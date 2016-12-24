<template>
    <p class="control">
        <label class="checkbox">
            <input ref="input" v-on:change="updateValue($event.target.value)" type="checkbox">
            {{ meta.name | humanize }}
        </label>
    </p>
</template>

<script>
    export default {
        mounted() {
            console.log('Bool control mounted.')
        },
        data(){
            return {
                value: {}
            }
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
            }
        }
    }
</script>
