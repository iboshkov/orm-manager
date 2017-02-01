<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div>
        <label class="label">{{ meta.name | humanize }}</label>
        <p class="control">
            <input ref="input" :value="value" v-on:input="updateValue($event.target.value)" class="input" type="text" placeholder="Enter a value...">
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('String control mounted.', this.value)
        },
        data(){
            return {
            }
        },
        methods: {
            updateValue: function (value) {
                this.$emit('input', value);
            }
        },
        props: {
            value: {},
            meta: {
                type: Object
            }
        }
    }
</script>
