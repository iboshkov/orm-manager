<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div>
        <span class="label">Which <u>{{ modelMeta && modelMeta.class | classOnly }}</u> does this object belong to ?</span>
        <!--<label class="label">Filtering by {{ selectedAttribute }}</label>-->
        <!--<label class="label">Selected object: {{ selectedValue }}</label>-->
        <div class="columns">
            <div class="column">
                <div v-if="metaIsLoading">
                    <button class="button is-loading is-fullwidth"></button>
                </div>
                <div v-else>
                    <multiselect select-label="" deselect-label="" v-model="selectedAttribute" label="humanName" :options="modelMeta.attributes"/>
                </div>
            </div>
            <div class="column is-three-quarters">
                <div v-if="dataIsLoading || metaIsLoading">
                    <button class="button is-loading is-fullwidth"></button>
                </div>
                <div v-else>
                    <multiselect ref="valueSelect" v-on:input="updateValue" v-model="selectedValue" :label="filterAttribute" :options="options">
                    </multiselect>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        mounted() {
            console.log('BelongsTo control mounted.', this.value);
            this.loadData();
        },
        watch: {
            value() {
                console.log("Belongs to value change", this.value);
            },
            selectedAttribute(newVal) {
                var vm = this;
                // TODO: Find a non-hack way to do this.
                vm.$refs.valueSelect.value = null;
            }
        },
        computed: {
            filterAttribute() {
                var vm = this;
                if (vm.selectedAttribute)
                    return vm.selectedAttribute.name;
                else
                    return "";
            }
        },
        data(){
            return {
                metaIsLoading: true,
                dataIsLoading: true,
                selectedValue: null,
                selectedAttribute: null,
                modelMeta: null,
                options: []
            }
        },
        methods: {
            loadData() {
                var vm = this;
                vm.dataIsLoading = true;
                // TODO: Abstract into resource
                vm.$http.get('/orm/api/data/', {params: {
                    "class": vm.meta.model
                }
                }).then((response) => {
                    console.log("Got relation model meta", response);
                    vm.options = response.body;
                    vm.dataIsLoading = false;

                    vm.options.forEach(function(val) {
                        var otherKey = val[vm.meta.otherKey];
                        if (otherKey == vm.value) {
                            vm.selectedValue = val;
                        }
                    });
                }, (response) => {
                    vm.dataIsLoading = false;
                });

                // TODO: Abstract into resource
                vm.$http.get('/orm/api/meta/', {params: {
                    "class": vm.meta.model
                }
                }).then((response) => {
                    console.log("Got relation model meta", response);
                    vm.modelMeta = response.body;
                    vm.metaIsLoading = false;
                }, (response) => {
                    vm.metaIsLoading = false;
                });
            },
            updateValue: function (value) {
                var vm = this;
                var key = value[vm.meta.otherKey];
                console.log("Relation chosen", key);
                this.$emit('input', key);
            }
        },
        props: {
            value: {},
            meta: {
                type: Object
            }
        },
        components: {
            Multiselect
        }
    }
</script>
