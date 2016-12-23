<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <nav class="panel">
        <p class="panel-heading">
            Meta Form: {{ className }} {{ 'testCase test_case' | humanize }}
        </p>
        <div class="panel-block">
            <meta-field v-model="testData.active" v-for="attr in meta.attributes" :meta="attr">{{ attr.name }} : {{ attr.type }}</meta-field>
            <p v-for="attr in meta.relationships">{{ attr.type }} {{ attr.model }}</p>
        </div>
        <p>
            {{ testData }}
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
            loadData() {
                  this.$http.get('/orm/api/meta/', {params: {
                        "class": this.className
                   }
                  }).then((response) => {
                    console.log("Got model meta", response);
                      this.meta = response.body;
                      this.options = this.meta.attributes;
                      this.selected = this.meta.attributes;

                      this.$http.get('/orm/api/data/all', {params: {
                            "class": this.className
                        }
                      }).then((response) => {
                        console.log("Got data for meta", response);
                        this.data = response.body;
                      }, (response) => {
                        // error callback
                      });
                  }, (response) => {
                    // error callback
                  });
            }
        },
        data(){
            return {
                testData: {
                    name: "",
                    active: false
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
