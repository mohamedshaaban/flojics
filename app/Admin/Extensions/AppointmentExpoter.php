<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

class AppointmentExpoter extends AbstractExporter
{
    public function export()
    {
        Excel::create('Appointment', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {

                $sheet->prependRow(array(
                    'Id', 'Name', 'Phone', 'Email', 'Civil id', 'Preferred date', 'Department', 'Doctor', 'Status'
                ));

                // This logic get the columns that need to be exported from the table data
                $rows = collect($this->getData())->map(function ($item) {
                    return Arr::only($item, ['id', 'name', 'phone_number', 'email', 'civil_id', 'preffered_date', 'department_name', 'doctor_name', 'status_name']);
                });

                $sheet->rows($rows);
            });

        })->export('xls');
    }
}
