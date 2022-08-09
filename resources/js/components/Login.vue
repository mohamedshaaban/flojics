<template>
    <div>
        <section class="inner-content careers-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('nav.login') }}</li>
                </ol>
                <h1 class="main-head">{{ $t('nav.login') }}</h1>
            </div>
             <div class="text-center"><button id="load" class="loadmore"></button></div>
            <div class="container">

                <div v-if="this.error" class="text-danger">{{ this.error }}</div>

                <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('civil_id_passport')}}<span>**</span></label>
                    <input type="text"  @keypress="clearErrors()" id="inputEmail4"  v-model="user.civil_id" :placeholder="$t('civil_id_passport')" required="required" name="phone" class="form-control grey"> <!---->
                           <div v-if="errors && errors.civil_id" class="text-danger">{{ errors.civil_id[0] }}</div>
                       </div>
                    <div class="form-group col-md-6"></div>
                    <div class="form-group col-md-6"><label for="exampleInputEmail1">{{$t('password')}}<span>*</span></label>
                        <input type="password"  @keypress="clearErrors()" id="inputEmail4"  v-model="user.password" :placeholder="$t('password')" required="required" name="phone" class="form-control grey"> <!---->
                        <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>

                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <router-link :to="{name:'resetpass'}" style="margin: 0 0 0 15px;"   class="link-active">{{ $t('reset_password') }}</router-link>

                </div>
                    </div>
                    <div class="col-md-12 modal-footer text-center pb-0">
                        <button type="button" id="sad" class="btn btn-outline-primary"  @click="login">{{ $t('Login')}}</button>
                        <router-link :to="{name:'register'}"><button type="button" id="sad" class="btn btn-outline-primary">{{ $t('create_account') }}</button></router-link>


                    </div>

            </div>
        </section>
    </div>
</template>

<script>
import Auth from '../Auth.js';
export default {
    data(){
        return {
            user: {
                civil_id: '',
                password: '',
            },
            settings: [0],
            categories: [],
            filterCategory: 0,
            filterCategorySellected: 0,

            category_id: 0,
            errors: {},
            error : '',
            first_name : '',
            last_name : '',
            civil_id : '',
            phone : '',
            file : '',
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

        $('.upload').on('change',function(event){
            var files = event.originalEvent.target.files;
            $(this).parent().siblings('#uploadFile').val(files[0].name);
            $(this).parent().siblings('#uploadFile1').val(files[0].name);
        });
    },
    methods: {
        clearErrors(){
            this.errors = null ;
            this.error = null ;
        },
        login() {
            this.axios.post('/api/login', this.user)
                .then(({data}) => {
                    Auth.login(data.access_token,data.user); //set local storage
                    // Simulate a mouse click:
                    window.location.href = '/'+this.$i18n.locale+'/profile';
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.error = null;

                        this.errors = error.response.data.errors || {};
                    }
                    else
                    {
                        this.errors = null;
                        this.error = error.response.data.errors;
                    }

                });
        },

        getFromLocale(){
            return document.documentElement.lang.substr(0, 2);
        }
    }
}
</script>
