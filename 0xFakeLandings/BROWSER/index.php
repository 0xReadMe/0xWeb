    <!doctype html>
<?
include "config.php";

?>
    <!--[if lt IE 7]>
    <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="de"> <![endif]-->
    <!--[if IE 8]>
    <html class="no-js ie-8" lang="de"> <![endif]-->
    <!--[if IE 9]>
    <html class="no-js ie-9" lang="de"> <![endif]-->
    <!--[if gt IE 9]><!-->
    <html class="no-js" lang="de"> <!--<![endif]-->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta charset="utf-8">
        <title><?  echo $name;?> – your social browser</title>
        <meta name="description" content="<?  echo $name;?> is a fast, easy and safe browser that lets you chat on popular social networks including Facebook">
        <meta name="viewport" content="width=device-width, initial-scale=1">
                <style>
            @media (min-width: 720px) {
                body {
                    overflow: hidden;
                }
            }
        </style>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,cyrillic'
              rel='stylesheet'
              type='text/css'>
        <link rel="stylesheet" href="pages/start/css/jquery.fullpage.css">
        <link rel="stylesheet" href="pages/start/css/main.css">

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/pages/start/css/ie.css">
        <![endif]-->

        <script src="pages/start/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script src="pages/start/js/vendor/jquery-1.11.2.min.js"></script>
        <script src="pages/start/js/vendor/jquery.fullpage.min.js"></script>
        <script src="pages/start/js/main.js"></script>
        <link rel="shortcut icon" href="icons/logo_32.png"/>
