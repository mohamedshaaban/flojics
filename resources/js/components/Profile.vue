<template>
    <div>
        <section class="inner-content careers-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('nav.profile') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('nav.profile') }}</h1>
            </div>
            <div class="text-center"><button id="load" class="loadmore"></button></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 left" style="margin: unset !important;padding: unset;">
                        <nav class="navbar navbar-collpase-lg navbar-light bg-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContentprofile" aria-controls="navbarSupportedContentprofile" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div id="navbarSupportedContentprofile" class="collapse show navbar-collapse" style="">
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
                 <form class=" mt-3 row"  @submit.prevent="updateProfile()">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">{{ $t('first_name')}} <span>*</span></label>
                        <input type="text" id="inputEmail4" disabled :placeholder="$t('first_name')" required="required" v-model="user.first_name" name="first_name" class="form-control grey"> <!---->
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">{{ $t('last_name')}} <span>*</span></label>
                        <input type="text" id="inputEmail4" disabled :placeholder="$t('last_name')"  required="required" v-model="user.last_name" name="last_name" class="form-control grey"> <!----></div>
                     <div class="form-group col-md-6">
                         <label for="exampleInputEmail1">{{$t('email_id')}} <span>*</span></label>
                         <input type="text" id="inputEmail4" :placeholder="$t('email_id')" required="required" v-model="user.email"   name="email" class="form-control grey"> <!---->
                         <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>

                     </div>
                     <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('phone')}}<span>*</span></label>
                         <input type="tel"  @change="validatePhone"  maxlength="8" pattern="[569][0-9]{7}"  id="inputEmail4" placeholder="Phone Number" required="required" v-model="user.phone"    name="phone" class="form-control grey"> <!---->
                         <div v-if="errors && errors.phone" class="text-danger">{{ errors.phone[0] }}</div>
                         <div v-if="errors_mob" class="text-danger">{{ errors_mob }}</div>

                     </div>
                     <div class="form-group col-md-6" style="display: none"><label for="exampleInputEmail1">{{$t('whatsapp_number')}}</label>
                         <input type="tel"  @change="validateWhatsapp"  pattern="[569][0-9]{7}"  id="inputEmail4" placeholder="Phone Number"   v-model="user.whatsapp_number"    name="whatsapp_number" class="form-control grey"> <!---->
                         <div v-if="errors && errors.whatsapp_number" class="text-danger">{{ errors.whatsapp_number[0] }}</div>
                         <div v-if="errors_whatsapp_number" class="text-danger">{{ errors_whatsapp_number }}</div>

                     </div>



                    <div class="form-group col-md-6 mb-0"><label for="exampleInputEmail1">{{ $t('pass_civil')}} </label>
                        <div class="upload-file-cvr"><input id="uploadFile" placeholder="pdf, .doc" disabled="disabled" class="form-control grey">
                            <div class="fileUpload"><span>{{$t('upload')}}</span>
                                <input name="civil_file" type="file" disabled accept=".pdf, .doc"  class="upload upload_civil"></div> <!---->
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

                    <div class="col-md-12 modal-footer text-center pb-0">
                        <button type="submit" id="sad" class="btn btn-outline-primary">{{$t('submit')}}</button>
                    </div>
                </form>
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
            user: {},
            settings: [0],
            categories: [],
            filterCategory: 0,
            filterCategorySellected: 0,
            filterVacancy: 0,
            vacancy_title: '',
            vacancy_id: 0,
            category_id: 0,
            errors: {},
            first_name : '',
            last_name : '',
            email : '',
            phone : '',
            file : '',
            errors_mob : null,
            errors_whatsapp_number : null,
        }
    },
    mounted() {
        this.user = this.auth.user,
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
        $('meta[name=title]').attr('content', this.meta_settings[0].careers_meta_title);
        $('meta[name=keywords]').attr('content', this.meta_settings[0].careers_meta_keywords);
        $('meta[name=description]').attr('content', this.meta_settings[0].careers_meta_description);
        $('#title').html(this.meta_settings[0].careers_meta_title);
        $('.upload_profilep').on('change',function(event){
            var civil_front_files = event.originalEvent.target.files;
            $(this).parent().siblings('#profile_picture').val(civil_front_files[0].name);
        });
        $('.upload').on('change',function(event){
            var files = event.originalEvent.target.files;
            $(this).parent().siblings('#uploadFile').val(files[0].name);
            $(this).parent().siblings('#uploadFile1').val(files[0].name);
        });
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
            if( phone.match(/[a-z]/i) )
            {
                this.errors_whatsapp_number = 'Invalid phone number format';
            }
        },
        onProfileChange(event) {
            this.user.profile_picture = event.target.files[0];
        },
        updateProfile() {
            console.log(this.user);
            let formData = new FormData();

            $('#load').show();
            $('#sad').attr("disabled", true);

            formData.append('email', this.user.email);
            formData.append('phone', this.user.phone);
            formData.append('whatsapp_number', this.user.whatsapp_number);
            formData.append('profile_picture', this.user.profile_picture);

            this.axios.post('/api/updateprofile',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(({data}) => {
                    this.user = data.user;
                    this.$router.push({
                        name: 'profile',
                    });

                })
                .catch((error) => {
                    if (error.response.status === 422) {

                        this.errors = error.response.data.errors || {};
                    }
                });
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
            this.file = event.target.files;
            console.log(event.target.files);
        },
        getFromLocale(){
            return document.documentElement.lang.substr(0, 2);
        }
    }
}
</script>
