function luhnChk(e) {
    for (var t = e.length, a = 0, r = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9], [0, 2, 4, 6, 8, 1, 3, 5, 7, 9]], s = 0; t--;) s += r[a][parseInt(e.charAt(t), 10)], a ^= 1;
    return s % 10 == 0 && s > 0
}

function initAutoTab() {
    var e = {
        cardNumber: /^[0-9]{16,19}$/,
        month: /^(0[1-9]|1[012])$/,
        year: /^([1-4]\d)$/,
        cvc: /^[0-9]{3,4}$/,
        mail: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        digit: /[0-9]/
    }, t = {
        cardNumber: $("#form-card-number-input"),
        cvc: $("#form-cvc-input"),
        month: $("#form-month-input"),
        year: $("#form-year-input"),
        mail: $("#form-sendmail-input"),
        sendMail: $('#form-sendmail-checkbox'),
        submit: $('#form-submit')
    }, a = !0;
    for (var r in t) if (!t[r].length || 0 == t[r].length) {
        a = !1;
        break
    }
    if (!a) return 0;
    window.autoTab = function (a) {
        switch (a.key = a.key || String.fromCharCode(a.keyCode), a.target) {
            case t.cardNumber[0]:
                var r = t.cardNumber[0].value;
                e.digit.test(a.key) && r && (r = r.replace(/\D/g, ''), e.cardNumber.test(r) && luhnChk(r) && detectCardType(r) && 17 != r.length && t.month.focus());
                break;
            case t.cvc[0]:
                e.digit.test(a.key) && e.cvc.test(t.cvc[0].value) && (t.sendMail[0].checked ? t.mail.focus() : setTimeout(function () {
                    t.submit.focus()
                }));
                break;
            case t.month[0]:
                var s = t.month[0].value, n = parseInt(s), m = (d = new Date).getMonth() + 1,
                    o = d.getFullYear().toString().substr(2, 2), l = t.year[0].value;
                e.digit.test(a.key) && s && e.month.test(s) && !(n - m < 0 && l == o) && t.year.focus();
                break;
            case t.year[0]:
                var d = new Date, o = d.getFullYear().toString().substr(2, 2), l = t.year[0].value;
                e.digit.test(a.key) && l && !(!e.year.test(l) || l - o < 0 || l - o > 25) && t.cvc.focus()
        }
    };
    for (var r in t) t[r].bind('keyup', autoTab)
}

