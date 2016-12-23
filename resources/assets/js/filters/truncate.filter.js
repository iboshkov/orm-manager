module.exports = function (val, stop, end) {
    if (val) {
        val = val.toString().slice(0, stop) + ((val.length > stop) ? end || "..." : "");
    }

    return val;
};
