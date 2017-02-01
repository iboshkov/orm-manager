<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div>
        <span class="label">Belongs to {{ meta.name | humanize}}</span>
        <!--<label class="label">Filtering by {{ selectedAttribute }}</label>-->
        <!--<label class="label">Selected object: {{ selectedValue }}</label>-->
        <model-select :multiple="false" :value="value" v-on:input="updateValue" :meta="meta"/>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import ModelSelect from '../ModelSelect.vue';
 
    export default {
        mounted() {
            console.log('BelongsTo control mounted.', this.value);
        },
        watch: {
            value() {
                console.log("Belongs to value change", this.value);
            },
        },
        data(){
            return {
            }
        },
        methods: {
            updateValue: function (value) {
                var vm = this;
                console.log("Belongs to chosen", value);
                this.$emit('input', value);
            }
        },
        props: {
            value: {},
            meta: {
                type: Object
            }
        },
        components: {
            Multiselect, ModelSelect
        }
    }
</script>
