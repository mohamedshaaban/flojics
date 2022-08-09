<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function homeDepartments()
    {
        $departments = Department::where('status', '1')->where('in_home', '1')
                                    ->get(['id', 'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar', 'image']);
        return $departments;
    }

    public function getAll()
    {
        $departments = Department::where('status', '1')
                                    ->get(['id', 'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar', 'image']);
        return $departments;
    }

    public function getApptAll()
    {
        $departments = Department::where('status', '1')->where('show_appt', '1')
                                    ->get(['id', 'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar', 'image']);
        return $departments;
    }

    public function getAllFilterDepartment()
    {
        $departments = Department::where('status', '1')
                                    ->orderBy('name_en', 'asc')
                                    ->get(['id', 'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar', 'image']);
        return $departments;
    }

    public function getFilterDepartment($id)
    {
        if($id == 0){
            $departments = Department::where('status', '1')
                                    ->get(['id', 'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar', 'image']);
        }else{
            $departments = Department::where('id', $id)
                                    ->get(['id', 'name_en', 'name_ar','slug', 'short_description_en', 'short_description_ar', 'image']);
        }
        return $departments;
    }

    public function getDepartmentDetails($id)
    {
        $Department = Department::where('slug', $id)->first();
        return $Department;
    }

    public function getDepartmentPhones()
    {
        $departments = Department::where('status', '1')
                                    ->get(['id', 'name_en', 'name_ar', 'phone']);
        return $departments;
    }
}
