<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Page;
use App\Models\Award;
use App\Models\Activity;
use Session;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Artisan;
use Illuminate\Console\Scheduling\Schedule;

class HomeController extends Controller
{
    public function tiny()
    {
               $link ='http://wara.phpmawaqaa.com/en/booking/280613';


         //TinyUrl
         $curlbit = curl_init();

         curl_setopt_array($curlbit, array(
             CURLOPT_URL => 'https://api.tinyurl.com/create',
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_ENCODING => '',
             CURLOPT_MAXREDIRS => 10,
             CURLOPT_TIMEOUT => 0,
             CURLOPT_FOLLOWLOCATION => true,
             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
             CURLOPT_CUSTOMREQUEST => 'POST',
             CURLOPT_POSTFIELDS =>'{
  "url":"'.$link.'" ,
   "domain": "tiny.one",
   "alias": "",
   "tags": ""
 }',
             CURLOPT_HTTPHEADER => array(
                 'Authorization:  Bearer '.config('app.BITLY_ACCESS_TOKEN'),
                 'Content-Type: application/json'
             ),
         ));

         $response = curl_exec($curlbit);
         $response = json_decode($response);
         curl_close($curlbit);
         $link = $response->data->tiny_url;
         dd($link);
    }
    public function homeSlides()
    {
        $slides_list = array();
        $slides = Slider::where('status', '1')
                        ->orderBy('order', 'asc')
                        ->get(['image', 'link']);
        foreach ($slides as $slide) {
            $responce['image']= $slide->image;
            $responce['link']= $slide->link != null? substr($slide->link, strpos($slide->link, '=')+1):null;
            array_push($slides_list,$responce);
        }
                        // dd($slides_list);
        return $slides_list;
    }
    public function npmRun(Schedule $schedule)
    {
        $result = $schedule->command('vue:dev')->hourly();

    }

    public function addSlugs()
    {
        $departments = Department::all();
        foreach($departments as $department){
            $slug_department = Str::slug($department->name_en, '-');
             $department->slug =  $slug_department;
            $department->Save();
        }

        $doctors = Doctor::all();
        foreach($doctors as $doctor){
            $slug_doctor = Str::slug($doctor->name_en, '-');
             $doctor->slug =  $slug_doctor;
            $doctor->Save();
        }
        dd ('finich');
    }

    public function internetExplorer(){
        return view('internetExplorer');
    }

    public function switchLang($locale)
    {
        Session::put('locale',$locale);
        App::setLocale($locale);
        header("Refresh:0");
    }

}
