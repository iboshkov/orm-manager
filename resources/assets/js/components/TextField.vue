<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div>
        <label class="label">{{ meta.name | humanize }}</label>
        <p class="control">
            <textarea v-model="value" v-on:input="updateValue($event.target.value)" class="textarea"></textarea>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Field control mounted.')
        },
        data(){
            return {
                value: ""
            }
        },
        methods: {
            // Instead of updating the value directly, this
            // method is used to format and place constraints
            // on the input's value
            updateValue: function (value) {
                this.$emit('input', value)
            }
        },
        props: {
            meta: {
                type: Object
            }
        }
    }
</script>
