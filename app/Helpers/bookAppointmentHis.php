<?php

use App\Models\UserNotifications;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;
use App\User;

if ( ! function_exists( 'bookAppointmentHis' ) ) {
    /**
     * Get Total Refunded Amount order
     * @param $id
     *
     * @return  float|integer
     */
    function bookAppointmentHis( $data) {
        $app = \App\Models\Appointment::find($data);
        $user = User::find($app->user_id);
        $cURLConnection = curl_init();
        $name = explode(' ', $app->name);
        $lname = array_key_exists('1',$name) ? $name[1] : 'Website';
        $dob = $app->dob;
        if(!isValid($dob))
        {
            $time = strtotime($dob);
            $dob = date('Y-m-d', $time);
        }
        $passport = '';
        if($app->passport_no && $app->passport_no!="null"&& $app->passport_no!="" )
        {
            $passport = $app->passport_no;
        }
  //        $uqery = ('{"appointment_id":"0","department_id":"'.$department->his_ref.'","doctor_id":"'.$doctor->his_ref.'","appointment_time":"'.$time.'","appt_duration":"'.$seleced_date->appt_duration.'","appointment_date":"'.$seleced_date->appointment_date.'","pass_code":"'.config('app.BOOK_APPOINTMENT_PASSCODE').'","status":"Reserved"}');
        $uqery = ('{"appointment_id":"'.$app->his_ref.'","first_name":"'.urlencode(@$app->name).'","last_name":"'.@$app->last_name.'","email":"'.$app->email.'","mobile_no":"'.$app->phone_number.'","whatsapp_number":"'.$app->whatsapp_number.'","civil_id":"'.$app->civil_id.'","dob":"'.$dob.'","age":"'.$app->age.'","passport_no":"'.$passport.'","my_complaints":"'.$app->message.'","gender":"'.$app->gender.'","receipt_amount":"'.$app->charge_price.'","receipt_date":"'.\Carbon\Carbon::today()->format('d-M-Y').'","bank_code":"QNB","card_number":"3455345451231234","reference_number":"'.$app->reference_number.'","payment_type":"DC","pass_code":"'.config('app.BOOK_APPOINTMENT_PASSCODE').'"}');
         curl_setopt($cURLConnection, CURLOPT_URL,  config('app.BOOK_APPOINTMENT_LINK').'apptBookingWithPayment.shms?requestJson='.$uqery);
      

        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $bookRes = curl_exec($cURLConnection);
        file_put_contents('logs/log_his_'.date("j.n.Y").'_his.log',   config('app.BOOK_APPOINTMENT_LINK').'apptBookingWithPayment.shms?requestJson='.$uqery. "\n", FILE_APPEND);
        file_put_contents('logs/log_his_'.date("j.n.Y").'_his.log',  $bookRes. "\n", FILE_APPEND);
        if($user)
        {
            $bookRes = json_decode($bookRes);
            $user->his_ref = $bookRes->patient_id;
            $user->save();
        }
         curl_close($cURLConnection);
    }
    function isValid($date, $format = 'Y-m-d'){
        $dt = DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }

}
if ( ! function_exists( 'cancelAppointmentHis' ) ) {
    /**
     * Get Total Refunded Amount order
     * @param $id
     *
     * @return  float|integer
     */
    function cancelAppointmentHis( $data) {
        $app = \App\Models\Appointment::find($data);
        $cURLConnection = curl_init();
        $name = explode(' ', $app->name);
        $lname = array_key_exists('1',$name) ? $name[1] : 'Website';
        $dob = $app->dob;
        if(!isValid($dob))
        {
            $time = strtotime($dob);
            $dob = date('Y-m-d', $time);
        }
//        $uqery = ('{"appointment_id":"0","department_id":"'.$department->his_ref.'","doctor_id":"'.$doctor->his_ref.'","appointment_time":"'.$time.'","appt_duration":"'.$seleced_date->appt_duration.'","appointment_date":"'.$seleced_date->appointment_date.'","pass_code":"'.config('app.BOOK_APPOINTMENT_PASSCODE').'","status":"Reserved"}');
        $uqery = urlencode('{"appointment_id":"'.$app->his_ref.'","status":"Cancelled","remarks":"'.$app->remarks.'","pass_code":"'.config('app.BOOK_APPOINTMENT_PASSCODE').'"}');
        file_put_contents('logs/log_'.date("j.n.Y").'_his.log',  $uqery. "\n", FILE_APPEND);

        curl_setopt($cURLConnection, CURLOPT_URL,  config('app.BOOK_APPOINTMENT_LINK').'cancelAppointmentOnWebsite.shms?requestJson='.$uqery);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $bookRes = curl_exec($cURLConnection);
        file_put_contents('logs/log_'.date("j.n.Y").'_his.log',  $bookRes. "\n", FILE_APPEND);

         return $bookRes;
         curl_close($cURLConnection);
    }


}
