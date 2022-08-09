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
                <form class="row mt-3" @submit.prevent="storeAppointment">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">{{ $t('choose_department') }} <span>*</span></label>
                        <select class="form-control" required v-model="depart" @change="departmentsDoctors()">
                            <option value="" >{{ $t('choose_department') }}</option>
                            <option v-for="department in departments" :key="department.id" :value="department.id" >
                                {{department.name}}
                            </option>
                        </select>
                        <div v-if="errors && errors.department_id" class="text-danger">{{ errors.department_id[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label id="doctor_id" for="exampleInputEmail1">{{ $t('doctor_name') }} <span>*</span></label>
                        <select2 name="doctor_id" :placeholder="$t('doctor_name')" :options="doctors" v-model="doc" required >

                        </select2>

                        <div v-if="errors && errors.doctor_id" class="text-danger">{{ errors.doctor_id[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('first_last_name') }} <span>*</span></label>
                        <input type="text" class="form-control" id="inputEmail4" :placeholder="$t('enter_name')" required name="name" v-model="name">
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('phone_number') }} <span>*</span></label>
                        <input type="text" class="form-control" id="inputEmail4" :placeholder="$t('phone_number')" name="phone_number" required v-model="phone_number">
                        <div v-if="errors && errors.phone_number" class="text-danger">{{ errors.phone_number[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('civil_id') }} </label>
                        <input type="text" class="form-control" id="inputEmail4" :placeholder="$t('placeholder_civil')" name="civil_id" v-model="civil_id">
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('preffered_date_time') }} </label>
                        <div class="full_width">
                            <input id="input" class="date-picker2" :placeholder="$t('placeholder_date_time')" name="preffered_date" />
                        </div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('email_id') }} </label>
                        <input type="email" class="form-control" id="inputEmail4" :placeholder="$t('placeholder_email')" name="email" v-model="email">
                    </div><!--/col-4-->
                    <div class="form-group col-md-8">
                        <label>{{ $t('message') }}</label>
                        <input type="text" class="form-control" id="inputEmail4" :placeholder="$t('message')" name="message" maxlength="2000" v-model="message">
                        <!-- <textarea class="form-control" :placeholder="$t('message')" name="message" maxlength="2000" v-model="message"></textarea> -->
                    </div><!--/col-4-->
                    <div class="form-group col-md-12 mt-3">
                        <!-- <button class="btn btn-outline-primary rounded-0" @click.prevent="storeAppointment">{{ $t('submit') }}</button> -->
                        <input type="submit" id="sad" class="btn btn-outline-primary rounded-0" :value="$t('submit')">
                    </div>
                </form>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                doctors: [],
                departments: [],
                errors: {},
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
            axios.all([
                axios.get('/api/departments')
            ])
            .then(axios.spread((departmentsResponse) => {
                this.departments = departmentsResponse.data;
            })).then((result) => {
                this.depart = this.$route.params.depart_id;
                axios.all([
                    axios.get('/api/department-doctors/'+this.depart),
                ])
                .then(axios.spread((doctorsResponse) => {
                    console.log('doc list');
                    this.doctors = doctorsResponse.data;
                })).then((result) => {
                    this.doc = this.$route.params.doc_id;
                    console.log(this.doc);
                });
            });
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
                    axios.get('/api/departments-doctors/'+this.depart),
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
