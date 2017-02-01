<template>
    <div>
        <label class="label">{{ meta.name | humanize }}</label>
        format: {{dateFormat}}
        val: {{value}}
        Enable time: {{ enableTime }}
        Enable date: {{enableDate}}
        <p class="control">
            <input  class="input flatpickr" :value="value" type="text" placeholder="Select a date...">
        </p>
    </div>
</template>

<script>
    const Flatpickr = require("flatpickr");
    var moment = require('moment');
    var defaultFormatFull = "YYYY-MM-DD HH:mm:ss"; 
    var defaultFormatSplit = defaultFormatFull.split(" ");
    var defaultFormatTimeOnly = defaultFormatSplit[1];
    var defaultFormatDateOnly = defaultFormatSplit[0];
    export default {
        mounted() {
            this.dateFormat = "";
            if (this.enableDate) {
                this.dateFormat += defaultFormatDateOnly; 
            }
            if (this.enableTime) {
                this.dateFormat += (this.enableDate ? " " : "") + defaultFormatTimeOnly;
            }

						console.log("Date format", this.dateFormat);
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
                var targetDate = null;
                if (!vm.value) {
                    targetDate = new Date();
                    vm.updateValue(moment().format(vm.dateFormat));
                } else {
                    var mdate = moment(vm.value, vm.dateFormat);
                    vm.updateValue(mdate.format(vm.dateFormat));
                    targetDate = moment(vm.value, vm.dateFormat).toDate();
                }
                if (!vm.picker) {
                    var el = vm.$el.querySelector(".flatpickr");

                    vm.picker = new Flatpickr(el, {
                        defaultDate: targetDate,
                        enableDate: vm.enableDate,
                        enableTime: vm.enableTime,
                        enableSeconds: vm.enableTime,
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
            enableDate: {
                type: Boolean,
                default: true,
            },
            dateFormat: {
                type: String,
                default: defaultFormatFull
            },
            value: {
                type: String,
                default: ""
            }
        }
    }
</script>
