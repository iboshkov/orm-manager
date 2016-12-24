module.exports = function (val) {
    if (val) {
        val = val.split("\\").pop()
    }

    return val;
};