<template>
    <div>
        <label class="label">{{ meta.name | humanize }}</label>
        format: {{dateFormat}}
        val: {{value}}
        <p class="control">
            <input class="input flatpickr" :value="value" type="text" placeholder="Select Date..">
        </p>
    </div>
</template>

<script>
    const Flatpickr = require("flatpickr");
    var moment = require('moment');
    var defaultFormat = "YYYY-MM-DD HH:mm:ss";

    export default {
        mounted() {
            this.rebind();
        },

        watch: {
            value: function(newVal) {
                this.rebind();
            },
            dateFormat: function (newVal) {
                this.rebind();
            }
        },
        data() {
            return {
                picker: null
            }
        },
        methods: {
            rebind() {
                var vm = this;
                var targetDate = moment(vm.value, vm.dateFormat).toDate();
                if (!vm.value) {
                    targetDate = new Date();
                }
                if (!vm.picker) {
                    var el = vm.$el.querySelector(".flatpickr");

                    vm.picker = Flatpickr(el, {
                        defaultDate: targetDate,
                        enableTime: true,
                        enableSeconds: true,
                        time_24hr: true,
                        onChange: function(selectedDates, dateStr, instance) {
                            vm.updateValue(dateStr);
                        }
                    });
                }

                vm.picker.jumpToDate(targetDate);
                console.log('Rebinding datetime control.', vm.picker, targetDate);

                //this.picker.jumpToDate(d);
            },
            updateValue: function (value) {
                console.log("DateTime control says", value);
                this.$emit('input', value);
            }
        },
        components: {
        },
        props: {
            meta: {
                type: Object
            },
            enableTime: {
                type: Boolean,
                    default: true
            },
            dateFormat: {
                type: String,
                default: defaultFormat
            },
            value: {
                type: String,
                default: ""
            }
        }
    }
</script>
