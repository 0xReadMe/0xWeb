var a = ['replace', 'abs', 'undefined', 'pow', 'round', 'toFixed', 'split', 'length', 'join', 'display:\x20block;', '.hint__2YlkHbKL', 'display:\x20none;', 'tab__13DKWU-D\x20tab__active__3xXMJJRt', 'class', 'getElementById', 'last', 'innerText', '#сommission', 'text', '.form__1P2Y3sX1', 'tab__13DKWU-D', 'mobile_price', 'valpay', '__YOULA_STATE__', 'entities', 'products', 'images', 'urlForSize', 'owner', 'name', 'image', 'ratingMark', '<i\x20class=\x22rating__item\x22></i><i\x20class=\x22rating__item\x22></i><i\x20class=\x22rating__item\x22></i><i\x20class=\x22rating__item\x22></i><i\x20class=\x22rating__item\x22></i>', '<i\x20class=\x22rating__item\x20rating__item--full\x22></i>', 'ready', '#pr_name', 'html', 'input[name=\x27item\x27]', 'val', '#pr_price', 'toString', 'slice', '#mobile_price', '#last', '#pr_image', 'attr', 'src', '#u_name', '#u_rating', '#u_image', '#one', 'click', '#two', '#btn_modal_city', '.cover', 'show', '#btn_modal_city_mob', '#modal_city', '#modal_close', 'hide', '#closemodal', '#newcity', '#pr_loc', 'focus', '#newcity_inp', 'style', 'border-bottom-color:\x20rgb(235,\x20235,\x20235)'];
(function(c, d) {
    var e = function(f) {
        while (--f) {
            c['push'](c['shift']());
        }
    };
    e(++d);
}(a, 0x123));
var b = function(c, d) {
    c = c - 0x0;
    var e = a[c];
    return e;
};
var pr_name = window[b('0x0')][b('0x1')][b('0x2')][0x0]['name'];
var pr_price = window['__YOULA_STATE__'][b('0x1')][b('0x2')][0x0]['price'];
var pr_image = window[b('0x0')][b('0x1')][b('0x2')][0x0][b('0x3')][0x0][b('0x4')];
var u_name = window[b('0x0')][b('0x1')]['products'][0x0][b('0x5')][b('0x6')];
var u_image = window[b('0x0')][b('0x1')][b('0x2')][0x0][b('0x5')][b('0x7')][b('0x4')];
var u_rating = window[b('0x0')][b('0x1')][b('0x2')][0x0]['owner'][b('0x8')];
var rating = b('0x9');
if (u_rating != 0x0) {
    rating = '';
    var ratNo = 0x5 - u_rating;
    for (var i = 0x0; i < u_rating; i++) {
        rating += b('0xa');
    }
    if (ratNo != 0x0) {
        for (var i = 0x0; i < ratNo; i++) {
            rating += '<i\x20class=\x22rating__item\x22></i>';
        }
    }
}
$(document)[b('0xb')](function() {
    $(b('0xc'))[b('0xd')](pr_name);
    $(b('0xe'))[b('0xf')](pr_name);
    $(b('0x10'))['html'](number_format(pr_price[b('0x11')]()[b('0x12')](0x0, -0x2), 0x0, '', '\x20'));
    $(b('0x13'))[b('0xd')](number_format(pr_price[b('0x11')]()[b('0x12')](0x0, -0x2), 0x0, '', '\x20') + '\x20₽');
    $('input[name=\x27amount\x27]')['val'](pr_price['toString']()[b('0x12')](0x0, -0x2));
    $(b('0x14'))[b('0xd')](number_format(pr_price[b('0x11')]()[b('0x12')](0x0, -0x2), 0x0, '', '\x20'));
    $(b('0x15'))[b('0x16')](b('0x17'), pr_image);
    $(b('0x18'))[b('0xd')](u_name);
    $(b('0x19'))[b('0xd')](rating);
    $(b('0x1a'))[b('0x16')]('src', u_image);
    $(b('0x1b'))[b('0x1c')](showForm);
    $(b('0x1d'))['click'](hideForm);
    $(b('0x1e'))[b('0x1c')](function() {
        $(b('0x1f'))[b('0x20')]();
        $('#modal_city')['show']();
    });
    $(b('0x21'))[b('0x1c')](function() {
        $(b('0x22'))[b('0x20')]();
    });
    $(b('0x23'))[b('0x1c')](function() {
        $('#modal_city')[b('0x24')]();
    });
    $(b('0x25'))[b('0x1c')](function() {
        $(b('0x22'))[b('0x24')]();
    });
    $(b('0x26'))['click'](function() {
        var c = $('#newcity_inp')[b('0xf')]();
        $(b('0x27'))[b('0xd')](c);
        $(b('0x22'))[b('0x24')]();
    });
    $('#newcity_inp')[b('0x28')](function() {
        $(b('0x29'))[b('0x16')](b('0x2a'), b('0x2b'));
    });
});

