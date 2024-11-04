

<template>

    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">

        <router-view/>


    </div>
</template>
<script>
import {defineComponent} from "vue";
import Nav from "@/components/parts/nav-header.vue";

export default defineComponent({
    components: {Nav}
})
</script>
