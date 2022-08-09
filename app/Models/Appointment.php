<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    const PENDING_STATUS = 0;
    const CONTACTED_STATUS = 1;
    const COMPLETED_STATUS = 2;
    const CANCELED_STATUS = 3;

    protected $appends = ['department_name', 'doctor_name', 'status_name','reserved_time'];

    protected $fillable = ['remarks','whatsapp_number',
        'name','last_name', 'birth_day', 'phone_number', 'email', 'patient_id', 'civil_id', 'preffered_date', 'message',
        'status', 'department_id', 'doctor_id','his_ref','appointment_time','end_time','passport_no','age','dob','gender','charge_price'
        ,'payment_type','reference_number','payment_status_id','reserved_time','user_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getDepartmentNameAttribute()
    {
        return @$this->department['name_en'];
    }
    public function getEndTimeAttribute()
    {
        return Carbon::parse(@$this->attributes['end_time'])->format('H:i');
    }

    public function getDoctorNameAttribute()
    {
        return @$this->doctor['name_en'];
    }

    public function getReservedTimeAttribute()
    {
        $now = Carbon::now();
        $to = $this->created_at;
        $diff= $to->diff($now)->format('%i.%s');
        $remaing = $this->attributes['reserved_time'] - $diff;
      return $remaing;
    }
    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case "0":
                return 'Pending';
                break;
            case "1":
                return 'Contacted';
                break;
            case "2":
                return 'Completed';
                break;
            case "3":
                return 'Cancelled';
                break;
            default:
                return "no status";
                break;
        }
    }


}
