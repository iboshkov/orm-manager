<template id="modelComponent" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <modal-meta-form v-on:submit="editSubmitted" :initial-data="modalData" v-on:close="showEditModal = false" :show="showEditModal" :class-name="className"></modal-meta-form>
        <modal-meta-form  :initial-data="{}" v-on:submit="createSubmitted" v-on:close="showCreateModal = false" :show="showCreateModal" :class-name="className"></modal-meta-form>
        <confirmation-modal v-on:positive="confirmationModalPositive"
                            v-on:negative="confirmationModalNegative"
                            v-on:close="showConfirmationModal = false"
                            message="Are you sure you want to delete the selected entry ?"
                            positive-class="is-danger"
                            positive-label="Delete"
                            negative-label="Cancel"
                            :show="showConfirmationModal">

            <span slot="beforeTitle" class="icon">
                <i class="fa fa-exclamation-triangle"></i>
            </span>
            <span slot="beforePositiveLabel" class="icon">
                <i class="fa fa-trash"></i>
            </span>
            <span slot="beforeNegativeLabel" class="icon">
                <i class="fa fa-ban"></i>
            </span>
        </confirmation-modal>

        <confirmation-modal

                v-on:positive="dropAllModalPositive"
                v-on:negative="showDropAllModal = false"
                v-on:close="showDropAllModal = false"
                message="Are you sure you want to delete the selected entry ?"
                positive-class="is-danger"
                positive-label="Delete"
                negative-label="Cancel"
                :show="showDropAllModal">

            <span slot="beforeTitle" class="icon">
                <i class="fa fa-exclamation-triangle"></i>
            </span>
            <span slot="beforePositiveLabel" class="icon">
                <i class="fa fa-trash"></i>
            </span>
            <span slot="beforeNegativeLabel" class="icon">
                <i class="fa fa-ban"></i>
            </span>
        </confirmation-modal>
        <nav class="panel">
            <p class="panel-heading">
                Model: <strong>{{ className | classOnly }}</strong>
            </p>

            <div class="panel-block">
                <p class="control">
                    <label class="label">Limit displayed value length</label>

                    <input class="input" type="number" v-model.number="testValue">
                </p>

                <p class="control">
                    <label class="label">Filter by model field</label>

                    <multiselect v-model="selected" :close-on-select="false" :multiple="true" track-by="name" label="humanName" :options="options" />
                </p>

            </div>
            <batch-controls v-if="!isLoading" v-on:new="createNew()" v-on:drop="dropAll"></batch-controls>
            <div class="panel-block">
                <table v-if="!isLoading" class="table is-striped is-narrow">
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
                    <tr v-if="!isLoading" v-for="entry in data">
                        <td v-for="attr in selected">
                            <span>{{ entry[attr.name] | truncate(testValue) }}</span>
                        </td>
                        <td>
                            <div class="control is-grouped is-pulled-right">
                                <p class="control">
                                    <button v-on:click="editEntry(entry)" class="button is-info is-outlined">
                                    <span class="icon is-small">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </span>
                                        <span>Edit</span>
                                    </button>
                                </p>
                                <p class="control">
                                    <button v-on:click="deleteEntry(entry)" class="button is-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <a v-else class="button is-loading is-fullwidth">Loading</a>

            </div>

            <batch-controls v-if="!isLoading" v-on:new="createNew()" v-on:drop="dropAll"></batch-controls>

        </nav>
    </div>
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

    import BatchControls from "./BatchControls.vue";
    import ModalMetaForm from "./ModalMetaForm.vue";
    import ConfirmationModal from "./ConfirmationModal.vue";

    export default{
        components: { Multiselect, BatchControls, ModalMetaForm, ConfirmationModal },
        mixins: [mixins],
        methods: {
            createNew() {
                this.showCreateModal = true;

            },
            createSubmitted(value) {
                console.log("Create new", value);
                var vm = this;
                // TODO: Abstract into resource.
                var data = {
                    "class": vm.className,
                    "data": value
                };
                this.$http.post('/orm/api/data/', data).then((response) => {
                    console.log("create new  Success", value, response);
                    // Reload data, just in case.
                    vm.loadData();
                }, (response) => {
                    console.log("create fail", response);
                    // error callback
                    // TODO Handle delete fail
                });
            },
            dropAll() {
                this.showDropAllModal= true;
            },
            dropAllModalPositive() {
                var vm = this;
                // TODO: Abstract into resource.
                var data = {
                    "class": vm.className
                };
                this.$http.delete('/orm/api/data/all', {params: data}).then((response) => {
                    console.log("delete all Success", response);
                    // Reload data, just in case.
                    vm.loadData();
                }, (response) => {
                    console.log("delete fail", response);
                    // error callback
                    // TODO Handle delete fail
                });
            },
            editSubmitted(value) {
                console.log("submitted", value);
                var vm = this;
                function matchPrimaryKey(element) {
                    return element[vm.meta.primaryKey] == value[vm.meta.primaryKey];
                };

                var entry = this.data.find(matchPrimaryKey);
                Object.assign(entry, value);
                console.log("Matched ", entry);
                this.modalData = value;
                // TODO: Abstract into resource.
                this.$http.put('/orm/api/data/', {
                    "class": vm.className,
                    "data": value
                }).then((response) => {
                    console.log("edit Success", response, vm.modalData);
                    // Reload data, just in case.
                    vm.loadData();
                }, (response) => {
                    console.log("edit fail", response);
                    // error callback
                    // TODO Handle edit fail
                });
            },
            updateSelected (newSelected) {
                this.selected = newSelected
            },
            emitEdit(entry) {
                console.log("Emitting click for", entry);
            },
            editEntry(entry) {
                console.log("Setting active model to", entry);

                this.modalData = entry;
                this.showEditModal = true;
            },
            deleteEntry(entry) {
                console.log("delete");
                this.toDelete = entry;
                this.showConfirmationModal = true;
            },
            confirmationModalPositive() {
                console.log("Positive");
                var vm = this;
                var data = {
                    "class": vm.className,
                    "data": vm.toDelete
                };
                console.log("Delete", data);
                // TODO: Abstract into resource.
                this.$http.delete('/orm/api/data/', {params: data}).then((response) => {
                    console.log("delete Success", response, vm.toDelete);
                    // Reload data, just in case.
                    vm.loadData();
                }, (response) => {
                    console.log("delete fail", response);
                    // error callback
                    // TODO Handle delete fail
                });

            },
            confirmationModalNegative() {
                console.log("Negative");
            },
            loadData() {
                var vm = this;
                vm.isLoading = true;
                vm.$http.get('/orm/api/meta/', {params: {
                    "class": vm.className
                }
                }).then((response) => {
                    console.log("Got model meta", response);
                    vm.meta = response.body;
                    vm.options = vm.meta.attributes;
                    vm.selected = vm.meta.attributes;

                    vm.$http.get('/orm/api/data/', {params: {
                        "class": vm.className
                    }
                    }).then((response) => {
                        console.log("Got data for meta", response);
                        vm.data = response.body;
                        vm.isLoading = false;
                    }, (response) => {
                        // error callback
                        vm.isLoading = false;
                    });
                }, (response) => {
                    // error callback
                    vm.isLoading = false;
                });
            }
        },
        data(){
            return{
                msg:'hello vue',
                testValue: 100,
                selected: null,
                showEditModal: false,
                showCreateModal: false,
                showConfirmationModal: false,
                showDropAllModal: false,
                modalData: {},
                toDelete: null,
                options: ['list', 'of', 'options'],
                isLoading: true,
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
