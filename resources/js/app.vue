<template>
    <div >
        <!--header Section Start Here-->
            <Header></Header>
        <!--/header Section End Here-->


            <router-view :key="$route.params.pathMatch"></router-view>
        <!--footer Section Start Here-->
            <Footer></Footer>
        <!--footer Section End Here-->
    </div>
</template>

<script>
    import Header from "./components/layout/Header";
    import Footer from "./components/layout/Footer";
    export default {
        components: {Footer, Header},
        updated: function () {
            this.$nextTick(function () {
                console.log('scrollto');
                window.top.window.scrollTo(0,0);
            })
        },
        computed:{
            currentPage(){
                return this.$route.path;
            },
        },
        methods:{
            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            }
        }
    }
</script>
