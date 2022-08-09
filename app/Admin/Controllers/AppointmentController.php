<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

use App\Admin\Extensions\AppointmentExpoter;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;


class AppointmentController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    // protected $title = 'Appointments';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Appointments')
            ->description('List')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Appointments')
            ->description('Show')
            ->body(
                // $this->detail($id)
                view('admin.appointment.details')
	            ->with('appointment', Appointment::with('department','doctor')->find($id))
            );
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Appointments')
            ->description('Edit')
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
            ->header('Appointments')
            ->description('Create')
            ->body($this->form());
    }

    public function update(Request $request,$id)
    {
        Appointment::updateOrCreate(['id' => $id],[
            'name'  => $request->name,
            'last_name'  => $request->last_name,
            'phone_number'  => $request->phone_number,
            'email'  => $request->email,
            'civil_id'  => $request->civil_id,
            'preffered_date'  => $request->preffered_date,
            'message'  => $request->message,
            'department_id'  => $request->department_id,
            'doctor_id'  => $request->doctor_id,
            'status'  => $request->status
        ]);

        return redirect()->route('admin_appointments.index');
    }
    public function store(Request $request)
    {
        Appointment::updateOrCreate([
            'name'  => $request->name,
            'last_name'  => $request->last_name,
            'phone_number'  => $request->phone_number,
            'email'  => $request->email,
            'civil_id'  => $request->civil_id,
            'preffered_date'  => $request->preffered_date,
            'message'  => $request->message,
            'department_id'  => $request->department_id,
            'doctor_id'  => $request->doctor_id,
            'status'  => $request->status
        ]);

        return redirect()->route('admin_appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appointment::whereId($id)->delete();
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Appointment());

        $grid->model()->orderBy('id', 'desc');

        // $grid->disableExport();
        if (Admin::user()->inRoles(['appointments.view'])) {
            $grid->disableCreateButton();
        }

        $grid->actions(function ($actions){
            if (Admin::user()->inRoles(['appointments.view'])) {
                $actions->disableEdit();
            }
            $actions->disableView();
            $actions->append(
                '<a href="'.$actions->getResource().'/'.$actions->getKey().'" target="_blank" class="grid-row-edit" style="margin-right:4px">
                <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>'
            );
            if (Admin::user()->inRoles(['appointments.view', 'appointments.edit'])) {
                $actions->disableDelete();
            }
        });

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('preffered_date')->datetime();
            $filter->in('department_id', 'Department')->select(department::all()->pluck('name', 'id'));
            $filter->in('doctor_id', 'Doctor')->select(doctor::all()->pluck('name', 'id'));
            $filter->in('status', 'Status')->select([Appointment::PENDING_STATUS => 'Pending', Appointment::CONTACTED_STATUS => 'Contacted', Appointment::COMPLETED_STATUS => 'Completed', Appointment::CANCELED_STATUS => 'Canceled']);
        });

        $grid->exporter(new AppointmentExpoter());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('last_name', 'Last Name');
        $grid->column('phone_number', __('Phone number'));
        $grid->column('preffered_date', __('Preffered date'));
        $grid->column('birth_day', 'Birth Day');
        $grid->column('department.name_en', __('Department'));
        $grid->column('doctor.name_en', __('Doctor'));

        $grid->column('status', __('Status'))->display(function ($field) {
            switch ($field) {
				case Appointment::PENDING_STATUS:
					return '<span class="badge badge-primary">Pending</span>';
				case Appointment::CONTACTED_STATUS:
					return '<span class="badge badge-primary">Contacted</span>';
				case Appointment::COMPLETED_STATUS:
					return '<span class="badge badge-primary">Completed</span>';
				case Appointment::CANCELED_STATUS:
					return '<span class="badge badge-primary">Canceled</span>';
			}
			return '';
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
        $show = new Show(Appointment::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
            if (Admin::user()->inRoles(['appointments.view'])) {
                $tools->disableEdit();
            }
            if (Admin::user()->inRoles(['appointments.view', 'appointments.edit'])) {
                $tools->disableDelete();
            }
        });

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('last_name', 'last Name');
        $show->field('phone_number', __('Phone number'));
        $show->field('whatsapp_number', 'Whatsapp Number');

        $show->field('email', __('Email'));
        $show->field('civil_id', __('Civil id'));
        $show->field('preffered_date', __('Preferred date'));
        $show->field('message', __('Message'));
        $show->field('doctor.name_en', __('Doctor'));
        $show->field('department.name_en', __('Department'));
        $show->field('his_ref', __('His Ref'));
        $show->field('appointment_time', __('appointment time'));
        $show->field('end_time', __('end time'));
        $show->field('passport_no', __('passport no'));
        $show->field('age', __('Age'));
        $show->field('dob', __('Dob'));
        $show->field('gender', __('Gender'));
        $show->field('remarks','Remarks');
        $show->field('charge_price', __('Charge price'));
        $show->field('payment_type', __('Payment type'));
        $show->field('reference_number', __('Reference number'));
        $show->field('payment_status_id', __('Payment status id'));

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
        $form = new Form(new Appointment());
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

            // disable `Continue editing` checkbox
            $footer->disableEditingCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();
        });

        $form->text('name', __('Name'))->required();
        $form->text('last_name', 'Last Name')->required();
        $form->mobile('phone_number', __('Phone number'))->options(['mask' => '99 999 999'])->required();
        $form->email('email', __('Email'));
        $form->text('civil_id', __('Civil id'));
        $form->datetime('preffered_date', __('Preferred date'));
        $form->textarea('message', __('Message'));
        $form->select('department_id', __('Department'))->options(Department::where('status', 1)->pluck('name_en', 'id'))->required();
        $form->select('doctor_id', __('Doctor'))->options(Doctor::where('status', 1)->pluck('name_en', 'id'))->required();
        $form->radio('status', 'State')->options(['0' => 'Pending', '1' => 'Contacted', '2' => 'Completed', '3' => 'Canceled'])->default('0');

        return $form;
    }
}
