function(e) {
    function t(r) {
        if (n[r]) return n[r].exports;
        var o = n[r] = {
            i: r,
            l: !1,
            exports: {}
        };
        return e[r].call(o.exports, o, o.exports, t), o.l = !0, o.exports
    }
    var n = {};
    t.m = e, t.c = n, t.d = function(e, n, r) {
        t.o(e, n) || Object.defineProperty(e, n, {
            configurable: !1,
            enumerable: !0,
            get: r
        })
    }, t.n = function(e) {
        var n = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return t.d(n, "a", n), n
    }, t.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, t.p = "//assets.alicdn.com/g/msite/header/0.0.52/", t(t.s = 3)
}([function(e, t) {
    e.exports = preact
}, function(e, t, n) {
    var r, o;
    /*!
      Copyright (c) 2017 Jed Watson.
      Licensed under the MIT License (MIT), see
      http://jedwatson.github.io/classnames
    */
    ! function() {
        "use strict";

        function n() {
            for (var e = [], t = 0; t < arguments.length; t++) {
                var r = arguments[t];
                if (r) {
                    var o = typeof r;
                    if ("string" === o || "number" === o) e.push(r);
                    else if (Array.isArray(r) && r.length) {
                        var i = n.apply(null, r);
                        i && e.push(i)
                    } else if ("object" === o)
                        for (var c in r) a.call(r, c) && r[c] && e.push(c)
                }
            }
            return e.join(" ")
        }
        var a = {}.hasOwnProperty;
        void 0 !== e && e.exports ? (n.default = n, e.exports = n) : (r = [], void 0 !== (o = function() {
            return n
        }.apply(t, r)) && (e.exports = o))
    }()
}, function(e, t, n) {
    var r, o, a;
    ! function(n, i) {
        o = [t, e], r = i, void 0 !== (a = "function" == typeof r ? r.apply(t, o) : r) && (e.exports = a)
    }(0, function(e, t) {
        "use strict";

        function n() {
            return "jsonp_" + Date.now() + "_" + Math.ceil(1e5 * Math.random())
        }

        function r(e) {
            try {
                delete window[e]
            } catch (t) {
                window[e] = void 0
            }
        }

        function o(e) {
            var t = document.getElementById(e);
            t && document.getElementsByTagName("head")[0].removeChild(t)
        }

        function a(e) {
            var t = arguments.length <= 1 || void 0 === arguments[1] ? {} : arguments[1],
                a = e,
                c = t.timeout || i.timeout,
                s = t.jsonpCallback || i.jsonpCallback,
                l = void 0;
            return new Promise(function(i, u) {
                var f = t.jsonpCallbackFunction || n(),
                    p = s + "_" + f;
                window[f] = function(e) {
                    i({
                        ok: !0,
                        json: function() {
                            return Promise.resolve(e)
                        }
                    }), l && clearTimeout(l), o(p), r(f)
                }, a += -1 === a.indexOf("?") ? "?" : "&";
                var h = document.createElement("script");
                h.setAttribute("src", "" + a + s + "=" + f), t.charset && h.setAttribute("charset", t.charset), h.id = p, document.getElementsByTagName("head")[0].appendChild(h), l = setTimeout(function() {
                    u(new Error("JSONP request to " + e + " timed out")), r(f), o(p), window[f] = function() {
                        r(f)
                    }
                }, c), h.onerror = function() {
                    u(new Error("JSONP request to " + e + " failed")), r(f), o(p), l && clearTimeout(l)
                }
            })
        }
        var i = {
            timeout: 5e3,
            jsonpCallback: "callback",
            jsonpCallbackFunction: null
        };
        t.exports = a
    })
}, function(e, t, n) {
    n(4), e.exports = n(5)
}, function(e, t, n) {
    "use strict";

    function r(e) {
        return e && DataView.prototype.isPrototypeOf(e)
    }

    function o(e) {
        if ("string" != typeof e && (e = String(e)), /[^a-z0-9\-#$%&'*+.^_`|~]/i.test(e)) throw new TypeError("Invalid character in header field name");
        return e.toLowerCase()
    }

    function a(e) {
        return "string" != typeof e && (e = String(e)), e
    }

    function i(e) {
        var t = {
            next: function() {
                var t = e.shift();
                return {
                    done: void 0 === t,
                    value: t
                }
            }
        };
        return E.iterable && (t[Symbol.iterator] = function() {
            return t
        }), t
    }

    function c(e) {
        this.map = {}, e instanceof c ? e.forEach(function(e, t) {
            this.append(t, e)
        }, this) : Array.isArray(e) ? e.forEach(function(e) {
            this.append(e[0], e[1])
        }, this) : e && Object.getOwnPropertyNames(e).forEach(function(t) {
            this.append(t, e[t])
        }, this)
    }

    function s(e) {
        if (e.bodyUsed) return Promise.reject(new TypeError("Already read"));
        e.bodyUsed = !0
    }

    function l(e) {
        return new Promise(function(t, n) {
            e.onload = function() {
                t(e.result)
            }, e.onerror = function() {
                n(e.error)
            }
        })
    }

    function u(e) {
        var t = new FileReader,
            n = l(t);
        return t.readAsArrayBuffer(e), n
    }

    function f(e) {
        var t = new FileReader,
            n = l(t);
        return t.readAsText(e), n
    }

    function p(e) {
        for (var t = new Uint8Array(e), n = new Array(t.length), r = 0; r < t.length; r++) n[r] = String.fromCharCode(t[r]);
        return n.join("")
    }

    function h(e) {
        if (e.slice) return e.slice(0);
        var t = new Uint8Array(e.byteLength);
        return t.set(new Uint8Array(e)), t.buffer
    }

    function m() {
        return this.bodyUsed = !1, this._initBody = function(e) {
            this._bodyInit = e, e ? "string" == typeof e ? this._bodyText = e : E.blob && Blob.prototype.isPrototypeOf(e) ? this._bodyBlob = e : E.formData && FormData.prototype.isPrototypeOf(e) ? this._bodyFormData = e : E.searchParams && URLSearchParams.prototype.isPrototypeOf(e) ? this._bodyText = e.toString() : E.arrayBuffer && E.blob && r(e) ? (this._bodyArrayBuffer = h(e.buffer), this._bodyInit = new Blob([this._bodyArrayBuffer])) : E.arrayBuffer && (ArrayBuffer.prototype.isPrototypeOf(e) || S(e)) ? this._bodyArrayBuffer = h(e) : this._bodyText = e = Object.prototype.toString.call(e) : this._bodyText = "", this.headers.get("content-type") || ("string" == typeof e ? this.headers.set("content-type", "text/plain;charset=UTF-8") : this._bodyBlob && this._bodyBlob.type ? this.headers.set("content-type", this._bodyBlob.type) : E.searchParams && URLSearchParams.prototype.isPrototypeOf(e) && this.headers.set("content-type", "application/x-www-form-urlencoded;charset=UTF-8"))
        }, E.blob && (this.blob = function() {
            var e = s(this);
            if (e) return e;
            if (this._bodyBlob) return Promise.resolve(this._bodyBlob);
            if (this._bodyArrayBuffer) return Promise.resolve(new Blob([this._bodyArrayBuffer]));
            if (this._bodyFormData) throw new Error("could not read FormData body as blob");
            return Promise.resolve(new Blob([this._bodyText]))
        }, this.arrayBuffer = function() {
            return this._bodyArrayBuffer ? s(this) || Promise.resolve(this._bodyArrayBuffer) : this.blob().then(u)
        }), this.text = function() {
            var e = s(this);
            if (e) return e;
            if (this._bodyBlob) return f(this._bodyBlob);
            if (this._bodyArrayBuffer) return Promise.resolve(p(this._bodyArrayBuffer));
            if (this._bodyFormData) throw new Error("could not read FormData body as text");
            return Promise.resolve(this._bodyText)
        }, E.formData && (this.formData = function() {
            return this.text().then(b)
        }), this.json = function() {
            return this.text().then(JSON.parse)
        }, this
    }

    function d(e) {
        var t = e.toUpperCase();
        return k.indexOf(t) > -1 ? t : e
    }

    function y(e, t) {
        t = t || {};
        var n = t.body;
        if (e instanceof y) {
            if (e.bodyUsed) throw new TypeError("Already read");
            this.url = e.url, this.credentials = e.credentials, t.headers || (this.headers = new c(e.headers)), this.method = e.method, this.mode = e.mode, this.signal = e.signal, n || null == e._bodyInit || (n = e._bodyInit, e.bodyUsed = !0)
        } else this.url = String(e);
        if (this.credentials = t.credentials || this.credentials || "same-origin", !t.headers && this.headers || (this.headers = new c(t.headers)), this.method = d(t.method || this.method || "GET"), this.mode = t.mode || this.mode || null, this.signal = t.signal || this.signal, this.referrer = null, ("GET" === this.method || "HEAD" === this.method) && n) throw new TypeError("Body not allowed for GET or HEAD requests");
        this._initBody(n)
    }

    function b(e) {
        var t = new FormData;
        return e.trim().split("&").forEach(function(e) {
            if (e) {
                var n = e.split("="),
                    r = n.shift().replace(/\+/g, " "),
                    o = n.join("=").replace(/\+/g, " ");
                t.append(decodeURIComponent(r), decodeURIComponent(o))
            }
        }), t
    }

    function g(e) {
        var t = new c;
        return e.replace(/\r?\n[\t ]+/g, " ").split(/\r?\n/).forEach(function(e) {
            var n = e.split(":"),
                r = n.shift().trim();
            if (r) {
                var o = n.join(":").trim();
                t.append(r, o)
            }
        }), t
    }

    function v(e, t) {
        t || (t = {}), this.type = "default", this.status = void 0 === t.status ? 200 : t.status, this.ok = this.status >= 200 && this.status < 300, this.statusText = "statusText" in t ? t.statusText : "OK", this.headers = new c(t.headers), this.url = t.url || "", this._initBody(e)
    }

    function w(e, t) {
        return new Promise(function(n, r) {
            function o() {
                i.abort()
            }
            var a = new y(e, t);
            if (a.signal && a.signal.aborted) return r(new O("Aborted", "AbortError"));
            var i = new XMLHttpRequest;
            i.onload = function() {
                var e = {
                    status: i.status,
                    statusText: i.statusText,
                    headers: g(i.getAllResponseHeaders() || "")
                };
                e.url = "responseURL" in i ? i.responseURL : e.headers.get("X-Request-URL");
                var t = "response" in i ? i.response : i.responseText;
                n(new v(t, e))
            }, i.onerror = function() {
                r(new TypeError("Network request failed"))
            }, i.ontimeout = function() {
                r(new TypeError("Network request failed"))
            }, i.onabort = function() {
                r(new O("Aborted", "AbortError"))
            }, i.open(a.method, a.url, !0), "include" === a.credentials ? i.withCredentials = !0 : "omit" === a.credentials && (i.withCredentials = !1), "responseType" in i && E.blob && (i.responseType = "blob"), a.headers.forEach(function(e, t) {
                i.setRequestHeader(t, e)
            }), a.signal && (a.signal.addEventListener("abort", o), i.onreadystatechange = function() {
                4 === i.readyState && a.signal.removeEventListener("abort", o)
            }), i.send(void 0 === a._bodyInit ? null : a._bodyInit)
        })
    }
    Object.defineProperty(t, "__esModule", {
        value: !0
    }), t.Headers = c, t.Request = y, t.Response = v, n.d(t, "DOMException", function() {
        return O
    }), t.fetch = w;
    var E = {
        searchParams: "URLSearchParams" in self,
        iterable: "Symbol" in self && "iterator" in Symbol,
        blob: "FileReader" in self && "Blob" in self && function() {
            try {
                return new Blob, !0
            } catch (e) {
                return !1
            }
        }(),
        formData: "FormData" in self,
        arrayBuffer: "ArrayBuffer" in self
    };
    if (E.arrayBuffer) var C = ["[object Int8Array]", "[object Uint8Array]", "[object Uint8ClampedArray]", "[object Int16Array]", "[object Uint16Array]", "[object Int32Array]", "[object Uint32Array]", "[object Float32Array]", "[object Float64Array]"],
        S = ArrayBuffer.isView || function(e) {
            return e && C.indexOf(Object.prototype.toString.call(e)) > -1
        };
    c.prototype.append = function(e, t) {
        e = o(e), t = a(t);
        var n = this.map[e];
        this.map[e] = n ? n + ", " + t : t
    }, c.prototype.delete = function(e) {
        delete this.map[o(e)]
    }, c.prototype.get = function(e) {
        return e = o(e), this.has(e) ? this.map[e] : null
    }, c.prototype.has = function(e) {
        return this.map.hasOwnProperty(o(e))
    }, c.prototype.set = function(e, t) {
        this.map[o(e)] = a(t)
    }, c.prototype.forEach = function(e, t) {
        for (var n in this.map) this.map.hasOwnProperty(n) && e.call(t, this.map[n], n, this)
    }, c.prototype.keys = function() {
        var e = [];
        return this.forEach(function(t, n) {
            e.push(n)
        }), i(e)
    }, c.prototype.values = function() {
        var e = [];
        return this.forEach(function(t) {
            e.push(t)
        }), i(e)
    }, c.prototype.entries = function() {
        var e = [];
        return this.forEach(function(t, n) {
            e.push([n, t])
        }), i(e)
    }, E.iterable && (c.prototype[Symbol.iterator] = c.prototype.entries);
    var k = ["DELETE", "GET", "HEAD", "OPTIONS", "POST", "PUT"];
    y.prototype.clone = function() {
        return new y(this, {
            body: this._bodyInit
        })
    }, m.call(y.prototype), m.call(v.prototype), v.prototype.clone = function() {
        return new v(this._bodyInit, {
            status: this.status,
            statusText: this.statusText,
            headers: new c(this.headers),
            url: this.url
        })
    }, v.error = function() {
        var e = new v(null, {
            status: 0,
            statusText: ""
        });
        return e.type = "error", e
    };
    var A = [301, 302, 303, 307, 308];
    v.redirect = function(e, t) {
        if (-1 === A.indexOf(t)) throw new RangeError("Invalid status code");
        return new v(null, {
            status: t,
            headers: {
                location: e
            }
        })
    };
    var O = self.DOMException;
    try {
        new O
    } catch (e) {
        O = function(e, t) {
            this.message = e, this.name = t;
            var n = Error(e);
            this.stack = n.stack
        }, O.prototype = Object.create(Error.prototype), O.prototype.constructor = O
    }
    w.polyfill = !0, self.fetch || (self.fetch = w, self.Headers = c, self.Request = y, self.Response = v)
}, function(e, t, n) {
    "use strict";

    function r(e) {
        return (r = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function o(e) {
        for (var t = 1; t < arguments.length; t++) {
            var n = null != arguments[t] ? arguments[t] : {},
                r = Object.keys(n);
            "function" == typeof Object.getOwnPropertySymbols && (r = r.concat(Object.getOwnPropertySymbols(n).filter(function(e) {
                return Object.getOwnPropertyDescriptor(n, e).enumerable
            }))), r.forEach(function(t) {
                a(e, t, n[t])
            })
        }
        return e
    }

    function a(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function i(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function c(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function s(e, t, n) {
        return t && c(e.prototype, t), n && c(e, n), e
    }

    function l(e, t) {
        return !t || "object" !== r(t) && "function" != typeof t ? u(e) : t
    }

    function u(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function f(e) {
        return (f = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function p(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && h(e, t)
    }

    function h(e, t) {
        return (h = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function m(e) {
        return (m = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function d(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function y(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function b(e, t, n) {
        return t && y(e.prototype, t), n && y(e, n), e
    }

    function g(e, t) {
        return !t || "object" !== m(t) && "function" != typeof t ? w(e) : t
    }

    function v(e) {
        return (v = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function w(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function E(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && C(e, t)
    }

    function C(e, t) {
        return (C = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function S(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function k(e) {
        return (k = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function A() {
        return A = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        }, A.apply(this, arguments)
    }

    function O(e, t) {
        return j(e) || I(e, t) || _()
    }

    function _() {
        throw new TypeError("Invalid attempt to destructure non-iterable instance")
    }

    function I(e, t) {
        var n = [],
            r = !0,
            o = !1,
            a = void 0;
        try {
            for (var i, c = e[Symbol.iterator](); !(r = (i = c.next()).done) && (n.push(i.value), !t || n.length !== t); r = !0);
        } catch (e) {
            o = !0, a = e
        } finally {
            try {
                r || null == c.return || c.return()
            } finally {
                if (o) throw a
            }
        }
        return n
    }

    function j(e) {
        if (Array.isArray(e)) return e
    }

    function x(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function P(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function T(e, t, n) {
        return t && P(e.prototype, t), n && P(e, n), e
    }

    function M(e, t) {
        return !t || "object" !== k(t) && "function" != typeof t ? U(e) : t
    }

    function U(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function R(e) {
        return (R = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function D(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && B(e, t)
    }

    function B(e, t) {
        return (B = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function N(e, t) {
        var n = {};
        if (q(e) && e.length > 0)
            for (var r, o, a, i = t ? Lt : L, c = e.split(/;\s/g), s = 0, l = c.length; s < l; s++) {
                if ((a = c[s].match(/([^=]+)=/i)) instanceof Array) try {
                    r = Lt(a[1]), o = i(c[s].substring(a[1].length + 1))
                } catch (e) {} else r = Lt(c[s]), o = "";
                r && (n[r] = o)
            }
        return n
    }

    function q(e) {
        return "string" == typeof e
    }

    function F(e) {
        return q(e) && "" !== e
    }

    function V(e) {
        if (!F(e)) throw new TypeError("Cookie name must be a non-empty string")
    }

    function L(e) {
        return e
    }

    function G(e) {
        return (G = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function J(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function K(e, t) {
        return !t || "object" !== G(t) && "function" != typeof t ? Q(e) : t
    }

    function Q(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function Z(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && X(e, t)
    }

    function z(e) {
        var t = "function" == typeof Map ? new Map : void 0;
        return (z = function(e) {
            function n() {
                return W(e, arguments, $(this).constructor)
            }
            if (null === e || !Y(e)) return e;
            if ("function" != typeof e) throw new TypeError("Super expression must either be null or a function");
            if (void 0 !== t) {
                if (t.has(e)) return t.get(e);
                t.set(e, n)
            }
            return n.prototype = Object.create(e.prototype, {
                constructor: {
                    value: n,
                    enumerable: !1,
                    writable: !0,
                    configurable: !0
                }
            }), X(n, e)
        })(e)
    }

    function H() {
        if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
        if (Reflect.construct.sham) return !1;
        if ("function" == typeof Proxy) return !0;
        try {
            return Date.prototype.toString.call(Reflect.construct(Date, [], function() {})), !0
        } catch (e) {
            return !1
        }
    }

    function W(e, t, n) {
        return W = H() ? Reflect.construct : function(e, t, n) {
            var r = [null];
            r.push.apply(r, t);
            var o = Function.bind.apply(e, r),
                a = new o;
            return n && X(a, n.prototype), a
        }, W.apply(null, arguments)
    }

    function Y(e) {
        return -1 !== Function.toString.call(e).indexOf("[native code]")
    }

    function X(e, t) {
        return (X = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function $(e) {
        return ($ = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function ee() {
        return new Promise(function(e, t) {
            An() ? e(!0) : (t({
                type: "not_sign_in"
            }), location.href = "https://m.alibaba.com/login.html?return_url=".concat(encodeURIComponent(location.href)))
        })
    }

    function te(e) {
        return ee().then(function() {
            location.href = e
        }).catch(function(t) {
            t && "not_sign_in" === t.type && (location.href = "https://m.alibaba.com/login.html?return_url=".concat(encodeURIComponent(e)))
        })
    }

    function ne(e, t, n) {
        return "m.alibaba.com" !== n ? "https://".concat(n, "/p-detail/").concat(t.replace(/\W/g, "-"), "-").concat(e, ".html") : "https://".concat(n, "/product/").concat(e, "/").concat(t.replace(/\W/g, "-"), ".html")
    }

    function re() {
        return new Promise(function(e) {
            er() ? e(!0) : location.href = "https://m.alibaba.com/login.html?return_url=".concat(encodeURIComponent(location.href))
        })
    }

    function oe(e) {
        return re().then(function() {
            location.href = e
        })
    }

    function ae(e, t) {
        return Ut.a.createElement("a", {
            class: ["search-bar", t && "header-item inline-search-bar"].filter(function(e) {
                return e
            }).join(" ")
        }, Ut.a.createElement("div", {
            class: "search-text",
            onClick: e.onClickSearch
        }, Ut.a.createElement("span", null, e.searchText), Ut.a.createElement("div", {
            class: "icon-wrap"
        }, Ut.a.createElement("i", {
            class: "iconfont-search"
        }))))
    }

    function ie(e) {
        return (ie = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function ce() {
        return ce = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        }, ce.apply(this, arguments)
    }

    function se(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function le(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function ue(e, t, n) {
        return t && le(e.prototype, t), n && le(e, n), e
    }

    function fe(e, t) {
        return !t || "object" !== ie(t) && "function" != typeof t ? he(e) : t
    }

    function pe(e) {
        return (pe = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function he(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function me(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && de(e, t)
    }

    function de(e, t) {
        return (de = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function ye(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function be() {
        return be = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        }, be.apply(this, arguments)
    }

    function ge() {
        return !!window.localStorage && (window.localStorage.setItem("test_localstorage", 123), 123 == window.localStorage.getItem("test_localstorage") && (window.localStorage.removeItem("test_localstorage"), !0))
    }

    function ve(e) {
        var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
        if (!ge()) return "";
        var n = window.localStorage.getItem(e);
        return n = Ce(e, n), n && t && n.data ? Number(n.cacheTime) < (new Date).getTime() ? (Ee(e), "") : n.data : n
    }

    function we(e, t, n) {
        var r = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 3e5;
        if (!ge()) return "";
        if (n) {
            var o = (new Date).getTime() + r;
            return window.localStorage.setItem(e, JSON.stringify({
                data: t,
                cacheTime: o
            }))
        }
        return window.localStorage.setItem(e, JSON.stringify(t))
    }

    function Ee(e) {
        return ge() ? window.localStorage.removeItem(e) : ""
    }

    function Ce(e, t) {
        var n = "";
        try {
            n = JSON.parse(t)
        } catch (t) {
            Ee(e), n = ""
        }
        return n
    }

    function Se(e) {
        return (Se = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function ke(e) {
        for (var t = 1; t < arguments.length; t++) {
            var n = null != arguments[t] ? arguments[t] : {},
                r = Object.keys(n);
            "function" == typeof Object.getOwnPropertySymbols && (r = r.concat(Object.getOwnPropertySymbols(n).filter(function(e) {
                return Object.getOwnPropertyDescriptor(n, e).enumerable
            }))), r.forEach(function(t) {
                Me(e, t, n[t])
            })
        }
        return e
    }

    function Ae(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function Oe(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function _e(e, t, n) {
        return t && Oe(e.prototype, t), n && Oe(e, n), e
    }

    function Ie(e, t) {
        return !t || "object" !== Se(t) && "function" != typeof t ? xe(e) : t
    }

    function je(e) {
        return (je = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function xe(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function Pe(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && Te(e, t)
    }

    function Te(e, t) {
        return (Te = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function Me(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function Ue(e) {
        try {
            return localStorage.getItem(e)
        } catch (e) {
            return console.error(e), null
        }
    }

    function Re(e, t) {
        try {
            localStorage.setItem(e, t)
        } catch (e) {
            console.error(e)
        }
    }

    function De(e) {
        var t = JSON.parse(Ue("mod:search-bar")) || {
                his: []
            },
            n = t.his,
            r = n.indexOf(e);
        if (-1 !== r) return n.splice(r, 1), n.push(e), void Re("mod:search-bar", JSON.stringify(t));
        t.his.push(e), t.his.length > Br && t.his.splice(0, t.his.length - Br), Re("mod:search-bar", JSON.stringify(t))
    }

    function Be() {
        return (JSON.parse(Ue("mod:search-bar")) || {
            his: []
        }).his
    }

    function Ne() {
        var e = JSON.parse(Ue("mod:search-bar"));
        e && (e.his = [], Re("mod:search-bar", JSON.stringify(e)))
    }

    function qe(e, t) {
        if (t && t.key) {
            var n = cn.core.get("mobile_language") || "EN",
                r = "//connectkeyword.alibaba.com/mobileLenoIframeJson.htm?searchText=" + t.key;
            "supplier" === t["suggest-type"] && (r = "//connectkeyword.alibaba.com/lenoWapJson.htm?keyword=" + t.key), "EN" != n ? (r = "//connectkeyword.alibaba.com/mutilLenoIframeJson.htm?keyword=" + t.key, n = n.toLowerCase(), r += "&language=" + n + "&__number=1") : r += "&searchNum=10", r += "&searchType=product_en&varname=JSONVSearchSuggestion&_=" + (new Date).getTime(), window.JSONVSearchSuggestion = [], Fr(r, e)
        }
    }

    function Fe(e) {
        return (Fe = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function Ve(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function Le(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function Ge(e, t, n) {
        return t && Le(e.prototype, t), n && Le(e, n), e
    }

    function Je(e, t) {
        return !t || "object" !== Fe(t) && "function" != typeof t ? Qe(e) : t
    }

    function Ke(e) {
        return (Ke = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function Qe(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function Ze(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && ze(e, t)
    }

    function ze(e, t) {
        return (ze = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function He(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function We(e) {
        return (We = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function Ye(e) {
        for (var t = 1; t < arguments.length; t++) {
            var n = null != arguments[t] ? arguments[t] : {},
                r = Object.keys(n);
            "function" == typeof Object.getOwnPropertySymbols && (r = r.concat(Object.getOwnPropertySymbols(n).filter(function(e) {
                return Object.getOwnPropertyDescriptor(n, e).enumerable
            }))), r.forEach(function(t) {
                it(e, t, n[t])
            })
        }
        return e
    }

    function Xe(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function $e(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function et(e, t, n) {
        return t && $e(e.prototype, t), n && $e(e, n), e
    }

    function tt(e, t) {
        return !t || "object" !== We(t) && "function" != typeof t ? rt(e) : t
    }

    function nt(e) {
        return (nt = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function rt(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function ot(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && at(e, t)
    }

    function at(e, t) {
        return (at = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function it(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function ct(e) {
        return (ct = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function st(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function lt(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function ut(e, t, n) {
        return t && lt(e.prototype, t), n && lt(e, n), e
    }

    function ft(e, t) {
        return !t || "object" !== ct(t) && "function" != typeof t ? ht(e) : t
    }

    function pt(e) {
        return (pt = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function ht(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function mt(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && dt(e, t)
    }

    function dt(e, t) {
        return (dt = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function yt(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function bt(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function gt(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function vt(e, t, n) {
        return t && gt(e.prototype, t), n && gt(e, n), e
    }

    function wt(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function Et(e) {
        return e = e || "", 0 == e.indexOf("//") && (e = location.protocol + e), e
    }

    function Ct(e) {
        var t = zr[e.type] || {},
            n = t.url || "";
        return "copy" === e.type ? e.url : (n = n.replace(/{url}/g, encodeURIComponent(e.url || "")), n = n.replace(/{title}/g, encodeURIComponent(e.title || "")), n = n.replace(/{text}/g, encodeURIComponent(e.text || "")), n = n.replace(/{image}/g, encodeURIComponent(e.image || "")))
    }

    function St(e) {
        return (St = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function kt(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function At(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
        }
    }

    function Ot(e, t, n) {
        return t && At(e.prototype, t), n && At(e, n), e
    }

    function _t(e, t) {
        return !t || "object" !== St(t) && "function" != typeof t ? jt(e) : t
    }

    function It(e) {
        return (It = Object.setPrototypeOf ? Object.getPrototypeOf : function(e) {
            return e.__proto__ || Object.getPrototypeOf(e)
        })(e)
    }

    function jt(e) {
        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return e
    }

    function xt(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                writable: !0,
                configurable: !0
            }
        }), t && Pt(e, t)
    }

    function Pt(e, t) {
        return (Pt = Object.setPrototypeOf || function(e, t) {
            return e.__proto__ = t, e
        })(e, t)
    }

    function Tt(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }
    Object.defineProperty(t, "__esModule", {
        value: !0
    });
    var Mt = n(0),
        Ut = n.n(Mt),
        Rt = (n(6), n(1)),
        Dt = n.n(Rt),
        Bt = (n(7), {
            width: "100%",
            height: 0,
            left: 0,
            top: 0,
            opacity: 0
        }),
        Nt = function(e) {
            function t(e) {
                return i(this, t), l(this, f(t).call(this, e))
            }
            return p(t, e), s(t, [{
                key: "render",
                value: function() {
                    var e = this.props.style,
                        t = void 0 === e ? {} : e,
                        n = o({}, Bt, t),
                        r = this.props.class || this.props.className || "",
                        a = Dt()("fixed-panel", r, {
                            disabled: n.opacity <= 0
                        });
                    return Ut.a.createElement("div", {
                        class: a,
                        style: n
                    }, this.props.children)
                }
            }]), t
        }(Mt.Component),
        qt = function(e) {
            function t(e) {
                var n;
                return d(this, t), n = g(this, v(t).call(this, e)), S(w(n), "updateIntersectionRate", function(e) {
                    var t = n.props,
                        r = t.movingInRange,
                        o = t.start,
                        a = t.end,
                        i = 0;
                    i = e < o ? 0 : e < a ? (e - o) / (a - o) : 1, r(i), n.setState({
                        rate: i
                    })
                }), n.state = {
                    rate: 0
                }, n
            }
            return E(t, e), b(t, [{
                key: "componentDidMount",
                value: function() {
                    var e = this,
                        t = this.props,
                        n = t.throttle,
                        r = t.start,
                        o = t.end;
                    if (!(r > o)) {
                        var a = Date.now(),
                            i = null;
                        window.addEventListener("scroll", function() {
                            var t = Date.now();
                            if (t - a >= n) {
                                var o = window.scrollY;
                                o >= r && (e.updateIntersectionRate(o), window.clearTimeout(i), i = window.setTimeout(function() {
                                    e.updateIntersectionRate(window.scrollY)
                                }, n + 100)), a = t
                            }
                        })
                    }
                }
            }, {
                key: "getChildContext",
                value: function() {
                    return {
                        rate: this.state.rate
                    }
                }
            }, {
                key: "render",
                value: function() {
                    return this.props.children[0]
                }
            }]), t
        }(Mt.Component);
    S(qt, "defaultProps", {
        start: 0,
        end: 0,
        throttle: 30,
        movingInRange: function() {}
    });
    var Ft = function(e) {
        function t(e) {
            var n;
            return x(this, t), n = M(this, R(t).call(this, e)), n.state = {
                rate: 0
            }, n
        }
        return D(t, e), T(t, [{
            key: "updateOpacity",
            value: function() {
                var e = this.props.opacityRange,
                    t = this.state.rate,
                    n = O(e, 2),
                    r = n[0];
                return r + t * (n[1] - r)
            }
        }, {
            key: "render",
            value: function() {
                var e = this,
                    t = this.props,
                    n = t.start,
                    r = t.end,
                    o = t.throttle,
                    a = t.width,
                    i = t.height,
                    c = t.left,
                    s = t.top,
                    l = {
                        start: n,
                        end: r,
                        throttle: o
                    },
                    u = {
                        width: a,
                        height: i,
                        left: c,
                        top: s,
                        opacity: this.updateOpacity()
                    };
                return Ut.a.createElement(qt, A({}, l, {
                    movingInRange: function(t) {
                        e.setState({
                            rate: t
                        })
                    }
                }), Ut.a.createElement(Nt, {
                    class: this.props.class,
                    style: u
                }, this.props.children))
            }
        }]), t
    }(Mt.Component);
    ! function(e, t, n) {
        t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n
    }(Ft, "defaultProps", {
        start: 0,
        end: 0,
        throttle: 30,
        width: "100%",
        height: 0,
        left: 0,
        top: 0,
        opacityRange: [0, 1]
    });
    var Vt = {},
        Lt = decodeURIComponent,
        Gt = encodeURIComponent;
    Vt.get = function(e, t) {
        V(e), t = "function" == typeof t ? {
            converter: t
        } : t || {};
        var n = N(document.cookie, !t.raw);
        return (t.converter || L)(n[e])
    }, Vt.set = function(e, t, n) {
        V(e), n = n || {};
        var r = n.expires,
            o = n.domain,
            a = n.path;
        n.raw || (t = Gt(String(t)));
        var i = e + "=" + t,
            c = r;
        return "number" == typeof c && (c = new Date, c.setDate(c.getDate() + r)), c instanceof Date && (i += "; expires=" + c.toUTCString()), F(o) && (i += "; domain=" + o), F(a) && (i += "; path=" + a), n.secure && (i += "; secure"), document.cookie = i, i
    }, Vt.remove = function(e, t) {
        return t = t || {}, t.expires = new Date(0), this.set(e, "", t)
    };
    var Jt = Vt,
        Kt = function(e) {
            var t = {};
            return e ? (e.split("&").map(function(e) {
                var n = e.split("="),
                    r = n[0],
                    o = n[1];
                t[r] = o
            }), t) : t
        },
        Qt = function(e) {
            e = (e || "").replace(/</g, "&lt;").replace(/>/g, "&gt;");
            var t = e.split("|");
            return {
                country: t[0],
                lastName: t[1],
                firstName: t[2],
                serviceType: t[3],
                memberSeq: t[4]
            }
        },
        Zt = function() {
            var e = Jt.get("xman_us_f") || "",
                t = Kt(e);
            return t.x_user = Qt(t.x_user), t
        },
        zt = function() {
            return Jt.get("ali_beacon_id")
        },
        Ht = function() {
            return Jt.get("cna")
        },
        Wt = function() {
            var e = Jt.get("xman_us_t");
            return e && -1 !== e.indexOf("sign=y")
        },
        Yt = function() {
            return (Jt.get("ali_apache_track") || "").replace(/.+mid=(.+)$/, "$1").replace(/"/g, "")
        },
        Xt = function() {
            return "" === Jt.get("ali_intl_firstIn")
        },
        $t = function() {
            return Jt.get("intl_locale") || Zt().x_locale || "en_US"
        },
        en = function() {
            return Zt().x_user
        },
        tn = function() {
            return "0" == Zt().x_l
        },
        nn = function() {
            return "" !== Zt().x_user.memberSeq
        },
        rn = function() {
            var e = ["gs", "cgs", "twgs", "hkgs", "cnfm"],
                t = Zt().x_user.serviceType;
            return e.indexOf(t) > -1 ? "hz" : "us"
        },
        on = function() {
            var e = Jt.get("xman_us_t") || "";
            return Kt(e).ctoken || ""
        },
        an = {
            core: Jt,
            getBeaconId: zt,
            getCna: Ht,
            getIsLoggedIn: Wt,
            getUserId: Yt,
            getIsFirstIn: Xt,
            getLanguage: $t,
            getUser: en,
            getIsOversea: tn,
            getIsNewUser: nn,
            getServerDomain: rn,
            getCToken: on
        },
        cn = an,
        sn = n(2),
        ln = n.n(sn),
        un = n(8),
        fn = n.n(un),
        pn = navigator && navigator.userAgent && navigator.userAgent.indexOf("HavanaSession") > -1,
        hn = function(e, t) {
            return e = e || "", pn && /^(https?:\/\/)(gateway\.alibaba\.com|gw\.api\.alibaba\.com)/.test(e) && (t && t.headers instanceof Headers ? t.headers.append("havanaSession", "true") : (t = Object.assign({}, t), t.headers = Object.assign({}, t.headers, {
                havanaSession: "true"
            }))), t
        },
        mn = function(e) {
            function t(e, n) {
                var r;
                return J(this, t), r = K(this, $(t).call(this)), r.name = "FetchError", r.response = n, r.status = e, r
            }
            return Z(t, e), t
        }(z(Error)),
        dn = function(e, t, n, r, o) {
            var a = /^(https?:)?\/\/(.+)([\?\#].+)$/i;
            !t && a.test(e) && (t = RegExp.$2), t = t || e;
            var i = new Date - r,
                c = "name=".concat(t, "|type=").concat(n, "|time=").concat(i);
            "failure" === n && (c += "|reason=".concat(o, "|url=").concat(e)), window.dmtrack && window.dmtrack.dotstat && window.dmtrack.dotstat(27132, {
                ext: c
            })
        },
        yn = function(e) {
            return e.indexOf("?") < 0 && (e += "?1=1"), e
        },
        bn = function(e) {
            return e = yn(e), "".concat(e, "&_=").concat((new Date).valueOf())
        },
        gn = function(e) {
            var t = cn.getCToken();
            return t ? (e = yn(e), "".concat(e, "&ctoken=").concat(t)) : e
        },
        vn = function(e) {
            return e.replace("gw.api.alibaba.com", "gateway.alibaba.com")
        },
        wn = function(e, t) {
            return t.noCache || (e = bn(e)), !1 !== t.ctoken && (e = gn(e)), e = vn(e)
        },
        En = {
            sendTrack: dn,
            jsonp: function(e, t) {
                var n = {
                        timeout: 6e4
                    },
                    r = new Date;
                t = Object.assign({}, n, t), t = hn(e, t), e = wn(e, t);
                var o = ln()(e, t);
                return Cn(o, e, t.apiName, r)
            },
            fetch: function(e) {
                function t(t, n) {
                    return e.apply(this, arguments)
                }
                return t.toString = function() {
                    return e.toString()
                }, t
            }(function(e, t) {
                return e = vn(e), t = hn(e, t), fetch(e, t)
            })
        },
        Cn = function(e, t, n, r) {
            return e.then(function(e) {
                if (e.ok) return dn(t, n, "success", r), e.json();
                dn(t, n, "failure", r, e.status);
                var o = new mn(e.status, e);
                throw En.trigger("error", o), o
            })
        },
        Sn = function(e, t, n) {
            var r = {
                    method: "GET",
                    credentials: "same-origin"
                },
                o = Object.assign({}, r, t);
            return o = hn(e, o), "object" !== G(o.body) || o.body instanceof FormData || (o.body = JSON.stringify(o.body)), dn(e, t.apiName, "send", n), fetch(e, o)
        };
    ["put", "delete", "post", "get"].forEach(function(e) {
        En[e] = function(t) {
            var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
            n.method = e, t = wn(t, n);
            var r = new Date,
                o = Sn(t, n, r);
            return Cn(o, t, n.apiName, r)
        }
    }), fn.a.mixTo(En);
    var kn = En,
        An = cn.getIsLoggedIn,
        On = document.querySelector('input[name="_csrf_token_"]'),
        _n = On ? On.value : "",
        In = function(e) {
            return kn.get("/api/favorite/checkFavorite.do?objectId=".concat(e, "&timestamp=").concat(+new Date)).then(function(e) {
                if (200 === e.responseCode && e.entity) return {
                    isFavorite: -1 !== e.entity.check,
                    fid: e.entity.check
                }
            })
        },
        jn = function() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "",
                t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "",
                n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : _n;
            return new Promise(function(r, o) {
                ee().then(function() {
                    kn.post("/api/favorite/addFavorite.do?objectType=product&objectId=".concat(e, "&companyId=").concat(t, "&urlRule=D&_csrf_token_=").concat(n, "&timestamp=").concat(+new Date)).then(function(e) {
                        200 === e.responseCode && e.entity && -1 !== e.entity.check ? r({
                            success: !0,
                            fid: e.entity.check
                        }) : o("favoriteCountLimit" == e.error ? "Sorry,Your favorites is full, please remove something unnecessary." : "Sorry,the system is busy! Please try again later.")
                    })
                })
            })
        },
        xn = function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : _n;
            return new Promise(function(n, r) {
                kn.post("/api/favorite/delFavorite.do?id=".concat(e, "&_csrf_token_=").concat(t, "&timestamp=").concat(+new Date)).then(function(e) {
                    200 === e.responseCode && e.entity && e.entity.remove ? n({
                        success: !0
                    }) : r("Sorry,the system is busy! Please try again later.")
                })
            })
        },
        Pn = {
            fetchAccountInfo: function() {
                return kn.jsonp("//m.alibaba.com/api/getUserAccountInfo.do")
            },
            fetchInquiryCount: function() {
                return kn.jsonp("//notification.alibaba.com/notification.do")
            },
            fetchRfqCount: function() {
                return kn.jsonp("//m.alibaba.com/api/getMessageTypeList.do")
            },
            fetchKnockCount: function() {
                return kn.jsonp("//m.alibaba.com/api/knock/lingDang.do")
            },
            fetchFavoriteCount: function() {
                return kn.get("/api/favorite/countFavorite.do?objectType=product")
            }
        },
        Tn = Pn,
        Mn = cn.getIsFirstIn,
        Un = cn.getIsLoggedIn,
        Rn = cn.getIsNewUser,
        Dn = cn.getUserId,
        Bn = cn.getLanguage,
        Nn = cn.getCna,
        qn = cn.getBeaconId,
        Fn = cn.getCToken,
        Vn = cn.getUser,
        Ln = Vn(),
        Gn = Tn.fetchAccountInfo,
        Jn = Tn.fetchInquiryCount,
        Kn = Tn.fetchRfqCount,
        Qn = Tn.fetchKnockCount,
        Zn = Tn.fetchFavoriteCount,
        zn = {
            getIsFirstIn: Mn,
            getIsLoggedIn: Un,
            getIsNewUser: Rn,
            getUserId: Dn,
            getLocale: Bn,
            getCna: Nn,
            getBeaconId: qn,
            getCToken: Fn,
            getCountry: function() {
                return Ln.country
            },
            getFirstName: function() {
                return Ln.firstName
            },
            getLastName: function() {
                return Ln.lastName
            },
            getMemberSeq: function() {
                return Ln.memberSeq
            },
            fetchAccountInfo: Gn,
            fetchInquiryCount: Jn,
            fetchRfqCount: Kn,
            fetchKnockCount: Qn,
            fetchFavoriteCount: Zn,
            checkFavorite: In,
            addFavorite: jn,
            removeFavorite: xn,
            signIn: ee,
            signAndGo: te
        },
        Hn = (n(9), function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "";
            return window.PAGE_DATA.i18n.header[e] || t
        }),
        Wn = function() {
            var e = "en";
            return PAGE_DATA && PAGE_DATA.common && PAGE_DATA.common.lang && (e = PAGE_DATA.common.lang.split("_")[0]), e
        },
        Yn = function() {
            var e = {},
                t = cn.core.get("sc_g_cfg_f");
            return t = t.split("&").forEach(function(t) {
                var n = t && t.split("=");
                e[n[0]] = n[1]
            }), {
                country: e.sc_b_site,
                currency: e.sc_b_currency
            }
        },
        Xn = function(e) {
            var t = document.createElement("textarea");
            return t.innerHTML = e, t.value
        },
        $n = function() {
            return /Android/i.test(window.navigator.userAgent)
        },
        er = cn.getIsLoggedIn,
        tr = document.querySelector('input[name="_csrf_token_"]'),
        nr = tr ? tr.value : "",
        rr = function(e) {
            return kn.get("/api/favorite/checkFavorite.do?objectId=".concat(e, "&timestamp=").concat(+new Date)).then(function(e) {
                if (200 === e.responseCode && e.entity) return {
                    isFavorite: -1 !== e.entity.check,
                    fid: e.entity.check
                }
            })
        },
        or = function() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "",
                t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "",
                n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : nr;
            return new Promise(function(r, o) {
                re().then(function() {
                    kn.post("/api/favorite/addFavorite.do?objectType=product&objectId=".concat(e, "&companyId=").concat(t, "&urlRule=D&_csrf_token_=").concat(n, "&timestamp=").concat(+new Date)).then(function(e) {
                        200 === e.responseCode && e.entity && -1 !== e.entity.check ? r({
                            success: !0,
                            fid: e.entity.check
                        }) : o("favoriteCountLimit" == e.error ? "Sorry,Your favorites is full, please remove something unnecessary." : "Sorry,the system is busy! Please try again later.")
                    })
                })
            })
        },
        ar = function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : nr;
            return new Promise(function(n, r) {
                kn.post("/api/favorite/delFavorite.do?id=".concat(e, "&_csrf_token_=").concat(t, "&timestamp=").concat(+new Date)).then(function(e) {
                    200 === e.responseCode && e.entity && e.entity.remove ? n({
                        success: !0
                    }) : r("Sorry,the system is busy! Please try again later.")
                })
            })
        },
        ir = {
            fetchAccountInfo: function() {
                return kn.jsonp("/api/getUserAccountInfo.do")
            },
            fetchInquiryCount: function() {
                return kn.jsonp("//notification.alibaba.com/notification.do")
            },
            fetchRfqCount: function() {
                return kn.jsonp("/api/getMessageTypeList.do")
            },
            fetchKnockCount: function() {
                return kn.jsonp("/api/knock/lingDang.do")
            },
            fetchFavoriteCount: function() {
                return kn.get("/api/favorite/countFavorite.do?objectType=product")
            },
            fetchCountryAndCurrency: function() {
                return kn.jsonp("https://open-s.alibaba.com/openservice/wapCountryCurrencyDataService?appName=mobilemagellan&appKey=kznalwy3ropnvjwq0gtzfeurkcelb3jp")
            },
            changeCountryAndCurrency: function(e) {
                return kn.jsonp("https://open-s.alibaba.com/openservice/alibabaBuyerCookieDataService?language=".concat(e.language, "&localCurrency=").concat(e.currency, "&localCountry=").concat(e.country, "&appName=mobilemagellan&appKey=kznalwy3ropnvjwq0gtzfeurkcelb3jp"))
            }
        },
        cr = ir,
        sr = cn.getIsFirstIn,
        lr = cn.getIsLoggedIn,
        ur = cn.getIsNewUser,
        fr = cn.getUserId,
        pr = cn.getLanguage,
        hr = cn.getCna,
        mr = cn.getBeaconId,
        dr = cn.getCToken,
        yr = cn.getUser,
        br = yr(),
        gr = cr.fetchAccountInfo,
        vr = cr.fetchInquiryCount,
        wr = cr.fetchRfqCount,
        Er = cr.fetchKnockCount,
        Cr = cr.fetchFavoriteCount,
        Sr = cr.fetchCountryAndCurrency,
        kr = cr.changeCountryAndCurrency,
        Ar = {
            getIsFirstIn: sr,
            getIsLoggedIn: lr,
            getIsNewUser: ur,
            getUserId: fr,
            getLocale: pr,
            getCna: hr,
            getBeaconId: mr,
            getCToken: dr,
            getCountry: function() {
                return br.country
            },
            getFirstName: function() {
                return br.firstName
            },
            getLastName: function() {
                return br.lastName
            },
            getMemberSeq: function() {
                return br.memberSeq
            },
            fetchAccountInfo: gr,
            fetchInquiryCount: vr,
            fetchRfqCount: wr,
            fetchKnockCount: Er,
            fetchFavoriteCount: Cr,
            fetchCountryAndCurrency: Sr,
            changeCountryAndCurrency: kr,
            checkFavorite: rr,
            addFavorite: or,
            removeFavorite: ar,
            signIn: re,
            signAndGo: oe
        },
        Or = function(e) {
            return Ut.a.createElement("div", {
                class: e.class
            }, Ut.a.createElement("div", {
                class: "main-header"
            }, e.navItems.map(function(t) {
                if ("menu" === t) return Ut.a.createElement("a", {
                    class: "header-item btn-menu",
                    onClick: __ifvm__("", e.onClickMenu)
                }, Ut.a.createElement("i", {
                    class: "iconfont-menu"
                }));
                if ("logo" == t) return Ut.a.createElement("a", {
                    class: "header-item logo",
                    href: "/"
                }, Ut.a.createElement("img", {
                    src: "data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAAeAAD/4QMsaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzE0MCA3OS4xNjA0NTEsIDIwMTcvMDUvMDYtMDE6MDg6MjEgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpDQTg3QjkyNjU0RkQxMUU4ODM5REUzNDczOEY5NDkzQyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDowODU5MTlEMjU1MDAxMUU4ODM5REUzNDczOEY5NDkzQyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkNBODdCOTI0NTRGRDExRTg4MzlERTM0NzM4Rjk0OTNDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkNBODdCOTI1NTRGRDExRTg4MzlERTM0NzM4Rjk0OTNDIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/+4ADkFkb2JlAGTAAAAAAf/bAIQAEAsLCwwLEAwMEBcPDQ8XGxQQEBQbHxcXFxcXHx4XGhoaGhceHiMlJyUjHi8vMzMvL0BAQEBAQEBAQEBAQEBAQAERDw8RExEVEhIVFBEUERQaFBYWFBomGhocGhomMCMeHh4eIzArLicnJy4rNTUwMDU1QEA/QEBAQEBAQEBAQEBA/8AAEQgAJADcAwEiAAIRAQMRAf/EAKIAAAIDAQEBAAAAAAAAAAAAAAAFAgMEAQYHAQADAQEBAAAAAAAAAAAAAAABAgMEBQAQAAECBAQDBgMGAgsBAAAAAAECAwAREgQhMRMFQSIUUWFxMkIVgaFSkWJykiMzQwbB0eGislODoyREJTYRAAIAAwUECAQGAwAAAAAAAAECABEDITFBEgRRIjIz8HGBwUKCEzRhoVJykeHCQyREcxSE/9oADAMBAAIRAxEAPwD6BBHCQkFSjIDEk5AR53dN7W8SxaEoayU4MFK8OwRGvXSis2vNwF5i1DTvWbKtwvY3CGl5vFnaEoJ1HR6EcPE5CE9xv988ZNSZScgkVK+0xbs+1W10xrvhZkogJ8qTLjPOHTbFnaUhCENFZpSZSJPZOMwGprqHLrRptdlvjUTpqDFBTavUW8tdHmhb7vd4lLqweKyQP70hDA7C7ppct3lMuSE21mcj+NH9UPY4pQSkqUZJAmSeAEOuhpiZdmcnEmUom+vqmQRVpgYATn1wj2+/vbe8FhfTVUZJUrEgnLm4gw9jz7Cjue8i4SJMMSIPcny/aYc3dyi1t1vr9IwHaeAhtK8qbksWpozZWb6RA1STqIAoWo6LnVbsxjJe71b2j5YKFOKSAVFMpAnhGy1uW7phL7flVwOYIzBjz23ptHxcvXryEuPApTUcQVYlcW/y/d6T67NZmlzFB4VDs8REqWqc1FzlclWYUYrsn1xWrpEFNsgbPRkWODbZdUNFbo2m/FjQqskCvCWIqjiN1Qu+NnpKCgopr9PKJwte/wDpE/iT/gEXM3t0rfFWxcJZClijCUgkkQRqHzEFpfyfTElBs2QDp0yghZ/xvVM2It2xst91afvFWiUKCkFQKjKXIZRvjzNol9W8vJYUELKnZrIqpEziB2xfevX+13LauoU+25M0r7sxBp6phTZ6isyrUKlhKwYQKmkU1FSmyqzUwwUzmTjbD+CFO63b6dMNXLdu2pIUZzLhn3BKsIXu7m9brQq2vVXI9aVoIGH4u2KVNWiMQQd2UzMY7BOcTp6N6iggjenISbDaZSEONw3VuwWhC0KXWJgpl/TG0GYnHnf5hVW5bLA8zc5eJjXfM7k1bG66shaACppIpQB2Dtl3wo1DipWGUutPKRllYJTMMdMhp0TmCNUzA5p2mchDiCFVvuL7+1qfrbbfQaFOOYJnhzSAOMjC9V64llSzuSlXAxDaUqoPdMpEM2rRQpAJDLmvAs7TfCpo6jFgSAVbJcWt7BdHpYIwbPeO3loVvYuIUUFQwngDP5xK+efLzNnbq01vTK3JTpQnOXeYqKymmKgmQ0pDGZslEjRYVDTMgVnM4SFpMbYIxM2TzDyVpunHG8dRDprnhhSeGMUMIf3JJuVXDjLJUQy20acEmU1HjA9RrBkOYzksxcMZx70ltOcZBKbSN5wl2Q0ghcw/cNm5tHl1uMoradlIlJBz7xGad77ancDcq1UpCggAUEAy5hxJhTXEp5WNjMRZZlsMMNOZyLKJsqqbbc1ohyTIT7Iy9eimqg9vDLtjK8bu3Qxdm4UpTi0BxqQ05L4JHCUMtJv6R25QwqEzkpGS0rZMg3QDSAABYHPYGtkCL4R7/uJKuiaMkj94jifphbttom8uksLJCSCSU8JCKwkvXdLyqC45JxR4TOJj19tasWrYbYSEp4nie8njHOpU21VZqjncRuE7NkdGrUXS0VpoN914ht+qKEWt8hAbTdJShIkJMgSH5pfKJiwZJqfKn3PrWcuPKEyCcuEaYih1tZIQoKIzkZy+yOl6aCQNuwMxb5GOZ6tQzIs2lVC/MROEG53zt8+NvsuZJMlqGSiO/wCkRp36+XbsJYbMlvTmocEjP7Yo2Z3brS31XHkh9ydU80gHyxmr1c9T0AwRZTqMTKz6RGnT0ilP/YKl2nKmoE7fqMNLCybsrcNIxVmtX1KjJu9le3pQ2yUhlOJqMiVeEuETXvtiDS1W8s5JQk4/mlEku7nc+VtNo2fU5zufBIkB8YoxounpISy3SpW/O6EUV0qes4CtfOrZf8L4iNm2xtA1GwZAAqKlCZ/NGS72NwPoe2+ltKZGSicFAzmJzhq1aobVWtSnXf8AMcMyPwjJPwER3B5y3s3XmxNaE8vdPCfwjz0KRQlkVMu9ucVnxjyaisKgC1Gcscu/w2/CMJ227XuqL5VARNJUAcQQkJPDtjrW2XKN3N6adIqUc+aRBGUok3O3u2W9Z9eqDNS+ZpZKSrlM+WXcIjbX1107LbYS46GdZxbqjimoiQzxwiYWkDvBgfUNS+e8JbOuKFqxG6UI9IUrpbhnt6oqb2m/bv3LptaG5qWpB806jgFCWRiL22bnf3CVXqkIbRhyHhxpHf3xeb651XLhkBTQYbeLa1ESGJNIAzi1zcnA+2EJSppam0nzVjV7ZCkZ5EwuTTyIJqBS8ys7Gtv+UNn1GYECmWCSDStWy75xm3Darpd6m6tqFgU/pryFGEseGEcvtt3O9S2pwtJUmYDaZgAHjPHGNtq68bW4VVU4hx0IKiZcpMh4RTa3t4tNs1JCnHW9Ra1EjlB7hnKGanRM5+oBW3yBdOcKtWuJS9MmhuBiLZSirc9qurvQ06f00BKpmWPdhBd2m8utdKFtrZMhqeVRA+r+yLk7q4FuFaEqbDa3EKRVjQZSqUAD4iK1390w8t18AhNulSWkKJSStdKTjxxxgMKBzMGqDPY+UysAxgqdQMqlaZ9O1MwnaThHHdlc9tRatLBdSvUVPBKlESiLdjuhszZqDLLdJFQxWrjIywx7YYWVy6+HEvIpW2QKgFBKgRPCsAxlG43Kg8lSUsuBC1NoVUFAo8RSrtwhjToDKwLqGTJJcQMIUVNQcykIxV882wLYxPabK4srVxtykuKUVJkcMgBPDuiy5tbh5LNw2Ut3jOIzKDUOZJ7ozHcbpm0ZWQhxzSDrgmoqKTkeVPL4nCJ3N9dkXQYShKbdANaiauZFeAlLCCGoimE35Kosx+odolAKVjULnJNmM2w+k9hnF7KtzW8kvJbZZTOsJNRWZYS7IqQxf2RUi0Sh63USpCFGlSCcSO8RFW4XLOkHUpSgoQVuKqpUVZyUAQmX3ou3Bx5CrXRPMp0JlMgEUq80uENNCpOaoWQi3xDNZCycMFy0wrg2eE5bfx7Y4xZvBL7z6gq5uE0mnyJEpJSI4bN72no8NXTpzwn4xWdzfobSltOupTiVeYo/SMjKkFWMSG4vKWmloJQGQ+7UTUkTIUkCWeGEANQlIFrVKnz2ntgla85kLYwYXeCwdkW3dq69bMtIlU2ttSpnCSM42QutLx28m063QlxvUQtNUgD6SVBOPhGjpnK56yqJ+XunOWcOHTKagnlIAJ6vhCFKhYUzLOCSB1/GE29e166qaup9enKmf3p8fCMdt1chR1Olw0qpfLCCCObV57cN/wC1398dOj7deK4c3u7oYse2YdZr1T/7NVM/hh9sOWdHTGhTp+miVPwlhBBG/S48vy8fmjn6rDm3+Lg8sL979v00dZVXjp6cq+/PCULLf2CY1db/AFMv9vGCCM+o9wfb4cz9UaNN7ce4x5f6Ye2Xt9H/AAtOXGiU/jx+2NUEEb6fAOHycPZHPq8Z4/PxdsERXRQquVEjVPKXGc4IIc3QgvhfaezdQOmlrSNE68uNFeH5Y477Nos1y06TpSrnRPGdONPjBBGQcv8Aq4/bh0/CNh5n9rC/ix6fjHbn2fUGvTVSmUqpUenyYU/KJO+19T+p+9UjKumv0ZctUEEE3t7biHff8fzgC5fc8J7rvh+UaWOm03NGVFa9TOVU+fPvii09tm302dK9OdXkq5/NwnBBFMU5V3eOHpsiYufnX9x4um2K2PaKv0pTpX5q6dP1yrwp+UcZ9loc06adP9Sqv9uf3/l8oIIkMPbY3dWHfFT4vdYX9ePdGqy6ShXS5Vc9VVVUvVqc2UUMe06h0pTkuU6qKf4mnVy+NMEEPhT5GPV5InjU5+HX54q/8TTR9FBl+55J+runlV8I1DoabjKmlPUTn5aOWc/uwQQqf893h+09OqGf/pvPH9w6dcozn2aSJ+WlMp6lNE+TU4SnlVG1/p62dbzV/o5+eR7O6CCGS5uR4eC7t7oWpevP8XHf2d8ZHfadPny1HJU11V/xJU83jwi9rodQaVNWimWctGZp7pQQR5eL9jDhvugtw/v48XDf0nFNv7Xz9POckzlqTpqwon6Z/ThDCCCPDlHkYfZfj0vjx5o5+P8Akuw6XR//2Q==",
                    "data-src": "https://u.alicdn.com/mobile/g/common/ai-header/4.0.0/assets/logo.png",
                    ref: lazyloadRef,
                    alt: ""
                }));
                if ("fav" === t) return Ut.a.createElement("a", {
                    class: "header-item btn-fav",
                    onClick: __ifvm__("", e.onClickFav)
                }, e.highlightFavorite ? Ut.a.createElement("i", {
                    class: "iconfont-love-fill"
                }) : Ut.a.createElement("i", {
                    class: "iconfont-love"
                }));
                if ("search" === t) return Ut.a.createElement("a", {
                    class: "header-item btn-search",
                    onClick: __ifvm__("", e.onClickSearch)
                }, Ut.a.createElement("i", {
                    class: "iconfont-search"
                }));
                if ("more" === t) return Ut.a.createElement("a", {
                    class: "header-item btn-more",
                    onClick: __ifvm__("", e.onClickMore)
                }, Ut.a.createElement("i", {
                    class: "iconfont-more"
                }));
                if ("back" === t) return Ut.a.createElement("a", {
                    class: "header-item btn-back",
                    onClick: __ifvm__("", e.onClickBack)
                }, Ut.a.createElement("i", {
                    class: "iconfont-back"
                }));
                if ("download" === t) {
                    var n = encodeURIComponent("enalibaba://".concat($n() ? "sc-home" : "iPhoneHome")),
                        r = "//app.alibaba.com/dynamiclink?schema=".concat(n, "&ck=wap_header&cna=").concat(Ar.getCna(), "&pageid=").concat(window.dmtrack_pageid);
                    return Ut.a.createElement("a", {
                        class: "header-item btn-download",
                        href: r,
                        "data-domdot": "id:26502"
                    }, Ut.a.createElement("i", {
                        class: "iconfont-download"
                    }))
                }
                return "inline-search" === t ? ae(e, !0) : "title" === t ? Ut.a.createElement("span", {
                    class: "header-item title"
                }, e.title) : void 0
            })), e.showSearchBar && ae(e), Ut.a.createElement("span", {
                "data-placeholder": "after__main-header"
            }))
        },
        _r = Or,
        Ir = (n(10), function(e) {
            function t() {
                var e, n;
                se(this, t);
                for (var r = arguments.length, o = new Array(r), a = 0; a < r; a++) o[a] = arguments[a];
                return n = fe(this, (e = pe(t)).call.apply(e, [this].concat(o))), ye(he(n), "handlerChange", function(e) {
                    var t = n.props,
                        r = t.type,
                        o = t.getValue;
                    o && o(e.target.value, r)
                }), ye(he(n), "renderOptions", function(e) {
                    var t = n.props,
                        r = t.code,
                        o = t.name,
                        a = t.current;
                    return Ut.a.createElement("optgroup", {
                        label: e.name
                    }, e.list && e.list.map(function(e) {
                        var t = e[r] === a ? {
                            selected: !0
                        } : {};
                        return Ut.a.createElement("option", ce({
                            value: e[r]
                        }, t), e[o])
                    }))
                }), n
            }
            return me(t, e), ue(t, [{
                key: "render",
                value: function() {
                    var e = this.props.list,
                        t = e.all,
                        n = e.popular;
                    return Ut.a.createElement("select", {
                        class: "select-options ".concat(this.props.classname || ""),
                        onChange: this.handlerChange
                    }, this.renderOptions(n), this.renderOptions(t))
                }
            }]), t
        }(Mt.Component)),
        jr = [{
            code: "EN",
            url: "https://m.alibaba.com/",
            text: "English"
        }, {
            code: "ES",
            url: "https://m.spanish.alibaba.com/",
            text: "Español"
        }, {
            code: "PT",
            url: "https://m.portuguese.alibaba.com/",
            text: "Português"
        }, {
            code: "FR",
            url: "https://m.french.alibaba.com/",
            text: "Français"
        }, {
            code: "DE",
            url: "https://m.german.alibaba.com/",
            text: "Deutsch"
        }, {
            code: "IT",
            url: "https://m.italian.alibaba.com/",
            text: "Italiano"
        }, {
            code: "TR",
            url: "https://m.turkish.alibaba.com/",
            text: "Türk"
        }, {
            code: "TH",
            url: "https://m.thai.alibaba.com/",
            text: "ภาษาไทย"
        }, {
            code: "JA",
            url: "https://m.japanese.alibaba.com/",
            text: "日本語"
        }, {
            code: "RU",
            url: "https://m.russian.alibaba.com/",
            text: "Pусский"
        }, {
            code: "KO",
            url: "https://m.korean.alibaba.com/",
            text: "한국어"
        }, {
            code: "NL",
            url: "https://m.dutch.alibaba.com/",
            text: "Nederlands"
        }, {
            code: "VI",
            url: "https://m.vietnamese.alibaba.com/",
            text: "tiếng Việt"
        }, {
            code: "IN",
            url: "https://m.indonesian.alibaba.com/",
            text: "Indonesian"
        }, {
            code: "AR",
            url: "https://m.arabic.alibaba.com/",
            text: " اللغة العربية"
        }, {
            code: "IW",
            url: "https://m.hebrew.alibaba.com/",
            text: "עברית"
        }],
        xr = function(e) {
            e = e.toUpperCase();
            for (var t = 0, n = jr.length; t < n; t++) {
                var r = jr[t];
                if (r.code === e) return r
            }
        },
        Pr = Wn(),
        Tr = function(e) {
            return Ut.a.createElement("select", {
                class: "select-options",
                onChange: function(t) {
                    var n = t.target.value,
                        r = xr(n).url;
                    if ("function" == typeof e.onSelect) {
                        var o = window.location.pathname + window.location.search + window.location.hash;
                        "/" === o[0] && (o = o.slice(1));
                        var a = {
                                lang: n,
                                homeUrl: r,
                                noSlashStartPath: o
                            },
                            i = r.match(/\/\/(.+)\//);
                        i && (a.hostname = i[1]), e.onSelect(a)
                    }
                    e.goHome && (location.href = r)
                }
            }, jr.map(function(e) {
                var t = e.code === Pr.toUpperCase() ? {
                    selected: !0
                } : {};
                return Ut.a.createElement("option", be({
                    value: e.code
                }, t), e.text)
            }))
        },
        Mr = Tr,
        Ur = function(e) {
            return encodeURIComponent(e || location.href)
        },
        Rr = function(e) {
            return e > 99 ? "99+" : e
        },
        Dr = function(e) {
            function t(e) {
                var n;
                return Ae(this, t), n = Ie(this, je(t).call(this, e)), Me(xe(n), "onClickMask", function() {
                    n.props.onClickMask()
                }), Me(xe(n), "show", function() {
                    n.setState({
                        visible: !0
                    }), n.getCountryAndCurrency(), setTimeout(function() {
                        n.setState({
                            contentVisible: !0
                        })
                    }, 0)
                }), Me(xe(n), "hide", function() {
                    n.setState({
                        contentVisible: !1
                    }), setTimeout(function() {
                        n.setState({
                            visible: !1
                        })
                    }, 250)
                }), Me(xe(n), "checkSignIn", function(e, t) {
                    n.state.signIn || (t.preventDefault(), location.href = "/login.html?return_url=".concat(encodeURIComponent(e)))
                }), Me(xe(n), "handlerDownloadApp", function() {
                    return "//app.alibaba.com/dynamiclink?schema=".concat(encodeURIComponent("enalibaba://".concat($n() ? "sc-home" : "iPhoneHome")), "&ck=wap_ma&cna=").concat(Ar.getCna(), "&pageid=").concat(window.dmtrack_pageid)
                }), Me(xe(n), "handlerCouponDownloadAPP", function() {
                    var e = $n() ? "enalibaba://sc-home?frag=MA" : "enalibaba://myAlibaba";
                    return "//app.alibaba.com/dynamiclink?ck=mycoupon&schema=".concat(encodeURIComponent(e), "&cna=").concat(Ar.getCna(), "&pageid=").concat(window.dmtrack_pageid)
                }), Me(xe(n), "handlerGetValue", function(e, t) {
                    if (n.state[t]) {
                        var r = n.handlerChangeStateValue(e, t);
                        n.setState(ke({}, r), function() {
                            var e = n.state,
                                t = e.language,
                                r = e.country,
                                o = e.currency;
                            Ar.changeCountryAndCurrency({
                                country: r,
                                currency: o,
                                language: t
                            }).then(function(e) {
                                window.location.reload()
                            })
                        })
                    }
                }), Me(xe(n), "handlerChangeStateValue", function(e, t) {
                    var r = Me({}, t, e);
                    if ("country" === t)
                        for (var o = n.state.countryList.all.list, a = 0, i = o.length; a < i; a++)
                            if (o[a].code === e) {
                                r.currency = o[a].currencyCode;
                                break
                            } return r
                }), Me(xe(n), "getCountryAndCurrency", function() {
                    var e = Wn(),
                        t = "countryAndCurrency-".concat(e),
                        r = ve(t, !0);
                    r ? n.initCountryAndCurrency(r) : Ar.fetchCountryAndCurrency().then(function(e) {
                        e && 200 === e.code && (we(t, e.data, !0), n.initCountryAndCurrency(e.data))
                    })
                }), Me(xe(n), "initCountryAndCurrency", function(e) {
                    if (e && e.countryModule) {
                        var t = Yn(),
                            r = t.country,
                            o = t.currency;
                        n.setState({
                            country: r,
                            currency: o,
                            countryList: {
                                all: {
                                    name: Hn("ma_all_country"),
                                    list: e.countryModule.allCountryList
                                },
                                popular: {
                                    name: Hn("ma_popular_country"),
                                    list: e.countryModule.popularCountryList
                                }
                            },
                            currencyList: {
                                all: {
                                    name: Hn("ma_all_currency"),
                                    list: e.currencyModule.allCurrency
                                },
                                popular: {
                                    name: Hn("ma_popular_currency"),
                                    list: e.currencyModule.popularCurrency
                                }
                            }
                        })
                    }
                }), n.state = {
                    visible: e.visible || !1,
                    contentVisible: e.visible || !1,
                    signIn: !1,
                    portraitPath: "",
                    firstName: "",
                    lastName: "",
                    inquiryCount: 0,
                    rfqCount: 0,
                    knockCount: 0,
                    favCount: 0,
                    countryList: {
                        all: {
                            list: []
                        },
                        popular: {
                            list: []
                        }
                    },
                    currencyList: {
                        all: {
                            list: []
                        },
                        popular: {
                            list: []
                        }
                    },
                    country: "us",
                    language: "en",
                    currency: "USD"
                }, n
            }
            return Pe(t, e), _e(t, [{
                key: "componentDidMount",
                value: function() {
                    var e = this;
                    Ar.fetchAccountInfo().then(function(t) {
                        if (200 === t.responseCode && t.entity) {
                            var n = t.entity,
                                r = n.signIn,
                                o = n.firstName,
                                a = n.lastName,
                                i = n.portraitPath;
                            if (r) return e.setState({
                                signIn: r,
                                firstName: o,
                                lastName: a,
                                portraitPath: i
                            }), n
                        }
                    }).then(function(t) {
                        t && t.signIn && (Ar.fetchInquiryCount().then(function(t) {
                            t.map(function(t) {
                                /^(inquiries|inquiry)$/i.test(t.name) && t.count > 0 && e.setState({
                                    inquiryCount: t.count
                                })
                            })
                        }), Ar.fetchRfqCount().then(function(t) {
                            200 === t.responseCode && t.entity && t.entity.rfq && t.entity.rfq.count && e.setState({
                                rfqCount: t.entity.rfq.count
                            })
                        }), Ar.fetchKnockCount().then(function(t) {
                            200 === t.responseCode && t.entity && t.entity.unreadKnockCount && e.setState({
                                knockCount: t.entity.unreadKnockCount
                            })
                        }), Ar.fetchFavoriteCount().then(function(t) {
                            200 === t.responseCode && t.entity && t.entity.count && e.setState({
                                favCount: t.entity.count
                            })
                        }))
                    })
                }
            }, {
                key: "render",
                value: function() {
                    var e = this,
                        t = this.props.items,
                        n = this.state,
                        r = n.visible,
                        o = n.contentVisible,
                        a = n.signIn,
                        i = n.firstName,
                        c = n.lastName,
                        s = n.portraitPath,
                        l = n.inquiryCount,
                        u = n.rfqCount,
                        f = n.knockCount,
                        p = n.favCount,
                        h = n.currency,
                        m = (n.language, n.country),
                        d = n.countryList,
                        y = n.currencyList,
                        b = Dt()("site-menu", {
                            "site-menu-visible": o
                        });
                    return Ut.a.createElement("div", {
                        class: b,
                        style: {
                            display: r ? "block" : "none"
                        },
                        "data-spm": "mod-side-menu"
                    }, Ut.a.createElement("div", {
                        class: "menu-mask",
                        onClick: this.onClickMask
                    }), Ut.a.createElement("div", {
                        class: "menu-content",
                        "data-field": "side-menu"
                    }, Ut.a.createElement("header", {
                        class: "header"
                    }, a ? Ut.a.createElement("div", {
                        class: "member hide",
                        "data-field": "member"
                    }, Ut.a.createElement("div", {
                        class: "avatar"
                    }, Ut.a.createElement("span", {
                        style: "background-image: url(".concat(s, ")"),
                        "data-field": "avatar"
                    })), Ut.a.createElement("div", {
                        class: "nickname",
                        "data-field": "nickname"
                    }, i, " ", c)) : Ut.a.createElement("div", {
                        class: "unregister"
                    }, Ut.a.createElement("div", {
                        class: "avatar"
                    }, Ut.a.createElement("a", {
                        href: "/login.html?return_url=".concat(Ur()),
                        "data-field": "avatar"
                    })), Ut.a.createElement("a", {
                        href: "/login.html?return_url=".concat(Ur())
                    }, Hn("pwa_signin")), Ut.a.createElement("span", {
                        class: "split-line"
                    }, "|"), Ut.a.createElement("a", {
                        href: "/register.htm?return_url=".concat(Ur()),
                        class: "line"
                    }, Hn("register")))), Ut.a.createElement("div", {
                        class: "list"
                    }, t.map(function(t) {
                        return "home" === t ? Ut.a.createElement("a", {
                            class: "item flex home line-bottom",
                            href: "/"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-home-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("pwa_home"))) : "messenger" === t ? Ut.a.createElement("a", {
                            class: "item flex",
                            href: "//m.alibaba.com/atmHistory"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-message-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("common_menu_messenger"))) : "inquiries" === t ? Ut.a.createElement("a", {
                            class: "item flex",
                            href: "/messages/#inbox/inquiry/1"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-inquery-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("pwa_inquiries")), l > 0 && Ut.a.createElement("span", {
                            class: "badge"
                        }, Rr(l))) : "rfq" === t ? Ut.a.createElement("a", {
                            class: "item flex",
                            href: "//m.alibaba.com/activity/mobile/rfqlist.html",
                            onClick: e.checkSignIn.bind(e, "//m.alibaba.com/activity/mobile/rfqlist.html")
                        }, Ut.a.createElement("i", {
                            class: "iconfont-rfq-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("common_menu_rfq")), u > 0 && Ut.a.createElement("span", {
                            class: "badge"
                        }, Rr(u))) : "qq" === t ? Ut.a.createElement("a", {
                            class: "item flex",
                            href: "//m.alibaba.com/messagebox/list.html"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-flash-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("common_menu_quick_quotation")), f > 0 && Ut.a.createElement("span", {
                            class: "badge"
                        }, Rr(f))) : "fav" === t ? Ut.a.createElement("a", {
                            class: "item flex",
                            href: "//m.alibaba.com/favorite"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-star-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("common_menu_favorites")), p > 0 && Ut.a.createElement("span", {
                            class: "badge"
                        }, Rr(p))) : "coupon" === t ? Ut.a.createElement("a", {
                            class: "item flex line-bottom",
                            href: e.handlerCouponDownloadAPP()
                        }, Ut.a.createElement("i", {
                            class: "iconfont-coupon-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("common_menu_coupons"))) : "country" === t ? d.all.list.length ? Ut.a.createElement("label", {
                            class: "item flex language"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-position-fill"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("ma_country")), Ut.a.createElement("img", {
                            class: "country-img",
                            src: "//u.alicdn.com/mobile/g/common/flags/1.0.0/assets/".concat(m.toLowerCase(), ".png")
                        }), Ut.a.createElement(Ir, {
                            code: "code",
                            name: "name",
                            type: "country",
                            current: m,
                            list: d,
                            classname: "country",
                            getValue: e.handlerGetValue
                        })) : Ut.a.createElement("span", null) : "language" === t ? Ut.a.createElement("label", {
                            class: "item flex language"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-language"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("pwa_language")), Ut.a.createElement(Mr, {
                            goHome: !0
                        })) : "currency" === t ? y.all.list.length ? Ut.a.createElement("label", {
                            class: "item flex language"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-icon-pound"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("ma_currency")), Ut.a.createElement(Ir, {
                            type: "currency",
                            code: "currencyCode",
                            name: "currencyCode",
                            current: h,
                            list: y,
                            getValue: e.handlerGetValue
                        })) : Ut.a.createElement("span", null) : "feedback" === t ? Ut.a.createElement("a", {
                            class: "item flex",
                            href: "/myalibaba/helpcenter/suggestion.htm"
                        }, Ut.a.createElement("i", {
                            class: "iconfont-feedback"
                        }), Ut.a.createElement("i", {
                            class: "flex-1"
                        }, Hn("pwa_feedback"))) : void 0
                    }), a && Ut.a.createElement("a", {
                        class: "item flex none",
                        href: "https://login.alibaba.com/xman/xlogout.htm",
                        "data-field": "sign-out"
                    }, Ut.a.createElement("i", {
                        class: "iconfont-off"
                    }), Ut.a.createElement("i", {
                        class: "flex-1"
                    }, Hn("Footer-SingOut"))), t.map(function(t) {
                        if ("download" === t) return Ut.a.createElement("a", {
                            class: "item flex download-app line-top",
                            href: e.handlerDownloadApp()
                        }, Ut.a.createElement("i", {
                            class: "iconfont-download"
                        }), Ut.a.createElement("div", {
                            class: "action flex-1"
                        }, Ut.a.createElement("div", {
                            class: "flex"
                        }, Ut.a.createElement("h3", {
                            class: "flex-1"
                        }, "Alibaba.com"), Ut.a.createElement("p", {
                            class: "get-app flex-1"
                        }, Hn("pwa_getapp"))), Ut.a.createElement("p", {
                            class: "description"
                        }, Hn("pwa_appinfo"))))
                    })), Ut.a.createElement("div", {
                        class: "company-info"
                    }, Ut.a.createElement("p", null, Ut.a.createElement("a", {
                        href: "//news.alibaba.com/article/detail/help/100453303-1-privacy-policy.html",
                        rel: "nofollow"
                    }, Hn("pwa_privacy")), "-", Ut.a.createElement("a", {
                        href: "//buyercentral.alibaba.com/privacy/cookie_setting.htm?from=wap",
                        rel: "nofollow"
                    }, Hn("gdpr-cookie-setting")), "-", Ut.a.createElement("a", {
                        href: "//news.alibaba.com/article/detail/help/100453293-1-terms-use.html",
                        rel: "nofollow"
                    }, Hn("pwa_termsofuse"))), Ut.a.createElement("p", null, "@ ", Hn("pwa_allrights")))))
                }
            }]), t
        }(Mt.Component),
        Br = (n(11), 5),
        Nr = {},
        qr = function(e, t, n) {
            function r() {
                o.parentNode.removeChild(o), (a || t) && t()
            }
            var o, a, i = "jsonp" + +new Date + (Nr.jsonpid = ++Nr.jsonpid || 0),
                c = document,
                s = ("-1" == e.indexOf("?") ? e + "?" : e) + (n ? "" : "&call=" + i);
            (o = c.createElement("script")).setAttribute("type", "text/javascript"), c.getElementsByTagName("head")[0].appendChild(o).src = s, window[i] = function() {
                void 0 !== t && t.apply(null, arguments), a = 1
            }, o.onload = o.onreadystatechange = function() {
                o.readyState ? "loaded" == o.readyState.toLowerCase() && r() : r()
            }
        },
        Fr = qr,
        Vr = qe,
        Lr = Wn(),
        Gr = function(e) {
            function t(e) {
                var n;
                return Ve(this, t), n = Je(this, Ke(t).call(this, e)), He(Qe(n), "getPopular", function() {
                    ln()("//connectkeyword.alibaba.com/popularJson.htm?searchtype=wap&countryId=EN").then(function(e) {
                        if (e.ok) return e.json();
                        console.log("request failed")
                    }).then(function(e) {
                        n.setState({
                            popularKeywords: e.map(function(e) {
                                return e.keywords
                            })
                        })
                    })
                }), He(Qe(n), "startSearch", function() {
                    De(n.state.inputValue), n.form.submit()
                }), He(Qe(n), "show", function() {
                    n.setState({
                        visible: !0
                    }, function() {
                        n.input.focus()
                    })
                }), He(Qe(n), "hide", function() {
                    n.setState({
                        visible: !1
                    })
                }), He(Qe(n), "clearInput", function() {
                    n.setState({
                        inputValue: "",
                        clearVisible: !1
                    })
                }), He(Qe(n), "onInput", function(e) {
                    var t = e.target,
                        r = t.value,
                        o = !1;
                    r && r.length ? (o = !0, Vr(function() {
                        var e = window.JSONVSearchSuggestion;
                        n.setState({
                            suggestionList: e
                        })
                    }, {
                        key: r
                    })) : n.getPopular(), n.setState({
                        clearVisible: o,
                        inputValue: r
                    })
                }), He(Qe(n), "clearHistory", function() {
                    Ne(), n.setState({
                        historyKeywords: Be()
                    })
                }), n.state = {
                    visible: e.visible || !1,
                    clearVisible: !1,
                    inputValue: e.inputValue || "",
                    popularKeywords: [],
                    historyKeywords: Be(),
                    suggestionList: []
                }, n.form = null, n.setFormRef = function(e) {
                    n.form = e
                }, n.input = null, n.setInputRef = function(e) {
                    n.input = e
                }, n
            }
            return Ze(t, e), Ge(t, [{
                key: "onClickKeywords",
                value: function(e) {
                    var t = this;
                    this.setState({
                        inputValue: e
                    }, function() {
                        t.startSearch()
                    })
                }
            }, {
                key: "componentWillMount",
                value: function() {
                    this.getPopular()
                }
            }, {
                key: "render",
                value: function() {
                    var e = this,
                        t = this.state,
                        n = t.visible,
                        r = t.clearVisible,
                        o = t.inputValue,
                        a = t.popularKeywords,
                        i = void 0 === a ? [] : a,
                        c = t.historyKeywords,
                        s = void 0 === c ? [] : c,
                        l = t.suggestionList,
                        u = void 0 === l ? [] : l;
                    return Ut.a.createElement("div", {
                        class: "site-search",
                        style: {
                            display: n ? "block" : "none"
                        }
                    }, Ut.a.createElement("div", {
                        class: "search-header"
                    }, Ut.a.createElement("a", {
                        class: "back-btn",
                        onClick: this.props.onClickBack
                    }, Ut.a.createElement("i", {
                        class: "iconfont-back"
                    })), Ut.a.createElement("form", {
                        class: "form-wrap",
                        action: "/trade/search",
                        ref: this.setFormRef,
                        onSubmit: this.startSearch
                    }, Ut.a.createElement("input", {
                        ref: this.setInputRef,
                        onInput: this.onInput,
                        name: "SearchText",
                        type: "search",
                        value: o,
                        placeholder: Hn("search-bar-placeholder"),
                        autocorrect: "off",
                        autocomplete: "off",
                        autocapitalize: "off"
                    }), Ut.a.createElement("a", {
                        class: "clear-btn",
                        style: {
                            display: r ? "inline-block" : "none"
                        },
                        onClick: this.clearInput
                    }, Ut.a.createElement("i", {
                        class: "iconfont-close"
                    })))), Ut.a.createElement("div", {
                        class: "search-content"
                    }, o && u.length > 0 ? Ut.a.createElement("div", {
                        class: "suggestion"
                    }, u.slice(0, 5).map(function(t) {
                        return Ut.a.createElement("div", {
                            class: "suggestion-item"
                        }, Ut.a.createElement("a", {
                            class: "suggestion-text",
                            onClick: e.onClickKeywords.bind(e, t.keywords)
                        }, Xn(t.keywords)), t.relatedquerys && t.relatedquerys.length > 0 && Ut.a.createElement("div", {
                            class: "suggestion-tag-list"
                        }, t.relatedquerys.slice(0, 3).map(function(t) {
                            return Ut.a.createElement("a", {
                                class: "suggestion-tag",
                                onClick: e.onClickKeywords.bind(e, t.word)
                            }, Xn(t.word))
                        })))
                    })) : Ut.a.createElement("div", null, s.length > 0 && Ut.a.createElement("div", {
                        class: "history"
                    }, Ut.a.createElement("div", {
                        class: "keywords-title"
                    }, Hn("common_search_history"), ":", Ut.a.createElement("i", {
                        class: "iconfont-delete",
                        onClick: this.clearHistory
                    })), s.reverse().map(function(t) {
                        return Ut.a.createElement("a", {
                            class: "tag",
                            onClick: e.onClickKeywords.bind(e, t)
                        }, Xn(t))
                    })), "en" === Lr ? Ut.a.createElement("div", {
                        class: "popular"
                    }, i.length > 0 && Ut.a.createElement("div", {
                        class: "keywords-title"
                    }, Hn("common_search_popular"), ":"), i.slice(0, 5).map(function(t) {
                        return Ut.a.createElement("a", {
                            class: "tag",
                            onClick: e.onClickKeywords.bind(e, t)
                        }, Xn(t))
                    })) : null)))
                }
            }]), t
        }(Mt.Component),
        Jr = (n(12), Wn()),
        Kr = function(e) {
            function t(e) {
                var n;
                return Xe(this, t), n = tt(this, nt(t).call(this, e)), it(rt(n), "getCountryAndCurrency", function() {
                    var e = Wn(),
                        t = "countryAndCurrency-".concat(e),
                        r = ve(t, !0);
                    r ? n.initCountryAndCurrency(r) : Ar.fetchCountryAndCurrency().then(function(e) {
                        e && 200 === e.code && (we(t, e.data, !0), n.initCountryAndCurrency(e.data))
                    })
                }), it(rt(n), "initCountryAndCurrency", function(e) {
                    if (e && e.countryModule) {
                        var t = Yn(),
                            r = t.country,
                            o = t.currency;
                        n.setState({
                            country: r,
                            currency: o,
                            countryList: {
                                all: {
                                    name: Hn("ma_all_country"),
                                    list: e.countryModule.allCountryList
                                },
                                popular: {
                                    name: Hn("ma_popular_country"),
                                    list: e.countryModule.popularCountryList
                                }
                            },
                            currencyList: {
                                all: {
                                    name: Hn("ma_all_currency"),
                                    list: e.currencyModule.allCurrency
                                },
                                popular: {
                                    name: Hn("ma_popular_currency"),
                                    list: e.currencyModule.popularCurrency
                                }
                            }
                        })
                    }
                }), it(rt(n), "handlerGetValue", function(e, t) {
                    if (n.state[t]) {
                        var r = n.handlerChangeStateValue(e, t);
                        n.setState(Ye({}, r), function() {
                            var e = n.state,
                                t = e.language,
                                r = e.country,
                                o = e.currency;
                            Ar.changeCountryAndCurrency({
                                country: r,
                                currency: o,
                                language: t
                            }).then(function(e) {
                                window.location.reload()
                            })
                        })
                    }
                }), it(rt(n), "handlerChangeStateValue", function(e, t) {
                    var r = it({}, t, e);
                    if ("country" === t)
                        for (var o = n.state.countryList.all.list, a = 0, i = o.length; a < i; a++)
                            if (o[a].code === e) {
                                r.currency = o[a].currencyCode;
                                break
                            } return r
                }), n.state = {
                    countryList: {
                        all: {
                            list: []
                        },
                        popular: {
                            list: []
                        }
                    },
                    currencyList: {
                        all: {
                            list: []
                        },
                        popular: {
                            list: []
                        }
                    },
                    country: "us",
                    language: "en",
                    currency: "USD"
                }, n
            }
            return ot(t, e), et(t, [{
                key: "render",
                value: function() {
                    var e = this,
                        t = this.props,
                        n = t.items,
                        r = t.visible,
                        o = t.productId,
                        a = t.onClickMask,
                        i = t.onClickShare,
                        c = t.productTitle,
                        s = this.state,
                        l = s.currency,
                        u = (s.language, s.country, s.countryList, s.currencyList);
                    return r && Ut.a.createElement("div", {
                        class: "popup-menu",
                        onClick: a
                    }, Ut.a.createElement("div", {
                        class: "popup-menu-mask"
                    }), Ut.a.createElement("div", {
                        class: "popup-menu-wrap",
                        onClick: function(e) {
                            return e.stopPropagation()
                        }
                    }, Ut.a.createElement("ul", null, n.map(function(t) {
                        return "home" === t ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-home-fill"
                        }), Ut.a.createElement("a", {
                            href: "/"
                        }, Hn("pwa_home"))) : "messenger" === t && "en" === Jr ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-message-fill"
                        }), Ut.a.createElement("a", {
                            href: "//m.alibaba.com/atmHistory"
                        }, Hn("common_menu_messenger"))) : "inquiries" === t ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-inquery-fill"
                        }), Ut.a.createElement("a", {
                            href: "/messages/#inbox/inquiry/1"
                        }, Hn("pwa_inquiries"))) : "fav" === t && "en" === Jr ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-star-fill"
                        }), Ut.a.createElement("a", {
                            href: "//m.alibaba.com/favorite/"
                        }, Hn("common_menu_favorites"))) : "share" === t ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-share-2"
                        }), Ut.a.createElement("a", {
                            onClick: i
                        }, Hn("product_detail_share_product"))) : "language" === t ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-language"
                        }), Ut.a.createElement(Mr, {
                            onSelect: function(e) {
                                o ? location.href = ne(o, c, e.hostname) : e.noSlashStartPath ? location.href = e.homeUrl + e.noSlashStartPath : location.href = e.homeUrl
                            }
                        })) : "currency" === t ? u.all.list.length ? Ut.a.createElement("li", {
                            class: "ripple flex"
                        }, Ut.a.createElement("i", {
                            class: "icon iconfont-icon-pound"
                        }), Ut.a.createElement(Ir, {
                            type: "currency",
                            code: "currencyCode",
                            name: "currencyCode",
                            current: l,
                            list: u,
                            getValue: e.handlerGetValue
                        })) : Ut.a.createElement("span", null) : void 0
                    }))))
                }
            }]), t
        }(Mt.Component),
        Qr = (n(13), 2e3),
        Zr = function(e) {
            function t(e) {
                var n;
                return st(this, t), n = ft(this, pt(t).call(this, e)), yt(ht(n), "hide", function() {
                    n.setState({
                        visible: !1
                    })
                }), yt(ht(n), "showCopyMessage", function(e) {
                    var t = e ? "Copied." : "Oops, share was unsuccessful. Please copy URL and paste manually.";
                    n.setState({
                        copyMessage: t
                    }), window.setTimeout(function() {
                        n.setState({
                            copyMessage: ""
                        })
                    }, Qr)
                }), yt(ht(n), "onClickBtn", function(e, t) {
                    switch (t.type) {
                        case "mail":
                            break;
                        case "copy":
                            if (e.preventDefault(), !document.queryCommandSupported("copy")) return console.log("not support copy function."), void n.showCopyMessage(!1);
                            if (n.inputCopy && n.inputCopy.select) {
                                n.inputCopy.select();
                                try {
                                    var r = document.execCommand("copy");
                                    console.log("Copy link command return:", r), n.showCopyMessage(r)
                                } catch (e) {
                                    console.log("Oops, unable to copy"), n.showCopyMessage(!1)
                                }
                                window.getSelection().removeAllRanges()
                            } else console.log("not support .select function");
                            break;
                        default:
                            window.open(t.href), e.preventDefault()
                    }
                }), n.state = {
                    visible: !0,
                    copyMessage: ""
                }, n.inputCopy = null, n.getInputCopyRef = function(e) {
                    return n.inputCopy = e
                }, n
            }
            return mt(t, e), ut(t, [{
                key: "render",
                value: function() {
                    var e = this,
                        t = this.state,
                        n = t.visible,
                        r = t.copyMessage,
                        o = this.props,
                        a = o.platforms,
                        i = o.operations;
                    return n && Ut.a.createElement("div", {
                        class: "share-dialog"
                    }, Ut.a.createElement("div", {
                        class: "sns-share-overlay",
                        onClick: this.hide
                    }), Ut.a.createElement("div", {
                        class: "sns-share-menu"
                    }, Ut.a.createElement("div", {
                        class: "menu-wrapper"
                    }, Ut.a.createElement("ul", {
                        class: "menu-item"
                    }, a.map(function(t) {
                        return Ut.a.createElement("li", {
                            class: "btn-share"
                        }, Ut.a.createElement("a", {
                            class: "btn-share-link",
                            href: t.href,
                            onClick: function(n) {
                                e.onClickBtn(n, t)
                            }
                        }, Ut.a.createElement("img", {
                            class: "logo",
                            src: t.logo,
                            alt: "img"
                        }), Ut.a.createElement("span", {
                            class: "label"
                        }, t.label)))
                    })), Ut.a.createElement("ul", {
                        class: "menu-item"
                    }, i.map(function(t) {
                        return Ut.a.createElement("li", {
                            class: "btn-share"
                        }, Ut.a.createElement("a", {
                            class: "btn-share-link",
                            href: t.href,
                            onClick: function(n) {
                                e.onClickBtn(n, t)
                            }
                        }, Ut.a.createElement("img", {
                            class: "logo",
                            src: t.logo,
                            alt: "img"
                        }), Ut.a.createElement("span", {
                            class: "label"
                        }, t.label), "copy" === t.type && Ut.a.createElement("input", {
                            class: "input-copy",
                            value: t.href,
                            ref: e.getInputCopyRef
                        })))
                    }))), Ut.a.createElement("div", {
                        class: "btn-cancel"
                    }, "Cancel")), r ? Ut.a.createElement("div", {
                        class: "toast"
                    }, r) : null)
                }
            }]), t
        }(Mt.Component),
        zr = {
            twitter: {
                url: "https://twitter.com/intent/tweet?url={url}&text={text}",
                label: "Twitter"
            },
            pinterest: {
                url: "https://www.pinterest.com/pin/create/button/?media={image}&url={url}&description={text}",
                logo: "//u.alicdn.com/mobile/g/common/ai-sns-share/1.0.0/assets/pinterest.png",
                label: "Pinterest"
            },
            facebook: {
                url: "https://www.facebook.com/sharer.php?u={url}&p[title]={title}&p[summary]={text}",
                logo: "//u.alicdn.com/mobile/g/common/ai-sns-share/1.0.0/assets/fb.png",
                label: "Facebook"
            },
            vk: {
                url: "https://vk.com/share.php?url={url}&title={title}&description={text}&image={image}&noparse=true",
                logo: "//u.alicdn.com/mobile/g/common/ai-sns-share/1.0.0/assets/vk.png",
                label: "VK"
            },
            plus: {
                url: "https://plus.google.com/share?url={url}",
                logo: "//u.alicdn.com/mobile/g/common/ai-sns-share/1.0.0/assets/google-plus.png",
                label: "Google+"
            },
            mail: {
                url: "mailto:?subject={title}&body={text}, {url}",
                logo: "//u.alicdn.com/mobile/g/common/ai-sns-share/1.0.0/assets/mail.png",
                label: Hn("pwa_mail", "Mail")
            },
            copy: {
                url: "{url}",
                logo: "//u.alicdn.com/mobile/g/common/ai-sns-share/1.0.0/assets/copy.png",
                label: Hn("pwa_copy", "Copy")
            }
        },
        Hr = ["pinterest", "facebook", "vk", "plus"],
        Wr = ["mail", "copy"],
        Yr = function() {
            function e() {
                var t = this,
                    n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                bt(this, e), wt(this, "showDialog", function() {
                    Object(Mt.render)(Ut.a.createElement(Zr, {
                        platforms: t.platformData,
                        operations: t.operationData
                    }), document.body, document.querySelector(".share-dialog"))
                }), this.platforms = n.platforms || Hr, this.operations = n.operations || Wr, this.url = n.url || location.href, this.title = n.title || document.title, this.text = n.text || "", this.image = n.image || "", n.trigger && (this.triggerEl = document.querySelector(n.trigger), this.bindEvents()), this.platformData = this.getData(this.platforms), this.operationData = this.getData(this.operations)
            }
            return vt(e, [{
                key: "getData",
                value: function(e) {
                    var t = this;
                    return e.map(function(e) {
                        var n = zr[e];
                        return n ? (n.type = e, n.href = Ct({
                            type: e,
                            url: Et(t.url),
                            title: t.title,
                            text: t.text,
                            image: Et(t.image)
                        }), n) : null
                    }).filter(function(e) {
                        return e
                    })
                }
            }, {
                key: "bindEvents",
                value: function() {
                    this.triggerEl.addEventListener("click", this.showDialog)
                }
            }]), e
        }(),
        Xr = function(e) {
            function t(e) {
                var n;
                return kt(this, t), n = _t(this, It(t).call(this, e)), Tt(jt(n), "toggleMenu", function() {
                    n.state.menuVisible ? (n.menu.hide(), n.setState({
                        menuVisible: !1
                    })) : (n.menu.show(), n.setState({
                        menuVisible: !0
                    }))
                }), Tt(jt(n), "showSearch", function() {
                    n.search.show(), n.setState({
                        searchVisible: !0
                    })
                }), Tt(jt(n), "hideSearch", function() {
                    n.search.hide(), n.setState({
                        searchVisible: !1
                    })
                }), Tt(jt(n), "showSearchBar", function() {
                    n.setState({
                        searchBarHidden: !1
                    })
                }), Tt(jt(n), "hideSearchBar", function() {
                    n.setState({
                        searchBarHidden: !0
                    })
                }), Tt(jt(n), "showPopupMenu", function() {
                    n.setState({
                        popupMenuVisible: !0
                    }), n.popupMenu.getCountryAndCurrency()
                }), Tt(jt(n), "hidePopupMenu", function() {
                    n.setState({
                        popupMenuVisible: !1
                    })
                }), Tt(jt(n), "onClickFav", function() {
                    var e = n.props,
                        t = e.productId,
                        r = e.companyId,
                        o = e.productTitle,
                        a = n.state.isAlreadyFavorite;
                    if (!t) throw new Error("未设置 window.PAGE_DATA.modules.header.productId");
                    if (!zn.getIsLoggedIn()) return void zn.signIn();
                    a ? confirm('Do you want to remove "'.concat(o, '" from your favorites?')) && zn.removeFavorite(n.favoriteId).then(function(e) {
                        e.success && (n.setState({
                            isAlreadyFavorite: !1
                        }), n.favoriteId = "")
                    }) : zn.addFavorite(t, r).then(function(e) {
                        e.success && (n.setState({
                            isAlreadyFavorite: !0
                        }), n.favoriteId = e.fid)
                    })
                }), Tt(jt(n), "onClickShare", function() {
                    n.hidePopupMenu(), n.share = n.share || new Yr({
                        url: n.props.shareUrl
                    }), n.share.showDialog()
                }), Tt(jt(n), "onClickBack", function() {
                    "function" == typeof n.props.beforeBack && his.props.beforeBack(), n.props.backUrl ? location.href = n.props.backUrl : document.referrer.indexOf(".alibaba.com") > -1 ? history.back() : location.href = "/"
                }), n.state = {
                    searchBarHidden: !1,
                    menuVisible: !1,
                    searchVisible: !1,
                    popupMenuVisible: !1,
                    isAlreadyFavorite: !1
                }, n.menu = null, n.setMenuRef = function(e) {
                    n.menu = e
                }, n.popupMenu = null, n.setPopupMeun = function(e) {
                    n.popupMenu = e
                }, n.search = null, n.setSearchRef = function(e) {
                    n.search = e
                }, n.setLogoRef = function(e) {
                    window.__lazyload && window.__lazyload.observeIntersection(e)
                }, n
            }
            return xt(t, e), Ot(t, [{
                key: "componentDidMount",
                value: function() {
                    var e = this;
                    if (this.props.showSearchBar);
                    else this.setState({
                        searchBarHidden: !0
                    });
                    this.props.navItems.indexOf("fav") > -1 && zn.checkFavorite(this.props.productId).then(function(t) {
                        t && t.isFavorite && (e.setState({
                            isAlreadyFavorite: !0
                        }), e.favoriteId = t.fid)
                    })
                }
            }, {
                key: "componentDidUpdate",
                value: function() {
                    var e = document.querySelector("html");
                    this.state.menuVisible || this.state.searchVisible ? (e.style.overflowX = "hidden", e.style.overflowY = "hidden", e.style.position = "fixed") : (e.style.overflowX = "auto", e.style.overflowY = "auto", e.style.position = "static")
                }
            }, {
                key: "render",
                value: function() {
                    var e = this.props,
                        t = e.showSearchBar,
                        n = e.showPopupMenu,
                        r = e.navItems,
                        o = e.searchText,
                        a = e.shadow,
                        i = e.scrollTransition,
                        c = e.title,
                        s = void 0 === c ? "" : c,
                        l = e.popMenuItems,
                        u = this.state.isAlreadyFavorite,
                        f = Dt()("site-header", {
                            "search-bar-hidden": this.state.searchBarHidden,
                            "with-shadow": a
                        }),
                        p = Dt()("site-header", {
                            "search-bar-hidden": this.state.searchBarHidden,
                            "with-shadow": a,
                            transparent: i
                        }),
                        h = Ut.a.createElement(_r, {
                            class: f,
                            showSearchBar: t,
                            navItems: r,
                            onClickMenu: this.toggleMenu,
                            onClickSearch: this.showSearch,
                            onClickMore: this.showPopupMenu,
                            onClickFav: this.onClickFav,
                            onClickBack: this.onClickBack,
                            searchText: o || Hn("pwa_search"),
                            title: s,
                            highlightFavorite: u
                        }),
                        m = Ut.a.createElement(_r, {
                            class: p,
                            transparent: i,
                            showSearchBar: t,
                            navItems: r,
                            onClickMenu: this.toggleMenu,
                            onClickSearch: this.showSearch,
                            onClickMore: this.showPopupMenu,
                            onClickFav: this.onClickFav,
                            onClickBack: this.onClickBack,
                            searchText: o || Hn("pwa_search"),
                            title: s,
                            highlightFavorite: u
                        }); - 1 === r.indexOf("logo") && -1 === r.indexOf("title") && -1 === r.indexOf("inline-search") && ("menu" === r[0] || "back" === r[0] ? r.splice(1, 0, "title") : r.unshift("title"));
                    var d = "menu" === r[0];
                    return Ut.a.createElement("div", {
                        class: "header-wrap"
                    }, i ? Ut.a.createElement("div", null, Ut.a.createElement(Ft, {
                        start: 0,
                        end: 300,
                        opacityRange: [1, 0]
                    }, m), Ut.a.createElement(Ft, {
                        start: 0,
                        end: 300,
                        opacityRange: [0, 1]
                    }, h)) : h, d && Ut.a.createElement(Dr, {
                        ref: this.setMenuRef,
                        visible: this.state.menuVisible,
                        items: this.props.sideMenuItems,
                        onClickMask: this.toggleMenu
                    }), Ut.a.createElement(Gr, {
                        ref: this.setSearchRef,
                        inputValue: o,
                        visible: this.state.searchVisible,
                        onClickBack: this.hideSearch
                    }), n && Ut.a.createElement(Kr, {
                        ref: this.setPopupMeun,
                        visible: this.state.popupMenuVisible,
                        items: l,
                        onClickMask: this.hidePopupMenu,
                        onClickShare: this.onClickShare,
                        productId: this.props.productId,
                        productTitle: this.props.productTitle
                    }))
                }
            }]), t
        }(Mt.Component);
    window.PAGE_DATA.modules.header || (window.PAGE_DATA.modules.header = {
        __debug__: {
            warning: "页面没有设置 window.PAGE_DATA.modules.header，因此将使用默认配置。"
        }
    });
    var $r = window.PAGE_DATA.modules.header,
        eo = $r.navItems,
        to = void 0 === eo ? ["menu", "logo", "search"] : eo,
        no = $r.sideMenuItems,
        ro = void 0 === no ? ["home", "messenger", "inquiries", "rfq", "qq", "fav", "coupon", "country", "language", "currency", "feedback", "download"] : no,
        oo = $r.popMenuItems,
        ao = void 0 === oo ? ["home", "messenger", "inquiries", "fav", "language"] : oo,
        io = $r.showSearchBar,
        co = void 0 === io || io,
        so = $r.showPopupMenu,
        lo = void 0 === so || so,
        uo = $r.searchText,
        fo = void 0 === uo ? "" : uo,
        po = $r.shadow,
        ho = void 0 === po || po,
        mo = $r.scrollTransition,
        yo = void 0 !== mo && mo,
        bo = $r.title,
        go = void 0 === bo ? "" : bo,
        vo = $r.productId,
        wo = void 0 === vo ? "" : vo,
        Eo = $r.productTitle,
        Co = void 0 === Eo ? "" : Eo,
        So = $r.companyId,
        ko = void 0 === So ? "" : So,
        Ao = $r.shareUrl,
        Oo = void 0 === Ao ? "" : Ao,
        _o = $r.shareTitle,
        Io = void 0 === _o ? "" : _o,
        jo = $r.shareText,
        xo = void 0 === jo ? "" : jo,
        Po = $r.shareImage,
        To = void 0 === Po ? "" : Po;
    Object(Mt.render)(Ut.a.createElement(Xr, {
        showSearchBar: co,
        showPopupMenu: lo,
        navItems: to,
        sideMenuItems: ro,
        popMenuItems: ao,
        shadow: ho,
        scrollTransition: yo,
        title: go,
        productId: wo,
        productTitle: Co,
        companyId: ko,
        shareUrl: Oo,
        shareTitle: Io,
        shareText: xo,
        shareImage: To,
        searchText: fo
    }), document.querySelector('[data-comp-name="header"]'), document.querySelector('[data-comp-name="header"] .site-header'))
}, function(e, t) {}, function(e, t) {}, function(e, t) {
    function n() {}

    function r(e, t, n) {
        var r = !0;
        if (e) {
            var o = 0,
                a = e.length,
                i = t[0],
                c = t[1],
                s = t[2];
            switch (t.length) {
                case 0:
                    for (; o < a; o += 2) r = !1 !== e[o].call(e[o + 1] || n) && r;
                    break;
                case 1:
                    for (; o < a; o += 2) r = !1 !== e[o].call(e[o + 1] || n, i) && r;
                    break;
                case 2:
                    for (; o < a; o += 2) r = !1 !== e[o].call(e[o + 1] || n, i, c) && r;
                    break;
                case 3:
                    for (; o < a; o += 2) r = !1 !== e[o].call(e[o + 1] || n, i, c, s) && r;
                    break;
                default:
                    for (; o < a; o += 2) r = !1 !== e[o].apply(e[o + 1] || n, t) && r
            }
        }
        return r
    }

    function o(e) {
        return "[object Function]" === Object.prototype.toString.call(e)
    }
    var a = /\s+/;
    n.prototype.on = function(e, t, n) {
        var r, o, i;
        if (!t) return this;
        for (r = this.__events || (this.__events = {}), e = e.split(a); o = e.shift();) i = r[o] || (r[o] = []), i.push(t, n);
        return this
    }, n.prototype.once = function(e, t, n) {
        var r = this,
            o = function() {
                r.off(e, o), t.apply(n || r, arguments)
            };
        return this.on(e, o, n)
    }, n.prototype.off = function(e, t, n) {
        var r, o, c, s;
        if (!(r = this.__events)) return this;
        if (!(e || t || n)) return delete this.__events, this;
        for (e = e ? e.split(a) : i(r); o = e.shift();)
            if (c = r[o])
                if (t || n)
                    for (s = c.length - 2; s >= 0; s -= 2) t && c[s] !== t || n && c[s + 1] !== n || c.splice(s, 2);
                else delete r[o];
        return this
    }, n.prototype.trigger = function(e) {
        var t, n, o, i, c, s, l = [],
            u = !0;
        if (!(t = this.__events)) return this;
        for (e = e.split(a), c = 1, s = arguments.length; c < s; c++) l[c - 1] = arguments[c];
        for (; n = e.shift();)(o = t.all) && (o = o.slice()), (i = t[n]) && (i = i.slice()), "all" !== n && (u = r(i, l, this) && u), u = r(o, [n].concat(l), this) && u;
        return u
    }, n.prototype.emit = n.prototype.trigger;
    var i = Object.keys;
    i || (i = function(e) {
        var t = [];
        for (var n in e) e.hasOwnProperty(n) && t.push(n);
        return t
    }), n.mixTo = function(e) {
        e = o(e) ? e.prototype : e;
        var t = n.prototype,
            r = new n;
        for (var a in t) t.hasOwnProperty(a) && function(n) {
            e[n] = function() {
                return t[n].apply(r, Array.prototype.slice.call(arguments)), this
            }
        }(a)
    }, e.exports = n
}, function(e, t) {}, function(e, t) {}, function(e, t) {}, function(e, t) {}, function(e, t) {}]);