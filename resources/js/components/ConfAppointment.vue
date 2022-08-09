<template>
    <div>
        <section class="inner-content drApntmnt-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('dr_appointment') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('dr_appointment') }}</h1>
                <strong>{{ $t('request_appointment') }}</strong><br />


                <div id="book-app" v-if="showTime" class="bookappointment bookconfappointment confAppt">
                    <router-link to="#">
                         <i><img src="/images/icon1.png"></i>

                        <span><center><h2 style="color: red;text-align: center;margin: 0 0 0 70%;">{{time}}</h2></center></span>
                        <span style="color: white">{{ $t('paid_alert_time') }}</span>
                    </router-link>
                 </div>

                <form class="row mt-3" @submit.prevent="storeAppointment">
                    <div v-if="loggedUser" class="form-group col-md-12">
                        <a href="#" style="display: none" class="groupck"></a>
                        <div class="row"><div class="form-group col-md-12 q-col"><div class="question-hold"><div class="q-sec"><h2>{{$t('self_other')}}</h2> <ul><li>
                            <div class="radio-container"><label class="checkbox">
                            {{$t('self')}}<input type="radio" name="pcr_single" @click="filldata(0)"  value="0" class="question-chk cks"    > <span class="checkmark-checkbox"></span></label></div></li> <li><div class="radio-container"><label class="checkbox">{{$t('other')}}
                            <input type="radio" name="pcr_single" @click="filldata(1)" value="1" class="question-chk ckg"  >
                            <span class="checkmark-checkbox"></span></label></div></li></ul></div> </div></div>
                        </div></div>


                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">{{ $t('choose_department') }} <span>*</span></label>
                        <select class="form-control" disabled required v-model="depart" @change="departmentsDoctors()">
                            <option value="" >{{ $t('choose_department') }}</option>
                            <option v-for="department in departments" :key="department.id" :value="department.id" >
                                {{department.name}}
                            </option>
                        </select>
                        <div v-if="errors && errors.department_id" class="text-danger">{{ errors.department_id[0] }}</div>
                    </div><!--/col-4-->

                    <div class="form-group col-md-4">
                        <label id="doctor_id" for="exampleInputEmail1">{{ $t('doctor_name') }} <span>*</span></label>
                        <select2 name="doctor_id" disabled :placeholder="$t('doctor_name')" :options="doctors" v-model="doc" required >

                        </select2>
                        <div v-if="errors && errors.doctor_id" class="text-danger">{{ errors.doctor_id[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('preffered_date_time') }} </label>
                        <div class="full_width">
                            <input disabled type="text"  class="form-control" :placeholder="$t('placeholder_date_time')" name="preffered_date" v-model="preffered_date" />
                        </div>
                    </div><!--/col-4-->

                    <div class="form-group col-md-4">
                        <label>{{ $t('first_name') }} <span>*</span></label>
                        <input type="text" class="form-control"  :placeholder="$t('first_name')" required name="name" v-model="name">
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('last_name') }} <span>*</span></label>
                        <input type="text" class="form-control"  :placeholder="$t('last_name')" required name="last_name" v-model="last_name">
                        <div v-if="errors && errors.last_name" class="text-danger">{{ errors.last_name[0] }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('passport_no') }} <span>**</span></label>
                        <input type="text" class="form-control" :placeholder="$t('passport_no')"  id="passport_no" name="passport_no" v-model="passport_no" maxlength="15">
                        <div v-if="errorpassport_civil" class="text-danger">{{ errorpassport_civil }}</div>
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('phone') }} <span>*</span></label>
                        <input type="hidden" name="book_id" required v-model="book_id">
                        <input type="tel" maxlength="8"  @change="validatePhone"  pattern="[569][0-9]{7}" class="form-control"  :placeholder="$t('phone')" name="phone_number" required v-model="phone_number">
                        <div v-if="errors && errors.phone_number" class="text-danger">{{ errors.phone_number[0] }}</div>
                        <div v-if="errors_mob" class="text-danger">{{ errors_mob }}</div>

                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('whatsapp_number') }} <span>*</span></label>
                        <input type="tel"  @change="validateWhatsapp"  pattern="[569][0-9]{7}" class="form-control"  :placeholder="$t('whatsapp_number')" name="whatsapp_number" required v-model="whatsapp_number">
                        <div v-if="errors && errors.whatsapp_number" class="text-danger">{{ errors.whatsapp_number[0] }}</div>
                        <div v-if="errors_whatsapp_number" class="text-danger">{{ errors_whatsapp_number }}</div>

                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label>{{ $t('civil_id') }} <span>**</span></label>

                        <input type="text" pattern="[0-9]{12}" class="form-control" id="civil_id"  name="civil_id" v-model="civil_id" :placeholder="$t('pcr-test.place_civil_id')" minlength="8" maxlength="12" @change="validateCivilId1">
                        <div v-if="errorpassport_civil" class="text-danger">{{ errorpassport_civil }}</div>

                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label> {{ $t('pcr-test.dob') }} <span>*</span></label>
                        <datepicker format="MM/dd/yyyy"   v-model="dob" name="dob" required=""   class="date-picker form-control datepicker_dob dobb0"  id="datepicker_dob" :placeholder="$t('pcr-test.place_dob')" @selected="getAge($event)"></datepicker>
                        <!--<div class="">
                            <input id="datepicker-dob" name="dob" required="" class="date-picker" type="text" :placeholder="$t('pcr-test.place_dob')" @change="getAge" />
                        </div>-->
                        <div v-if="errors && errors.dob" class="text-danger">{{ errors.dob }}</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label> {{ $t('pcr-test.age') }} <span>*</span></label>
                        <input id="age" type="number" :name="age" v-model="age" class="form-control age" :placeholder="$t('pcr-test.place_age')" maxlength="3" required="" oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); if (this.value.length > 0) {$("#datepicker_dob").prop("required", false);}else{$("#datepicker_dob").prop("required", true);}'>
                        <div v-if="errors && errors.age" class="text-danger">{{ errors.age }}</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>{{ $t('email_id') }} </label>
                        <input type="email" class="form-control"  :placeholder="$t('placeholder_email')" name="email" v-model="email">
                    </div><!--/col-4-->
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> {{ $t('pcr-test.gender') }} <span>*</span></label>
                        <select class="form-control" required name="gender" v-model="gender" >
                            <option value="M">{{ $t('pcr-test.male') }}</option>
                            <option value="F">{{ $t('pcr-test.female') }}</option>
                            <option value="U">{{ $t('pcr-test.unknown') }}</option>
                        </select>
                        <div v-if="errors && errors.gender" class="text-danger">{{ errors.gender }}</div>
                    </div>

                    <div class="form-group col-md-8">
                        <label>{{ $t('message') }}</label>
                        <input type="text" class="form-control"  :placeholder="$t('message')" name="message" maxlength="2000" v-model="message">
                        <!-- <textarea class="form-control" :placeholder="$t('message')" name="message" maxlength="2000" v-model="message"></textarea> -->
                    </div><!--/col-4-->


                    <div class="form-group col-md-12 mt-3">
                        <!-- <button class="btn btn-outline-primary rounded-0" @click.prevent="storeAppointment">{{ $t('submit') }}</button> -->
                        <input type="submit" id="sad" class="btn btn-outline-primary rounded-0" :value="$t('pay')">
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
                loggedUser: this.auth.user,
                doctors: [],
                departments: [],
                errors: {},
                errors_mob: null,
                errors_whatsapp_number: null,

                selected_declerations : [],

                book_id: '',
                name : '',
                last_name : '',
                passport_no: '',
                phone_number : '',
                whatsapp_number : '',
                civil_id : '',
                dob : '',
                age : '',
                email : '',
                gender : '',
                message : '',
                errorpassport_civil : '',

                depart: '',
                doc: '',
                preffered_date: '',
                reserved_time:0,
                showTime:true,

                date:  moment(60 * 0  * 1000)


            }
        },
        updated: function () {

        },
        computed: {
            time: function(){
                return this.date.format('mm:ss');
            }
        },
        mounted() {

            this.appID = this.$route.params.id;




            axios.all([
                axios.get('/api/departments'),
                axios.get('/api/appoiment-department-confirm-doctors/'+this.appID),
                axios.get('/api/appointment/confirmation/'+this.appID)

            ])
                .then(axios.spread((departmentsResponse,doctorsResponse,appointmentResponse) => {
                    this.departments = departmentsResponse.data;
                    this.doctors = doctorsResponse.data;
                    this.book_id = appointmentResponse.data.id;
                    this.depart = appointmentResponse.data.department_id;
                    this.doc = appointmentResponse.data.doctor_id;
                    this.reserved_time = appointmentResponse.data.reserved_time;
                    this.date = moment(60 * this.reserved_time * 1000);
                    this.preffered_date = appointmentResponse.data.preffered_date+' '+appointmentResponse.data.appointment_time+' '+appointmentResponse.data.end_time;
                    this.countDownTimer();

                }));

        },
        watch: {
            beforeRouteEnter(to, from, next) {
                this.otp = to.params.otp;
            }
            },

        methods: {
            validatePhone(event ){
                const arr = ['9', '6', '5'];
                this.errors_mob= null;
                var phone = event.target.value;
                if (!arr.includes(phone[0])) {
                    this.errors_mob = 'Invalid phone number format, it must be 8 numeric digits';
                }
                if( phone.match(/[a-z]/i) || phone.length < 8 )
                {
                    alert(2);
                    this.errors_mob = 'Invalid phone number format, it must be 8 numeric digits';
                }
            },
            validateWhatsapp(event ){
                const arr = ['9', '6', '5'];
                this.errors_whatsapp_number= null;
                var phone = event.target.value;
                // if (!arr.includes(phone[0])) {
                //     this.errors_whatsapp_number = 'Invalid phone number format';
                // }
                if( phone.match(/[a-z]/i)  )
                {
                    this.errors_whatsapp_number = 'Invalid phone number format';
                }
            },
            filldata(val)
            {

                if(!val)
                {
                    this.name = this.loggedUser.first_name;
                    this.last_name = this.loggedUser.last_name;
                    this.passport_no = this.loggedUser.passport_id;
                    this.phone_number = this.loggedUser.phone;
                    this.whatsapp_number = this.loggedUser.whatsapp_number;
                    this.dob = this.loggedUser.dob;
                    this.email = this.loggedUser.email;
                    this.civil_id = this.loggedUser.civil_id;
                    this.gender = this.loggedUser.gender;
                    this.age = this.loggedUser.age;
                }
                else
                {
                    this.name = '';
                    this.last_name = '';
                    this.passport_no = '';
                    this.phone_number = '';
                    this.dob = '';
                    this.email = '';
                    this.civil_id = '';
                    this.gender = '';
                    this.age = '';
                }
            },
            countDownTimer() {

                 setInterval(() => {
                this.redirectAfterTime();
                }, 1000);
            },
            redirectAfterTime(){

                this.date = moment(this.date.subtract(1, 'seconds'));
                if(this.time ==  '00:00' )
                {
                    this.showTime = false ;
                    let formData = new FormData();

                    formData.append('book_id', this.book_id);

                    this.$swal.fire({
                        title: 'Waiting time is over! You will be redirected to the appointment page.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('/api/appointment/delete',
                                formData,
                                {
                                    headers: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                }
                            ).then(response => {
                                this.$router.push({
                                    name: 'appointment',
                                });

                            })
                            ;
                        }
                    });
                }
            },
            validateDateFromCivilID(day,month,year){
                console.debug("addEditPatient.js:validateDate starts..");

                var leap = "";
                if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)){
                    leap = 1;
                }
                if(parseInt(month,10) > 12 )return false;
                if ((month == "02") && (leap == 1) && (day > 29)) return false;
                if ((month == "02") && (leap != 1) && (day > 28)) return false;

                /* Validation of other months */
                if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))){
                    return false;
                }
                if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))){
                    return false;
                }

                console.debug("addEditPatient.js:validateDate end.");
                return true;
            },
            addDecleration(id){
                //alert(event.target.value);
                if(this.selected_declerations.includes(id))
                {
                    this.selected_declerations.splice(this.selected_declerations.indexOf(event), 1);
                }
                else
                {
                    this.selected_declerations.push(id);
                }
            },
            storeAppointment(){
                this.errorpassport_civil = null;
                this.errordecleration = null;
                if(this.passport_no == '' && this.civil_id == '')
                {
                    this.errorpassport_civil = this.$t('invalid_passport_civil');
                    return;
                }


                $('#sad').attr("disabled", true);
                //Initialize the form data
                let formData = new FormData();
                 if(this.auth.user)
                {
                    formData.append('user_id', this.auth.user.id);
                }
                formData.append('book_id', this.book_id);
                formData.append('name', this.name);
                formData.append('last_name', this.last_name);
                formData.append('passport_no', this.passport_no);
                formData.append('phone_number', this.phone_number);
                formData.append('whatsapp_number', this.whatsapp_number);
                formData.append('civil_id', this.civil_id);
                formData.append('email', this.email);
                formData.append('age', this.age);
                formData.append('dob', this.dob);
                formData.append('gender', this.gender);
                formData.append('message', this.message);
                formData.append('selected_declerations', this.selected_declerations);

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
                    window.location.href = response.data;


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

                        });
                    }
                });
            },
            getAge(event){
                //             console.log(event.target);
//             var index = (event.target.getAttribute('data-index'));
                var today = new Date();
                var birthDate = new Date(event);
                var calcul_age = today.getFullYear() - birthDate.getFullYear();

                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    calcul_age--;
                }
                if(calcul_age <= 0){ calcul_age = 0;}
                this.age = calcul_age;
                console.log(this.age);
            },
            validatePassport(event ){
                var status = false;
                var passport = (event.target.value).toUpperCase();
                // this.errorspassport = '';
                console.log(passport);
                if(passport==''){
                    return ;
                }
                var occurance = 0 ;
                var arrayLength = this.passport_no.length;
                for (var i = 0; i < arrayLength; i++) {
                    console.log(this.passport_no[i].toUpperCase()+' - '+passport.toUpperCase());
                    if(this.passport_no[i].toUpperCase() == passport.toUpperCase())
                    {
                        occurance = occurance+1;
                    }
                    //Do something
                }
                if(occurance<=1)
                {
                    this.errorspassport = '';
                }
                else
                {
                    this.errorspassport = this.$t('pcr-test.passport_repeated');
                    this.passport_no.splice( 1);
                }

                // }
            },
            getDOBfromCivilID()
            {
                var civilId = this.civil_id;

                if (civilId == '111111111111') {
                    return false;
                }
                var dobInputString = civilId.substring(1,7);

                var year = civilId.substring(1,3);
                var month = civilId.substring(3,5);
                var day = civilId.substring(5,7);

                if(!this.validateDateFromCivilID(day,month,year)){
                    //alert(' Please Enter Valid Civil ID.');
                    this.civil_id = '';
                    this.dob = '';
                    this.age = '';
                    return false;
                }
                if(month == '00' || day == '00'){
                    //alert(' Please Enter Valid Civil ID.');
                    this.civil_id = '';
                    this.dob = '';
                    this.age = '';
                    return false;
                }
                var curDate = new Date();
                curDate.setHours(0, 0, 0, 0);
                var dobDate = new Date(year, month-1, day);
                dobDate.setHours(0, 0, 0, 0);
                if (curDate < dobDate) {
                    //alert(' Please Enter Valid Civil ID.');
                    this.civil_id = '';
                    this.dob = '';
                    this.age = '';
                    return false;
                }

                var monthName = ["01","02","03","04","05","06","07","08","09","10","11","12"];
                month = monthName[month-1];

                // var currentYear = getServerDate().split("-")[2];
                var currYearInt = 0;
                var currentYear = new Date().getFullYear();
                currentYear = currentYear.toString();
                currentYear = currentYear.substring(2,4);
                currYearInt = parseInt(currentYear,10);

                if( (parseInt(year,10) >= 0) && ((currYearInt + 1) > year) )year = "20"+ year;
                else year = "19" + year;

                var formattedDate = year+"-"+month +"-"+day;
                this.dob = formattedDate;
                console.log(this.dob);

                this.getAgefromDOB(formattedDate);

            },
            getAgefromDOB(formattedDate)
            {
                var dateString = formattedDate;
                // alert(dateString);
                var today = new Date();
                var birthDate = new Date(dateString);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
                {
                    age--;
                }
                if(age == -1){
                    this.age = 0;
                }else{
                    this.age = age;
                }
            },
            validateCivilId1(event ){
                //alert(event.target.value);
                var status = false;
                var civilId = event.target.value;
                 // 290102705341
                var numbers = /^[0-9]+$/;

                if(!civilId.match(numbers))
                {
                    //alert('Invalid Civil ID....allows only numbers');
                    status=true;
                }
                if(civilId.length==12){
                    // alert(this.civil_id.includes(civilId));
                    var occurance = 0 ;
                    var arrayLength = this.civil_id.length;
                    for (var i = 0; i < arrayLength; i++) {
                        if(this.civil_id[i] == civilId)
                        {
                            occurance = occurance+1;
                        }
                        //Do something
                    }
                    if(occurance>1)
                    {
                        this.errorscivilid = this.$t('pcr-test.civil_id_repeated');

                        status=true;
                        return ;

                    }
                }
                if(civilId.length != 11){
                    //alert('Invalid Civil ID....enter only 12 characters');
                    status=true;
                }
                if(Number(civilId.substr(0,1)) == Number(0) || Number(civilId.substr(0,1)) > Number(3)){
                    //alert('Invalid Civil ID....1st number');
                    status=true;
                }
                if(Number(civilId.substr(3,2)) == Number(0) || Number(civilId.substr(3,2)) > Number(12)){
                    //alert('Invalid Civil ID....month');
                    status=true;
                }
                if(Number(civilId.substr(5,2)) == Number(0) || Number(civilId.substr(5,2)) > Number(31)){
                    //alert('Invalid Civil ID....days');
                    status=true;
                }
                if(Number(civilId.substr(3,2)) == Number(2) && Number(civilId.substr(5,2)) == Number(29) && Number(civilId.substr(5,2))%4 != Number(0)){
                    //alert('Invalid Civil ID....leap year');
                    status=true;
                }
                var dgt1 =          Number(civilId.substr(0,1))*2;
                var dgt2  = dgt1  + Number(civilId.substr(1,1))*1;
                var dgt3  = dgt2  + Number(civilId.substr(2,1))*6;
                var dgt4  = dgt3  + Number(civilId.substr(3,1))*3;
                var dgt5  = dgt4  + Number(civilId.substr(4,1))*7;
                var dgt6  = dgt5  + Number(civilId.substr(5,1))*9;
                var dgt7  = dgt6  + Number(civilId.substr(6,1))*10;
                var dgt8  = dgt7  + Number(civilId.substr(7,1))*5;
                var dgt9  = dgt8  + Number(civilId.substr(8,1))*8;
                var dgt10 = dgt9  + Number(civilId.substr(9,1))*4;
                var dgt11 = dgt10 + Number(civilId.substr(10,1))*2;
                var sum = Math.floor(dgt11/11);
                var modsum = Math.floor(dgt11%11);
                var dgt12 = Math.floor(11-modsum);

                if(Number(civilId.substr(11,1)) == dgt12){
                    //alert("valid");
                    status=false;
                }else{
                    //alert("invalid");
                    status=true;
                }

                if(status == true){
                    if(civilId.length==12)
                    {
                        this.errorscivilid = this.$t('pcr-test.invalid_civil_id');
                    }
                }else{

                    this.errorscivilid = null ;

                    this.getDOBfromCivilID();
                }
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
