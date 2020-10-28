<?php

namespace App\Admin\Controllers\Supplier;

use App\Models\shopSupplierData;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class DataController extends Controller
{
    use HasResourceActions;

    /**
     * default page title
     *
     * @param string $pageModTitle
     */
    private static $pageModTitle = "产品数据";

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
        $grid = new Grid(new shopSupplierData);

        $grid->id('编号');
        $grid->title('数据标题');
        $grid->data('数据')->display(function ($data) {
            $data = json_decode($data, true);
            $data = array_except($data, ['_pjax', '_token', '_method', '_previous_']);
            if (empty($data)) {
                return '<code>{}</code>';
            }

            return '<pre>'.json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>';
        });;
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
        $show = new Show(shopSupplierData::findOrFail($id));

        $show->id('编号');
        $show->title('数据标题');
        $show->data('数据内容');
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
        $form = new Form(new shopSupplierData);

        $form->text('title', '数据标题');
        $form->SupplierData('data', '数据内容');

        return $form;
    }
}
