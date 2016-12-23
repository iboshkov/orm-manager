<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <nav class="panel">
        <p class="panel-heading">
            Model: {{ className }}
        </p>

        <div class="panel-block">
            <p class="control">
                <label class="label">Limit displayed value length</label>

                <input class="input" type="number" v-model.number="testValue">
            </p>

            <p class="control">
                <label class="label">Filter by model field</label>

                <multiselect v-model="selected" :close-on-select="false" :multiple="true" track-by="name" label="name" :options="options">
            </p>

        </div>
        <div class="panel-block">
            <table class="table is-striped is-narrow">
                <thead>
                <tr>
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
                        <span>{{ entry[attr.name] | truncate(testValue) }}</span>
                    </td>
                    <td>
                        <div class="control is-grouped is-pulled-right">
                            <p class="control">
                                <button class="button is-info is-outlined">
                                    <span class="icon is-small">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </span>
                                    <span>Edit</span>
                                </button>
                            </p>
                            <p class="control">
                                <button class="button is-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </p>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-block">
            <div class="columns">
                <div class="column">
                    <button class="button is-primary is-fullwidth is-outlined">
                        <span class="icon is-small">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </span>
                        <span>Add New</span>
                    </button>
                </div>
                <div class="column">
                    <button class="button is-danger is-fullwidth is-outlined">
                        <span class="icon is-small">
                            <i class="fa fa-warning" aria-hidden="true"></i>
                        </span>
                        <span>Drop All</span>
                    </button>
                </div>
            </div>
        </div>


    </nav>
</template>
<style>
    table {
        table-layout: fixed;
    }

    td {
        word-wrap: break-word;
        max-width: 150px;
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
            updateSelected (newSelected) {
                this.selected = newSelected
            },
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
            return{
                msg:'hello vue',
                testValue: 100,
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

        watch: {
            className: function(val) {
                console.log("Change", val);
                this.loadData();
            }
        },
        mounted() {
            console.log("Mounted, testing...");
              // GET /someUrl
            this.loadData();

        },
        props: {
            className: {
                type: String
            }
       }
    }
</script>
