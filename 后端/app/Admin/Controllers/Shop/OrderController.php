<?php

namespace App\Admin\Controllers\Shop;

use App\Models\shopOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * default page title
     *
     * @param string $pageModTitle
     */
    private static $pageModTitle = "商品订单";

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header(self::$pageModTitle)
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(self::$pageModTitle)
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(self::$pageModTitle)
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header(self::$pageModTitle)
            ->description('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new shopOrder);

        $grid->id('编号');
        $grid->orderId('订单号');
        $grid->pId('产品信息');
        $grid->count('购买数量');
        $grid->aPrice('购买单价');
        $grid->bPrice('购买总价');
        $grid->email('购买邮箱');
        $grid->payHas('是否支付');
        $grid->payName('支付平台');
        $grid->payOrder('支付ID');
        $grid->payTime('支付时间');
        $grid->created_at('创建时间');
        $grid->updated_at('上次修改时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(shopOrder::findOrFail($id));

        $show->id('编号');
        $show->orderId('订单号');
        $show->pId('产品信息');
        $show->count('购买数量');
        $show->aPrice('购买单价');
        $show->bPrice('购买总价');
        $show->email('购买邮箱');
        $show->payHas('是否支付');
        $show->payName('支付平台');
        $show->payOrder('支付ID');
        $show->payTime('支付时间');
        $show->created_at('创建时间');
        $show->updated_at('上次修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new shopOrder);

        $form->text('orderId', '订单号');
        $form->number('pId', '产品信息');
        $form->number('count', '购买数量');
        $form->decimal('aPrice', '购买单价');
        $form->decimal('bPrice', '购买总价');
        $form->email('email', '购买邮箱');
        $form->number('payHas', '是否支付');
        $form->text('payName', '支付平台');
        $form->text('payOrder', '支付ID');
        $form->datetime('payTime', '支付时间')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
