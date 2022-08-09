<template>
    <div>
        <section class="inner-content drApntmnt-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('dr_appointment') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('dr_appointment_confirmation') }}</h1>
                 <form class="row mt-3" @submit.prevent="storeAppointment">

                    <div class="form-group col-md-4" v-if="this.book.department">
                        <label>{{ $t('department') }} :</label>
                        {{ this.book.department.name}}
                        <!-- <textarea class="form-control" :placeholder="$t('message')" name="message" maxlength="2000" v-model="message"></textarea> -->
                    </div><!--/col-4-->

                    <div class="form-group col-md-4" v-if="this.book.doctor">
                        <label>{{ $t('doctor_name') }}:</label>
                        {{ this.book.doctor.name}}
                        <!-- <textarea class="form-control" :placeholder="$t('message')" name="message" maxlength="2000" v-model="message"></textarea> -->
                    </div><!--/col-4-->

                    <div class="form-group col-md-4">
                        <label>{{ $t('Name') }} :</label>
                        {{ this.book.name}} {{ this.book.last_name}}
                    </div><!--/col-4-->
                    <div class="form-group col-md-4" v-if="this.book.passport_no && this.book.passport_no != 'null'">
                        <label>{{ $t('pcr-test.passport_no') }} :</label>
                        {{ this.book.passport_no}}

                    </div><!--/col-4-->
                     <div class="form-group col-md-4" v-else>
                        <label>{{ $t('pcr-test.passport_no') }} :</label>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('phone_number') }} :</label>
                        {{ this.book.phone_number}}
                    </div><!--/col-4-->
                     <div class="form-group col-md-4" v-if="this.book.whatsapp_number">
                        <label>{{ $t('whatsapp_number') }} :</label>
                        {{ this.book.whatsapp_number}}
                    </div><!--/col-4-->
                     <div class="form-group col-md-4">
                         <label> {{ $t('placeholder_appt_date_time') }} :</label>
                         {{ this.book.preffered_date}} {{ this.book.appointment_time}} {{ this.book.بةخع}}

                     </div>
                    <div class="form-group col-md-4">
                        <label>{{ $t('civil_id') }} :</label>
                        {{ this.book.civil_id}}

                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label> {{ $t('pcr-test.dob') }} :</label>
                        {{ this.book.dob}}

                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ $t('email_id') }} :</label>
                        {{ this.book.email}}

                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> {{ $t('pcr-test.gender') }} :</label>
                        {{ this.book.gender}}

                        <div v-if="errors && errors.gender" class="text-danger">{{ errors.gender[0] }}</div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>{{ $t('message') }}:</label>
                        {{ this.book.message}}

                        <!-- <textarea class="form-control" :placeholder="$t('message')" name="message" maxlength="2000" v-model="message"></textarea> -->
                    </div><!--/col-4-->
                     <div class="form-group col-md-4">
                         <label> {{ $t('pcr-test.dr_fees') }} : {{ this.book.charge_price}}
                             {{ $t('pcr-test.kd') }} </label>

                     </div>

                     <div class="form-group col-md-4">
                         <label> {{ $t('nav.Payment_ID') }} :</label>
                         {{ this.book.reference_number}}

                     </div>
                     <div class="form-group col-md-4">
                         <label> {{ $t('nav.Invoice_Number') }} :</label>
                         {{ this.book.id}}

                     </div>
                     <div class="form-group col-md-4">
                         <label> {{ $t('nav.payment_type') }} :</label>
                         {{ this.book.payment_type}}

                     </div>
                     <div class="form-group col-md-8">
                         <label> {{ $t('nav.Payment_Status') }} :</label>
                         <label v-if="this.book.payment_status_id == 1">
                             {{ $t('nav.Payment_Sucess')}}
                         </label>
                         <label  v-if="this.book.payment_status_id !=1">
                         {{ $t('nav.Payment_Failed')}}
                     </label>


                     </div>
                </form>
            </div>
        </section>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';

    export default {
        components: { Datepicker },

        data(){
            return {
                doctors: [],
                departments: [],
                errors: {},
                book:'',
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

        },
        mounted() {

            this.appID = this.$route.params.id;

            axios.all([
                axios.get('/api/departments'),
                axios.get('/api/appointment/confirmation/'+this.appID)


            ])
            .then(axios.spread((departmentsResponse,appointmentResponse) => {
                this.departments = departmentsResponse.data;
                this.book = appointmentResponse.data;

            }));
        },
        methods: {

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
