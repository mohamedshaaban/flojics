<section class="content">
    <style>
        @media print {
            .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left;
            }
            .col-sm-12 {
                width: 100%;
            }
            .col-sm-11 {
                width: 91.66666667%;
            }
            .col-sm-10 {
                width: 83.33333333%;
            }
            .col-sm-9 {
                width: 75%;
            }
            .col-sm-8 {
                width: 66.66666667%;
            }
            .col-sm-7 {
                width: 58.33333333%;
            }
            .col-sm-6 {
                width: 50%;
            }
            .col-sm-5 {
                width: 41.66666667%;
            }
            .col-sm-4 {
                width: 33.33333333%;
            }
            .col-sm-3 {
                width: 25%;
            }
            .col-sm-2 {
                width: 16.66666667%;
            }
            .col-sm-1 {
                width: 8.33333333%;
            }
            .col-sm-pull-12 {
                right: 100%;
            }
            .col-sm-pull-11 {
                right: 91.66666667%;
            }
            .col-sm-pull-10 {
                right: 83.33333333%;
            }
            .col-sm-pull-9 {
                right: 75%;
            }
            .col-sm-pull-8 {
                right: 66.66666667%;
            }
            .col-sm-pull-7 {
                right: 58.33333333%;
            }
            .col-sm-pull-6 {
                right: 50%;
            }
            .col-sm-pull-5 {
                right: 41.66666667%;
            }
            .col-sm-pull-4 {
                right: 33.33333333%;
            }
            .col-sm-pull-3 {
                right: 25%;
            }
            .col-sm-pull-2 {
                right: 16.66666667%;
            }
            .col-sm-pull-1 {
                right: 8.33333333%;
            }
            .col-sm-pull-0 {
                right: auto;
            }
            .col-sm-push-12 {
                left: 100%;
            }
            .col-sm-push-11 {
                left: 91.66666667%;
            }
            .col-sm-push-10 {
                left: 83.33333333%;
            }
            .col-sm-push-9 {
                left: 75%;
            }
            .col-sm-push-8 {
                left: 66.66666667%;
            }
            .col-sm-push-7 {
                left: 58.33333333%;
            }
            .col-sm-push-6 {
                left: 50%;
            }
            .col-sm-push-5 {
                left: 41.66666667%;
            }
            .col-sm-push-4 {
                left: 33.33333333%;
            }
            .col-sm-push-3 {
                left: 25%;
            }
            .col-sm-push-2 {
                left: 16.66666667%;
            }
            .col-sm-push-1 {
                left: 8.33333333%;
            }
            .col-sm-push-0 {
                left: auto;
            }
            .col-sm-offset-12 {
                margin-left: 100%;
            }
            .col-sm-offset-11 {
                margin-left: 91.66666667%;
            }
            .col-sm-offset-10 {
                margin-left: 83.33333333%;
            }
            .col-sm-offset-9 {
                margin-left: 75%;
            }
            .col-sm-offset-8 {
                margin-left: 66.66666667%;
            }
            .col-sm-offset-7 {
                margin-left: 58.33333333%;
            }
            .col-sm-offset-6 {
                margin-left: 50%;
            }
            .col-sm-offset-5 {
                margin-left: 41.66666667%;
            }
            .col-sm-offset-4 {
                margin-left: 33.33333333%;
            }
            .col-sm-offset-3 {
                margin-left: 25%;
            }
            .col-sm-offset-2 {
                margin-left: 16.66666667%;
            }
            .col-sm-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-sm-offset-0 {
                margin-left: 0%;
            }
        }
    </style>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail</h3>
                            <div class="box-tools">
                                <div class="btn-group pull-right" style="margin-right: 5px">
                                    <a href="{{ route('admin_appointments.index') }}" class="btn btn-sm btn-default" title="List">
                                        <i class="fa fa-list"></i>
                                        <span class="hidden-xs">&nbsp;List</span>
                                    </a>
                                </div>
                                <div class="btn-group pull-right" style="margin-right: 5px">
                                    <a href="{{ route('customer.appointment.print_invoice',$appointment->id) }}" target="_blank" class="btn btn-sm btn-default">
                                        <i class="fa fa-print"></i>
                                        <span class="hidden-xs">&nbsp;Print</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <tr>
                                    <td style="width: 40%;">Id # : </td>
                                    <td>{{ $appointment->id }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Name  : </td>
                                    <td>{{ $appointment->name }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Last Name  : </td>
                                    <td>{{ $appointment->last_name }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Phone number  : </td>
                                    <td>{{ $appointment->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Whatsapp number  : </td>
                                    <td>{{ $appointment->whatsapp_number }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Email  : </td>
                                    <td>{{ $appointment->email }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Civil id  : </td>
                                    <td>{{ $appointment->civil_id }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Preferred date  : </td>
                                    <td>{{ $appointment->preffered_date }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Reason for consultation  : </td>
                                    <td>{{ $appointment->message }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Department  : </td>
                                    <td>{{ $appointment->department_name }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Doctor  : </td>
                                    <td>{{ $appointment->doctor_name }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Status  : </td>
                                    <td>{{ $appointment->status_name }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">His ref  : </td>
                                    <td>{{ $appointment->his_ref }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Appointment time  : </td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">End time  : </td>
                                    <td>{{ $appointment->end_time }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Passport no  : </td>
                                    <td>{{ $appointment->passport_no }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Age  : </td>
                                    <td>{{ $appointment->age }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Date Of Birth  : </td>
                                    <td>{{ $appointment->dob }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Gender  : </td>
                                    <td>{{ $appointment->gender }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Charge price  : </td>
                                    <td>{{ $appointment->charge_price }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Reason for cancellation  : </td>
                                    <td>{{ $appointment->remarks }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Payment type  : </td>
                                    <td>{{ $appointment->payment_type }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 40%;">Reference number  : </td>
                                    <td>{{ $appointment->reference_number }}</td>
                                </tr>

                                <tr>
                                    <td style="width: 40%;">Declerations : </td>
                                    <td>{{ $appointment->declerations }}</td>
                                </tr>



                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>

    // function load() {
    //     $('#printBtn').click(function () {
    //         var divToPrint=document.getElementById('details');

    //         var newWin=window.open('','Print-Window');

    //         newWin.document.open();

    //         newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

    //         newWin.document.close();

    //         setTimeout(function(){newWin.close();},10);


    //     });
    // }

    // if (document.readyState === 'complete') {
    //     load();
    // }else {
    //     $(document).ready(load);
    // }
</script>
