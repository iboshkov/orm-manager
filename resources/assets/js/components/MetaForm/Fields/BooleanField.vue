<template>
    <p class="control">
        <label class="checkbox">
            <input ref="input" v-on:change="updateValue($event.target.checked)" :checked="value" type="checkbox">
            {{ meta.name | humanize }}
        </label>
    </p>
</template>

<script>
    export default {
        mounted() {
            console.log('Bool control mounted.')
        },
        computed: {
            toBool() {
                return this.value.toBoolean();
            }
        },
        methods: {
            updateValue: function (value) {
                console.log("Bool control says", value);
                this.$refs.input.value = value;
                this.$emit('input', value ? 1 : 0);
            }
        },
        props: {
            meta: {
                type: Object
            },
            value: {
                type: [String, Number, Boolean],
                default: false
            }
        }
    }
</script>
