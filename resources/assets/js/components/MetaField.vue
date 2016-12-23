<template>
    <div>
        <string-field v-on:input="updateValue()" v-if="meta.type == 'string'" v-model="value"  :meta="meta" />
        <boolean-field v-on:input="updateValue()" v-if="meta.type == 'boolean'" v-model="value" :meta="meta" />
    </div>
</template>

<script>
    import StringField from './StringField.vue';
    import BooleanField from './BooleanField.vue';
    export default {
        components: { StringField, BooleanField },
        mounted() {
            console.log('Field control mounted.')
        },
        data(){
            return {
                value: ""
            }
        },
        methods: {
            updateValue: function () {
                this.$emit('input', this.value)
            }
        },
        props: {
            meta: {
                type: Object
            }
        }
    }
</script>
