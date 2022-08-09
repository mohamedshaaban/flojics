<?php

namespace App\Admin\Controllers;

use App\Models\Menu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class MenuController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Menus';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Menu());

        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableCreateButton();
        $grid->actions(function ($actions){
            if (Admin::user()->inRoles(['menus.view'])) {
                $actions->disableEdit();
            }
            $actions->disableDelete();
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name_en', __('Name en'));
        $grid->column('name_ar', __('Name ar'));
        $grid->column('in_why_wara')->display(function () {
            if ($this->in_why_wara == 0) {
                return "<span style='color: red;'>no</span>";
            } else {
                return "<span style='color: #00a65a	;'>yes</span>";
            }
        });
        $grid->column('in_footer')->display(function () {
            if ($this->in_footer == 0) {
                return "<span style='color: red;'>no</span>";
            } else {
                return "<span style='color: #00a65a	;'>yes</span>";
            }
        });
        $grid->column('in_header')->display(function () {
            if ($this->in_header == 0) {
                return "<span style='color: red;'>no</span>";
            } else {
                return "<span style='color: #00a65a	;'>yes</span>";
            }
        });
        $grid->column('order', __('Order'));
        $grid->column('status')->display(function () {
            if ($this->status == 0) {
                return "<span style='color: red;'>not active</span>";
            } else {
                return "<span style='color: #00a65a	;'>active</span>";
            }
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Menu::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            if (Admin::user()->inRoles(['menus.view'])) {
                $tools->disableEdit();
            }
            $tools->disableDelete();
        });

        $show->field('id', __('Id'));
        $show->field('name_en', __('Name English'));
        $show->field('name_ar', __('Name Arabic'));
        $show->in_why_wara('Show in why wara')->using(['1' => 'yes', '0' => 'no']);
        $show->in_header('Show in header')->using(['1' => 'yes', '0' => 'no']);
        $show->in_footer('Show in footer')->using(['1' => 'yes', '0' => 'no']);
        $show->field('order', __('Order'));
        $show->status('Active')->using(['1' => 'yes', '0' => 'no']);
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Menu());

        $form->tools(function (Form\Tools $tools) {
            // Disable `Veiw` btn.
            $tools->disableView();
            // Disable `Delete` btn.
            $tools->disableDelete();
        });

        $form->footer(function ($footer) {
            // disable `View` checkbox
            $footer->disableViewCheck();
            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();
            // disable reset btn
            $footer->disableReset();
        });

        $form->text('name_en', __('Name English'))->required();
        $form->text('name_ar', __('Name Arabic'))->required();
        $form->text('url', __('URL'))->required();
        $form->text('word_activ', __('Word active'))->required();
        $form->radio('in_why_wara', 'Show in why wara')->options(['1' => 'yes', '0' => 'no'])->default('0');
        $form->radio('in_header', 'Show in header')->options(['1' => 'yes', '0' => 'no'])->default('0');
        $form->radio('in_footer', 'Show in footer')->options(['1' => 'yes', '0' => 'no'])->default('0');
        $form->number('order', __('Order'))->default(0);
        $form->radio('status', 'Active')->options(['1' => 'yes', '0' => 'no'])->default('1');

        return $form;
    }
}
