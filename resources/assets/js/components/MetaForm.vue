<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <nav class="panel">
        <p class="panel-heading">
            Meta Form: {{ className }} {{ 'testCase test_case' | humanize }}
        </p>
        <div class="panel-block">
            <meta-field v-on:input="valueUpdated(attr.name, $event)" v-for="attr in meta.attributes" :meta="attr"></meta-field>
            <p v-for="attr in meta.relationships">{{ attr.type }} {{ attr.model }}</p>
        </div>
        <p>
            {{ value }}
        </p>
    </nav>
</template>
<style>
    table {
        table-layout: fixed;
    }
</style>
<script>
    var mixins = require("../mixins/util.mixin");
    import MetaField from './MetaField.vue';

    export default{
        components: { MetaField },
        mixins: [mixins],

        methods: {
            valueUpdated: function(attr, val) {
                Vue.set(this.value, attr, val);

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

                      vm.meta.attributes.forEach(function(attr){
                        Vue.set(vm.value, attr.name, "");
                      });
                  }, (response) => {
                    // error callback
                  });
            }
        },
        data(){
            return {
                value: {
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
            }
        },
        mounted() {
            console.log("Mounted, testing...");
            this.loadData();

        },
        props: {
            className: {
                type: String
            }
       }
    }
</script>
