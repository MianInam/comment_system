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
                    <div class="col-xl-3 col-xxl-4">
                        <div class="row">
                            <div class="col-xl-12 col-lg-6">
                                <div class="card  flex-lg-column flex-md-row ">
                                    <div class="card-body card-body  text-center border-bottom profile-bx">
                                        <div class="profile-image mb-4">
                                            <img :src="image != 'null'? imageBaseURL+image : staticImage"
                                                 class="rounded-circle"
                                                 @click="triggerFileInput"
                                                 style="cursor: pointer"
                                                 alt="">
                                            <input
                                                type="file"
                                                ref="fileInput"
                                                accept="image/*"
                                                @change="onImageSelected"
                                                style="display: none"
                                            />
                                        </div>
                                        <h4 class="fs-22 text-black mb-1">{{ user.name }}</h4>
                                        <p class="mb-4">{{ role }}</p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-xxl-8">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card profile-card">
                                    <div class="card-header flex-wrap border-0 pb-0">
                                        <h3 class="fs-24 text-black font-w600 me-auto mb-2 pe-3">Edit Profile</h3>

                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="mb-sm-5 mb-2">
                                                <div class="title mb-4"><span class="fs-18 text-black font-w600">Generals</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" class="form-control"
                                                                   v-model="user.name">
                                                            <p v-if="errors.hasOwnProperty('name')" class="errorText">
                                                                {{ errors['name'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="text" disabled class="form-control bg-"
                                                                   v-model="user.email">
                                                        </div>
                                                    </div>
                                                    <div class="d-sm-flex d-block">

                                                        <a class="btn btn-primary rounded mb-2"
                                                           @click.prevent="saveName">Save Name</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-sm-5 mb-2">
                                                <div class="title mb-4"><span
                                                    class="fs-18 text-black font-w600">PASSWORD</span></div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="form-group position-relative">
                                                            <label>Password</label>
                                                            <input :type="inputType" id="dz-password"
                                                                   class="form-control" v-model="password"
                                                                   placeholder="Enter password">
                                                            <span style="cursor: pointer;" class="eye"
                                                                  @click="togglePasswordVisibility">

												<i v-show="!showPassword" class="fa fa-eye-slash"></i>
												<i v-show="showPassword" class="fa fa-eye"></i>

											</span>
                                                            <p v-if="errors.hasOwnProperty('password')"
                                                               class="errorText">
                                                                {{ errors['password'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label>Re-Type Password</label>
                                                            <input :type="inputType" v-model="confirm_password"
                                                                   name="confirm_password"
                                                                   id="confirm_password" class="form-control"
                                                                   style="border-color:#C2C2C2;"
                                                                   placeholder="Enter password">
                                                            <span style="cursor: pointer;" class="eye"
                                                                  @click="togglePasswordVisibility">

												<i v-show="!showPassword" class="fa fa-eye-slash"></i>
												<i v-show="showPassword" class="fa fa-eye"></i>

											</span>

                                                        </div>
                                                    </div>
                                                    <div class="d-sm-flex d-block">

                                                        <a class="btn btn-primary rounded mb-2"
                                                           @click.prevent="changePassword">Save Password</a>
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
            imageBaseURL: this.$imageBaseUrl,
            Loader: false,
            user: {},
            role: '',
            showPassword: false,
            inputType: 'password',
            password: '',
            confirm_password: '',
            image: 'null',
            staticImage: '/images/profile/conimg2.png'
        };
    },
    methods: {
        triggerFileInput() {
            this.$refs.fileInput.click(); // Trigger the file input on image click
        },
        onImageSelected(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.image = e.target.result; // Set image to preview URL
                };

                reader.readAsDataURL(file);
                this.errors = {}
                this.axios
                    .post(this.$baseUrl + "/api/profile/update", {image: file}, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem("token")}`,
                                "Content-Type": "multipart/form-data",
                            }
                        },
                    )
                    .then((response) => {
                        console.log(response)
                        this.$swal({
                            title: "Success!",
                            text: "Profile Pic updated successfully!",
                            type: "success",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false,
                        });
                        localStorage.setItem('image', response.data.data.image);
                        location.reload()
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
            } else {
                alert("Please select a valid image file.");
            }
        },
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword
            this.inputType = this.showPassword ? 'text' : 'password';
        },
        saveName() {
            this.errors = {}
            this.axios
                .post(this.$baseUrl + "/api/name/update", {name: this.user.name}, {
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
                        text: "Name updated successfully!",
                        type: "success",
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
                    localStorage.setItem('name', response.data.data.name);
                    location.reload()
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
        changePassword() {
            this.errors = {}
            this.axios
                .post(this.$baseUrl + "/api/password/update",
                    {password: this.password, password_confirmation: this.confirm_password},
                    {
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
                        text: "Password updated successfully!",
                        type: "success",
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
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
        fetchInfo() {
            this.axios
                .get(this.$baseUrl + "/api/user/info", {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                            "Content-Type": "application/json",
                        }
                    },
                )
                .then((response) => {
                    console.log(response)
                    this.user = response.data.data
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
        this.fetchInfo();
        this.role = localStorage.getItem("role");
        this.image = localStorage.getItem("image");
    }
}
</script>
<style>
.errorText {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: var(--bs-form-invalid-color);
}
</style>
