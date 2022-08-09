<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;

use App\Models\Booking;
class BookingsExpoter extends AbstractExporter
{
    public function export()
    {
        Excel::create('Booking', function($excel) {

            $excel->sheet('Sheetname', function($sheet) {

                $sheet->prependRow(array(
                    'Booking Id', 'First Name', 'Last Name', 'Civil ID', 'Passport', 'Gender', 'Mobile Number', 'Booking Date', 'Created Date', 'Paid', 'Payment ID'
                ));

                // This logic get the columns that need to be exported from the table data
                $rows = collect($this->getData())->map(function ($item) {
                    return Arr::only($item, ['booking_number','first_name_en','last_name_en','civil_id','passport_no','gender','mobile_no','booking_date','created_at','payment_status_string','last_invoice_transactions']);
                });

                $sheet->rows($rows);
            });

        })->export('xls');
    }
}
