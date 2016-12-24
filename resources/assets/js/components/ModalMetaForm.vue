<template>
    <div :class="['modal', {'is-active' : show}]">

        <div v-on:click="reset(true)" class="modal-background"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title"><strong>{{ title }} {{ className | classOnly }}</strong></p>
                <button v-on:click="reset(true)" class="delete"></button>
            </header>
            <section class="modal-card-body">
                <meta-form v-model="testModel" :class-name="className"></meta-form>
            </section>
            <footer class="modal-card-foot">
                <a v-on:click="close()" class="button is-primary">Save changes</a>
                <a v-on:click="reset(true)" class="button">Cancel</a>
                Val: {{ testModel }} endval
            </footer>
        </div>

    </div>
</template>

<script>
    import MetaForm from "./MetaForm/MetaForm.vue";


    export default{
        data(){
            return{
                msg:'hello vue',
                testModel: {}
              }
        },
        methods: {
            close() {
                this.$emit("close");
            },
            reset(close) {
                this.testModel = {};
                if (close) this.close();
            }
        },
        mounted() {
            this.testModel = this.initialData;
        },

        watch: {
            initialData: function(newVal, oldVal) {
                this.testModel = newVal;
            }
        },
        props: {
            title: "Edit",
            initialData: {},
            show: false,
            className: "",
        },

        components:{
            MetaForm
        }
    }
</script>
