<template>
    <div>
        <app-layout>
            <div slot="sidebar-nav">
                <p class="menu-label">
                    Models
                </p>
                <ul class="menu-list">
                    <li><router-link active-class="is-active" :to="{name: 'allModels'}">All</router-link></li>

                    <li v-for="model in metaList"><a active-class="is-active">{{ model }}</a></li>
                </ul>
            </div>

            <h1 class="title">Meta form</h1>
            <meta-form class-name="App\Blog\Post"></meta-form>

            <model-component v-for="model in metaList" :class-name="model" />
        </app-layout>
    </div>
</template>
<style>

</style>
<script>
    import AppLayout from '../App.vue'
    import ModelComponent from '../../components/ModelComponent.vue'
    import MetaForm from '../../components/MetaForm.vue';
    export default{
        data(){
            return {
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
            AppLayout,
            MetaForm,
            ModelComponent
        }
    }
</script>
