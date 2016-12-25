<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div>
        <label class="label">{{ meta.name | humanize }}</label>
        <p class="control">
            <textarea ref="input" v-on:input="updateValue($event.target.value)"
                      :value="value"
                      class="textarea"
                      placeholder="Enter some text."></textarea>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Field control mounted.')
        },
        methods: {
            updateValue: function (value) {
                this.$refs.input.value = value
                this.$emit('input', value)
            }
        },
        props: {
            meta: {
                type: Object
            },
            value: {}
        }
    }
</script>
