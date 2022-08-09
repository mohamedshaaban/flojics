<template>
    <header v-if="Object.keys(this.settings).length > 0">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="ml-auto">
                        <div class="d-flex">


                             <ul  class="soc"  v-if="this.loggedUser">
                                 <router-link class="ar" :to="{ name: 'profile', params: { lang: getFromLocale() }}"><span style="  text-decoration: underline;"> {{ $t('Welcome') }} {{ this.loggedUser.name }}&nbsp;</span>
                                     <img :src='`/uploads/`+this.loggedUser.profile_picture' class="profilimg ar" v-if="this.loggedUser.profile_picture!=`[object File]`" />
                                     <img src='/uploads/profilepic.png' class="profilimg ar" v-else />

                                 </router-link>

                                <a href="javascript:void(0)" @click="logout()" class="ar">{{ $t('Logout') }}</a>
                            </ul>
                            <ul  class="soc" v-else>
                                <router-link class="ar" :to="{ name: 'login', params: { lang: getFromLocale() }}">{{ $t('Login_Regiter') }}</router-link>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex ali">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="navbar-brand" href="#">
                    <div class="logo">
                        <router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">
                            <img src="/images/logo.png">
                        </router-link>
                    </div>
                </div>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li :class="['nav-item dropdown ',
                        ['/'+getFromLocale()+'/management-message','/'+getFromLocale()+'/page/our-story','/'+getFromLocale()+'/page/experience-weshare','/'+getFromLocale()+'/page/vision-mission-values','/'+getFromLocale()+'/board-directors','/'+getFromLocale()+'/executive-management','/'+getFromLocale()+'/bod','/'+getFromLocale()+'/why-wara'].includes(currentPage) ? activeClass : '']">

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div v-for="wara_menu in wara_menus" :key="wara_menu.id">
                                            <router-link :to="'/'+getFromLocale()+wara_menu.url" class="dropdown-item">
                                                {{ wara_menu.name }}
                                            </router-link>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'appointment', params: { lang: getFromLocale() }}" class="nav-link">
                               {{ $t('bookan') }} {{ $t('appointment') }}
                            </router-link>
                        </li>
                        <li v-for="header_menu in header_menus" :key="header_menu.id" :class="['nav-item',currentPage.includes(header_menu.word_activ)?activeClass:'']">
                            <router-link :to="'/'+getFromLocale()+header_menu.url" class="nav-link">
                                {{ header_menu.name }}
                            </router-link>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>

    </header>
</template>

<script>
import Auth from '../../Auth.js';

export default {
        name: "Header",

        data() {
            return {
                loggedUser: this.auth.user,
                settings: [0],
                 wara_menus: [],
                header_menus: [],
                 activeClass: 'active',
                search: ''
            }
        },
        beforeMount:  function () {
             var url_lang = this.$route.params.lang;

        },
        mounted() {
            this.loggedUser =  this.auth.user;
            console.log('mounted');

            axios.all([
                axios.get('/api/contact-settings'),
                axios.get('/api/wara-menus'),
                axios.get('/api/header-menus'),
            ])
            .then(axios.spread((settingsResponse,waraMenusResponse,headerMenusResponse) => {
                this.settings = settingsResponse.data;
                this.wara_menus = waraMenusResponse.data;
                this.header_menus = headerMenusResponse.data;
            }));
        },
        computed:{
            currentPage(){
                return this.$route.path;
            },
        },

        methods: {
            logout() {
                this.axios.post('/api/logout')
                    .then(({data}) => {
                        Auth.logout(); //reset local storage
                        window.location.href = '/login';
                        this.$router.push('/login');
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            },
            getToLocale(){
                if(document.documentElement.lang.substr(0, 2) == 'en'){
                    return 'ar';
                }
                return 'en';
            },

            Find(search) {
                let selectedLang = this.getFromLocale();
                this.$router.push({name: 'search', params: {lang: selectedLang, q: search}});
                location.reload();
            },
        }

    }
</script>