function validate() {
    var e = {
            cardNumber: /^[0-9]{16,19}$/,
            month: /^(0[1-9]|1[012])$/,
            year: /^([1-4]\d)$/,
            cvc: /^[0-9]{3,4}$/,
            mail: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        }, t = new Date, a = document.getElementById("form-card-number-input"), r = a.value.replace(/\D/g, ''),
        s = document.getElementById("form-cvc-input"), n = document.getElementById("form-month-input"),
        m = document.getElementById("form-year-input"), o = document.getElementById("form-sendmail-input"), l = !1,
        d = "", c = t.getMonth() + 1, i = t.getFullYear().toString().substr(2, 2);
    window.trnTcs ? window.trnTcs._get().then(function (t) {
        var u = window.trnTcs._lngCol[t].trnslt;
        e.cardNumber.test(r) && luhnChk(r) && detectCardType(r) ? removeClassName(document.getElementsByClassName("form-card-number")[0], "error-wrapper") : ("true" === a.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-card-number")[0], "error-wrapper"), d += u.cardNumErr), l = !0), !e.month.test(n.value) || n.value - c < 0 && m.value == i ? ("true" === n.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-date_month")[0], "error-wrapper"), d += u.monthErr), l = !0) : removeClassName(document.getElementsByClassName("form-date_month")[0], "error-wrapper"), !e.year.test(m.value) || m.value - i < 0 || m.value - i > 25 ? ("true" === m.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-date_year")[0], "error-wrapper"), d += u.yearErr), l = !0) : removeClassName(document.getElementsByClassName("form-date_year")[0], "error-wrapper"), e.cvc.test(s.value) ? removeClassName(document.getElementsByClassName("form-cvc")[0], "error-wrapper") : ("true" === s.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-cvc")[0], "error-wrapper"), d += "CVV/CVC, "), l = !0), document.getElementsByClassName("form-sendmail").length > 0 && document.getElementsByClassName("form-sendmail")[0].offsetWidth > 0 && document.getElementsByClassName("form-sendmail")[0].offsetHeight > 0 && (document.getElementById("form-sendmail-checkbox").checked ? (document.getElementsByClassName('mobile-border_pay')[0].classList.add('mobile-border_pay2'), document.getElementsByClassName('mobile-border_bottom')[0].classList.add('mobile-border_bottom2'), e.mail.test(o.value) ? removeClassName(document.getElementsByClassName("form-sendmail")[0], "error-wrapper") : ("true" === o.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-sendmail")[0], "error-wrapper"), d += "email, "), l = !0)) : (document.getElementsByClassName('mobile-border_pay')[0].classList.remove('mobile-border_pay2'), document.getElementsByClassName('mobile-border_bottom')[0].classList.remove('mobile-border_bottom2'))), 0 == d.length ? document.getElementById("card-credit-error").style.display = "none" : (d = d.substring(0, d.length - 2), document.getElementById("card-credit-error").style.display = "block"), !1 === l && tcsPay && !tcsPay.inProgress ? document.getElementById("form-submit").disabled = !1 : (document.getElementById("form-submit").disabled = !1, document.getElementById("card-credit-error").innerHTML = u.creditErr + d)
    }, function (e) {
        throw e
    }) : (e.cardNumber.test(r) && luhnChk(r) && detectCardType(r) ? removeClassName(document.getElementsByClassName("form-card-number")[0], "error-wrapper") : ("true" === a.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-card-number")[0], "error-wrapper"), d += "номер карты, "), l = !0), !e.month.test(n.value) || n.value - c < 0 && m.value == i ? ("true" === n.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-date_month")[0], "error-wrapper"), d += "месяц, "), l = !0) : removeClassName(document.getElementsByClassName("form-date_month")[0], "error-wrapper"), !e.year.test(m.value) || m.value - i < 0 || m.value - i > 25 ? ("true" === m.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-date_year")[0], "error-wrapper"), d += "год, "), l = !0) : removeClassName(document.getElementsByClassName("form-date_year")[0], "error-wrapper"), e.cvc.test(s.value) ? removeClassName(document.getElementsByClassName("form-cvc")[0], "error-wrapper") : ("true" === s.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-cvc")[0], "error-wrapper"), d += "CVC, "), l = !0), document.getElementsByClassName("form-sendmail").length > 0 && document.getElementsByClassName("form-sendmail")[0].offsetWidth > 0 && document.getElementsByClassName("form-sendmail")[0].offsetHeight > 0 && (document.getElementById("form-sendmail-checkbox").checked ? (document.getElementsByClassName('mobile-border_pay')[0].classList.add('mobile-border_pay2'), document.getElementsByClassName('mobile-border_bottom')[0].classList.add('mobile-border_bottom2'), e.mail.test(o.value) ? removeClassName(document.getElementsByClassName("form-sendmail")[0], "error-wrapper") : ("true" === o.getAttribute("data-validate") && (addClassName(document.getElementsByClassName("form-sendmail")[0], "error-wrapper"), d += "email, "), l = !0)) : (document.getElementsByClassName('mobile-border_pay')[0].classList.remove('mobile-border_pay2'), document.getElementsByClassName('mobile-border_bottom')[0].classList.remove('mobile-border_bottom2'))), 0 == d.length ? document.getElementById("card-credit-error").style.display = "none" : (d = d.substring(0, d.length - 2), document.getElementById("card-credit-error").style.display = "block"), !1 === l && tcsPay && !tcsPay.inProgress ? document.getElementById("form-submit").disabled = !1 : (document.getElementById("form-submit").disabled = !1, document.getElementById("card-credit-error").innerHTML = "Ошибка в заполнении полей: " + d))
}

function makeMask_card(e) {
    var t = (e = fixEvent(e)).target.value.replace(/\D/g, ''), a = document.getElementById("form-card-number__type");
    "VISA" == detectCardType(t) ? (a.className = "form-card-number__field_visa", e.target.setAttribute("maxlength", 19)) : "MIR" == detectCardType(t) ? (a.className = "form-card-number__field_mir", e.target.setAttribute("maxlength", 19)) : "MASTERCARD" == detectCardType(t) ? (a.className = "form-card-number__field_mc", e.target.setAttribute("maxlength", 19)) : "MAESTRO" == detectCardType(t) ? (a.className = "form-card-number__field_maestro", e.target.setAttribute("maxlength", 23)) : (a.className = "", e.target.setAttribute("maxlength", 23)), t.length > 0 && (t = t.match(new RegExp('.{1,4}', 'g')).join(" ")), e.target.getAttribute("data-prev-val") != e.target.value && (e.target.value = t, e.target.setAttribute("data-prev-val", t)), validate()
}

