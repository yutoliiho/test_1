@component('mail::message')

|        |
|:-------------|
|Your order {{ $id }} has been paid。|
|注文 {{ $id }} が支払われました。|
|您的订单 {{ $id }} 已经支付。|
|您的訂單 {{ $id }} 已經支付。|

@component('mail::button', ['url' => config('app.url')])
Website / 网站
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent