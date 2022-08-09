<template>
    <div>
        <div class="inner-banner" v-if="settings[0].banner_doctor">
            <img :src="'/'+settings[0].banner_doctor">
            <div class="container search-dr">
                <h4>{{ $t('search_doctor') }}</h4>
                <div class="d-block">
                    <div class="col">
                        <select class="form-control" v-model="filterDepartment" @change="departmentsFilter()">
                            <option value="0">{{ $t('by_department') }}</option>
                            <option v-for="department in departments" :key="department.id" :value="department.id" >
                                {{department.name}}
                            </option>
                        </select>
                    </div><!--/col-->
                    <div class="col">
                        <select class="form-control" v-model="filterDoctor">
                            <option value="0" >{{ $t('choose_doctor') }}</option>
                            <option v-for="doctor in doctors_filter" :key="doctor.id" :value="doctor.id">
                                {{doctor.name}}
                            </option>
                        </select>
                    </div><!--/col-->
                    <div class="col">
                        <select class="form-control" v-model="filterGender">
                            <option value="" >{{ $t('gender') }}</option>
                            <option value="M" >{{ $t('male') }}</option>
                            <option value="F" >{{ $t('female') }}</option>
                        </select>
                    </div><!--/col-->

                    <div class="col">
                        <button class="btn btn-primary" @click.prevent="searchDoctor">{{ $t('submit') }}</button>
                    </div><!--/col-->
                </div>
            </div>
        </div>
        <div class="browse-by">
            <div class="container">
                <div class="input-group mb-3 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
                    <input type="text" class="form-control dccs" :placeholder=" $t('search_name') " name="name" v-model="name">
                    <div class="input-group-append">
                        <button class="btn" type="button" id="" @click.prevent="searchNameDoctor"><img src="/images/search.png"></button>
                    </div>
                </div>
                <h4>{{ $t('browse_first_name') }}</h4>
                <ul class="alphabet" v-if="getFromLocale() == 'en'">
                    <li><a href="#" @click.prevent="searchLetterDoctor('A')">A</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('B')">B</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('C')">C</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('D')">D</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('E')">E</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('F')">F</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('G')">G</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('H')">H</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('I')">I</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('J')">J</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('K')">K</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('L')">L</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('M')">M</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('N')">N</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('O')">O</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('P')">P</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('Q')">Q</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('R')">R</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('S')">S</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('T')">T</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('U')">U</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('V')">V</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('W')">W</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('X')">X</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('Y')">Y</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('Z')">Z</a></li>
                </ul>
                <ul class="alphabet" v-if="getFromLocale() == 'ar'">
                    <li><a href="#" @click.prevent="searchLetterDoctor('أ')">أ</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ب')">ب</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ت')">ت</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ث')">ث</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ج')">ج</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ح')">ح</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('خ')">خ</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('د')">د</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ذ')">ذ</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ر')">ر</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ز')">ز</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('س')">س</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ش')">ش</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ص')">ص</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ض')">ض</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ط')">ط</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ظ')">ظ</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ع')">ع</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('غ')">غ</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ف')">ف</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ق')">ق</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ك')">ك</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ل')">ل</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('م')">م</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ن')">ن</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ه')">ه</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('و')">و</a></li>
                    <li><a href="#" @click.prevent="searchLetterDoctor('ي')">ي</a></li>
                </ul>
            </div>
        </div>
        <section class="inner-content with-bnr doctors-page">
            <div class="container">
                <h1 class="main-head">{{ $t('nav.our_doctors') }}</h1>
                <div class="text-center"><button id="load" class="loadmore"></button></div>
                <p v-html='settings[0].body_doctor'>{{ settings[0].body_doctor }}</p>

                <div class="doctors-category" id="doctors" v-for="(department_doctors, name) in doctors_list" :key="department_doctors.id">
                    <h4>{{ name }}</h4>
                    <div class="row cvr">
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3" v-for="doctor in orderBy(department_doctors,'id')" :key="doctor.id">
                            <div class="box">
                                <div class="img">
                                    <img :src="'/'+doctor.picture">
                                    <router-link :to="{ name: 'doctors_details', params: { lang: getFromLocale(), id: doctor.slug}}" class="btn">{{ $t('view_profile') }}</router-link>
                                </div>
                                <div class="data">
                                    <span class="blue">{{ doctor.name }}</span>
                                    <strong>{{ doctor.specialty.name }}</strong>
                                    <router-link :to="{ name: 'appointment_doctors', params: { lang: getFromLocale() ,depart_id: doctor.department_id,doc_id: doctor.id}}" class="book">{{ $t('book_appointment') }}</router-link>
                                </div>
                            </div>
                        </div><!--/col-->
                    </div>
                </div> <!--/.doctors-category-->
            </div>
        </section>
    </div>
