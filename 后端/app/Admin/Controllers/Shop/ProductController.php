<?php

namespace App\Admin\Controllers\Shop;

use App\Models\shopCategories;
use App\Models\shopProduct;
use App\Http\Controllers\Controller;
use App\Models\shopSupplierData;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends Controller
{
    use HasResourceActions;

    /**
     * default page title
     *
     * @param string $pageModTitle
     */
    private static $pageModTitle = "商品";

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
        $grid = new Grid(new shopProduct);

        $grid->id('编号');
        $grid->cid('分类')->display(function ($cid) {
            $nowTitle = shopCategories::where('id', $cid)->get(['parent_id', 'title'])[0]->toArray();
            $fatherTuitle = shopCategories::where('id', $nowTitle['parent_id'])->get(['title'])[0]->toArray()['title'];
            return $fatherTuitle . ' => ' . $nowTitle['title'];
        });;
        $grid->name('商品名');
        $grid->description('介绍')->title('Post');
        $grid->price('单价');

        $grid->data('产品数据')->display(function ($data){
            $html = '';
            for ($i=0;$i<count($data);$i++){
                $html .= "<span class='label label-info' style='margin-left: 4px'>".$data[$i]."</span>";
            }
            return $html;
        });

        $grid->isDisable('是否下架');
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
        $show = new Show(shopProduct::findOrFail($id));

        $show->id('编号');
        $show->cid('分类');
        $show->name('商品名');
        $show->description('介绍');
        $show->price('单价');
        $show->data('产品数据');
        $show->isDisable('是否下架');
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
        $form = new Form(new shopProduct);

        $form->select('cid', '分类')->options(shopCategories::selectOptions())->rules('required');
        $form->textarea('name', '商品名')->rules('required');
        $form->editor('description', '介绍')->rules('required');
        $form->currency('price', '单价')->symbol('$')->rules('required');
        $form->multipleSelect('data', '数据')->options(function () {
            $allData = shopSupplierData::all()->toArray();

            $tempData = array();
            foreach ($allData as $item) {
                $tempData[$item['id']] = '数据编号：' . $item['id'] . ' 名：' .$item['title'];
            }
            return $tempData;

        })->rules('required');

        $states = [
            'on'  => ['value' => 1, 'text' => '下架', 'color' => 'danger'],
            'off' => ['value' => 0, 'text' => '在销', 'color' => 'success'],
        ];
        $form->switch('isDisable', '是否下架')->states($states)->rules('required');


        return $form;
    }
}
