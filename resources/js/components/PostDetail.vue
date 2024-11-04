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
                        <div class="card">
                            <div class="card-body">
                                <div class="post-details">
                                    <h3 class="mb-2 text-black">{{post.title}}</h3>
                                    <ul class="mb-4 post-meta d-flex flex-wrap">
                                        <li class="post-author me-3">By Admin</li>
                                        <li class="post-date me-3"><i class="far fa-calendar-plus me-2"></i>{{formatDate(post.created_at)}}</li>
                                        <li class="post-comment"><i class="far fa-comment me-2"></i>{{post.comments?.length}}</li>
                                    </ul>
                                    <p>{{post.content}}</p>
                                    <div class="col-xl-12 col-xxl-12 col-lg-12">
                                        <div v-if="post.comments?.length > 0" class="card border-0 pb-0">
                                            <div class="card-header border-0 pb-0">
                                                <h4 class="card-title">Comments</h4>
                                            </div>
                                            <div class="card-body p-0">
                                                <div id="DZ_W_Todo3" class="widget-media my-4 px-4 ">
                                                    <ul class="timeline">
                                                        <li v-for="comment in post.comments">
                                                            <div class="timeline-panel">

                                                                <div class="media-body">
                                                                    <h5 class="mb-1">{{comment.user.name}} <small class="text-muted">29 July 2020</small></h5>
                                                                    <p class="mb-1">{{comment.comment}}</p>
<!--                                                                    <a href="#" class="btn btn-primary btn-xxs shadow">Reply</a>-->
<!--                                                                    <a href="#" class="btn btn-outline-danger btn-xxs">Delete</a>-->
                                                                </div>
<!--                                                                <div class="dropdown">-->
<!--                                                                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown">-->
<!--                                                                        <svg width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>-->
<!--                                                                    </button>-->
<!--                                                                    <div class="dropdown-menu dropdown-menu-end">-->
<!--                                                                        <a class="dropdown-item" href="#">Edit</a>-->
<!--                                                                        <a class="dropdown-item" href="#">Delete</a>-->
<!--                                                                    </div>-->
<!--                                                                </div>-->
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="card border-0 pb-0">
                                            <div class="card-header border-1">
                                                <h4 class="card-title">No Comments</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment-respond" id="respond">
                                        <h4 class="comment-reply-title text-primary mb-3" id="reply-title">Leave a Comment </h4>
                                        <form class="comment-form" id="commentform" method="post">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="comment" class="text-black font-w600">Comment</label>
                                                        <textarea rows="4" class="form-control" v-model="comment" name="comment" placeholder="Comment" id="comment"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="submit" value="Post Comment" @click.prevent="addComment" class="submit btn btn-primary" id="submit" name="submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
            errors: {},
            Loader: false,
            id:'',
            post:{},
            comment:""
        };
    },
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getUTCDate();
            const month = date.toLocaleString('en-GB', { month: 'short', timeZone: 'UTC' });
            const year = date.getUTCFullYear();
            return `${day} ${month} ${year}`;
        },
        addComment(){
            this.errors = {}
            this.axios
                .post(this.$baseUrl + "/api/comment/create", {post_id:this.id,comment:this.comment}, {
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
                        text: "Comment Added successfully!",
                        type: "success",
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
                    console.log(response.data.data)
                    this.post.comments.unshift(response.data.data)
                    this.comment = ''
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
        fetchPostDetail(id){
            this.axios
                .get(this.$baseUrl + "/api/post/show/"+id, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                            "Content-Type": "application/json",
                        }
                    },
                )
                .then((response) => {
                    console.log(response)
                    this.post = response.data.data
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
        this.id =this.$route.params.id;
        this.fetchPostDetail(this.id)
    }
}
</script>
