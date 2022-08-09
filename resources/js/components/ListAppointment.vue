<template>
    <div>
        <section class="inner-content drApntmnt-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('appointments') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('appointments') }}</h1>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 left" style="margin: unset !important;padding: unset;">
                            <nav class="navbar navbar-collpase-lg navbar-light bg-light">
                                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContentprofile" aria-controls="navbarSupportedContentprofile" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div id="navbarSupportedContentprofile" class="collapse  show navbar-collapse" style="">
                                    <ul class="navbar-nav ml-auto sidepanel list-unstyled components">
                                    <li class="nav-item nav-item dropdown">
                                        <h2 class="main-head">{{ $t('Welcome') }} {{ this.loggedUser.name }}</h2>
                                    </li>
                                    <li class="nav-item nav-item dropdown">

                                        <router-link  :to="{ name: 'profile', params: { lang: getFromLocale() }}"><i class="nav-icon la la-user"></i>{{ $t('nav.profile') }}</router-link>

                                    </li>
                                    <li class="nav-item nav-item dropdown">
                                        <router-link  :to="{ name: 'listappointment', params: { lang: getFromLocale() }}"><i class="nav-icon fa fa-calendar"></i>{{ $t('appointments') }}</router-link>

                                    </li>


                                </ul>
                                </div>
                            </nav>
                        </div>
                    <div class="col-lg-9">
                    <table class="table table-striped" >
                    <thead>
                    <tr>
                        <td>{{ $t('appointment') }}</td>
                        <td >{{$t("Date")}}</td width="30%">
                        <td>{{$t("patient")}}</td>
                        <td>{{$t("patient_id")}}</td>
                        <td>{{$t("pass_civil")}}</td>
                         <td>{{$t("department")}}</td>
                        <td>{{$t("doctor")}}</td>
                        <td>{{$t("status")}}</td>
                        <td>{{$t("req_cal")}}</td>
                    </tr>
                    </thead>
                        <tbody>
                        <tr v-for="appointment in appointments">
                            <td>#{{ appointment.id}}</td>
                            <td  style="white-space:nowrap;" >{{ appointment.preffered_date}} {{ appointment.appointment_time}} {{ appointment.end_time}}</td>
                            <td>{{ appointment.name}}</td>
                            <td>{{ appointment.his_ref}}</td>
                            <td>{{ appointment.civil_id}} <span v-if="appointment.passport_no && appointment.passport_no !='null'">/ {{ appointment.passport_no}}</span> </td>
                            <td>{{ appointment.department_name}}</td>
                            <td>{{ appointment.doctor_name}}</td>
                            <td>{{ appointment.status_name}}</td>
                        </tr>

                        </tbody>
                </table>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                loggedUser: this.auth.user,
                doctors: [],
                departments: [],
                appointments: [],
                errors: {},
                decleartions: '',
                depart: '',
                doc: '',
                name : '',
                phone_number : '',
                email : '',
                civil_id : '',
                message : ''
            }
        },
        updated: function () {

            $('#input').datetimepicker({minDate : 0, footer: true, modal: true });
        },
        mounted() {
            this.getAppt();
            axios.all([
                axios.get('/api/departments')])

        .then(axios.spread((departmentsResponse) => {
                this.departments = departmentsResponse.data;

            }));
        },
        methods: {


            getAppt() {
                this.axios.post('/api/appointments')
                    .then(({data}) => {
                        this.appointments = data.appts;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            storeAppointment(){
                $('#sad').attr("disabled", true);
                //Initialize the form data
                let formData = new FormData();

                formData.append('department_id', this.depart);
                formData.append('doctor_id', this.doc);
                formData.append('name', this.name);
                formData.append('phone_number', this.phone_number);
                formData.append('email', this.email);
                formData.append('preffered_date', $('.date-picker2').val());
                formData.append('civil_id', this.civil_id);
                formData.append('message', this.message);
                /*
                  Make the request to the POST /single-file URL
                */
                let  _this = this;

                axios.post('/api/appointment/store',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(response => {
                    _this.$swal({
                        icon: 'success',
                        title: this.$t('pop-up.appointment-success-title'),
                        text: this.$t('pop-up.appointment-success-text'),
                    }).then((result) => {
                        this.depart = '';
                        this.doctors =[];
                        this.doc = '';
                        this.name = '';
                        this.phone_number = '';
                        this.email = '';
                        $('.date-picker2').val('');
                        this.civil_id = '';
                        this.message = '';
                        this.errors = {};
                        $('#sad').attr("disabled", false);
                    });
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        $('#sad').attr("disabled", false);
                    }else{
                        _this.$swal({
                            icon: 'warning',
                            title: this.$t('pop-up.appointment-warning-title'),
                            text: this.$t('pop-up.appointment-warning-text'),
                        }).then((result) => {
                            this.depart = '';
                            this.doctors =[];
                            this.doc = '';
                            this.name = '';
                            this.phone_number = '';
                            this.email = '';
                            $('.date-picker2').val('');
                            this.civil_id = '';
                            this.message = '';
                            this.errors = {};
                            $('#sad').attr("disabled", false);
                        });
                    }
                });
            },

            departmentsDoctors(){

                this.doctors =[];

                axios.all([
                    axios.get('/api/appoiment-department-doctors/'+this.depart),
                ])
                .then(axios.spread((doctorsResponse) => {
                    this.doctors = doctorsResponse.data;
                })).then((result) => {
                    this.doc = '';
                });
            },

            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            }
        }
    }
</script>
