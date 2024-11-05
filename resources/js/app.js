import { createApp } from 'vue';
import App from './App.vue';
import router from "@/routes.js";
import Nav from './components/parts/nav-header.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ToastPlugin from 'vue-toast-notification';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp(App);


app.component(
    "Nav",
    Nav
);
app.use(VueAxios, axios)
app.use(router);
app.use(ToastPlugin);
app.use(VueSweetalert2);
app.config.globalProperties.$baseUrl = window.location.origin;
app.config.globalProperties.$sentimentsBaseUrl = "http://127.0.0.1:5000";
app.config.globalProperties.$imageBaseUrl = window.location.origin+'/storage/';

app.mixin({
    data() {
        return {
            isActive1: false,
            isActive2: false,
            isActive3: false,
        };
    },
    methods: {
        setActive() {
            if (this.$route.href == "/dashboard") {
                this.isActive1 = true
                this.isActive2 = false
            } else if (this.$route.href.includes("posts")) {
                this.isActive1 = false
                this.isActive2 = true
            }
        }
    },
    mounted() {
        setTimeout((e) => {
            this.setActive();
        }, 500)

    },
    created() {
        // console.log(localStorage.getItem('token'))
        app.config.globalProperties.$header = {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
                "Content-Type": "application/json",
            },
        };
    }
});
app.mount("#app")
