<?php

namespace App\Admin\Controllers\Supplier;

use App\Models\shopSupplierOrder;
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
    private static $pageModTitle = "供应商订单";

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
        $grid = new Grid(new shopSupplierOrder);

        $grid->id('编号');
        $grid->pID('产品ID');
        $grid->orderID('订单ID');
        $grid->dataID('订单数据ID');
        $grid->data('执行数据');
        $grid->supID('执行数据供应商');
        $grid->supOrderID('供应商订单');
        $grid->supOrderStatus('供应商状态');
        $grid->startEmail('订单创建邮件');
        $grid->endEmail('订单完成邮件');
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
        $show = new Show(shopSupplierOrder::findOrFail($id));

        $show->id('编号');
        $show->pID('产品ID');
        $show->orderID('订单ID');
        $show->dataID('订单数据ID');
        $show->data('执行数据');
        $show->supID('执行数据供应商');
        $show->supOrderID('供应商订单');
        $show->supOrderStatus('供应商状态');
        $show->startEmail('订单创建邮件');
        $show->endEmail('订单完成邮件');
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
        $form = new Form(new shopSupplierOrder);

        $form->number('orderID', '订单ID');
        $form->number('dataID', '订单数据ID');
        $form->text('data', '执行数据');
        $form->number('supID', '执行数据供应商');
        $form->text('supOrderID', '供应商订单');
        $form->text('supOrderStatus', '供应商状态');
        $form->number('startEmail', '订单创建邮件');
        $form->number('endEmail', '订单完成邮件');

        return $form;
    }
}
