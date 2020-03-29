! function () {
    function n(l, e, t) {
        function a(r, i) {
            if (!e[r]) {
                if (!l[r]) {
                    var u = "function" == typeof require && require;
                    if (!i && u) return u(r, !0);
                    if (h) return h(r, !0);
                    var g = new Error("Cannot find module '" + r + "'");
                    throw g.code = "MODULE_NOT_FOUND", g
                }
                var v = e[r] = {
                    exports: {}
                };
                l[r][0].call(v.exports, function (n) {
                    return a(l[r][1][n] || n)
                }, v, v.exports, n, l, e, t)
            }
            return e[r].exports
        }
        for (var h = "function" == typeof require && require, r = 0; r < t.length; r++) a(t[r]);
        return a
    }
    return n
}()({
    1: [function (n, l, e) {
        l.exports = [{
            name: "visa_electron",
            pattern: "^4(026|17500|405|508|844|91[37])",
            length: [16],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "discover",
            pattern: "^6([045]|22)",
            length: [16],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "unionpay",
            pattern: "^62",
            length: [16, 17, 18, 19],
            cvcLength: [3],
            luhn: !1
        }, {
            name: "maestro",
            pattern: "^(5(0|[6-9])|6[0-4]|6[6-9])",
            length: [12, 13, 14, 15, 16, 17, 18, 19],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "visa",
            pattern: "^4",
            length: [13, 16, 19],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "mastercard",
            pattern: "^(5[1-5]|2[2-7])",
            length: [16],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "amex",
            pattern: "^3[47]",
            length: [15],
            cvcLength: [3, 4],
            luhn: !0
        }, {
            name: "diners",
            pattern: "^3[0689]",
            length: [14],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "jcb",
            pattern: "^35[2-8]",
            length: [16, 17, 18, 19],
            cvcLength: [3],
            luhn: !0
        }, {
            name: "uatp",
            pattern: "^1",
            length: [15],
            cvcLength: [3],
            luhn: !0
        }]
    }, {}],
    2: [function (n, l, e) {
        const t = n("./data/validation.json");
        var a = {};
        a.luhn = function (n) {
            var l = 0,
                e = 0,
                t = !1;
            n = n.replace(/\D/g, "");
            for (var a = n.length - 1; a >= 0; a--) {
                var h = n.charAt(a),
                    e = parseInt(h, 10);
                t && (e *= 2) > 9 && (e -= 9), l += e, t = !t
            }
            return l % 10 == 0
        }, a.validatePAN = function (n) {
            if (!n) return {
                valid: null
            };
            var n = n.replace(/\D/g, ""),
                l = {
                    length_valid: null,
                    luhn_valid: null,
                    maxlengh: 19,
                    length: n.length
                },
                e = null;
            for (i in t) {
                var a = t[i];
                if (new RegExp(a.pattern).exec(n)) {
                    e = a;
                    break
                }
            }
            return null != e && (l.card_name = e.name, l.length_valid = -1 != a.length.indexOf(n.length), l.luhn_valid = a.luhn ? this.luhn(n) : null, l.valid = l.length_valid && (l.luhn_valid || null === l.luhn_valid), l.maxlength = Math.max.apply(null, a.length)), l
        }, a.validateCVV = function (n) {
            if (!n) return {
                valid: null
            };
            var n = n.replace(/\D/g, ""),
                l = {
                    length_valid: 3 == n.length || 4 == n.length,
                    maxlength: 4,
                    length: n.length
                };
            return l.valid = l.length_valid, l
        }, a.validate = function (n, l) {
            var n = n.replace(/\D/g, ""),
                l = l.replace(/\D/g, ""),
                e = {
                    valid: null,
                    pan: {
                        length_valid: null,
                        luhn_valid: null,
                        maxlength: 19,
                        length: n.length
                    },
                    cvv: {
                        length_valid: null,
                        maxlength: 4,
                        length: l.length
                    }
                },
                a = null;
            for (i in t) {
                var h = t[i];
                if (new RegExp(h.pattern).exec(n)) {
                    a = h;
                    break
                }
            }
            return null != a && (e.card_name = a.name, e.pan.length_valid = -1 != h.length.indexOf(n.length), e.cvv.length_valid = -1 != h.cvcLength.indexOf(l.length), e.pan.luhn_valid = h.luhn ? this.luhn(n) : null, e.valid = e.pan.length_valid && e.cvv.length_valid && (e.pan.luhn_valid || null === e.pan.luhn_valid), e.pan.maxlength = Math.max.apply(null, h.length), e.cvv.maxlength = Math.max.apply(null, h.cvcLength)), e
        }, window.VaultValidator = a
    }, {
        "./data/validation.json": 1
    }]
}, {}, [2]);