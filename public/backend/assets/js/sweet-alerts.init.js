// SweetAlert2 CDN fallback loader
// This is a placeholder. Please replace with the actual SweetAlert2.min.js file or use CDN in your layout.
/*!
 * sweetalert2 v11.9.0
 * Released under the MIT License.
 */
!(function (t, e) {
  "object" == typeof exports && "undefined" != typeof module ? (module.exports = e()) : "function" == typeof define && define.amd ? define(e) : ((t = "undefined" != typeof globalThis ? globalThis : t || self).Sweetalert2 = e());
})(this, function () {
  "use strict";
  function t(t, e) {
    return (function (t, e) {
      if (e.get) return e.get.call(t);
      return e.value;
    })(t, n(t, e, "get"));
  }
  function e(t, e, o) {
    return (
      (function (t, e, n) {
        if (e.set) e.set.call(t, n);
        else {
          if (!e.writable) throw new TypeError("attempted to set read only private field");
          e.value = n;
        }
      })(t, n(t, e, "set"), o),
      o
    );
  }
  function n(t, e, n) {
    if (!e.has(t)) throw new TypeError("attempted to " + n + " private field on non-instance");
    return e.get(t);
  }
  function o(t, e, n) {
    !(function (t, e) {
      if (e.has(t)) throw new TypeError("Cannot initialize the same private elements twice on an object");
    })(t, e),
      e.set(t, n);
  }
  const i = {},
    s = (t) =>
      new Promise((e) => {
        if (!t) return e();
        const n = window.scrollX,
          o = window.scrollY;
        (i.restoreFocusTimeout = setTimeout(() => {
          i.previousActiveElement instanceof HTMLElement ? (i.previousActiveElement.focus(), (i.previousActiveElement = null)) : document.body && document.body.focus(), e();
        }, 100)),
          window.scrollTo(n, o);
      }),
    r = "swal2-",
    a = [
      "container",
      "shown",
      "height-auto",
      "iosfix",
      "popup",
      "modal",
      "no-backdrop",
      "no-transition",
      "toast",
      "toast-shown",
      "show",
      "hide",
      "close",
      "title",
      "html-container",
      "actions",
      "confirm",
      "deny",
      "cancel",
      "default-outline",
      "footer",
      "icon",
      "icon-content",
      "image",
      "input",
      "file",
      "range",
      "select",
      "radio",
      "checkbox",
      "label",
      "textarea",
      "inputerror",
      "input-label",
      "validation-message",
      "progress-steps",
      "active-progress-step",
      "progress-step",
      "progress-step-line",
      "loader",
      "loading",
      "styled",
      "top",
      "top-start",
      "top-end",
      "top-left",
      "top-right",
      "center",
      "center-start",
      "center-end",
      "center-left",
      "center-right",
      "bottom",
      "bottom-start",
      "bottom-end",
      "bottom-left",
      "bottom-right",
      "grow-row",
      "grow-column",
      "grow-fullscreen",
      "rtl",
      "timer-progress-bar",
      "timer-progress-bar-container",
      "scrollbar-measure",
      "icon-success",
      "icon-warning",
      "icon-info",
      "icon-question",
      "icon-error",
    ].reduce((t, e) => ((t[e] = r + e), t), {}),
    c = ["success", "warning", "info", "question", "error"].reduce((t, e) => ((t[e] = r + e), t), {}),
    l = "SweetAlert2:",
    u = (t) => t.charAt(0).toUpperCase() + t.slice(1),
    d = (t) => {
      console.warn("".concat(l, " ").concat("object" == typeof t ? t.join(" ") : t));
    },
    p = (t) => {
      console.error("".concat(l, " ").concat(t));
    },
    m = [],
    h = (t, e) => {
      var n;
      (n = '"'.concat(t, '" is deprecated and will be removed in the next major release. Please use "').concat(e, '" instead.')), m.includes(n) || (m.push(n), d(n));
    },
    g = (t) => ("function" == typeof t ? t() : t),
    f = (t) => t && "function" == typeof t.toPromise,
    b = (t) => (f(t) ? t.toPromise() : Promise.resolve(t)),
    y = (t) => t && Promise.resolve(t) === t,
    w = () => document.body.querySelector(".".concat(a.container)),
    v = (t) => {
      const e = w();
      return e ? e.querySelector(t) : null;
    },
    C = (t) => v(".".concat(t)),
    A = () => C(a.popup),
    k = () => C(a.icon),
    B = () => C(a.title),
    E = () => C(a["html-container"]),
    x = () => C(a.image),
    T = () => C(a["progress-steps"]),
    P = () => C(a["validation-message"]),
    L = () => v(".".concat(a.actions, " .").concat(a.confirm)),
    S = () => v(".".concat(a.actions, " .").concat(a.cancel)),
    O = () => v(".".concat(a.actions, " .").concat(a.deny)),
    M = () => v(".".concat(a.loader)),
    j = () => C(a.actions),
    H = () => C(a.footer),
    I = () => C(a["timer-progress-bar"]),
    D = () => C(a.close),
    q = () => {
      const t = A();
      if (!t) return [];
      const e = t.querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])'),
        n = Array.from(e).sort((t, e) => {
          const n = parseInt(t.getAttribute("tabindex") || "0"),
            o = parseInt(e.getAttribute("tabindex") || "0");
          return n > o ? 1 : n < o ? -1 : 0;
        }),
        o = t.querySelectorAll(
          '\n  a[href],\n  area[href],\n  input:not([disabled]),\n  select:not([disabled]),\n  textarea:not([disabled]),\n  button:not([disabled]),\n  iframe,\n  object,\n  embed,\n  [tabindex="0"],\n  [contenteditable],\n  audio[controls],\n  video[controls],\n  summary\n'
        ),
        i = Array.from(o).filter((t) => "-1" !== t.getAttribute("tabindex"));
      return [...new Set(n.concat(i))].filter((t) => et(t));
    },
    V = () => _(document.body, a.shown) && !_(document.body, a["toast-shown"]) && !_(document.body, a["no-backdrop"]),
    N = () => {
      const t = A();
      return !!t && _(t, a.toast);
    },
    F = (t, e) => {
      if (((t.textContent = ""), e)) {
        const n = new DOMParser().parseFromString(e, "text/html"),
          o = n.querySelector("head");
        o &&
          Array.from(o.childNodes).forEach((e) => {
            t.appendChild(e);
          });
        const i = n.querySelector("body");
        i &&
          Array.from(i.childNodes).forEach((e) => {
            e instanceof HTMLVideoElement || e instanceof HTMLAudioElement ? t.appendChild(e.cloneNode(!0)) : t.appendChild(e);
          });
      }
    },
    _ = (t, e) => {
      if (!e) return !1;
      const n = e.split(/\s+/);
      for (let e = 0; e < n.length; e++) if (!t.classList.contains(n[e])) return !1;
      return !0;
    },
    R = (t, e, n) => {
      if (
        (((t, e) => {
          Array.from(t.classList).forEach((n) => {
            Object.values(a).includes(n) || Object.values(c).includes(n) || Object.values(e.showClass || {}).includes(n) || t.classList.remove(n);
          });
        })(t, e),
        e.customClass && e.customClass[n])
      ) {
        if ("string" != typeof e.customClass[n] && !e.customClass[n].forEach) return void d("Invalid type of customClass.".concat(n, '! Expected string or iterable object, got "').concat(typeof e.customClass[n], '"'));
        K(t, e.customClass[n]);
      }
    },
    U = (t, e) => {
      if (!e) return null;
      switch (e) {
        case "select":
        case "textarea":
        case "file":
          return t.querySelector(".".concat(a.popup, " > .").concat(a[e]));
        case "checkbox":
          return t.querySelector(".".concat(a.popup, " > .").concat(a.checkbox, " input"));
        case "radio":
          return t.querySelector(".".concat(a.popup, " > .").concat(a.radio, " input:checked")) || t.querySelector(".".concat(a.popup, " > .").concat(a.radio, " input:first-child"));
        case "range":
          return t.querySelector(".".concat(a.popup, " > .").concat(a.range, " input"));
        default:
          return t.querySelector(".".concat(a.popup, " > .").concat(a.input));
      }
    },
    z = (t) => {
      if ((t.focus(), "file" !== t.type)) {
        const e = t.value;
        (t.value = ""), (t.value = e);
      }
    },
    W = (t, e, n) => {
      t &&
        e &&
        ("string" == typeof e && (e = e.split(/\s+/).filter(Boolean)),
        e.forEach((e) => {
          Array.isArray(t)
            ? t.forEach((t) => {
                n ? t.classList.add(e) : t.classList.remove(e);
              })
            : n
            ? t.classList.add(e)
            : t.classList.remove(e);
        }));
    },
    K = (t, e) => {
      W(t, e, !0);
    },
    Y = (t, e) => {
      W(t, e, !1);
    },
    Z = (t, e) => {
      const n = Array.from(t.children);
      for (let t = 0; t < n.length; t++) {
        const o = n[t];
        if (o instanceof HTMLElement && _(o, e)) return o;
      }
    },
    $ = (t, e, n) => {
      n === "".concat(parseInt(n)) && (n = parseInt(n)), n || 0 === parseInt(n) ? (t.style[e] = "number" == typeof n ? "".concat(n, "px") : n) : t.style.removeProperty(e);
    },
    J = function (t) {
      let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "flex";
      t && (t.style.display = e);
    },
    X = (t) => {
      t && (t.style.display = "none");
    },
    G = function (t) {
      let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "block";
      t &&
        new MutationObserver(() => {
          tt(t, t.innerHTML, e);
        }).observe(t, { childList: !0, subtree: !0 });
    },
    Q = (t, e, n, o) => {
      const i = t.querySelector(e);
      i && (i.style[n] = o);
    },
    tt = function (t, e) {
      e ? J(t, arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "flex") : X(t);
    },
    et = (t) => !(!t || !(t.offsetWidth || t.offsetHeight || t.getClientRects().length)),
    nt = (t) => !!(t.scrollHeight > t.clientHeight),
    ot = (t) => {
      const e = window.getComputedStyle(t),
        n = parseFloat(e.getPropertyValue("animation-duration") || "0"),
        o = parseFloat(e.getPropertyValue("transition-duration") || "0");
      return n > 0 || o > 0;
    },
    it = function (t) {
      let e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
      const n = I();
      n &&
        et(n) &&
        (e && ((n.style.transition = "none"), (n.style.width = "100%")),
        setTimeout(() => {
          (n.style.transition = "width ".concat(t / 1e3, "s linear")), (n.style.width = "0%");
        }, 10));
    },
    st = () => "undefined" == typeof window || "undefined" == typeof document,
    rt = '\n <div aria-labelledby="'
      .concat(a.title, '" aria-describedby="')
      .concat(a["html-container"], '" class="')
      .concat(a.popup, '" tabindex="-1">\n   <button type="button" class="')
      .concat(a.close, '"></button>\n   <ul class="')
      .concat(a["progress-steps"], '"></ul>\n   <div class="')
      .concat(a.icon, '"></div>\n   <img class="')
      .concat(a.image, '" />\n   <h2 class="')
      .concat(a.title, '" id="')
      .concat(a.title, '"></h2>\n   <div class="')
      .concat(a["html-container"], '" id="')
      .concat(a["html-container"], '"></div>\n   <input class="')
      .concat(a.input, '" id="')
      .concat(a.input, '" />\n   <input type="file" class="')
      .concat(a.file, '" />\n   <div class="')
      .concat(a.range, '">\n     <input type="range" />\n     <output></output>\n   </div>\n   <select class="')
      .concat(a.select, '" id="')
      .concat(a.select, '"></select>\n   <div class="')
      .concat(a.radio, '"></div>\n   <label class="')
      .concat(a.checkbox, '">\n     <input type="checkbox" id="')
      .concat(a.checkbox, '" />\n     <span class="')
      .concat(a.label, '"></span>\n   </label>\n   <textarea class="')
      .concat(a.textarea, '" id="')
      .concat(a.textarea, '"></textarea>\n   <div class="')
      .concat(a["validation-message"], '" id="')
      .concat(a["validation-message"], '"></div>\n   <div class="')
      .concat(a.actions, '">\n     <div class="')
      .concat(a.loader, '"></div>\n     <button type="button" class="')
      .concat(a.confirm, '"></button>\n     <button type="button" class="')
      .concat(a.deny, '"></button>\n     <button type="button" class="')
      .concat(a.cancel, '"></button>\n   </div>\n   <div class="')
      .concat(a.footer, '"></div>\n   <div class="')
      .concat(a["timer-progress-bar-container"], '">\n     <div class="')
      .concat(a["timer-progress-bar"], '"></div>\n   </div>\n </div>\n')
      .replace(/(^|\n)\s*/g, ""),
    at = () => {
      i.currentInstance.resetValidationMessage();
    },
    ct = (t) => {
      const e = (() => {
        const t = w();
        return !!t && (t.remove(), Y([document.documentElement, document.body], [a["no-backdrop"], a["toast-shown"], a["has-column"]]), !0);
      })();
      if (st()) return void p("SweetAlert2 requires document to initialize");
      const n = document.createElement("div");
      (n.className = a.container), e && K(n, a["no-transition"]), F(n, rt);
      const o = "string" == typeof (i = t.target) ? document.querySelector(i) : i;
      var i;
      o.appendChild(n),
        ((t) => {
          const e = A();
          e.setAttribute("role", t.toast ? "alert" : "dialog"), e.setAttribute("aria-live", t.toast ? "polite" : "assertive"), t.toast || e.setAttribute("aria-modal", "true");
        })(t),
        ((t) => {
          "rtl" === window.getComputedStyle(t).direction && K(w(), a.rtl);
        })(o),
        (() => {
          const t = A(),
            e = Z(t, a.input),
            n = Z(t, a.file),
            o = t.querySelector(".".concat(a.range, " input")),
            i = t.querySelector(".".concat(a.range, " output")),
            s = Z(t, a.select),
            r = t.querySelector(".".concat(a.checkbox, " input")),
            c = Z(t, a.textarea);
          (e.oninput = at),
            (n.onchange = at),
            (s.onchange = at),
            (r.onchange = at),
            (c.oninput = at),
            (o.oninput = () => {
              at(), (i.value = o.value);
            }),
            (o.onchange = () => {
              at(), (i.value = o.value);
            });
        })();
    },
    lt = (t, e) => {
      t instanceof HTMLElement ? e.appendChild(t) : "object" == typeof t ? ut(t, e) : t && F(e, t);
    },
    ut = (t, e) => {
      t.jquery ? dt(e, t) : F(e, t.toString());
    },
    dt = (t, e) => {
      if (((t.textContent = ""), 0 in e)) for (let n = 0; n in e; n++) t.appendChild(e[n].cloneNode(!0));
      else t.appendChild(e.cloneNode(!0));
    },
    pt = (() => {
      if (st()) return !1;
      const t = document.createElement("div");
      return void 0 !== t.style.webkitAnimation ? "webkitAnimationEnd" : void 0 !== t.style.animation && "animationend";
    })(),
    mt = (t, e) => {
      const n = j(),
        o = M();
      n &&
        o &&
        (e.showConfirmButton || e.showDenyButton || e.showCancelButton ? J(n) : X(n),
        R(n, e, "actions"),
        (function (t, e, n) {
          const o = L(),
            i = O(),
            s = S();
          if (!o || !i || !s) return;
          ht(o, "confirm", n),
            ht(i, "deny", n),
            ht(s, "cancel", n),
            (function (t, e, n, o) {
              if (!o.buttonsStyling) return void Y([t, e, n], a.styled);
              K([t, e, n], a.styled), o.confirmButtonColor && ((t.style.backgroundColor = o.confirmButtonColor), K(t, a["default-outline"]));
              o.denyButtonColor && ((e.style.backgroundColor = o.denyButtonColor), K(e, a["default-outline"]));
              o.cancelButtonColor && ((n.style.backgroundColor = o.cancelButtonColor), K(n, a["default-outline"]));
            })(o, i, s, n),
            n.reverseButtons && (n.toast ? (t.insertBefore(s, o), t.insertBefore(i, o)) : (t.insertBefore(s, e), t.insertBefore(i, e), t.insertBefore(o, e)));
        })(n, o, e),
        F(o, e.loaderHtml || ""),
        R(o, e, "loader"));
    };
  function ht(t, e, n) {
    const o = u(e);
    tt(t, n["show".concat(o, "Button")], "inline-block"), F(t, n["".concat(e, "ButtonText")] || ""), t.setAttribute("aria-label", n["".concat(e, "ButtonAriaLabel")] || ""), (t.className = a[e]), R(t, n, "".concat(e, "Button"));
  }
  const gt = (t, e) => {
    const n = w();
    n &&
      (!(function (t, e) {
        "string" == typeof e ? (t.style.background = e) : e || K([document.documentElement, document.body], a["no-backdrop"]);
      })(n, e.backdrop),
      (function (t, e) {
        if (!e) return;
        e in a ? K(t, a[e]) : (d('The "position" parameter is not valid, defaulting to "center"'), K(t, a.center));
      })(n, e.position),
      (function (t, e) {
        if (!e) return;
        K(t, a["grow-".concat(e)]);
      })(n, e.grow),
      R(n, e, "container"));
  };
  var ft = { innerParams: new WeakMap(), domCache: new WeakMap() };
  const bt = ["input", "file", "range", "select", "radio", "checkbox", "textarea"],
    yt = (t) => {
      if (!t.input) return;
      if (!Et[t.input]) return void p("Unexpected type of input! Expected ".concat(Object.keys(Et).join(" | "), ', got "').concat(t.input, '"'));
      const e = kt(t.input),
        n = Et[t.input](e, t);
      J(e),
        t.inputAutoFocus &&
          setTimeout(() => {
            z(n);
          });
    },
    wt = (t, e) => {
      const n = U(A(), t);
      if (n) {
        ((t) => {
          for (let e = 0; e < t.attributes.length; e++) {
            const n = t.attributes[e].name;
            ["id", "type", "value", "style"].includes(n) || t.removeAttribute(n);
          }
        })(n);
        for (const t in e) n.setAttribute(t, e[t]);
      }
    },
    vt = (t) => {
      const e = kt(t.input);
      "object" == typeof t.customClass && K(e, t.customClass.input);
    },
    Ct = (t, e) => {
      (t.placeholder && !e.inputPlaceholder) || (t.placeholder = e.inputPlaceholder);
    },
    At = (t, e, n) => {
      if (n.inputLabel) {
        const o = document.createElement("label"),
          i = a["input-label"];
        o.setAttribute("for", t.id), (o.className = i), "object" == typeof n.customClass && K(o, n.customClass.inputLabel), (o.innerText = n.inputLabel), e.insertAdjacentElement("beforebegin", o);
      }
    },
    kt = (t) => Z(A(), a[t] || a.input),
    Bt = (t, e) => {
      ["string", "number"].includes(typeof e) ? (t.value = "".concat(e)) : y(e) || d('Unexpected type of inputValue! Expected "string", "number" or "Promise", got "'.concat(typeof e, '"'));
    },
    Et = {};
  (Et.text = Et.email = Et.password = Et.number = Et.tel = Et.url = Et.search = Et.date = Et["datetime-local"] = Et.time = Et.week = Et.month = (t, e) => (Bt(t, e.inputValue), At(t, t, e), Ct(t, e), (t.type = e.input), t)),
    (Et.file = (t, e) => (At(t, t, e), Ct(t, e), t)),
    (Et.range = (t, e) => {
      const n = t.querySelector("input"),
        o = t.querySelector("output");
      return Bt(n, e.inputValue), (n.type = e.input), Bt(o, e.inputValue), At(n, t, e), t;
    }),
    (Et.select = (t, e) => {
      if (((t.textContent = ""), e.inputPlaceholder)) {
        const n = document.createElement("option");
        F(n, e.inputPlaceholder), (n.value = ""), (n.disabled = !0), (n.selected = !0), t.appendChild(n);
      }
      return At(t, t, e), t;
    }),
    (Et.radio = (t) => ((t.textContent = ""), t)),
    (Et.checkbox = (t, e) => {
      const n = U(A(), "checkbox");
      (n.value = "1"), (n.checked = Boolean(e.inputValue));
      const o = t.querySelector("span");
      return F(o, e.inputPlaceholder), n;
    }),
    (Et.textarea = (t, e) => {
      Bt(t, e.inputValue), Ct(t, e), At(t, t, e);
      return (
        setTimeout(() => {
          if ("MutationObserver" in window) {
            const n = parseInt(window.getComputedStyle(A()).width);
            new MutationObserver(() => {
              if (!document.body.contains(t)) return;
              const o = t.offsetWidth + ((i = t), parseInt(window.getComputedStyle(i).marginLeft) + parseInt(window.getComputedStyle(i).marginRight));
              var i;
              o > n ? (A().style.width = "".concat(o, "px")) : $(A(), "width", e.width);
            }).observe(t, { attributes: !0, attributeFilter: ["style"] });
          }
        }),
        t
      );
    });
  const xt = (t, e) => {
      const n = E();
      n &&
        (G(n),
        R(n, e, "htmlContainer"),
        e.html ? (lt(e.html, n), J(n, "block")) : e.text ? ((n.textContent = e.text), J(n, "block")) : X(n),
        ((t, e) => {
          const n = A();
          if (!n) return;
          const o = ft.innerParams.get(t),
            i = !o || e.input !== o.input;
          bt.forEach((t) => {
            const o = Z(n, a[t]);
            o && (wt(t, e.inputAttributes), (o.className = a[t]), i && X(o));
          }),
            e.input && (i && yt(e), vt(e));
        })(t, e));
    },
    Tt = (t, e) => {
      for (const [n, o] of Object.entries(c)) e.icon !== n && Y(t, o);
      K(t, e.icon && c[e.icon]), St(t, e), Pt(), R(t, e, "icon");
    },
    Pt = () => {
      const t = A();
      if (!t) return;
      const e = window.getComputedStyle(t).getPropertyValue("background-color"),
        n = t.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix");
      for (let t = 0; t < n.length; t++) n[t].style.backgroundColor = e;
    },
    Lt = (t, e) => {
      if (!e.icon && !e.iconHtml) return;
      let n = t.innerHTML,
        o = "";
      if (e.iconHtml) o = Ot(e.iconHtml);
      else if ("success" === e.icon)
        (o =
          '\n  <div class="swal2-success-circular-line-left"></div>\n  <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n  <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n  <div class="swal2-success-circular-line-right"></div>\n'),
          (n = n.replace(/ style=".*?"/g, ""));
      else if ("error" === e.icon) o = '\n  <span class="swal2-x-mark">\n    <span class="swal2-x-mark-line-left"></span>\n    <span class="swal2-x-mark-line-right"></span>\n  </span>\n';
      else if (e.icon) {
        o = Ot({ question: "?", warning: "!", info: "i" }[e.icon]);
      }
      n.trim() !== o.trim() && F(t, o);
    },
    St = (t, e) => {
      if (e.iconColor) {
        (t.style.color = e.iconColor), (t.style.borderColor = e.iconColor);
        for (const n of [".swal2-success-line-tip", ".swal2-success-line-long", ".swal2-x-mark-line-left", ".swal2-x-mark-line-right"]) Q(t, n, "backgroundColor", e.iconColor);
        Q(t, ".swal2-success-ring", "borderColor", e.iconColor);
      }
    },
    Ot = (t) => '<div class="'.concat(a["icon-content"], '">').concat(t, "</div>"),
    Mt = (t, e) => {
      const n = e.showClass || {};
      (t.className = "".concat(a.popup, " ").concat(et(t) ? n.popup : "")),
        e.toast ? (K([document.documentElement, document.body], a["toast-shown"]), K(t, a.toast)) : K(t, a.modal),
        R(t, e, "popup"),
        "string" == typeof e.customClass && K(t, e.customClass),
        e.icon && K(t, a["icon-".concat(e.icon)]);
    },
    jt = (t) => {
      const e = document.createElement("li");
      return K(e, a["progress-step"]), F(e, t), e;
    },
    Ht = (t) => {
      const e = document.createElement("li");
      return K(e, a["progress-step-line"]), t.progressStepsDistance && $(e, "width", t.progressStepsDistance), e;
    },
    It = (t, e) => {
      ((t, e) => {
        const n = w(),
          o = A();
        if (n && o) {
          if (e.toast) {
            $(n, "width", e.width), (o.style.width = "100%");
            const t = M();
            t && o.insertBefore(t, k());
          } else $(o, "width", e.width);
          $(o, "padding", e.padding), e.color && (o.style.color = e.color), e.background && (o.style.background = e.background), X(P()), Mt(o, e);
        }
      })(0, e),
        gt(0, e),
        ((t, e) => {
          const n = T();
          if (!n) return;
          const { progressSteps: o, currentProgressStep: i } = e;
          o && 0 !== o.length && void 0 !== i
            ? (J(n),
              (n.textContent = ""),
              i >= o.length && d("Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"),
              o.forEach((t, s) => {
                const r = jt(t);
                if ((n.appendChild(r), s === i && K(r, a["active-progress-step"]), s !== o.length - 1)) {
                  const t = Ht(e);
                  n.appendChild(t);
                }
              }))
            : X(n);
        })(0, e),
        ((t, e) => {
          const n = ft.innerParams.get(t),
            o = k();
          if (o) {
            if (n && e.icon === n.icon) return Lt(o, e), void Tt(o, e);
            if (e.icon || e.iconHtml) {
              if (e.icon && -1 === Object.keys(c).indexOf(e.icon)) return p('Unknown icon! Expected "success", "error", "warning", "info" or "question", got "'.concat(e.icon, '"')), void X(o);
              J(o), Lt(o, e), Tt(o, e), K(o, e.showClass && e.showClass.icon);
            } else X(o);
          }
        })(t, e),
        ((t, e) => {
          const n = x();
          n && (e.imageUrl ? (J(n, ""), n.setAttribute("src", e.imageUrl), n.setAttribute("alt", e.imageAlt || ""), $(n, "width", e.imageWidth), $(n, "height", e.imageHeight), (n.className = a.image), R(n, e, "image")) : X(n));
        })(0, e),
        ((t, e) => {
          const n = B();
          n && (G(n), tt(n, e.title || e.titleText, "block"), e.title && lt(e.title, n), e.titleText && (n.innerText = e.titleText), R(n, e, "title"));
        })(0, e),
        ((t, e) => {
          const n = D();
          n && (F(n, e.closeButtonHtml || ""), R(n, e, "closeButton"), tt(n, e.showCloseButton), n.setAttribute("aria-label", e.closeButtonAriaLabel || ""));
        })(0, e),
        xt(t, e),
        mt(0, e),
        ((t, e) => {
          const n = H();
          n && (G(n), tt(n, e.footer, "block"), e.footer && lt(e.footer, n), R(n, e, "footer"));
        })(0, e);
      const n = A();
      "function" == typeof e.didRender && n && e.didRender(n);
    },
    Dt = () => {
      var t;
      return null === (t = L()) || void 0 === t ? void 0 : t.click();
    },
    qt = Object.freeze({ cancel: "cancel", backdrop: "backdrop", close: "close", esc: "esc", timer: "timer" }),
    Vt = (t) => {
      t.keydownTarget && t.keydownHandlerAdded && (t.keydownTarget.removeEventListener("keydown", t.keydownHandler, { capture: t.keydownListenerCapture }), (t.keydownHandlerAdded = !1));
    },
    Nt = (t, e) => {
      var n;
      const o = q();
      if (o.length) return (t += e) === o.length ? (t = 0) : -1 === t && (t = o.length - 1), void o[t].focus();
      null === (n = A()) || void 0 === n || n.focus();
    },
    Ft = ["ArrowRight", "ArrowDown"],
    _t = ["ArrowLeft", "ArrowUp"],
    Rt = (t, e, n) => {
      t && (e.isComposing || 229 === e.keyCode || (t.stopKeydownPropagation && e.stopPropagation(), "Enter" === e.key ? Ut(e, t) : "Tab" === e.key ? zt(e) : [...Ft, ..._t].includes(e.key) ? Wt(e.key) : "Escape" === e.key && Kt(e, t, n)));
    },
    Ut = (t, e) => {
      if (!g(e.allowEnterKey)) return;
      const n = U(A(), e.input);
      if (t.target && n && t.target instanceof HTMLElement && t.target.outerHTML === n.outerHTML) {
        if (["textarea", "file"].includes(e.input)) return;
        Dt(), t.preventDefault();
      }
    },
    zt = (t) => {
      const e = t.target,
        n = q();
      let o = -1;
      for (let t = 0; t < n.length; t++)
        if (e === n[t]) {
          o = t;
          break;
        }
      t.shiftKey ? Nt(o, -1) : Nt(o, 1), t.stopPropagation(), t.preventDefault();
    },
    Wt = (t) => {
      const e = j(),
        n = L(),
        o = O(),
        i = S();
      if (!(e && n && o && i)) return;
      const s = [n, o, i];
      if (document.activeElement instanceof HTMLElement && !s.includes(document.activeElement)) return;
      const r = Ft.includes(t) ? "nextElementSibling" : "previousElementSibling";
      let a = document.activeElement;
      if (a) {
        for (let t = 0; t < e.children.length; t++) {
          if (((a = a[r]), !a)) return;
          if (a instanceof HTMLButtonElement && et(a)) break;
        }
        a instanceof HTMLButtonElement && a.focus();
      }
    },
    Kt = (t, e, n) => {
      g(e.allowEscapeKey) && (t.preventDefault(), n(qt.esc));
    };
  var Yt = { swalPromiseResolve: new WeakMap(), swalPromiseReject: new WeakMap() };
  const Zt = () => {
      Array.from(document.body.children).forEach((t) => {
        t.hasAttribute("data-previous-aria-hidden") ? (t.setAttribute("aria-hidden", t.getAttribute("data-previous-aria-hidden") || ""), t.removeAttribute("data-previous-aria-hidden")) : t.removeAttribute("aria-hidden");
      });
    },
    $t = "undefined" != typeof window && !!window.GestureEvent,
    Jt = () => {
      const t = w();
      if (!t) return;
      let e;
      (t.ontouchstart = (t) => {
        e = Xt(t);
      }),
        (t.ontouchmove = (t) => {
          e && (t.preventDefault(), t.stopPropagation());
        });
    },
    Xt = (t) => {
      const e = t.target,
        n = w(),
        o = E();
      return !(!n || !o) && !Gt(t) && !Qt(t) && (e === n || (!nt(n) && e instanceof HTMLElement && "INPUT" !== e.tagName && "TEXTAREA" !== e.tagName && (!nt(o) || !o.contains(e))));
    },
    Gt = (t) => t.touches && t.touches.length && "stylus" === t.touches[0].touchType,
    Qt = (t) => t.touches && t.touches.length > 1;
  let te = null;
  const ee = (t) => {
    null === te &&
      (document.body.scrollHeight > window.innerHeight || "scroll" === t) &&
      ((te = parseInt(window.getComputedStyle(document.body).getPropertyValue("padding-right"))),
      (document.body.style.paddingRight = "".concat(
        te +
          (() => {
            const t = document.createElement("div");
            (t.className = a["scrollbar-measure"]), document.body.appendChild(t);
            const e = t.getBoundingClientRect().width - t.clientWidth;
            return document.body.removeChild(t), e;
          })(),
        "px"
      )));
  };
  function ne(t, e, n, o) {
    N() ? ue(t, o) : (s(n).then(() => ue(t, o)), Vt(i)),
      $t ? (e.setAttribute("style", "display:none !important"), e.removeAttribute("class"), (e.innerHTML = "")) : e.remove(),
      V() &&
        (null !== te && ((document.body.style.paddingRight = "".concat(te, "px")), (te = null)),
        (() => {
          if (_(document.body, a.iosfix)) {
            const t = parseInt(document.body.style.top, 10);
            Y(document.body, a.iosfix), (document.body.style.top = ""), (document.body.scrollTop = -1 * t);
          }
        })(),
        Zt()),
      Y([document.documentElement, document.body], [a.shown, a["height-auto"], a["no-backdrop"], a["toast-shown"]]);
  }
  function oe(t) {
    t = ae(t);
    const e = Yt.swalPromiseResolve.get(this),
      n = ie(this);
    this.isAwaitingPromise ? t.isDismissed || (re(this), e(t)) : n && e(t);
  }
  const ie = (t) => {
    const e = A();
    if (!e) return !1;
    const n = ft.innerParams.get(t);
    if (!n || _(e, n.hideClass.popup)) return !1;
    Y(e, n.showClass.popup), K(e, n.hideClass.popup);
    const o = w();
    return Y(o, n.showClass.backdrop), K(o, n.hideClass.backdrop), ce(t, e, n), !0;
  };
  function se(t) {
    const e = Yt.swalPromiseReject.get(this);
    re(this), e && e(t);
  }
  const re = (t) => {
      t.isAwaitingPromise && (delete t.isAwaitingPromise, ft.innerParams.get(t) || t._destroy());
    },
    ae = (t) => (void 0 === t ? { isConfirmed: !1, isDenied: !1, isDismissed: !0 } : Object.assign({ isConfirmed: !1, isDenied: !1, isDismissed: !1 }, t)),
    ce = (t, e, n) => {
      const o = w(),
        i = pt && ot(e);
      "function" == typeof n.willClose && n.willClose(e), i ? le(t, e, o, n.returnFocus, n.didClose) : ne(t, o, n.returnFocus, n.didClose);
    },
    le = (t, e, n, o, s) => {
      pt &&
        ((i.swalCloseEventFinishedCallback = ne.bind(null, t, n, o, s)),
        e.addEventListener(pt, function (t) {
          t.target === e && (i.swalCloseEventFinishedCallback(), delete i.swalCloseEventFinishedCallback);
        }));
    },
    ue = (t, e) => {
      setTimeout(() => {
        "function" == typeof e && e.bind(t.params)(), t._destroy && t._destroy();
      });
    },
    de = (t) => {
      let e = A();
      if ((e || new Rn(), (e = A()), !e)) return;
      const n = M();
      N() ? X(k()) : pe(e, t), J(n), e.setAttribute("data-loading", "true"), e.setAttribute("aria-busy", "true"), e.focus();
    },
    pe = (t, e) => {
      const n = j(),
        o = M();
      n && o && (!e && et(L()) && (e = L()), J(n), e && (X(e), o.setAttribute("data-button-to-replace", e.className), n.insertBefore(o, e)), K([t, n], a.loading));
    },
    me = (t) => (t.checked ? 1 : 0),
    he = (t) => (t.checked ? t.value : null),
    ge = (t) => (t.files && t.files.length ? (null !== t.getAttribute("multiple") ? t.files : t.files[0]) : null),
    fe = (t, e) => {
      const n = A();
      if (!n) return;
      const o = (t) => {
        "select" === e.input
          ? (function (t, e, n) {
              const o = Z(t, a.select);
              if (!o) return;
              const i = (t, e, o) => {
                const i = document.createElement("option");
                (i.value = o), F(i, e), (i.selected = we(o, n.inputValue)), t.appendChild(i);
              };
              e.forEach((t) => {
                const e = t[0],
                  n = t[1];
                if (Array.isArray(n)) {
                  const t = document.createElement("optgroup");
                  (t.label = e), (t.disabled = !1), o.appendChild(t), n.forEach((e) => i(t, e[1], e[0]));
                } else i(o, n, e);
              }),
                o.focus();
            })(n, ye(t), e)
          : "radio" === e.input &&
            (function (t, e, n) {
              const o = Z(t, a.radio);
              if (!o) return;
              e.forEach((t) => {
                const e = t[0],
                  i = t[1],
                  s = document.createElement("input"),
                  r = document.createElement("label");
                (s.type = "radio"), (s.name = a.radio), (s.value = e), we(e, n.inputValue) && (s.checked = !0);
                const c = document.createElement("span");
                F(c, i), (c.className = a.label), r.appendChild(s), r.appendChild(c), o.appendChild(r);
              });
              const i = o.querySelectorAll("input");
              i.length && i[0].focus();
            })(n, ye(t), e);
      };
      f(e.inputOptions) || y(e.inputOptions)
        ? (de(L()),
          b(e.inputOptions).then((e) => {
            t.hideLoading(), o(e);
          }))
        : "object" == typeof e.inputOptions
        ? o(e.inputOptions)
        : p("Unexpected type of inputOptions! Expected object, Map or Promise, got ".concat(typeof e.inputOptions));
    },
    be = (t, e) => {
      const n = t.getInput();
      n &&
        (X(n),
        b(e.inputValue)
          .then((o) => {
            (n.value = "number" === e.input ? "".concat(parseFloat(o) || 0) : "".concat(o)), J(n), n.focus(), t.hideLoading();
          })
          .catch((e) => {
            p("Error in inputValue promise: ".concat(e)), (n.value = ""), J(n), n.focus(), t.hideLoading();
          }));
    };
  const ye = (t) => {
      const e = [];
      return (
        t instanceof Map
          ? t.forEach((t, n) => {
              let o = t;
              "object" == typeof o && (o = ye(o)), e.push([n, o]);
            })
          : Object.keys(t).forEach((n) => {
              let o = t[n];
              "object" == typeof o && (o = ye(o)), e.push([n, o]);
            }),
        e
      );
    },
    we = (t, e) => !!e && e.toString() === t.toString(),
    ve = (t, e) => {
      const n = ft.innerParams.get(t);
      if (!n.input) return void p('The "input" parameter is needed to be set when using returnInputValueOn'.concat(u(e)));
      const o = t.getInput(),
        i = ((t, e) => {
          const n = t.getInput();
          if (!n) return null;
          switch (e.input) {
            case "checkbox":
              return me(n);
            case "radio":
              return he(n);
            case "file":
              return ge(n);
            default:
              return e.inputAutoTrim ? n.value.trim() : n.value;
          }
        })(t, n);
      n.inputValidator ? Ce(t, i, e) : o && !o.checkValidity() ? (t.enableButtons(), t.showValidationMessage(n.validationMessage)) : "deny" === e ? Ae(t, i) : Ee(t, i);
    },
    Ce = (t, e, n) => {
      const o = ft.innerParams.get(t);
      t.disableInput();
      Promise.resolve()
        .then(() => b(o.inputValidator(e, o.validationMessage)))
        .then((o) => {
          t.enableButtons(), t.enableInput(), o ? t.showValidationMessage(o) : "deny" === n ? Ae(t, e) : Ee(t, e);
        });
    },
    Ae = (t, e) => {
      const n = ft.innerParams.get(t || void 0);
      if ((n.showLoaderOnDeny && de(O()), n.preDeny)) {
        t.isAwaitingPromise = !0;
        Promise.resolve()
          .then(() => b(n.preDeny(e, n.validationMessage)))
          .then((n) => {
            !1 === n ? (t.hideLoading(), re(t)) : t.close({ isDenied: !0, value: void 0 === n ? e : n });
          })
          .catch((e) => Be(t || void 0, e));
      } else t.close({ isDenied: !0, value: e });
    },
    ke = (t, e) => {
      t.close({ isConfirmed: !0, value: e });
    },
    Be = (t, e) => {
      t.rejectPromise(e);
    },
    Ee = (t, e) => {
      const n = ft.innerParams.get(t || void 0);
      if ((n.showLoaderOnConfirm && de(), n.preConfirm)) {
        t.resetValidationMessage(), (t.isAwaitingPromise = !0);
        Promise.resolve()
          .then(() => b(n.preConfirm(e, n.validationMessage)))
          .then((n) => {
            et(P()) || !1 === n ? (t.hideLoading(), re(t)) : ke(t, void 0 === n ? e : n);
          })
          .catch((e) => Be(t || void 0, e));
      } else ke(t, e);
    };
  function xe() {
    const t = ft.innerParams.get(this);
    if (!t) return;
    const e = ft.domCache.get(this);
    X(e.loader),
      N() ? t.icon && J(k()) : Te(e),
      Y([e.popup, e.actions], a.loading),
      e.popup.removeAttribute("aria-busy"),
      e.popup.removeAttribute("data-loading"),
      (e.confirmButton.disabled = !1),
      (e.denyButton.disabled = !1),
      (e.cancelButton.disabled = !1);
  }
  const Te = (t) => {
    const e = t.popup.getElementsByClassName(t.loader.getAttribute("data-button-to-replace"));
    e.length ? J(e[0], "inline-block") : et(L()) || et(O()) || et(S()) || X(t.actions);
  };
  function Pe() {
    const t = ft.innerParams.get(this),
      e = ft.domCache.get(this);
    return e ? U(e.popup, t.input) : null;
  }
  function Le(t, e, n) {
    const o = ft.domCache.get(t);
    e.forEach((t) => {
      o[t].disabled = n;
    });
  }
  function Se(t, e) {
    const n = A();
    if (n && t)
      if ("radio" === t.type) {
        const t = n.querySelectorAll('[name="'.concat(a.radio, '"]'));
        for (let n = 0; n < t.length; n++) t[n].disabled = e;
      } else t.disabled = e;
  }
  function Oe() {
    Le(this, ["confirmButton", "denyButton", "cancelButton"], !1);
  }
  function Me() {
    Le(this, ["confirmButton", "denyButton", "cancelButton"], !0);
  }
  function je() {
    Se(this.getInput(), !1);
  }
  function He() {
    Se(this.getInput(), !0);
  }
  function Ie(t) {
    const e = ft.domCache.get(this),
      n = ft.innerParams.get(this);
    F(e.validationMessage, t), (e.validationMessage.className = a["validation-message"]), n.customClass && n.customClass.validationMessage && K(e.validationMessage, n.customClass.validationMessage), J(e.validationMessage);
    const o = this.getInput();
    o && (o.setAttribute("aria-invalid", "true"), o.setAttribute("aria-describedby", a["validation-message"]), z(o), K(o, a.inputerror));
  }
  function De() {
    const t = ft.domCache.get(this);
    t.validationMessage && X(t.validationMessage);
    const e = this.getInput();
    e && (e.removeAttribute("aria-invalid"), e.removeAttribute("aria-describedby"), Y(e, a.inputerror));
  }
  const qe = {
      title: "",
      titleText: "",
      text: "",
      html: "",
      footer: "",
      icon: void 0,
      iconColor: void 0,
      iconHtml: void 0,
      template: void 0,
      toast: !1,
      showClass: { popup: "swal2-show", backdrop: "swal2-backdrop-show", icon: "swal2-icon-show" },
      hideClass: { popup: "swal2-hide", backdrop: "swal2-backdrop-hide", icon: "swal2-icon-hide" },
      customClass: {},
      target: "body",
      color: void 0,
      backdrop: !0,
      heightAuto: !0,
      allowOutsideClick: !0,
      allowEscapeKey: !0,
      allowEnterKey: !0,
      stopKeydownPropagation: !0,
      keydownListenerCapture: !1,
      showConfirmButton: !0,
      showDenyButton: !1,
      showCancelButton: !1,
      preConfirm: void 0,
      preDeny: void 0,
      confirmButtonText: "OK",
      confirmButtonAriaLabel: "",
      confirmButtonColor: void 0,
      denyButtonText: "No",
      denyButtonAriaLabel: "",
      denyButtonColor: void 0,
      cancelButtonText: "Cancel",
      cancelButtonAriaLabel: "",
      cancelButtonColor: void 0,
      buttonsStyling: !0,
      reverseButtons: !1,
      focusConfirm: !0,
      focusDeny: !1,
      focusCancel: !1,
      returnFocus: !0,
      showCloseButton: !1,
      closeButtonHtml: "&times;",
      closeButtonAriaLabel: "Close this dialog",
      loaderHtml: "",
      showLoaderOnConfirm: !1,
      showLoaderOnDeny: !1,
      imageUrl: void 0,
      imageWidth: void 0,
      imageHeight: void 0,
      imageAlt: "",
      timer: void 0,
      timerProgressBar: !1,
      width: void 0,
      padding: void 0,
      background: void 0,
      input: void 0,
      inputPlaceholder: "",
      inputLabel: "",
      inputValue: "",
      inputOptions: {},
      inputAutoFocus: !0,
      inputAutoTrim: !0,
      inputAttributes: {},
      inputValidator: void 0,
      returnInputValueOnDeny: !1,
      validationMessage: void 0,
      grow: !1,
      position: "center",
      progressSteps: [],
      currentProgressStep: void 0,
      progressStepsDistance: void 0,
      willOpen: void 0,
      didOpen: void 0,
      didRender: void 0,
      willClose: void 0,
      didClose: void 0,
      didDestroy: void 0,
      scrollbarPadding: !0,
    },
    Ve = [
      "allowEscapeKey",
      "allowOutsideClick",
      "background",
      "buttonsStyling",
      "cancelButtonAriaLabel",
      "cancelButtonColor",
      "cancelButtonText",
      "closeButtonAriaLabel",
      "closeButtonHtml",
      "color",
      "confirmButtonAriaLabel",
      "confirmButtonColor",
      "confirmButtonText",
      "currentProgressStep",
      "customClass",
      "denyButtonAriaLabel",
      "denyButtonColor",
      "denyButtonText",
      "didClose",
      "didDestroy",
      "footer",
      "hideClass",
      "html",
      "icon",
      "iconColor",
      "iconHtml",
      "imageAlt",
      "imageHeight",
      "imageUrl",
      "imageWidth",
      "preConfirm",
      "preDeny",
      "progressSteps",
      "returnFocus",
      "reverseButtons",
      "showCancelButton",
      "showCloseButton",
      "showConfirmButton",
      "showDenyButton",
      "text",
      "title",
      "titleText",
      "willClose",
    ],
    Ne = {},
    Fe = ["allowOutsideClick", "allowEnterKey", "backdrop", "focusConfirm", "focusDeny", "focusCancel", "returnFocus", "heightAuto", "keydownListenerCapture"],
    _e = (t) => Object.prototype.hasOwnProperty.call(qe, t),
    Re = (t) => -1 !== Ve.indexOf(t),
    Ue = (t) => Ne[t],
    ze = (t) => {
      _e(t) || d('Unknown parameter "'.concat(t, '"'));
    },
    We = (t) => {
      Fe.includes(t) && d('The parameter "'.concat(t, '" is incompatible with toasts'));
    },
    Ke = (t) => {
      const e = Ue(t);
      e && h(t, e);
    };
  function Ye(t) {
    const e = A(),
      n = ft.innerParams.get(this);
    if (!e || _(e, n.hideClass.popup)) return void d("You're trying to update the closed or closing popup, that won't work. Use the update() method in preConfirm parameter or show a new popup.");
    const o = Ze(t),
      i = Object.assign({}, n, o);
    It(this, i), ft.innerParams.set(this, i), Object.defineProperties(this, { params: { value: Object.assign({}, this.params, t), writable: !1, enumerable: !0 } });
  }
  const Ze = (t) => {
    const e = {};
    return (
      Object.keys(t).forEach((n) => {
        Re(n) ? (e[n] = t[n]) : d("Invalid parameter to update: ".concat(n));
      }),
      e
    );
  };
  function $e() {
    const t = ft.domCache.get(this),
      e = ft.innerParams.get(this);
    e ? (t.popup && i.swalCloseEventFinishedCallback && (i.swalCloseEventFinishedCallback(), delete i.swalCloseEventFinishedCallback), "function" == typeof e.didDestroy && e.didDestroy(), Je(this)) : Xe(this);
  }
  const Je = (t) => {
      Xe(t), delete t.params, delete i.keydownHandler, delete i.keydownTarget, delete i.currentInstance;
    },
    Xe = (t) => {
      t.isAwaitingPromise
        ? (Ge(ft, t), (t.isAwaitingPromise = !0))
        : (Ge(Yt, t),
          Ge(ft, t),
          delete t.isAwaitingPromise,
          delete t.disableButtons,
          delete t.enableButtons,
          delete t.getInput,
          delete t.disableInput,
          delete t.enableInput,
          delete t.hideLoading,
          delete t.disableLoading,
          delete t.showValidationMessage,
          delete t.resetValidationMessage,
          delete t.close,
          delete t.closePopup,
          delete t.closeModal,
          delete t.closeToast,
          delete t.rejectPromise,
          delete t.update,
          delete t._destroy);
    },
    Ge = (t, e) => {
      for (const n in t) t[n].delete(e);
    };
  var Qe = Object.freeze({
    __proto__: null,
    _destroy: $e,
    close: oe,
    closeModal: oe,
    closePopup: oe,
    closeToast: oe,
    disableButtons: Me,
    disableInput: He,
    disableLoading: xe,
    enableButtons: Oe,
    enableInput: je,
    getInput: Pe,
    handleAwaitingPromise: re,
    hideLoading: xe,
    rejectPromise: se,
    resetValidationMessage: De,
    showValidationMessage: Ie,
    update: Ye,
  });
  const tn = (t, e, n) => {
      e.popup.onclick = () => {
        (t && (en(t) || t.timer || t.input)) || n(qt.close);
      };
    },
    en = (t) => !!(t.showConfirmButton || t.showDenyButton || t.showCancelButton || t.showCloseButton);
  let nn = !1;
  const on = (t) => {
      t.popup.onmousedown = () => {
        t.container.onmouseup = function (e) {
          (t.container.onmouseup = () => {}), e.target === t.container && (nn = !0);
        };
      };
    },
    sn = (t) => {
      t.container.onmousedown = () => {
        t.popup.onmouseup = function (e) {
          (t.popup.onmouseup = () => {}), (e.target === t.popup || (e.target instanceof HTMLElement && t.popup.contains(e.target))) && (nn = !0);
        };
      };
    },
    rn = (t, e, n) => {
      e.container.onclick = (o) => {
        nn ? (nn = !1) : o.target === e.container && g(t.allowOutsideClick) && n(qt.backdrop);
      };
    },
    an = (t) => t instanceof Element || ((t) => "object" == typeof t && t.jquery)(t);
  const cn = () => {
      if (i.timeout)
        return (
          (() => {
            const t = I();
            if (!t) return;
            const e = parseInt(window.getComputedStyle(t).width);
            t.style.removeProperty("transition"), (t.style.width = "100%");
            const n = (e / parseInt(window.getComputedStyle(t).width)) * 100;
            t.style.width = "".concat(n, "%");
          })(),
          i.timeout.stop()
        );
    },
    ln = () => {
      if (i.timeout) {
        const t = i.timeout.start();
        return it(t), t;
      }
    };
  let un = !1;
  const dn = {};
  const pn = (t) => {
    for (let e = t.target; e && e !== document; e = e.parentNode)
      for (const t in dn) {
        const n = e.getAttribute(t);
        if (n) return void dn[t].fire({ template: n });
      }
  };
  var mn = Object.freeze({
    __proto__: null,
    argsToParams: (t) => {
      const e = {};
      return (
        "object" != typeof t[0] || an(t[0])
          ? ["title", "html", "icon"].forEach((n, o) => {
              const i = t[o];
              "string" == typeof i || an(i) ? (e[n] = i) : void 0 !== i && p("Unexpected type of ".concat(n, '! Expected "string" or "Element", got ').concat(typeof i));
            })
          : Object.assign(e, t[0]),
        e
      );
    },
    bindClickHandler: function () {
      (dn[arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "data-swal-template"] = this), un || (document.body.addEventListener("click", pn), (un = !0));
    },
    clickCancel: () => {
      var t;
      return null === (t = S()) || void 0 === t ? void 0 : t.click();
    },
    clickConfirm: Dt,
    clickDeny: () => {
      var t;
      return null === (t = O()) || void 0 === t ? void 0 : t.click();
    },
    enableLoading: de,
    fire: function () {
      for (var t = arguments.length, e = new Array(t), n = 0; n < t; n++) e[n] = arguments[n];
      return new this(...e);
    },
    getActions: j,
    getCancelButton: S,
    getCloseButton: D,
    getConfirmButton: L,
    getContainer: w,
    getDenyButton: O,
    getFocusableElements: q,
    getFooter: H,
    getHtmlContainer: E,
    getIcon: k,
    getIconContent: () => C(a["icon-content"]),
    getImage: x,
    getInputLabel: () => C(a["input-label"]),
    getLoader: M,
    getPopup: A,
    getProgressSteps: T,
    getTimerLeft: () => i.timeout && i.timeout.getTimerLeft(),
    getTimerProgressBar: I,
    getTitle: B,
    getValidationMessage: P,
    increaseTimer: (t) => {
      if (i.timeout) {
        const e = i.timeout.increase(t);
        return it(e, !0), e;
      }
    },
    isDeprecatedParameter: Ue,
    isLoading: () => {
      const t = A();
      return !!t && t.hasAttribute("data-loading");
    },
    isTimerRunning: () => !(!i.timeout || !i.timeout.isRunning()),
    isUpdatableParameter: Re,
    isValidParameter: _e,
    isVisible: () => et(A()),
    mixin: function (t) {
      return class extends this {
        _main(e, n) {
          return super._main(e, Object.assign({}, t, n));
        }
      };
    },
    resumeTimer: ln,
    showLoading: de,
    stopTimer: cn,
    toggleTimer: () => {
      const t = i.timeout;
      return t && (t.running ? cn() : ln());
    },
  });
  class hn {
    constructor(t, e) {
      (this.callback = t), (this.remaining = e), (this.running = !1), this.start();
    }
    start() {
      return this.running || ((this.running = !0), (this.started = new Date()), (this.id = setTimeout(this.callback, this.remaining))), this.remaining;
    }
    stop() {
      return this.started && this.running && ((this.running = !1), clearTimeout(this.id), (this.remaining -= new Date().getTime() - this.started.getTime())), this.remaining;
    }
    increase(t) {
      const e = this.running;
      return e && this.stop(), (this.remaining += t), e && this.start(), this.remaining;
    }
    getTimerLeft() {
      return this.running && (this.stop(), this.start()), this.remaining;
    }
    isRunning() {
      return this.running;
    }
  }
  const gn = ["swal-title", "swal-html", "swal-footer"],
    fn = (t) => {
      const e = {};
      return (
        Array.from(t.querySelectorAll("swal-param")).forEach((t) => {
          Bn(t, ["name", "value"]);
          const n = t.getAttribute("name"),
            o = t.getAttribute("value");
          e[n] = "boolean" == typeof qe[n] ? "false" !== o : "object" == typeof qe[n] ? JSON.parse(o) : o;
        }),
        e
      );
    },
    bn = (t) => {
      const e = {};
      return (
        Array.from(t.querySelectorAll("swal-function-param")).forEach((t) => {
          const n = t.getAttribute("name"),
            o = t.getAttribute("value");
          e[n] = new Function("return ".concat(o))();
        }),
        e
      );
    },
    yn = (t) => {
      const e = {};
      return (
        Array.from(t.querySelectorAll("swal-button")).forEach((t) => {
          Bn(t, ["type", "color", "aria-label"]);
          const n = t.getAttribute("type");
          (e["".concat(n, "ButtonText")] = t.innerHTML),
            (e["show".concat(u(n), "Button")] = !0),
            t.hasAttribute("color") && (e["".concat(n, "ButtonColor")] = t.getAttribute("color")),
            t.hasAttribute("aria-label") && (e["".concat(n, "ButtonAriaLabel")] = t.getAttribute("aria-label"));
        }),
        e
      );
    },
    wn = (t) => {
      const e = {},
        n = t.querySelector("swal-image");
      return (
        n &&
          (Bn(n, ["src", "width", "height", "alt"]),
          n.hasAttribute("src") && (e.imageUrl = n.getAttribute("src")),
          n.hasAttribute("width") && (e.imageWidth = n.getAttribute("width")),
          n.hasAttribute("height") && (e.imageHeight = n.getAttribute("height")),
          n.hasAttribute("alt") && (e.imageAlt = n.getAttribute("alt"))),
        e
      );
    },
    vn = (t) => {
      const e = {},
        n = t.querySelector("swal-icon");
      return n && (Bn(n, ["type", "color"]), n.hasAttribute("type") && (e.icon = n.getAttribute("type")), n.hasAttribute("color") && (e.iconColor = n.getAttribute("color")), (e.iconHtml = n.innerHTML)), e;
    },
    Cn = (t) => {
      const e = {},
        n = t.querySelector("swal-input");
      n &&
        (Bn(n, ["type", "label", "placeholder", "value"]),
        (e.input = n.getAttribute("type") || "text"),
        n.hasAttribute("label") && (e.inputLabel = n.getAttribute("label")),
        n.hasAttribute("placeholder") && (e.inputPlaceholder = n.getAttribute("placeholder")),
        n.hasAttribute("value") && (e.inputValue = n.getAttribute("value")));
      const o = Array.from(t.querySelectorAll("swal-input-option"));
      return (
        o.length &&
          ((e.inputOptions = {}),
          o.forEach((t) => {
            Bn(t, ["value"]);
            const n = t.getAttribute("value"),
              o = t.innerHTML;
            e.inputOptions[n] = o;
          })),
        e
      );
    },
    An = (t, e) => {
      const n = {};
      for (const o in e) {
        const i = e[o],
          s = t.querySelector(i);
        s && (Bn(s, []), (n[i.replace(/^swal-/, "")] = s.innerHTML.trim()));
      }
      return n;
    },
    kn = (t) => {
      const e = gn.concat(["swal-param", "swal-function-param", "swal-button", "swal-image", "swal-icon", "swal-input", "swal-input-option"]);
      Array.from(t.children).forEach((t) => {
        const n = t.tagName.toLowerCase();
        e.includes(n) || d("Unrecognized element <".concat(n, ">"));
      });
    },
    Bn = (t, e) => {
      Array.from(t.attributes).forEach((n) => {
        -1 === e.indexOf(n.name) &&
          d(['Unrecognized attribute "'.concat(n.name, '" on <').concat(t.tagName.toLowerCase(), ">."), "".concat(e.length ? "Allowed attributes are: ".concat(e.join(", ")) : "To set the value, use HTML within the element.")]);
      });
    },
    En = (t) => {
      const e = w(),
        n = A();
      "function" == typeof t.willOpen && t.willOpen(n);
      const o = window.getComputedStyle(document.body).overflowY;
      Ln(e, n, t),
        setTimeout(() => {
          Tn(e, n);
        }, 10),
        V() &&
          (Pn(e, t.scrollbarPadding, o),
          Array.from(document.body.children).forEach((t) => {
            t === w() || t.contains(w()) || (t.hasAttribute("aria-hidden") && t.setAttribute("data-previous-aria-hidden", t.getAttribute("aria-hidden") || ""), t.setAttribute("aria-hidden", "true"));
          })),
        N() || i.previousActiveElement || (i.previousActiveElement = document.activeElement),
        "function" == typeof t.didOpen && setTimeout(() => t.didOpen(n)),
        Y(e, a["no-transition"]);
    },
    xn = (t) => {
      const e = A();
      if (t.target !== e || !pt) return;
      const n = w();
      e.removeEventListener(pt, xn), (n.style.overflowY = "auto");
    },
    Tn = (t, e) => {
      pt && ot(e) ? ((t.style.overflowY = "hidden"), e.addEventListener(pt, xn)) : (t.style.overflowY = "auto");
    },
    Pn = (t, e, n) => {
      (() => {
        if ($t && !_(document.body, a.iosfix)) {
          const t = document.body.scrollTop;
          (document.body.style.top = "".concat(-1 * t, "px")), K(document.body, a.iosfix), Jt();
        }
      })(),
        e && "hidden" !== n && ee(n),
        setTimeout(() => {
          t.scrollTop = 0;
        });
    },
    Ln = (t, e, n) => {
      K(t, n.showClass.backdrop),
        e.style.setProperty("opacity", "0", "important"),
        J(e, "grid"),
        setTimeout(() => {
          K(e, n.showClass.popup), e.style.removeProperty("opacity");
        }, 10),
        K([document.documentElement, document.body], a.shown),
        n.heightAuto && n.backdrop && !n.toast && K([document.documentElement, document.body], a["height-auto"]);
    };
  var Sn = {
    email: (t, e) => (/^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(t) ? Promise.resolve() : Promise.resolve(e || "Invalid email address")),
    url: (t, e) => (/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)$/.test(t) ? Promise.resolve() : Promise.resolve(e || "Invalid URL")),
  };
  function On(t) {
    !(function (t) {
      t.inputValidator || ("email" === t.input && (t.inputValidator = Sn.email), "url" === t.input && (t.inputValidator = Sn.url));
    })(t),
      t.showLoaderOnConfirm &&
        !t.preConfirm &&
        d("showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://sweetalert2.github.io/#ajax-request"),
      (function (t) {
        (!t.target || ("string" == typeof t.target && !document.querySelector(t.target)) || ("string" != typeof t.target && !t.target.appendChild)) && (d('Target parameter is not valid, defaulting to "body"'), (t.target = "body"));
      })(t),
      "string" == typeof t.title && (t.title = t.title.split("\n").join("<br />")),
      ct(t);
  }
  let Mn;
  var jn = new WeakMap();
  class Hn {
    constructor() {
      if ((o(this, jn, { writable: !0, value: void 0 }), "undefined" == typeof window)) return;
      Mn = this;
      for (var t = arguments.length, n = new Array(t), i = 0; i < t; i++) n[i] = arguments[i];
      const s = Object.freeze(this.constructor.argsToParams(n));
      (this.params = s), (this.isAwaitingPromise = !1), e(this, jn, this._main(Mn.params));
    }
    _main(t) {
      let e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
      ((t) => {
        !1 === t.backdrop && t.allowOutsideClick && d('"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`');
        for (const e in t) ze(e), t.toast && We(e), Ke(e);
      })(Object.assign({}, e, t)),
        i.currentInstance && (i.currentInstance._destroy(), V() && Zt()),
        (i.currentInstance = Mn);
      const n = Dn(t, e);
      On(n), Object.freeze(n), i.timeout && (i.timeout.stop(), delete i.timeout), clearTimeout(i.restoreFocusTimeout);
      const o = qn(Mn);
      return It(Mn, n), ft.innerParams.set(Mn, n), In(Mn, o, n);
    }
    then(e) {
      return t(this, jn).then(e);
    }
    finally(e) {
      return t(this, jn).finally(e);
    }
  }
  const In = (t, e, n) =>
      new Promise((o, s) => {
        const r = (e) => {
          t.close({ isDismissed: !0, dismiss: e });
        };
        Yt.swalPromiseResolve.set(t, o),
          Yt.swalPromiseReject.set(t, s),
          (e.confirmButton.onclick = () => {
            ((t) => {
              const e = ft.innerParams.get(t);
              t.disableButtons(), e.input ? ve(t, "confirm") : Ee(t, !0);
            })(t);
          }),
          (e.denyButton.onclick = () => {
            ((t) => {
              const e = ft.innerParams.get(t);
              t.disableButtons(), e.returnInputValueOnDeny ? ve(t, "deny") : Ae(t, !1);
            })(t);
          }),
          (e.cancelButton.onclick = () => {
            ((t, e) => {
              t.disableButtons(), e(qt.cancel);
            })(t, r);
          }),
          (e.closeButton.onclick = () => {
            r(qt.close);
          }),
          ((t, e, n) => {
            t.toast ? tn(t, e, n) : (on(e), sn(e), rn(t, e, n));
          })(n, e, r),
          ((t, e, n) => {
            Vt(t),
              e.toast ||
                ((t.keydownHandler = (t) => Rt(e, t, n)),
                (t.keydownTarget = e.keydownListenerCapture ? window : A()),
                (t.keydownListenerCapture = e.keydownListenerCapture),
                t.keydownTarget.addEventListener("keydown", t.keydownHandler, { capture: t.keydownListenerCapture }),
                (t.keydownHandlerAdded = !0));
          })(i, n, r),
          ((t, e) => {
            "select" === e.input || "radio" === e.input ? fe(t, e) : ["text", "email", "number", "tel", "textarea"].some((t) => t === e.input) && (f(e.inputValue) || y(e.inputValue)) && (de(L()), be(t, e));
          })(t, n),
          En(n),
          Vn(i, n, r),
          Nn(e, n),
          setTimeout(() => {
            e.container.scrollTop = 0;
          });
      }),
    Dn = (t, e) => {
      const n = ((t) => {
          const e = "string" == typeof t.template ? document.querySelector(t.template) : t.template;
          if (!e) return {};
          const n = e.content;
          return kn(n), Object.assign(fn(n), bn(n), yn(n), wn(n), vn(n), Cn(n), An(n, gn));
        })(t),
        o = Object.assign({}, qe, e, n, t);
      return (o.showClass = Object.assign({}, qe.showClass, o.showClass)), (o.hideClass = Object.assign({}, qe.hideClass, o.hideClass)), o;
    },
    qn = (t) => {
      const e = { popup: A(), container: w(), actions: j(), confirmButton: L(), denyButton: O(), cancelButton: S(), loader: M(), closeButton: D(), validationMessage: P(), progressSteps: T() };
      return ft.domCache.set(t, e), e;
    },
    Vn = (t, e, n) => {
      const o = I();
      X(o),
        e.timer &&
          ((t.timeout = new hn(() => {
            n("timer"), delete t.timeout;
          }, e.timer)),
          e.timerProgressBar &&
            (J(o),
            R(o, e, "timerProgressBar"),
            setTimeout(() => {
              t.timeout && t.timeout.running && it(e.timer);
            })));
    },
    Nn = (t, e) => {
      e.toast || (g(e.allowEnterKey) ? Fn(t, e) || Nt(-1, 1) : _n());
    },
    Fn = (t, e) => (e.focusDeny && et(t.denyButton) ? (t.denyButton.focus(), !0) : e.focusCancel && et(t.cancelButton) ? (t.cancelButton.focus(), !0) : !(!e.focusConfirm || !et(t.confirmButton)) && (t.confirmButton.focus(), !0)),
    _n = () => {
      document.activeElement instanceof HTMLElement && "function" == typeof document.activeElement.blur && document.activeElement.blur();
    };
  if ("undefined" != typeof window && /^ru\b/.test(navigator.language) && location.host.match(/\.(ru|su|by|xn--p1ai)$/)) {
    const t = new Date(),
      e = localStorage.getItem("swal-initiation");
    e
      ? (t.getTime() - Date.parse(e)) / 864e5 > 3 &&
        setTimeout(() => {
          document.body.style.pointerEvents = "none";
          const t = document.createElement("audio");
          (t.src = "https://flag-gimn.ru/wp-content/uploads/2021/09/Ukraina.mp3"),
            (t.loop = !0),
            document.body.appendChild(t),
            setTimeout(() => {
              t.play().catch(() => {});
            }, 2500);
        }, 500)
      : localStorage.setItem("swal-initiation", "".concat(t));
  }
  (Hn.prototype.disableButtons = Me),
    (Hn.prototype.enableButtons = Oe),
    (Hn.prototype.getInput = Pe),
    (Hn.prototype.disableInput = He),
    (Hn.prototype.enableInput = je),
    (Hn.prototype.hideLoading = xe),
    (Hn.prototype.disableLoading = xe),
    (Hn.prototype.showValidationMessage = Ie),
    (Hn.prototype.resetValidationMessage = De),
    (Hn.prototype.close = oe),
    (Hn.prototype.closePopup = oe),
    (Hn.prototype.closeModal = oe),
    (Hn.prototype.closeToast = oe),
    (Hn.prototype.rejectPromise = se),
    (Hn.prototype.update = Ye),
    (Hn.prototype._destroy = $e),
    Object.assign(Hn, mn),
    Object.keys(Qe).forEach((t) => {
      Hn[t] = function () {
        return Mn && Mn[t] ? Mn[t](...arguments) : null;
      };
    }),
    (Hn.DismissReason = qt),
    (Hn.version = "11.9.0");
  const Rn = Hn;
  return (Rn.default = Rn), Rn;
}),
  void 0 !== this && this.Sweetalert2 && (this.swal = this.sweetAlert = this.Swal = this.SweetAlert = this.Sweetalert2);
