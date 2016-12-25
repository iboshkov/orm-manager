<template>
    <div>
        <template v-if="meta.type == 'string'">
            <string-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-if="meta.type == 'boolean'">
            <boolean-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-if="meta.type == 'text'">
            <text-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-if="meta.type == 'datetime'">
            <date-time-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
    </div>
</template>

<script>
    import StringField from './Fields/StringField.vue';
    import BooleanField from './Fields/BooleanField.vue';
    import TextField from './Fields/TextField.vue';
    import DateTimeField from './Fields/DateTimeField.vue';


    export default {
        components: { StringField, BooleanField, TextField, DateTimeField },
        mounted() {
            console.log('Meta field mounted.', this.value);
        },
        data(){
            return {
                fieldData: ""
            }
        },
        methods: {
            updateValue: function (value) {
                console.log("Meta field update", value)
                this.$emit('input', value)
            }
        },
        props: {
            meta: {
                type: Object
            },
            value: {
            }

        }
    }
</script>