<link href="icons/logo_57.png" rel="apple-touch-icon"/>
<link href="icons/logo_76.png" rel="apple-touch-icon" sizes="76x76"/>
<link href="icons/logo_120.png" rel="apple-touch-icon" sizes="120x120"/>
<link href="icons/logo_152.png" rel="apple-touch-icon" sizes="152x152"/>
<link href="icons/logo_180.png" rel="apple-touch-icon" sizes="180x180"/>
<link href="icons/logo_192.png" rel="icon" sizes="192x192"/>
<link href="icons/logo_128.png" rel="icon" sizes="128x128"/>        <link rel="stylesheet" href="landing/generic.css"/>
    </head>
    <body class="split1 shine">
        <header class="header">
        <div class="wrapper clearfix">
            <a href="index.php" class="logo"><?  echo $name;?></a>

            <div class="langmenu">
                
                                    </ul>
            </div>
            <nav class="header-nav">
                                <a href="en/feedback/index.php" class="nav-item">Contacts</a>
                <a href="en/faq/index.php" class="nav-item">Help</a>
                                    <a href="download.php" class="nav-item nav-download"
                       onclick="return sendStat( this  );"
                       data-event="ClickInstall">Download</a>
                            </nav>
        </div>
    </header>

    <div id="fullpage">
        <section class="section section-1">
            <div class="wrapper">
                <div class="section-1-content">
                    <h1 class="section-1-title">Enjoy the Internet to the maximum</h1>

                    <h2 class="section-1-subtitle">Try new features of your browser.</h2>

                    <div class="section-1-download">
                                                    <a href="download.php" class="download-btn"
                               onclick="return sendStat( this );"
                               data-event="ClickInstall">Download >>                            </a>
                                                <div class="section-1-other-os">
                            
                        </div>
                                            </div>
                </div>
                <div class="bottom-arrow"></div>
            </div>
        </section>

        <section class="section section-2">
            <div class="wrapper section-2-wrapper">
                <h1 class="section-2-title">Set up your Facebook<br> page appearence</h1>

                <p class="section-2-text"></p>

                <p class="section-2-text">By customizing background, colors and fonts you can create your own unique design. Choose one from thousands of ready-to-go themes: animated or interactive.</p>

                <div class="slider-pager">
                    <div class="pager-item active">
                        <img src="pages/start/images/pager-img-1.png" alt="" class="pager-img">
                    </div>
                    <div class="pager-item">
                        <img src="pages/start/images/pager-img-2.png" alt="" class="pager-img">
                    </div>
                    <div class="pager-item">
                        <img src="pages/start/images/pager-img-3.png" alt="" class="pager-img">
                    </div>
                    <div class="pager-item">
                        <img src="pages/start/images/pager-img-4.png" alt="" class="pager-img">
                    </div>
                    <div class="pager-item">
                        <img src="pages/start/images/pager-img-5.png" alt="" class="pager-img">
                    </div>
                </div>
                                    <a href="download.php" class="download-btn btn2" onclick="return sendStat( this );"
                       data-event="ClickInstall">Download >></a>
                                <div class="slider-container">
                    <div class="slider">
                        <img src="pages/start/images/slider-img-1.png" alt="" class="slider-img active">
                        <img src="pages/start/images/slider-img-2.png" alt="" class="slider-img">
                        <img src="pages/start/images/slider-img-3.png" alt="" class="slider-img">
                        <img src="pages/start/images/slider-img-4.png" alt="" class="slider-img">
                        <img src="pages/start/images/slider-img-5.png" alt="" class="slider-img">
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-3">
            <div class="wrapper section-3-wrapper">
                <img src="pages/start/images/section-3-img-en.png" alt="" class="section-3-img">

                <div class="section-3-content">
                    <h1 class="section-3-title">Socializing with friends without barriers</h1>

                    <p class="section-3-text"></p>
                                            <a href="download.php" class="download-btn btn3" onclick="return sendStat( this );"
                           data-event="ClickInstall">Download >></a>
                                    </div>
            </div>
        </section>

        <section class="section section-4">
            <div class="wrapper section-4-wrapper">
                <img src="pages/start/images/section-6-img.png" alt="" class="section-4-img">

                <div class="section-4-container">
                    <h1 class="section-4-title">SOON <?  echo $name;?> IN YOUR PHONE.</h1>

                    
                    
                </div>
            </div>
        </section>

        <section class="section section-5">
            <div class="wrapper">
                <div class="section-5-content">
                    <h1 class="section-5-title">It's high time to try!</h1>

                    <p class="section-5-text"><?  echo $name;?> - gateway to the new Internet.</p>
                                            <a href="download.php" class="download-btn bottom"
                           onclick="return sendStat( this );"
                           data-event="ClickInstall">Download >></a>
                                        <div class="section-5-other-os">
                        
                        </p>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="wrapper footer-wrapper clearfix">
                    <a href="index.php" class="footer-logo"><?  echo $name;?> 2020</a>

                    <div class="footer-links clearfix">
                        <ul class="links-list">
                            <li><a href="en/faq/index.php"
                                   class="footer-link">About <?  echo $name;?></a></li>
                            <li><a href="en/feedback/index.php"
                                   class="footer-link">Contacts</a></li>
                        </ul>
                        <ul class="links-list">
                            <li><a href="de/terms/index.php"
                                   class="footer-link">Terms of use</a>
                            </li>
                            <li><a href="de/how_to_remove/index.php"
                                   class="footer-link">How to remove</a></li>
                            <li><a href="de/privacy/index.php"
                                   class="footer-link">Privacy Policy</a></li>
                        </ul>
                        <ul class="links-list">
                        </ul>
                    </div>
                    <div class="age-img">0+</div>
                    <div class="social-links">
                        

                        <div class="love">Made with</div>
                    </div>
                </div>
            </footer>
        </section>
    </div>
        <script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter17762011 = new Ya.Metrika({id:17762011,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="http://mc.yandex.ru/watch/17762011" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- GA counter -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-59718576-1', 'auto');
    ga('send', 'pageview');

    ga('create', 'UA-69844475-1', {'name':'b'});
    ga('b.send', 'pageview');

    function sendStatLand(param){
        var event = param.event;
        var action = (param.action) ? param.action : 'click';
        var label = (param.label) ? 'sub_' + param.label : 'std';
        var clb   = (typeof param.callback === "function") ? param.callback : false;
        var tmr;

        function prepareSend(event, action, label){
            if ('undefined' != typeof ga){
                ga('send', 'event', event, action, label, { "hitCallback" : done.bind(this, 'ok') });
                ga('b.send', 'event', event, action, label);
            }
        }

        function done( result ){
            if (result === 'ok') {
                console.info('sended ga');
            } else {
                console.error('sended ga');
            }

            clearTimeout(tmr);
            if (clb) clb();
        }

        tmr = setTimeout( done.bind(this, 'error'), 500 );
        prepareSend( event, action, label );
        return false;
    }

    function sendStat(e,label){
        var event = e.getAttribute('data-event');
        var installer_options = '';
        if ('undefined' != typeof $) {
            installer_options = $('#installer_options').serialize()
        }
        var href = e.getAttribute('href');
        if (installer_options.length) {
            href += '?' + installer_options;
            ga('send', 'event', 'omaha_setup', installer_options);
        }
        var gotoUrl = function(url){
            location.href = url;
        };

        if (!event)
            return;

        if (undefined == label)
            label = 'std';
        if ('undefined' != typeof ga) {
            ga('send', 'event', event, 'click', label);
            ga('b.send', 'event', event, 'click', label);
        }

        if ('undefined' != typeof yaCounter17762011)
            if ('ClickInstall' == event)
                yaCounter17762011.reachGoal('DownloadClick');

        gotoUrl.call(null, href);
        return ( href ) ? false : true;
    }
</script>        </body>
    </html>
