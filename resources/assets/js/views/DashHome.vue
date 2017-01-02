<template>
    <div>
        Hello dash home.
    </div>
</template>
<style>
</style>
<script>
    import ModelComponent from '../components/ModelComponent.vue'
    export default{
        data(){
            return{
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
