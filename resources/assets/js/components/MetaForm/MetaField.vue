<template>
    <div>
        <template v-if="meta.type == 'string'">
            <string-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'boolean'">
            <boolean-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'text'">
            <text-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'datetime' || meta.type == 'date' || meta.type == 'time'">
            <date-time-field :value="value" :enable-date="meta.type != 'time' || meta.type == 'date' || meta.type == 'date-time'" :enable-time="meta.type != 'date' || meta.type == 'datetime'" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'HasOne'">
            <has-one :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'BelongsTo'">
            <belongs-to :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'HasMany'">
            <has-many :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else-if="meta.type == 'BelongsToMany'">
            <belongs-to-many :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
        <template v-else>
            <div class="notification is-warning">
                <b>Warning:</b> <u>{{ meta.type | humanize }}</u> field types are not yet supported, so this is our best attempt at handling its value.
            </div>
           
            <string-field :value="value" v-on:input="updateValue" :meta="meta" />
        </template>
</div>
</template>

<script>
    import StringField from './Fields/StringField.vue';
    import BooleanField from './Fields/BooleanField.vue';
    import TextField from './Fields/TextField.vue';
    import DateTimeField from './Fields/DateTimeField.vue';
    import BelongsTo from './Fields/Relation/BelongsTo.vue';
    import HasMany from './Fields/Relation/HasMany.vue';
    import BelongsToMany from './Fields/Relation/BelongsToMany.vue';
    import HasOne from './Fields/Relation/HasOne.vue';

    export default {
        components: { StringField, BooleanField, TextField, DateTimeField, HasOne, BelongsTo, HasMany, BelongsToMany },
        mounted() {
            console.log('Meta field mounted.', this.value);
        },
        methods: {
            updateValue: function (value) {
                console.log("Meta field update", value)
                this.$emit('input', value)
            }
        },
        props: {
            meta: {
                type: Object
            },
            value: {
            }

        }
    }
</script>