function makeMask_cvc(e) {
    var t = (e = fixEvent(e)).target.value.replace(/\D/g, '');
    e.target.getAttribute("data-prev-val") != e.target.value && (e.target.value = t, e.target.setAttribute("data-prev-val", t)), validate()
}

function makeMail(e) {
    1 == (e = fixEvent(e)).target.checked ? (addClassName(document.getElementsByClassName("form-sendmail")[0], "form-sendmail_checked"), addClassName(document.getElementsByClassName("form-submit")[0], "form-submit__with-mail"), document.getElementById("form-sendmail-input").focus()) : (removeClassName(document.getElementsByClassName("form-sendmail")[0], "form-sendmail_checked"), removeClassName(document.getElementsByClassName("form-submit")[0], "form-submit__with-mail")), validate()
}

function getClosest(e, t) {
    t = t.toUpperCase();
    do {
        if (e.nodeName === t) return e
    } while (e = e.parentNode);
    return null
}

function showPopUp(e) {
    e = fixEvent(e), closePopUp(), e.preventDefault(), e.stopPropagation(), 'block' == getClosest(e.target, 'div').getElementsByTagName('div')[0].style.display ? getClosest(e.target, 'div').getElementsByTagName('div')[0].style.display = "none" : getClosest(e.target, 'div').getElementsByTagName('div')[0].style.display = "block"
}

function closePopUp(e) {
    document.getElementById('pop-up-1').style.display = "none", document.getElementById('pop-up-2') && (document.getElementById('pop-up-2').style.display = "none")
}

function fixEvent(e) {
    if ((e = e || window.event).isFixed) return e;
    if (e.isFixed = !0, e.preventDefault = e.preventDefault || function () {
        this.returnValue = !1
    }, e.stopPropagation = e.stopPropagaton || function () {
        this.cancelBubble = !0
    }, e.target || (e.target = e.srcElement), !e.relatedTarget && e.fromElement && (e.relatedTarget = e.fromElement == e.target ? e.toElement : e.fromElement), null == e.pageX && null != e.clientX) {
        var t = document.documentElement, a = document.body;
        e.pageX = e.clientX + (t && t.scrollLeft || a && a.scrollLeft || 0) - (t.clientLeft || 0), e.pageY = e.clientY + (t && t.scrollTop || a && a.scrollTop || 0) - (t.clientTop || 0)
    }
    return !e.which && e.button && (e.which = 1 & e.button ? 1 : 2 & e.button ? 3 : 4 & e.button ? 2 : 0), e
}

function checkCardNumber(e) {
    var t, a = e.split('').reverse().join(''), r = 0, s = !0;
    if (e.length < 16) return !1;
    for (var n = 0, m = a.length; n < m; n++) t = parseInt(a[n], 10), s ? r += t : (t *= 2) > 9 ? (t = t.toString(), r += parseInt(t[0], 10) + parseInt(t[1], 10)) : r += t, s = !s;
    return !(r % 10)
}

function detectCardType(e) {
    var t = {maestro: /^6/, visa: /^4/, mastercard: /^5/, mastercard2bin: /^2/, mir: /^220[0-4]/};
    return t.maestro.test(e) ? 'MAESTRO' : t.visa.test(e) ? 'VISA' : t.mir.test(e) ? 'MIR' : t.mastercard.test(e) || t.mastercard2bin.test(e) ? 'MASTERCARD' : void 0
}


function unfocusField(e) {
    return 0 == (e = fixEvent(e)).target.value.length && removeClassName(getClosest(e.target, 'div').getElementsByTagName('label')[0], "form-label_active"), e.target.setAttribute("data-validate", "true"), validate(), !0
}

function addClassName(e, t) {
    return !hasClass(e, t) && (e.className += " " + t)
}

function removeClassName(e, t) {
    var a = ' ' + e.className.replace(/[\t\r\n]/g, ' ') + ' ';
    if (hasClass(e, t)) {
        for (; a.indexOf(' ' + t + ' ') >= 0;) a = a.replace(' ' + t + ' ', ' ');
        e.className = a.replace(/^\s+|\s+$/g, '')
    }
}

