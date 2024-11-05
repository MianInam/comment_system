<template>
    <Nav>

        <div class="content-body">
            <div v-if="Loader" id="preloader">
                <div class="sk-three-bounce">
                    <div class="sk-child sk-bounce1"></div>
                    <div class="sk-child sk-bounce2"></div>
                    <div class="sk-child sk-bounce3"></div>
                </div>
            </div>
            <div v-if="!Loader" class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a data-bs-toggle="tab" class="nav-link active show">Posts</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="my-post-content pt-3">
                                                    <div v-if="role == 'admin'" class="post-input">
                                                        <input type="text" v-model="post.title"
                                                               placeholder="Enter title here"
                                                               class="form-control">
                                                        <p v-if="errors.hasOwnProperty('title')"
                                                           class="errorText">
                                                            {{ errors['title'] }}
                                                        </p>
                                                        <textarea v-model="post.content" name="textarea" id="textarea"
                                                                  cols="30"
                                                                  rows="5" class="form-control bg-transparent"
                                                                  placeholder="Please type what you want...."></textarea>
                                                        <p v-if="errors.hasOwnProperty('content')"
                                                           class="errorText">
                                                            {{ errors['content'] }}
                                                        </p>
                                                        <a href="javascript:void()" class="btn btn-primary"
                                                           @click.prevent="addPost">Post</a>
                                                    </div>
                                                    <div v-for="post in posts"
                                                         class="profile-uoloaded-post border-bottom-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div style="flex: 1">
                                                                <a class="post-title"><h3 class="text-black">
                                                                    {{ post.title }}</h3></a>
                                                                <p>{{ post.content }}</p>
                                                                <router-link
                                                                    :to="{name:'PostsDetail',params: { id: post.id },}">
                                                                    <button class="btn btn-primary me-2"><span
                                                                        class="me-2">
                                                        </span>See Post
                                                                    </button>
                                                                </router-link>
                                                            </div>
                                                            <div :id="'container-' + post.id"
                                                                 class="chart-container"></div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Nav>
</template>

<script>
import HighchartsVue from 'highcharts-vue';
import Highcharts from 'highcharts';

export default {
    components: {highcharts: HighchartsVue.component},
    data() {
        return {
            Loader: true,
            role: '',
            post: {
                title: '',
                content: '',
            },
            errors: {},
            posts: {}
        };
    },
    methods: {
        chart(id, positive, negative, neutral) {
            console.log(positive, negative, neutral, id)
            Highcharts.chart('container-' + id, {
                chart: {
                    type: 'pie',
                    height: 200, // Set a smaller height
                    width: 200, // Set a smaller width
                    custom: {},
                    events: {
                        render() {
                            //
                        }
                    }
                },
                title: {
                    text: '' // Set an empty title
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },


                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 2,
                        dataLabels: [{
                            enabled: false,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -17,
                            format: '{point.percentage:.0f}%',
                            style: {
                                fontSize: '15px'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    colorByPoint: true,
                    innerSize: '50%',
                    data: [{
                        name: 'Positive',
                        y: positive,
                        color: "#00e272"
                    }, {
                        name: 'Negative',
                        y: negative,
                        color: "#fe6a35"
                    }, {
                        name: 'Neutral',
                        y: neutral,
                        color: "#a6a6a6"
                    }]
                }]
            });

        },
        addPost() {
            this.errors = {}
            this.axios
                .post(this.$baseUrl + "/api/post/create", this.post, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                            "Content-Type": "application/json",
                        }
                    },
                )
                .then((response) => {
                    console.log(response)
                    this.$swal({
                        title: "Success!",
                        text: "Post Added successfully!",
                        type: "success",
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
                    const total = {
                        positive:0,
                        negative:0,
                        neutral:0
                    }
                    location.reload()
                    this.post.title = ''
                    this.post.content = ''
                })
                .catch((error) => {
                    console.log(error.response.data.status);
                    if (error.response.data.message === "Unauthenticated.") {
                        localStorage.clear();
                        setTimeout(() => {
                            this.$router.push({name: "Login"});
                        }, 1000);
                    }
                    const errorData = error.response.data.message;
                    this.errors = {}
                    for (const field in errorData) {
                        this.errors[field] = errorData[field][0];
                    }
                });
        },
        fetchSentiments(comments) {
            this.axios
                .post(this.$sentimentsBaseUrl + "/analyze_posts", {posts: comments}, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then((response) => {
                    console.log("Response:", response.data);
                    this.posts = response.data.data.posts

                    this.posts.map((post) => {
                        let sum = post.total.positive + post.total.negative + post.total.neutral
                        this.chart(post.id, this.fetchPercentage(post.total.positive,sum),
                            this.fetchPercentage(post.total.negative,sum),
                            this.fetchPercentage(post.total.neutral,sum))
                    })
                })
                .catch((error) => {
                    console.error("Error:", error);
                    // Handle error response
                });
        },
        fetchPercentage(value,sum){
            return sum/100*value;
        },
        fetchPosts() {
            this.axios
                .get(this.$baseUrl + "/api/post/list", {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                            "Content-Type": "application/json",
                        }
                    },
                )
                .then((response) => {
                    console.log(response)
                    this.posts = response.data.data
                    this.fetchSentiments(this.posts)
                    setTimeout((e) => {
                        // this.posts.map((post) => {
                        //     this.fetchSentiments(post.comments)
                        //     this.chart(post.id)
                        // })
                    }, 1000)
                    this.Loader = false
                })
                .catch((error) => {
                    console.log(error.response.data.status);
                    this.Loader = false
                    if (error.response.data.message === "Unauthenticated.") {
                        localStorage.clear();
                        setTimeout(() => {
                            this.$router.push({name: "Login"});
                        }, 1000);
                    }
                });
        },
    },

    mounted() {
        this.role = localStorage.getItem('role')
        this.fetchPosts();
        //     setTimeout((e)=>{
        //         this.chart()
        //     },1000)
    }
}
</script>
<style>


</style>
