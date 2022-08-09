<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class DepartmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Departments';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Department());

        $grid->model()->orderBy('id', 'desc');

        $grid->disableExport();
        $grid->disableFilter();
        if (Admin::user()->inRoles(['departments.view'])) {
            $grid->disableCreateButton();
        }

        $grid->actions(function ($actions){
            if (Admin::user()->inRoles(['departments.view'])) {
                $actions->disableEdit();
            }
            if (Admin::user()->inRoles(['departments.view', 'departments.edit'])) {
                $actions->disableDelete();
            }
        });

        $grid->id('ID')->sortable();
        $grid->name_en('name_en');
        $grid->name_ar('name_ar');
        $grid->phone('phone');

        $grid->column('status')->display(function () {
            if ($this->status == 0) {
                return "<span style='color: red;'>not active</span>";
            } else {
                return "<span style='color: #00a65a	;'>active</span>";
            }
        });
        $grid->column('in_home', __('Home'))->display(function () {
            if ($this->in_home == 0) {
                return "no";
            } else {
                return "yes";
            }
        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Department::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            if (Admin::user()->inRoles(['departments.view'])) {
                $tools->disableEdit();
            }
            if (Admin::user()->inRoles(['departments.view', 'departments.edit'])) {
                $tools->disableDelete();
            }
        });

        $show->field('id', __('Id'));
        $show->field('name_en', __('Name English'));
        $show->field('name_ar', __('Name Arabic'));
        $show->field('slug', __('Slug'));
        $show->field('his_ref', 'His ref');
        $show->image()->image();
        $show->field('short_description_en', 'Short Description English');
        $show->field('short_description_ar', 'Short Description Arabic');
        $show->field('description_en', 'Description English');
        $show->field('description_ar', 'Description Arabic');
        $show->desc_image_en('Image Description English')->image();
        $show->desc_image_ar('Image Description Arabic')->image();
        $show->desc_video_en('Video Description English(.mp4)')->file();
        $show->desc_video_ar('Video Description Arabic(.mp4)')->file();
        $show->field('phone', 'Phone');
        $show->status('Active')->using(['1' => 'yes', '0' => 'no']);
        $show->in_home('See in home page')->using(['1' => 'yes', '0' => 'no']);
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
        $form = new Form(new Department());

        $form->tools(function (Form\Tools $tools) {
            // Disable `Veiw` btn.
            $tools->disableView();
            // Disable `Delete` btn.
            $tools->disableDelete();
        });

        $form->footer(function ($footer) {
            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable reset btn
            $footer->disableReset();
        });

        $form->tab('General', function ($form) {
            $form->text('name_en', 'Name English')->required();
            $form->text('name_ar', 'Name Arabic')->required();
            $form->text('his_ref', 'His Ref')->required();
            $form->text('slug')
            ->creationRules(['required', "unique:departments"])
            ->updateRules(['required', "unique:departments,slug,{{id}}"]);
            $form->image('image', 'Image')->move('uploads/departments')->uniqueName()->required();
            $form->textarea('short_description_en', 'Short Description English')->required();
            $form->textarea('short_description_ar', 'Short Description Arabic')->required();
            $form->ckeditor('description_en', 'Description English')->required();
            $form->ckeditor('description_ar', 'Description Arabic')->required();
            $form->image('desc_image_en', __('Image Description English'))->removable()->move('uploads/departments')->uniqueName();
            $form->image('desc_image_ar', __('Image Description Arabic'))->removable()->move('uploads/departments')->uniqueName();
            $form->file('desc_video_en', __('Video Description English(.mp4)'))->removable()->move('uploads/departments')->rules('mimetypes:video/mp4')->uniqueName();
            $form->file('desc_video_ar', __('Video Description Arabic(.mp4)'))->removable()->move('uploads/departments')->rules('mimetypes:video/mp4')->uniqueName();
            $form->text('phone', 'Phone')->required();
            $form->radio('status', 'Active')->options(['1' => 'yes', '0' => 'no'])->default('1');
            $form->radio('in_home', 'See in home page')->options(['1' => 'yes', '0' => 'no'])->default('0');
            $form->radio('show_appt', 'See in appointment page')->options(['1' => 'yes', '0' => 'no'])->default('0');

        })->tab('Search Engine Optimization', function ($form) {
            $form->text('meta_title_en', __('Meta Title English'));
            $form->text('meta_title_ar', __('Meta Title Arabic'));
            $form->textarea('meta_keywords_en', __('Meta Keywords English'));
            $form->textarea('meta_keywords_ar', __('Meta Keywords Arabic'));
            $form->textarea('meta_description_en', __('Meta Description English'));
            $form->textarea('meta_description_ar', __('Meta Description Arabic'));
        });

        return $form;
    }
}
