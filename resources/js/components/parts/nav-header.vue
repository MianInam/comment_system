<template>

    <div class="nav-header d-flex justify-content-center align-items-center">

            <h3>Comment System</h3>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">

                        </div>
                    </div>
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                                <div class="header-info">
                                    <span class="text-black"><strong>{{name}}</strong></span>
                                    <p class="fs-12 mb-0">{{role}}</p>
                                </div>
                                <img :src="image != 'null' ? imageBaseURL+image : staticImage" width="20" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <router-link to="/profile" class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span class="ms-2">Profile </span>
                                </router-link>
                                <a href="" @click.prevent="logout" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                         width="18" height="18" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span class="ms-2">Logout </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li :class="{'mm-active': isActive1}" v-if="role == 'admin'" @click="setActive()">
                    <router-link to="/dashboard">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Dashboard</span>

                    </router-link>
                </li>
                <li :class="{'mm-active': isActive2}" @click="setActive()">
                    <router-link to="/posts">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Posts</span>
                    </router-link>
                </li>
            </ul>

        </div>
    </div>

    <slot></slot>
    <Footer/>
</template>
<script>
export default {
    data(){
        return{
            imageBaseURL:this.$imageBaseUrl,
            role: '',
            name: '',
            image:null,
            staticImage:'/images/profile/conimg2.png'
        }
    },
    mounted() {
        this.role = localStorage.getItem("role");
        this.name = localStorage.getItem("name");
        this.image = localStorage.getItem("image");
    },
    methods: {
        logout() {
            this.axios
                .post(this.$baseUrl + "/api/logout", {}, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                            "Content-Type": "application/json",
                        }
                    },
                )
                .then((response) => {
                    console.log(response)
                    localStorage.clear();
                    this.$router.push({ name: 'Login'})
                })
                .catch((error) => {
                    console.log(error.response.data.status);
                    if(error.response.data.message === "Unauthenticated.") {
                        localStorage.clear();
                        setTimeout(() => {
                            this.$router.push({name: "Login"});
                        }, 1000);
                    }
                });
        }
    },
}
</script>
