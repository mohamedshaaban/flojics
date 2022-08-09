<template>
    <div>

        <footer>
            <div class="container">

            </div>
        </footer>
    </div>
</template>

<script>

    export default {
        name: "Footer",

        data() {
            return {
                settings: [0],
                current_year:new Date().getFullYear(),
                footer_menus: [],
            }
        },
        mounted() {
            axios.all([
                axios.get('/api/contact-settings'),
                axios.get('/api/footer-menus')
            ])
            .then(axios.spread((settingsResponse,footerMenusResponse) => {
                this.settings = settingsResponse.data;
                this.footer_menus = footerMenusResponse.data;
            }));
        },
        computed: {
            footerMenusChunks(){
                return _.chunk(Object.values(this.footer_menus), 5);
            }
        },
        methods: {
            getFromLocale(){
                return document.documentElement.lang.substr(0, 2);
            },

        }

    }
</script>




