<template>
    <modal v-on:close="close" :show="show">
        <meta-form v-on:cancel="close" v-on:submit="submit" v-model="formResult" :class-name="className"></meta-form>
    </modal>
</template>

<script>
    import MetaForm from "./MetaForm/MetaForm.vue";
    import Modal from "./Modal.vue";

    export default {
        data(){
            return{
                msg:'hello vue',
                formResult: {}
              }
        },
        methods: {
            submit(val) {
                console.log("Modal firing submit", val);
                this.$emit("submit", val);
                this.close();
            },
            close() {
                this.$emit("close");
            }
        },
        mounted() {
            this.formResult = this.initialData;
        },

        watch: {
            initialData: function(newVal, oldVal) {
                this.formResult = newVal;
            }
        },
        props: {
            title: "Edit",
            initialData: {},
            show: false,
            className: "",
        },

        components: {
            MetaForm, Modal
        }
    }
</script>
