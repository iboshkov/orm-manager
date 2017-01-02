<template>
    <transition name="fade" :appear="show">
        <div v-if="show" :class="['modal', 'is-active']">
            <div v-on:click="close()" class="modal-background"></div>
            <transition name="bounce" :appear="show">

                <div class="modal-card">
                    <header v-if="includeHeader" class="modal-card-head">
                        <slot name="beforeTitle"></slot>
                        <span v-if="showTitle" class="modal-card-title"><strong>{{ title }}</strong></span>
                        <slot name="afterTitle"></slot>

                        <button v-on:click="close()" class="delete"></button>
                    </header>

                    <section class="modal-card-body">
                        {{ message }}
                        <slot></slot>
                    </section>

                    <footer v-if="includeFooter" class="modal-card-foot">
                        <slot name="footer"></slot>
                    </footer>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
    // TODO: Implement close on escape.
    export default{
        methods: {
            close() {
                this.$emit("close");
            }
        },
        mounted() {
            console.log("Modal mounted");
            document.body.appendChild(this.$el);
        },

        props: {
            title: {
                type: String,
                default: "Modal Title"
            },
            message: {
                type: String,
                default: ""
            },
            closeOnBackgroundClick: {
                type: Boolean,
                default: true
            },
            show: {
                type: Boolean,
                default: false
            },
            showTitle: {
                type: Boolean,
                default: true
            },
            includeHeader: {
                type: Boolean,
                default: true
            },
            includeFooter: {
                type: Boolean,
                default: false
            },
            closeOnEscape: {
                type: Boolean,
                default: true
            }
        }
    }
</script>
