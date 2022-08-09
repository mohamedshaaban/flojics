<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Mail\AppointmentMail;
use Mail;

use DateTime;

class AppointmentController extends Controller
{
    public function appointments(Request  $request)
    {
        $appts = Appointment::where('user_id',Auth::id())->get();
         return ['appts'=>$appts];

    }
    public function delappointments(Request $request)
    {
         $app = Appointment::find($request->id);
        $app->remarks =$request->remarks;
$app->save();
        $bookRes = cancelAppointmentHis($app->id);
        $bookRes = json_decode($bookRes);

         if($bookRes->status==200)
        {
            $app->status = Appointment::CANCELED_STATUS;
            $app->save();
        }
        $appts = Appointment::where('user_id',Auth::id())->get();
        return ['appts'=>$appts];
    }
    public function getConfirmation(Request $request)
    {

        return Appointment::find($request->id);
    }

    public function deleteAppointment(Request $request)
    {
        $appointment = Appointment::where('id',$request->book_id)->delete();
        return 'true';
    }

    public function reserveBookingSlot(Request  $request)
    {
        $doctor = Doctor::find($request->doctor_id);
        $department = Department::find($request->department_id);
        $seleced_date = json_decode($request->seleced_date);
        $time = strtotime($seleced_date->available_slot);
        $time = date('Hi', $time);

        $cURLConnection = curl_init();
        $uqery = ('{"appointment_id":"0","department_id":"'.$department->his_ref.'","doctor_id":"'.$doctor->his_ref.'","appointment_time":"'.$time.'","appt_duration":"'.$seleced_date->appt_duration.'","appointment_date":"'.$seleced_date->appointment_date.'","pass_code":"'.config('app.BOOK_APPOINTMENT_PASSCODE').'","status":"Reserved"}');
         curl_setopt($cURLConnection, CURLOPT_URL,  config('app.BOOK_APPOINTMENT_LINK').'reserveBookingSlot.shms?requestJson='.$uqery);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $bookRes = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $bookRes = json_decode($bookRes);
          if($bookRes->status == '200'){
             $appointment = Appointment::create( [
                'reserved_time'  => $seleced_date->reserved_time,
                'department_id'  => $request->department_id,
                'doctor_id' => $request->doctor_id,
                 'his_ref'=>$bookRes->appointment_id,
                 'charge_price'=>$seleced_date->charge_price,
                'preffered_date' => $seleced_date->appointment_date,
                'appointment_time' => $seleced_date->available_slot,
                'end_time' => date('H:i:s',strtotime('+'.$seleced_date->appt_duration.' minutes',strtotime($seleced_date->available_slot)))
            ]);
            return ['status'=>200 ,'message'=>'', 'appointment'=>$appointment];

        }
        return ['status'=>400 , 'message'=>$bookRes->message];
    }
    public function getAvaliableTime(Request $request)
    {

        $doctor = Doctor::find($request->doctor_id);
        $department = Department::find($request->department_id);
        $date = strtotime($request->date);
        $date = date('d-M-Y', $date);

        $cURLConnection = curl_init();
        $uqery = ('{"department_id":"'.$department->his_ref.'","doctor_id":"'.$doctor->his_ref.'","appointment_date":"'.$date.'","appointment_time":"1000","pass_code":"'.config('app.BOOK_APPOINTMENT_PASSCODE').'"}');
        curl_setopt($cURLConnection, CURLOPT_URL,  config('app.BOOK_APPOINTMENT_LINK').'getAvailableApptSlot.shms?requestJson='.$uqery);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $timeList = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($timeList);
        $dataList = [] ;
        $index = 0 ;
         foreach($data->appointment_details as $datTime)
        {
             $dataList [] = [

                "id"=>$index,
                "reserved_time"=> $datTime->reserved_time,
                "appointment_date"=> $datTime->appointment_date,
                "doctor_id"=> $datTime->doctor_id,
                "booking_code"=> $datTime->booking_code,
                "charge_price"=> $datTime->charge_price,
                "appt_duration"=> $datTime->appt_duration,
                "available_slot"=> $datTime->available_slot,
                "end_time"=> date('H:i',strtotime('+'.$datTime->appt_duration.' minutes',strtotime($datTime->available_slot))) ,
            ];
            $index++;
        }
         $status = 1 ;
         if($data->status != '200' || sizeof($dataList)<1)
         {
             $status = 0 ;
         }
        return (json_encode([
          'show_list'=>$status ,
            'message'=> $data->message,
            'dateList' =>$dataList
        ]));

    }
    public function store(Request $request)
    {
        Validator::make($request->all(), [

            'book_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required','numeric'],
            'whatsapp_number' => ['required','numeric'],
        ])->validate();

        $date_preffered_date = new DateTime($request->preffered_date);
        $preffered_date=date_format( $date_preffered_date, 'Y-m-d H:i:s');
         $dob = \DateTime::createFromFormat('D M d Y H:i:s e+',$request->dob);
         if($dob)
         {
             $dob= $dob->format('Y-m-d') ;
         }
         else
         {
             $dob = $request->dob;
         }



        $appointment = Appointment::updateOrCreate( ['id'=>$request->book_id],[

            'user_id'    => $request->user_id,
            'name'    => $request->name,
            'last_name'    => $request->last_name,
            'passport_no'    => $request->passport_no,
            'phone_number' => $request->phone_number,
            'whatsapp_number' => $request->whatsapp_number,
            'civil_id' => $request->civil_id,
            'age' => $request->age,
            'dob' => $dob,


            'email' => $request->email,
            'gender' => $request->gender,
            'message' => $request->message,
        ]);


//To Be dynaimc from Db
        $email = 'info@task.com';

        if($email[0]->appointment_email != ''){
            $department = Department::find($request->department_id);
            $doctor = Doctor::find($request->doctor_id);
            try
            {
                Mail::to($email[0]->appointment_email)->send(new AppointmentMail($appointment,$department,$doctor));
            }
            catch (\Exception $exception){}
        }

        $payUrl = 'en/appointment/details/'.$appointment->id;
        return $payUrl;
        return response()->json('Appointment saved', 200);
    }

}
