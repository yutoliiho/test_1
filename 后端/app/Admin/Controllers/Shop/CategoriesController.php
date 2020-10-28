<?php

namespace App\Admin\Controllers\Shop;

use App\Models\shopCategories;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;

class CategoriesController extends Controller
{
    use HasResourceActions;

    private static $pageModTitle = "商品分类";

    public function index(Content $content)
    {
        $content
            ->header(self::$pageModTitle)
            ->description('列表');
        $content->row(function (Row $row) {
            $row->column(6, $this->tree());
            $row->column(6, $this->form());
        });

        return $content;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header(self::$pageModTitle)
            ->description('编辑')
            ->body($this->editForm()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header(self::$pageModTitle)
            ->description('创建')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new shopCategories);

        $grid->id('编号');
        $grid->parent_id('父分类ID');
        $grid->order('排序');
        $grid->title('分类名');
        $grid->image('分类图片');
        $grid->description('分类描述');
        $grid->created_at('创建时间');
        $grid->updated_at('上次修改时间');

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new shopCategories);

        $form->setAction(admin_base_path('shop/categories'));

        $form->select('parent_id', '父分类')->options(ShopCategories::selectOptions())->rules('required');
        $form->slider('order', '排序')->options(['max' => 1000, 'min' => 1, 'step' => 1, 'postfix' => ''])->help('数值越小，显示越前，数值越大，显示越后。只在同一父分类有效');
        $form->text('title', '名称');
        $form->image('image', '分类图片');
        $form->text('description', '分类描述');


        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableList();
            $tools->disableView();
        });
        $form->disableViewCheck();
        $form->disableEditingCheck();

        $form->footer(function ($footer) {
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }

    protected function editForm()
    {
        $form = new Form(new shopCategories);

        $form->select('parent_id', '父分类')->options(ShopCategories::selectOptions())->rules('required');
        $form->slider('order', '排序')->options(['max' => 1000, 'min' => 0, 'step' => 10, 'postfix' => ''])->help('数值越小，显示越前，数值越大，显示越后。只在同一父分类有效');
        $form->text('title', '名称');
        $form->image('image', '分类图片');
        $form->text('description', '分类描述');


        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->disableViewCheck();
        $form->disableEditingCheck();

        $form->footer(function ($footer) {
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }

    protected function tree()
    {
        return shopCategories::tree(function (Tree $tree) {
            $tree->disableCreate();
            $tree->branch(function ($branch) {
                $src = config('filesystems.disks.admin.url') . '/' . $branch['image'];
                $logo = "<img src='$src' style='max-width:25px;max-height:25px' class='img' alt='logo'/>";
                $id = strlen($branch['id']) == 1 ? '0'.$branch['id'] : $branch['id'];
                return "{$id} - {$logo}  [ {$branch['title']} ]";
            });
        });
    }
}
