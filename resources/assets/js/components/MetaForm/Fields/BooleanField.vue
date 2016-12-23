<template>
    <p class="control">
        <label class="checkbox">
            <input v-on:change="updateValue($event.target.value)" v-model="value" type="checkbox">
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
