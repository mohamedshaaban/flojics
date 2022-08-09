<template>
    <div>
        <section class="inner-content details-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item"><router-link :to="{ name: 'departments', params: { lang: getFromLocale() }}">{{ $t('nav.our_departments') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ department.name }}</li>
                </ol>
                <div class="text-center"><button id="load" class="loadmore"></button></div>
                <!-- <div class=" ">
                    <h1 class="main-head">{{ department.name }}</h1>
                    <div class=" " v-html='department.description'>
                            {{ department.description }}
                    </div>
                </div> -->
                <div class=" col-md-12">
                    <div class="container_all apart-hns">
                        <video class="rounded-lg container__image" controls v-if="department.desc_video != null">
                            <source :src="'/'+department.desc_video">
                        </video>
                        <img class="rounded-lg container__image" v-else-if="department.desc_image != null" :src="'/'+department.desc_image">
                        <div class="container__text">
                            <h1 class="main-head">{{ department.name }}</h1>
                            <p v-html='department.description'>{{ department.description }}</p>
                        </div>
                    </div>
                </div>
                <div class="innerspage-slider" v-if="Object.keys(this.doctors).length > 0">
                    <h3>{{ $t('our_doctors') }}</h3>
                    <div class="inner-slider carousel-main">
                        <div class="item" v-for="doctor in doctors" :key="doctor.id">
                            <router-link :to="{ name: 'doctors_details', params: { lang: getFromLocale(), id: doctor.slug}}" class="box">
                                <div class="img"><img :src="'/'+doctor.picture"></div>
                                <div class="data">
                                    <span>{{ doctor.name }}</span>
                                    <strong>{{ doctor.specialty.name }}</strong>
                                </div>
                            </router-link>
                        </div><!--/item-->
                    </div>
                </div>
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
                department: [0],
                doctors: []
            }
        },
        mounted() {
            this.id = this.$route.params.id;
            axios.all([
                axios.get('/api/departments/'+this.id),
                axios.get('/api/departments-doctors/'+this.id)
            ])
            .then(axios.spread((departmentsResponse,doctorsResponse) => {
                this.department = departmentsResponse.data;
                this.doctors = doctorsResponse.data;
            })).then((result) => {
                $("#load").hide();
            });
        },
        watch: {
            beforeRouteEnter(to, from, next) {
                this.id = to.params.id;
            }
        },
        updated: function () {
            $('.carousel-main').slick({
                loop: true,
                autoplay: true,
                autoplayTimeout: 300,
                items: 12 ,
                singleItem: true,
                nav: false,
                dots: false,
                slidesToShow: 4,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });

            $('meta[name=title]').attr('content', this.department.meta_title);
            $('meta[name=keywords]').attr('content', this.department.meta_keywords);
            $('meta[name=description]').attr('content', this.department.meta_description);
            $('#title').html(this.department.meta_title);
        },
        methods: {
            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            }
        }
    }
</script>
