<template>
    <div>
        <template v-if="meta.type == 'string'">
            <string-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
    </div>
</template>

<script>
    import StringField from './Fields/StringField.vue';
    import BooleanField from './Fields/BooleanField.vue';
    import TextField from './Fields/TextField.vue';
    export default {
        components: { StringField, BooleanField, TextField },
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
