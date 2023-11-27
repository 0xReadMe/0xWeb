!function(e) {
    function t(t) {
        for (var n, i, c = t[0], u = t[1], s = t[2], d = 0, p = []; d < c.length; d++)
            i = c[d],
            Object.prototype.hasOwnProperty.call(a, i) && a[i] && p.push(a[i][0]),
            a[i] = 0;
        for (n in u)
            Object.prototype.hasOwnProperty.call(u, n) && (e[n] = u[n]);
        for (l && l(t); p.length; )
            p.shift()();
        return o.push.apply(o, s || []),
        r()
    }
    function r() {
        for (var e, t = 0; t < o.length; t++) {
            for (var r = o[t], n = !0, c = 1; c < r.length; c++) {
                var u = r[c];
                0 !== a[u] && (n = !1)
            }
            n && (o.splice(t--, 1),
            e = i(i.s = r[0]))
        }
        return e
    }
    var n = {}
      , a = {
        41: 0,
        4: 0
    }
      , o = [];
    function i(t) {
        if (n[t])
            return n[t].exports;
        var r = n[t] = {
            i: t,
            l: !1,
            exports: {}
        };
        return e[t].call(r.exports, r, r.exports, i),
        r.l = !0,
        r.exports
    }
    i.e = function(e) {
        var t = []
          , r = a[e];
        if (0 !== r)
            if (r)
                t.push(r[2]);
            else {
                var n = new Promise(function(t, n) {
                    r = a[e] = [t, n]
                }
                );
                t.push(r[2] = n);
                var o, c = document.createElement("script");
                c.charset = "utf-8",
                c.timeout = 120,
                i.nc && c.setAttribute("nonce", i.nc),
                c.src = function(e) {
                    return i.p + "" + ({
                        3: "vendors~FilterGroupModal~FilterMobileModal~SetLocationModal",
                        4: "CityEditModal~PaymentsPickupAdressesModal",
                        5: "CityEditModal~SettingsDeliveryModal",
                        6: "vendors~FilterGroupModal~FilterMobileModal",
                        7: "AuthComponent",
                        8: "BlackListConfirmModal",
                        9: "BlackListModal",
                        10: "CategoryMobileContainer",
                        11: "CityEditModal",
                        12: "ClaimModal",
                        13: "ConfirmModal",
                        14: "DisablePromotionConfirmModal",
                        15: "EmailEditModal",
                        16: "EmptyListModal",
                        17: "FilterGroupModal",
                        18: "FilterMobileModal",
                        19: "InstallAppModalUtm",
                        20: "LoyaltySuccessModal",
                        21: "PaymentsConfirmModal",
                        22: "PaymentsCreateDisputModal",
                        23: "PaymentsPickupAdressesModal",
                        24: "PhoneEditModal",
                        25: "PopupAppBannerModal",
                        26: "ProductLimitFormModal",
                        27: "ProductPhoneModal",
                        28: "ProfileEditModal",
                        29: "SanitizeService",
                        30: "SetLocationModal",
                        31: "SettingsDeliveryModal",
                        32: "SubsListModal",
                        33: "UnsubscribeConfirmModal",
                        36: "imAdminModal",
                        37: "imChatRemoveConfirmModal",
                        47: "vendors~CategoryMobileContainer",
                        48: "vendors~ProductLimitFormModal",
                        49: "vendors~SetLocationModal",
                        50: "web-push-confirmation",
                        51: "web-push-provider"
                    }[e] || e) + "." + {
                        3: "2a8853",
                        4: "236b7e",
                        5: "572f47",
                        6: "ec4e41",
                        7: "900e32",
                        8: "63105d",
                        9: "5775cd",
                        10: "903bd3",
                        11: "80d007",
                        12: "c1a3df",
                        13: "0d4496",
                        14: "92c68a",
                        15: "fdb3b6",
                        16: "6da71e",
                        17: "f31f52",
                        18: "0ebd50",
                        19: "f2e333",
                        20: "f0a7c9",
                        21: "0113ab",
                        22: "cc3a61",
                        23: "925834",
                        24: "547656",
                        25: "22439b",
                        26: "30da39",
                        27: "f66703",
                        28: "a9ab6d",
                        29: "d0dcb1",
                        30: "e4aa2e",
                        31: "72a300",
                        32: "57726b",
                        33: "56f2b9",
                        36: "0c65cf",
                        37: "2ff8f3",
                        47: "e0730d",
                        48: "12cd23",
                        49: "aef2a6",
                        50: "864262",
                        51: "9ada31"
                    }[e] + ".js"
                }(e);
                var u = new Error;
                o = function(t) {
                    c.onerror = c.onload = null,
                    clearTimeout(s);
                    var r = a[e];
                    if (0 !== r) {
                        if (r) {
                            var n = t && ("load" === t.type ? "missing" : t.type)
                              , o = t && t.target && t.target.src;
                            u.message = "Loading chunk " + e + " failed.\n(" + n + ": " + o + ")",
                            u.name = "ChunkLoadError",
                            u.type = n,
                            u.request = o,
                            r[1](u)
                        }
                        a[e] = void 0
                    }
                }
                ;
                var s = setTimeout(function() {
                    o({
                        type: "timeout",
                        target: c
                    })
                }, 12e4);
                c.onerror = c.onload = o,
                document.head.appendChild(c)
            }
        return Promise.all(t)
    }
    ,
    i.m = e,
    i.c = n,
    i.d = function(e, t, r) {
        i.o(e, t) || Object.defineProperty(e, t, {
            enumerable: !0,
            get: r
        })
    }
    ,
    i.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }),
        Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }
    ,
    i.t = function(e, t) {
        if (1 & t && (e = i(e)),
        8 & t)
            return e;
        if (4 & t && "object" == typeof e && e && e.__esModule)
            return e;
        var r = Object.create(null);
        if (i.r(r),
        Object.defineProperty(r, "default", {
            enumerable: !0,
            value: e
        }),
        2 & t && "string" != typeof e)
            for (var n in e)
                i.d(r, n, function(t) {
                    return e[t]
                }
                .bind(null, n));
        return r
    }
    ,
    i.n = function(e) {
        var t = e && e.__esModule ? function() {
            return e.default
        }
        : function() {
            return e
        }
        ;
        return i.d(t, "a", t),
        t
    }
    ,
    i.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }
    ,
    i.p = "/build/",
    i.oe = function(e) {
        throw console.error(e),
        e
    }
    ;
    var c = window.webpackJsonp = window.webpackJsonp || []
      , u = c.push.bind(c);
    c.push = t,
    c = c.slice();
    for (var s = 0; s < c.length; s++)
        t(c[s]);
    var l = u;
    o.push([1918, 0, 1, 2]),
    r()
}({
    104: function(e, t, r) {
        e.exports = {
            form: "form__1P2Y3sX1",
            form_control: "form_control__3Uyg-pWq",
            form_group: "form_group__3-PlZQuP",
            label: "label__332nHo7g",
            group_container: "group_container__12wNwGP9",
            group_container__focus: "group_container__focus__3mj1cO0Q",
            group: "group__1v7ouE2m",
            address: "address__3uSvKlHU",
            address_map: "address_map__2kRHJ7WM",
            address_content: "address_content__3C31XaN8",
            place: "place__12NqXmUR",
            place_image: "place_image__12lje0Rp",
            place_content: "place_content__3JDivMsg",
            place_title: "place_title__TcsCqjam",
            place_desc: "place_desc__2KVF7dDE",
            data: "data__388YiuhZ",
            data__mobile: "data__mobile__2dfVb27p data__388YiuhZ",
            hint: "hint__2r7xW549",
            total: "total__I4PhWy7G",
            total_text: "total_text__1mD3ZJgn",
            total_price: "total_price__vlZUHSq2",
            hint_error: "hint_error__3xUUs9jF",
            input_error: "input_error__B7Uw6wLj",
            hint_error_another: "hint_error_another__3G6Ph2cJ hint_error__3xUUs9jF",
            boxberry_text: "boxberry_text__24q32W-A",
            hint_text: "hint_text__22iLmT10"
        }
    },
    1195: function(e, t, r) {
        e.exports = r.p + "images/bb_logo.586f56.svg"
    },
    162: function(e, t, r) {
        "use strict";
        var n = r(73)
          , a = r(325);
        t.a = {
            menuToggle: function(e) {
                return {
                    type: n.b.MENU_TOGGLE,
                    payload: {
                        value: e
                    }
                }
            },
            editModalShow: a.a
        }
    },
    166: function(e, t, r) {
        "use strict";
        var n = r(190)
          , a = r(97)
          , o = r(94)
          , i = r(32)
          , c = r(33)
          , u = Object(i.a)({
            route: "/favourites/delete",
            params: {
                method: "post"
            }
        }, c.a);
        t.a = {
            addToFavourites: n.b,
            addToFavouritesAfterAuth: n.a,
            removeFromFavourites: function(e) {
                return function(t, r) {
                    return new Promise(function(n) {
                        if (r().productReducer.flags.isOnFavouritesToggling)
                            return null;
                        t({
                            types: [a.a.REMOVE_START, a.a.REMOVE_FINISH, a.a.REMOVE_FAIL],
                            methodParams: u,
                            callAPI: function(t) {
                                return o.a.run(t, {
                                    productId: e
                                })
                            },
                            payload: {
                                id: e
                            },
                            then: n
                        })
                    }
                    )
                }
            }
        }
    },
    168: function(e, t, r) {
        e.exports = {
            product: "product__2oLb4nXl",
            product_image: "product_image__2AcYUpNV",
            product_price: "product_price__2IFwtrXu",
            product_title: "product_title__3jNOq_vZ",
            product_text: "product_text__CJfFik_i",
            product_content: "product_content__mI30-3Fr",
            product_inner: "product_inner__1ZrDwagy",
            product_owner: "product_owner__VUJH2ylJ",
            product_owner__order: "product_owner__order__1of37Y-y",
            product__order: "product__order__3dYX1fHW",
            product_discount_label: "product_discount_label__2QPhKO-m",
            product_discount_text: "product_discount_text__10Kq7Q3j",
            product_old_price: "product_old_price__3axip87u",
            product_real_price: "product_real_price__j_Bk3J3i"
        }
    },
    1918: function(e, t, r) {
        e.exports = r(2078)
    },
    196: function(e, t, r) {
        "use strict";
        r.d(t, "d", function() {
            return n
        }),
        r.d(t, "c", function() {
            return a
        }),
        r.d(t, "b", function() {
            return o
        }),
        r.d(t, "a", function() {
            return i
        });
        var n = "Договаривайтесь с продавцом о месте и времени передачи товара самостоятельно. Деньги за оплату товара продавец получит только после того, как вы подтвердите успешное получение товара. А в случае возникновения спорной ситуации, уладить возникшие разногласия поможет сервис «Безопасная сделка»."
          , a = "На указанный номер телефона будут приходить SMS сообщения о статусе доставки и оплаты. Другие пользователи не увидят этот номер телефона."
          , o = "При заполнении информации о ФИО допустимо использование букв, символов дефиса, точки и пробела"
          , i = "При заполнении информации о ФИО значение каждого поля может быть не более 25 символов"
    },
    197: function(e, t, r) {
        "use strict";
        r.d(t, "c", function() {
            return a
        }),
        r.d(t, "g", function() {
            return o
        }),
        r.d(t, "d", function() {
            return i
        }),
        r.d(t, "f", function() {
            return c
        }),
        r.d(t, "a", function() {
            return u
        }),
        r.d(t, "b", function() {
            return s
        }),
        r.d(t, "e", function() {
            return d
        }),
        r.d(t, "h", function() {
            return f
        });
        var n = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
          , a = "GOOGLE_MAPS_FAIL"
          , o = "GOOGLE_MAPS_READY"
          , i = "GOOGLE_MAPS_MAP_FAIL"
          , c = "GOOGLE_MAPS_MAP_READY"
          , u = "GOOGLE_MAPS_AUTOCOMPLETE_FAIL"
          , s = "GOOGLE_MAPS_AUTOCOMPLETE_READY"
          , l = "GOOGLE_MAPS_INIT_MARKERS"
          , d = "GOOGLE_MAPS_MAP_OPTIONS"
          , p = {
            isMapOnPage: !1,
            googleMapsReady: !1,
            autocompleteService: null,
            markers: {},
            markersArr: []
        };
        function f() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : p
              , t = arguments[1]
              , r = t.type
              , f = t.payload;
            switch (r) {
            case a:
            case o:
            case i:
            case c:
            case d:
            case u:
            case s:
                return n({}, e, f);
            case l:
                return n({}, e, {
                    markers: n({}, f.markers),
                    markersArr: Object.keys(n({}, f.markers))
                })
            }
            return e
        }
    },
    205: function(e, t, r) {
        e.exports = {
            root: "root__3ahLIWiH",
            suggest: "suggest__39HSdA70",
            suggest_list: "suggest_list__2FrKhm4H",
            suggest_item: "suggest_item__3YDeS0Jr",
            "suggest_list--focused": "suggest_list--focused__3sCWmA0o",
            hint_error: "hint_error__OX7cUQPh",
            input_error: "input_error__3eBcgfIa"
        }
    },
    2078: function(e, t, r) {
        "use strict";
        r.r(t);
        r(227);
        var n = r(0)
          , a = r.n(n)
          , o = r(39)
          , i = r.n(o)
          , c = r(135)
          , u = r(99)
          , s = r(631)
          , l = r(197)
          , d = r(251)
          , p = r(17)
          , f = r(522)
          , m = r(14)
          , v = r.n(m)
          , b = r(2)
          , y = r.n(b)
          , g = r(46)
          , _ = r(108)
          , h = r(4)
          , E = r(136)
          , O = r.n(E)
          , P = r(195)
          , j = r.n(P)
          , C = r(154)
          , k = r.n(C)
          , w = r(866)
          , R = r(167);
        function I() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "";
            if (e)
                return "-" + e + "%"
        }
        var S = r(168)
          , N = r.n(S)
          , A = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function M(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        var x = 100;
        function T(e) {
            var t = e.sendMessageEnabled
              , r = e.variant
              , n = e.product
              , o = n.id
              , i = n.name
              , c = n.mainImage
              , u = n.description
              , s = n.discount
              , l = n.showDescription
              , d = n.href
              , p = n.owner
              , f = e.order
              , m = f.priceAfterDiscount
              , b = f.discountPercent
              , y = e.order
              , g = e.userProps
              , _ = e.linksEnabled
              , E = e.useProductOwner
              , P = e.isMobile
              , C = e.userId || (p && E ? p.id : null)
              , S = O()(c, h.ImagePreset.SMALL_S)
              , T = "orderDetails" === r
              , L = void 0
              , q = void 0
              , F = void 0;
            T ? (L = P ? e.product.price : m,
            q = I(b),
            F = Boolean(b)) : (L = Object(R.a)(e.product),
            q = I(s),
            F = Boolean(s));
            var D = P ? F && !T : F;
            return a.a.createElement("div", {
                className: v()(N.a.product, M({}, N.a.product__order, T))
            }, S ? a.a.createElement(k.a, {
                href: _ && d ? d : null,
                className: v()(N.a.product_image, M({}, N.a["product_image--discounted"], F))
            }, F && a.a.createElement("span", {
                className: N.a.product_discount_label
            }, a.a.createElement("span", {
                className: N.a.product_discount_text
            }, q)), a.a.createElement("img", {
                src: S,
                alt: i,
                width: x,
                height: x
            })) : null, !C && !g.id || Object(h.getIsOrderFromChina)(y) ? null : a.a.createElement("div", {
                className: v()(N.a.product_owner, M({}, N.a.product_owner__order, T))
            }, a.a.createElement(w.a, A({
                id: C,
                label: "Продавец:",
                sendMessageLabel: "Написать продавцу",
                showRating: !0,
                showSendMessage: t,
                linksEnabled: _,
                productId: o
            }, g))), a.a.createElement("div", {
                className: N.a.product_content
            }, a.a.createElement("div", {
                className: N.a.product_inner
            }, a.a.createElement("div", {
                className: N.a.product_price
            }, a.a.createElement("span", {
                className: N.a.product_real_price
            }, a.a.createElement(j.a, {
                value: L,
                enabledFree: !0
            })), D && a.a.createElement("span", {
                className: N.a.product_old_price
            }, a.a.createElement(j.a, {
                value: e.product.price,
                enabledFree: !0
            }))), a.a.createElement("div", {
                className: N.a.product_title
            }, i), u && l ? a.a.createElement("div", {
                className: N.a.product_text
            }, u) : null)))
        }
        T.defaultProps = {
            order: {},
            userProps: {},
            sendMessageEnabled: !1,
            linksEnabled: !0,
            useProductOwner: !0,
            showDescription: !0
        },
        T.propTypes = {
            variant: y.a.string,
            product: y.a.shape({
                id: y.a.string.isRequired,
                name: y.a.string.isRequired,
                description: y.a.string,
                showDescription: y.a.bool,
                images: y.a.arrayOf(y.a.shape({
                    id: y.a.string.isRequired
                })),
                price: y.a.number.isRequired,
                owner: y.a.shape.isRequired,
                href: y.a.string.isRequired
            }).isRequired,
            order: y.a.shape({
                priceAfterDiscount: y.a.number.isRequired,
                discountPercent: y.a.number.isRequired
            }),
            userId: y.a.string,
            useProductOwner: y.a.bool,
            sendMessageEnabled: y.a.bool,
            linksEnabled: y.a.bool,
            userProps: y.a.object,
            isMobile: y.a.bool.isRequired
        };
        var L = T;
        var q = Object(p.connect)(function() {
            var e = Object(_.a)();
            return function(t, r) {
                return {
                    isMobile: Object(g.getIsMobile)(t),
                    product: e(t, r)
                }
            }
        })(L)
          , F = function(e) {
            return h.orion.order(e)
        }
          , D = r(545)
          , G = r.n(D)
          , B = r(34)
          , U = r.n(B);
        function K(e) {
            var t = e.order
              , r = t.id
              , n = t.number
              , o = t.product
              , i = t.seller
              , c = o ? o.id : null
              , u = i ? i.id : null;
            return a.a.createElement("div", null, c && u ? a.a.createElement(q, {
                id: c,
                userId: u,
                sendMessageEnabled: !1,
                showDescription: !1,
                linksEnabled: !1
            }) : null, a.a.createElement("div", {
                className: G.a.message
            }, a.a.createElement("div", {
                className: v()(G.a.message_title, G.a.message_title__success)
            }, a.a.createElement("i", {
                className: "icon icon--check_circle"
            }), "Ваш заказ ", n ? "№" + n : null, " оплачен"), a.a.createElement("p", {
                className: G.a.hint
            }, "Проверить статус сделки вы можете в своем профиле"), r ? a.a.createElement(U.a, {
                href: F(r)
            }, "Проверить статус сделки") : null))
        }
        K.defaultProps = {
            order: {}
        },
        K.propTypes = {
            order: y.a.shape({
                id: y.a.string,
                number: y.a.number,
                product: y.a.shape({
                    id: y.a.string.isRequired
                }),
                seller: y.a.shape({
                    id: y.a.string.isRequired
                })
            })
        };
        var H = K;
        var V = Object(p.connect)(function() {
            var e = Object(f.c)();
            return function(t) {
                var r = Object(f.b)(t);
                return {
                    order: e(t, {
                        id: r
                    })
                }
            }
        })(H)
          , Y = r(162)
          , z = r(166)
          , W = r(63)
          , J = r(196);
        function Z(e) {
            var t = e.isBoxberryAvailable
              , r = e.className;
            return a.a.createElement("div", {
                className: r
            }, "Нажимая кнопку «Перейти к оплате», вы соглашаетесь с заключением", " ", a.a.createElement("a", {
                href: "https://help.mail.ru/youlaapp-help/rules/safedeal/",
                target: "_blank",
                rel: "noopener noreferrer"
            }, "Договора купли-продажи"), " товаров с использованием Онлайн сервиса «Безопасная сделка»", t ? a.a.createElement("span", null, " ", "и c ", a.a.createElement("a", {
                href: "http://boxberry.ru/private_customers/documentation/",
                target: "_blank",
                rel: "noopener noreferrer"
            }, "Офертой Boxberry")) : null)
        }
        Z.propTypes = {
            isBoxberryAvailable: y.a.bool.isRequired,
            className: y.a.string
        };
        var X = r(379)
          , Q = r(222)
          , $ = r.n(Q)
          , ee = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function te(e) {
            var t = {
                href: e.href,
                target: e.target,
                className: e.className,
                title: e.title,
                disabled: e.disabled,
                onClick: e.onClick,
                onMouseEnter: e.onMouseEnter,
                onMouseMove: e.onMouseMove,
                style: e.style,
                tabIndex: e.tabIndex
            }
              , r = ee({
                to: e.to,
                activeClassName: e.activeClassName,
                activeStyle: e.activeStyle
            }, t);
            return e.replace ? a.a.createElement(c.a, ee({}, r, {
                onClick: function() {
                    return e.router.replace(e.to)
                }
            }), e.children) : e.to ? a.a.createElement(c.a, r, e.children) : a.a.createElement("a", t, e.children)
        }
        te.propTypes = {
            href: y.a.string,
            to: y.a.string,
            target: y.a.string,
            className: y.a.string,
            title: y.a.string,
            disabled: y.a.bool,
            onClick: y.a.func,
            onMouseEnter: y.a.func,
            onMouseMove: y.a.func,
            style: y.a.object,
            tabIndex: y.a.number,
            activeClassName: y.a.string,
            activeStyle: y.a.object,
            children: y.a.any,
            replace: y.a.bool,
            router: y.a.object
        };
        var re = r(338)
          , ne = r.n(re);
        var ae = Object(c.f)(te);
        function oe(e) {
            var t = e.title
              , r = e.active
              , n = e.price
              , o = e.link
              , i = e.period
              , c = v()(ne.a.tab, function(e, t, r) {
                return t in e ? Object.defineProperty(e, t, {
                    value: r,
                    enumerable: !0,
                    configurable: !0,
                    writable: !0
                }) : e[t] = r,
                e
            }({}, ne.a.tab__active, r));
            return a.a.createElement(ae, {
                className: c,
                to: o,
                replace: !0
            }, a.a.createElement("div", {
                className: ne.a.tab_title
            }, t), a.a.createElement("div", {
                className: ne.a.tab_price
            }, n ? a.a.createElement("div", null, $()(n), " ", a.a.createElement("span", {
                className: "rub"
            }, a.a.createElement("b", null, "₽"), a.a.createElement("i", {
                className: "rub__old"
            }, "руб."))) : "Бесплатно"), a.a.createElement("div", {
                className: ne.a.tab_desc
            }, i ? a.a.createElement("span", null, i) : a.a.createElement("span", null, "Договаривайтесь", " ", a.a.createElement("span", {
                className: "hidden-xs hidden-sm"
            }, "с продавцом "), "по телефону или в чате")))
        }
        oe.propTypes = {
            active: y.a.bool,
            title: y.a.string.isRequired,
            period: y.a.string,
            price: y.a.number.isRequired,
            link: y.a.string.isRequired
        };
        var ie = oe
          , ce = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function ue(e) {
            var t = e.activeTab
              , r = e.urlParams
              , n = (r = void 0 === r ? {} : r).id
              , o = e.deliveries;
            return a.a.createElement("div", {
                className: ne.a.tabs
            }, o.map(function(e, r) {
                var o = e.type === t
                  , i = h.orion.productBuy({
                    id: n,
                    deliveryType: X.b[e.type]
                });
                return a.a.createElement(ie, ce({
                    key: r
                }, e, {
                    active: o,
                    link: i
                }))
            }))
        }
        ue.propTypes = {
            activeTab: y.a.string.isRequired,
            urlParams: y.a.object.isRequired,
            deliveries: y.a.arrayOf(y.a.object).isRequired
        };
        var se = ue;
        var le = Object(p.connect)(function(e) {
            return {
                urlParams: e.routing.params,
                deliveries: Object(W.b)(e)
            }
        })(se)
          , de = r(36)
          , pe = r(1094)
          , fe = r(869)
          , me = r(70)
          , ve = r(72)
          , be = r(26)
          , ye = Object(be.createSelector)([W.k], function(e) {
            var t = e.deliveryTypeActive;
            return t ? h.EDeliveryType.isCarrierPickup(t) || h.EDeliveryType.isCarrierCourier(t) : null
        });
        var ge = r(100)
          , _e = r.n(ge)
          , he = r(667)
          , Ee = r(427);
        function Oe() {
            var e, t, r = this;
            return e = regeneratorRuntime.mark(function e(t, n) {
                var a, o;
                return regeneratorRuntime.wrap(function(e) {
                    for (; ; )
                        switch (e.prev = e.next) {
                        case 0:
                            if (n().googleMapsApi.googleMapsReady) {
                                e.next = 4;
                                break
                            }
                            return e.next = 4,
                            t(Object(Ee.a)());
                        case 4:
                            if (a = window.google) {
                                e.next = 7;
                                break
                            }
                            return e.abrupt("return", t({
                                type: l.a
                            }));
                        case 7:
                            return o = new a.maps.places.AutocompleteService,
                            e.abrupt("return", t({
                                type: l.b,
                                payload: {
                                    autocompleteService: o
                                }
                            }));
                        case 9:
                        case "end":
                            return e.stop()
                        }
                }, e, r)
            }),
            t = function() {
                var t = e.apply(this, arguments);
                return new Promise(function(e, r) {
                    return function n(a, o) {
                        try {
                            var i = t[a](o)
                              , c = i.value
                        } catch (e) {
                            return void r(e)
                        }
                        if (!i.done)
                            return Promise.resolve(c).then(function(e) {
                                n("next", e)
                            }, function(e) {
                                n("throw", e)
                            });
                        e(c)
                    }("next")
                }
                )
            }
            ,
            function(e, r) {
                return t.apply(this, arguments)
            }
        }
        var Pe = r(68)
          , je = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
          , Ce = "OK"
          , ke = "ZERO_RESULTS"
          , we = {
            types: ["geocode"],
            componentRestrictions: {
                country: "ru"
            }
        };
        function Re(e) {
            return function(t, r) {
                var n = r()
                  , a = n.googleMapsApi
                  , o = (a = void 0 === a ? {} : a).autocompleteService
                  , i = Object(W.k)(n).deliveryCity
                  , c = (void 0 === i ? {} : i).name;
                if (!o)
                    return !1;
                var u = e ? c + " " + e : " ";
                o.getPlacePredictions(je({
                    input: u
                }, we), function(e, r) {
                    r !== Ce && r !== ke || function(e, t, r) {
                        var n = e && e.filter(function(e) {
                            return e.structured_formatting.main_text.toLowerCase() !== t.toLowerCase()
                        });
                        r({
                            type: Pe.o,
                            payload: {
                                suggestions: n,
                                suggestsStatus: !0
                            }
                        })
                    }(e, c, t)
                })
            }
        }
        r(563);
        function Ie(e) {
            return function(t) {
                t({
                    type: Pe.n,
                    payload: {
                        addressFromSuggests: e
                    }
                })
            }
        }
        var Se = r(54)
          , Ne = r.n(Se)
          , Ae = r(265)
          , Me = r(515)
          , xe = r(205)
          , Te = r.n(xe)
          , Le = r(104)
          , qe = r.n(Le)
          , Fe = function() {
            function e(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    n.enumerable = n.enumerable || !1,
                    n.configurable = !0,
                    "value"in n && (n.writable = !0),
                    Object.defineProperty(e, n.key, n)
                }
            }
            return function(t, r, n) {
                return r && e(t.prototype, r),
                n && e(t, n),
                t
            }
        }();
        function De(e, t) {
            if (!e)
                throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return !t || "object" != typeof t && "function" != typeof t ? e : t
        }
        var Ge = Ae.a.getKeyCodes()
          , Be = function(e) {
            function t() {
                var e, r, n;
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t);
                for (var a = arguments.length, o = Array(a), i = 0; i < a; i++)
                    o[i] = arguments[i];
                return r = n = De(this, (e = t.__proto__ || Object.getPrototypeOf(t)).call.apply(e, [this].concat(o))),
                n.state = {
                    focus: !1,
                    suggestsInFocus: !1,
                    focusedSuggest: null
                },
                n.inputContainerRef = function(e) {
                    n.node = n.node || e
                }
                ,
                n.inputRef = function(e) {
                    n.input = n.input || e
                }
                ,
                n.handleKeyPress = function(e) {
                    var t = n.props.suggestions
                      , r = n.state.focusedSuggest
                      , a = t && t.length;
                    if (!a)
                        return !1;
                    if (e.keyCode === Ge.DOWN)
                        n.handleKeyDOWN(a, r);
                    else if (e.keyCode === Ge.UP)
                        n.handleKeyUP(a, r);
                    else if (e.keyCode === Ge.ENTER) {
                        var o = t[r].structured_formatting.main_text;
                        n.handleSuggestsClick(e, o, r),
                        n.input.focus()
                    }
                }
                ,
                n.handleKeyDOWN = function(e, t) {
                    t !== e - 1 ? n.setState({
                        suggestsInFocus: !0,
                        focusedSuggest: null === t ? 0 : t + 1
                    }) : n.setState({
                        suggestsInFocus: !0,
                        focusedSuggest: 0
                    })
                }
                ,
                n.handleKeyUP = function(e, t) {
                    0 !== t ? n.setState({
                        suggestsInFocus: !0,
                        focusedSuggest: null === t ? e - 1 : t - 1
                    }) : n.setState({
                        suggestsInFocus: !0,
                        focusedSuggest: e - 1
                    })
                }
                ,
                n.handleChange = function(e) {
                    var t = e.target.value
                      , r = n.props
                      , a = r.input.onChange
                      , o = r.addressFromSuggests;
                    return n.handleGetSuggestions(t),
                    o && n.props.suggestClick(!1),
                    a(t)
                }
                ,
                n.handleReset = function() {
                    return n.props.input.onChange(""),
                    n.handleGetSuggestions(""),
                    !1
                }
                ,
                n.handleFocus = function(e) {
                    n.handleInputState(e, !0)
                }
                ,
                n.handleBlur = function(e) {
                    n.handleInputState(e, !1)
                }
                ,
                n.handleInputState = Ne()(function(e, t) {
                    t ? n.props.input.onFocus() : (n.props.input.onBlur(),
                    e.persist()),
                    n.setState({
                        focus: t
                    })
                }, 150),
                n.handleSuggestsClick = function(e, t, r) {
                    var a = n.props
                      , o = a.input.onChange;
                    (0,
                    a.suggestClick)(!0, t),
                    o(t),
                    n.setState({
                        suggestsInFocus: !0,
                        focusedSuggest: r
                    }),
                    n.input.focus(),
                    n.handleInputState(null, !0)
                }
                ,
                n.handleGetSuggestions = Ne()(function(e) {
                    n.props.getSuggests(e)
                }, 300),
                De(n, r)
            }
            return function(e, t) {
                if ("function" != typeof t && null !== t)
                    throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        enumerable: !1,
                        writable: !0,
                        configurable: !0
                    }
                }),
                t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
            }(t, n["Component"]),
            Fe(t, [{
                key: "componentDidMount",
                value: function() {
                    this.props.initGoogleMapsAutocompleteService()
                }
            }, {
                key: "render",
                value: function() {
                    var e = this.props
                      , t = e.input
                      , r = (t = void 0 === t ? {} : t).value
                      , n = e.meta
                      , o = e.formGroupClassname
                      , i = e.formControlClassname
                      , c = e.suggestions
                      , u = e.addressFromSuggests
                      , s = this.state
                      , l = s.focus
                      , d = s.suggestsInFocus
                      , p = s.focusedSuggest
                      , f = !l && n.error
                      , m = v()(i, function(e, t, r) {
                        return t in e ? Object.defineProperty(e, t, {
                            value: r,
                            enumerable: !0,
                            configurable: !0,
                            writable: !0
                        }) : e[t] = r,
                        e
                    }({}, qe.a.input_error, f));
                    return a.a.createElement("div", {
                        className: Te.a.root
                    }, a.a.createElement("div", {
                        className: o,
                        onKeyDown: this.handleKeyPress,
                        ref: this.inputContainerRef
                    }, r ? a.a.createElement("button", {
                        type: "button",
                        title: "Сбросить",
                        className: "button button--icon button--delete",
                        onClick: this.handleReset
                    }, a.a.createElement("i", {
                        className: "icon icon--close-mini"
                    })) : null, a.a.createElement("input", {
                        type: "text",
                        className: m,
                        value: r,
                        placeholder: "Улица, дом",
                        onChange: this.handleChange,
                        onBlur: this.handleBlur,
                        onFocus: this.handleFocus,
                        ref: this.inputRef
                    }), l && r && c && !u ? a.a.createElement(Me.a, {
                        suggestions: c,
                        onClick: this.handleSuggestsClick,
                        suggestsInFocus: d,
                        focusedSuggest: p
                    }) : null), f ? a.a.createElement("div", {
                        className: qe.a.hint_error
                    }, f) : null)
                }
            }]),
            t
        }();
        Be.propTypes = {
            input: y.a.object.isRequired,
            meta: y.a.object.isRequired,
            formGroupClassname: y.a.string.isRequired,
            formControlClassname: y.a.string.isRequired,
            suggestions: y.a.array,
            suggestClick: y.a.func.isRequired,
            initGoogleMapsAutocompleteService: y.a.func.isRequired,
            getSuggests: y.a.func.isRequired,
            addressFromSuggests: y.a.bool.isRequired
        };
        var Ue = Be;
        var Ke = Object(p.connect)(function(e) {
            var t = e.form[me.a].addressFromSuggests;
            return {
                suggestions: Object(W.k)(e).suggestions,
                addressFromSuggests: t
            }
        }, {
            initGoogleMapsAutocompleteService: Oe,
            loadGoogleMaps: Ee.a,
            getSuggests: Re,
            suggestClick: Ie
        })(Ue)
          , He = r(30)
          , Ve = r(53)
          , Ye = r(21);
        function ze(e, t) {
            var r = t.id;
            return e.entities.pickupPoints[r]
        }
        var We = r(15)
          , Je = 180
          , Ze = "ru"
          , Xe = 4
          , Qe = 16
          , $e = We.a.getParams().gmapsKey
          , et = We.a.getImagePin()
          , tt = "https://maps.googleapis.com/maps/api/staticmap?";
        $e && (tt += "key=" + $e + "&");
        var rt = r(8)
          , nt = r(435)
          , at = function() {
            function e(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    n.enumerable = n.enumerable || !1,
                    n.configurable = !0,
                    "value"in n && (n.writable = !0),
                    Object.defineProperty(e, n.key, n)
                }
            }
            return function(t, r, n) {
                return r && e(t.prototype, r),
                n && e(t, n),
                t
            }
        }();
        var ot = function(e) {
            function t() {
                return function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                function(e, t) {
                    if (!e)
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    return !t || "object" != typeof t && "function" != typeof t ? e : t
                }(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments))
            }
            return function(e, t) {
                if ("function" != typeof t && null !== t)
                    throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        enumerable: !1,
                        writable: !0,
                        configurable: !0
                    }
                }),
                t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
            }(t, n["Component"]),
            at(t, [{
                key: "render",
                value: function() {
                    var e = this.props
                      , t = e.pickupPoint
                      , r = t.name
                      , n = t.phone
                      , o = t.images
                      , i = t.workTime
                      , c = t.location.description
                      , u = e.mapImage
                      , s = e.count
                      , l = e.showChangeButton
                      , d = e.onClick
                      , p = e.children
                      , f = Object(nt.a)(o)
                      , m = void 0;
                    return f && (m = O()(f, h.ImagePreset.MIDDLE_S)),
                    a.a.createElement("div", null, a.a.createElement("label", {
                        className: qe.a.label
                    }, "Пункт самовывоза"), p, a.a.createElement("div", {
                        className: qe.a.address
                    }, a.a.createElement("div", {
                        className: v()(qe.a.address_map),
                        onClick: d
                    }, a.a.createElement("img", {
                        src: u,
                        width: 180,
                        height: 180,
                        alt: c
                    })), a.a.createElement("div", {
                        className: qe.a.address_content
                    }, a.a.createElement("div", {
                        className: qe.a.place
                    }, m ? a.a.createElement("div", {
                        className: qe.a.place_image
                    }, a.a.createElement("img", {
                        src: m,
                        width: 84,
                        height: 60,
                        alt: c
                    })) : null, a.a.createElement("div", {
                        className: qe.a.place_content
                    }, a.a.createElement("div", {
                        className: qe.a.place_title
                    }, r), a.a.createElement("div", {
                        className: qe.a.place_desc
                    }, c), a.a.createElement("ul", {
                        className: qe.a.data__mobile
                    }, a.a.createElement("li", null, Object(rt.formatPhoneHuman)(n)), a.a.createElement("li", null, i)))), a.a.createElement("ul", {
                        className: qe.a.data
                    }, a.a.createElement("li", null, Object(rt.formatPhoneHuman)(n)), a.a.createElement("li", null, i)), l && s ? a.a.createElement(U.a, {
                        flat: !0,
                        small: !0,
                        onClick: d
                    }, "Выбрать другой пункт из ", s) : null)))
                }
            }]),
            t
        }();
        ot.defaultProps = {
            showChangeButton: !1
        },
        ot.propTypes = {
            showChangeButton: y.a.bool,
            mapImage: y.a.string.isRequired,
            count: y.a.number,
            pickupPoint: y.a.shape({
                images: y.a.arrayOf(y.a.shape({
                    url: y.a.string
                })),
                name: y.a.string.isRequired,
                phone: y.a.string.isRequired,
                workTime: y.a.string.isRequired,
                location: y.a.shape({
                    description: y.a.string.isRequired
                }).isRequired
            }).isRequired,
            onClick: y.a.func,
            children: y.a.node
        };
        var it = ot;
        var ct = Object(p.connect)(function() {
            var e = Object(be.createSelector)([ze, Ye.i], function(e, t) {
                return e ? Object(He.denormalize)(e, Ve.n, t) : null
            });
            return function(t, r) {
                var n = e(t, r);
                return {
                    pickupPoint: n,
                    mapImage: function() {
                        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {}
                          , t = e.x
                          , r = void 0 === t ? Je : t
                          , n = e.y
                          , a = void 0 === n ? Je : n
                          , o = e.language
                          , i = void 0 === o ? Ze : o
                          , c = e.markers
                          , u = void 0 === c ? [{
                            lat: 55.747553,
                            lng: 37.6185533
                        }] : c
                          , s = tt + "size=" + r + "x" + a + "&language=" + i + "&scale=" + Xe + "&zoom=" + Qe;
                        return u.length > 0 && u.map(function(e) {
                            return s = s + "&markers=icon:" + et + "|" + e.lat + "," + e.lng,
                            e
                        }),
                        s
                    }({
                        markers: [n.location]
                    })
                }
            }
        })(it)
          , ut = r(516)
          , st = r(426)
          , lt = r(1195)
          , dt = r.n(lt)
          , pt = r(11)
          , ft = function() {
            function e(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    n.enumerable = n.enumerable || !1,
                    n.configurable = !0,
                    "value"in n && (n.writable = !0),
                    Object.defineProperty(e, n.key, n)
                }
            }
            return function(t, r, n) {
                return r && e(t.prototype, r),
                n && e(t, n),
                t
            }
        }();
        function mt(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        function vt(e, t) {
            if (!e)
                throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return !t || "object" != typeof t && "function" != typeof t ? e : t
        }
        var bt = function(e) {
            function t() {
                var e, r, n;
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t);
                for (var a = arguments.length, o = Array(a), i = 0; i < a; i++)
                    o[i] = arguments[i];
                return r = n = vt(this, (e = t.__proto__ || Object.getPrototypeOf(t)).call.apply(e, [this].concat(o))),
                n.handlePhoneInputReset = function() {
                    n.props.changeFormInput(n.props.form, ve.f, "+7")
                }
                ,
                n.handleAddressRef = function(e) {
                    n[ve.a] = e
                }
                ,
                n.handlePersonalRef = function(e) {
                    ve.h.map(function(t) {
                        return n[t.name] = e,
                        t
                    })
                }
                ,
                n.handlePhoneRef = function(e) {
                    n[ve.f] = e
                }
                ,
                n.handleOpenPickupAddressesModal = function() {
                    n.props.openPickupAddressesModal(st.a)
                }
                ,
                vt(n, r)
            }
            return function(e, t) {
                if ("function" != typeof t && null !== t)
                    throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        enumerable: !1,
                        writable: !0,
                        configurable: !0
                    }
                }),
                t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
            }(t, n["Component"]),
            ft(t, [{
                key: "componentWillUpdate",
                value: function(e) {
                    var t = e.submitErrors;
                    !this.props.submitErrors && t && this[Object.keys(t)[0]].scrollIntoView()
                }
            }, {
                key: "render",
                value: function() {
                    var e = this.props
                      , t = e.flags
                      , r = t.needPickUpAdress
                      , n = t.needLocationInput
                      , o = e.fieldValues
                      , i = e.fieldErrors
                      , c = e.form
                      , u = e.changeFormInput
                      , s = e.pickupPointId
                      , l = e.pickupPointsCount
                      , d = e.isBoxberryAvailable
                      , p = v()("row", qe.a.row)
                      , f = v()("from_group", qe.a.form_group)
                      , m = v()("form_control", qe.a.form_control)
                      , b = this.handlePersonErrors(i)
                      , y = i && i[ve.f]
                      , g = v()(m, mt({}, qe.a.input_error, y));
                    return a.a.createElement("div", {
                        className: qe.a.form
                    }, a.a.createElement("form", null, r && s ? a.a.createElement(ct, {
                        id: s,
                        count: l,
                        onClick: this.handleOpenPickupAddressesModal,
                        showChangeButton: !0
                    }) : null, n ? a.a.createElement("div", null, a.a.createElement("label", {
                        className: qe.a.label
                    }, "Адрес доставки"), a.a.createElement("div", {
                        className: p
                    }, a.a.createElement("div", {
                        className: "col-md-8",
                        ref: this.handleAddressRef
                    }, a.a.createElement(he.a, {
                        type: "text",
                        name: ve.a,
                        component: Ke,
                        className: m,
                        formGroupClassname: f,
                        formControlClassname: m
                    })), a.a.createElement("div", {
                        className: "col-md-4"
                    }, a.a.createElement("div", {
                        className: f
                    }, a.a.createElement(he.a, {
                        type: "text",
                        name: ve.b,
                        component: "input",
                        className: m,
                        placeholder: "Квартира/Офис"
                    }))))) : null, a.a.createElement("label", {
                        className: qe.a.label
                    }, "Данные покупателя (для курьера и/или сообщений о статусе заказа)"), a.a.createElement("div", {
                        className: p,
                        style: {
                            position: "relative"
                        },
                        ref: this.handlePersonalRef
                    }, ve.h.map(function(e, t) {
                        var r = v()(m, mt({}, qe.a.input_error, i && i[e.name]));
                        return a.a.createElement("div", {
                            className: "col-md-4",
                            key: t
                        }, a.a.createElement("div", {
                            className: f
                        }, o[e.name] ? a.a.createElement("button", {
                            onClick: function() {
                                return u(c, e.name, "")
                            },
                            type: "button",
                            title: "Сбросить",
                            className: "button button--icon button--delete"
                        }, a.a.createElement("i", {
                            className: "icon icon--close-mini"
                        })) : null, a.a.createElement(he.a, {
                            name: e.name,
                            component: "input",
                            type: e.type,
                            className: r,
                            placeholder: e.placeholder,
                            maxLength: 25
                        })))
                    }), b ? a.a.createElement("div", {
                        className: qe.a.hint_error
                    }, b) : null), a.a.createElement("div", {
                        className: p,
                        ref: this.handlePhoneRef
                    }, a.a.createElement("div", {
                        className: "col-md-4"
                    }, a.a.createElement("div", {
                        className: f
                    }, o.phone ? a.a.createElement("button", {
                        type: "button",
                        title: "Сбросить",
                        className: "button button--icon button--delete",
                        onClick: this.handlePhoneInputReset
                    }, a.a.createElement("i", {
                        className: "icon icon--close-mini"
                    })) : null, a.a.createElement(ut.a, {
                        name: ve.f,
                        type: "tel",
                        inputClassName: g,
                        placeholder: "Телефон",
                        defaultValue: "+7"
                    })))), a.a.createElement("p", {
                        className: qe.a.hint
                    }, J.c), a.a.createElement("div", {
                        className: qe.a.boxberry_text
                    }, a.a.createElement("a", {
                        href: "http://boxberry.ru/",
                        target: "_blank",
                        rel: "noopener noreferrer"
                    }, a.a.createElement("img", {
                        src: dt.a,
                        alt: "Boxberry",
                        width: 88,
                        height: 24
                    })), "Доставка осуществляется через службу Boxberry."), pt.isTouchDevice ? a.a.createElement(Z, {
                        className: qe.a.hint_text,
                        isBoxberryAvailable: d
                    }) : null))
                }
            }, {
                key: "handlePersonErrors",
                value: function(e) {
                    if (!e)
                        return !1;
                    var t = _e()(ve.h, function(t) {
                        return e[t.name]
                    })
                      , r = t && e[t.name];
                    if (!r)
                        return !1;
                    switch (r) {
                    case J.a:
                    case J.b:
                        return r
                    }
                    return "Фамилия, имя и отчество покупателя обязательны для заполнения"
                }
            }]),
            t
        }();
        bt.defaultProps = {
            fieldValues: {},
            pickupPointsCount: 0
        },
        bt.propTypes = {
            flags: y.a.object,
            fieldValues: y.a.object,
            changeFormInput: y.a.func.isRequired,
            openPickupAddressesModal: y.a.func.isRequired,
            fieldErrors: y.a.object,
            form: y.a.string,
            submitErrors: y.a.object,
            pickupPointId: y.a.string,
            pickupPointsCount: y.a.number,
            isBoxberryAvailable: y.a.bool.isRequired
        };
        var yt = bt
          , gt = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        var _t = {
            form: me.a,
            destroyOnUnmount: !1,
            validate: function(e, t) {
                var r = function(e, t, r) {
                    var n = r.flags
                      , a = n.addressFromSuggests
                      , o = n.suggestsStatus;
                    return !!e[ve.a] && (t !== ve.a && (!!o && (!a && "Выберите адрес из выпадающего списка")))
                }(e, t.fieldActive, t);
                return r ? function(e, t, r) {
                    return t in e ? Object.defineProperty(e, t, {
                        value: r,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0
                    }) : e[t] = r,
                    e
                }({}, ve.a, r) : {}
            },
            shouldValidate: function(e) {
                var t = e.props.fields
                  , r = (t = void 0 === t ? {} : t)[ve.a];
                return !!(r = void 0 === r ? {} : r).active
            }
        }
          , ht = Object(p.connect)(function(e) {
            var t = e.form[me.a]
              , r = (t = void 0 === t ? {} : t).values
              , n = t.addressFromSuggests
              , a = t.addressValid
              , o = t.fields
              , i = t.syncErrors
              , c = t.submitErrors
              , u = t.active
              , s = Object(W.k)(e)
              , l = s.deliveryTypeActive
              , d = s.deliveryCity
              , p = s.pickupPointIdPersisted
              , f = s.suggestsStatus
              , m = Object(W.p)(e)
              , v = Object(W.j)(e)
              , b = p || v;
            return {
                flags: {
                    needForm: l !== h.EDeliveryType.SELF_PICKUP,
                    needPickUpAdress: h.EDeliveryType.isCarrierPickup(l),
                    needLocationInput: h.EDeliveryType.isCarrierCourier(l),
                    needCommentInput: h.EDeliveryType.isCarrierCourier(l),
                    addressFromSuggests: n,
                    addressValid: a,
                    suggestsStatus: f
                },
                fields: o,
                syncErrors: i,
                active: u,
                values: r,
                fieldValues: r,
                fieldErrors: gt({}, i || {}, c || {}),
                submitErrors: c,
                deliveryCity: d,
                pickupPointId: b,
                pickupPointsCount: m.length,
                isBoxberryAvailable: ye(e)
            }
        }, {
            changeFormInput: de.change,
            openPickupAddressesModal: fe.c
        })(Object(pe.a)(_t)(yt))
          , Et = r(559)
          , Ot = r(339)
          , Pt = r.n(Ot)
          , jt = "Оплачивать на&nbsp;Юле безопасно";
        function Ct(e) {
            var t = e.isBoxberryAvailable
              , r = e.price
              , n = e.delivery
              , o = e.formSubmit;
            return a.a.createElement("div", {
                className: Pt.a.summary
            }, a.a.createElement("div", {
                className: Pt.a.summary_header
            }, a.a.createElement("div", {
                className: Pt.a.summary_price
            }, a.a.createElement(j.a, {
                value: r + n
            })), n ? a.a.createElement("div", {
                className: Pt.a.summary_delivery
            }, "С учетом стоимости доставки ", a.a.createElement(j.a, {
                value: n
            })) : null), a.a.createElement("div", {
                className: "fixed_buttons fixed_buttons--single"
            }, a.a.createElement("div", {
                className: Pt.a.summary_total
            }, "Итого", a.a.createElement("div", {
                className: Pt.a.summary_total_value
            }, a.a.createElement(j.a, {
                value: r + n
            }))), a.a.createElement("div", {
                className: "button_container"
            }, a.a.createElement(U.a, {
                onClick: o,
                success: !0,
                block: !0
            }, "Перейти к оплате"))), a.a.createElement("div", {
                className: Pt.a.safely_text
            }, a.a.createElement("div", {
                className: "status_badge__icon status_badge__icon--deal"
            }), a.a.createElement("span", {
                dangerouslySetInnerHTML: {
                    __html: jt
                }
            })), a.a.createElement(Z, {
                className: "hint",
                isBoxberryAvailable: t
            }))
        }
        Ct.propTypes = {
            isBoxberryAvailable: y.a.bool,
            price: y.a.number.isRequired,
            delivery: y.a.number.isRequired,
            formSubmit: y.a.func.isRequired
        };
        var kt = Ct;
        var wt = Object(p.connect)(function(e) {
            var t = Object(W.m)(e);
            return {
                price: Object(R.a)(t),
                delivery: Object(W.a)(e),
                isBoxberryAvailable: ye(e)
            }
        }, {
            formSubmit: Et.b
        })(kt)
          , Rt = r(887)
          , It = r(221)
          , St = r.n(It);
        function Nt(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        function At(e) {
            var t, r = e.location, n = e.openCityEditModal, o = e.deliveryAvailable, i = e.isLocationEmpty, c = v()("status_badge__icon status_badge__icon--delivery", St.a.status_icon), u = v()((Nt(t = {}, St.a.hint, i),
            Nt(t, St.a.hint_error, !i),
            t)), s = i ? "Для расчета стоимости доставки уточните, где вы хотите получить товар." : "К сожалению, доставки в этом городе нет.", l = !o && i ? "Выбрать город" : "Изменить город";
            return a.a.createElement("div", {
                className: St.a.panel
            }, a.a.createElement("div", {
                className: St.a.panel_icon
            }, a.a.createElement("div", {
                className: c
            })), a.a.createElement("div", {
                className: St.a.panel_button
            }, a.a.createElement(U.a, {
                flat: !0,
                small: !0,
                className: "hidden-xs",
                onClick: n
            }, l)), a.a.createElement("div", {
                className: St.a.panel_content
            }, r ? a.a.createElement("div", {
                className: St.a.text
            }, "Выбрана доставка по городу ", a.a.createElement("b", null, r), ".") : a.a.createElement("div", {
                className: St.a.text_error
            }, "Выберите город доставки."), o ? a.a.createElement("div", {
                className: St.a.hint
            }, "Стоимость доставки в разные города может различаться.") : a.a.createElement("div", {
                className: u
            }, s)), a.a.createElement("div", {
                className: St.a.panel_button
            }, a.a.createElement(U.a, {
                flat: !0,
                small: !0,
                className: "visible-xs",
                onClick: n
            }, l)))
        }
        At.propTypes = {
            location: y.a.string,
            openCityEditModal: y.a.func.isRequired,
            deliveryAvailable: y.a.bool.isRequired,
            isLocationEmpty: y.a.bool.isRequired
        };
        var Mt = At;
        var xt = Object(p.connect)(function(e) {
            var t = Object(W.k)(e).deliveryCity;
            return {
                location: (t = void 0 === t ? {} : t).name,
                deliveryAvailable: Object(W.i)(e),
                isLocationEmpty: Object(Ye.k)(e)
            }
        }, {
            openCityEditModal: Rt.b
        })(Mt)
          , Tt = r(546)
          , Lt = r.n(Tt);
        function qt(e) {
            var t = e.formConfig
              , r = e.flags
              , n = e.activeTab
              , o = e.isDeliveryAvailable
              , i = e.productId
              , c = v()("hint", Lt.a.payhint);
            return a.a.createElement("div", null, a.a.createElement(q, {
                id: i,
                sendMessageEnabled: !1,
                linksEnabled: !1,
                showDescription: !1
            }), a.a.createElement("div", {
                className: Lt.a.container
            }, a.a.createElement(wt, null), a.a.createElement("div", {
                className: Lt.a.block
            }, o ? a.a.createElement(xt, null) : null, a.a.createElement(le, {
                activeTab: n
            }), r.needForm ? a.a.createElement(ht, t) : a.a.createElement(a.a.Fragment, null, a.a.createElement("p", {
                className: Lt.a.hint
            }, J.d), a.a.createElement(Z, {
                className: c
            })))))
        }
        qt.propTypes = {
            formConfig: y.a.object,
            flags: y.a.object,
            activeTab: y.a.string.isRequired,
            isDeliveryAvailable: y.a.bool.isRequired,
            productId: y.a.string.isRequired
        };
        var Ft = qt;
        var Dt = Object(p.connect)(function(e) {
            var t = Object(W.k)(e).deliveryTypeActive;
            return {
                activeTab: t,
                formConfig: {
                    initialValues: Object(W.l)(e)
                },
                productId: Object(W.n)(e),
                flags: {
                    needForm: t !== h.EDeliveryType.SELF_PICKUP
                },
                isDeliveryAvailable: Object(W.h)(e)
            }
        }, {})(Ft)
          , Gt = r(847)
          , Bt = r.n(Gt);
        function Ut(e) {
            var t = e.title;
            return a.a.createElement("div", null, a.a.createElement("h1", {
                className: Bt.a.title
            }, t), a.a.createElement("div", {
                className: Bt.a.container
            }, a.a.createElement(Dt, null)))
        }
        Ut.propTypes = {
            title: y.a.string.isRequired
        };
        var Kt = Ut;
        var Ht = Object(p.connect)(function(e) {
            var t = e.twigReducer.routeName;
            return {
                deliveryTypes: e.entities.deliveryTypes,
                deliveryTypeIds: Object(W.k)(e).deliveryTypeIds,
                title: "Оформление и оплата",
                routeName: t
            }
        })(Kt)
          , Vt = r(130)
          , Yt = r(79)
          , zt = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
          , Wt = new Vt.a({
            actions: zt({}, Y.a, z.a),
            reducers: {
                routing: s.a,
                googleMapsApi: l.h,
                payments: d.d
            }
        }).appStore
          , Jt = Wt.getState().twigReducer.routeName;
        function Zt(e) {
            return Wt.dispatch(Object(s.b)(e.params))
        }
        var Xt = document.getElementById("payments")
          , Qt = document.querySelector(".js-counter-orders-buyer")
          , $t = document.querySelector(".js-counter-orders-seller")
          , er = Qt && Qt.querySelector(".inner")
          , tr = $t && $t.querySelector(".inner");
        Wt.subscribe(function() {
            var e = Wt.getState()
              , t = Object(u.getOrdersBuyerCount)(e)
              , r = Object(u.getOrdersSellerCount)(e);
            er && void 0 !== t && (er.innerHTML = t,
            Qt.classList.toggle("hide", !t)),
            tr && void 0 !== r && (tr.innerHTML = r,
            $t.classList.toggle("hide", !r))
        }),
        "scrollRestoration"in history && (history.scrollRestoration = "manual"),
        i.a.render(a.a.createElement(Yt.b, {
            store: Wt
        }, function() {
            switch (Jt) {
            case "order_success":
                return a.a.createElement(V, null);
            default:
                return c.e.listen(Object(s.c)(Wt)),
                a.a.createElement(c.d, {
                    history: c.e
                }, a.a.createElement(c.b, {
                    from: "/:city/:category/:subcategory/:name-:id/buy(/:type)",
                    to: "/product/:id/buy(/:type)"
                }), a.a.createElement(c.c, {
                    path: "/product/:id/buy(/:type)",
                    component: Ht,
                    name: "createPayment",
                    onEnter: Zt,
                    onChange: Zt
                }))
            }
        }()), Xt)
    },
    221: function(e, t, r) {
        e.exports = {
            panel: "panel__3B1d-ak5",
            panel_icon: "panel_icon__1HmxOezY",
            panel_content: "panel_content__VGeorc1g",
            panel_button: "panel_button__2vr4fIVO",
            status_icon: "status_icon__3QzFN2ZZ",
            hint: "hint__aMasvQSz",
            hint_error: "hint_error__j7wj4nAg hint__aMasvQSz",
            text: "text__3Wt10VPX",
            text_error: "text_error__1P9YZeV5 text__3Wt10VPX",
            "text-red": "text-red__3KYBKkqG"
        }
    },
    226: function(e, t, r) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        }),
        t.default = function(e, t) {
            if (!(0,
            o.default)(e) && !e)
                return "";
            var r = e.replace(/[^\d]/g, "");
            if (!t || e.length > t.length) {
                if (1 === r.length)
                    return "8" === r[0] || "7" === r[0] ? "+7" : "+7 (" + r;
                if (r.length > 10)
                    return "+" + r.slice(0, 11)
            } else if (e.length < 2)
                return "+7";
            return "+" + r
        }
        ;
        var n, a = r(132), o = (n = a) && n.__esModule ? n : {
            default: n
        }
    },
    251: function(e, t, r) {
        "use strict";
        r.d(t, "b", function() {
            return u
        }),
        r.d(t, "c", function() {
            return s
        }),
        r.d(t, "a", function() {
            return l
        });
        var n = r(15)
          , a = r(68)
          , o = r(160)
          , i = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function c(e) {
            if (Array.isArray(e)) {
                for (var t = 0, r = Array(e.length); t < e.length; t++)
                    r[t] = e[t];
                return r
            }
            return Array.from(e)
        }
        var u = "PAYMENTS_GET_CITY_BY_COORDS_START"
          , s = "PAYMENTS_GET_CITY_BY_COORDS_SUCCESS"
          , l = "PAYMENTS_GET_CITY_BY_COORDS_FAIL"
          , d = []
          , p = void 0
          , f = void 0
          , m = void 0
          , v = void 0
          , b = void 0
          , y = void 0
          , g = n.a.getTemplateParams()
          , _ = g.orders
          , h = g.orderId
          , E = g.transferId
          , O = g.pickupPointIds
          , P = g.disputeId
          , j = g.isSeller
          , C = g.isBuyer
          , k = g.newCardBound;
        _ && (d = d.concat(_)),
        h && (p = h),
        P && (m = P),
        E && (f = E),
        j && (v = j),
        C && (b = C),
        k && (y = k);
        var w = {
            orders: d,
            orderId: p,
            disputeId: m,
            transferId: f,
            pickupPointIds: O,
            isSeller: v,
            isBuyer: b,
            newCardBound: y
        };
        t.d = function() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : w
              , t = arguments[1]
              , r = t.payload
              , n = t.type;
            switch (n) {
            case s:
                return i({}, e, {
                    cityInfo: i({}, r)
                });
            case a.e:
                return i({}, e, {
                    pickupPointIds: [].concat(c(r.pickupPointIds)),
                    orderCreate: Object(a.p)(e.orderCreate, t)
                });
            case o.j:
                return i({}, e, {
                    orders: [].concat(c(r.orders)),
                    requests: Object(o.F)(e.requests, t)
                });
            case a.a:
            case a.k:
                return i({}, e, r);
            case a.l:
                return i({}, e, r, {
                    orderCreate: Object(a.p)(e.orderCreate, t)
                })
            }
            return i({}, e, {
                orderCreate: Object(a.p)(e.orderCreate, t),
                requests: Object(o.F)(e.requests, t)
            })
        }
    },
    338: function(e, t, r) {
        e.exports = {
            tabs: "tabs__2t54pDtg",
            tab: "tab__13DKWU-D",
            tab__active: "tab__active__3xXMJJRt",
            tab_title: "tab_title__3JjUypIZ",
            tab_price: "tab_price__3c3Qa3nF",
            tab_desc: "tab_desc__2Lf7A_79"
        }
    },
    339: function(e, t, r) {
        e.exports = {
            summary: "summary__2TIRymkY",
            summary_price: "summary_price__1HT5R9_P",
            summary_delivery: "summary_delivery__1bPMd9hw",
            summary_header: "summary_header__bJmC15X9",
            safely_text: "safely_text__392qqBrF",
            summary_total: "summary_total__3aEKbkJu",
            summary_total_value: "summary_total_value__nRhP7XkA"
        }
    },
    340: function(e, t, r) {
        "use strict";
        r.d(t, "e", function() {
            return n
        }),
        r.d(t, "c", function() {
            return a
        }),
        r.d(t, "d", function() {
            return o
        }),
        r.d(t, "b", function() {
            return i
        }),
        r.d(t, "a", function() {
            return c
        });
        var n = "disputResolution"
          , a = "disputCompensation"
          , o = "disputReason"
          , i = "disputComment"
          , c = ["disputAttachment_1", "disputAttachment_2", "disputAttachment_3", "disputAttachment_4"]
    },
    346: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return o
        });
        var n = "premise"
          , a = "street_address";
        function o(e) {
            var t = e[0];
            if (!t)
                return !1;
            var r = t || {}
              , o = r.formatted_address
              , i = r.types
              , c = void 0 === i ? [] : i;
            return (c.indexOf(a) >= 0 || c.indexOf(n) >= 0) && o
        }
    },
    390: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return n
        }),
        r.d(t, "b", function() {
            return a
        });
        var n = "buyer"
          , a = "seller"
    },
    395: function(e, t, r) {
        "use strict";
        r.d(t, "d", function() {
            return n
        }),
        r.d(t, "b", function() {
            return a
        }),
        r.d(t, "c", function() {
            return o
        }),
        r.d(t, "a", function() {
            return i
        });
        var n = "text"
          , a = "radio"
          , o = "textarea"
          , i = "images"
    },
    426: function(e, t, r) {
        "use strict";
        r.d(t, "c", function() {
            return n
        }),
        r.d(t, "a", function() {
            return a
        }),
        r.d(t, "b", function() {
            return o
        });
        var n = "pickupAddressModalViewVariant"
          , a = "pickupAddressModalChooseVariant"
          , o = "pickupAddressModalCurrentVariant"
    },
    427: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return c
        });
        var n = r(8)
          , a = r(197)
          , o = r(15).a.getParams().gmapsKey || null
          , i = "https://maps.googleapis.com/maps/api/js?&libraries=places";
        function c() {
            return function(e) {
                return new Promise(function(t, r) {
                    return Object(n.addScriptTag)(i, function() {
                        return t(),
                        e({
                            type: a.g,
                            payload: {
                                googleMapsReady: !0
                            }
                        })
                    }, function() {
                        return r(new Error),
                        e({
                            type: a.c
                        })
                    })
                }
                )
            }
        }
        o && (i += "&key=" + o)
    },
    474: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return a
        });
        var n = /^\+?7[\d]{10}$/;
        function a(e) {
            if (e = String(e),
            !n.test(e))
                return "Неверный номер телефона. Укажите телефон в формате +7 (999) 999-99-99."
        }
    },
    479: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return n
        }),
        r.d(t, "b", function() {
            return a
        });
        var n = "CITY_CHANGE_PAYMENT_VARIANT"
          , a = "CITY_CHANGE_SETTINGS_DELIVERY_VARIANT"
    },
    515: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return d
        });
        var n = r(0)
          , a = r.n(n)
          , o = r(2)
          , i = r.n(o)
          , c = r(14)
          , u = r.n(c)
          , s = r(205)
          , l = r.n(s);
        function d(e) {
            var t = e.suggestions
              , r = e.onClick
              , n = e.suggestsInFocus
              , o = e.focusedSuggest
              , i = u()("Select suggest_container has-value", l.a.suggest)
              , c = u()("suggest_list", l.a.suggest_list);
            return a.a.createElement("div", {
                className: i
            }, a.a.createElement("div", {
                className: "Select-control"
            }, a.a.createElement("div", {
                className: c
            }, t.map(function(e, t) {
                var i, c, s, d = e.structured_formatting.main_text, p = u()("suggest_list__item", l.a.suggest_item, (i = {},
                c = l.a["suggest_list--focused"],
                s = n && o === t,
                c in i ? Object.defineProperty(i, c, {
                    value: s,
                    enumerable: !0,
                    configurable: !0,
                    writable: !0
                }) : i[c] = s,
                i));
                return a.a.createElement("div", {
                    className: p,
                    onClick: function(e) {
                        return r(e, d, t)
                    },
                    key: t
                }, d)
            }))))
        }
        d.propTypes = {
            suggestions: i.a.array.isRequired,
            onClick: i.a.func.isRequired,
            suggestsInFocus: i.a.bool,
            focusedSuggest: i.a.any
        }
    },
    516: function(e, t, r) {
        "use strict";
        var n = r(2)
          , a = r.n(n)
          , o = r(0)
          , i = r.n(o)
          , c = r(667)
          , u = r(8)
          , s = r(226)
          , l = r.n(s)
          , d = r(117)
          , p = r.n(d)
          , f = function() {
            function e(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    n.enumerable = n.enumerable || !1,
                    n.configurable = !0,
                    "value"in n && (n.writable = !0),
                    Object.defineProperty(e, n.key, n)
                }
            }
            return function(t, r, n) {
                return r && e(t.prototype, r),
                n && e(t, n),
                t
            }
        }();
        function m(e, t) {
            if (!e)
                throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return !t || "object" != typeof t && "function" != typeof t ? e : t
        }
        var v = function(e) {
            function t() {
                var e, r, n;
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t);
                for (var a = arguments.length, o = Array(a), i = 0; i < a; i++)
                    o[i] = arguments[i];
                return r = n = m(this, (e = t.__proto__ || Object.getPrototypeOf(t)).call.apply(e, [this].concat(o))),
                n.handleNormalize = function(e, t) {
                    var r = n.props.defaultValue
                      , a = t ? e.length < t.length : e.length < r.length;
                    return a && e.length < r.length ? r : a ? e : Object(u.formatPhoneHuman)(e)
                }
                ,
                m(n, r)
            }
            return function(e, t) {
                if ("function" != typeof t && null !== t)
                    throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        enumerable: !1,
                        writable: !0,
                        configurable: !0
                    }
                }),
                t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
            }(t, o["Component"]),
            f(t, [{
                key: "render",
                value: function() {
                    var e = this.props
                      , t = e.inputClassName
                      , r = e.autocomplete
                      , n = e.name
                      , a = e.innerRef;
                    return i.a.createElement(c.a, {
                        name: n,
                        type: "text",
                        component: p.a,
                        autoComplete: r,
                        normalize: l.a,
                        format: u.formatPhoneHuman,
                        maxLength: "18",
                        innerRef: a,
                        forwardRef: Boolean(a),
                        inputClassName: t,
                        fullWidth: !0
                    })
                }
            }]),
            t
        }();
        v.defaultProps = {
            defaultValue: ""
        },
        v.propTypes = {
            name: a.a.string.isRequired,
            defaultValue: a.a.string,
            inputClassName: a.a.string,
            autocomplete: a.a.string,
            innerRef: a.a.func
        },
        t.a = v
    },
    522: function(e, t, r) {
        "use strict";
        r.d(t, "b", function() {
            return u
        }),
        r.d(t, "a", function() {
            return s
        }),
        r.d(t, "c", function() {
            return l
        });
        var n = r(30)
          , a = r(26)
          , o = r(53)
          , i = r(21);
        r(390);
        function c(e, t) {
            var r = t.id;
            return r ? e.entities.orders[r] : null
        }
        function u(e) {
            return e.payments.orderId
        }
        var s = Object(a.createSelector)([u, i.i], function(e, t) {
            return e ? Object(n.denormalize)(t.orders[e], o.l, t) : null
        });
        function l() {
            return Object(a.createSelector)([c, i.i], function(e, t) {
                if (e)
                    return Object(n.denormalize)(e, o.l, t)
            })
        }
    },
    545: function(e, t, r) {
        e.exports = {
            message: "message__5Ep02yP0",
            message_title: "message_title__4mGlZ9H5",
            message_title__success: "message_title__success__25FN5oy1",
            hint: "hint__1Lptt0Qt"
        }
    },
    546: function(e, t, r) {
        e.exports = {
            block: "block__3ioUhNQH",
            hint: "hint__2YlkHbKL hint__2r7xW549",
            container: "container__b66PCR7o",
            payhint: "payhint__1EGeMlob"
        }
    },
    551: function(e, t, r) {
        "use strict";
        r.d(t, "a", function() {
            return n
        }),
        r.d(t, "c", function() {
            return a
        }),
        r.d(t, "b", function() {
            return o
        });
        var n = "1"
          , a = "2"
          , o = "3"
    },
    553: function(e, t, r) {
        "use strict";
        var n = r(30)
          , a = r(4)
          , o = r(32)
          , i = r(33)
          , c = Object(o.a)({
            route: "/delivery/city/:cityId",
            params: {
                method: "get"
            }
        }, i.a)
          , u = r(35)
          , s = r(68)
          , l = r(63)
          , d = r(522)
          , p = r(53);
        r.d(t, "a", function() {
            return m
        });
        var f = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function m(e, t) {
            return function(r, o) {
                return new Promise(function(i, m) {
                    var v, b, y, g = o(), _ = Object(l.k)(g).productId, h = (Object(d.a)(g) || {}).product;
                    r((v = {
                        payload: {
                            id: _ || h
                        }
                    },
                    b = u.a,
                    y = {
                        method: c,
                        requestParams: f({
                            productId: _ || h,
                            type: a.EDeliveryType.CARRIER_PICKUP
                        }, t),
                        routeParams: {
                            cityId: e.id
                        },
                        types: [s.d, {
                            type: s.e,
                            payload: function(t, r, a) {
                                var o = Object(u.b)(a)
                                  , i = Object(n.normalize)(o, {
                                    deliveries: p.e,
                                    points: p.m
                                })
                                  , c = i.result.deliveries
                                  , s = i.result.points;
                                return {
                                    entities: f({}, i.entities),
                                    deliveryTypeIds: c,
                                    pickupPointIds: s,
                                    deliveryCity: f({}, e)
                                }
                            }
                        }, s.c],
                        resolve: i,
                        reject: m
                    },
                    b in v ? Object.defineProperty(v, b, {
                        value: y,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0
                    }) : v[b] = y,
                    v))
                }
                )
            }
        }
    },
    559: function(e, t, r) {
        "use strict";
        var n = r(68);
        function a(e) {
            return {
                type: n.m,
                payload: {
                    deliveryTypeActive: e
                }
            }
        }
        var o = r(36)
          , i = r(70)
          , c = r(4)
          , u = r(63)
          , s = r(72)
          , l = r(32)
          , d = r(33)
          , p = Object(l.a)({
            route: "/order/create",
            params: {
                method: "post",
                headers: {
                    "Content-Type": "application/json; charset=utf-8"
                }
            }
        }, d.a)
          , f = r(35)
          , m = r(425)
          , v = /[^\d]?/g
          , b = function(e) {
            return e ? e.replace(v, "") : ""
        }
          , y = r(6)
          , g = r(108);
        function _() {
            return function(e, t) {
                var r = t()
                  , a = Object(u.k)(r)
                  , o = a.productId
                  , i = a.order
                  , s = i.deliveryType
                  , l = i.firstname
                  , d = i.lastname
                  , v = i.middlename
                  , _ = i.phone
                  , h = i.deliveryCity
                  , E = void 0 === h ? {} : h
                  , O = i.pickupPointId
                  , P = i.address
                  , j = i.apartament
                  , C = i.location;
                return new Promise(function(t, a) {
                    var i, c, u;
                    e((i = {},
                    c = f.a,
                    u = {
                        method: p,
                        requestParams: {
                            firstName: l,
                            lastName: d,
                            middleName: v,
                            phone: b(_),
                            cityId: E.id,
                            cityName: E.name,
                            productId: o,
                            deliveryType: s,
                            deliveryCity: E.id,
                            deliveryPoint: O,
                            skin: Object(m.a)(r),
                            addressStreet: P,
                            addressRoom: j,
                            location: C
                        },
                        types: [n.g, {
                            type: n.h,
                            payload: function(e, t, r) {
                                return Object(f.b)(r)
                            }
                        }, n.f],
                        resolve: t,
                        reject: a
                    },
                    c in i ? Object.defineProperty(i, c, {
                        value: u,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0
                    }) : i[c] = u,
                    i))
                }
                ).then(function(e) {
                    var t = Object(g.a)()(r, {
                        id: o
                    })
                      , n = e.orderId;
                    return y.bc.emit(y.D, {
                        productId: o,
                        product: t,
                        order: n
                    }),
                    e.orderId && setTimeout(function() {
                        window.location.href = c.orion.orderHold(n)
                    }, 500),
                    e
                })
            }
        }
        var h = r(474)
          , E = r(196)
          , O = r(520)
          , P = r(346)
          , j = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
          , C = "OK"
          , k = "ZERO_RESULTS";
        function w(e, t) {
            var r = t.dispatch
              , n = t.deliveryCity.name;
            return new Promise(function(t) {
                var a = n + " " + e;
                return function(e) {
                    return new Promise(function(t, r) {
                        (new window.google.maps.Geocoder).geocode({
                            address: e
                        }, function(e, n) {
                            return n === C || n === k ? t(e) : r(e),
                            e
                        })
                    }
                    )
                }(a).then(function(e) {
                    var n = e[0].geometry.location
                      , o = Object(P.a)(e)
                      , i = {
                        latitude: n.lat(),
                        longitude: n.lng()
                    };
                    if (!o)
                        return t("Адрес должен содержать улицу и дом");
                    r({
                        type: O.a,
                        payload: {
                            fullAddress: o,
                            location: j({
                                description: a
                            }, i)
                        }
                    }),
                    t(!1)
                }).catch(function() {
                    r({
                        type: O.a,
                        payload: {
                            fullAddress: e
                        }
                    }),
                    t(!1)
                })
            }
            )
        }
        function R(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        var I, S, N = /(^[.a-zA-Zа-яА-ЯЁё\s\t\-\一]+$)/, A = (I = regeneratorRuntime.mark(function e(t, r, n) {
            var a;
            return regeneratorRuntime.wrap(function(e) {
                for (; ; )
                    switch (e.prev = e.next) {
                    case 0:
                        if (a = !1,
                        -1 === r.indexOf(s.a) || !t[s.a]) {
                            e.next = 5;
                            break
                        }
                        return e.next = 4,
                        w(t[s.a], n);
                    case 4:
                        a = e.sent;
                    case 5:
                        return e.abrupt("return", r.reduce(function(e, r) {
                            var n, o, i = t[r];
                            if (!i)
                                return e[r] = (n = r,
                                R(o = {}, s.c, "Поле «Имя» должно быть заполнено"),
                                R(o, s.e, "Поле «Отчество» должно быть заполнено"),
                                R(o, s.d, "Поле «Фамилия» должно быть заполнено"),
                                R(o, s.f, "Поле «Tелефон» должно быть заполнено"),
                                R(o, s.a, "Выберите адрес из выпадающего списка"),
                                o[n]),
                                e;
                            if (r === s.f) {
                                var c = Object(h.a)(i);
                                if (c)
                                    return e[r] = c,
                                    e
                            }
                            return r === s.a && a && (e[r] = a),
                            (r === s.c || r === s.d || r === s.e) && (N.test(i.trim()) ? i.length > 25 && (e[r] = E.a) : e[r] = E.b),
                            e
                        }, {}));
                    case 6:
                    case "end":
                        return e.stop()
                    }
            }, e, this)
        }),
        S = function() {
            var e = I.apply(this, arguments);
            return new Promise(function(t, r) {
                return function n(a, o) {
                    try {
                        var i = e[a](o)
                          , c = i.value
                    } catch (e) {
                        return void r(e)
                    }
                    if (!i.done)
                        return Promise.resolve(c).then(function(e) {
                            n("next", e)
                        }, function(e) {
                            n("throw", e)
                        });
                    t(c)
                }("next")
            }
            )
        }
        ,
        function(e, t, r) {
            return S.apply(this, arguments)
        }
        );
        var M = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function x(e, t, r) {
            return !!(r.length > 0) || !e && !t
        }
        function T() {
            var e = this;
            return function() {
                var t = function(e) {
                    return function() {
                        var t = e.apply(this, arguments);
                        return new Promise(function(e, r) {
                            return function n(a, o) {
                                try {
                                    var i = t[a](o)
                                      , c = i.value
                                } catch (e) {
                                    return void r(e)
                                }
                                if (!i.done)
                                    return Promise.resolve(c).then(function(e) {
                                        n("next", e)
                                    }, function(e) {
                                        n("throw", e)
                                    });
                                e(c)
                            }("next")
                        }
                        )
                    }
                }(regeneratorRuntime.mark(function t(r, a) {
                    var l, d, p, f, m, v, b, y, g, h, E, O, P, j;
                    return regeneratorRuntime.wrap(function(e) {
                        for (; ; )
                            switch (e.prev = e.next) {
                            case 0:
                                return l = a(),
                                d = l.form[i.a],
                                p = d.values,
                                f = d.syncErrors,
                                m = void 0 === f ? {} : f,
                                v = l.entities.deliveryTypes,
                                b = Object(u.k)(l),
                                y = b.deliveryTypeActive,
                                g = b.pickupPointIdPersisted,
                                h = Object(u.j)(l),
                                E = Object(s.g)(c.EDeliveryType.CARRIER_PICKUP),
                                O = E.reduce(function(e, t) {
                                    var r = m[t];
                                    return r && (e[t] = r),
                                    e
                                }, {}),
                                e.t0 = M,
                                e.t1 = {},
                                e.t2 = O,
                                e.next = 11,
                                A(p, E);
                            case 11:
                                if (e.t3 = e.sent,
                                e.t3) {
                                    e.next = 14;
                                    break
                                }
                                e.t3 = {};
                            case 14:
                                if (e.t4 = e.t3,
                                P = (0,
                                e.t0)(e.t1, e.t2, e.t4),
                                j = Object.keys(P),
                                !x(g, h, j)) {
                                    e.next = 19;
                                    break
                                }
                                return e.abrupt("return", r(Object(o.stopSubmit)(i.a, P)));
                            case 19:
                                return r({
                                    type: n.i,
                                    payload: {
                                        order: M({}, p, {
                                            deliveryType: y,
                                            pickupPointId: g || h,
                                            pickupPrice: v[y].price
                                        })
                                    }
                                }),
                                e.abrupt("return", r(_()));
                            case 21:
                            case "end":
                                return e.stop()
                            }
                    }, t, e)
                }));
                return function(e, r) {
                    return t.apply(this, arguments)
                }
            }()
        }
        var L = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function q() {
            var e = this;
            return function() {
                var t = function(e) {
                    return function() {
                        var t = e.apply(this, arguments);
                        return new Promise(function(e, r) {
                            return function n(a, o) {
                                try {
                                    var i = t[a](o)
                                      , c = i.value
                                } catch (e) {
                                    return void r(e)
                                }
                                if (!i.done)
                                    return Promise.resolve(c).then(function(e) {
                                        n("next", e)
                                    }, function(e) {
                                        n("throw", e)
                                    });
                                e(c)
                            }("next")
                        }
                        )
                    }
                }(regeneratorRuntime.mark(function t(r, a) {
                    var l, d, p, f, m, v, b, y, g, h, E, O, P, j, C, k;
                    return regeneratorRuntime.wrap(function(e) {
                        for (; ; )
                            switch (e.prev = e.next) {
                            case 0:
                                return l = a(),
                                d = l.form[i.a],
                                p = d.values,
                                f = d.syncErrors,
                                m = void 0 === f ? {} : f,
                                v = Object(u.k)(l),
                                b = v.deliveryTypeActive,
                                y = v.deliveryCity,
                                g = Object(s.g)(c.EDeliveryType.CARRIER_COURIER),
                                h = g.reduce(function(e, t) {
                                    var r = m[t];
                                    return r && (e[t] = r),
                                    e
                                }, {}),
                                e.t0 = L,
                                e.t1 = {},
                                e.t2 = h,
                                e.next = 10,
                                A(p, g, {
                                    dispatch: r,
                                    deliveryCity: y
                                });
                            case 10:
                                if (e.t3 = e.sent,
                                E = (0,
                                e.t0)(e.t1, e.t2, e.t3),
                                !(Object.keys(E).length > 0) && y && y.id) {
                                    e.next = 15;
                                    break
                                }
                                return e.abrupt("return", r(Object(o.stopSubmit)(i.a, E)));
                            case 15:
                                return O = a(),
                                P = O.form[i.a],
                                j = P.fullAddress,
                                C = P.location,
                                k = O.entities.deliveryTypes,
                                r({
                                    type: n.i,
                                    payload: {
                                        order: L({}, p, {
                                            deliveryType: b,
                                            deliveryCity: y,
                                            deliveryPrice: k[b].price,
                                            fullAddress: j,
                                            location: C
                                        })
                                    }
                                }),
                                e.abrupt("return", r(_()));
                            case 18:
                            case "end":
                                return e.stop()
                            }
                    }, t, e)
                }));
                return function(e, r) {
                    return t.apply(this, arguments)
                }
            }()
        }
        function F() {
            return function(e, t) {
                var r = t()
                  , a = Object(u.k)(r)
                  , s = a.deliveryTypeActive
                  , l = a.deliveryCity;
                switch (e(Object(o.startSubmit)(i.a)),
                s) {
                case c.EDeliveryType.CARRIER_PICKUP:
                case c.EDeliveryType.CARRIER_PICKUP_FREE:
                    return e(T());
                case c.EDeliveryType.CARRIER_COURIER:
                    return e(q());
                case c.EDeliveryType.SELF_PICKUP:
                    return e({
                        type: n.i,
                        payload: {
                            order: {
                                deliveryType: s,
                                deliveryCity: l
                            }
                        }
                    }),
                    e(_())
                }
            }
        }
        r.d(t, "c", function() {
            return a
        }),
        r.d(t, "b", function() {
            return F
        }),
        r.d(t, "a", function() {
            return _
        })
    },
    563: function(e, t, r) {
        "use strict";
        var n = r(197)
          , a = r(427)
          , o = function() {
            return {
                streetViewControl: !1,
                mapTypeControl: !1,
                zoomControl: !1,
                fullscreenControl: !1
            }
        };
        r.d(t, "a", function() {
            return u
        });
        var i = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        var c = {
            backgroundColor: "#ccc",
            zoom: 14
        };
        function u(e, t) {
            var r, u, s = this, l = t.centerCoords;
            return r = regeneratorRuntime.mark(function t(r, u) {
                var d, p, f;
                return regeneratorRuntime.wrap(function(t) {
                    for (; ; )
                        switch (t.prev = t.next) {
                        case 0:
                            if (l) {
                                t.next = 2;
                                break
                            }
                            return t.abrupt("return");
                        case 2:
                            if (u().googleMapsApi.googleMapsReady) {
                                t.next = 6;
                                break
                            }
                            return t.next = 6,
                            r(Object(a.a)());
                        case 6:
                            if (d = window.google) {
                                t.next = 9;
                                break
                            }
                            return t.abrupt("return", r({
                                type: n.d
                            }));
                        case 9:
                            return p = new d.maps.LatLng(l),
                            f = new d.maps.Map(e,i({
                                center: p
                            }, c, o(d))),
                            t.abrupt("return", r({
                                type: n.f,
                                payload: {
                                    map: f
                                }
                            }));
                        case 12:
                        case "end":
                            return t.stop()
                        }
                }, t, s)
            }),
            u = function() {
                var e = r.apply(this, arguments);
                return new Promise(function(t, r) {
                    return function n(a, o) {
                        try {
                            var i = e[a](o)
                              , c = i.value
                        } catch (e) {
                            return void r(e)
                        }
                        if (!i.done)
                            return Promise.resolve(c).then(function(e) {
                                n("next", e)
                            }, function(e) {
                                n("throw", e)
                            });
                        t(c)
                    }("next")
                }
                )
            }
            ,
            function(e, t) {
                return u.apply(this, arguments)
            }
        }
    },
    63: function(e, t, r) {
        "use strict";
        var n, a = r(100), o = r.n(a), i = r(64), c = r.n(i), u = r(20), s = r.n(u), l = r(868), d = r.n(l), p = r(26), f = r(30), m = r(4), v = r(397), b = r(340), y = [m.EDeliveryType.CARRIER_PICKUP, m.EDeliveryType.CARRIER_PICKUP_FREE, m.EDeliveryType.CARRIER_COURIER, m.EDeliveryType.SELF_PICKUP], g = r(551);
        function _(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        var h, E = (_(n = {}, g.a, "Сумма возврата должна совпадать с суммой заказа"),
        _(n, g.c, "Сумма возврата не может быть больше суммы заказа"),
        _(n, g.b, "Сумма возврата должна совпадать с суммой заказа"),
        _(n, "default", "Сумма возврата не может быть больше суммы заказа"),
        n), O = r(395), P = r(72), j = r(391), C = r(390), k = r(77), w = r(70), R = r(53), I = r(21);
        function S(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        r.d(t, "n", function() {
            return M
        }),
        r.d(t, "g", function() {
            return q
        }),
        r.d(t, "q", function() {
            return F
        }),
        r.d(t, "p", function() {
            return D
        }),
        r.d(t, "k", function() {
            return G
        }),
        r.d(t, "d", function() {
            return B
        }),
        r.d(t, "m", function() {
            return U
        }),
        r.d(t, "o", function() {
            return K
        }),
        r.d(t, "c", function() {
            return H
        }),
        r.d(t, "b", function() {
            return V
        }),
        r.d(t, "j", function() {
            return Y
        }),
        r.d(t, "h", function() {
            return z
        }),
        r.d(t, "i", function() {
            return W
        }),
        r.d(t, "a", function() {
            return J
        }),
        r.d(t, "r", function() {
            return Z
        }),
        r.d(t, "f", function() {
            return X
        }),
        r.d(t, "e", function() {
            return Q
        }),
        r.d(t, "l", function() {
            return $
        });
        var N = (S(h = {}, C.a, "Сумма возврата"),
        S(h, C.b, "Сумма оплаты"),
        h)
          , A = /[^\d+]/g;
        function M(e) {
            return e.payments.orderCreate.productId
        }
        function x(e) {
            return e.entities.products
        }
        function T(e) {
            return e.entities.deliveryTypes
        }
        function L(e) {
            return e.payments.orderCreate.deliveryTypeIds
        }
        function q(e) {
            return e.commonReducer.modalPayload.disputFormPayload
        }
        function F(e) {
            return e.entities.pickupPoints
        }
        function D(e) {
            return e.payments.pickupPointIds || []
        }
        function G(e) {
            return e.payments.orderCreate
        }
        function B(e) {
            return e.form[w.b] || {}
        }
        var U = Object(p.createSelector)([M, x], function(e, t) {
            return t[e] || {}
        })
          , K = Object(p.createSelector)([U, function(e) {
            return e.entities.images
        }
        ], function(e, t) {
            return t[e.images[0]] || {}
        })
          , H = Object(p.createSelector)([T, L], function(e, t) {
            var r = t.sort(function(t, r) {
                return e[t].order - e[r].order
            });
            return Object(f.denormalize)(r, R.e, S({}, k.d, e))
        })
          , V = Object(p.createSelector)([H], function(e) {
            var t = Array(3);
            return e.map(function(e) {
                if (e.isAvailable) {
                    var r = y.indexOf(e.type);
                    return t[r] = e,
                    e
                }
                return e
            }),
            t.filter(Boolean)
        })
          , Y = Object(p.createSelector)([F, D], function(e, t) {
            return o()(t, function(t) {
                return e[t].isNearest
            }) || t[0]
        })
          , z = Object(p.createSelector)([x, M], function(e, t) {
            return e[t].deliveryAvailable
        })
          , W = Object(p.createSelector)([L], function(e) {
            return !s()(d()(e, [m.EDeliveryType.CARRIER_COURIER, m.EDeliveryType.CARRIER_PICKUP, m.EDeliveryType.CARRIER_PICKUP_FREE]))
        })
          , J = Object(p.createSelector)([T, function(e) {
            return e.payments.orderCreate.deliveryTypeActive
        }
        ], function(e, t) {
            return c()(e, [t, "price"])
        })
          , Z = Object(p.createSelector)([function(e) {
            return e.payments.pickupPointIdChoosen
        }
        , D, Y], function(e, t, r) {
            var n = e || r;
            return {
                pickupPointIdActive: n,
                pickupPointIndexActive: t.indexOf(n)
            }
        })
          , X = Object(p.createSelector)([B, q], function(e, t) {
            var r = e.reasons
              , n = e.resolutions
              , a = e.values
              , o = void 0 === a ? {} : a
              , i = t.variant
              , c = t.productPrice
              , u = t.userRole
              , s = o[b.e]
              , l = c / 100
              , d = N[u]
              , p = {
                title: i === v.b ? "Решение" : "Тип спора",
                type: O.b,
                name: b.e,
                options: n
            }
              , f = {
                title: d + ", ₽",
                type: O.d,
                name: b.c,
                placeholder: "до " + l + " ₽",
                description: E[s || "default"]
            }
              , m = {
                title: "Причина спора",
                type: O.b,
                name: b.d,
                options: r
            }
              , y = {
                title: "Комментарий",
                type: O.c,
                name: b.b,
                placeholder: "Обязательно опишите, что вас не устроило"
            }
              , g = {
                title: "Вложения",
                type: O.a,
                name: b.a
            };
            switch (i) {
            case v.a:
                return [p, f, m, y, g];
            case v.b:
                return [p, f, y]
            }
        })
          , Q = Object(p.createSelector)([X], function(e) {
            return e.map(function(e) {
                return e.name
            })
        })
          , $ = Object(p.createSelector)([function(e) {
            return e.form[w.a] || {}
        }
        , I.a, I.l], function(e, t, r) {
            var n, a, i = t.firstName, c = t.lastName, u = t.phone, s = t.delivery, l = s.firstName, d = s.lastName, p = s.middleName, f = s.phone, m = s.addressStreet, v = s.addressRoom, b = s.location.description, y = r.type, g = r.data, _ = void 0;
            return m ? _ = m : b ? _ = b : y === j.a && (_ = g.title),
            S(n = {}, P.c, l || i),
            S(n, P.d, d || c),
            S(n, P.e, p),
            S(n, P.f, (a = [f, u],
            o()(a, function(e) {
                return String(e).replace(A, "")
            }) || "+7")),
            S(n, P.a, _),
            S(n, P.b, v),
            n
        })
    },
    631: function(e, t, r) {
        "use strict";
        r.d(t, "c", function() {
            return l
        }),
        r.d(t, "b", function() {
            return d
        }),
        r.d(t, "a", function() {
            return f
        });
        var n = r(135)
          , a = r(559)
          , o = r(379)
          , i = r(63)
          , c = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
          , u = "LOCATION_CHANGE"
          , s = "SET_PARAMS";
        function l(e) {
            var t = e.dispatch;
            return function(e) {
                return t(function() {
                    var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "/";
                    return {
                        type: u,
                        payload: e
                    }
                }(e))
            }
        }
        function d(e) {
            return function(t, r) {
                var n = r();
                return t(Object(a.c)(function(e, t) {
                    var r = Object(i.k)(t).deliveryTypeIds
                      , n = Object(i.c)(t)
                      , a = o.c[e && e.type];
                    return a && r.indexOf(a) > -1 ? a : n[0].type
                }(e, n))),
                t({
                    type: s,
                    payload: {
                        params: e
                    }
                })
            }
        }
        var p = n.e.getCurrentLocation();
        function f() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : p
              , t = arguments[1]
              , r = t.type
              , n = t.payload;
            switch (r) {
            case u:
                return c({}, e, n);
            case s:
                return c({}, e, {
                    params: n.params
                })
            }
            return e
        }
    },
    72: function(e, t, r) {
        "use strict";
        r.d(t, "c", function() {
            return i
        }),
        r.d(t, "d", function() {
            return c
        }),
        r.d(t, "e", function() {
            return u
        }),
        r.d(t, "a", function() {
            return s
        }),
        r.d(t, "b", function() {
            return l
        }),
        r.d(t, "f", function() {
            return d
        }),
        r.d(t, "h", function() {
            return f
        }),
        r.d(t, "g", function() {
            return m
        });
        var n, a = r(4);
        function o(e, t, r) {
            return t in e ? Object.defineProperty(e, t, {
                value: r,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = r,
            e
        }
        var i = "firstname"
          , c = "lastname"
          , u = "middlename"
          , s = "address"
          , l = "apartament"
          , d = "phone"
          , p = (o(n = {}, c, {
            placeholder: "Фамилия",
            name: "lastname",
            type: "text"
        }),
        o(n, i, {
            placeholder: "Имя",
            name: "firstname",
            type: "text"
        }),
        o(n, u, {
            placeholder: "Отчество",
            name: "middlename",
            type: "text"
        }),
        n)
          , f = Object.keys(p).map(function(e) {
            return p[e]
        });
        function m(e) {
            switch (e) {
            case a.EDeliveryType.CARRIER_PICKUP:
                return [i, c, u, d];
            case a.EDeliveryType.CARRIER_COURIER:
                return [i, c, u, d, s]
            }
        }
    },
    847: function(e, t, r) {
        e.exports = {
            title: "title__1tzAN2wR",
            container: "container__28A_2L3T"
        }
    },
    866: function(e, t, r) {
        "use strict";
        var n = r(17)
          , a = r(74)
          , o = r(2)
          , i = r.n(o)
          , c = r(0)
          , u = r.n(c)
          , s = r(71)
          , l = r.n(s)
          , d = r(4)
          , p = r(136)
          , f = r.n(p)
          , m = r(154)
          , v = r.n(m)
          , b = r(34)
          , y = r.n(b)
          , g = r(131)
          , _ = r.n(g);
        function h(e, t) {
            var r = _()(e)
              , n = _()();
            return function(e) {
                return e.isSame(_()().clone().subtract(1, "days").startOf("day"), "day")
            }(r) ? "Вчера " + r.format("HH:mm") : n.diff(r, "days", !0) < 1 && "short" === t ? r.format("HH:mm") : n.diff(r, "days", !0) > 1 ? "short" === t ? r.format("DD.MM.YY") : r.format("L") : r.calendar()
        }
        _.a.locale("ru");
        var E = r(399);
        function O(e) {
            var t = e.user
              , r = t.id
              , n = t.image
              , a = t.name
              , o = t.ratingMark
              , i = t.blacklistDateAdded
              , c = e.chatId
              , s = e.productId
              , p = e.label
              , m = e.showRating
              , b = e.showSendMessage
              , g = e.sendMessageLabel
              , _ = e.linksEnabled
              , O = e.analyticsSendMessage
              , P = d.orion.user(r)
              , j = function(e) {
                return l()(e) ? e.url : e || null
            }(n)
              , C = void 0;
            return c ? C = d.orion.chat(c) : s && (C = d.orion.imProduct(s)),
            u.a.createElement("div", {
                className: "user user--simple"
            }, u.a.createElement("div", {
                className: "user__image"
            }, u.a.createElement(v.a, {
                rel: "nofollow",
                href: _ && P ? P : null
            }, j ? u.a.createElement("img", {
                src: f()(j, d.ImagePreset.SMALL_S),
                alt: a,
                width: "64",
                height: "64"
            }) : null)), u.a.createElement("div", {
                className: "user__info"
            }, u.a.createElement("div", {
                className: "user__name"
            }, u.a.createElement(v.a, {
                href: _ && P ? P : null,
                title: a
            }, p ? u.a.createElement("span", {
                className: "user__label"
            }, p) : null, a), i ? u.a.createElement("div", {
                className: "hint"
            }, h(1e3 * i, "short")) : null), m ? u.a.createElement(E.a, {
                rating: o
            }) : null), b && C ? u.a.createElement(y.a, {
                flat: !0,
                small: !0,
                href: C,
                className: "button_open_order",
                onClick: O || null
            }, g) : null)
        }
        O.defaultProps = {
            showRating: !1,
            sendMessageLabel: "Написать сообщение",
            linksEnabled: !0,
            showSendMessage: !1
        },
        O.propTypes = {
            user: i.a.shape({
                id: i.a.string.isRequired,
                image: i.a.oneOfType([i.a.string, i.a.shape({
                    url: i.a.string
                })]),
                name: i.a.string.isRequired,
                rating: i.a.number,
                blacklistDateAdded: i.a.number
            }).isRequired,
            chatId: i.a.string,
            productId: i.a.string,
            showRating: i.a.bool,
            showSendMessage: i.a.bool,
            label: i.a.string,
            sendMessageLabel: i.a.string,
            linksEnabled: i.a.bool,
            analyticsSendMessage: i.a.func
        };
        var P = O;
        t.a = Object(n.connect)(function() {
            var e = Object(a.d)();
            return function(t, r) {
                return {
                    user: e(t, r)
                }
            }
        })(P)
    },
    869: function(e, t, r) {
        "use strict";
        var n = r(68)
          , a = r(63)
          , o = r(15)
          , i = o.a.getImagePin()
          , c = o.a.getImageDot();
        function u(e) {
            if (e)
                return function(t, r) {
                    var o = r()
                      , u = o.googleMapsApi
                      , s = u.map
                      , l = u.markers
                      , d = o.entities.pickupPoints
                      , p = o.payments.pickupPointIdChoosen
                      , f = Object(a.j)(o)
                      , m = p || f
                      , v = d[e].location
                      , b = new window.google.maps.LatLng(v.lat,v.lng);
                    return s.panTo(b),
                    l[m].setIcon(c),
                    l[e].setIcon(i),
                    t({
                        type: n.k,
                        payload: {
                            pickupPointIdChoosen: e,
                            pickupPointDetail: !0
                        }
                    })
                }
        }
        function s() {
            return {
                type: n.l,
                payload: {
                    pickupPointIdChoosen: null,
                    pickupPointIdPersisted: null,
                    pickupPointIdActive: null,
                    pickupPointDetail: !1
                }
            }
        }
        function l() {
            return function(e, t) {
                var r = t().payments.pickupPointIdChoosen;
                return e({
                    type: n.j,
                    payload: {
                        pickupPointIdPersisted: r
                    }
                })
            }
        }
        function d() {
            return {
                type: n.a,
                payload: {
                    pickupPointDetail: !1
                }
            }
        }
        var p = r(50)
          , f = r(29)
          , m = r(426)
          , v = r(197)
          , b = r(32)
          , y = r(33)
          , g = Object(b.a)({
            route: "/geo/city_by_coords",
            params: {
                method: "get"
            }
        }, y.a)
          , _ = r(35)
          , h = r(251)
          , E = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        function O() {
            return function(e, t) {
                return new Promise(function(r, n) {
                    var a, o, i, c = t().twigReducer.location, u = (c = void 0 === c ? {} : c).data, s = u.lat, l = u.lng;
                    if (u.id)
                        return e({
                            type: h.c,
                            payload: E({}, u)
                        }),
                        r(u);
                    s && l && e((a = {},
                    o = _.a,
                    i = {
                        method: g,
                        requestParams: {
                            lat: s,
                            lng: l
                        },
                        payload: {},
                        types: [h.b, {
                            type: h.c,
                            payload: function(e, t, r) {
                                var n = Object(_.b)(r);
                                return E({}, n)
                            }
                        }, h.a],
                        resolve: r,
                        reject: n
                    },
                    o in a ? Object.defineProperty(a, o, {
                        value: i,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0
                    }) : a[o] = i,
                    a))
                }
                )
            }
        }
        var P = r(553);
        function j() {
            var e, t, r = this, n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            return e = regeneratorRuntime.mark(function e(t, o) {
                var i, c, u, s, l, d, p, f, b, y, g, _, h, E, j, C, k;
                return regeneratorRuntime.wrap(function(e) {
                    for (; ; )
                        switch (e.prev = e.next) {
                        case 0:
                            i = {},
                            c = o(),
                            u = Object(a.q)(c),
                            e.t0 = n.variant,
                            e.next = e.t0 === m.a ? 6 : e.t0 === m.b ? 12 : e.t0 === m.c ? 19 : 33;
                            break;
                        case 6:
                            return s = Object(a.k)(c).pickupPointIdPersisted,
                            i.pickupPointIds = Object(a.p)(c),
                            l = Object(a.j)(c),
                            i.pointIdActive = s || l,
                            i.centerCoords = u[i.pointIdActive].location,
                            e.abrupt("break", 33);
                        case 12:
                            return d = c.entities.transfers,
                            p = c.payments.transferId,
                            f = d[p].deliveryPoint,
                            b = u[f],
                            y = b.id,
                            g = b.location,
                            i.pickupPointIds = [y],
                            i.pointIdActive = y,
                            i.centerCoords = g,
                            e.abrupt("break", 33);
                        case 19:
                            if (_ = c.payments.cityInfo) {
                                e.next = 24;
                                break
                            }
                            return e.next = 23,
                            t(O());
                        case 23:
                            _ = e.sent;
                        case 24:
                            return e.next = 26,
                            t(Object(P.a)(_, n.direction));
                        case 26:
                            return h = o(),
                            E = Object(a.q)(h),
                            i.pickupPointIds = Object(a.p)(h),
                            i.pointIdActive = Object(a.j)(h),
                            j = E[i.pointIdActive].location,
                            C = j.latitude,
                            k = j.longitude,
                            i.centerCoords = {
                                lat: C,
                                lng: k
                            },
                            e.abrupt("break", 33);
                        case 33:
                            return e.abrupt("return", t({
                                type: v.e,
                                payload: {
                                    mapOptions: i
                                }
                            }));
                        case 34:
                        case "end":
                            return e.stop()
                        }
                }, e, r)
            }),
            t = function() {
                var t = e.apply(this, arguments);
                return new Promise(function(e, r) {
                    return function n(a, o) {
                        try {
                            var i = t[a](o)
                              , c = i.value
                        } catch (e) {
                            return void r(e)
                        }
                        if (!i.done)
                            return Promise.resolve(c).then(function(e) {
                                n("next", e)
                            }, function(e) {
                                n("throw", e)
                            });
                        e(c)
                    }("next")
                }
                )
            }
            ,
            function(e, r) {
                return t.apply(this, arguments)
            }
        }
        function C(e, t) {
            var r, n, a = this;
            return r = regeneratorRuntime.mark(function r(n) {
                return regeneratorRuntime.wrap(function(r) {
                    for (; ; )
                        switch (r.prev = r.next) {
                        case 0:
                            return r.next = 2,
                            n(j({
                                variant: e,
                                direction: t
                            }));
                        case 2:
                            n({
                                type: p.b.ON_OPEN,
                                payload: {
                                    activeModal: f.s,
                                    className: "modal_map modal_pickup",
                                    modalPayload: {
                                        pickupAddressVariant: e
                                    }
                                }
                            });
                        case 3:
                        case "end":
                            return r.stop()
                        }
                }, r, a)
            }),
            n = function() {
                var e = r.apply(this, arguments);
                return new Promise(function(t, r) {
                    return function n(a, o) {
                        try {
                            var i = e[a](o)
                              , c = i.value
                        } catch (e) {
                            return void r(e)
                        }
                        if (!i.done)
                            return Promise.resolve(c).then(function(e) {
                                n("next", e)
                            }, function(e) {
                                n("throw", e)
                            });
                        t(c)
                    }("next")
                }
                )
            }
            ,
            function(e) {
                return n.apply(this, arguments)
            }
        }
        var k = r(563);
        function w(e) {
            var t = function() {
                var e = document.createElement("div");
                return e.classList.add("map_buttons"),
                e.style.paddingRight = "10px",
                e.style.paddingBottom = "10px",
                e.index = 1,
                e.innerHTML = '\n  <div>\n    <div class="btn btn--target"><i class="icon icon--target"></i></div>\n  </div>',
                e
            }()
              , r = window.google
              , n = r.maps.ControlPosition.RIGHT_BOTTOM;
            t.addEventListener("click", function() {
                navigator.geolocation && navigator.geolocation.getCurrentPosition(function(t) {
                    var n = new r.maps.LatLng(t.coords.latitude,t.coords.longitude);
                    e.setCenter(n)
                })
            }),
            e.controls[n].push(t)
        }
        var R = r(54)
          , I = r.n(R)
          , S = r(11);
        function N(e) {
            var t = 14
              , r = I()(function() {
                return e.setZoom(t)
            }, 150)
              , n = document.createElement("div");
            n.classList.add("map_buttons"),
            n.style.paddingRight = "10px",
            n.style.paddingBottom = "10px",
            n.index = 0;
            var a = document.createElement("div");
            a.classList.add("btn_group");
            var o = document.createElement("div");
            o.classList.add("btn", "_location_zoom_in"),
            o.innerHTML = '<i class="icon icon--add"></i>',
            o.addEventListener("click", function() {
                ++t,
                r()
            });
            var i = document.createElement("div");
            return i.classList.add("btn", "_location_zoom_out"),
            i.innerHTML = '<i class="icon icon--remove"></i>',
            i.addEventListener("click", function() {
                --t,
                r()
            }),
            a.appendChild(o),
            a.appendChild(i),
            n.appendChild(a),
            n
        }
        function A(e) {
            if (!S.isTouchDevice) {
                var t = N(e)
                  , r = window.google.maps.ControlPosition.RIGHT_BOTTOM;
                e.controls[r].push(t)
            }
        }
        var M = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var r = arguments[t];
                for (var n in r)
                    Object.prototype.hasOwnProperty.call(r, n) && (e[n] = r[n])
            }
            return e
        }
        ;
        var x = o.a.getImagePin()
          , T = o.a.getImageDot()
          , L = {};
        function q(e) {
            var t, r, n, a = e.pointId, o = e.nearest, i = e.index, c = e.arr, s = e.google, l = e.map, d = e.dispatch, p = (0,
            e.getState)().entities.pickupPoints[a], f = p.location, m = p.id, v = new s.maps.Marker({
                position: f,
                map: l,
                icon: o ? x : T,
                id: m
            });
            L = M({}, L, (n = v,
            (r = a)in (t = {}) ? Object.defineProperty(t, r, {
                value: n,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : t[r] = n,
            t)),
            i === c.length - 1 && d({
                type: "GOOGLE_MAPS_INIT_MARKERS",
                payload: {
                    markers: L
                }
            }),
            s.maps.event.addListener(v, "click", function() {
                return function(e, t, r, n) {
                    return n(u(r[t]))
                }(0, i, c, d)
            })
        }
        function F(e) {
            var t, r, n = this;
            return t = regeneratorRuntime.mark(function t(r, a) {
                var o, i, c, u, s, l, d;
                return regeneratorRuntime.wrap(function(t) {
                    for (; ; )
                        switch (t.prev = t.next) {
                        case 0:
                            return o = a(),
                            i = o.googleMapsApi.mapOptions,
                            c = i.pickupPointIds,
                            u = i.pointIdActive,
                            t.next = 5,
                            r(Object(k.a)(e, i));
                        case 5:
                            s = window.google,
                            l = a(),
                            d = l.googleMapsApi.map,
                            c.map(function(e, t, n) {
                                return q({
                                    pointId: e,
                                    index: t,
                                    arr: n,
                                    google: s,
                                    map: d,
                                    dispatch: r,
                                    getState: a,
                                    nearest: u === e
                                })
                            }),
                            A(d),
                            w(d);
                        case 11:
                        case "end":
                            return t.stop()
                        }
                }, t, n)
            }),
            r = function() {
                var e = t.apply(this, arguments);
                return new Promise(function(t, r) {
                    return function n(a, o) {
                        try {
                            var i = e[a](o)
                              , c = i.value
                        } catch (e) {
                            return void r(e)
                        }
                        if (!i.done)
                            return Promise.resolve(c).then(function(e) {
                                n("next", e)
                            }, function(e) {
                                n("throw", e)
                            });
                        t(c)
                    }("next")
                }
                )
            }
            ,
            function(e, t) {
                return r.apply(this, arguments)
            }
        }
        r.d(t, "e", function() {
            return u
        }),
        r.d(t, "d", function() {
            return l
        }),
        r.d(t, "f", function() {
            return s
        }),
        r.d(t, "a", function() {
            return d
        }),
        r.d(t, "c", function() {
            return C
        }),
        r.d(t, "b", function() {
            return F
        })
    },
    887: function(e, t, r) {
        "use strict";
        var n = r(129)
          , a = r(63)
          , o = r(479);
        function i() {
            return function(e, t) {
                var r = t()
                  , i = Object(a.k)(r).deliveryCity;
                e(Object(n.a)({
                    name: "CityEditModal",
                    className: "modal_city",
                    payload: {
                        modalPayload: {
                            variant: o.a,
                            city: i
                        }
                    }
                }))
            }
        }
        var c = r(553);
        r.d(t, "b", function() {
            return i
        }),
        r.d(t, "a", function() {
            return c.a
        })
    }
});
