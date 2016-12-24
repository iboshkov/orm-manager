<template>
        <div>
            <meta-form v-model="result" class-name="App\User"></meta-form>
            <!--
            <tabs animation="slide" :only-fade="false">
                <tab-pane label="Data">
                    <model-component v-on:edit="editToggled(entry)" :class-name="$route.params.id" />
                </tab-pane>
                <tab-pane selected label="Utilities">
                </tab-pane>
                <tab-pane label="Videos">Video Tab</tab-pane>
            </tabs>

            -->
        </div>
</template>
<style>
    body{
        background-color:#ff0000;
    }
</style>
<script>
    import { Tabs, TabPane } from 'vue-bulma-tabs';
    import MetaForm from "../../components/MetaForm/MetaForm.vue";

    export default{
        data(){
            return {
                result: {
                    name: "Test"
                },
                showEditModal: false,
            }
        },
        components:{
            Tabs,
            TabPane,
            MetaForm
        }
    }
</script>
