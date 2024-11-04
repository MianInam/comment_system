<template>
    <div class="authincation h-100 mt-5">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <h3 class="text-white">Comment System</h3>
                                    </div>
                                    <h4 class="text-center mb-4 text-white">Create your account</h4>
                                    <form action="" @submit.prevent="signup">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Name</strong></label>
                                            <input type="text" v-model="form.name" class="form-control" placeholder="Enter your name here">
                                            <p class="error email"></p>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Email</strong></label>
                                            <input type="email" v-model="form.email" class="form-control" placeholder="Enter your email here">
                                            <p class="error email"></p>
                                        </div>
                                        <div class="form-group position-relative">
                                            <label class="mb-1 text-white"><strong>Password</strong></label>
                                            <input :type="inputType" v-model="form.password" id="dz-password" class="form-control" placeholder="Enter your password here">
                                            <span style="cursor: pointer;" class="eye" @click="togglePasswordVisibility">

												<i v-show="!showPassword" class="fa fa-eye-slash"></i>
												<i v-show="showPassword" class="fa fa-eye"></i>

											</span>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-white text-primary btn-block mt-5">Sign Up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p class="text-white">Have an account? <router-link to="/" class="text-white">Sign In</router-link></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>


export default {
    data(){
        return{
            form: {
                name:"",
                email: "",
                password: "",
            },
            showPassword:false,
            inputType: 'password'
        }
    },
    methods:{
        signup(){
            console.log(this.form)
            this.axios
                .post(this.$baseUrl + "/api/register", this.form)
                .then((response) => {
                    console.log(response)
                    localStorage.setItem('token',response.data.data.token);
                    localStorage.setItem('name',response.data.data.name);
                    localStorage.setItem('image',response.data.data.image);
                    localStorage.setItem('role',response.data.data.roles[0].name);
                    this.$router.push({ name: "Posts" });
                })
                .catch((error) => {
                    this.$toast.error("Please add correct details!",{position:"top-right"});
                    console.log(error.response);
                });
        },
        togglePasswordVisibility(){
            this.showPassword = !this.showPassword
            this.inputType = this.showPassword ? 'text' : 'password';
        }
    }
}

</script>
