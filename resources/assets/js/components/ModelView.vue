<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <nav class="panel">
        <p class="panel-heading">
            Model: {{ className }}
        </p>
        <div class="panel-block">

            <h2 class="subtitle">Toggle fields</h2>
            <multiselect v-model="selected" :close-on-select="false" :multiple="true" track-by="name" label="name" :options="options">
        </div>
        <div class="panel-block">
            <table class="table is-striped is-narrow">
                <thead>
                <tr>
                    <!--
                    @foreach($data["attributes"] as $attribute => $type)
                    <th>@{{ humanize_attribute($attribute) }}</th>
                    @endforeach
                    -->
                    <th v-for="attr in selected">
                        {{ attr.humanName }}
                    </th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th v-for="attr in selected">
                        {{ attr.humanName }}
                    </th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                <tbody>
                <tr v-for="entry in data">
                    <td v-for="attr in selected">
                        <span>{{ truncate(entry[attr.name], 15) }}</span>
                    </td>
                    <td>
                        <div class="columns">
                            <div class="column">
                                <button class="button is-primary ">
                                    Add New
                                </button>
                            </div>
                            <div class="column">
                                <button class="button is-danger ">
                                    Drop All
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-block">
            <div class="columns">
                <div class="column">
                    <button v-on:click="foo()" class="button is-primary is-outlined is-fullwidth">
                        Add New
                    </button>
                </div>
                <div class="column">
                    <button v-on:click="doShit(123)" class="button is-danger is-outlined is-fullwidth">
                        Drop All
                    </button>
                </div>
            </div>
        </div>


    </nav>
</template>
<style>
    body{
        background-color:#ff0000;
    }

    table {
        table-layout: fixed;
    }
</style>
<script>
    import Multiselect from 'vue-multiselect';

    var mixins = require("../mixins/util.mixin");
    console.log(Multiselect);
    export default{
        components: { Multiselect },
        mixins: [mixins],

        methods: {
            doShit: function(test) {
                console.log("TestA SF UCK");
            },
            updateSelected (newSelected) {
                this.selected = newSelected
            }

        },
        data(){
            return{
                msg:'hello vue',
                selected: null,
                options: ['list', 'of', 'options'],
                meta: {
                    type: Object,
                    default: function() {
                        return {
                            attributes: [],
                            relationships: []
                        }
                    }
                },
                data: {
                    type: Array,
                    default: function() { return []; }
                }
            }
        },
        mounted() {
            console.log("Mounted, testing...");
              // GET /someUrl

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

        },
        props: {
            className: {
                type: String
            }
       }
    }
</script>
