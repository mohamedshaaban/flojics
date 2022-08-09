<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Language;
use App\Http\Resources\Department as DepartmentResource;
use App\Http\Resources\Doctor as DoctorResource;

class DoctorController extends Controller
{
    public function homeDoctors()
    {
        $doctors = Doctor::with('specialty')->where('in_home', '1')->where('status',1)
                             ->get(['id', 'prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        return $doctors;
    }

    public function getAll()
    {
        $doctors = Doctor::with('specialty','department')->where('status',1)
                            ->get(['id', 'prefix_en', 'prefix_ar', 'name_en', 'name_ar', 'slug','picture', 'department_id', 'specialty_id']);
        return $doctors;
    }

    public function getDoctors()
    {
        // $doctors = Department::where('status', '1')->with('doctors')
        //                     ->get();
        // return DepartmentResource::collection($doctors);
        $doctors = Doctor::with('specialty','department')->where('status',1)
                        ->get()
                        ->sortBy('department.name')
                        ->groupBy('department.name')
                        ->toarray() ;
        // $doctors_sort= [];
        // foreach ($doctors as $k => $departments){
        //     // $index = 0 ;
        //     // foreach( $departments->sortBy('id') as $doctor)
        //     // {
        //     //     $doctors_sort[$k][$index] = $doctor;
        //     //     $index++;
        //     // }
        //     $doctors_sort[$k] = arsort($departments->toArray());
        // }
        return $doctors;
    }

    public function getAllLanguages()
    {
        $languages = Language::all();
        return $languages;
    }

    public function getDepartmentDoctors($id)
    {
        $doctors_list = array();
        if($id == 0){
            $doctors = Doctor::with('specialty')->where('status',1)
                            ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }else{
            $doctors = Doctor::with('specialty')->where('department_id', $id)->where('status',1)
                             ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }
        foreach ($doctors as $doctor) {
            // $responce['id']= $doctor->id;
            $responce['id']= $doctor->id;
            $responce['text']= $doctor->name;
            array_push($doctors_list,$responce);
        }
        return $doctors_list;
    }

    public function getDepartmentDoctorsForConformationAppoitmnet($id)
    {
        $id = Appointment::find($id);
        $id = $id->department_id;

        $doctors_list = array();
        if($id == 0){
            $doctors = Doctor::with('specialty')->where('status',1)
                            ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }else{
            $doctors = Doctor::with('specialty')->where('department_id', $id)->where('status',1)
                             ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }
        foreach ($doctors as $doctor) {
            $responce['id']= $doctor->id;
            // $responce['id']= $doctor->slug;
            $responce['text']= $doctor->name;
            array_push($doctors_list,$responce);
        }
        return $doctors_list;
    }
    public function getDoctorsInfo($id)
    {
        $doctor = Doctor::find($id);
        return ;
    }
    public function getDepartmentDoctorsForAppoitmnet($id)
    {

        $doctors_list = array();
        if($id == 0){
            $doctors = Doctor::with('specialty')->where('status',1)->where('show_appt', '1')
                            ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }else{
            $doctors = Doctor::with('specialty')->where('department_id', $id)->where('status',1)->where('show_appt', '1')
                             ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }
        foreach ($doctors as $doctor) {
            $responce['id']= $doctor->id;
            // $responce['id']= $doctor->slug;
            $responce['text']= $doctor->name;
            array_push($doctors_list,$responce);
        }
        return $doctors_list;
    }


    public function getDepartmentsDoctors(Request  $request,$id)
    {
          if($request->id ){
             $department = Department::where('slug',$request->id)->firstOrFail();
             $doctors = Doctor::with('specialty')->where('department_id', $department->id)->where('status',1)
                 ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);

        }else{
             $doctors = Doctor::with('specialty')->where('status',1)
                 ->get(['id','prefix_en', 'prefix_ar', 'name_en', 'name_ar','slug', 'picture', 'specialty_id']);
        }

        return $doctors;
    }

    public function getDoctorDetails($id)
    {
        $doctor = Doctor::with('specialty')->where('status',1)
                        ->where('slug', $id)->first();
        return new DoctorResource($doctor);
    }

    public function getFilterDoctors($filter, Request $request)
    {
        if($filter == "false"){
            $doctors = Doctor::with('specialty','department')->where('status',1)
                        ->get()
                        ->sortBy('department.name')
                        ->groupBy('department.name')->toarray() ;
        }else{
            $filterOptions = $request->query();
            $query = Doctor::with('specialty','department')->where('status',1);

            if(isset($filterOptions['language']))
            {
                $laguageId = $filterOptions['language'];
                $query->whereHas('languages', function ($query) use ($laguageId){
                    $query->where('languages.id', $laguageId);
                });
            }
            if(isset($filterOptions['department']))
            {
                $query->Where('department_id', $filterOptions['department']);
            }
            if(isset($filterOptions['doctor']))
            {
                $query->Where('id', $filterOptions['doctor']);
            }
            if(isset($filterOptions['gender']))
            {
                $query->Where('gender', $filterOptions['gender']);
            }
            $doctors = $query->get()->sortBy('department.name')->groupBy('department.name')->toarray() ;
        }
        return $doctors;
    }

    public function getLetterDoctors($letter)
    {
        $locale = app()->getLocale();
        if ($locale == 'en') {
            $doctors = Doctor::with('specialty','department')->where('status',1)
                        ->whereRaw("upper(name_en) LIKE '".$letter."%'")
                        ->get()
                        ->sortBy('department.name')
                        ->groupBy('department.name')->toarray() ;
        }else{
            $doctors = Doctor::with('specialty','department')->where('status',1)
                        ->whereRaw("upper(name_ar) LIKE '".$letter."%'")
                        ->get()
                        ->sortBy('department.name')
                        ->groupBy('department.name')->toarray() ;
        }
        return $doctors;
    }

    public function getNameDoctors($name){
        $locale = app()->getLocale();
        if ($locale == 'en') {
            $name = Str::upper($name);
            $doctors = Doctor::with('specialty','department')->where('status',1)
                            ->whereRaw("upper(name_en) LIKE '%".$name."%'")
                            ->get()
                            ->sortBy('department.name')
                            ->groupBy('department.name')->toarray() ;
        }else{
            $doctors = Doctor::with('specialty','department')->where('status',1)
                            ->whereRaw("name_ar LIKE '%".$name."%'")
                            ->get()
                            ->sortBy('department.name')
                            ->groupBy('department.name')->toarray() ;
        }
        return $doctors;
    }
}
