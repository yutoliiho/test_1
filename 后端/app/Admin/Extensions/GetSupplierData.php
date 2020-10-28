<?php
/**
 * Created by PhpStorm.
 * User: rnbug
 * Date: 2018/11/29
 * Time: 17:54
 */

namespace App\Admin\Extensions;

use App\Models\shopSupplierDataType;
use App\Models\shopSupplierList;
use Encore\Admin\Form\Field;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Box;


class GetSupplierData extends Field
{
    protected $view = "admin.supplier";

    protected static $css = [
    ];

    protected static $js = [
    ];

    private function getSupplier()
    {
        $data = shopSupplierList::all(['id', 'url', 'key'])->toArray();
        $reData = Array();
        foreach ($data as $item) {
            array_push($reData, [
                "id" => $item['id'],
                "text" => str_replace(strrchr(parse_url($item['url'])['host'], "."), "", parse_url($item['url'])['host']),
                "url" => $item['url'],
                "key" => $item['key'],
            ]);
        }
        return $reData;
    }

    protected function themesSupport()
    {
        $directories = shopSupplierDataType::all(['id','name'])->toArray();
        $directoriesTemp = [];
        for ($i = 0; $i < count($directories); $i++) {
            $v= $directories[$i]['id'].",".$directories[$i]['name'];
            $directoriesTemp[$v] = $v;
        }
        return $directoriesTemp;
    }

    protected function mkFrom($name, $isModel)
    {

        $states = [
            'on' => ['value' => 1, 'text' => '系统', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '用户', 'color' => 'success'],
        ];

        $form = new Form();
        $form->hasHtmlForm(true);
        $form->text('name')->default($name)->help('不需要修改此处的值');
        $form->text('value')->default("")->help('默认值');
        if ($isModel) {
            $form->switch('private')->states($states)->default(0)->help('是否需要用户输入');
        } else {
            $form->switch('private')->states($states)->default(1)->help('是否需要用户输入');
        }
        $form->select('model')->options($this->themesSupport())->help('private为推荐设置,开启时候,此选项的值不会生效!');
        $form->text('help', '提示信息')->help('private为用户的时候才有用');


        $form->disableSubmit();
        $form->disableReset();
        $box = new Box($name, $form);
        $box->solid();
        $box->collapsable();
        return $box->render();
    }

    /**/
    protected function packageForm()
    {
        return $this->mkFrom("link", true);
    }

    protected function defaultForm()
    {
        return $this->mkFrom("link", true) . $this->mkFrom("quantity", false);
    }

    protected function subscriptionsForm()
    {
        return $this->mkFrom("username", true)
            . $this->mkFrom("min", false)
            . $this->mkFrom("max", false)
            . $this->mkFrom("posts", false)
            . $this->mkFrom("delay", false);
    }

    protected function commentLikesForm()
    {
        return $this->mkFrom("link", true)
            . $this->mkFrom("quantity", true)
            . $this->mkFrom("username", true);
    }

    protected function customCommentsForm()
    {
        return $this->mkFrom("link", true)
            . $this->mkFrom("comments", true);
    }

    protected function customCommentsPackageForm()
    {
        return $this->mkFrom("link", true)
            . $this->mkFrom("comments", true);
    }

    protected function mentionsForm()
    {
        return $this->mkFrom("link", true)
            . $this->mkFrom("quantity", false)
            . $this->mkFrom("usernames", true);
    }

    protected function mentionsCustomListForm()
    {
        return $this->mkFrom("link", true)
            . $this->mkFrom("usernames", true);
    }

