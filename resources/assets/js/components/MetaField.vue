<template>
    <div>
        {{ meta.name }}
        <string-field v-on:input="updateValue()" v-if="meta.type == 'string'" v-model="value"  :meta="meta" />
        <boolean-field v-on:input="updateValue()" v-if="meta.type == 'boolean'" v-model="value" :meta="meta" />
        <text-field v-on:input="updateValue()" v-if="meta.type == 'text'" v-model="value" :meta="meta" />
    </div>
</template>

<script>
    import StringField from './StringField.vue';
    import BooleanField from './BooleanField.vue';
    import TextField from './TextField.vue';
    export default {
        components: { StringField, BooleanField, TextField },
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
                console.log("meta Update", this.value);

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
