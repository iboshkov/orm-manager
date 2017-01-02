<template>
        <app-layout>
            <div slot="sidebar-nav">
                <p class="menu-label">
                    Models
                </p>
                <ul class="menu-list">
                    <li v-for="model in metaList"><router-link :to="{name: 'singleModel', params:{ id: model }}" active-class="is-active">{{ model }}</router-link></li>
                </ul>
            </div>
            <transition name="fade" mode="out-in">
                Route: {{$route.fullPath}}
                <router-view :key="$route.fullPath"></router-view>
            </transition>
        </app-layout>
</template>
<style>

</style>
<script>
    import AppLayout from './App.vue'
    export default{
        mounted() {
            this.$http.get('/orm/api/meta/list/').then((response) => {
                console.log("Got all models meta", response);
                this.metaList = response.body;
            }, (response) => {
                // error callback
            });
        },
        data(){
            return{
                metaList: []
            }
        },
        components:{
            AppLayout,
        }
    }
</script>