    protected function mentionsUserFollowers()
    {
        return $this->mkFrom("link", true)
            . $this->mkFrom("username", true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {

        $name = $this->formatName($this->column);

        $tab = new Tab();
        $tab->add('Default', $this->defaultForm());
        $tab->add('Package', $this->packageForm());
        $tab->add('Subscriptions', $this->subscriptionsForm());
        $tab->add('Comment Likes', $this->commentLikesForm());
        $tab->add('Custom Comments', $this->customCommentsForm());
        $tab->add('Custom Comments Package', $this->customCommentsPackageForm());
        $tab->add('Mentions', $this->mentionsForm());
        $tab->add('Mentions Custom List', $this->mentionsCustomListForm());
        $tab->add('Mentions User Followers', $this->mentionsUserFollowers());

        $this->script = <<<JS
        
        console.log("****供应商数据模块加载开始");
        let formInput = $('input[name=$name]');
        let serverData = null,nowServerSelect = null,nowDataSelect = null,dataSelect = $(".supDATASelect"),nowData=null;
        let Supcontainer = document.getElementById("supLoadData");
        let Supoptions = {"mode":"view"};
        let Supeditor = new JSONEditor(Supcontainer, Supoptions);
        let supEND = {
            'user':[],
        };
        
        $(".helptext").parent().hide();
        const helpInfo = function(text){
            $(".helptext").text(text);
            $(".helptext").parent().show();
        };
        
        $(".supSelect").select2({"allowClear":true,"placeholder":{"id":"","text":"请选择供应商"}})
        .on("select2:select",function(e){
            nowServerSelect = e.params.data.id;
            console.log("供应商编号:",nowServerSelect);
            $.ajax({ 
                type : "GET", 
                url : "/admin/api/supplier/list/service/data/"+nowServerSelect,
                beforeSend:function(){
                    helpInfo("加载供应商数据中...");
                },
                success : function(result) {
                    console.log("已请求到供应商数据",result);
                    if(result['status_code'] === 200){
                        serverData = result['data'];
                        $(dataSelect).empty();
                        helpInfo("加载完成,处理供应商数据中...");
                        serverData.forEach(function(e){
                            var option = $('\<option\>\<\/option\>');
                            $(dataSelect).append($(option).val(e.service).text('['+e.service+'] '+e.name));
                        });
                        helpInfo("处理成功,请下一步操作...");
                        $(".datahelp").hide();
                        $("#dataSure").removeClass('disabled');
                        $(dataSelect).select2({"allowClear":true,"placeholder":{"id":"","text":"请选择供应商数据"}})
                        .on("select2:select",function(e){
                            nowDataSelect = e.params.data.id;
                            nowData = serverData.find((element) => (element.service === e.params.data.id));
                            console.log("已选择数据,",nowData);
                            dText = nowData['type'];
                            $("#navbs .nav-tabs li").each(function() {
                                if($(this).text() === dText){
                                    $(this).find('a').click();
                                }
                            });
                            bindValue();
                        });
                    }else{
                        helpInfo("加载失败,"+result['message']);
                    }
                },
                error:function() {
                    helpInfo("加载供应商数据失败,请重试,多次未果请联系管理员...");
                }
            });
        });
        
        function bindValue() {
            const Supjson = nowData;
            Supeditor.set(Supjson);
        }
        
        $("#dataSure").addClass('disabled').bind('click',function() {
            console.log("确定数据按钮触发");
            nowActiveNavbs();
            supEND.system = nowData;
            supEND.supID = $(".supSelect").val();
            $('input[name=$name]').val(JSON.stringify(supEND));
            console.log("****结束");
            console.log(supEND,JSON.stringify(supEND));
        });
        
        function nowActiveNavbs() {
            $("#navbs .nav-tabs li").each(function() {
                if ($(this).prop("className") === "active") {
                    const navbsContentID = $(this).find('a').attr('href');
                    console.log(navbsContentID);
                    $(""+navbsContentID).find('.box').each(function() {
                        console.log("==================内容开始=====");
                        findBlockInnerData(this);
                        console.log("==================内容结束=====");
                    })
                }
            });
        }
        
        function findBlockInnerData(obj) {
            let tempSup = {};
            $(obj).find('input[name]').each(function() {
                
                tempSup[$(this).prop("name")] = $(this).val().length < 1?"default":$(this).val();
                console.log($(this).val(),$(this).prop("name"));
            });
            supEND.user.push(tempSup);
        }
        
        $('button[type="submit"]').click(function() {
            $('div[data-name=$name]').find("input").each(function() {
                $(this).prop('disabled','disabled');
            });
            $('div[data-name=$name]').find("select").each(function() {
                $(this).prop('disabled','disabled');
            });
        })

JS;
        return parent::render()->with(["supData" => $this->getSupplier(), "tabObj" => $tab->render()]);
    }

}