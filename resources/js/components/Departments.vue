<template>
    <div>
        <section class="inner-content department-page">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{ name: 'home', params: { lang: getFromLocale() }}">{{ $t('nav.home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('nav.our_departments') }}</li>
                </ol>
                <div class="main-head-cvr">
                    <h1 class="main-head">{{ $t('nav.our_departments') }}</h1>
                    <select class="form-control ml-auto" v-model="filterDepartment"  @change="departmentsFilter()">
                        <option value="0" >{{ $t('choose_department') }}</option>
                        <option v-for="department in departments_filter" :key="department.id" :value="department.id" >
                            {{department.name}}
                        </option>
                    </select>
                </div>
                <ul class="row list">
                    <li class="col-md-6 col-lg-4 col-xl-3"  v-for="department in departments" :key="department.id">
                        <div class="dep-box">
                        <img :src="'/'+department.image">
                        <span class="heading-btm"><h3>{{ department.name }}</h3></span>
                        <div class="heading-top">
                            <h2>{{ department.name }}</h2>
                            <p v-html='department.short_description'>{{ department.short_description }}</p>
                            <router-link :to="{ name: 'departments_details', params: { lang: getFromLocale(),id: department.slug }}" class="btn btn-primary" tabindex="0">{{ $t('learn_more') }}</router-link>
                        </div>
                        </div>
                    </li><!--/li-->
                </ul>
                <div class="text-center"><button id="next" class="loadmore"></button></div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                departments: [],
                departments_filter: [],
                filterDepartment: 0,
            }
        },
        mounted() {
            axios.all([
                axios.get('/api/departments'),
                axios.get('/api/list-departments')
            ])
            .then(axios.spread((departmentsResponse,departmentsListResponse) => {
                this.departments = departmentsResponse.data;
                this.departments_filter = departmentsListResponse.data;
            }));
        },
        updated: function () {

            $(document).ready(function(){
                var list = $(".list li");
                var numToShow = 12;
                var button = $("#next");
                var numInList = list.length;
                list.hide();
                if (numInList > numToShow) {
                    button.show();
                }else{
                    button.hide();
                }
                list.slice(0, numToShow).show();

                $(window).scroll(function () {
                    if ($(window).scrollTop() >= $(document).height() - $(window).height() - $('footer').height() ) {
                        var showing = list.filter(':visible').length;
                        list.slice(showing - 1, showing + numToShow).fadeIn();
                        var nowShowing = list.filter(':visible').length;
                        if (nowShowing >= numInList) {
                            button.hide();
                        }
                    }
                });
            });
        },
        methods: {
            departmentsFilter(){
                this.departments =[];
                axios.all([
                    axios.get('/api/filter-departments/'+this.filterDepartment),
                ])
                .then(axios.spread((departmentsResponse) => {
                    this.departments = departmentsResponse.data;
                }));
            },
            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            }
        }
    }
</script>
