<template>
    <div>
        <section class="inner-content drApntmnt-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('dr_appointment') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('dr_appointment') }}</h1>
                <strong>{{ $t('request_appointment') }}</strong>
                <div class="row mt-3" >
                     <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">{{ $t('choose_department') }} <span>*</span></label>
                        <select class="form-control" required v-model="depart" @change="departmentsDoctors()">
                            <option value="" >{{ $t('choose_department') }}</option>
                            <option v-for="department in departments" :key="department.id" :value="department.id" >
                                {{department.name}}
                            </option>
                        </select>
                        <div v-if="departerrors" class="text-danger">{{ departerrors }}</div>
                    </div><!--/col-4-->

                    <div class="form-group col-md-4">
                        <label id="doctor_id" for="exampleInputEmail1">{{ $t('doctor_name') }} <span>*</span></label>
                         <select2 name="doctor_id" :placeholder="$t('doctor_name')" :options="doctors" v-model="doc" required @change="changeDoctor()">
                        </select2>
                        <div v-if="docerrors" class="text-danger">{{ docerrors }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('preffered_date_time') }}<span>*</span></label>
                        <div class="full_width">
                            <datepicker format="dd/MM/yyyy" :disabledDates="disabledDates" :highlighted="highlighted" v-model="preffered_date" name="preffered_date" required=""  data-index="0"
                                        class="date-picker form-control datepicker_dob"  id="datepicker_dob" :placeholder="$t('placeholder_date_time')" @selected="checkAppointment($event)"></datepicker>
                            <div v-if="preffered_dateerrors" class="text-danger">{{ preffered_dateerrors }}</div>

                        </div>
                    </div><!--/col-4-->



                            <div class="form-group col-md-12 q-col">

                                <b> {{ $t('avaliable_time') }} :</b><br />
                                 <div class="question-hold">
                                    <div class="q-sec" >
                                        <div class="radio-container1" >
                                           <div v-if="this.showLoad == 0">
                                               <button v-for="date in this.avaliable_dates" :id="date.id" :key="date.id" :value="date.id" @click="selectDoctor(date,date.id)" style="margin: 2px;" class="btn btn-outline-primary rounded-0">
                                                   {{ date.appointment_date }} ( {{ date.available_slot }} - {{ date.end_time }} )
                                               </button>
                                           </div>
                                            <div v-else>
                                                <center style="color:#026F78;">
                                                    <label style="color:#026F78;">{{ $t('avaliable_slot_loading') }}</label>
                                                </center>
                                            </div>


                                            <div v-if="seleced_dateerrors" class="text-danger">{{ seleced_dateerrors }}</div>


                                            <br />

                                        </div>
                                    </div>
                                </div>

                            </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> {{ $t('pcr-test.dr_fees') }} : {{this.fees}} {{ $t('pcr-test.kd') }} </label>
                    </div>
                    <div class="form-group col-md-12 mt-3">
                        <!-- <button class="btn btn-outline-primary rounded-0" @click.prevent="storeAppointment">{{ $t('submit') }}</button> -->
                        <input type="button" id="sad" class="btn btn-outline-primary rounded-0" :value="$t('book')" @click="storeAppointment">
                    <br />
                    </div>

                </div>
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
                loggedUser: this.auth.user,
                disabledDates: {
                    to: new Date(Date.now() - 8640000)
                },
                highlighted: {
                    dates: [ // Highlight an array of dates
                        new Date()
                    ],
                    includeDisabled: true // Highlight disabled dates
                },
                showLoad:0,
                doctors: [],
                departments: [],
                errors: [],
                preffered_date:null,
                avaliable_dates:[],
                show_list:false,
                seleced_date:null,
                message:'',
                fees:0,
                depart: '',
                departerrors: null,
                preffered_dateerrors: null,
                seleced_dateerrors: null,
                docerrors: null,
                doc: '',
                name : '',
                phone_number : '',
                email : '',
                civil_id : '',
            }
        },
        updated: function () {
           },
        mounted() {
            setTimeout(function(){
                window.location.reload();
            }, 300000);
            axios.all([
                axios.get('/api/apptdepartments')

            ])
            .then(axios.spread((departmentsResponse) => {
                this.departments = departmentsResponse.data;

                this.depart = this.$route.params.depart_id;

                if(this.depart && this.depart!='undefined')
                {
                    axios.all([
                        axios.get('/api/department-doctors/'+this.depart),
                        axios.get('/api/dedoctorsdetails/'+this.$route.params.doc_id),
                    ])
                        .then(axios.spread((doctorsResponse) => {
                             this.doctors = doctorsResponse.data;
                        })).then((result) => {
                        this.doc = this.$route.params.doc_id;
                     });
                }
                else
                {
                    this.depart ='';
                }


            }));
        },
        methods: {
            selectDoctor(doctor,id)
            {
                this.seleced_dateerrors = null ;
                this.fees = 0 ;
                var elems = document.querySelectorAll(".active");

                [].forEach.call(elems, function(el) {
                    el.classList.remove("active");
                });
                $('#'+id).toggleClass('active');
                this.seleced_date = doctor;
                this.fees = doctor.charge_price;
                return false ;
            },
            changeDoctor()
            {
                this.docerrors = null ;
                this.seleced_dateerrors = null ;
                this.fees = 0 ;
                var birthDate = this.preffered_date;
                this.avaliable_dates=[];
                let formData = new FormData();
                if( this.depart && this.doc && birthDate)
                {
                    this.showLoad = true;
                }
                formData.append('date', birthDate.getDate()+'-'+(birthDate.getMonth()+1)+'-'+birthDate.getFullYear());
                formData.append('department_id', this.depart);
                formData.append('doctor_id', this.doc);
                let  _this = this;

                axios.post('/api/appointment/getAvaliableTime',
                    formData,
                ).then(response => {
                    this.showLoad = false;

                    this.avaliable_dates = response.data.dateList;
                    this.show_list = response.data.show_list;
                    this.message = response.data.message;
                    if(this.show_list == 0 )
                    {
                        this.seleced_dateerrors= response.data.message;
                    }

                });

            },
            checkAppointment(event){
                this.seleced_dateerrors = null;
                this.preffered_dateerrors = null;
                 var birthDate = new Date(event);
                let formData = new FormData();
                formData.append('date', birthDate.getDate()+'-'+(birthDate.getMonth()+1)+'-'+birthDate.getFullYear());
                formData.append('department_id', this.depart);
                formData.append('doctor_id', this.doc);
                let  _this = this;
                this.showLoad = 1 ;
                axios.post('/api/appointment/getAvaliableTime',
                    formData,
                ).then(response => {
                    this.showLoad = 0 ;

                        this.avaliable_dates = response.data.dateList;
                        this.show_list = response.data.show_list;
                        this.message = response.data.message;
                    if(this.show_list == 0 )
                    {
                        this.seleced_dateerrors= response.data.message;
                    }
                 });

            },

            storeAppointment(){
                // $('#sad').attr("disabled", true);
                //Initialize the form data
                this.departerrors = null;
                this.docerrors = null;
                    this.preffered_dateerrors= null;
                    this.seleced_dateerrors= null;
                  if(this.depart=='' )
                {
                    this.departerrors= this.$t('please_select_depart');
                    return;
                }
                 if(this.doc=='')
                {
                    this.docerrors= this.$t('please_select_doctor');
                    return;
                }
                if(this.preffered_date ==null)
                {
                    this.preffered_dateerrors = this.$t('please_select_perferred_date');
                    return;
                }
                if(this.seleced_date ==null)
                {
                    this.seleced_dateerrors= this.$t('please_select_date');
                    return;
                }
                let formData = new FormData();

                formData.append('department_id', this.depart);
                formData.append('doctor_id', this.doc);
                formData.append('seleced_date', JSON.stringify(this.seleced_date));


                axios.post('/api/appointment/reserveBookingSlot',
                    formData,
                ).then(response => {
                    if(response.data.status==200)
                    {
                        this.$router.push({
                            name: 'confappointment',
                            params: {id: response.data.appointment.id}
                        });
                    }
                    else
                    {
                        _this.$swal({
                            icon: 'warning',
                            title: this.$t('pop-up.appointment-warning-title'),
                            text: response.data.message,
                        });
                    }

                });
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

                this.departerrors = null ;
                 this.departerrors = null ;
                this.fees = 0 ;

                this.doctors =[];
                this.avaliable_dates=[];

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
