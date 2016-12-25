<template>
    <modal :include-footer="true" :title="title" v-on:close="negative" :show="show">
        <span slot="beforeTitle"><slot name="beforeTitle"></slot></span>
        <span slot="afterTitle"><slot name="afterTitle"></slot></span>

        {{ message }}

        <div slot="footer">
            <div class="control">
                <a v-on:click="positive()" :class="['button', positiveClass]">
                    <slot name="beforePositiveLabel"></slot>
                    <span>{{ positiveLabel }}</span>
                    <slot name="afterPositiveLabel"></slot>
                </a>
                <a v-on:click="negative()" :class="['button', negativeClass]">
                    <slot name="beforeNegativeLabel"></slot>
                    <span>{{ negativeLabel }}</span>
                    <slot name="afterNegativeLabel"></slot>
                </a>
            </div>
        </div>
    </modal>
</template>

<script>
    import Modal from "./Modal.vue";

    export default{
        methods: {
            positive() {
                this.$emit("positive");
                this.close();
            },
            negative() {
                this.$emit("negative");
                this.close();
            },
            close() {
                this.$emit("close");
            },
        },
        props: {
            title: {
                type: String,
                default: "Confirmation dialog"
            },
            message: {
                type: String,
                default: "Are you sure you want to commit the chosen action ?"
            },
            show: {
                type: Boolean,
                default: false
            },
            positiveLabel: {
                type: String,
                default: "Yes"
            },
            negativeLabel: {
                type: String,
                default: "No"
            },
            positiveClass: {
                type: String,
                default: "is-primary"
            },
            negativeClass: {
                type: String,
                default: ""
            }
        },
        components: {
            Modal
        }
    }
</script>
