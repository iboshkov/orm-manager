<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div>
        <div class="columns">
            <div class="column">
                <div v-if="metaIsLoading">
                    <button class="button is-loading is-fullwidth"></button>
                </div>
                <div v-else>
                    <multiselect v-if="modelMeta" select-label="" deselect-label="" v-model="selectedAttribute" label="humanName" :options="modelMeta.attributes"/>
                </div>
            </div>
            <div class="column is-three-quarters">
                <div v-if="dataIsLoading || metaIsLoading">
                    <button class="button is-loading is-fullwidth"></button>
                </div>
                <div v-else>
                    <multiselect 
                        :close-on-select="!multiple"
                        ref="valueSelect" 
                        :multiple="multiple"
                        :hide-selected="multiple"
                        :value="selectedValue"
                        :track-by="trackField"
                        v-on:input="updateValue" 
                         :label="selectedAttribute && selectedAttribute.name"
                         :options="options">
                    </multiselect>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import _ from 'lodash';

    export default {
        mounted() {
            console.log('ModelSelect 123 control mounted.', this.value);
            this.loadData();
        },
        watch: {
            value() {
                console.log("Model select value change", this.value);
            },
            selectedAttribute(newVal) {
                var vm = this;
                // TODO: Find a non-hack way to do this.
                if (vm.$refs.valueSelect) {
                    vm.$refs.valueSelect.value = null;
                }
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
                metaIsLoading: false,
                dataIsLoading: false,
                selectedValue: null,
                selectedAttribute: null,
                modelMeta: null,
                trackField: null,
                options: ["Test", "Two"]
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

                    // TODO: Abstract into resource
                    vm.$http.get('/orm/api/meta/', {params: {
                        "class": vm.meta.model
                    }
                    }).then((response) => {
                        vm.modelMeta = response.body;
                        console.log("Got relation model meta", vm.modelMeta);
                        Vue.set(vm, "selectedAttribute", vm.modelMeta.attributes[0]);
                        var keyField = vm.modelMeta.primaryKey;
                        var thisKeyField = vm.meta.primaryKey;

                        vm.trackField = keyField;
                        vm.metaIsLoading = false;
                        var selected = [];
                        vm.options.forEach(function(val) {
                            var otherKey = val[vm.meta.otherKey] || val[vm.meta.foreignKeyPlain];
                            var thisKey = vm.value[thisKeyField];
                            console.log(vm.meta.name, otherKey, thisKey);
                            if (!vm.multiple && otherKey == thisKey) {
                                Vue.set(vm, "selectedValue", val);
                                console.log("SELECTED VAL", vm.selectedValue);
                            }
                        });
                       if (vm.multiple) {
                          Vue.set(vm, "selectedValue", vm.value);
                          console.log("Setting multi selected to ", selected);
                       }
                        if (!vm.selectedValue) {
                          console.log("Something's wrong", vm.value); 
                        }
                       vm.updateValue(vm.selectedValue);
                    }, (response) => {
                        vm.metaIsLoading = false;
                    });

                }, (response) => {
                    vm.dataIsLoading = false;
                });

                // TODO: Abstract into resource
                vm.$http.get('/orm/api/meta/', {params: {
                    "class": vm.meta.model
                }
                }).then((response) => {
                    vm.modelMeta = response.body;
                    console.log("Got relation model meta", vm.modelMeta);
                    Vue.set(vm, "selectedAttribute", vm.modelMeta.attributes[0]);
                    vm.metaIsLoading = false;
                }, (response) => {
                    vm.metaIsLoading = false;
                });
            },
            updateValue: function (value, id) {
                var vm = this;
                var out = null;
                if (vm.multiple) {
                    out = [];
                    value.forEach(function(element) {
                        out.push(element[vm.modelMeta.primaryKey]);
                        console.log(element);
                    });
                } else {
                    out = value[vm.modelMeta.primaryKey];
                }
                console.log("Model object chosen", out, value);

                this.$emit('input', out);
            }
        },
        props: {
            value: {},
            meta: {
                type: Object
            },
            otherKeyField: {
                type: String,
                default: "otherKey"
            },
            multiple: {
                type: Boolean,
                default: false
            }
        },
        components: {
            Multiselect
        }
    }
</script>