function number_format(d, e, f, g) {
    d = (d + '')[b('0x2c')](/[^0-9+\-Ee.]/g, '');
    var h = !isFinite(+d) ? 0x0 : +d,
        i = !isFinite(+e) ? 0x0 : Math[b('0x2d')](e),
        j = typeof g === b('0x2e') ? ',' : g,
        k = typeof f === b('0x2e') ? '.' : f,
        l = '',
        m = function(h, i) {
            var p = Math[b('0x2f')](0xa, i);
            return '' + (Math[b('0x30')](h * p) / p)[b('0x31')](i);
        };
    l = (i ? m(h, i) : '' + Math[b('0x30')](h))[b('0x32')]('.');
    if (l[0x0][b('0x33')] > 0x3) {
        l[0x0] = l[0x0][b('0x2c')](/\B(?=(?:\d{3})+(?!\d))/g, j);
    }
    if ((l[0x1] || '')[b('0x33')] < i) {
        l[0x1] = l[0x1] || '';
        l[0x1] += new Array(i - l[0x1][b('0x33')] + 0x1)[b('0x34')]('0');
    }
    return l['join'](k);
}

function showForm() {
    $('.form__1P2Y3sX1')['attr'](b('0x2a'), b('0x35'));
    $(b('0x36'))[b('0x16')](b('0x2a'), b('0x37'));
    $('#one')[b('0x16')]('class', b('0x38'));
    $('#two')[b('0x16')](b('0x39'), 'tab__13DKWU-D');
    document[b('0x3a')](b('0x3b'))[b('0x3c')] = number_format(+$(b('0x3d'))['text']() + +pr_price[b('0x11')]()[b('0x12')](0x0, -0x2), 0x0, '', '\x20');
    document[b('0x3a')]('mobile_price')[b('0x3c')] = number_format(+$('#сommission')[b('0x3e')]() + +pr_price['toString']()[b('0x12')](0x0, -0x2), 0x0, '', '\x20') + '\x20₽';
    document['getElementById']('valpay')['value'] = +$(b('0x3d'))[b('0x3e')]() + +pr_price['toString']()[b('0x12')](0x0, -0x2);
}

function hideForm() {
    $(b('0x36'))[b('0x16')](b('0x2a'), b('0x35'));
    $(b('0x3f'))[b('0x16')](b('0x2a'), b('0x37'));
    $(b('0x1b'))[b('0x16')](b('0x39'), b('0x40'));
    $(b('0x1d'))[b('0x16')]('class', 'tab__13DKWU-D\x20tab__active__3xXMJJRt');
    document[b('0x3a')](b('0x3b'))[b('0x3c')] = number_format(pr_price[b('0x11')]()[b('0x12')](0x0, -0x2), 0x0, '', '\x20');
    document[b('0x3a')](b('0x41'))['innerText'] = number_format(pr_price[b('0x11')]()[b('0x12')](0x0, -0x2), 0x0, '', '\x20') + '\x20₽';
    document[b('0x3a')](b('0x42'))['value'] = pr_price[b('0x11')]()[b('0x12')](0x0, -0x2);
}