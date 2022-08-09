<template>

    <section class="inner-content drDetails-page">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{ name: 'doctors', params: { lang: getFromLocale() }}">{{ $t('nav.our_doctors') }}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{ doctor.name }}</li>
            </ol>
            <div class="text-center"><button id="load" class="loadmore"></button></div>
            <div class="row">
                <div class="col-md-4" v-if="doctor.picture">
                    <div class="dr-pic"><img :src="'/'+doctor.picture"></div>
                </div>
                <div class="col-md-8" v-if="doctor.name">
                    <h4>{{ doctor.name }}</h4>
                    <span class="design" v-if="doctor.specialty">{{ doctor.specialty.name }}</span>
                    <p v-html='doctor.brief'>{{ doctor.brief }}</p>
                    <div class="experience" v-if="doctor.experience_description != '' && doctor.experience_description != null">
                        {{ $t('experience') }}<br>
                        <span v-if="doctor.working_date != '' && doctor.working_date != null"><strong>{{ doctor.experience }}</strong> {{ $t('years') }}</span>
                        <p v-html='doctor.experience_description'>{{ doctor.experience_description }}</p>
                    </div>

                    <div class="certi">
                        {{ $t('education') }}
                        <span v-html='doctor.education'>{{ doctor.education }}</span>
                    </div>

                    <div class="achievments" v-if="doctor.achievments != '' && doctor.achievments != null">
                        {{ $t('achievments') }}<br>
                        <p v-html='doctor.achievments'>{{ doctor.achievments }}</p>
                    </div>
                    <div class="certi" v-if="doctor.certificates != '' && doctor.certificates != null">
                        {{ $t('certificates') }}<br>
                        <span v-html='doctor.certificates'>{{ doctor.certificates }} </span>
                    </div>
                    <router-link :to="{ name: 'appointment_doctors', params: { lang: getFromLocale(), depart_id: doctor.department_id, doc_id: doctor.id }}" class="btn btn-primary">{{ $t('book_appointment') }}</router-link>
                </div>
            </div>
        </div>
    </section>

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
                doctor: []
            }
        },

        mounted() {
            this.id = this.$route.params.id;
            axios.all([
                axios.get('/api/doctors/'+this.id)
            ])
            .then(axios.spread((doctorsResponse) => {
                this.doctor = doctorsResponse.data.data;
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
            });

            $('meta[name=title]').attr('content', this.doctor.meta_title);
            $('meta[name=keywords]').attr('content', this.doctor.meta_keywords);
            $('meta[name=description]').attr('content', this.doctor.meta_description);
            $('#title').html(this.doctor.meta_title);
        },
        methods: {
            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            }
        }
    }
</script>
