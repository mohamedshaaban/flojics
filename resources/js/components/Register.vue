<template>
    <div>
        <section class="inner-content careers-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('nav.register') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('nav.register') }}</h1>
            </div>
            <div class="text-center"><button id="load" class="loadmore"></button></div>
            <div class="container">
                <form class="row mt-3" @submit.prevent="register()">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">{{$t('first_name')}}<span>*</span></label>
                        <input type="text" @keypress="clearErrors()" id="inputEmail4" :placeholder="$t('first_name')"  v-model="user.first_name" name="first_name" class="form-control grey"> <!---->
                        <div v-if="errors && errors.first_name" class="text-danger">{{ errors.first_name[0] }}</div>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">{{$t('last_name')}}<span>*</span></label>
                        <input type="text"  @keypress="clearErrors()" id="inputEmail4" :placeholder="$t('last_name')"  v-model="user.last_name" name="last_name" class="form-control grey"> <!---->
                    <div v-if="errors && errors.last_name" class="text-danger">{{ errors.last_name[0] }}</div>
                    </div>
                    <div class=" form-group col-md-6">
                        <label> {{ $t('pcr-test.civil_id') }} <span class="reqstrike_civil" >**</span></label>
                        <input type="text" pattern="[0-9]{12}" class="form-control grey" id="civil_id" data-index="0" name="civil_id" v-model="user.civil_id" :placeholder="$t('pcr-test.place_civil_id')" minlength="8" maxlength="12" @change="validateCivilId1">

                        <div v-if="errorscivilid" class="text-danger">{{ errorscivilid }}</div>
                        <div v-if="errors && errors.civil_id" class="text-danger">{{ errors.civil_id[0] }}</div>
                    </div>


                    <div class="form-group col-md-6">
                        <label> {{ $t('pcr-test.dob') }} <span>*</span></label>
                        <datepicker format="MM/dd/yyyy"  v-model="user.dob" name="dob"   data-index="0" class="date-picker grey form-control datepicker_dob dobb0"  id="datepicker_dob" :placeholder="$t('pcr-test.place_dob')" @selected="getAge($event,0)"></datepicker>
                        <div v-if="errors && errors.dob" class="text-danger">{{ errors.dob[0] }}</div>

                        <!--<div class="">
                            <input id="datepicker-dob" name="dob"  class="date-picker" type="text" :placeholder="$t('pcr-test.place_dob')" @change="getAge" />
                        </div>-->
                    </div>
                    <div class="form-group col-md-6">
                        <label> {{ $t('pcr-test.age') }} <span>*</span></label>
                        <input id="age" type="number" name="age" v-model="user.age" class="form-control grey" :placeholder="$t('pcr-test.place_age')" maxlength="3"  oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); if (this.value.length > 0) {$("#datepicker_dob").prop("required", false);}else{$("#datepicker_dob").prop("required", true);}'>
                        <div v-if="errors && errors.age" class="text-danger">{{ errors.age[0] }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> {{ $t('pcr-test.gender') }} <span>*</span></label>
                        <select class="form-control grey"   name="gender" v-model="user.gender">
                            <option value="M">{{ $t('pcr-test.male') }}</option>
                            <option value="F">{{ $t('pcr-test.female') }}</option>
                            <option value="U">{{ $t('pcr-test.unknown') }}</option>
                        </select>
                        <div v-if="errors && errors.gender" class="text-danger">{{ errors.gender[0] }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">{{$t('email_id')}} <span>*</span></label>
                        <input type="text"  @keypress="clearErrors()" id="inputEmail4" :placeholder="$t('email_id')"  v-model="user.email" name="email" class="form-control grey"> <!---->
                        <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>

                    </div>
                    <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('phone')}} <span>*</span></label>
                        <input type="tel" maxlength="8" @change="validatePhone" pattern="[569][0-9]{7}"   @keypress="clearErrors()" id="inputEmail4" :placeholder="$t('phone')"  v-model="user.phone" name="phone" class="form-control grey"> <!---->
                        <div v-if="errors && errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
                        <div v-if="errors_mob" class="text-danger">{{ errors_mob }}</div>

                    </div>

                    <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('whatsapp_number')}} <span>*</span></label>
                        <input type="tel"  @change="validateWhatsapp" pattern="[569][0-9]{7}"   @keypress="clearErrors()" id="inputEmail4" :placeholder="$t('whatsapp_number')"  v-model="user.whatsapp_number" name="whatsapp_number" class="form-control grey"> <!---->
                        <div v-if="errors && errors.whatsapp_number" class="text-danger">{{ errors.whatsapp_number[0] }}</div>
                        <div v-if="errors_whatsapp_number" class="text-danger">{{ errors_whatsapp_number }}</div>

                    </div>
                    <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('passport_no')}}<span>**</span></label>
                        <input type="text"  @keypress="clearErrors()" id="inputEmail4" :placeholder="$t('passport_no')" v-model="user.passport_id" name="passport_id" class="form-control grey"> <!---->
                        <div v-if="errors && errors.passport_id" class="text-danger">{{ errors.passport_id[0] }}</div>

                    </div>
                    <div class="form-group col-md-6 mb-0"><label for="exampleInputEmail1">{{ $t('civil_id_passport')}}</label>
                        <div class="upload-file-cvr">
                            <input id="uploadCivilFrontFile"  placeholder="pdf, .doc" disabled="disabled" class="form-control grey">
                            <div class="fileUpload"><span>{{$t('upload')}}</span>

                                <input name="file" @change="onFileChange" type="file"  accept=".pdf, .jpg, .png, .jpeg"  class="upload upload_civil"></div> <!---->
                            <div v-if="errors && errors.file" class="text-danger">{{ errors.file[0] }}</div>

                        </div>
                    </div>
                    <div class="form-group col-md-6 mb-0"><label for="exampleInputEmail1">{{$t('profile_picture')}} </label>
                        <div class="upload-file-cvr">
                            <input id="profile_picture" placeholder=".pdf, .jpg, .png, .jpeg" disabled="disabled" class="form-control grey">
                            <div class="fileUpload"><span>{{$t('upload')}}</span>

                            <input name="filed" @change="onProfileChange" type="file"  accept=".pdf, .jpg, .png, .jpeg"
                                   class="upload upload_profilep">
                            </div> <!---->

                        </div>
                    </div>

                    <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('password')}}<span>*</span></label>
                        <input type="password"  @keypress="clearErrors()" id="inputEmail4"  :placeholder="$t('password')"  v-model="user.password" name="password" class="form-control grey"> <!---->
                        <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>

                    </div>
                    <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('conf_password')}}<span>*</span></label>
                        <input type="password"  @keypress="clearErrors()" id="inputEmail4"  :placeholder="$t('conf_password')"  v-model="user.password_confirmation"  name="password_confirmation" class="form-control grey"> <!---->
                        <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="col-md-12 modal-footer text-center pb-0">
                        <button type="submit" id="sad" class="btn btn-outline-primary">{{ $t('create_account') }}</button>
                        <router-link :to="{name:'login'}"><button type="button" id="sad" class="btn btn-outline-primary">{{ $t('Login') }}</button></router-link>
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
            settings: [0],
            categories: [],
            filterCategory: 0,
            filterCategorySellected: 0,
            category_id: 0,
            errors: {},
            errors_mob: null,
            errors_whatsapp_number: null,
            errorscivilid: null,
            user: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                whatsapp_number: '',
                file: '',
                dob: '',
                age: '',
                civil_id: '',
                passport: '',
                passport_id: '',
                profile_picture: '',
                gender: '',
                password: '',
                password_confirmation: ''
            },
        }
    },
    mounted() {
        axios.all([
            axios.get('/api/categories')
        ])
            .then(axios.spread((categoriesResponse) => {
                this.categories = categoriesResponse.data.data;

            })).then((result) => {
            $("#load").hide();
        });
    },
    updated: function () {

        $('.upload_civil').on('change',function(event){
            var civil_front_files = event.originalEvent.target.files;
            $(this).parent().siblings('#uploadCivilFrontFile').val(civil_front_files[0].name);
        });
        $('.upload_profilep').on('change',function(event){
            var civil_front_files = event.originalEvent.target.files;
            $(this).parent().siblings('#profile_picture').val(civil_front_files[0].name);
        });
    },
    methods: {
        clearErrors(){
            this.errors = null ;
            this.errors_mob = null ;
            this.errors_whatsapp_number = null ;
            this.error = null ;
        },
        validatePhone(event ){
            const arr = ['9', '6', '5'];
            this.errors_mob= null;
            var phone = event.target.value;
              if (!arr.includes(phone[0])) {
                 this.errors_mob = 'Invalid phone number format, it must be 8 numeric digits';
            }
            if( phone.match(/[a-z]/i) || phone.length < 8 )
            {
                this.errors_mob = 'Invalid phone number format, it must be 8 numeric digits';
            }
        },
        validateWhatsapp(event ){
            const arr = ['9', '6', '5'];
            this.errors_whatsapp_number= null;
            var phone = event.target.value;
            //   if (!arr.includes(phone[0])) {
            //      this.errors_whatsapp_number = 'Invalid phone number format';
            // }
            if( phone.match(/[a-z]/i)  )
            {
                this.errors_whatsapp_number = 'Invalid phone number format';
            }
        },
        validateCivilId1(event ){
            //alert(event.target.value);
            var index = (event.target.getAttribute('data-index'));
            var status = false;
            var civilId = event.target.value;

            // 290102705341
            var numbers = /^[0-9]+$/;

            // if(!civilId.match(numbers))
            // {
            //     //alert('Invalid Civil ID....allows only numbers');
            //     status=true;
            // }
            if(civilId.length==12){
                // alert(this.civil_id.includes(civilId));
                var occurance = 0 ;
                var arrayLength = this.user.civil_id.length;
                for (var i = 0; i < arrayLength; i++) {
                    if(this.user.civil_id == civilId)
                    {
                        occurance = occurance+1;
                    }
                    //Do something
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

                    this.errorscivilid = this.$t('pcr-test.invalid_civil_id');

                // this.civil_id[index] = '';
                // this.dob[index] = '';
                // this.age[index] = '';
            }else{

                this.errorscivilid = null ;
                this.getDOBfromCivilID(index);
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

        getDOBfromCivilID(index)
        {
            var civilId = this.user.civil_id;

            if (civilId == '111111111111') {
                return false;
            }
            var dobInputString = civilId.substring(1,7);

            var year = civilId.substring(1,3);
            var month = civilId.substring(3,5);
            var day = civilId.substring(5,7);

            if(!this.validateDateFromCivilID(day,month,year)){
                //alert(' Please Enter Valid Civil ID.');
                this.user.civil_id = '';
                this.user.dob = '';
                this.user.age = '';
                return false;
            }
            if(month == '00' || day == '00'){
                //alert(' Please Enter Valid Civil ID.');
                this.user.civil_id = '';
                this.user.dob = '';
                this.user.age = '';
                return false;
            }
            var curDate = new Date();
            curDate.setHours(0, 0, 0, 0);
            var dobDate = new Date(year, month-1, day);
            dobDate.setHours(0, 0, 0, 0);
            if (curDate < dobDate) {
                //alert(' Please Enter Valid Civil ID.');
                this.user.civil_id = '';
                this.user.dob = '';
                this.user.age = '';
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
// alert(formattedDate);
//             this.user.dob.splice(index, 0,formattedDate);
            this.user.dob = formattedDate;
            // this.groupdob[index] = formattedDate;
            console.log(this.user.dob);

            this.getAgefromDOB(index,formattedDate);
            // if(index ==0 )
            // {
            //     $('.ckg').click();
            //
            //     $('.cks').click();
            // }
            // else
            // {
            //     $('.cks').click();
            //
            //     $('.ckg').click();
            // }
        },
        getAgefromDOB(index,formattedDate)
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
                this.user.age = 0;
            }else{
                this.user.age = age;
            }
        },
        register() {
            console.log(this.user);
            let formData = new FormData();


            formData.append('first_name', this.user.first_name);
            formData.append('last_name', this.user.last_name);
            formData.append('whatsapp_number', this.user.whatsapp_number);
            formData.append('email', this.user.email);
            formData.append('phone', this.user.phone);
            formData.append('file', this.user.file);
            formData.append('dob', this.user.dob);
            formData.append('age', this.user.age);
            formData.append('civil_id', this.user.civil_id);
            formData.append('passport', this.user.passport);
            formData.append('passport_id', this.user.passport_id);
            formData.append('profile_picture', this.user.profile_picture);
            formData.append('gender', this.user.gender);
            formData.append('password', this.user.password);
            formData.append('password_confirmation', this.user.password_confirmation);

            this.axios.post('/api/register', formData ,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(({data}) => {

                        this.$router.push({
                            name: 'regverifiy',
                        });

                })
                .catch((error) => {
                    if (error.response.status === 422) {

                        this.errors = error.response.data.errors || {};
                    }
                });
        },
        searchVacancy(){
            this.vacancies =[];
            let filterQueryString = '';
            let filter = false;
            if(this.filterCategory != 0){
                this.vacanciesFilter = [];
                if(this.filterCategorySellected != this.filterCategory)
                {
                    this.filterCategorySellected = this.filterCategory;
                    this.filterVacancy = 0;
                }
                filterQueryString = 'category='+this.filterCategory;
                filter = true;
            }
            if(this.filterVacancy != 0){
                if(filterQueryString !== ''){
                    filterQueryString += '&';
                }
                filterQueryString += 'vacancy='+this.filterVacancy;
                filter = true;
            }
            if(filterQueryString !== ''){
                filterQueryString = '?'+filterQueryString;
            }
            let  _this = this;
            axios.all([
                axios.get('/api/filter-vacancies/'+filter+filterQueryString),
                axios.get('/api/category-vacancies/'+this.filterCategory),
            ])
                .then(axios.spread((vacanciesResponse,vacanciesFilterResponse) => {
                    this.vacancies = vacanciesResponse.data;
                    this.vacanciesFilter = vacanciesFilterResponse.data;
                })).then((result) => {
                if(Object.keys(this.vacancies).length <= 0){
                    _this.$swal({
                        icon: 'warning',
                        title: this.$t('pop-up.vacancy-warning-title'),
                        text: this.$t('pop-up.vacancy-warning-text'),
                    });
                }
            });
        },
        popVacancy(category_id,id,title){
            this.category_id = category_id;
            this.vacancy_id = id;
            this.vacancy_title = title;
        },
        storeVacancy(){
            $('#sad').attr("disabled", true);
            //Initialize the form data
            let formData = new FormData();

            formData.append('first_name', this.first_name);
            formData.append('last_name', this.last_name);
            formData.append('phone', this.phone);
            formData.append('email', this.email);
            formData.append('vacancy_id', this.vacancy_id);
            formData.append('category_id', this.category_id);
            formData.append('file', this.file[0]);

            /*
              Make the request to the POST /single-file URL
            */
            let  _this = this;

            axios.post('/api/application/store',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(response => {
                _this.$swal({
                    icon: 'success',
                    title: this.$t('pop-up.application-success-title'),
                    text: this.$t('pop-up.application-success-text'),
                }).then((result) => {
                    this.first_name = '';
                    this.last_name ='';
                    this.phone = '';
                    this.email = '';
                    this.vacancy_id = 0;
                    $('#uploadFile').val('');
                    $('.upload').val('');
                    $('.close').click();
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
                        title: this.$t('pop-up.application-warning-title'),
                        text: this.$t('pop-up.application-warning-text'),
                    }).then((result) => {
                        this.first_name = '';
                        this.last_name ='';
                        this.phone = '';
                        this.email = '';
                        this.vacancy_id = 0;
                        $('#uploadFile').val('');
                        $('.upload').val('');
                        $('.close').click();
                        this.errors = {};
                        $('#sad').attr("disabled", false);
                    });
                }
            });
        },
        onFileChange(event) {
            this.user.file = event.target.files[0];
        },
        onProfileChange(event) {
             this.user.profile_picture = event.target.files[0];
         },
        getAge(event,index){
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
            this.user.age = calcul_age;

            console.log(this.user.age);
        },

        getFromLocale(){
            return document.documentElement.lang.substr(0, 2);
        }
    }
}
</script>