function hasClass(e, t) {
    return (" " + e.className + " ").replace(/[\n\t]/g, " ").indexOf(" " + t + " ") > -1
}

function readySteady(e, t) {
    function a(e, t) {
        $('.form-reject').css('display', 'block'), $('#tcs-pay-form').css('display', 'none'), $('.form-reject__head').text(e), $('.form-reject__text').text(t), $('.mobile-border_form').css('top', '420px'), $('.mobile-border_pay').css('display', 'none'), $('.mobile-border_bottom').css('display', 'none'), $('.button-back').on('click', function () {
            return $('.form-reject').css('display', ''), $('#tcs-pay-form').css('display', ''), $('.mobile-border_pay').css('display', ''), $('.mobile-border_bottom').css('display', ''), $('.mobile-border_form').css('top', ''), !1
        })
    }

    (tcsPay = new TcsPay).setBankSideParameters(e, t), tcsPay.allowDynamicUpdates(!0), tcsPay.onAjaxCallStart = function (e) {
        e === TcsUrl.FINISH_AUTORIZE_URL && (window.trnTcs ? window.trnTcs._get().then(function (e) {
            $("#form-submit").attr('disabled', 'disabled'), $("#form-submit").val(window.trnTcs._lngCol[e].trnslt.process)
        }, function (e) {
            throw e
        }) : ($("#form-submit").attr('disabled', 'disabled'), $("#form-submit").val('Обработка...')))
    }, tcsPay.onError = function (e, t, r, s) {
        s === TcsUrl.FINISH_AUTORIZE_URL && (window.trnTcs ? window.trnTcs._get().then(function (e) {
            $("#form-submit").removeAttr('disabled', 'disabled'), $("#form-submit").val(window.trnTcs._lngCol[e].trnslt.doPay)
        }, function (e) {
            throw e
        }) : ($("#form-submit").removeAttr('disabled', 'disabled'), $("#form-submit").val('Оплатить'))), a(t, r)
    }, tcsPay.onFail = function (e, t, r, s) {
        window.trnTcs ? window.trnTcs._get().then(function (e) {
            var t = window.trnTcs._lngCol[e].trnslt;
            s === TcsUrl.FINISH_AUTORIZE_URL && ($("#form-submit").removeAttr('disabled', 'disabled'), $("#form-submit").val(t.doPay)), a(t.opCancel, t.serverDown)
        }, function (e) {
            throw e
        }) : (s === TcsUrl.FINISH_AUTORIZE_URL && ($("#form-submit").removeAttr('disabled', 'disabled'), $("#form-submit").val('Оплатить')), a('Операция отклонена', 'Ошибка соединения с сервером банка'))
    };
    var r = parseInt($('#card__summ').text());
    $("#card__summ").html(Math.floor(parseInt(r) / 100) + '<span class="card__summ_small">,' + String(r).substring(String(r).length - 2) + ' <div class="images__rub"></div></span>');
    var s = new Array, n = new Array, m = new Array, o = decodeURIComponent(location.search);
    if ('' != o) for (s = o.substr(1).split('&'), i = 0; i < s.length; i++) m[(n = s[i].split('='))[0]] = n[1];
    var l = m.Message ? m.Message.replace(/\+/g, ' ') : '', d = m.Details ? m.Details.replace(/\+/g, ' ') : '';
    $('.form-reject__head_get').text(l), $('.form-reject__text_get').text(d)
}

var tcsPay;
$(document).ready(function () {
    var e = $('.js-notice-info'), t = $('.js-agreement'), a = $('.js-agreement-inside'), r = $('.js-info-close'),
        s = $('body');
    e.on('click', function (e) {
        t.css('display', 'block'), e.stopPropagation()
    }), r.on('click', function () {
        t.css('display', '')
    }), s.on('click', function () {
        t.css('display', '')
    }), a.on('click', function (e) {
        e.stopPropagation()
    }), $('#form-card-number-input').val() && $('.form-card-number__label').addClass('form-label_active'), $('#form-month-input').val() && $('.form-date__label_month').addClass('form-label_active'), $('#form-year-input').val() && $('.form-date__label_year').addClass('form-label_active'), $('#form-cvc-input').val() && $('.form-cvc__label').addClass('form-label_active')
});