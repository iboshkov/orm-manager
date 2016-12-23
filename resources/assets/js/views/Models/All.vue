<template>
        <transition name="fade">
            <div>
                <model-component v-for="model in metaList" :class-name="model" />
            </div>
            <h1 class="title">Meta form</h1>
            <meta-form class-name="App\User"></meta-form>>
        </transition>
</template>
<style>
</style>
<script>
    import ModelComponent from '../../components/ModelComponent.vue'
    export default{
        data(){
            return{
                msg:'hello vue',
                metaList: [],
            }
        },
        mounted() {
            this.$http.get('/orm/api/meta/list/').then((response) => {
                console.log("Got all models meta", response);
                this.metaList = response.body;
            }, (response) => {
                // error callback
            });
        },
        components:{
        }
    }
</script>
