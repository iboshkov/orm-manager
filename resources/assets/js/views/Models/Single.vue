<template>
        <div>
            <!--<meta-form v-model="result" class-name="App\User"></meta-form>-->
            <!--Actual result: {{result}}-->

            <!--<input type="text" v-model="result.name" />-->
            <tabs animation="slide" :only-fade="false">
                <tab-pane selected label="Data">
                    <model-component v-on:edit="editToggled(entry)" :class-name="$route.params.id" />
                </tab-pane>
                <tab-pane label="Utilities">
                </tab-pane>
                <tab-pane label="Videos">Video Tab</tab-pane>
            </tabs>
        </div>
</template>
<script>
    import { Tabs, TabPane } from 'vue-bulma-tabs';
    import MetaForm from "../../components/MetaForm/MetaForm.vue";

    export default{
        data(){
            return {
                result: {
                    name: "Test"
                },
                testUpdate: {
                    name: "Test123"
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
