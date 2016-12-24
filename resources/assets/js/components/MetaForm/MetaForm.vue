<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <nav class="panel">
        <p class="panel-heading">
            <slot name="form-title">
                Attributes for <span :title="className"><strong>{{ className | classOnly }}</strong></span>:
            </slot>
        </p>
        <div class="panel-block">
            <meta-field v-model="result[attr.name]" v-for="attr in meta.attributes" :meta="attr"></meta-field>

            <!--<meta-field  v-on:input="updateValue" v-for="attr in meta.attributes" :meta="attr"></meta-field>-->
        </div>
        <p class="panel-heading">
            Relationships:
        </p>
        <div class="panel-block">
            <p v-for="attr in meta.relationships">{{ attr.type }} {{ attr.model }}</p>
        </div>

        <slot name="form-footer"></slot>

        Form result:<br/>
        {{ result }}
        {{ value }}
    </nav>
</template>

<script>
    var mixins = require("../../mixins/util.mixin");
    import MetaField from './MetaField.vue';

    export default{
        components: { MetaField },
        mixins: [mixins],

        methods: {
            updateMeta () {
                var vm = this;
                vm.meta.attributes.forEach(function(attr){
                    Vue.set(vm.result, attr.name,  vm.value[attr.name] || "");
                });
            },
            updateValue: function(attr, val) {
                console.log("Meta form update", attr.name, val);
                this.$emit("input", {});
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
            value: function(val) {
                this.updateMeta();
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
