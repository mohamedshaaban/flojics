<template>
    <div>

        <section class="departments">
            <div class="row d-md-flex">
                <div class="col-md-4 col-lg-3 fixed-image pr-0">
                    <div class="heading">
                        <h2><span>{{ $t('our') }}</span>{{ $t('departments') }}</h2>
                        <p v-html='settings[0].department_description'>{{ settings[0].department_description }}</p>
                        <router-link :to="{ name: 'departments', params: { lang: getFromLocale() }}" class="btn btn-primary" tabindex="0">{{ $t('read_more') }}</router-link>
                    </div>
                </div>
                <div class="col-md-8 col-lg-9 pl-0 pr-0">
                    <div class="department-slide" v-if="Object.keys(this.departments).length > 0">
                        <div class="item" v-for="chunk in departmentChunks" :key="chunk.id">
                            <div class="d-block">
                                <div class="flex-container">
                                    <div class="flex-slide" v-for="department in chunk" :key="department.id">
                                        <img :src="'/'+department.image">
                                        <span class="heading-btm"><h3>{{ department.name }}</h3></span>
                                        <div class="heading-top">
                                            <h2>{{ department.name }}</h2>
                                            <p v-html='department.short_description'>{{ department.short_description }}</p>
                                            <router-link :to="{ name: 'departments_details', params: { lang: getFromLocale(),id: department.slug }}" class="btn btn-primary">{{ $t('learn_more') }}</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/item-->
                    </div>
                </div>
            </div>
        </section>
        <section class="our-doctors">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-10 offset-md-1 text-center">
                        <h2>{{ $t('our_doctors') }}</h2>
                        <p v-html='settings[0].doctor_description'>{{ settings[0].doctor_description }}</p>
                        <router-link :to="{ name: 'doctors', params: { lang: getFromLocale() }}" class="more">{{ $t('learn_more_doctors') }}</router-link>
                    </div>
                </div>
            </div>
            <div class="ourDoctors-slide" v-if="Object.keys(this.doctors).length > 0">
                <div class="item" style="width: 50%; display: inline-block;" v-for="(doctorchunk,index1) in doctorChunks" :key="index1">
                    <div href="#" v-for="(doctor,index2) in doctorchunk" :key="index2" :class="(index1%2 == 0)?'Dr Dr'+(index2+1):'Dr Dr'+(index2+6)">
                        <span class="img"><img :src="'/'+doctor.picture"></span>
                        <span class="data">
                            <h5>{{ doctor.name }}</h5>
                            <h6>{{  doctor.specialty.name  }}</h6>
                            <router-link :to="{ name: 'doctors_details', params: { lang: getFromLocale(), id: doctor.slug}}" class="view-more">{{ $t('view_details') }}</router-link>
                        </span>
                    </div><!--/dr-->
                </div><!--/.item-->
            </div>
        </section>

    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
import _ from 'lodash';

export default {
    components: { VueSlickCarousel },
    data(){
        return {
            sliders: [],
            settings: [0],
            sitesettings: [0],
            departments: [],
            doctors: [],


        }
    },
    mounted() {

        axios.all([
             axios.get('/api/home-settings'),
            axios.get('/api/home-departments'),
            axios.get('/api/home-doctors'),
            axios.get('/api/contact-settings')

        ])
            .then(axios.spread((settingsResponse,departmentsResponse,doctorsResponse,contactResponse) => {
                this.settings   = settingsResponse.data;
                this.departments = departmentsResponse.data;
                this.doctors   = doctorsResponse.data;
                this.sitesettings = contactResponse.data;

            })).then((result) => {
            $("#load").hide();

        });




    },
    computed: {

        departmentChunks(){
            return _.chunk(Object.values(this.departments), 3);
        },
        doctorChunks(){
            return _.chunk(Object.values(this.doctors), 5);
        },
        player() {
            return this.$refs.youtube
        }
    },
    updated: function () {


        // Global this for player video
        var $this = this;



        $('.department-slide').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 2000,
            slidesToShow: 1,
        });

        $(".ourDoctors-slide").slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 1000,
            autoplay: true,
            pauseOnHover: false,
            autoplaySpeed: 7000,
            slidesToShow: 1,
            slidesToScroll: 1,
            rows:1,
            slidesPerRow:2,
            fade: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        slidesPerRow:1
                    }
                }
            ]
        });


        var slideWrapper = $(".carousel-main"),
            iframes = slideWrapper.find('.embed-player'),
            lazyImages = slideWrapper.find('.slide-image'),
            lazyCounter = 0;



// DOM Ready
        $(function() {
            // Initialize



        });

    },


    methods: {
        openModal () {
            if (document.readyState == "complete") {

                setTimeout($('#MAINMODAL').modal(), 20000);

            }
        },
        getFromLocale(){
            return document.documentElement.lang.substr(0, 2);
        }

    }
}
</script>

