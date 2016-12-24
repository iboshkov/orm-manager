<template>
    <div>
        <app-layout>
            <div slot="sidebar-nav">
                <p class="menu-label">
                    Models
                </p>
                <ul class="menu-list">
                    <li><router-link active-class="is-active" :to="{name: 'allModels'}">All</router-link></li>

                    <li v-for="model in metaList"><router-link :to="{name: 'singleModel', params:{ id: model }}" active-class="is-active">1{{ model }}</router-link></li>
                </ul>
            </div>
            <router-view></router-view>
        </app-layout>
    </div>
</template>
<style>

</style>
<script>
    import AppLayout from '../App.vue'
    import ModelComponent from '../../components/ModelComponent.vue'
    import MetaForm from '../../components/MetaForm/MetaForm.vue';

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
