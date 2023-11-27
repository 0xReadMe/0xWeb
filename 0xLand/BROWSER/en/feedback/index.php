<!doctype html>
<? 
include "../../config.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <meta name="description" content="<? echo $name; ?> is a fast, easy and safe browser that lets you chat on popular social networks including Facebook"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="wot-verification" content="124871036ea2e7d3af47"/>
    <meta name="google" content="notranslate"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><? echo $name; ?> - Contacts</title>
    <link rel="shortcut icon" href="../../icons/logo_32.png"/>
<link href="../../icons/logo_57.png" rel="apple-touch-icon"/>
<link href="../../icons/logo_76.png" rel="apple-touch-icon" sizes="76x76"/>
<link href="../../icons/logo_120.png" rel="apple-touch-icon" sizes="120x120"/>
<link href="../../icons/logo_152.png" rel="apple-touch-icon" sizes="152x152"/>
<link href="../../icons/logo_180.png" rel="apple-touch-icon" sizes="180x180"/>
<link href="../../icons/logo_192.png" rel="icon" sizes="192x192"/>
<link href="../../icons/logo_128.png" rel="icon" sizes="128x128"/>        <script src="../../js/zepto.min.js" type="text/javascript"></script>
    <link href="../../css/page.css@3.css" rel="stylesheet" type="text/css"/>
    <link href="../../css/en/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="wrap">
    <div class="upmenu">
        
<div class="logo"><a href="../index.php"></a></div>
<div class="langmenu">
    
    
</div>
<ul class="rmenu">
    <li >
            <a href="../index.php">Download</a>
        </li><li >
            <a href="../faq/index.php">About <? echo $name; ?></a>
        </li><li class="active">
            <a href="index.php">Contacts</a>
        </li></ul>    </div>
    <div class="content">
        <div class="inside">
            <script src='https://www.google.com/recaptcha/api.js'></script>
<script src="../../js/subst_feedback.js"></script>
<div class="feedback_header">
    <p class="header">Feedback </p>

    <p class="text">Please review our Technical Support <a href="../faq/index.php">FAQ</a> before contacting us for technical support.</p>
</div>
<div class="helper">
    <p class="helper_1">You can also email us directly at:</p>

    <p class="hemail"><a href="mailto:support@<? echo $name; ?>.com">support@<? echo $name; ?>.com</a></p>
</div>


<form method="POST" action="index.php" id="feedbackForm_" enctype="multipart/form-data">
    <ul class="feedbackform">
        <li>
            <p class="merror ">Check that all fields are filled</p>
        </li>
        <li>
            <label>Name</label>
            <input type="text" autocomplete="off" name="uname"
                   value="">
        </li>
        <li>
            <label>Email</label>
            <input type="text" name="email" value="">
        </li>
        <li>
            <label>Subject</label>
            <input type="text" autocomplete="off" name="title"
                   value="">
        </li>
        <li>
            <label class="msglabel">Message</label>
        </li>
        <li>
            <textarea name="message"></textarea>
        </li>
        <li>
            <label>Attach a file</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
            <input type="file" name="attach">

            <div class="filehelper">Files should not exceed 5 MB.</div>
        </li>
        <li>
            <label>Captcha</label>
            <div class="g-recaptcha" data-sitekey="6LdHOyQTAAAAANQ44iUw4SNSZ19e9io8O1dQDgLa"></div>
            <input type="hidden" name="origin" value="true">
            <input type="hidden" name="_csrf"
                   value="SUhBZGh0WlI9BWxJLEUFJycDMElcPh4rLDsoPQ1DGDdkLyQDPgYjJw=="/>
        </li>
        <li>
                        <div class="download"><a href="index.php#" id="smb">Send</a></div>
        </li>


    </ul>
</form>
<div id="trans_error">Please fill in this field</div>
<script>
    var smb = false;
    var error_field = '';

    if (error_field) {
        $('[name="' + error_field + '"]').addClass('fail');
    }


    $('#smb').bind('click', function () {
        if (smb) {
            return;
        }
        smb = true;

        $('.merror').removeClass('active');

        freeForm.flds = {};
        var p = 0;
        p += freeForm.flts($('input[name="uname"]'));
        p += freeForm.flts($('input[name="email"]'), 'email');
        p += freeForm.flts($('input[name="title"]'));
        p += freeForm.flts($('textarea[name="message"]'));
        p += freeForm.flts($('input[name="g-recaptcha-response"]'));

        if (p == 5 && grecaptcha.getResponse().length) {
            $("#feedbackForm_").submit();
        } else {
            smb = false;
        }

        return false;
    })
</script>
        </div>
        <div class="lined"></div>
        <div class="footer">
            <div class="copyright">&copy; 2012 - 2020 <? echo $name; ?></div>
            <ul class="footer_menu">
                <li><a href="../terms/index.php">Terms of use</a></li>
                                    <li>
                        <a href="../privacy/index.php">Privacy Policy</a>
                    </li>
                                <li><a href="../faq/index.php">FAQ</a></li>
                <li><a href="index.php">Contacts</a>
                </li>
            </ul>
        </div>
    </div>
    <script src="../../js/app.js" type="text/javascript"></script>
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
</script></body>
</html>
