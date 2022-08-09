<template>
    <div>
        <h1 class="main-head">{{ $t('nav.new_activities') }}</h1>
        <div class="row">
            <div class="col-lg-6">
                <div class="news-box" v-if="featureds_first.id">
                    <img :src="'/'+featureds_first.image">
                    <a :data-target="'#textmdl'+featureds_first.id" data-toggle="modal" class="data light-g p-30">
                        <div>
                            <h4> {{ featureds_first.title }}</h4>
                            <span class="date">{{ featureds_first.date }}</span>
                        </div>
                    </a>
                </div>
            </div><!--/col-6-->
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12" v-if="featureds_second.id">
                        <div class="news-box s245" >
                            <img :src="'/'+featureds_second.image">
                            <a :data-target="'#textmdl'+featureds_second.id" data-toggle="modal" class="data dark-g">
                                <div>
                                    <h5> {{ featureds_second.title }}</h5>
                                    <span class="date">{{ featureds_second.date }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="featureds_third.id">
                        <div class="news-box h92">
                            <img :src="'/'+featureds_third.image">
                            <a :data-target="'#textmdl'+featureds_third.id" data-toggle="modal" class="data dark-g">
                                <div>
                                    <h6> {{ featureds_third.title }}</h6>
                                    <span class="date">{{ featureds_third.date }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6" v-if="featureds_fourth.id">
                        <div class="news-box h92">
                            <img :src="'/'+featureds_fourth.image">
                            <a :data-target="'#textmdl'+featureds_fourth.id" data-toggle="modal" class="data dark-g">
                                <div>
                                    <h6> {{ featureds_fourth.title }}</h6>
                                    <span class="date">{{ featureds_fourth.date }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div><!--/col-6-->
        </div><!--row-->
        <hr>
        <div class="row">
            <div class="col-md-6" v-for="activity in activities" :key="activity.id">
                <div class="news-box2 d-lg-flex align-items-md-center">
                    <div class="img mr-lg-4"><a :data-target="'#textmdl'+activity.id" data-toggle="modal"><img :src="'/'+activity.image"></a></div>
                    <a :data-target="'#textmdl'+activity.id" data-toggle="modal" class="data">
                        <h4>{{ activity.title }}</h4>
                        <span class="date">{{ activity.date }}</span>
                        <p>{{ activity.short_description }} </p>
                    </a>
                </div>
            </div><!--col-md-6-->
        </div>

        <!-- Modal news -->
        <div class="modal news-modl" :id="'textmdl'+featureds_first.id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <h4>{{ featureds_first.title }}</h4>

                        <video width="100%" height="500" controls v-if="featureds_first.desc_video != null">
                            <source :src="'/'+featureds_first.desc_video">
                        </video>
                        <img v-else-if="featureds_first.desc_image != null" :src="'/'+featureds_first.desc_image">
                        <p v-else v-html='featureds_first.description'>{{featureds_first.description}}</p>
                    </div>
                    <button type="button" class="btn-prev"></button>
                    <button type="button" class="btn-next"></button>
                </div>
            </div>
        </div>
        <!-- Modal news -->
        <div class="modal news-modl" :id="'textmdl'+featureds_second.id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <h4>{{ featureds_second.title }}</h4>

                        <video width="100%" height="500" controls v-if="featureds_second.desc_video != null">
                            <source :src="'/'+featureds_second.desc_video">
                        </video>
                        <img v-else-if="featureds_second.desc_image != null" :src="'/'+featureds_second.desc_image">
                        <p v-else v-html='featureds_second.description'>{{featureds_second.description}}</p>
                    </div>
                    <button type="button" class="btn-prev"></button>
                    <button type="button" class="btn-next"></button>
                </div>
            </div>
        </div>
        <!-- Modal news -->
        <div class="modal news-modl" :id="'textmdl'+featureds_third.id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <h4>{{ featureds_third.title }}</h4>

                        <video width="100%" height="500" controls v-if="featureds_third.desc_video != null">
                            <source :src="'/'+featureds_third.desc_video">
                        </video>
                        <img v-else-if="featureds_third.desc_image != null" :src="'/'+featureds_third.desc_image">
                        <p v-else v-html='featureds_third.description'>{{featureds_third.description}}</p>
                    </div>
                    <button type="button" class="btn-prev"></button>
                    <button type="button" class="btn-next"></button>
                </div>
            </div>
        </div>
        <!-- Modal news -->
        <div class="modal news-modl" :id="'textmdl'+featureds_fourth.id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <h4>{{ featureds_fourth.title }}</h4>

                        <video width="100%" height="500" controls v-if="featureds_fourth.desc_video != null">
                            <source :src="'/'+featureds_fourth.desc_video">
                        </video>
                        <img v-else-if="featureds_fourth.desc_image != null" :src="'/'+featureds_fourth.desc_image">
                        <p v-else v-html='featureds_fourth.description'>{{featureds_fourth.description}}</p>
                    </div>
                    <button type="button" class="btn-prev"></button>
                    <button type="button" class="btn-next"></button>
                </div>
            </div>
        </div>
        <!-- Modal news -->
        <div class="modal news-modl" v-for="activity in activities" :key="activity.id" :id="'textmdl'+activity.id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-body">
                        <h4>{{ activity.title }}</h4>

                        <video width="100%" height="500" controls v-if="activity.desc_video != null">
                            <source :src="'/'+activity.desc_video">
                        </video>
                        <img v-else-if="activity.desc_image != null" :src="'/'+activity.desc_image">
                        <p v-else v-html='activity.description'>{{activity.description}}</p>
                    </div>
                    <button type="button" class="btn-prev"></button>
                    <button type="button" class="btn-next"></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "News",
        data(){
            return {
                featureds_first: [0],
                featureds_second: [0],
                featureds_third: [0],
                featureds_fourth: [0],
                activities: []
            }
        },
        mounted() {
            axios.all([
                axios.get('/api/activities-first-featured'),
                axios.get('/api/activities-second-featured'),
                axios.get('/api/activities-third-featured'),
                axios.get('/api/activities-fourth-featured'),
                axios.get('/api/activities')
            ])
            .then(axios.spread((featuredFirstResponse,featuredSecondResponse,featuredThirdResponse,featuredFourthResponse,activitiesResponse) => {
                this.activities = activitiesResponse.data.data;
                this.featureds_first = featuredFirstResponse.data.data;
                this.featureds_second = featuredSecondResponse.data.data;
                this.featureds_third = featuredThirdResponse.data.data;
                this.featureds_fourth = featuredFourthResponse.data.data;
            }));
        },
        methods: {
        }
    }
</script>
