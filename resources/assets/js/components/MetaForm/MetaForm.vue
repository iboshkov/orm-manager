<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <nav class="panel">
        <p class="panel-heading">
            <slot name="form-title">
                Attributes for <span :title="className"><strong>{{ className | classOnly }}</strong></span>:
            </slot>
        </p>
        <div class="panel-block">
            <meta-field class="meta-field" v-model="result[attr.name]" v-for="attr in nonKeyAttributes" :meta="attr"></meta-field>
        </div>
        <p class="panel-heading">
            Relationships:
        </p>
        <div class="panel-block">
            <p v-for="attr in meta.relationships">{{ attr.type }} {{ attr.model }}</p>
        </div>
        <br/>
        <div class="control">

            <a v-on:click="submit()" class="button is-primary">Save changes</a>
            <a v-on:click="cancel()" class="button">Cancel</a>

        </div>

        <slot name="form-footer"></slot>

        Form result:<br/>
        {{ result }}
        <br/>
        Initial value: {{ value }}
    </nav>
</template>
<style scoped>
    .meta-field {
        margin-bottom: 15px;
    }
</style>
<script>
    var mixins = require("../../mixins/util.mixin");
    import MetaField from './MetaField.vue';

    export default{
        components: { MetaField },
        mixins: [mixins],
        computed: {
            nonKeyAttributes: function() {
                var vm = this;
                if (!vm.meta || !vm.meta.attributes)
                    return [];
                var attrs = [];
                this.meta.attributes.forEach(function(attr) {
                    if (attr.name != vm.meta.primaryKey) {
                        attrs.push(attr);
                    }
                });
                return attrs;
            }
        },
        methods: {
            submit() {
                console.log("Form firing submit", this.result);
                this.$emit("submit", this.result);
            },
            cancel() {
                this.$emit("cancel");
            },
            updateMeta () {
                var vm = this;
                vm.nonKeyAttributes.forEach(function(attr){
                    Vue.set(vm.result, attr.name,  vm.value[attr.name] || "");
                });
            },
            updateValue: function(val) {
                console.log("Meta form update", val);
                this.$emit("input", val);
            },
            loadData() {
                var vm = this;
                this.$http.get('/orm/api/meta/', {params: {
                    "class": this.className
                }
                }).then((response) => {
                    console.log("Got model meta", response);
                    vm.meta = response.body;
                    vm.options = this.meta.attributes;
                    vm.selected = this.meta.attributes;

                    vm.updateMeta();
                }, (response) => {
                    // error callback
                });
            }
        },
        data(){
            return {
                result: {

                },
                meta: {
                    type: Object,
                    default: function() {
                        return {
                            attributes: [],
                            relationships: []
                        }
                    }
                }
            }
        },

        watch: {
            className: function(val) {
                console.log("Change", val);
                this.loadData();
            },
            show: function(val) {
                if (!val) {
                    this.result = {};
                }
            },
            result: function(val) {
                console.log("Meta form update");
                this.updateValue(val);
            },
            value: function(val) {
                this.updateMeta();
                Object.assign(this.result, val);
            }
        },
        mounted() {
            this.result = this.value;
            this.loadData();

        },
        props: {
            value: {
            },
            className: {
                type: String
            },
        }
    }
</script>
