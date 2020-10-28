<?php

namespace App\Admin\Controllers\Supplier;

use App\Models\shopSupplierList;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ListController extends Controller
{
    use HasResourceActions;

    /**
     * default page title
     *
     * @param string $pageModTitle
     */
    private static $pageModTitle = "供应商列表";

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
        $grid = new Grid(new shopSupplierList);

        $grid->id('编号');
        $grid->url('API地址');
        $grid->key('API密钥');
        $grid->balance('API余额');
        $grid->created_at('创建时间');
        $grid->updated_at('上次修改时间');

        $grid->actions(function ($actions) {

            $actions->prepend('<a href="'.route('Admin.API.BalanceUpdate',$actions->getKey()).'"><i class="fa fa-money"></i></a>');

        });

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
        $show = new Show(shopSupplierList::findOrFail($id));

        $show->id('编号');
        $show->url('API地址');
        $show->key('API密钥');
        $show->balance('API余额');
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
        $form = new Form(new shopSupplierList);

        $form->url('url', 'API地址');
        $form->text('key', 'API密钥');
        $form->currency('balance', 'API余额')->default(0.00);

        return $form;
    }
}