</template>

<script>
    import Vue2Filters from 'vue2-filters';
    export default {
        mixins: [Vue2Filters.mixin],
        data(){
            return {
                settings: [0],
                doctors_list: [],
                doctors_filter: [],
                departments: [],
                filterDepartment: 0,
                filterDoctor: 0,
                filterGender: '',
                filterLanguage: 0,
                name: '',
                letter: ''
            }
        },
        mounted() {
            axios.all([
                axios.get('/api/doctor-settings'),
                axios.get('/api/doctors'),
                axios.get('/api/departments'),
                axios.get('/api/doctors_departments')
            ])
            .then(axios.spread((settingsResponse,doctorsFilterResponse,departmentsResponse,doctorDepartmentsResponse) => {
                this.doctors_list = doctorDepartmentsResponse.data;
                this.doctors_filter = doctorsFilterResponse.data;
                this.departments = departmentsResponse.data;
                this.settings = settingsResponse.data;
            })).then((result) => {
                $("#load").hide();
            });
        },
        updated: function () {

        },
        methods: {
            searchDoctor(){

                this.doctors_list =[];
                let  _this = this;
                let filterQueryString = '';
                let filter = false;
                if(this.filterDepartment != 0){
                    filterQueryString = 'department='+this.filterDepartment;
                    filter = true;
                }
                if(this.filterDoctor != 0){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'doctor='+this.filterDoctor;
                    filter = true;
                }
                if(this.filterGender != ''){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'gender='+this.filterGender;
                    filter = true;
                }
                if(this.filterLanguage != 0){
                    if(filterQueryString !== ''){
                        filterQueryString += '&';
                    }
                    filterQueryString += 'language='+this.filterLanguage;
                    filter = true;
                }

                if(filterQueryString !== ''){
                    filterQueryString = '?'+filterQueryString;
                }

                axios.all([
                    axios.get('/api/filter-doctors/'+filter+filterQueryString),
                ])
                .then(axios.spread((doctorsResponse) => {
                    this.doctors_list = doctorsResponse.data;
                })).then((result) => {
                    if(Object.keys(this.doctors_list).length > 0){
                        document.getElementById("doctors").scrollIntoView();
                    }else{
                        _this.$swal({
                            icon: 'warning',
                            title: this.$t('pop-up.doctor-warning-title'),
                            text: this.$t('pop-up.doctor-warning-text'),
                        });
                    }
                });
            },

            searchNameDoctor(){
                this.doctors_list =[];
                let  _this = this;
                if(this.name != ''){
                    axios.all([
                        axios.get('/api/name-doctors/'+this.name),
                    ])
                    .then(axios.spread((doctorsResponse) => {
                        this.doctors_list = doctorsResponse.data;
                    })).then((result) => {
                        if(Object.keys(this.doctors_list).length > 0){
                            document.getElementById("doctors").scrollIntoView();
                        }else{
                            _this.$swal({
                                icon: 'warning',
                                title: this.$t('pop-up.doctor-warning-title'),
                                text: this.$t('pop-up.doctor-warning-text'),
                            });
                        }
                    });
                }
            },

            searchLetterDoctor(letter){
                this.doctors_list =[];
                let  _this = this;
                axios.all([
                    axios.get('/api/letter-doctors/'+letter),
                ])
                .then(axios.spread((doctorsResponse) => {
                    this.doctors_list = doctorsResponse.data;
                })).then((result) => {
                    if(Object.keys(this.doctors_list).length > 0){
                        document.getElementById("doctors").scrollIntoView();
                    }else{
                        _this.$swal({
                            icon: 'warning',
                            title: this.$t('pop-up.doctor-warning-title'),
                            text: this.$t('pop-up.doctor-warning-text'),
                        });
                    }
                });
            },

            departmentsFilter(){

                this.doctors_filter =[];

                axios.all([
                    axios.get('/api/departments-doctors/'+this.filterDepartment),
                ])
                .then(axios.spread((doctorsResponse) => {
                    this.doctors_filter = doctorsResponse.data;
                }));
            },

            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            }
        }
    }
</script>
