@component('mail::message')

@component('mail::panel')
    Some items in your order have already started processing...
@endcomponent
@component('mail::panel')
    あなたの注文の一部のアイテムはすでに処理を開始しています...
@endcomponent
@component('mail::panel')
    您的订单中部分商品已经开始处理...
@endcomponent
@component('mail::panel')
    您的訂單中部分商品已經開始處理...
@endcomponent

@component('mail::panel')
    @component('mail::table')
        | K | V |
        |:-------------|:-------------|
        | Col 2 is      | Centered      |
        | Col 3 is      | Right-Aligned |
    @endcomponent
@endcomponent

@component('mail::button', ['url' => config('app.url')])
    Website / 网站
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
