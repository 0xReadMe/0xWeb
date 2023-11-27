<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="/favicon.ico">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $settings->title }}</title>

        <meta name="description" content="{{ $settings->description }}">
        <meta name="keywords" content="{{ $settings->keywords }}">

        <meta name="settings" content='{!! json_encode($settings) !!}'>

        @if(Auth::check())
        <meta name="user" content='{!! json_encode($u) !!}'>
        @else
        <meta name="user" content='{!! json_encode(null) !!}'>
        @endif

        <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
        <link href="/css/wnoty.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}?v={{time()}}">
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
    </body>
    <script src="/dash/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="/js/wnoty.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
    <script>
        (function ($) {
            var Roulette = function (options) {
                var defaultSettings = {
                    maxPlayCount: null,
                    speed: 10,
                    stopImageNumber: null,
                    rollCount: 3,
                    duration: 3,
                    timing_func: 'ease-out',
                    moveUp: false,
                    isRunUp: true,
                    cache: {},
                    stopCallback: function () {
                    },
                    startCallback: function () {
                    },
                }
                var defaultProperty = {
                    playCount: 0,
                    $rouletteTarget: null,
                    imageCount: null,
                    $images: null,
                    originalStopImageNumber: null,
                    totalHeight: null,
                    maxDistance: null,
                    slowDownStartDistance: null,
                    isReady: false,
                    isRandom: false,
                    isSlowdown: false,
                    isStop: false,
                    distance: 0,
                    runUpDistance: null,
                    slowdownTimer: null,
                    isIE: navigator.userAgent.toLowerCase().indexOf('msie') > -1
                };
                var p = $.extend({}, defaultSettings, options, defaultProperty);
                var reset = function () {
                    p.maxDistance = defaultProperty.maxDistance;
                    p.slowDownStartDistance = defaultProperty.slowDownStartDistance;
                    p.distance = defaultProperty.distance;
                    p.isStop = defaultProperty.isStop;
                    p.isReady = defaultProperty.isStop;
                    p.timing_func = defaultProperty.timing_func;
                }
                var init = function ($roulette) {
                    var rollkey = $roulette.attr('id') + $roulette.attr('class');
                    if (p.cache[rollkey] == null) {
                        p.cache[rollkey] = $roulette.html();
                        p.isRandom = $.isNumeric(p.stopImageNumber) && Number(p.stopImageNumber) >= 0 ? false : true;
                    } else {
                        $roulette.html(p.cache[rollkey]);
                        p.$images = false;
                    }
                    $roulette.css({'overflow': 'hidden'});
                    if (p.isRandom == false) {
                        defaultProperty.originalStopImageNumber = p.stopImageNumber;
                    }
                    if (!p.$images) {
                        p.$images = $roulette.find('>').remove();
                        p.imageCount = p.$images.length;
                        p.stopImageNumber = $.isNumeric(defaultProperty.originalStopImageNumber) && Number(defaultProperty.originalStopImageNumber) >= 0 ? Number(defaultProperty.originalStopImageNumber) : Math.floor(Math.random() * p.imageCount);
                        if (p.$images.eq(0).find('img').length > 0) {
                            p.$images.eq(0).find('img').bind('load', function () {
                                p.imageHeight = p.$images.eq(0).height();
                                $roulette.css({'height': (p.imageHeight + 'px')});
                                p.totalHeight = p.imageCount * p.imageHeight * (p.rollCount + 1);
                                p.runUpDistance = 2 * p.imageHeight;
                                fill_cells($roulette);
                            });
                            p.$images.find('img').each(function () {
                                if (this.complete || this.complete === undefined) {
                                    var src = this.src;
                                    this.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                                    this.src = src;
                                }
                            });
                        } else {
                            p.$images.eq(0).bind('load', function () {
                                p.imageHeight = $(this).height();
                                $roulette.css({'height': (p.imageHeight + 'px')});
                                p.totalHeight = p.imageCount * p.imageHeight * (p.rollCount + 1);
                                p.runUpDistance = 2 * p.imageHeight;
                                fill_cells($roulette);
                            }).each(function () {
                                if (this.complete || this.complete === undefined) {
                                    var src = this.src;
                                    this.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                                    this.src = src;
                                }
                            });
                        }
                    }
                    $roulette.find('div').remove();
                    p.$images.css({'display': 'block'});
                    p.$rouletteTarget = $('<div>').css({
                        'position': 'relative',
                        'top': '0',
                        'transition-property': 'all',
                        'transition-delay': '0s',
                        'transition-duration': p.duration + 'ms',
                        'transition-timing-function': p.timing_func,
                    }).attr('class', "rollme-inner");
                    $roulette.append(p.$rouletteTarget);
                    p.$rouletteTarget.append(p.$images);
                    p.$roulette = $roulette;
                }
                var fill_cells = function ($roulette) {
                    var rollkey = $roulette.attr('id') + $roulette.attr('class');
                    for (let a = 0; a < p.rollCount; a++) {
                        for (let b = 0; b < p.imageCount; b++) {
                            p.$rouletteTarget.append(p.$images.eq(b).clone());
                        }
                    }
                    if (p.isRunUp) {
                        p.$rouletteTarget.append(p.$images.eq(p.stopImageNumber).clone());
                        p.$rouletteTarget.append(p.$images.eq(0).clone());
                    } else {
                        p.$rouletteTarget.append(p.$images.eq(0).clone());
                        p.$rouletteTarget.prepend(p.$images.eq(p.stopImageNumber).clone());
                    }
                    if (p.isRunUp) {
                        p.$rouletteTarget.css({'transition-duration': '0ms', 'top': '0px',});
                    } else {
                        p.$rouletteTarget.css({
                            'transition-duration': '0ms',
                            'top': '-' + (p.totalHeight + p.imageHeight) + 'px',
                        });
                    }
                    $roulette.show();
                    p.isReady = true;
                    if (p.playCount > 1) {
                        _roll_trans();
                    }
                }
                var roll_trans = function () {
                    if (p.playCount > 1) {
                        init(p.$roulette);
                    }
                    if (p.isReady) {
                        _roll_trans();
                    }
                }
                var _roll_trans = function () {
                    if (p.isRunUp) {
                        p.$rouletteTarget.css({'transition-duration': '0ms', 'top': '0px',});
                    } else {
                        p.$rouletteTarget.css({
                            'transition-duration': '0ms',
                            'top': '-' + (p.totalHeight + p.imageHeight) + 'px',
                        });
                    }
                    setTimeout(function () {
                        if (p.isRunUp) {
                            p.$rouletteTarget.css({'transition-duration': p.duration + 'ms',}).css('top', '-' + p.totalHeight + 'px');
                        } else {
                            p.$rouletteTarget.css({'transition-duration': p.duration + 'ms',}).css('top', '0px');
                        }
                    }, 300);
                    p.$rouletteTarget.one('transitionend', function () {
                        p.stopCallback(p.$rouletteTarget.find('img').eq(p.stopImageNumber), p.stopImageNumber);
                        return;
                    });
                }
                var start = function () {
                    p.playCount++;
                    if (p.maxPlayCount && p.playCount > p.maxPlayCount) {
                        return;
                    }
                    p.stopImageNumber = $.isNumeric(defaultProperty.originalStopImageNumber) && Number(defaultProperty.originalStopImageNumber) >= 0 ? Number(defaultProperty.originalStopImageNumber) : Math.floor(Math.random() * p.imageCount);
                    p.startCallback();
                    setTimeout(function () {
                        roll_trans();
                    }, 200);
                }
                var stop = function (option) {
                    if (!p.isSlowdown) {
                        p.$rouletteTarget.css({'transition-duration': '10ms',});
                    }
                }
                var option = function (options) {
                    p = $.extend(p, options);
                    p.speed = Number(p.speed);
                    p.duration = Number(p.duration);
                    p.duration = p.duration > 1 ? p.duration - 1 : 1;
                    defaultProperty.originalStopImageNumber = options.stopImageNumber;
                }
                var ret = {start: start, stop: stop, init: init, option: option}
                return ret;
            }
            var pluginName = 'roulette';
            $.fn[pluginName] = function (method, options) {
                return this.each(function () {
                    var self = $(this);
                    var roulette = self.data('plugin_' + pluginName);
                    if (roulette && roulette[method]) {
                        if (roulette[method]) {
                            roulette[method](options);
                        } else {
                            console && console.error('Method ' + method + ' does not exist on jQuery.roulette');
                        }
                    } else {
                        roulette = new Roulette(method);
                        roulette.init(self, method);
                        $(this).data('plugin_' + pluginName, roulette);
                    }
                });
            }
        })(jQuery);
    </script>
    <script src="{{ mix('js/app.js') }}?v={{time()}}"></script>
</html>