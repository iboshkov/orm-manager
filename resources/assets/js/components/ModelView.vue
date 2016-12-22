<template>
    <nav class="panel">
        <p class="panel-heading">
            Model: {{ className }}
        </p>
        <div class="panel-block">

            <h2 class="subtitle">Toggle fields</h2>
            <div class="columns">
                <div  v-for="attr in meta.attributes" class="column is-narrow">
                    <p class="control">
                        <label class="checkbox">
                            <input type="checkbox">
                            {{ attr.humanName }}
                        </label>
                    </p>
                </div>
            </div>

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
                    <th v-for="attr in meta.attributes">
                        {{ attr.humanName }}
                    </th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th v-for="attr in meta.attributes">
                        {{ attr.humanName }}
                    </th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                <tbody>
                    <tr v-for="entry in data">
                        <td v-for="attr in meta.attributes">
                            <span>{{ entry[attr.name] }}</span>
                        </td>
                        <td>
                            <div class="columns">
                                <div class="column">
                                    <button class="button is-primary is-fullwidth">
                                        Add New
                                    </button>
                                </div>
                                <div class="column">
                                    <button class="button is-danger is-fullwidth">
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
                    <button class="button is-primary is-outlined is-fullwidth">
                        Add New
                    </button>
                </div>
                <div class="column">
                    <button class="button is-danger is-outlined is-fullwidth">
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
    export default{
        data(){
            return{
                msg:'hello vue',
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
       },
        components:{
        }
    }
</script>
