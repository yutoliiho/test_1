<?php
/**
 *  +----------------------------------------------------------------------
 *  | 草帽支付系统 [ WE CAN DO IT JUST THINK ]
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2018 http://www.iredcap.cn All rights reserved.
 *  +----------------------------------------------------------------------
 *  | Licensed ( https://www.apache.org/licenses/LICENSE-2.0 )
 *  +----------------------------------------------------------------------
 *  | Author: Brian Waring <BrianWaring98@gmail.com>
 *  +----------------------------------------------------------------------
 */
namespace IredCap\Pay\Util;

use IredCap\Pay\Constant\HttpHeader;
use IredCap\Pay\Http\HttpRequest;
use IredCap\Pay\Exception\InvalidResponseException;

class SignUtil
{
    /**
     * 获取当前时间的毫秒数
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @return float
     */
    public static function getMicroTime(){
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }

    /**
     * 生成唯一id[32位]
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param string $namespace
     *
     * @return string
     */
    public static function createUniqid($namespace = ''){
        static $uniqid = '';
        $uid = uniqid("", true);
        $data = $namespace;
        $data .= isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : "";
        $data .= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $data .= isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : "";
        $data .= isset($_SERVER['LOCAL_PORT']) ? $_SERVER['LOCAL_PORT'] : "";
        $data .= isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
        $data .= isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : "";
        $hash = strtoupper(hash('ripemd128', $uid . $uniqid . md5($data)));
        $uniqid = substr($hash,  0,  8) .
            substr($hash,  8,  4) .
            substr($hash, 12,  4) .
            substr($hash, 16,  4) .
            substr($hash, 20, 12);
        return $uniqid;
    }

    /**
     * 商户签名数据
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $headers
     * @param $uri
     * @param null $body_data
     *
     * @return string
     */
    public static function to_sign_data($headers, $uri, $body_data=null){
        $_cur_uri = $_cur_uri_query_string = stristr($uri,'/pay/');
        $_query_string = $_query_string_index = strpos($_cur_uri_query_string,'?');
        if (!empty($_query_string_index)){
            $_cur_uri = substr($_cur_uri_query_string,0,$_query_string_index);//uri
            $_query_string = substr($_cur_uri_query_string,$_query_string_index+1);//query string
        }
        $_to_sign_data = utf8_encode($_cur_uri)
            ."\n".utf8_encode($_query_string)
            ."\n".utf8_encode($headers[HttpHeader::X_CA_NONCE_STR])
            ."\n".utf8_encode($headers[HttpHeader::X_CA_TIMESTAMP])
            ."\n".utf8_encode(json_encode($body_data));

        return self::sign(base64_encode($_to_sign_data));
    }

    /**
     * 平台数据验签
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $res_header
     * @param $body_data
     *
     * @return bool
     * @throws InvalidResponseException
     */
    public static function to_verify_data($res_header, $body_data)
    {
        $body_data = json_decode($body_data,true);

        if (is_array($res_header)){
            $_res_nonce = $res_header[HttpHeader::X_CA_NONCE_STR];
            $_res_timestamp = $res_header[HttpHeader::X_CA_TIMESTAMP];
            $_res_sign = $res_header[HttpHeader::X_CA_SIGNATURE];
        }else{
            //分割返回头
            $res_header_array = explode("\r\n", $res_header);

            $_res_nonce = '';
            $_res_timestamp = '';
            $_res_sign = '';

            //取出签名参数
            foreach ($res_header_array as $loop) {
                if (strpos($loop, HttpHeader::X_CA_NONCE_STR) !== false) {
                    $_res_nonce = trim(substr($loop, strlen(HttpHeader::X_CA_NONCE_STR) + 1));
                } elseif (strpos($loop, HttpHeader::X_CA_TIMESTAMP) !== false) {
                    $_res_timestamp = trim(substr($loop, strlen(HttpHeader::X_CA_TIMESTAMP) + 1));
                } elseif (strpos($loop, HttpHeader::X_CA_SIGNATURE) !== false) {
                    $_res_sign = trim(substr($loop, strlen(HttpHeader::X_CA_SIGNATURE) + 1));
                }
            }
        }
        //拼装验签参数
        $_to_verify_data = utf8_encode($_res_nonce)
            ."\n".utf8_encode($_res_timestamp)
            ."\n".utf8_encode(json_encode($body_data['charge']));

        //验签
        $verify_result = self::verify(base64_encode($_to_verify_data), $_res_sign);
        if(empty($verify_result) || intval($verify_result)!=1){
            throw new InvalidResponseException("Invalid Response.[Response Data And Sign Verify Failure.]");
        }
        
        return true;
    }

    /**
     * 加密请求
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $data
     *
     * @return string
     */
    public static function to_encrypt_data($data){
        return self::pikeyEncrypt(json_encode($data));
    }

    /**
     * 响应解密
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $data
     *
     * @return string
     */
    public static function to_decrypt_data($data){
        return self::pubkeyDecrypt($data);
    }

    /**
     * 商户私钥数据签名
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $data
     *
     * @return string
     */
    private static function sign($data)
    {
        //读取私钥文件
        $priKey = self::getPrivateKey(HttpRequest::getPrivateKey());
        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);
        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $res);
        //释放资源
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * 平台公钥验签数据
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $data
     * @param $sign
     *
     * @return bool
     */
    private static function verify($data, $sign)  {

        //读取公钥文件
        $pubKey = self::getPublicKey(HttpRequest::getPayPublicKey());
        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        //释放资源
        openssl_free_key($res);
        //返回资源是否成功
        return $result;

    }

    /**
     * 商户数据私钥加密 【向平台发送数据】
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $source_data
     *
     * @return string
     */
    private static function pikeyEncrypt($source_data) {
        $data = "";
        $dataArray = str_split($source_data, 117);
        foreach ($dataArray as $value) {
            $encryptedTemp = "";
            openssl_private_encrypt($value,$encryptedTemp, self::getPrivateKey(HttpRequest::getPrivateKey()));
            $data .= base64_encode($encryptedTemp);
        }
        return $data;
    }

    /**
     * 平台数据公钥解密 【接收平台数据返回 -- 都是使用商户公钥】
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $eccryptData
     *
     * @return string
     */
    private static function pubkeyDecrypt($eccryptData) {
        $decrypted = "";
        $decodeStr = base64_decode($eccryptData);
        $enArray = str_split($decodeStr, 256);

        foreach ($enArray as $va) {
            openssl_public_decrypt($va,$decryptedTemp, self::getPublicKey(HttpRequest::getPublicKey()));
            $decrypted .= $decryptedTemp;
        }
        return $decrypted;
    }

    /**
     *
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $certificate
     *
     * @return string
     */
    private  static function getPublicKey($certificate)
    {
        $publicKeyString = "-----BEGIN PUBLIC KEY-----".PHP_EOL
            . chunk_split($certificate,64,"\n")
            . "-----END PUBLIC KEY-----".PHP_EOL;
        return $publicKeyString;
    }

    /**
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $certificate
     *
     * @return string
     */
    private static function getPrivateKey($certificate)
    {
        $privateKeyString = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($certificate, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        return $privateKeyString;
    }
}