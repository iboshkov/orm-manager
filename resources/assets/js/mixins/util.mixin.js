module.exports = {
    created: function () {
        this.hello()
    },
    methods: {
        hello: function () {
            console.log('hello from mixin!')
        },
        truncate: function (val, stop, end) {
            if (val) {
                val = val.slice(0, stop) + ((val.length > stop) ? end || "..." : "");
            }

            return val;
        }
    }
}