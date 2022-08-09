<?php

namespace App\Admin\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialty;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class DoctorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Doctors';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Doctor());

        $grid->model()->orderBy('id', 'desc');

        $grid->disableExport();
        $grid->disableFilter();
        if (Admin::user()->inRoles(['doctors.view'])) {
            $grid->disableCreateButton();
        }

        $grid->actions(function ($actions){
            if (Admin::user()->inRoles(['doctors.view'])) {
                $actions->disableEdit();
            }
            if (Admin::user()->inRoles(['doctors.view', 'doctors.edit'])) {
                $actions->disableDelete();
            }
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name_en', __('Name en'));
        $grid->column('name_ar', __('Name ar'));
        $grid->column('gender', __('Gender'))->using(['F' => 'Female', 'M' => 'Male']);
        $grid->column('working_date', __('Working date'));
        $grid->column('department.name_en', __('Department'));
        $grid->column('specialty.name_en', __('Specialty'));
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
        $grid->languages()->display(function ($languages) {

            $languages = array_map(function ($language) {
                return "<span class='label label-success'>{$language['language_code']}</span>";
            }, $languages);

            return join('&nbsp;', $languages);
        });
        $grid->column('created_at', __('Created at'));
        //$grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Doctor::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            if (Admin::user()->inRoles(['doctors.view'])) {
                $tools->disableEdit();
            }
            if (Admin::user()->inRoles(['doctors.view', 'doctors.edit'])) {
                $tools->disableDelete();
            }
        });

        $show->field('id', __('Id'));
        $show->field('prefix_en', __('Prefix English'));
        $show->field('prefix_ar', __('Prefix Arabic'));
        $show->field('name_en', __('Name English'));
        $show->field('name_ar', __('Name Arabic'));
        $show->field('slug', __('Slug'));
        $show->field('his_ref', 'His ref');

        $show->gender()->using(['F' => 'Female', 'M'=> 'Male']);
        $show->picture()->image();
        $show->field('brief_en', __('Brief English'));
        $show->field('brief_ar', __('Brief Arabic'));
        $show->field('working_date', __('Experience Start Date'));
        $show->field('experience_description_en', __('Experience Description English'));
        $show->field('experience_description_ar', __('Experience Description Arabic'));
        $show->field('education_en', __('Education English'));
        $show->field('education_ar', __('Education Arabic'));
        $show->field('achievments_en', __('Achievments English'));
        $show->field('achievments_ar', __('Achievments Arabic'));
        $show->field('certificates_en', __('Certificates English'));
        $show->field('certificates_ar', __('Certificates Arabic'));
        $show->department()->as(function ($department) {
            return $department->name_en;
        });
        $show->specialty()->as(function ($specialty) {
            return $specialty->name_en;
        });
        $show->status('Active')->using(['1' => 'yes', '0' => 'no']);
        $show->in_home('See in home page')->using(['1' => 'yes', '0' => 'no']);
        $show->show_appt('See in Appointment page')->using(['1' => 'yes', '0' => 'no']);
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
        $form = new Form(new Doctor());

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
            $form->text('prefix_en', __('Prefix English'))->required();
            $form->text('prefix_ar', __('Prefix Arabic'))->required();
            $form->text('name_en', __('Name English'))->required();
            $form->text('name_ar', __('Name Arabic'))->required();
            $form->text('his_ref', 'His Ref')->required();
            $form->text('slug')
            ->creationRules(['required', "unique:doctors"])
            ->updateRules(['required', "unique:doctors,slug,{{id}}"]);
            $form->radio('gender', __('Gender'))->options(['F' => 'Female', 'M'=> 'Male'])->default('M');
            $form->image('picture', __('Picture'))->move('uploads/doctors')->uniqueName();
            $form->ckeditor('brief_en', __('Brief English'))->required();
            $form->ckeditor('brief_ar', __('Brief Arabic'))->required();
            $form->date('working_date', __('Experience Start Date'))->format('YYYY');
            $form->ckeditor('experience_description_en', __('Experience Description English'));
            $form->ckeditor('experience_description_ar', __('Experience Description Arabic'));
            $form->ckeditor('education_en', __('Education English'))->required();
            $form->ckeditor('education_ar', __('Education Arabic'))->required();
            $form->ckeditor('achievments_en', __('Achievments English'));
            $form->ckeditor('achievments_ar', __('Achievments Arabic'));
            $form->ckeditor('certificates_en', __('Certificates English'));
            $form->ckeditor('certificates_ar', __('Certificates Arabic'));
            $form->select('department_id', __('Department'))->options(Department::where('status', 1)->pluck('name_en', 'id'))->required();
            $form->select('specialty_id', __('Specialty'))->options(Specialty::where('status', 1)->pluck('name_en', 'id'))->required();
            $form->multipleSelect('languages', __('Languages'))->options(Language::all()->pluck('name_en', 'id'))->required();
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
