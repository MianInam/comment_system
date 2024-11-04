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
                                            <li class="nav-item"><a  data-bs-toggle="tab" class="nav-link active show">Posts</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="my-post-content pt-3">
                                                    <div v-if="role == 'admin'" class="post-input">
                                                        <input type="text" v-model="post.title" placeholder="Enter title here"
                                                               class="form-control">
                                                        <p v-if="errors.hasOwnProperty('title')"
                                                           class="errorText">
                                                            {{ errors['title'] }}
                                                        </p>
                                                        <textarea v-model="post.content" name="textarea" id="textarea" cols="30"
                                                                  rows="5" class="form-control bg-transparent"
                                                                  placeholder="Please type what you want...."></textarea>
                                                        <p v-if="errors.hasOwnProperty('content')"
                                                           class="errorText">
                                                            {{ errors['content'] }}
                                                        </p>
                                                        <a href="javascript:void()" class="btn btn-primary" @click.prevent="addPost">Post</a>
                                                    </div>
                                                    <div v-for="post in posts" class="profile-uoloaded-post border-bottom-1 pb-5">
                                                        <a class="post-title" href="post-details.html"><h3 class="text-black">{{post.title}}</h3></a>
                                                        <p>{{post.content}}</p>
                                                        <router-link :to="{name:'PostsDetail',params: { id: post.id },}"><button class="btn btn-primary me-2"><span class="me-2">
                                                        </span>See Post</button></router-link>
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

export default {
    data() {
        return {
            Loader: false,
            role:'',
            post:{
                title:'',
                content:'',
            },
            errors:{},
            posts:{}
        };
    },
    methods: {
        addPost(){
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
                    this.posts.unshift(response.data.data)

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
        fetchPosts(){
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
                })
                .catch((error) => {
                    console.log(error.response.data.status);
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
    }
}
</script>
<style>

</style>
