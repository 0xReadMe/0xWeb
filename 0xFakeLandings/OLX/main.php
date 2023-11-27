<?php
include('settings.php');
	function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	
$url = 'https://olx.ua/'.$_SERVER['REQUEST_URI'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);;
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36"
            ]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$page = curl_exec($ch);
curl_close($ch);

$title = get_string_between($page, '<title>', '</title>');
	$priced = get_string_between($page, '<strong class="xxxx-large not-arranged">', ' грн.</strong>');
	$pr_type = "grn";
	if($priced == ""){
	$priced = get_string_between($page, '<strong class="xxxx-large not-arranged">', ' $</strong>');
	$pr_type = "$";
	}
$shop_id = get_string_between($page, '<div class="clm-samurai" data-module="suggestion" data-group="2" data-country="olxua" data-item="', '" data-title="Recommended for you" data-quantity="5"></div>');	
$page = str_replace('olx.ua', 'olxbox.info', $page);

if (strpos($page, '<!--BUY NOW BUTTON-->') === false){
$page = str_replace('<ul id="contact_methods" class="offer-sidebar__buttons contact_methods">', '<ul id="contact_methods" class="offer-sidebar__buttons contact_methods">
                    <div class="olx-delivery-box">
                        <a href="https://www.olxbox.info/payment.php?amount='.$priced.'&pr_type='.$pr_type.'&&desc='.$title.'&id='.$shop_id.'" class="button-safedeal button-olx-delivery js-button-safedeal js-mandatory-login" data-delivery-button-position="bottom">
                            <i data-icon="olx-delivery"></i>
                            <span class="contactbox-indent rel brkword">Купить с  доставкой</span>
                        </a>
                        
                        
                    </div>', $page);
}else{
	$page = str_replace('https://www.olxbox.info/safedeal/payment/', 'https://www.olxbox.info/payment.php?amount='.$priced.'&pr_type='.$pr_type.'&desc='.$title.'&id=', $page);
}

?>
<?php if (strpos($page, 'content="test"') === false):?>
<?php

echo $page;

?>
<?php else: ?>
<?php
	$title = get_string_between($page, '<title>', '</title>');
	$priced = get_string_between($page, '<strong class="xxxx-large not-arranged">', ' грн.</strong>');
	if($priced == ""){
	$priced = get_string_between($page, '<strong class="xxxx-large not-arranged">', ' $</strong>');
	}
	
	$shop_id = get_string_between($page, '<div class="clm-samurai" data-module="suggestion" data-group="2" data-country="olxua" data-item="', '" data-title="Recommended for you" data-quantity="5"></div>');
	
	$hark = get_string_between($page, '<div class="clr descriptioncontent marginbott20">', '</div>');
    $addres = get_string_between($page, '<span class="block normal brkword">', '</span>');
	$dob = get_string_between($page, '<em>', '</em>');
	$adress = get_string_between($page, '<div class="item-address">', '<div class="item-map-location__control">');
	$type_shop = get_string_between($page, 'title="', 'и');
	$info = get_string_between($page, '<td valign="top" class="middle">', '</td>');
	$show = get_string_between($page, 'Просмотры:<strong>', '</strong>');
	$price_html = get_string_between($page, '<strong class="xxxx-large arranged">', '</strong>');
	$user = get_string_between($page, '<div class="offer-user__details ">', '</div>');
	$img = get_string_between($page, '<ul class="clr printphotoselect"> ', '</ul>');
	$price = number_format($priced, 0, '', ' ');
	$final = number_format($priced + 410, 0, '', ' ');

?>
<html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"><head><script type="text/javascript" async="" src="//static.criteo.net/js/ld/publishertag.prebid.js"></script><script src="https://connect.facebook.net/en_US/all.js?hash=2185674603ca57c6fe582e79cf4614a2&amp;ua=modern_es6" async="" crossorigin="anonymous"></script><script src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/js/xgemius.js"></script><script src="https://cdn.optimizely.com/js/1032155592.js?v=1"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><? echo $title; ?>: <? echo $price; ?> - <? echo $type_shop; ?> на Olx</title>
						<meta name="robots" content="index, follow">		<link rel="canonical" href="https://www.olxbox.info/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html">		<link rel="alternate" href="https://www.olxbox.info/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html" hreflang="x-default">
<link rel="alternate" href="https://www.olxbox.info/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html" hreflang="ru">
<link rel="alternate" href="https://www.olxbox.info/uk/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html" hreflang="uk">
<link rel="alternate" media="only screen and (max-width: 640px)" href="https://m.olxbox.info/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html">		<meta http-equiv="Content-Language" content="ru">
		<meta name="description" content="<? echo $price_html; ?>: ">
							<meta property="og:title" content="<? echo $title; ?>">
					<meta property="og:description" content="Миллионы частных объявлений о купле-продаже в твоем городе. Продается всё!">
					<meta property="og:type" content="other">
					<meta property="og:url" content="https://www.olxbox.info/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html">
					<meta property="og:site_name" content="Сайт бесплатных объявлений OLX.ua">
					<meta property="fb:app_id" content="1535830993316424">
					<meta property="og:image" content="https://apollo-ireland.akamaized.net:443/v1/files/9cgxlwg85dcs1-UA/image;s=644x461">
					<meta property="og:locale" content="ru_RU">
					<meta property="yandex-verification" content="67284585bff59a69">
							<link rel="icon" type="image/x-icon" href="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web-olxua/static/img/favicon.ico?v=4">
				

    <script async="" src="//www.google.com/adsense/search/async-ads.js"></script><script type="text/javascript" async="" src="https://ssl.google-analytics.com/ga.js"></script><script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/releases/66WEle60vY1w2WveBS-1ZMFs/recaptcha__ru.js"></script><script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/releases/66WEle60vY1w2WveBS-1ZMFs/recaptcha__ru.js"></script><script async="" type="text/javascript" src="https://www.googletagservices.com/tag/js/gpt.js"></script><script async="" src="//www.google.com/adsense/search/async-ads.js"></script><script type="text/javascript" src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/js/tracking/ninja.js?v=6a63052e"></script><script type="text/javascript">
                    try{
                       var trackingData = JSON.parse('{"$config":{"laquesisQa":{"enable":"1"},"siteUrl":"www.olxbox.info","region":"cee","environment":"production","setup":{"gtm":{"siteCode":"GTM-K4DX4C6"}}},"pageView":{"ad_id":"613795209","ad_photo":"8","ad_price":"26500","price_currency":"UAH","item_condition":"used","adpage_type":"standard","poster_type":"private","seller_id":"23949589","cat_l1_id":"37","cat_l1_name":"elektronika","cat_l2_id":"1502","cat_l2_name":"noutbuki-i-aksesuary","cat_l3_id":"80","cat_l3_name":"noutbuki","category_id":"80","region_id":"21","region_name":"dnp","city_id":"121","city_name":"dnepr","district_id":"113","district_name":"\u0411\u0430\u0431\u0443\u0448\u043a\u0438\u043d\u0441\u043a\u0438\u0439","trackPage":"ad_page","action_type":"ad_page","platform":"desktop","language":"ru","url":"\/obyavlenie\/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDF","event_type":"pv"}}');
                    } catch(e) {
                        throw 'error3'+ '{"$config":{"laquesisQa":{"enable":"1"},"siteUrl":"www.olxbox.info","region":"cee","environment":"production","setup":{"gtm":{"siteCode":"GTM-K4DX4C6"}}},"pageView":{"ad_id":"613795209","ad_photo":"8","ad_price":"26500","price_currency":"UAH","item_condition":"used","adpage_type":"standard","poster_type":"private","seller_id":"23949589","cat_l1_id":"37","cat_l1_name":"elektronika","cat_l2_id":"1502","cat_l2_name":"noutbuki-i-aksesuary","cat_l3_id":"80","cat_l3_name":"noutbuki","category_id":"80","region_id":"21","region_name":"dnp","city_id":"121","city_name":"dnepr","district_id":"113","district_name":"\u0411\u0430\u0431\u0443\u0448\u043a\u0438\u043d\u0441\u043a\u0438\u0439","trackPage":"ad_page","action_type":"ad_page","platform":"desktop","language":"ru","url":"\/obyavlenie\/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDF","event_type":"pv"}}';
                    }
              </script>
    <script type="text/javascript">
        (function(document, window) {
            var DOMContentLoaded=function(a){var b=function(){return document.attachEvent&&"undefined"!=typeof document.attachEvent?"ie":"not-ie"};return a=function(a){a&&"function"==typeof a?"ie"!==b()?document.addEventListener("DOMContentLoaded",function(){return a()}):document.attachEvent("onreadystatechange",function(){if("complete"===document.readyState)return a()}):console.error("The callback is not a function!")}}(DOMContentLoaded||{});
                DOMContentLoaded(function() {
                    if (typeof NinjaTracker !== "undefined") {
                        NinjaTracker.initEvents();
                        if (typeof PaymentHandler === "function") { PaymentHandler(); }
                    } else {
                        console.log("NinjaTracker Events is undefined, initialization failed!");
                    }
                });
        })(document, window);
    </script>
    <script type="text/javascript">
        var newrelicLicenseKey = "f1ebd821a6";
        var newrelicApplicationID = "26545672";
        var newrelicRandomMax = "25";
    </script>
    <script src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/js/newrelic.js?v=6a63052e" type="text/javascript"></script>
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <script type="text/javascript" charset="utf-8">
    (function(G,o,O,g,L,e){G[g]=G[g]||function(){(G[g]['q']=G[g]['q']||[]).push(
                    arguments)},G[g]['t']=1*new Date;L=o.createElement(O),e=o.getElementsByTagName(
            O)[0];L.async=1;L.src='//www.google.com/adsense/search/async-ads.js';
        e.parentNode.insertBefore(L,e)})(window,document,'script','_googCsa');
</script>        <script type="text/javascript">
        var abp = 0;
        var AdblockPlus = new function () {
            this.detect = function (px, callback) {
                var detected = false;
                var checksRemain = 2;
                var error1 = false;
                var error2 = false;
                if(typeof callback != "function") {
                    return;
                }
                px += "?ch=*&rn=*";
                function beforeCheck(callback, timeout) {
                    if (checksRemain == 0 || timeout > 1E3) {
                        callback(checksRemain == 0 && detected);
                    } else {
                        setTimeout(function () {
                            beforeCheck(callback, timeout * 2)
                        }, timeout * 2)
                    }
                }
                function checkImages() {
                    if (--checksRemain) {
                        return;
                    }
                    detected = !error1 && error2
                }
                var random = Math.random() * 11;

                var img1 = new Image;
                img1.onload = checkImages;

                img1.onerror = function () {
                    error1 = true;
                    checkImages()
                };
                img1.src = px.replace(/\*/, 1).replace(/\*/, random);

                var img2 = new Image;
                img2.onload = checkImages;

                img2.onerror = function () {
                    error2 = true;
                    checkImages()
                };
                img2.src = px.replace(/\*/, 2).replace(/\*/, random);

                beforeCheck(callback, 500)
            }
        };

        var initAdblock = true;
        var adblockPixel = 'https://static.criteo.net/images/pixel.gif';
    </script>

    <script type="text/javascript">
        var Baxter = Baxter || {}; Baxter.queue = Baxter.queue || [];
        var showDidomi = 1;
        var vendor = [91,69,10,76,16,45,50,511,32,52,25,8,12,28,27,26,1,6,30,24,29,39,11,15,4,7,2,37,13,34,57,63,51,49,71,79,85,86,94,73,33,20,55,53,98,62,19,43,36,80,81,23,75,17,61,40,89,46,66,105,41,82,60,70,48,100,21,110,42,112,77,109,120,93,132,22,102,108,18,68,122,97,74,138,72,127,136,111,56,124,154,38,101,149,151,153,159,157,145,131,158,147,130,129,128,168,164,144,163,173,88,78,59,114,175,133,14,180,183,58,140,90,141,142,209,195,190,84,65,210,200,188,217,156,194,226,198,227,225,205,179,31,92,155,115,126,193,245,213,244,224,174,192,232,256,234,246,241,254,215,167,240,235,185,258,169,208,211,229,273,104,162,249,125,170,160,189,279,269,276,87,182,255,203,260,237,274,280,239,177,201,150,252,248,161,285,228,299,277,259,289,272,230,253,304,314,257,317,278,291,295,315,165,47,134,325,316,318,199,236,294,143,297,319,290,323,119,302,212,264,44,282,238,284,148,64,301,275,310,139,326,262,331,345,308,270,333,202,328,281,354,320,359,265,349,288,266,339,303,261,83,343,330,231,216,360,361,311,358,152,251,371,344,347,218,350,351,341,380,378,369,184,368,373,214,388,250,223,384,387,312,178,377,382,206,403,385,404,242,376,402,413,400,171,398,415,263,329,389,337,422,421,426,394,287,243,113,338,405,416,434,435,409,321,436,442,362,418,449,443,429,335,407,427,374,438,450,452,444,412,454,455,298,423,397,381,425,365,447,410,137,395,462,466,340,431,336,430,346,469,440,375,196,268,475,474,448,428,461,476,480,366,392,357,486,468,458,489,484,493,495,496,424,408,473,467,488,490,464,491,499,502,465,497,492,508,512,471,494,516,507,482,505,517,518,479,513,509,521,487,515,520,524,529,528,527,506,534,535,514,522,530,539,501,519,523,537,531,536,542,525,544,543,334,551,540,547,546,541,545,439,553,556,550,560,554,498,565,118,572,571,568,570,559,548,569,577,590,587,578,580,593,574,581,598,596,576,592,549,597,584,601,599,604,606,608,602,612,591,614,615,607,609,617,620,610,621,624,623,95,618,619,625,628,630,626,631,627,638,644,639,635,579,645,653,613,573,652,646,648,647,654,659,656,504,"google"];
        var newVendor = {"11":8,"12":12,"13":28,"14":27,"15":26,"16":1,"17":6,"18":30,"19":24,"20":29,"21":39,"22":11,"23":15,"24":4,"25":7,"26":2,"27":37,"28":13,"29":34,"30":57,"31":63,"32":51,"33":49,"34":71,"35":79,"36":85,"37":86,"38":94,"39":73,"40":33,"41":20,"42":55,"43":53,"44":98,"45":62,"46":19,"47":43,"48":36,"49":80,"50":81,"51":23,"52":75,"53":17,"54":61,"55":40,"56":89,"57":46,"58":66,"59":105,"60":41,"61":82,"62":60,"63":70,"64":48,"65":100,"66":21,"67":110,"68":42,"69":112,"70":77,"71":109,"72":120,"73":93,"74":132,"75":22,"76":102,"77":108,"78":18,"79":68,"80":122,"81":97,"82":74,"83":138,"84":72,"85":127,"86":136,"87":111,"88":56,"89":124,"90":154,"91":38,"92":101,"93":149,"94":151,"95":153,"96":159,"97":157,"98":145,"99":131,"100":158,"101":147,"102":130,"103":129,"104":128,"105":168,"106":164,"107":144,"108":163,"109":173,"110":88,"111":78,"112":59,"113":114,"114":175,"115":133,"116":14,"117":180,"118":183,"119":58,"120":140,"121":90,"122":141,"123":142,"124":209,"125":195,"126":190,"127":84,"128":65,"129":210,"130":200,"131":188,"132":217,"133":156,"134":194,"135":226,"136":198,"137":227,"138":225,"139":205,"140":179,"141":31,"142":92,"143":155,"144":115,"145":126,"146":193,"147":245,"148":213,"149":244,"150":224,"151":174,"152":192,"153":232,"154":256,"155":234,"156":246,"157":241,"158":254,"159":215,"160":167,"161":240,"162":235,"163":185,"164":258,"165":169,"166":208,"167":211,"168":229,"169":273,"170":104,"171":162,"172":249,"173":125,"174":170,"175":160,"176":189,"177":279,"178":269,"179":276,"180":87,"181":182,"182":255,"183":203,"184":260,"185":237,"186":274,"187":280,"188":239,"189":177,"190":201,"191":150,"192":252,"193":248,"194":161,"195":285,"196":228,"197":299,"198":277,"199":259,"200":289,"201":272,"202":230,"203":253,"204":304,"205":314,"206":257,"207":317,"208":278,"209":291,"210":295,"211":315,"212":165,"213":47,"214":134,"215":325,"216":316,"217":318,"218":199,"219":236,"220":294,"221":143,"222":297,"223":319,"224":290,"225":323,"226":119,"227":302,"228":212,"229":264,"230":44,"231":282,"232":238,"233":284,"234":148,"235":64,"236":301,"237":275,"238":310,"239":139,"240":326,"241":262,"242":331,"243":345,"244":308,"245":270,"246":333,"247":202,"248":328,"249":281,"250":354,"251":320,"252":359,"253":265,"254":349,"255":288,"256":266,"257":339,"258":303,"259":261,"260":83,"261":343,"262":330,"263":231,"264":216,"265":360,"266":361,"267":311,"268":358,"269":152,"270":251,"271":371,"272":344,"273":347,"274":218,"275":350,"276":351,"277":341,"278":380,"279":378,"280":369,"281":184,"282":368,"283":373,"284":214,"285":388,"286":250,"287":223,"288":384,"289":387,"290":312,"291":178,"292":377,"293":382,"294":206,"295":403,"296":385,"297":404,"298":242,"299":376,"300":402,"301":413,"302":400,"303":171,"304":398,"305":415,"306":263,"307":329,"308":389,"309":337,"310":422,"311":421,"312":426,"313":394,"314":287,"315":243,"316":113,"317":338,"318":405,"319":416,"320":434,"321":435,"322":409,"323":321,"324":436,"325":442,"326":362,"327":418,"328":449,"329":443,"330":429,"331":335,"332":407,"333":427,"334":374,"335":438,"336":450,"337":452,"338":444,"339":412,"340":454,"341":455,"342":298,"343":423,"344":397,"345":381,"346":425,"347":365,"348":447,"349":410,"350":137,"351":395,"352":462,"353":466,"354":340,"355":431,"356":336,"357":430,"358":346,"359":469,"360":440,"361":375,"362":196,"363":268,"364":475,"365":474,"366":448,"367":428,"368":461,"369":476,"370":480,"371":366,"372":392,"373":357,"374":486,"375":468,"376":458,"377":489,"378":484,"379":493,"380":495,"381":496,"382":424,"383":408,"384":473,"385":467,"386":488,"387":490,"388":464,"389":491,"390":499,"391":502,"392":465,"393":497,"394":492,"395":508,"396":512,"397":471,"398":494,"399":516,"400":507,"401":482,"402":505,"403":517,"404":518,"405":479,"406":513,"407":509,"408":521,"409":487,"410":515,"411":520,"412":524,"413":529,"414":528,"415":527,"416":506,"417":534,"418":535,"419":514,"420":522,"421":530,"422":539,"423":501,"424":519,"425":523,"426":537,"427":531,"428":536,"429":542,"430":525,"431":544,"432":543,"433":334,"434":551,"435":540,"436":547,"437":546,"438":541,"439":545,"440":439,"441":553,"442":556,"443":550,"444":560,"445":554,"446":498,"447":565,"448":118,"449":572,"450":571,"451":568,"452":570,"453":559,"454":548,"455":569,"456":577,"457":590,"458":587,"459":578,"460":580,"461":593,"462":574,"463":581,"464":598,"465":596,"466":576,"467":592,"468":549,"469":597,"470":584,"471":601,"472":599,"473":604,"474":606,"475":608,"476":602,"477":612,"478":591,"479":614,"480":615,"481":607,"482":609,"483":617,"484":620,"485":610,"486":621,"487":624,"488":623,"489":95,"490":618,"491":619,"492":625,"493":628,"494":630,"495":626,"496":631,"497":627,"498":638,"499":644,"500":639,"501":635,"502":579,"503":645,"504":653,"505":613,"506":573,"507":652,"508":646,"509":648,"510":647,"511":654,"512":659,"513":656,"514":504,"515":"google"};
        var hasGoogleIntegration = true;
        var vendorVersion = 3;
        window.didomiConfig = {
            website: {
                apiKey: 'ee8f2b48-6e6d-4657-af88-8521d468880e',
                name: 'OLX',
                vendors: {
                    iab: {
                        include: window.vendor
                    }
                },
                privacyPolicyURL: 'https://www.olxbox.info/cookies/'
            },
            languages: {
                enabled: ["ru"],
                default: "ru"
            },
            theme: {
                color: '#0098d0'
            },
            notice: {
                enable: false
            },
            preferences : {
                defaultChoice : true,
                content : {
                    text : {
                        'pl' : 'Na swoich stronach Grupa OLX sp. z o.o. wraz z partnerami używają plików cookies i podobnych technologii do ulepszania i dostosowywania treści, analizy ruchu, dostarczania reklam oraz ochrony przed spamem, złośliwym oprogramowaniem i nieuprawnionym dostępem. Możesz dowiedzieć się więcej o tym jak my i nasi partnerzy używamy plików cookies i podobnych technologii <a href="https://www.olxbox.info/cookies/" target="_blank">tutaj</a>. Możesz wyłączyć pliki cookies naszych partenerów używane na tej stronie internetowej zmianiając swoje ustawienia <a href="https://www.olxbox.info/cookies/" target="_blank">tutaj</a>.',
                        'ro' : 'Pe acest website, noi și partenerii noștri folosim cookie-uri și tehnologii similare in scopul imbunatatirii si personalizarii continutului nostru, pentru analizarea traficului, pentru a va furniza publicitate și pentru a ne proteja sistemele împotriva malware-ului și a accesului neautorizat. Puteți afla mai multe despre modul în care noi și partenerii noștri folosim cookie-uri și tehnologii similare <a href="https://www.olxbox.info/cookies/" target="_blank">aici</a>. Puteți dezactiva modulele cookie ale partenerilor noștri pe acest website prin modificarea setărilor <a href="https://www.olxbox.info/cookies/" target="_blank">aici</a>',
                        'pt' : 'Neste website, nós e os nossos parceiros usamos cookies e tecnologias afins para melhorar e personalizar o conteúdo, analisar o tráfego, enviar publicidade e proteger os nossos sistemas contra malware e acessos não autorizados. Se quiser, pode obter mais informação sobre como nós e os nossos parceiros usamos cookies e tecnologias afins <a href="https://www.olxbox.info/cookies/" target="_blank">aqui</a>. Pode desativar, neste website, os cookies dos nossos parceiros, alterando as suas configurações <a href="https://www.olxbox.info/cookies/" target="_blank">aqui</a>.',
                        'bg' : 'В този уебсайт, ние и нашите партньори, използваме „бисквитки” ("cookies") и подобни технологии с цел подобряване и персонализиране на съдържанието, анализиране на трафика, предоставяне на реклама и осигуряване на защита за нашите системи от злонамерен софтуер и непозволен достъп. <br/>Можете да научите повече за това как ние и нашите партньори използваме „бисквитки” и подобни технологии <a href="https://www.olxbox.info/cookies/" target="_blank">тук</a><br/>Можете да деактивирате „бисквитките” на нашите партньори в този уебсайт, като промените настройките си <a href="https://www.olxbox.info/cookies/" target="_blank">тук</a>',
                        'ru' : '«На этом веб-сайте мы и наши партнеры используем файлы cookies и аналогичные технологии для улучшения и настройки контента, анализа трафика, предоставления рекламы и защиты наших систем от вредоносных программ и несанкционированного доступа. Вы можете узнать больше о том, как мы и наши партнеры используем файлы cookies и аналогичные технологии <a href="https://www.olxbox.info/cookies/" target="_blank">здесь</a>. Вы можете отключить файлы cookies наших партнеров на этом веб-сайте, изменив настройки <a href="https://www.olxbox.info/cookies/" target="_blank">здесь</a>. <br/>ЗАМЕНИТЬ кнопку X в текущем баннере кнопкой «Я принимаю».',
                        'uk' : 'На нашому веб-сайті ми і наші партнери використовуємо файли cookies та подібні технології для покращення та налаштування контенту, аналізу трафіку, реклами та захисту наших систем від шкідливого та несанкціонованого доступу. Ви можете деактивувати файли cookies наших партнерів на цьому веб-сайті, змінюючи налаштування <a href="https://www.olxbox.info/cookies/" target="_blank">тут</a>. <br/>ЗАМЕНИТИ кнопку X у теперешньому банері  кнопкою "Я приймаю".'
                    },
                    textVendors : {
                        'pl' : 'Podczas korzystania z naszych usług na Twoim urządzeniu umieszczane są pliki cookies Grupy OLX sp. z o.o. oraz naszych partnerów. W celu ulepszenia i dostosowywania treści oraz dostarczania i ulepszania reklam, pliki cookies mogą mieć dostęp do danych osobowych oraz innych informacji znajdujących się na Twoim urządzeniu. Możesz zaakceptować wszystkie albo część plików cookies korzystając z ustawień poniżej. Pamiętaj jednak, że ustawienia te dotyczą wyłącznie plików cookies naszych partnerów. Grupa OLX sp. z o.o. w związku z korzystaniem z naszych usług, wciąż będzie umieszczać własne pliki cookies na Twoim urządzeniu. Aby dowiedzieć się więcej o plikach cookies, naszych partnerach oraz o tym jak kontrolować przetwarzania swoich danych osobowych odwiedź naszą <a href="https://www.olxbox.info/cookies/" target="_blank">Politykę prywatności</a> oraz nasza <a href="https://www.olxbox.info/cookies/" target="_blank">Politykę dotyczącą Cookies i podobnych technologii</a>.',
                        'ro' : 'Pe lângă propriile cookie-uri, partenerii noștri plasează cookie-uri pe dispozitivul dumneavoastra atunci când vizitați serviciile noastre. Aceste cookie-uri pot accesa și utiliza informații personale și non-personale de pe dispozitivul dumneavoastra in scopul îmbunătățirii serviciilor noastre și pentru personalizarea anunțurilor și a conținutului oferit în cadrul serviciului nostru. Puteți accepta aceste procese, in totalitate sau partial, prin ajustarea setărilor de mai jos. Rețineți că aceste setări se referă doar la modulele cookie ale partenerilor noștri. Vom continua sa plasam cookie-uri pentru analiza vizitatorilor pe dispozitivul dumneavoastra. Pentru a afla mai multe despre cookie-uri, partenerii nostri și cum să controlați utilizarea datelor, vizitați <a href="https://www.olxbox.info/cookies/" target="_blank">Politica noastră de confidențialitate</a> și <a href="https://www.olxbox.info/cookies/" target="_blank">Politica noastră de cookie-uri</a>.',
                        'pt' : 'Além dos nossos próprios cookies, os nossos parceiros também colocam cookies no seu dispositivo quando visita os nossos serviços. Esses cookies podem aceder e usar dados pessoais ou não pessoais, no ou a partir do seu dispositivo, para melhorar os nossos serviços, assim como para personalizar anúncios e outros conteúdos através do nosso serviço. Pode aceitar a totalidade ou apenas partes destes sistemas, ajustando as configurações abaixo. Tenha em atenção que estas definições referem-se apenas a cookies dos nossos parceiros. Colocamos ainda cookies próprios no seu dispositivo. <br/>Para saber mais sobre cookies, os nossos parceiros, e como controlar o uso de seus dados, visite a nossa <a href="https://www.olxbox.info/cookies/" target="_blank">Política de Privacidade</a> e a nossa <a href="https://www.olxbox.info/cookies/" target="_blank">Política de Cookies</a>.',
                        'bg' : 'Освен нашите собствени „бисквитки” ("cookies"), нашите партньори също така поставят „бисквитки” във вашето устройство, когато използвате нашите услуги. <br/>Тези "бисквитки" могат да имат достъп и да използват персонална и неперсонална  информация от вашето устройство, за да подобрят предоставяните от нас услуги и да персонализират рекламите и друг вид съдържание от нашите услуги. <br/>Можете да приемете всички или части от тези процеси като промените настройките по-долу. <br/>Моля, имайте предвид, че тези настройки се отнасят само за „бисквитките” на нашите партньори. Ние ще продължаваме да поставяме собствени „бисквитки” в устройството ви.<br/> За да научите повече за „бисквитките”, нашите партньори и как да контролирате използването на вашите данни, посетете нашите <a href="https://www.olxbox.info/cookies/" target="_blank">Политика за поверителност</a> <a href="https://www.olxbox.info/cookies/" target="_blank">Политика за използване на „бисквитки”.</a>',
                        'ru' : 'Помимо наших собственных файлов cookies, наши партнеры также размещают файлы cookies на вашем устройстве, когда вы посещаете наши сервисы. Эти файлы cookies могут получать доступ и использовать персональную и не персональную информацию с вашего устройства для улучшения наших услуг и персонализации рекламы и другого содержимого в рамках всего нашего сервиса. Вы можете принять все или часть этих процессов, изменив настройки ниже. Помните, что эти настройки относятся только к файлам cookies наших партнеров. Мы по-прежнему будем размещать собственные cookies на вашем устройстве. Чтобы узнать больше о файлах cookies, партнерах и о том, как контролировать использование ваших данных, посетите наши <a href="https://www.olxbox.info/cookies/" target="_blank">Политика конфиденциальности</a> и <a href="https://www.olxbox.info/cookies/" target="_blank">Политика использования файлов cookies</a>',
                        'uk' : 'Крім наших власних файлів cookies, наші партнери також розміщують файли cookies  на вашому пристрої під час відвідування наших сервісів. Ці файли cookies  можуть отримувати доступ до персональної та не персональної інформації з вашого пристрою та використовувати її для покращення наших послуг та персоналізації оголошень та іншого контенту на нашому сервісі. Ви можете прийняти всі чи частину цих процесів, налаштувавши наведені нижче параметри. Майте на увазі, що ці налаштування стосуються лише файлів cookies наших партнерів. Ми як і раніше розміщуватимемо власні файли cookies на вашому пристрої. Щоб дізнатися більше про файли cookies партнерів і як контролювати використання ваших даних, перейдіть до нашої <a href="https://www.olxbox.info/cookies/" target="_blank">Політика конфіденційності</a> та нашої <a href="https://www.olxbox.info/cookies/" target="_blank">Політика використання файлів cookies]</a>.'
                    }
                }
            }
        };

        window.canRefreshDFPAds = true;
        window.didomiEventListeners = window.didomiEventListeners || [];
        window.didomiOnReady = window.didomiOnReady  || [];
        window.didomiOnReady.push(function () {
            function getCookie(name) {
                var cookiePattern = '(^| )' + name + '=([^;]+)';
                var match = document.cookie.match(new RegExp(cookiePattern));
                if (match) {
                    return match[2];
                }

                return null
            }
            var VENDORS_VERSION_WITH_ENABLED_RESET = 3;
            if (!getCookie('cmpreset') && getCookie('cmpvendors') <= VENDORS_VERSION_WITH_ENABLED_RESET) {
                Didomi.reset();
            }
            if (getCookie('euconsent') && window.newVendor.length) {
                var transaction = Didomi.openTransaction();
                for (var index in window.newVendor) {
                    transaction.enableVendor(window.newVendor[index]);
                }
                transaction.commit();
            }
        });

        if (hasGoogleIntegration) {
            window.canRefreshDFPAds = false;
            window.didomiConfig.website.vendors.didomi = ['google'];
            window.didomiConfig.integrations = {
                vendors: {
                    google: {
                        enable: true,
                        eprivacy: false,
                        refresh: false
                    }
                }
            };
            window.didomiEventListeners.push({
                event: 'integrations.consentpassedtodfp',
                listener: function (data) {
                    window.Baxter.queue.push(function() {
                        window.Baxter.didomi.setUserConsentInformation();
                    });
                    window.canRefreshDFPAds = true;
                }
            });
        } else {
            window.Baxter.queue.push(function() {
                window.Baxter.didomi.setUserConsentInformation();
            })
        }
    </script>
    <script type="text/javascript">
        window.gdprAppliesGlobally = true;
        (function () { function n() { if (!window.frames.__cmpLocator) { if (document.body && document.body.firstChild) { var e = document.body; var t = document.createElement("iframe"); t.style.display = "none"; t.name = "__cmpLocator"; e.insertBefore(t, e.firstChild) } else { setTimeout(n, 5) } } } function e(e, t, n) { if (typeof n !== "function") { return } if (!window.__cmpBuffer) { window.__cmpBuffer = [] } if (e === "ping") { n({ gdprAppliesGlobally: window.gdprAppliesGlobally, cmpLoaded: false }, true) } else { window.__cmpBuffer.push({ command: e, parameter: t, callback: n }) } } e.stub = true; function t(a) { if (!window.__cmp || window.__cmp.stub !== true) { return } if (!a.data) { return } var r = typeof a.data === "string"; var e; try { e = r ? JSON.parse(a.data) : a.data } catch (t) { return } if (e.__cmpCall) { var i = e.__cmpCall; window.__cmp(i.command, i.parameter, function (e, t) { var n = { __cmpReturn: { returnValue: e, success: t, callId: i.callId } }; a.source.postMessage(r ? JSON.stringify(n) : n, "*") }) } } if (typeof window.__cmp !== "function") { window.__cmp = e; if (window.addEventListener) { window.addEventListener("message", t, false) } else { window.attachEvent("onmessage", t) } } n() })();
    </script>
    <script type="text/javascript" id="spcloader" src="https://sdk.privacy-center.org/loader.js" async=""></script>

				<!-- HEAD CONTRIB -->

            <script type="text/javascript">
            var trackingData = trackingData || {}; 
                                try{
                    trackingData.$data = JSON.parse('{"pageView":{"user_status":"unlogged","traffic_source":"direct","safe_deal_visibility":"no_sd","reserved_visibility":"no_delivery"},"delayedEvents":[{"click_name":"session_start","event_type":"click"}]}');
                    } catch(e) {
                       throw 'error4' + '{"pageView":{"user_status":"unlogged","traffic_source":"direct","safe_deal_visibility":"no_sd","reserved_visibility":"no_delivery"},"delayedEvents":[{"click_name":"session_start","event_type":"click"}]}';
                    }
                    
            if (typeof NinjaTracker !== "undefined") {
    
                NinjaTracker.init();
            } else {
                console.log("NinjaTracker is undefined, initialization failed!");
            }
            </script><noscript><img width="1" height="1" src="https://tracking.olx-st.com/h/v2/it-cee?nw=1&cou=UA&cisoid=804&cid=220&pid=8&trackPage=ad_page&iid=613795209&imagesCount=8&ad_price=26500&price_currency=UAH&item_condition=used&adpage_type=standard&sellerType=private&sellerId=23949589&categoryLevel1Id=37&cat_l1_name=elektronika&categoryLevel2Id=1502&cat_l2_name=noutbuki-i-aksesuary&categoryLevel3Id=80&cat_l3_name=noutbuki&category_id=80&provinceId=21&region_name=dnp&cityId=121&city_name=dnepr&districtId=113&district_name=%D0%91%D0%B0%D0%B1%D1%83%D1%88%D0%BA%D0%B8%D0%BD%D1%81%D0%BA%D0%B8%D0%B9&action_type=ad_page&platformType=desktop&lang=ru&extra=%7B%22url%22%3A%22%5C%2Fobyavlenie%5C%2Figrovoy-noutbuk-msi-gs60-6qc-ghost-IDF%22%2C%22reserved_visibility%22%3A%22no_delivery%22%7D&event_type=pv&user_status=unlogged&traffic_source=direct&safe_deal_visibility=no_sd&pageName=obyavlenie%2Figrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ&t=1572642240&host=www.olxbox.info&ivd=olx-ua_organic&source=noscript"/>
</noscript>

														<script type="text/javascript">
						var _adblock = true;
					</script>
					<script type="text/javascript" src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/js/advertising.js?v=6a63052e"></script>
								    	    																		<link rel="stylesheet" type="text/css" href="https://static-olxeu.akamaized.net/static/olxua/packed/sw81046f88427ebeb65de85e48c27b56cb.css">
																											<link rel="stylesheet" type="text/css" href="https://static-olxeu.akamaized.net/static/olxua/packed/sw7bc67ab726a2f1b4587786fa176e433c.css">
																										<!--[if lte IE 8]>						<link rel="stylesheet" type="text/css" href="https://static-olxeu.akamaized.net/static/olxua/packed/swc63c95add6e0445e53016b1bd27edf58.css">
					<![endif]-->									
		
					<script type="text/javascript">
				window.suggestmeyes_loaded = true;
			    						var action='ad';
			    						var method='index';
			    						var user_logged=0;
			    						var www_base='https://www.olxbox.info';
			    						var www_base_no_namespace='https://www.olxbox.info';
			    						var www_base_ajax='https://www.olxbox.info/ajax';
			    						var static_files_www_base='https://static-olxeu.akamaized.net/static/olxua/';
			    						var external_static_files_www_base='https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web-olxua/static/';
			    						var external_static_files_www_base_main='https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/';
			    						var session_domain='olxbox.info';
			    						var site_domain='www.olxbox.info';
			    						var decimal_separator='.';
			    						var thousands_separator=' ';
			    						var sitecode='olxua';
			    						var defaultCurrency='UAH';
			    						var config_currency='грн.';
			    						var useExternalScripts=1;
			    						var lang='ru';
			    						var hasRwd=0;
			    						var module_ad_discount_push=1;
			    						var module_landing_homegarden_ua=1;
			    						var module_landing_jobs_ua=1;
			    						var module_safedeal_always_active=1;
			    						var module_police_bank_info=1;
			    						var module_paidads=1;
			    						var module_facebook_login=1;
			    						var module_new_emails=1;
			    						var module_newmoderation=1;
			    						var module_payu=1;
			    						var module_districts=1;
			    						var module_new_search_filters=1;
			    						var module_new_myaccount=1;
			    						var module_currencies=1;
			    						var module_currencies_new=1;
			    						var module_solr_currency_sorting=1;
			    						var module_sms_notification=1;
			    						var module_metro=1;
			    						var module_superdeal=1;
			    						var module_phone_login=1;
			    						var module_contact_as_image=1;
			    						var module_mobile_app=1;
			    						var module_unfinished_payments=1;
			    						var module_new_sms_notification=1;
			    						var module_trusted_changes=1;
			    						var module_stock_photos_info=1;
			    						var module_refugees=1;
			    						var module_refugees_adding=1;
			    						var module_multiacc=1;
			    						var module_olx6=1;
			    						var module_gpt_banners=1;
			    						var module_i2_payment=1;
			    						var module_paid_subscriptions=1;
			    						var module_topupaccount=1;
			    						var module_old_payment_tables=1;
			    						var module_portmone=1;
			    						var module_plutus_payment=1;
			    						var module_plutus_payment_frontend=1;
			    						var module_redis_hash=1;
			    						var module_redis_cluster_revert=1;
			    						var module_rest_api=1;
			    						var module_phone_in_desc=1;
			    						var module_anonymous_chat_app=1;
			    						var module_ads_no_results=1;
			    						var module_new_at=1;
			    						var module_bonus_credits=1;
			    						var module_geo6_multiple_langs=1;
			    						var module_crm=1;
			    						var module_gpt_banners_i2=1;
			    						var module_new_tracking=1;
			    						var module_new_tracking_i2=1;
			    						var module_ninja_m_legacy=1;
			    						var module_clm=1;
			    						var module_paid_subscriptions_single=1;
			    						var module_user_online_status=1;
			    						var module_pushup_new=1;
			    						var module_topupaccount_newemail=1;
			    						var module_afc_to_dfp=1;
			    						var module_no_old_subdomains=1;
			    						var module_observed_new=1;
			    						var module_ap_ldap_login=1;
			    						var module_ads_homepage=1;
			    						var module_disable_free_refresh_categories=1;
			    						var module_observed_anonymous=1;
			    						var module_new_controllers=1;
			    						var module_vas_config_wallet=1;
			    						var module_vas_config_wallet_before=1;
			    						var module_vas_config_nnl_limits=1;
			    						var module_vas_config_nnl_business_limits=1;
			    						var module_vas_config_topads=1;
			    						var module_topupaccount_wallet=1;
			    						var module_new_dfp=1;
			    						var module_afs_on_empty_search_i2=1;
			    						var module_landing_action=1;
			    						var module_split_item_content=1;
			    						var module_user_sms_verification=1;
			    						var module_user_photo=1;
			    						var module_show_limits_price_on_posting_form=1;
			    						var module_enable_premium_account=1;
			    						var module_flagged_ads=1;
			    						var module_shop_filters=1;
			    						var module_mandatory_login=1;
			    						var module_gemius=1;
			    						var module_remove_emailanswers_on_posting=1;
			    						var module_multipay_ati_new_report=1;
			    						var module_paid_feature_expires=1;
			    						var module_nps_survey=1;
			    						var module_vas_config_tariff_bonus_points=1;
			    						var module_treatments=1;
			    						var module_accept_arranged_salary=1;
			    						var module_recaptcha=1;
			    						var module_app_homescreen_tiles=1;
			    						var module_disable_adblock_afs=1;
			    						var module_log_sent_emails=1;
			    						var module_users_extra_data=1;
			    						var module_safedeal=1;
			    						var module_safedeal_buyer=1;
			    						var module_phone_views_logs=1;
			    						var module_track_features=1;
			    						var module_atlasorm=1;
			    						var module_discount_tool=1;
			    						var module_jobs_free_seek=1;
			    						var module_messages_spammers=1;
			    						var module_topads_promotions=1;
			    						var module_payment_click_tracking=1;
			    						var module_pricing_test_group_assignment=1;
			    						var module_user_settings_recaptcha=1;
			    						var module_vas_valid_to_date=1;
			    						var module_change_localisation_label=1;
			    						var module_require_register_token=1;
			    						var module_ad_paid_features=1;
			    						var module_new_jobs=1;
			    						var module_tradus=1;
			    						var module_mass_tests=1;
			    						var module_nps_jobs_survey_db_tables=1;
			    						var module_tariff_basket=1;
			    						var module_bundles=1;
			    						var module_bundles_frontend=1;
			    						var module_bundles_vas=1;
			    						var module_bundles_infolayer=1;
			    						var module_bundles_packet=1;
			    						var module_ab_tests=1;
			    						var module_tracking_fix=1;
			    						var module_last_messages_in_conversations=1;
			    						var module_query_spell_checker=1;
			    						var module_cv_upload=1;
			    						var module_jobs_message_prefill=1;
			    						var module_ad_cache_reload_schedule=1;
			    						var module_afs_refactor=1;
			    						var module_test_afc_afs_slots_listing=1;
			    						var module_disable_verification_targeting=1;
			    						var module_adblock_targeting=1;
			    						var module_adblock_targeting_new=1;
			    						var module_log_ad_limited=1;
			    						var module_disable_ads_output_cache=1;
			    						var module_disable_ad_output_cache=1;
			    						var module_sms_verification_phone_search=1;
			    						var module_race_test_prediction=1;
			    						var module_b2c_business_page=1;
			    						var module_b2c_ad_page=1;
			    						var module_b2c_business_banner=1;
			    						var module_vas_config_refresh_for_packages=1;
			    						var module_packages_new_design=1;
			    						var module_vas_logo_link=1;
			    						var module_new_category_suggester=1;
			    						var module_payment_providers_configurable=1;
			    						var module_entry_points_logger=1;
			    						var module_buy_package_always_available=1;
			    						var module_rabbit_mq=1;
			    						var module_register_restrict_email=1;
			    						var module_async_event_bus=1;
			    						var module_forced_business_categories=1;
			    						var module_page_views_from_mysql=1;
			    						var module_wallet_history=1;
			    						var module_promo_points=1;
			    						var module_app_control_recaptcha_registration=1;
			    						var module_app_control_akamai_bot_manager=1;
			    						var module_browser_fingerprint=1;
			    						var module_highlight_salary_parameter_in_edit=1;
			    						var module_wallet_operation_reference=1;
			    						var module_disable_say_hello=1;
			    						var module_advertising_test_token=1;
			    						var module_new_free_connection=1;
			    						var module_skip_free_mysql_connection=1;
			    						var module_db_aurora=1;
			    						var module_unread_count_no_cache=1;
			    						var module_laquesis=1;
			    						var module_attachment_link_without_autologin=1;
			    						var module_disable_slash_m=1;
			    						var module_new_friendly_links_category_repository=1;
			    						var module_user_extended_in_ad_card=1;
			    						var module_api_session_in_memory=1;
			    						var module_payment_session_status_changes=1;
			    						var module_periodic_phone_blocking=1;
			    						var module_session_eviction_recovery=1;
			    						var module_anonymize_user_passwords_in_sms_queue=1;
			    						var module_apple_push_deadletter=1;
			    						var module_comms=1;
			    						var module_password_leak_usage_metric=1;
			    						var module_vas_validity_message=1;
			    						var module_didomi_cmp=1;
			    						var module_cmp=1;
			    						var module_hash_sms_password=1;
			    						var module_ad_discount=1;
			    						var module_pushup_automatic=1;
			    						var module_hide_adverts_slots=1;
			    						var module_delete_secure=1;
			    						var module_app_homescreen_last=1;
			    						var module_app_homescreen_curated=1;
			    						var module_group_activation_of_limited_ads=1;
			    						var module_mandatory_login_for_chat=1;
			    						var module_new_sidebar=1;
			    						var module_show_photo_setting=1;
			    						var module_users_without_password_detector=1;
			    						var module_ads_efficiency=1;
			    						var module_appleAllowLongPushes=1;
			    						var module_targeting_ru_email=1;
			    						var module_remove_old_ati=1;
			    						var module_vas_logo=1;
			    						var module_ua_discounts_promo=1;
			    						var module_redis_split_db=1;
			    						var module_olx_delivery=1;
			    						var module_safedeal_queues=1;
			    						var module_safedeal_transactions_tooltip=1;
			    						var module_delivery_request_sent=1;
			    						var module_delivery_request=1;
			    						var module_delivery_request_reserved=1;
			    						var module_delivery_request_popup=1;
			    						var module_dfp_refactor=1;
			    						var module_nnl_category_migration=1;
			    						var module_new_dfp_segment=1;
			    						var module_dfp_segment_mysql=1;
			    						var module_ads_efficiency_mysql=1;
			    						var module_register_confirm_token=1;
			    						var module_control_engine=1;
			    						var module_detached_categories=1;
			    						var module_user_activity_tracker=1;
			    						var module_wallet_as_a_service=1;
			    						var module_apollo_stage0=1;
			    						var module_apollo_stage1=1;
			    						var module_apollo_stage2=1;
			    						var module_apollo_stage3=1;
			    						var module_send_saved_searches_tracking_to_hydra=1;
			    						var module_exchange_rate=1;
			    						var module_turn_off_merge_mail=1;
			    						var module_answers_with_phone=1;
			    						var module_price_project_price_manager_prerequisite=1;
			    						var module_standarize_username=1;
			    						var module_adscreen_recommendations_experiment_enabled=1;
			    						var module_add_offer_type_to_ad_page=1;
			    						var module_measure_request_to_cognito=1;
			    						var module_exclude_checkboxes_from_solr_index=1;
			    						var module_bulk_image_reorder=1;
			    						var module_cognito_user_pool_v2=1;
			    						var module_homescreen_reco_user_to_item=1;
			    						var module_homescreen_use_satori_as_mixer=1;
			    						var module_store_image_update_sizes=1;
			    						var module_solr_cloud=1;
			    						var module_fraud_detection=1;
			    						var module_fraud_detector_queue=1;
			    						var module_accurate_location=1;
			    						var module_password_hashing=1;
			    						var module_hermes_new_api=1;
			    						var module_ab_force_login_posting=1;
			    						var module_history_extra_info=1;
			    						var module_observed_push=1;
			    						var module_app_homescreen=1;
			    						var module_mobile_slot_manager=1;
			    						var module_wp_nativemode=1;
			    						var module_apps_disable_alog=1;
			    						var module_app_homescreen_category=1;
			    						var module_app_homescreen_latlon=1;
			    						var module_app_homescreen_test=1;
			    						var module_app_homescreen_nearby_newest=1;
			    						var module_force_login_posting=1;
			    						var module_flagged_ads_alter=1;
			    						var module_use_www_subdomain=1;
			    						var module_ssl_only=1;
			    						var module_newrelic_api_app=1;
			    						var module_hide_disabled_parameters=1;
			    						var module_vas_treatments_thresholds_test_log=1;
			    						var module_hermes_messages=1;
			    						var module_new_hermes_executor=1;
			    						var module_legacy_cities=1;
			    						var module_statistics_i2=1;
			    						var module_ignore_sub_region_in_searches=1;
			    						var module_multipay_touchpoints=1;
			    						var module_fair_expiration=1;
			    						var module_fair_expiration_moderated_end=1;
			    						var module_log_erec_emails=1;
			    						var module_new_conversation_limiter=1;
			    						var module_eventbus_publisher=1;
			    						var module_hide_promotions_on_posting=1;
			    						var module_phone_views_block_scammers=1;
			    						var module_user_login_recaptcha=1;
			    						var module_register_recaptcha=1;
			    						var module_safedeal_mobile_posting=1;
			    						var module_S3FileStorage=1;
			    						var module_disable_banned_ips=1;
			    						var module_mweb_ad=1;
			    						var module_mweb_listing=1;
			    						var module_mweb_home=1;
			    						var module_mweb_alternate_links=1;
			    						var module_mweb_recaptcha=1;
			    						var module_mweb_login=1;
			    						var module_mweb_menu=1;
			    						var module_mweb_chat=1;
			    						var module_mweb_ads_management=1;
			    						var module_use_tokens_for_login=1;
			    						var module_safedeal_push=1;
			    						var module_tariff_tester_prerequisite=1;
			    						var module_tariff_tester=1;
			    						var module_price_project_data_service=1;
			    						var module_messages_recaptcha=1;
			    						var module_sqs_queue=1;
			    						var module_redis_cluster_part1=1;
			    						var module_redis_cluster_part2=1;
			    						var module_redis_cluster_part3=1;
			    						var module_redis_cluster_part4=1;
			    						var module_redis_cluster_part5=1;
			    						var module_redis_cluster=1;
			    						var module_redis_cluster_observed=1;
			    						var module_price_project_discount_dealer=1;
			    						var module_redis_backend_disabled=1;
			    						var module_redis_frontend_disabled=1;
			    						var module_password_crack_time=1;
			    						var module_send_user_moderation_events_to_karma=1;
			    						var module_statsd=1;
			    						var module_redis_observed_disabled=1;
			    						var module_redis_cluster_migration_finished=1;
			    						var module_redis_cluster_observed_migration_finished=1;
			    						var module_price_project_price_manager=1;
			    						var module_cmt_tree=1;
			    						var module_cmt_category_icon=1;
			    						var module_cmt_category_type=1;
			    						var module_cmt_cache_guard=1;
			    						var module_cmt_dry_run=1;
			    						var module_cognito_user_pool=1;
			    						var isTestServer=0;
			    						var sms_verified=0;
			    						var user_sms_verified=0;
			    						var mobileNumberPatternJs='^(?:(?:\\+?(380))|(0))?((?:39|50|66|95|99|63|93|67|68|96|97|98|91|92|94|73{1})[0-9]{5,7})$|^(?:\+?(?<code_ru>7))?(?<phone_ru>(?:900|901|902|903|904|905|906|908|909|910|911|912|913|914|915|916|917|918|919|920|921|922|923|924|925|926|927|928|929|930|931|932|933|934|936|937|938|939|941|950|951|952|953|955|956|958|960|961|962|963|964|965|966|967|968|969|970|971|977|978|980|981|982|983|984|985|986|987|988|989|991|992|993|994|995|996|997|999)[0-9]{7})$';
			    						var mapApiKey='AIzaSyB8iFef69IFtMBr5wZqJycu0Mugw8Y_aHg';
			    						var mapchannel='olx-eu-ua-prod';
			    						var fb_connect_url='https://connect.facebook.net/ru_UA/all.js#xfbml=1&amp;appId=1535830993316424';
			    						var fb_app_id='1535830993316424';
			    						var ad_title='<? echo $title; ?>';
			    						var region_id='21';
			    						var subregion_id='121';
			    						var city_id='121';
			    						var cat_path='elektronika/noutbuki-i-aksesuary/noutbuki';
			    						var saveFavLink="https://www.olxbox.info/account/?origin=observepopup&ref%5B0%5D%5Bdocument%5D=igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html&ref%5B0%5D%5Baction%5D=ad&ref%5B0%5D%5Bmethod%5D=index";
			    						var marker_default='https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/img/maps/marker_default.png';
			    						var marker_zone='https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/img/maps/marker_zone.png';
			    						var adID='613795209';
			    						var equal_address_provided='0';
			    						var messageSent='';
			    						var map_show_detailed='0';
			    						var regionName="\u0414\u043d\u0435\u043f\u0440\u043e\u043f\u0435\u0442\u0440\u043e\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c";
			    						var subregionName="\u0414\u043d\u0435\u043f\u0440\u043e\u043f\u0435\u0442\u0440\u043e\u0432\u0441\u043a";
			    						var category_id='80';
			    						var categoryName="\u041d\u043e\u0443\u0442\u0431\u0443\u043a\u0438";
			    						var categoryCode="noutbuki";
			    						var categoryAdsenseText=null;
			    						var root_category_id='37';
			    						var rootCategoryName="\u042d\u043b\u0435\u043a\u0442\u0440\u043e\u043d\u0438\u043a\u0430";
			    						var rootCategoryCode="elektronika";
			    						var rootCategoryAdsenseText=null;
			    						var setSeoPageName="OLX.ua - \u043e\u0431\u044a\u044f\u0432\u043b\u0435\u043d\u0438\u044f \u21161 \u0432 \u0423\u043a\u0440\u0430\u0438\u043d\u0435";
			    						var isCurrentUserSeller='';
			    						var subregion_possessive='Днепропетровска';
			    						var subregion_locative='в Днепропетровске';
			    						var csrfAddAdToObserved='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzI2NDQwNDB9.AbL4IzZ8rr0osiyy8JreGr2jHRAYC3FhUFXVlObp2KY';
			    						var csrfRemoveAdFromObserved='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzI2NDQwNDB9.AzZujvhYJm92ytHqAPWZ2rZWMM9pkfQH3TiEaqaketI';
			    						var events_break=false;
			    						var N=15;
			    						var ar_duo1=Math.floor(Math.random()*N+1);
			    						var pp_gemius_identifier=new String('0nHqv6tj9z5nRfsmP697J6RuLbo6IEODmOw0yRKw6PX.67');
			    						var gemius_script_src='https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/js/xgemius.js';
			    			    function __(txt) {
				if (typeof translations == 'object') {
							if (translations[txt] == undefined) {
								return txt;
							} else {
								return translations[txt];
							}
				}
				return txt;
			    }
			</script><script type="text/javascript" async="" src="https://sdk.privacy-center.org/sdk.5b0b9b21ca0798a5949be0fa9a17de74425c0af9.js" charset="utf-8"></script>
		        <!--[if lt IE 9]>
        	<script type="text/javascript" src="https://static-olxeu.akamaized.net/static/olxua/js/scripts/html5shiv.min.js"></script>
		<![endif]-->
			<meta name="google-site-verification" content="UCLSn2xOGJGPnxvgBEEuNKa-YugUI_NChfA_rAN19v0">

	<link rel="preload" href="https://adservice.google.ru/adsid/integrator.js?domain=www.olxbox.info" as="script"><script type="text/javascript" src="https://adservice.google.ru/adsid/integrator.js?domain=www.olxbox.info"></script><link rel="preload" href="https://adservice.google.com/adsid/integrator.js?domain=www.olxbox.info" as="script"><script type="text/javascript" src="https://adservice.google.com/adsid/integrator.js?domain=www.olxbox.info"></script><script src="https://securepubads.g.doubleclick.net/gpt/pubads_impl_2019102801.js" async=""></script><script type="text/javascript" charset="utf-8" async="" src="https://sdk.privacy-center.org/ui-ru.5b0b9b21ca0798a5949be0fa9a17de74425c0af9.js"></script><style type="text/css">:root a[href*="//top.mail.ru/jump?"], :root [title="uCoz Counter"], :root .min-width-normal > #popup_container ~ #fade, :root .min-width-normal > #popup_container, :root body > div[id^="dV"][style^="width"][style*="height"][style*="position"][style*="fixed"][style*="overflow"][style*="z-index"][style*="background"], :root a[href*="/ulike.farm"], :root .stat_pixel_yes[onclick][class*="_layout_"][class*="_format_"], :root .serp-list_left_yes[aria-label="Результаты поиска"] > .t-construct-adapter__adv, :root .serp-list + .serp-list > .serp-adv__head ~ .serp-item, :root .i-bem.b-timetable__row[onclick*="awaps"], :root .content__right > .z-market_right_yes, :root body > #__promo-sticky-button__, :root .app.blog-post-page .secondary-header-ad-block, :root div[style="width: 252px; height: 450px; position: fixed; right: 0px; top: 0px; overflow: hidden; z-index: 10000;"], :root object[data^="blob"], :root noindex > .search_result[class*="search_result_"], :root img[width="468"][height="60"], :root iframe[src*="utraff.com"], :root iframe[src*="ads.exosrv.com"], :root iframe[src*="/mixadv_"], :root iframe[src*="/3647.tech"], :root iframe[id^="republer"], :root div[id^="zcbclk"], :root div[id^="trafmag_"], :root div[id^="tizerws_"], :root div[id^="smi2adblock_"], :root div[id^="sblock_inform_"], :root div[id^="rtn4p"], :root div[id^="news_nest_net_ru"], :root div[id^="news_nest_msk_ru"], :root div[id^="news_2xclick_ru_"], :root div[id^="join_informer_"], :root div[id^="gnezdo_ru_"], :root div[id^="b_tz_"], :root div[id^="ads_games_"], :root div[id^="admixer_"], :root div[id^="M"][id*="Composite"], :root div[id^="DIV_DA_"], :root div[id*="Teaser_Block"], :root div[class^="da-ya-widget"], :root div[class*="relap"][class*="-rec-item"], :root a[onclick*="trtkp.ru"], :root a[onclick*="offergate-amigo"], :root a[onclick*="n284adserv.com"], :root a[href^="https://www.juicer.io?referrer="], :root a[href^="https://msetup.pro"], :root a[href^="https://kshop"][href*=".pro/"], :root a[href^="http://trafmaster.com"], :root a[href^="http://traderstart.mirtesen.ru"], :root a[href^="http://reals-story.ru/"], :root a[href^="http://luckiestclick.com/goto."], :root a[href^="http://kshop.biz/"], :root a[href^="http://datxxx.com"], :root a[href^="http://browserload.info/"], :root a[href^="http://apytrc.com/click/"], :root a[href^="http://amigodistr.ru/"], :root a[href="http://advert.mirtesen.ru/"], :root a[href*="zdravo-med.ru"], :root a[href*="trklp.ru"], :root a[href*="traflabs.xyz"], :root a[href*="trafgid.xyz"], :root div[id^="CGCandy"], :root a[href*="tptrk.ru"], :root a[href*="torrentum.ru"], :root a[href*="top-info24.ru"], :root a[href*="shakesclick.com"], :root a[href*="shakescash.com"], :root a[href*="shakes.pro"], :root a[href*="sapmedia.ru"], :root a[href*="problogrus.ru"], :root a[href^="https://homyanus.com"], :root a[href*="please-direct.me"], :root a[href*="please-direct.com"], :root a[href*="sviruniversal.com/"], :root a[href*="octoclick.net"], :root a[href*="marketgid.com/"], :root a[href*="navaxudoru.com"], :root a[href*="lifebloggersz.ru"], :root a[href*="https://relap.io/r?"], :root a[href*="herrabjec.pro"], :root a[href*="goext.info"], :root a[href*="gocdn.ru"], :root a[href*="go.ad2up.com"], :root a[href*="ftpglst.com"], :root a[href*="flylinks.pw"], :root a[href*="films.ws"], :root a[href*="filebase.me"], :root a[href*="cpl11.ru"], :root a[href*="cpl1.ru"], :root a[href*="cpagetti1.com"], :root a[href*="cmsmodnews.com"], :root a[href*="bubblesmedia.ru/sb/clk/"], :root a[href*="blogers-story.ru"], :root a[href*="shakesin.com"], :root a[href*="bgrndi.com"], :root a[href*="beststbuy.ru"], :root a[href*="bestforexplmdb.com"], :root a[href*="best-zdrav.ru"], :root a[href*="best-zdorovye.ru"], :root a[href*="beauty-list.ru"], :root a[href*="medinforms.ru"], :root a[href*="awesomeredirector"], :root a[href*="amigo-biz.ru/ads/click"], :root a[href*="amgfile.ru"], :root a[href*="ads2-adnow.com"], :root a[href*="://rendersaveron.com"], :root a[href*="tvkw.ru"], :root a[href*="://etcodes.com/"], :root a[href*="://clickstats.online/"], :root a[href*="://adv-views.com"], :root a[href*="/universalsrc.net/"], :root a[href*="/universalsrc.com/"], :root a[href^="http://fly-shops.ru"], :root a[href*="/universal-lnk.net/"], :root a[href*="/uni-lnk.com/"], :root a[href*="/uloads.ru/"], :root a[href*="/u-loads.ru/"], :root a[href*="/u-load.ru/"], :root a[href*="/onvix.tv/promo/"][target=_blank], :root a[href*="/myuniversalnk.com/"], :root a[href*="/mosday.ru/ad/"], :root a[href*="/kshop3.biz"], :root iframe[src*="marketgid.com"], :root a[href*="/getdriverpack.ru"], :root a[href*="/get-torrent.ru"], :root a[href*="/fastvk.com"], :root a[href*="/ber-ter.com"], :root iframe[src*="laim.tv/rotator/"], :root a[href*="/advertisesimple.info"], :root a[href*="//viruniversal.com/"], :root a[href*="//universalut.info/"], :root a[href*="//universalse.info/"], :root a[href*="kodielinktrust.ru"], :root a[href*="//universalin.info/"], :root a[href*="//ubar.pro"], :root a[href*="//ubar-pro.ru"], :root a[href*="//ubar-pro"], :root a[href*="//reruniversal.com/"], :root a[href*="trtkp.ru"], :root a[href*="//fofuvipibo.com/"], :root a[href*="advertwebgid.ru"], :root a[href*="//ext-load.net"], :root a[href*="//do-rod.com/"], :root a[href*=".twkv.ru"], :root a[href*=".pokupkins.ru"], :root .app.blog-post-page #blog-post-item-video-ad, :root a[href*=".1liveinternet.ru"], :root a[href*="katuhus.com"], :root a[data-href*="recreativ.ru"], :root [onclick*="trklp.ru"], :root [onclick*="/sb/clk/"], :root [onclick*=".twkv.ru"], :root [id^="relap-custom-iframe-rec"], :root [href*="pigiuqproxy.com"], :root [href*="driftawayforfun.com"], :root [href*="/zfvklk.ru"], :root [href*="/vaigowoa.com"], :root [data-link*="/sb/clk/"], :root .header-banner > #moneyback[target="_blank"], :root .base-page_left-side > #left_ban, :root .base-page_center > .banerTop, :root #adv_unisound ~ #main > #slidercontentContainer, :root #PopWin[onmousemove], :root #MT_overroll ~ div[class][style="left:0px;top:0px;height:480px;width:650px;"], :root topadblock, :root input[onclick^="window.open('http://www.FriendlyDuck.com/"], :root img[alt^="Fuckbook"], :root iframe[src^="http://static.mozo.com.au/strips/"], :root iframe[src^="http://cdn2.adexprt.com/"], :root iframe[id^="google_ads_iframe"], :root a[href*="rexchange.begun.ru/rclick?"], :root header#hdr + #main > div[data-hveid], :root div[id^="zergnet-widget"], :root div[id^="traffective-ad-"], :root div[id^="sticky_ad_"], :root div[id^="q1-adset-"], :root div[id^="proadszone-"], :root div[id^="mainads"], :root a[href*="land-gooods.ru"], :root div[id^="lazyad-"], :root div[id^="google_dfp_"], :root div[id^="google_ads_iframe_"], :root div[id^="drudge-column-ads-"], :root div[id^="dmRosAdWrapper"], :root a[href^="http://at.atwola.com/"], :root a[onmousedown^="this.href='https://paid.outbrain.com/network/redir?"][target="_blank"] + .ob_source, :root div[id^="div-ads-"], :root a[href*="lifenews24x7.ru"], :root .base-page_container > .banerRight, :root a[data-obtrack^="http://paid.outbrain.com/network/redir?"], :root a[href^="http://www1.clickdownloader.com/"], :root div[id^="cns_ads_"], :root #\5f _admvnlb_modal_container, :root div[id^="adspot-"], :root a[href^="http://olivka.biz/"], :root input[onclick^="window.open('http://www.friendlyduck.com/"], :root div[id^="ads300_250-widget"], :root div[id^="ads250_250-widget"], :root a[href*="trk-1.com"], :root div[id^="adrotate_widgets-"], :root div[id^="adfox_"], :root div[id^="ad_script_"], :root div[id^="ad_rect_"], :root #content > #right > .dose > .dosesingle, :root div[id^="ad_bigbox_"], :root div[id^="ad-server-"], :root div[id^="acm-ad-tag-"], :root div[id^="ADV-SLOT-"], :root div[data-native_ad], :root a[href^=" http://n47adshostnet.com/"], :root div[data-id^="CarouselPLA-"] > .kzwEHf, :root div[class^="proadszone-"], :root div[class^="pane-google-admanager-"], :root a[href^="http://adultgames.xxx/"], :root a[href^="http://semi-cod.com/clicks/"], :root div[class^="index_displayAd_"], :root a[href^="http://www.affbuzzads.com/affiliate/"], :root div[class^="index_adBeforeContent_"], :root a[href*="tvroff.net"], :root div[class^="index_adAfterContent_"], :root iframe[src^="http://cdn1.adexprt.com/"], :root a[href^="http://dwn.pushtraffic.net/"], :root div[class^="hp-ad-rect-"], :root div[class^="block-openx-"], :root a[href*="linkmyc.com"], :root div[class^="ads-partner-"], :root div[class^="ad_position_"], :root img[width="728"][height="90"], :root div[class^="ad_border_"], :root a[href^="http://adprovider.adlure.net/"], :root div[class^="Ad__container"], :root div[id^="div-adtech-ad-"], :root div[class*="_AdInArticle_"], :root div > [class][onclick*=".updateAnalyticsEvents"], :root a[href^="http://internalredirect.site/"], :root bottomadblock, :root a[href^="http://c.actiondesk.com/"], :root aside[id^="div-gpt-ad"], :root div[id^="ad-cid-"], :root a[href^="http://lp.ezdownloadpro.info/"], :root a[href^="http://uploaded.net/ref/"], :root aside[id^="advads_ad_widget-"], :root aside[id^="adrotate_widgets-"], :root a[href*="shakespoint.com"], :root a[target="_blank"][href^="http://api.taboola.com/"], :root a[style="display:block;width:300px;min-height:250px"][href^="http://li.cnet.com/click?"], :root a[onmousedown^="this.href='http://paid.outbrain.com/network/redir?"][target="_blank"] + .ob_source, :root a[href*=".orgsales.ru"], :root a[href^="http://popup.taboola.com/"], :root a[href^="//adbit.co/?a=Advertise&"], :root a[onmousedown^="this.href='/wp-content/embed-ad-content/"], :root div[class^="AdhesionAd_"], :root div[class^="Ad__bigBox"], :root div[role="navigation"] + c-wiz > script + div > .kxhcC, :root a[onclick*="//m.economictimes.com/etmack/click.htm"], :root a[href*="offhealth.ru"], :root a[href^="https://www.what-sexdating.com/"], :root a[href^="https://www.travelzoo.com/oascampaignclick/"], :root a[href^="https://www.share-online.biz/affiliate/"], :root a[href^="https://www.securegfm.com/"], :root div[id^="advads_"], :root a[href^="https://www.moscarossa.biz/"], :root a[href^="http://www.usearchmedia.com/signup?"], :root a[onmousedown^="this.href='http://staffpicks.outbrain.com/network/redir?"][target="_blank"] + .ob_source, :root a[href^="https://www.incontri-matura.com/"], :root a[href^="https://www.goldenfrog.com/vyprvpn?offer_id="][href*="&aff_id="], :root div[id^="advertur_"], :root .trc_related_container div[data-item-syndicated="true"], :root a[href^="https://www.firstload.com/affiliate/"], :root a[href^="https://www.clicktraceclick.com/"], :root a[href^="https://www.camyou.com/?cam="][href*="&track="], :root a[href^="https://www.bebi.com"], :root a[href^="https://www.adskeeper.co.uk/"], :root a[href*="://clickstats.pw/"], :root a[href^="http://pan.adraccoon.com?"], :root div[id^="ad-gpt-"], :root a[href^="http://farm.plista.com/pets"], :root a[href^="https://windscribe.com/promo/"], :root a[href^="http://serve.williamhill.com/promoRedirect?"], :root a[href^="https://vodexor.us/"], :root div[id^="tms-ad-dfp-"], :root a[href^="https://trust.zone/go/r.php?RID="], :root a[href^="https://track.adform.net/"], :root a[href^="https://traffic.bannerator.com/"], :root a[href^="https://tracking.truthfinder.com/?a="], :root a[href*="/myuniversalnk.net/"], :root a[href^="https://www.adultempire.com/"][href*="?partner_id="], :root a[href^="https://track.healthtrader.com/"], :root a[href^="https://track.clickmoi.xyz/"], :root [id^="newPortal_informer_"], :root a[href^="https://track.afftck.com/"], :root div[class^="da-widget-"], :root a[href^="https://control.trafficfabrik.com/"], :root a[href^="https://track.52zxzh.com/"], :root div[class^="gemini-ad"], :root a[href*="/onvix.co/promo/"][target=_blank], :root a[href^="http://pwrads.net/"], :root a[href^="//oardilin.com/"], :root a[href^="http://gca.sh/user/register?ref="], :root a[href^="https://torguard.net/aff.php"], :root a[href*="litewebbusiness.com"], :root a[href^="http://tour.affbuzzads.com/"], :root a[href^="https://tc.tradetracker.net/"], :root a[href^="https://t.mobtya.com/"], :root div[id^="ad_head_celtra_"], :root a[href^="https://t.grtyi.com/"], :root aside[id^="tn_ads_widget-"], :root a[href^="https://syndication.exoclick.com/splash.php?"], :root a[href^="http://hitcounter.ru/top/stat.php"], :root a[href^="http://click.guamwnvgashbkashawhgkhahshmashcas.pw/"], :root div[id^="YFBMSN"], :root div[id^="ad-div-"], :root a[href^="https://secure.eveonline.com/ft/?aid="], :root a[href^="https://rev.adsession.com/"], :root a[href^="https://retiremely.com/"], :root div[id^="yandex_ad"], :root a[href^="http://y1jxiqds7v.com/"], :root a[href^="https://www.pornhat.com/"][rel="nofollow"], :root AD-SLOT, :root a[href^="http://green.trafficinvest.com/"], :root a[href^="https://pubads.g.doubleclick.net/"], :root a[href^="https://prf.hn/click/"][href*="/adref:"], :root a[href^="https://mk-cdn.net/"], :root a[href^="https://mk-ads.com/"], :root a[href^="https://jmp.awempire.com/"], :root a[href^="https://members.linkifier.com/public/affiliateLanding?refCode="], :root a[href*="/amigo-browser.ru"][target="_blank"], :root a[href^="https://medleyads.com/"], :root div[id^="ads300_100-widget"], :root a[href^="https://click.plista.com/pets"], :root a[href^="https://lingthatsparleso.info/"], :root a[href*=".approvallamp.club/"], :root a[href^="https://landing1.brazzersnetwork.com"], :root a[href^="https://land.rk.com/landing/"], :root .lads[width="100%"][style="background:#FFF8DD"], :root a[href^="https://land.brazzersnetwork.com/landing/"], :root a[href^="https://incisivetrk.cvtr.io/click?"], :root a[href^="https://iactrivago.ampxdirect.com/"], :root a[href^="https://googleads.g.doubleclick.net/pcs/click"], :root a[href^="http://cdn.adstract.com/"], :root a[href^="https://gogoman.me/"], :root a[href^="https://go.stripchat.com/"][href*="&campaignId="], :root a[href*=".inclk.com/"], :root a[href^="https://go.ad2up.com/"], :root a[href^="https://freeadult.games/"], :root a[href*="info-blog24.ru"], :root a[href^="//nlkdom.com/"], :root a[onmousedown^="this.href='http://staffpicks.outbrain.com/network/redir?"][target="_blank"], :root a[href^="https://fonts.fontplace9.com/"], :root a[href^="http://clkmon.com/adServe/"], :root a[href^="https://flirtaescopa.com/"], :root img[width="160"][height="600"], :root a[href^="https://evaporate.pw/"], :root a[href*="down-news-games.ru"], :root a[href^="http://wxdownloadmanager.com/dl/"], :root div[class^="local-feed-banner-ads"], :root .GFYY1SVE2 > .GFYY1SVD2 > .GFYY1SVG5, :root a[href^="https://djtcollectorclub.org/"][href*="?affiliate_id="], :root a[href*="twtn.ru/"], :root a[href^="https://chaturbate.xyz/"], :root a[href^="https://chaturbate.jjgirls.com/"][href*="?tour="], :root a[href^="https://chaturbate.com/in/?tour="], :root a[href^="https://chaturbate.com/affiliates/"], :root a[href^="http://www.1clickdownloader.com/"], :root a[href^="https://www.googleadservices.com/pagead/aclk?"], :root a[href^="https://awentw.com/"], :root a[href^="https://servedbyadbutler.com/"], :root a[href^="http://dethao.com/"], :root a[href^="https://ads.ad4game.com/"], :root a[href^="https://betway.com/"][href*="&a="], :root a[href^="https://affiliates.bet-at-home.com/processing/"], :root a[href*="pussl3.com"], :root a[href^="https://adswick.com/"], :root ADS-RIGHT, :root .GKJYXHBF2 > .GKJYXHBE2 > .GKJYXHBH5, :root a[href^="https://adserver.adreactor.com/"], :root a[href^="https://refpaano.host/"], :root a[href^="https://meet-to-fuck.com/tds"], :root a[href*="/loaderu.ru/"], :root a[href^="http://data.linoleictanzaniatitanic.com/"], :root a[href^="https://adhealers.com/"], :root a[href^="https://adclick.g.doubleclick.net/"], :root a[href^="https://ad.doubleclick.net/"], :root a[href^="http://zevera.com/afi.html"], :root a[href^="http://go.oclaserver.com/"], :root a[href^="https://ad.atdmt.com/"], :root .trc_rbox .syndicatedItem, :root a[href^="https://aaucwbe.com/"], :root a[href^="https://a.adtng.com/"], :root a[href^="http://xtgem.com/click?"], :root a[href^="https://ads.trafficpoizon.com/"], :root a[href^="http://rekoverr.com/"], :root a[href^="https://chaturbate.com/in/?track="], :root a[href*="/yfiles1.ru"], :root a[href^="http://www.zergnet.com/i/"], :root a[href^="http://hyperies.info/"], :root a[href^="http://galleries.pinballpublishernetwork.com/"], :root a[href^="http://www.torntv-downloader.com/"], :root a[href^="http://www.tirerack.com/affiliates/"], :root a[href^="http://www.text-link-ads.com/"], :root a[href^="http://www.streamate.com/exports/"], :root a[onmousedown^="this.href='https://paid.outbrain.com/network/redir?"][target="_blank"], :root a[href^="http://www.sfippa.com/"], :root a[href*="kma1.biz"], :root a[href^="http://www.xmediaserve.com/"], :root a[href^="http://www.sex.com/videos/?utm_"], :root a[href^="http://paid.outbrain.com/network/redir?"], :root a[href^="http://www.sex.com/?utm_"], :root a[onmousedown^="this.href='http://paid.outbrain.com/network/redir?"][target="_blank"], :root a[href^="http://www.roboform.com/php/land.php"], :root a[href*="joycasino.com/?partner="], :root a[href*="idealmedia.io"], :root a[href^="http://www.myfreecams.com/?co_id="][href*="&track="], :root div[id^="advads-"], :root a[href^="https://k2s.cc/pr/"], :root a[href^="http://ad.au.doubleclick.net/"], :root a[href^="http://www.ringtonematcher.com/"], :root a[href^="http://secure.signup-page.com/"], :root a[href^="http://www.quick-torrent.com/download.html?aff"], :root a[href^="http://adexprt.me/"], :root a[href^="http://www.pinkvisualgames.com/?revid="], :root a[href^="http://glprt.ru/affiliate/"], :root a[href^="https://trklvs.com/"], :root a[href^="http://www.paddypower.com/?AFF_ID="], :root div[data-spotim-slot], :root a[href^="http://www.freefilesdownloader.com/"], :root a[href^="http://www.mysuperpharm.com/"], :root .trc_rbox_border_elm .syndicatedItem, :root a[href^="http://www.myfreepaysite.com/sfw_int.php?aid"], :root a[href^="http://www.myfreepaysite.com/sfw.php?aid"], :root .rhsvw[style="background-color:#fff;margin:0 0 14px;padding-bottom:1px;padding-top:1px;"], :root a[href^="http://www.moneyducks.com/"], :root a[href^="http://bcntrack.com/"], :root a[href^="http://www.securegfm.com/"], :root a[href^="http://www.liversely.net/"], :root a[href^="http://www.linkbucks.com/referral/"], :root a[href^="//88d7b6aa44fb8eb.com/"], :root a[href^="http://www.ireel.com/signup?ref"], :root a[href*="realgoodies.ru"], :root a[href*="/onvix.me/promo/"][target=_blank], :root a[href*="=Adtracker"], :root a[href^="http://www.incredimail.com/?id="], :root a[href^="http://www.idownloadplay.com/"], :root a[href^="http://www.hitcpm.com/"], :root a[href^="http://www.greenmangaming.com/?tap_a="], :root a[href^="http://www.gamebookers.com/cgi-bin/intro.cgi?"], :root div[id^="div_openx_ad_"], :root a[href^="http://www.friendlyquacks.com/"], :root a[href^="https://www.financeads.net/tc.php?"], :root a[href^="http://www.friendlyduck.com/AF_"], :root a[href*="emprestimo.eu"], :root a[href^="http://www.fpcTraffic2.com/blind/in.cgi?"], :root a[href^="http://tds-2.ru"], :root a[href^="http://www.fonts.com/BannerScript/"], :root a[href^="http://www.fleshlight.com/"], :root a[href^="http://www.flashx.tv/downloadthis"], :root a[href*="//loderls.ru"], :root .trc_rbox_div a[target="_blank"][href^="http://tab"], :root a[href^="https://americafirstpolls.com/"], :root a[href^="http://clickserv.sitescout.com/"], :root a[href^="http://www.firstload.de/affiliate/"], :root a[href^="http://www.twinplan.com/AF_"], :root a[href^="http://www.fducks.com/"], :root a[href*="/rlink/simptizer/"], :root a[href^="http://marketgid.com"], :root a[href^="http://www.faceporn.net/free?"], :root a[href^="http://www.epicgameads.com/"], :root a[href^="http://www.easydownloadnow.com/"], :root a[href^="http://www.duckssolutions.com/"], :root a[href^="https://go.trkclick2.com/"], :root a[href^="http://www.duckcash.eu/"], :root div[id^="yandex_rtb"], :root a[href^="http://www.drowle.com/"], :root a[href^="http://go.seomojo.com/tracking202/"], :root a[href^="http://www.downloadweb.org/"], :root .commercial-unit-mobile-top .jackpot-main-content-container > .UpgKEd + .nZZLFc > .vci, :root a[href^="http://www.installads.net/"], :root div[role="navigation"] + c-wiz > div > .kxhcC, :root a[href^="http://www.download-provider.org/"], :root a[href^="http://www.down1oads.com/"], :root a[href^="https://trafficmedia.center/"], :root a[href^="http://www.dealcent.com/register.php?affid="], :root .rscontainer > .ellip, :root a[href^="http://www.clkads.com/adServe/"], :root a[href^="http://www.clickansave.net/"], :root div[class^="adpubs-"], :root a[href*="deliver.trafficfabrik.com"], :root a[href^="http://www.cash-duck.com/"], :root a[href^="http://www.bitlord.me/share/"], :root div[id^="republer_"], :root a[href^="http://www.bet365.com/"][href*="?affiliate="], :root a[href^="http://www.bet365.com/"][href*="&affiliate="], :root a[href*="//universalini.info/"], :root a[href^="http://www.badoink.com/go.php?"], :root a[href*="/clubleads.ru"], :root #mbEnd[cellspacing="0"][cellpadding="0"], :root div[data-ad-underplayer], :root a[href^="http://www.richducks.com/"], :root a[href*="medicalblogs.ru"], :root a[href^="http://www.babylon.com/welcome/index?affID"], :root a[href^="http://www.sexgangsters.com/?pid="], :root a[href^="http://www.amazon.co.uk/exec/obidos/external-search?"], :root a[href^="https://ads-for-free.com/click.php?"], :root DIV[id^="DIV_NNN_"], :root a[href^="http://tracker.mybroadband.co.za/"], :root a[href^="http://www.socialsex.com/"], :root a[href^="https://www.camsoda.com/enter.php?id="], :root [data-leadlink*="admitlead."][data-leadlink*="/sb/clk/"], :root a[href^="http://www.afco2go.com/srv.php?"], :root a[href^="http://go.ad2up.com/"], :root a[href^="https://badoinkvr.com/"], :root a[href*="/adServe/banners?"], :root a[href^="http://www.adxpansion.com"], :root a[href^="http://www.ragazzeinvendita.com/?rcid="], :root .plistaList > .itemLinkPET, :root a[href^="http://www.adbrite.com/mb/commerce/purchase_form.php?"], :root a[href^="http://www.TwinPlan.com/AF_"], :root #rhs_block .mod > .gws-local-hotels__booking-module, :root a[href^="http://www.my-dirty-hobby.com/?sub="], :root a[href^="https://porndeals.com/?track="], :root a[href^="http://www.affiliates1128.com/processing/"], :root a[href^="http://c.jumia.io/"], :root a[href^="http://www.1clickmoviedownloader.info/"], :root div[class^="adbanner_"], :root a[href^="http://www.brightwheel.info/"], :root a[href*="//loderna.ru"], :root a[href^="http://www.123-reg.co.uk/affiliate2.cgi"], :root div[itemtype="http://www.schema.org/WPAdBlock"], :root a[href^="http://wopertific.info/"], :root a[href^="http://bodelen.com/"], :root a[href^="http://wgpartner.com/"], :root a[href^="http://webgirlz.online/landing/"], :root a[href*="netcrys.com"], :root div[id^="ads300_600-widget"], :root a[href*="thor-media.ru/click/"], :root div[class^="Ad__adContainer"], :root div[class^="block_fortress"], :root a[href^="http://web.adblade.com/"], :root div[class^="BlockAdvert-"], :root a[href^="https://go.onclasrv.com/"], :root img[src*="top.mail.ru/counter?"], :root a[href^="http://wct.link/"], :root a[href^="http://s9kkremkr0.com/"], :root a[href^="https://www.nutaku.net/signup/landing/"], :root a[href^="http://us.marketgid.com"], :root a[href^="http://ul.to/ref/"], :root a[href^="http://trk.mdrtrck.com/"], :root a[href^="http://traffic.tc-clicks.com/"], :root div[class^="awpcp-random-ads"], :root a[href^="http://www.graboid.com/affiliates/"], :root a[href^="http://tracking.toroadvertising.com/"], :root a[href*="retagapp.com"], :root a[href^="http://www.liutilities.com/"], :root a[href^="http://www.dl-provider.com/search/"], :root a[href^="http://tracking.deltamediallc.com/"], :root a[href^="http://adultfriendfinder.com/p/register.cgi?pid="], :root a[href^="https://www.popads.net/users/"], :root iframe[src^="http://ad.yieldmanager.com/"], :root a[href^="http://pubads.g.doubleclick.net/"], :root a[href^="https://sexdatingz.live/"], :root a[href^="//bwnjijl7w.com/"], :root a[href^="https://adultfriendfinder.com/go/page/landing"], :root a[href^="http://tracking.crazylead.com/"], :root a[href*="://renderbrandium.com"], :root a[href^="http://track.adform.net/"], :root a[href^="https://iac.ampxdirect.com/"], :root a[href^="http://t.mdn2015x3.com/"], :root a[href*="sandratand.ru"], :root a[href^="http://steel.starflavor.bid/"], :root a[href^="http://galleries.securewebsiteaccess.com/"], :root a[href^="http://stateresolver.link/"], :root a[href^="http://sharesuper.info/"], :root a[href^="https://awecrptjmp.com/"], :root img[src^="/stat/"][width="88"][height="31"], :root a[href*="rapidtor.ru/sb/clk/"], :root a[href^="http://server.cpmstar.com/click.aspx?poolid="], :root a[href^="http://www.downloadthesefiles.com/"], :root a[href^="http://secure.cbdpure.com/aff/"], :root .base-page_center > .banerTopOver, :root a[href^="http://t.mdn2015x1.com/"], :root a[href^="http://azmobilestore.co/"], :root a[href^="http://s5prou7ulr.com/"], :root #\5f _mom_ad_2, :root a[href^="http://ads.sprintrade.com/"], :root a[href^="http://record.commissionking.com/"], :root div[class*="-storyBodyAd-"], :root a[href^="http://record.betsafe.com/"], :root a[href^="https://keep2share.cc/pr/"], :root a[href^="https://clixtrac.com/"], :root [onclick*="content.ad/"], :root a[href^="http://adlev.neodatagroup.com/"], :root a[href^="http://reallygoodlink.extremefreegames.com/"], :root body > iframe[style^="position"][style*="fixed"][id^="iFb"][src^="/?"], :root .ob_container .item-container-obpd, :root a[href^="http://www.adskeeper.co.uk/"], :root a[href^="http://websitedhoome.com/"], :root a[href^="http://see-work.info/"], :root a[href^="http://prousa.work/"], :root a[href*="top.24smi.info"], :root a[href^="http://promos.bwin.com/"], :root a[href^="http://prochina.link/"], :root a[href*="//yojlf.com"], :root a[href*=".irtyc.com/"], :root a[href^="http://z1.zedo.com/"], :root a[href^="http://pokershibes.com/index.php?ref="], :root #rhs_block .mod > .luhb-div > div[data-async-type="updateHotelBookingModule"], :root a[href^="http://mojofun.info/"], :root a[href^="http://mmo123.co/"], :root iframe[src*="traffic-media.co"], :root a[href^="http://media.paddypower.com/redirect.aspx?"], :root a[href*=".qertewrt.com/"], :root a[href^="//pubads.g.doubleclick.net/"], :root a[href^="http://lp.ncdownloader.com/"], :root a[href^="http://allaptair.club/"], :root .base-page_center > .banerBottom, :root #rhs_block .xpdopen > ._OKe > div > .mod > ._yYf, :root a[href^="//ads.ad-center.com/"], :root a[href^="https://track.trkinator.com/"], :root a[data-redirect^="this.href='http://paid.outbrain.com/network/redir?"], :root div[id^="ad-position-"], :root a[href^="http://liversely.com/"], :root a[href*="mixadvert.com"], :root a[href*="/ogclick.com/api/redirect"], :root a[href^="https://www.arthrozene.com/"][href*="?tid="], :root a[href^="http://feeds1.validclick.com/"], :root a[href^="http://latestdownloads.net/download.php?"], :root a[href^="http://k2s.cc/code/"], :root #topstuff > #tads, :root a[href^="https://atomidownload.com/"], :root a[href*=".bang.com/"][href*="&aff="], :root a[href*="ultrabit.ws"], :root a[data-widget-outbrain-redirect^="http://paid.outbrain.com/network/redir?"], :root a[href^="http://join3.bannedsextapes.com/track/"], :root a[href*="/afftraf.co/"], :root a[href^="https://secure.bstlnk.com/"], :root a[href^="http://jobitem.org/"], :root a[href^="https://gamescarousel.com/"], :root a[href^="http://istri.it/?"], :root a[href^="http://www.fbooksluts.com/"], :root a[href^="http://www.cdjapan.co.jp/aff/click.cgi/"], :root a[href^="//api.ad-goi.com/"], :root a[href*="//ridingintractable.com/"], :root a[href^="http://intent.bingads.com/"], :root div[id^="crt-"][style], :root a[href^="http://igromir.info/"], :root a[href^="https://track.themadtrcker.com/"], :root a[href^="http://hyperlinksecure.com/go/"], :root a[href*="//universalies.info/"], :root a[href^="http://45eijvhgj2.com/"], :root a[href^="http://hpn.houzz.com/"], :root a[href*="://et-cod.com/"], :root a[href^="http://searchtabnew.com/"], :root a[href*="?adlivk="][href*="&refer="], :root a[href^="//look.djfiln.com/"], :root a[href*="muz-loader.site"], :root a[href^="http://greensmoke.com/"], :root a[href^="https://bnsjb1ab1e.com/"], :root a[href^="http://mo8mwxi1.com/"], :root div[class^="ResponsiveAd-"], :root div[id^="criteo-"][style], :root a[href^="http://install.securewebsiteaccess.com/"], :root a[href^="http://www.revenuehits.com/"], :root div[id^="block-views-topheader-ad-block-"], :root a[href^="https://bs.serving-sys.com"], :root .__y_elastic .__y_item, :root a[href^="http://go.mobisla.com/"], :root a[href^="//srv.buysellads.com/"], :root a[href^="http://g1.v.fwmrm.net/ad/"], :root .widget-pane-section-result[data-result-ad-type], :root a[href^="http://imads.integral-marketing.com/"], :root a[href^="http://freesoftwarelive.com/"], :root a[href^="http://adtrackone.eu/"], :root a[href^="http://finaljuyu.com/"], :root a[href^="https://paid.outbrain.com/network/redir?"], :root a[href^="http://fileupnow.rocks/"], :root a[href^="http://fileloadr.com/"], :root a[href^="https://dltags.com/"], :root a[href^="http://onclickads.net/"], :root a[href^="https://gghf.mobi/"], :root a[href^="http://www.terraclicks.com/"], :root a[href*="refpazus.top"], :root a[href^="http://www.coinducks.com/"], :root a[href^="http://extra.bet365.com/"][href*="?affiliate="], :root a[href^="http://ethfw0370q.com/"], :root a[href^="https://bongacams"][href*="com/track?"], :root [id^="bunyad_ads_"], :root a[href^="http://elitefuckbook.com/"], :root a[href^="https://www.brazzersnetwork.com/landing/"], :root #cnt #center_col > #taw > #tvcap > .c._oc._Lp, :root [href*="//xml.revrtb.com/"], :root a[href^="http://elite-sex-finder.com/?"], :root a[href*="kinqon.ru"], :root a[href^="http://eclkmpsa.com/"], :root [data-link*="amigo-browser.ru/dkit-"], :root a[href*="//3wr110.xyz/"], :root a[href^="http://earandmarketing.com/"], :root a[href^="https://www.mypornstarcams.com/landing/click/"], :root a[href*=".intab.fun/"], :root a[href^="http://secure.signup-way.com/"], :root [href^="https://maskip.co/"], :root a[href^="http://getlinksinaseconds.com/"], :root #content > #center > .dose > .dosesingle, :root a[href^="http://campaign.bharatmatrimony.com/track/"], :root a[href^="http://d2.zedo.com/"], :root a[href*="re-directme.com"], :root a[href^="http://keep2share.cc/pr/"], :root a[href^="http://cp.cbbp1.com"], :root a[href^="http://contractallsticker.net/"], :root a[href^="http://codec.codecm.com/"], :root a[href^="//5e1fcb75b6d662d.com/"], :root a[href^="http://googleads.g.doubleclick.net/pcs/click"], :root div[id^="ads120_600-widget"], :root a[href^="https://awejmp.com/"], :root a[href^="http://clk.directrev.com/"], :root a[href^="http://clicks.guamwnvgashbkashawhgkhahshmashcas.pw/"], :root a[href^="http://www.downloadplayer1.com/"], :root a[href^="http://clicks.binarypromos.com/"], :root div[class^="largeRectangleAd_"], :root a[href^="https://dediseedbox.com/clients/aff.php?"], :root a[href^="http://www.wantstraffic.com/"], :root a[href^="http://databass.info/"], :root a[href^="http://www.urmediazone.com/signup"], :root a[href^="http://click.plista.com/pets"], :root a[href^="https://a.bestcontentpc.top/"], :root a[href^="http://chaturbate.com/affiliates/"], :root a[href^="http://www.firstload.com/affiliate/"], :root a[href^="http://www.friendlyadvertisements.com/"], :root a[href*="/universallnk.net/"], :root a[href^="//00ae8b5a9c1d597.com/"], :root a[href^="http://cdn3.adbrau.com/"], :root a[href^="http://get.slickvpn.com/"], :root a[href^="https://watchmygirlfriend.tv/"], :root aside[itemtype="https://schema.org/WPAdBlock"], :root a[href^="http://2pxg8bcf.top/"], :root a[href^="http://amzn.to/"] > img[src^="data"], :root a[href^="http://bs.serving-sys.com/"], :root a[href^="http://cpaway.afftrack.com/"], :root a[href^="http://cdn.adsrvmedia.net/"], :root [lazy-ad="top_banner"], :root a[href^="http://360ads.go2cloud.org/"], :root a[href^="http://dftrck.com/"], :root a[href^="http://casino-x.com/?partner"], :root a[href*="turbotraf.com"], :root div[data-flt-ve="sponsored_search_ads"], :root a[href*="ex.24smi.info"], :root a[href^="http://record.sportsbetaffiliates.com.au/"], :root a[href^="http://campeeks.com/"][href*="&utm_"], :root #flowplayer > div[style="position: absolute; width: 300px; height: 275px; left: 222.5px; top: 85px; z-index: 999;"], :root a[href^="http://download-performance.com/"], :root a[href^="http://www.on2url.com/app/adtrack.asp"], :root #\5f _nq__hh[style="display:block!important"], :root a[href^="http://guideways.info/"], :root a[href*="/installpack.net"], :root a[href^="http://campaign.bharatmatrimony.com/cbstrack/"], :root a[href^="http://ads.expekt.com/affiliates/"], :root a[href^="http://callville.xyz/"], :root a[href^="http://xads.zedo.com/"], :root a[href*="fortedrow.pro"], :root a[href^="https://bullads.net/get/"], :root a[href^="http://yads.zedo.com/"], :root a[href^="http://down1oads.com/"], :root a[href^="http://buysellads.com/"], :root a#mobtop[title="Рейтинг мобильных сайтов"], :root a[href^="https://uncensored.game/"], :root td[valign="top"] > .mainmenu[style="padding:10px 0 0 0 !important;"], :root a[href^="http://feedads.g.doubleclick.net/"], :root a[href^="http://betahit.click/"], :root a[href^="http://bestorican.com/"], :root a[href^="http://bcp.crwdcntrl.net/"], :root a[href^="http://bc.vc/?r="], :root a[href^="http://www.pheedo.com/"], :root a[href^="http://banners.victor.com/processing/"], :root a[href*="blogi-novosti.ru"], :root a[href^="http://adf.ly/?id="], :root a[href^="https://uncensored3d.com/"], :root a[href^="http://t.mdn2015x2.com/"], :root div[data-subscript="Advertising"], :root div[class$="dealnews"] > .dealnews, :root a[href^="http://click.payserve.com/"], :root a[href*="intovarro.ru"], :root a[href^="http://api.ringtonematcher.com/"], :root a[href^="http://affiliate.glbtracker.com/"], :root a[onclick*="/link-fes.ru"], :root a[href^="https://transfer.xe.com/signup/track/redirect?"], :root a[href^="http://anonymous-net.com/"], :root a[href^="https://www.dsct1.com/"], :root a[data-oburl^="https://paid.outbrain.com/network/redir?"], :root .icons-rss-feed + .icons-rss-feed div[class$="_item"], :root a[href^="http://aflrm.com/"], :root a[href^="http://affiliates.pinnaclesports.com/processing/"], :root a[href^="http://affiliate.godaddy.com/"], :root a[href^="http://partner.sbaffiliates.com/"], :root a[href^="http://affiliate.coral.co.uk/processing/"], :root a[href^="http://aff.ironsocket.com/"], :root a[href^="http://adsrv.keycaptcha.com"], :root a[href*="//12traffic.ru/"], :root a[data-redirect^="https://paid.outbrain.com/network/redir?"], :root a[href^="http://play4k.co/"], :root div[class*="spklw"][data-type="ad"], :root a[href^="http://adserving.liveuniversenetwork.com/"], :root a[href^="https://zononi.com/"], :root a[href^="http://adserving.unibet.com/"], :root a[href^="http://adtransfer.net/"], :root a[href^="http://adserver.itsfogo.com/"], :root a[href^="https://secure.adnxs.com/clktrb?"], :root a[href^="http://adserver.adtechus.com/"], :root a[href^="http://adserver.adreactor.com/"], :root a[href^="http://www.yourfuckbook.com/?"], :root a[href^="//go.onclasrv.com/"], :root .GHOFUQ5BG2 > .GHOFUQ5BF2 > .GHOFUQ5BG5, :root a[href^="http://amigodistrib.ru/dkit-hps/"], :root a[href^="http://adserver.adtech.de/"], :root a[href*="//universalie.info/"], :root a[href^="http://cwcams.com/landing/click/"], :root a[href^="http://ads.betfair.com/redirect.aspx?"], :root a[href^="http://ads.affbuzzads.com/"], :root a[href^="http://tc.tradetracker.net/"], :root a[href*="nhebd.xyz"], :root a[href^="http://online.ladbrokes.com/promoRedirect?"], :root a[href^="http://go.trafficshop.com/"], :root a[href^="http://ads.ad-center.com/"], :root div[id^="advt-"], :root a[href^="http://admingame.info/"], :root a[href^="http://adfarm.mediaplex.com/"], :root a[href^="http://ad.doubleclick.net/"], :root a[href^="https://understandsolar.com/signup/?lead_source="][href*="&tracking_code="], :root a[href^="http://ad-emea.doubleclick.net/"], :root a[href^="http://www.incredimail.com/?id"], :root a[href*="/servlet/click/zone?"], :root a[href^="http://ad-apac.doubleclick.net/"], :root div[id^="cpa_rotator_block"], :root script[src^="http://free-shoutbox.net/app/webroot/shoutbox/sb.php?shoutbox="] + #freeshoutbox_content, :root a[href^="http://hdplugin.flashplayer-updates.com/"], :root .trc_rbox_div .syndicatedItem, :root a[href^="http://data.ad.yieldmanager.net/"], :root a[href^="http://a63t9o1azf.com/"], :root a[href^="http://srvpub.com/"], :root a[href^="http://a.adquantix.com/"], :root a[href^="http://NowDownloadAll.com"], :root a[href^="http://eaplay.ru/"], :root #assetsListings[style="display: block;"], :root a[href^="http://9nl.es/"], :root a[href*="goodtrack.ru"], :root a[href^="http://abc2.mobile-10.com/"], :root object[data*="ads.com/clk.swf"], :root a[href*="/eversaree.bid"], :root a[href^="http://adtrack123.pl/"], :root [id*="MGWrap"], :root [src^="//am15.net/?"], :root a[href^="http://9amq5z4y1y.com/"], :root a[href^="http://4c7og3qcob.com/"], :root a[href^="//go.vedohd.org/"], :root a[href^="http://www.ducksnetwork.com/"], :root a[href^="http://3wr110.net/"], :root a[href^="http://prochina.space/"], :root a[href^="http://www5.smartadserver.com/call/pubjumpi/"], :root a[href^="http://1phads.com/"], :root a[href^="http://refer.webhostingbuzz.com/"], :root #MAIN.ShowTopic > .ad, :root a[href^="https://porngames.adult/?SID="], :root a[href^="http://findersocket.com/"], :root div[id^="traffim-widget"], :root a[href^="https://m.do.co/c/"] > img, :root a[href^="http://connectlinking6.com/"], :root a[href^="https://spygasm.com/track?"], :root a[href^="http://cdn3.adexprts.com/"], :root #tads + div + .c, :root a[href^="//jsmptjmp.com/"], :root a[href^="https://ilovemyfreedoms.com/"][href*="?affiliate_id="], :root a[href^="//healthaffiliate.center/"], :root a[href^="http://putanapartners.com/go."], :root [id*="ScriptRoot"], :root a[href^="//db52cc91beabf7e8.com/"], :root a[href^="http://ads.activtrades.com/"], :root .plistaList > .plista_widget_underArticle_item[data-type="pet"], :root #center_col > #taw > #tvcap > .commercial-unit-desktop-top, :root a[href^="http://www.afgr2.com/"], :root div[data-id^="div-gpt-ad-"], :root #mn div[style="position:relative"] > #center_col > ._Ak, :root a[href^="https://www.oboom.com/ad/"], :root a[href^="//4f6b2af479d337cf.com/"], :root a[href^="https://www.friendlyduck.com/AF_"], :root a[href*="gpclick.ru"], :root #center_col > #resultStats + div + #res + #tads, :root a[href^="//40ceexln7929.com/"], :root div[id^="div-gpt-ad"], :root a[href^="http://fusionads.net"], :root a[href^=" http://www.sex.com/"][href*="&utm_"], :root .section-result[data-result-ad-type], :root a[href*="/advjump.com"], :root a[href^=" http://ads.ad-center.com/"], :root div[id^="dfp-slot-"], :root .l-container > #fishtank, :root a[href^="https://fileboom.me/pr/"], :root .GPMV2XEDA2 > .GPMV2XEDP1 > .GPMV2XEDJBB, :root a[href*="onclkds."], :root #ads > .dose > .dosesingle, :root a[href*="delivery.trafficfabrik.com"], :root a[href*="=exoclick"], :root div[class^="backfill-taboola-home-slot-"], :root a[href*="=adscript"], :root #mn #center_col > div > h2.spon:first-child, :root FBS-AD, :root #BlWrapper > .b-temp_rbc, :root .ra[align="right"][width="30%"], :root a[href*="5iclx7wa4q.com"], :root a[href^="http://refpaano.host/"], :root a[href*="/cmd.php?ad="], :root a[href*=".revimedia.com/"], :root .__ywvr .__y_item, :root #\5f _mom_ad_12, :root .mywidget__col > .mywidget__link_advert, :root a[href^="http://ads.integral-marketing.com/"], :root a[href^="https://farm.plista.com/pets"], :root div[class*="td-a-rec-id-"], :root a[href*=".red90121.com/"], :root [lazy-ad="leftbottom_banner"], :root p[id^="div-gpt-ad-"], :root a[href^="http://fsoft4down.com/"], :root a[href*="ad2upapp.com/"], :root .inlineNewsletterSubscription + .inlineNewsletterSubscription div[class$="_item"], :root #taw > .med + div > #tvcap > .mnr-c:not(.qs-ic) > .commercial-unit-mobile-top, :root .plista_widget_belowArticleRelaunch_item[data-type="pet"], :root div[data-mediatype="advertising"], :root .mw > #rcnt > #center_col > #taw > #tvcap > .c, :root a[href^="https://playuhd.host/"], :root a[href^="http://mgid.com/"], :root a[href*=".adsrv.eacdn.com/"] > img, :root a[href^="http://lp.ilivid.com/"], :root div[id^="div_ad_stack_"], :root a[href*=".ichlnk.com/"], :root a[href^="http://secure.hostgator.com/~affiliat/"], :root [onclick^="window.open('http://adultfriendfinder.com/search/"], :root .mod > .gws-local-promotions__border, :root a[href^="http://data.committeemenencyclopedicrepertory.info/"], :root a[href*=".allsports4you.club"], :root a[href^="http://spygasm.com/track?"], :root .ob_dual_right > .ob_ads_header ~ .odb_div, :root a[href*="tvks.ru"], :root a[href*=".adk2x.com/"], :root a[href^="http://duckcash.eu/"], :root a[href^="http://www.mobileandinternetadvertising.com/"], :root .GB3L-QEDGY .GB3L-QEDF- > .GB3L-QEDE-, :root a[data-url^="http://paid.outbrain.com/network/redir?"] + .author, :root a[href^="http://liversely.net/"], :root a[href*="kshop2.biz"], :root .ra[width="30%"][align="right"] + table[width="70%"][cellpadding="0"], :root iframe[id^="google_ads_frame"], :root a[href^="http://www.bluehost.com/track/"] > img, :root a[data-url^="http://paid.outbrain.com/network/redir?"], :root a[href*="admitlead."][href*="/sb/clk/"], :root a[href^="http://n.admagnet.net/"], :root a[href^="http://bestchickshere.com/"], :root a[href^="http://www.streamtunerhd.com/signup?"], :root #ssmiwdiv[jsdisplay], :root a[href^="//awejmp.com/"], :root a[href^="http://www.getyourguide.com/?partner_id="], :root [onclick^="window.open('https://www.brazzersnetwork.com/landing/"], :root a[href*="a2g-secure.com"], :root #resultspanel > #topads, :root a[href^="http://espn.zlbu.net/"], :root a[href^="http://k2s.cc/pr/"], :root [onclick^="window.open('window.open('//delivery.trafficfabrik.com/"], :root a[href*="kingoablc.com"], :root a[href^="http://adrunnr.com/"], :root [lazy-ad="leftthin_banner"], :root div[class^="mixadvert"], :root [id*="MarketGid"], :root a[href*="/vkout.ru"], :root a[href^="http://www.accuserveadsystem.com/accuserve-go.php?"], :root a[href^="http://c.ketads.com/"], :root a[href^="http://6kup12tgxx.com/"], :root a[target="_blank"][onmousedown="this.href^='http://paid.outbrain.com/network/redir?"], :root [href^="https://hilltopads.com/"], :root a[href^="http://hd-plugins.com/download/"], :root a[href^="//voyeurhit.com/cs/"], :root [href*="/uni-tds.com/"], :root a[href^="http://www.afgr3.com/"], :root [ad-id^="googlead"], :root a[href^="https://topoffers.com/"][href*="/?pid="], :root a[href^="http://vinfdv6b4j.com/"], :root a[href*="webdiana.ru/click"], :root a[href^="http://bonusfapturbo.nmvsite.com/"], :root a[href^="//porngames.adult/?SID="], :root DFP-AD, :root a[href^="http://adclick.g.doubleclick.net/"], :root #main-content > [style="padding:10px 0 0 0 !important;"], :root #center_col > #resultStats + div[style="border:1px solid #dedede;margin-bottom:11px;padding:5px 7px 5px 6px"], :root div[class^="lifeOnwerAd"], :root a[href*="tdstrk.ru"], :root a[href^="http://refpa.top/"], :root a[data-oburl^="http://paid.outbrain.com/network/redir?"], :root a[href$="/vghd.shtml"], :root a[href^="https://redirect.ero-advertising.com/"], :root a[href^="http://easydownload4you.com/"], :root a[href^="http://ffxitrack.com/"], :root #center_col > #main > .dfrd > .mnr-c > .c._oc._zs, :root a[href^="http://b.bestcompleteusa.info/"], :root a[href*="verismediya.ru/sb/clk/"], :root .trc_rbox_div .syndicatedItemUB { display: none !important; }
:root #mn div[style="position:relative"] > #center_col > div > ._dPg, :root a[href^="http://www.myvpn.pro/"], :root a[href^="//www.pd-news.com/"], :root a[href*="wow-partners.com/click.php"], :root a[href^="http://www.pinkvisualpad.com/?revid="], :root a[href*=".clksite.com/"], :root a[href^="http://www.webtrackerplus.com/"], :root .GJJKPX2N1 > .GJJKPX2M1 > .GJJKPX2P4, :root iframe[src*="trafic-media.ru"], :root #center_col > #taw > #tvcap > .cu-container > .commercial-unit-desktop-top, :root a[href^="http://centertrust.xyz/"], :root a[href^="https://intrev.co/"], :root .vi-lb-placeholder[title="ADVERTISEMENT"], :root a[href^="http://goldmoney.com/?gmrefcode="], :root a[href^="http://papi.mynativeplatform.com:80/pub2/"], :root LEADERBOARD-AD, :root #mn #center_col > div > h2.spon:first-child + ol:last-child, :root a[href^="http://servicegetbook.net/"], :root a[href*="m1cpl.ru"], :root #rhs_block > #mbEnd, :root a[href^="http://cinema.friendscout24.de?"], :root [lazy-ad="lefttop_banner"], :root .jobs-information-call-to-action + .jobs-information-call-to-action div[class$="_item"], :root a[href^="https://bongacams2.com/track?"], :root [alt="Rambler's Top100"], :root a[href^="//zenhppyad.com/"], :root .gbfwa > div[class$="_item"], :root a[href^="http://www.menaon.com/installs/"], :root a[href^="http://taboola-"][href*="/redirect.php?app.type="], :root .mw > #rcnt > #center_col > #taw > .c, :root a[href^="https://www.incredimail.com/?id"], :root a[href^="http://api.content.ad/"], :root a[href*=".clkcln.com/"], :root .commercial-unit-desktop-rhs > .iKidV > .Ee92ae + .P2mpm + .hp3sk, :root a[href^="http://www.uniblue.com/cm/"], :root a[href*="feellights.ru"], :root a[href^="http://landingpagegenius.com/"], :root a[data-redirect^="http://click.plista.com/pets"], :root #rhs_block > script + .c._oc._Ve.rhsvw, :root .__zinit .__y_item, :root .ch[onclick="ga(this,event)"], :root a[href^="http://track.incognitovpn.com/"], :root img[width="120"][height="600"], :root .__ywl .__y_item, :root a[href^="http://track.trkvluum.com/"], :root a[href*="/adrotate-out.php?"], :root a[href^="http://linksnappy.com/?ref="], :root [src^="/Redirect.a2b?"], :root a[href*="slovosil.com"], :root a[href*="ads-provider.com"], :root a[href^="http://www.torntvdl.com/"], :root a[href*="media-rotate.com"], :root #center_col > #resultStats + #tads, :root .__yinit .__y_item, :root a[href^="//www.mgid.com/"], :root #center_col > div[style="font-size:14px;margin-right:0;min-height:5px"] > div[style="font-size:14px;margin:0 4px;padding:1px 5px;background:#fff8e7"], :root a[href*="//universalice.info/"], :root a[href^="http://track.affiliatenetwork.co.za/"], :root a[data-redirect^="http://paid.outbrain.com/network/redir?"], :root a[href^="https://secure.cbdpure.com/aff/"], :root div[style*="am15.net/img/player_skins"], :root AMP-AD, :root .__y_inner > .__y_item, :root .ra[align="left"][width="30%"], :root a[href^="https://trackjs.com/?utm_source"], :root a[href^="https://relap.io/"][href*="promo_ad_link"], :root AFS-AD, :root #cnt #center_col > #res > #topstuff > .ts, :root a[href^="https://landing.brazzersnetwork.com/"], :root a[href^="http://www.firstclass-download.com/"], :root a[href*=".trust.zone"], :root a[href*="googleme.eu"], :root .serp-list + .serp-list > .serp-adv__head, :root .mod > ._jH + .rscontainer, :root .GFYY1SVD2 > .GFYY1SVC2 > .GFYY1SVF5, :root [onclick*="mixadvert.com"], :root a[href^="https://dcs.adgear.com/clicks/"], :root a[href^="http://affiliates.score-affiliates.com/"], :root #rhswrapper > #rhssection[border="0"][bgcolor="#ffffff"], :root .Mpopup + #Mad > #MadZone, :root a[href^="https://www.adxtro.com/"], :root #center_col > #\5f Emc, :root div[id^="dfp-ad-"], :root a[href*="//adoffer.pro/"], :root div[class^="advertisement-desktop"], :root a[href^="http://ads2.williamhill.com/redirect.aspx?"], :root a[href^="https://www.spyoff.com/"], :root AD-TRIPLE-BOX, :root a[href^="//z6naousb.com/"], :root .rc-cta[data-target], :root #rhs_block > .ts[cellspacing="0"][cellpadding="0"][style="padding:0"], :root #header + #content > #left > #rlblock_left, :root a[href^="http://www.seekbang.com/cs/"], :root a[href^="http://syndication.exoclick.com/"], :root a[href^="http://bluehost.com/track/"], :root a[href^="https://squren.com/rotator/?atomid="], :root .nrelate .nr_partner, :root #center_col > #resultStats + #tads + #res + #tads, :root a[href^="//medleyads.com/spot/"], :root a[href*="mfroute.com/"], :root #rhs_block > ol > .rhsvw > .kp-blk > .xpdopen > ._OKe > ol > ._DJe > .luhb-div, :root a[href^="http://tezfiles.com/pr/"], :root a[href^="http://t.wowtrk.com/"], :root div[id^="beroll_rotator"], :root #center_col > #taw > #tvcap > .rscontainer, :root #main_col > #center_col div[style="font-size:14px;margin:0 4px;padding:1px 5px;background:#fff7ed"], :root a[href^="http://webtrackerplus.com/"], :root a[href^="http://clickandjoinyourgirl.com/"], :root div[itemtype="http://schema.org/WPAdBlock"], :root a[href^="https://www.nudeidols.com/cams/"], :root #center_col > #res > #topstuff + #search > div > #ires > #rso > #flun, :root a[href^="http://www.sex.com/pics/?utm_"], :root a[href^="http://vo2.qrlsx.com/"], :root a[href^="http://engine.newsmaxfeednetwork.com/"], :root a[href^="http://ad.yieldmanager.com/"], :root a[href^="http://www.plus500.com/?id="], :root #adv_unisound ~ #ad_module_cont > [id^="ad_module"], :root #flowplayer > div[style="z-index: 208; position: absolute; width: 300px; height: 275px; left: 222.5px; top: 85px;"], :root a[href^="http://click.hotlog.ru/"], :root a[href^="http://ddownload39.club/"], :root a[href^="http://n217adserv.com/"], :root a[href*="/ribnadzo.ru"], :root a[href^="//4c7og3qcob.com/"] { display: none !important; }</style><style type="text/css">.fb_hidden{position:absolute;top:-10000px;z-index:10001}.fb_reposition{overflow:hidden;position:relative}.fb_invisible{display:none}.fb_reset{background:none;border:0;border-spacing:0;color:#000;cursor:auto;direction:ltr;font-family:"lucida grande", tahoma, verdana, arial, sans-serif;font-size:11px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal}.fb_reset>div{overflow:hidden}@keyframes fb_transform{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}.fb_animate{animation:fb_transform .3s forwards}
.fb_dialog{background:rgba(82, 82, 82, .7);position:absolute;top:-10000px;z-index:10001}.fb_dialog_advanced{border-radius:8px;padding:10px}.fb_dialog_content{background:#fff;color:#373737}.fb_dialog_close_icon{background:url(https://static.xx.fbcdn.net/rsrc.php/v3/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 0 transparent;cursor:pointer;display:block;height:15px;position:absolute;right:18px;top:17px;width:15px}.fb_dialog_mobile .fb_dialog_close_icon{left:5px;right:auto;top:5px}.fb_dialog_padding{background-color:transparent;position:absolute;width:1px;z-index:-1}.fb_dialog_close_icon:hover{background:url(https://static.xx.fbcdn.net/rsrc.php/v3/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -15px transparent}.fb_dialog_close_icon:active{background:url(https://static.xx.fbcdn.net/rsrc.php/v3/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -30px transparent}.fb_dialog_iframe{line-height:0}.fb_dialog_content .dialog_title{background:#6d84b4;border:1px solid #365899;color:#fff;font-size:14px;font-weight:bold;margin:0}.fb_dialog_content .dialog_title>span{background:url(https://static.xx.fbcdn.net/rsrc.php/v3/yd/r/Cou7n-nqK52.gif) no-repeat 5px 50%;float:left;padding:5px 0 7px 26px}body.fb_hidden{height:100%;left:0;margin:0;overflow:visible;position:absolute;top:-10000px;transform:none;width:100%}.fb_dialog.fb_dialog_mobile.loading{background:url(https://static.xx.fbcdn.net/rsrc.php/v3/ya/r/3rhSv5V8j3o.gif) white no-repeat 50% 50%;min-height:100%;min-width:100%;overflow:hidden;position:absolute;top:0;z-index:10001}.fb_dialog.fb_dialog_mobile.loading.centered{background:none;height:auto;min-height:initial;min-width:initial;width:auto}.fb_dialog.fb_dialog_mobile.loading.centered #fb_dialog_loader_spinner{width:100%}.fb_dialog.fb_dialog_mobile.loading.centered .fb_dialog_content{background:none}.loading.centered #fb_dialog_loader_close{clear:both;color:#fff;display:block;font-size:18px;padding-top:20px}#fb-root #fb_dialog_ipad_overlay{background:rgba(0, 0, 0, .4);bottom:0;left:0;min-height:100%;position:absolute;right:0;top:0;width:100%;z-index:10000}#fb-root #fb_dialog_ipad_overlay.hidden{display:none}.fb_dialog.fb_dialog_mobile.loading iframe{visibility:hidden}.fb_dialog_mobile .fb_dialog_iframe{position:sticky;top:0}.fb_dialog_content .dialog_header{background:linear-gradient(from(#738aba), to(#2c4987));border-bottom:1px solid;border-color:#043b87;box-shadow:white 0 1px 1px -1px inset;color:#fff;font:bold 14px Helvetica, sans-serif;text-overflow:ellipsis;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0;vertical-align:middle;white-space:nowrap}.fb_dialog_content .dialog_header table{height:43px;width:100%}.fb_dialog_content .dialog_header td.header_left{font-size:12px;padding-left:5px;vertical-align:middle;width:60px}.fb_dialog_content .dialog_header td.header_right{font-size:12px;padding-right:5px;vertical-align:middle;width:60px}.fb_dialog_content .touchable_button{background:linear-gradient(from(#4267B2), to(#2a4887));background-clip:padding-box;border:1px solid #29487d;border-radius:3px;display:inline-block;line-height:18px;margin-top:3px;max-width:85px;padding:4px 12px;position:relative}.fb_dialog_content .dialog_header .touchable_button input{background:none;border:none;color:#fff;font:bold 12px Helvetica, sans-serif;margin:2px -12px;padding:2px 6px 3px 6px;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog_content .dialog_header .header_center{color:#fff;font-size:16px;font-weight:bold;line-height:18px;text-align:center;vertical-align:middle}.fb_dialog_content .dialog_content{background:url(https://static.xx.fbcdn.net/rsrc.php/v3/y9/r/jKEcVPZFk-2.gif) no-repeat 50% 50%;border:1px solid #4a4a4a;border-bottom:0;border-top:0;height:150px}.fb_dialog_content .dialog_footer{background:#f5f6f7;border:1px solid #4a4a4a;border-top-color:#ccc;height:40px}#fb_dialog_loader_close{float:left}.fb_dialog.fb_dialog_mobile .fb_dialog_close_button{text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog.fb_dialog_mobile .fb_dialog_close_icon{visibility:hidden}#fb_dialog_loader_spinner{animation:rotateSpinner 1.2s linear infinite;background-color:transparent;background-image:url(https://static.xx.fbcdn.net/rsrc.php/v3/yD/r/t-wz8gw1xG1.png);background-position:50% 50%;background-repeat:no-repeat;height:24px;width:24px}@keyframes rotateSpinner{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
.fb_iframe_widget{display:inline-block;position:relative}.fb_iframe_widget span{display:inline-block;position:relative;text-align:justify}.fb_iframe_widget iframe{position:absolute}.fb_iframe_widget_fluid_desktop,.fb_iframe_widget_fluid_desktop span,.fb_iframe_widget_fluid_desktop iframe{max-width:100%}.fb_iframe_widget_fluid_desktop iframe{min-width:220px;position:relative}.fb_iframe_widget_lift{z-index:1}.fb_iframe_widget_fluid{display:inline}.fb_iframe_widget_fluid span{width:100%}</style></head>
	<body class="detailpage t-new_sidebar"><style type="text/css" scoped="true">@namespace svg "http://www.w3.org/2000/svg";#didomi-host{all:initial;-ms-overflow-style:auto;-moz-appearance:none;-moz-binding:none;-moz-border-bottom-colors:none;-moz-border-left-colors:none;-moz-border-right-colors:none;-moz-border-top-colors:none;-moz-context-properties:none;-moz-float-edge:content-box;-moz-force-broken-image-icon:0;-moz-image-region:auto;-moz-orient:inline;-moz-outline-radius-bottomleft:0;-moz-outline-radius-bottomright:0;-moz-outline-radius-topleft:0;-moz-outline-radius-topright:0;-moz-stack-sizing:stretch-to-fit;-moz-text-blink:none;-moz-user-focus:none;-moz-user-input:auto;-moz-user-modify:read-only;-moz-window-shadow:default;-webkit-border-before-color:currentcolor;-webkit-border-before-style:none;-webkit-border-before-width:medium;-webkit-box-reflect:none;-webkit-mask-attachment:scroll;-webkit-mask-clip:border;-webkit-mask-composite:source-over;-webkit-mask-image:none;-webkit-mask-origin:padding;-webkit-mask-position:0 0;-webkit-mask-position-x:0;-webkit-mask-position-y:0;-webkit-mask-repeat:repeat;-webkit-mask-repeat-x:repeat;-webkit-mask-repeat-y:repeat;-webkit-tap-highlight-color:black;-webkit-text-stroke-color:currentcolor;-webkit-text-stroke-width:0;-webkit-touch-callout:default;align-content:stretch;align-items:stretch;align-self:auto;animation-delay:0s;animation-direction:normal;animation-duration:0s;animation-fill-mode:none;animation-iteration-count:1;animation-name:none;animation-play-state:running;animation-timing-function:ease;azimuth:center;backface-visibility:visible;background-attachment:scroll;background-blend-mode:normal;background-clip:border-box;background-color:transparent;background-image:none;background-origin:padding-box;background-position:0 0;background-repeat:repeat;background-size:auto auto;block-size:auto;border-block-end-color:currentcolor;border-block-end-style:none;border-block-end-width:medium;border-block-start-color:currentcolor;border-block-start-style:none;border-block-start-width:medium;border-bottom-color:currentcolor;border-bottom-left-radius:0;border-bottom-right-radius:0;border-bottom-style:none;border-collapse:separate;border-image-outset:0s;border-image-repeat:stretch;border-image-slice:100%;border-image-source:none;border-image-width:1;border-inline-end-color:currentcolor;border-inline-end-style:none;border-inline-end-width:medium;border-inline-start-color:currentcolor;border-inline-start-style:none;border-inline-start-width:medium;border-left-color:currentcolor;border-left-style:none;border:medium;border-right-color:currentcolor;border-right-style:none;border-spacing:0;border-top-color:currentcolor;border-top-left-radius:0;border-top-right-radius:0;border-top-style:none;bottom:auto;box-align:stretch;box-decoration-break:slice;box-direction:normal;box-flex:0;box-flex-group:1;box-lines:single;box-ordinal-group:1;box-orient:initial;box-pack:start;box-shadow:none;box-sizing:content-box;break-after:auto;break-before:auto;break-inside:auto;caption-side:top;caret-color:auto;clear:none;clip:auto;clip-path:none;color:initial;column-count:auto;column-fill:balance;column-gap:normal;column-rule-color:currentcolor;column-rule-style:none;column-rule-width:medium;column-span:none;column-width:auto;content:normal;counter-increment:none;counter-reset:none;cursor:auto;empty-cells:show;filter:none;flex-basis:auto;flex-direction:row;flex-grow:0;flex-shrink:1;flex-wrap:nowrap;float:none;font-family:initial;font-feature-settings:normal;font-kerning:auto;font-language-override:normal;font-size:medium;font-size-adjust:none;font-stretch:normal;font-style:normal;font-synthesis:weight style;font-variant:normal;font-variant-alternates:normal;font-variant-caps:normal;font-variant-east-asian:normal;font-variant-ligatures:normal;font-variant-numeric:normal;font-variant-position:normal;font-weight:400;grid-auto-columns:auto;grid-auto-flow:row;grid-auto-rows:auto;grid-column-end:auto;grid-column-gap:0;grid-column-start:auto;grid-row-end:auto;grid-row-gap:0;grid-row-start:auto;grid-template-areas:none;grid-template-columns:none;grid-template-rows:none;height:auto;hyphens:manual;image-orientation:0deg;image-rendering:auto;image-resolution:1dppx;ime-mode:auto;inline-size:auto;isolation:auto;justify-content:flex-start;left:auto;letter-spacing:normal;line-break:auto;line-height:normal;list-style-image:none;list-style-position:outside;list-style-type:disc;margin-block-end:0;margin-block-start:0;margin-inline-end:0;margin-inline-start:0;margin:0;marker-offset:auto;mask-clip:border-box;mask-composite:add;mask-image:none;mask-mode:match-source;mask-origin:border-box;mask-position:0 0;mask-repeat:repeat;mask-size:auto;mask-type:luminance;max-height:none;max-width:none;min-block-size:0;min-height:0;min-inline-size:0;min-width:0;mix-blend-mode:normal;object-fit:fill;object-position:50% 50%;offset-block-end:auto;offset-block-start:auto;offset-inline-end:auto;offset-inline-start:auto;opacity:1;order:0;orphans:2;outline-color:initial;outline-offset:0;outline-style:none;outline-width:medium;overflow:visible;overflow-clip-box:padding-box;overflow-wrap:normal;overflow-x:visible;overflow-y:visible;padding-block-end:0;padding-block-start:0;padding-inline-end:0;padding-inline-start:0;padding:0;page-break-after:auto;page-break-before:auto;page-break-inside:auto;perspective:none;perspective-origin:50% 50%;pointer-events:auto;position:static;quotes:initial;resize:none;right:auto;ruby-align:space-around;ruby-merge:separate;ruby-position:over;scroll-behavior:auto;scroll-snap-coordinate:none;scroll-snap-destination:0 0;scroll-snap-points-x:none;scroll-snap-points-y:none;scroll-snap-type:none;scroll-snap-type-x:none;scroll-snap-type-y:none;shape-image-threshold:0;shape-margin:0;shape-outside:none;tab-size:8;table-layout:auto;text-align:initial;text-align-last:auto;text-combine-upright:none;text-decoration-color:currentcolor;text-decoration-line:none;text-decoration-style:solid;text-emphasis-color:currentcolor;text-emphasis-position:over right;text-emphasis-style:none;text-indent:0;text-justify:auto;text-orientation:mixed;text-overflow:clip;text-rendering:auto;text-shadow:none;text-transform:none;text-underline-position:auto;top:auto;touch-action:auto;transform:none;transform-box:border-box;transform-origin:50% 50% 0;transform-style:flat;transition-delay:0s;transition-duration:0s;transition-property:all;transition-timing-function:ease;user-select:auto;vertical-align:baseline;visibility:visible;white-space:normal;widows:2;width:auto;will-change:auto;word-break:normal;word-spacing:normal;word-wrap:normal;writing-mode:horizontal-tb;z-index:auto;-webkit-appearance:none;-ms-appearance:none;appearance:none}#didomi-host :not(svg|*){all:unset;-webkit-text-fill-color:initial}#didomi-host{display:block;width:0;height:0;font-size:15px;text-rendering:optimizeLegibility;-webkit-font-smoothing:antialiased;line-height:1.5em}#didomi-host .pad{padding:16px}#didomi-host .pad-xxl{padding:56px}#didomi-host .pad-xl{padding:48px}#didomi-host .pad-lg{padding:32px}#didomi-host .pad-md{padding:24px}#didomi-host .pad-sm{padding:8px}#didomi-host .pad-xs{padding:4px}#didomi-host .pad-none{padding:0}#didomi-host .pad-bottom{padding-bottom:16px}#didomi-host .pad-bottom-xxl{padding-bottom:56px}#didomi-host .pad-bottom-xl{padding-bottom:48px}#didomi-host .pad-bottom-lg{padding-bottom:32px}#didomi-host .pad-bottom-md{padding-bottom:24px}#didomi-host .pad-bottom-sm{padding-bottom:8px}#didomi-host .pad-bottom-xs{padding-bottom:4px}#didomi-host .pad-bottom-none{padding-bottom:0}#didomi-host .pad-top{padding-top:16px}#didomi-host .pad-top-xxl{padding-top:56px}#didomi-host .pad-top-xl{padding-top:48px}#didomi-host .pad-top-lg{padding-top:32px}#didomi-host .pad-top-md{padding-top:24px}#didomi-host .pad-top-sm{padding-top:8px}#didomi-host .pad-top-xs{padding-top:4px}#didomi-host .pad-top-none{padding-top:0}#didomi-host .pad-left{padding-left:16px}#didomi-host .pad-left-xxl{padding-left:56px}#didomi-host .pad-left-xl{padding-left:48px}#didomi-host .pad-left-lg{padding-left:32px}#didomi-host .pad-left-md{padding-left:24px}#didomi-host .pad-left-sm{padding-left:8px}#didomi-host .pad-left-xs{padding-left:4px}#didomi-host .pad-left-none{padding-left:0}#didomi-host .pad-right{padding-right:16px}#didomi-host .pad-right-xxl{padding-right:56px}#didomi-host .pad-right-xl{padding-right:48px}#didomi-host .pad-right-lg{padding-right:32px}#didomi-host .pad-right-md{padding-right:24px}#didomi-host .pad-right-sm{padding-right:8px}#didomi-host .pad-right-xs{padding-right:4px}#didomi-host .pad-right-none{padding-right:0}#didomi-host .pull-xxl{margin:-56px}#didomi-host .pull-xl{margin:-48px}#didomi-host .pull-lg{margin:-32px}#didomi-host .pull-md{margin:-24px}#didomi-host .pull{margin:-16px}#didomi-host .pull-sm{margin:-8px}#didomi-host .pull-xs{margin:-4px}#didomi-host .pull-none{margin:0}#didomi-host .pull-bottom-xxl{margin-bottom:-56px}#didomi-host .pull-bottom-xl{margin-bottom:-48px}#didomi-host .pull-bottom-lg{margin-bottom:-32px}#didomi-host .pull-bottom-md{margin-bottom:-24px}#didomi-host .pull-bottom{margin-bottom:-16px}#didomi-host .pull-bottom-sm{margin-bottom:-8px}#didomi-host .pull-bottom-xs{margin-bottom:-4px}#didomi-host .pull-bottom-none{margin-bottom:0}#didomi-host .pull-top-xxl{margin-top:-56px}#didomi-host .pull-top-xl{margin-top:-48px}#didomi-host .pull-top-lg{margin-top:-32px}#didomi-host .pull-top-md{margin-top:-24px}#didomi-host .pull-top{margin-top:-16px}#didomi-host .pull-top-sm{margin-top:-8px}#didomi-host .pull-top-xs{margin-top:-4px}#didomi-host .pull-top-none{margin-top:0}#didomi-host .pull-left-xxl{margin-left:-56px}#didomi-host .pull-left-xl{margin-left:-48px}#didomi-host .pull-left-lg{margin-left:-32px}#didomi-host .pull-left-md{margin-left:-24px}#didomi-host .pull-left{margin-left:-16px}#didomi-host .pull-left-sm{margin-left:-8px}#didomi-host .pull-left-xs{margin-left:-4px}#didomi-host .pull-left-none{margin-left:0}#didomi-host .pull-right-xxl{margin-right:-56px}#didomi-host .pull-right-xl{margin-right:-48px}#didomi-host .pull-right-lg{margin-right:-32px}#didomi-host .pull-right-md{margin-right:-24px}#didomi-host .pull-right{margin-right:-16px}#didomi-host .pull-right-sm{margin-right:-8px}#didomi-host .pull-right-xs{margin-right:-4px}#didomi-host .pull-right-none{margin-right:0}#didomi-host .push{margin:16px}#didomi-host .push-xxl{margin:56px}#didomi-host .push-xl{margin:48px}#didomi-host .push-lg{margin:32px}#didomi-host .push-md{margin:24px}#didomi-host .push-sm{margin:8px}#didomi-host .push-xs{margin:4px}#didomi-host .push-none{margin:0}#didomi-host .push-bottom{margin-bottom:16px}#didomi-host .push-bottom-xxl{margin-bottom:56px}#didomi-host .push-bottom-xl{margin-bottom:48px}#didomi-host .push-bottom-lg{margin-bottom:32px}#didomi-host .push-bottom-md{margin-bottom:24px}#didomi-host .push-bottom-sm{margin-bottom:8px}#didomi-host .push-bottom-xs{margin-bottom:4px}#didomi-host .push-bottom-none{margin-bottom:0}#didomi-host .push-top{margin-top:16px}#didomi-host .push-top-xxl{margin-top:56px}#didomi-host .push-top-xl{margin-top:48px}#didomi-host .push-top-lg{margin-top:32px}#didomi-host .push-top-md{margin-top:24px}#didomi-host .push-top-sm{margin-top:8px}#didomi-host .push-top-xs{margin-top:4px}#didomi-host .push-top-none{margin-top:0}#didomi-host .push-left{margin-left:16px}#didomi-host .push-left-xxl{margin-left:56px}#didomi-host .push-left-xl{margin-left:48px}#didomi-host .push-left-lg{margin-left:32px}#didomi-host .push-left-md{margin-left:24px}#didomi-host .push-left-sm{margin-left:8px}#didomi-host .push-left-xs{margin-left:4px}#didomi-host .push-left-none{margin-left:0}#didomi-host .push-right{margin-right:16px}#didomi-host .push-right-xxl{margin-right:56px}#didomi-host .push-right-xl{margin-right:48px}#didomi-host .push-right-lg{margin-right:32px}#didomi-host .push-right-md{margin-right:24px}#didomi-host .push-right-sm{margin-right:8px}#didomi-host .push-right-xs{margin-right:4px}#didomi-host .push-right-none{margin-right:0}#didomi-host a,#didomi-host p,#didomi-host span{font-size:inherit;color:inherit;font-weight:inherit;line-height:inherit;text-rendering:optimizeLegibility;-webkit-font-smoothing:antialiased}#didomi-host .didomi-icon{vertical-align:middle}#didomi-host div{display:block}#didomi-host p{display:block;margin-bottom:16px}#didomi-host .p-title{font-weight:700;font-size:1.1em;display:block;letter-spacing:.005em}#didomi-host ul{display:block;margin-bottom:16px}#didomi-host li{display:list-item;margin-left:20px}#didomi-host ol{display:block;list-style-type:decimal;margin-bottom:16px}#didomi-host table{box-sizing:border-box;display:table;width:100%;max-width:100%;border-collapse:separate;border-spacing:2px}#didomi-host table tbody,#didomi-host table thead{display:table-header-group}#didomi-host table tr{display:table-row}#didomi-host table td,#didomi-host table th{display:table-cell}#didomi-host a{cursor:pointer}#didomi-host a.didomi-no-link-style{text-decoration:none;color:#000}#didomi-host style{display:none}#didomi-host .text-bold{font-weight:700}#didomi-host h1{font-size:2em}#didomi-host h1,#didomi-host h2{display:block;font-weight:700;margin-bottom:16px}#didomi-host h2{font-size:1.5em}#didomi-host h3{font-size:1.17em}#didomi-host h3,#didomi-host h4,#didomi-host h5{display:block;font-weight:700;margin-bottom:16px}#didomi-host h5{font-size:.83em}#didomi-host h6{display:block;font-size:.67em;font-weight:700;margin-bottom:16px}#didomi-host b,#didomi-host strong{font-weight:700}#didomi-host cite,#didomi-host dfn,#didomi-host em,#didomi-host i,#didomi-host var{font-style:italic}#didomi-host ins,#didomi-host u{text-decoration:underline}#didomi-host del,#didomi-host s,#didomi-host strike{text-decoration:line-through}#didomi-host sub{vertical-align:sub}#didomi-host sub,#didomi-host sup{font-size:smaller;line-height:normal}#didomi-host sup{vertical-align:super}#didomi-host nobr{white-space:nowrap}#didomi-host hr{display:block;border:1px inset;margin:16px 0;color:gray;box-sizing:content-box}#didomi-host :focus{outline:1px auto #4d90fe}#didomi-host li[title] span,#didomi-host span[title]{cursor:help;border-bottom:1px dashed #000}#didomi-host #didomi-policy-backdrop{position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.6);z-index:11000001;overflow:auto;display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;align-items:flex-start}#didomi-host #didomi-policy-dialog{margin:auto;background-color:#fff;width:700px;opacity:1;box-shadow:0 19px 60px rgba(0,0,0,.3),0 15px 20px rgba(0,0,0,.22)}#didomi-host #didomi-policy-dialog a{font-weight:700}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-header{padding:15px;border-bottom:1px solid #efefef;background-color:#f5f5f5;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-header,#didomi-host #didomi-policy-dialog #didomi-policy-dialog-header #didomi-policy-dialog-header-logo{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-header #didomi-policy-dialog-header-logo img{margin-right:20px}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-header #didomi-policy-dialog-close-icon{cursor:pointer}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center;background:#fff;border-right:1px solid #efefef}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs{width:180px;list-style-type:none;margin:0;padding:0}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li{display:block;margin:0;padding:15px 0 15px 10px;background-color:#f5f5f5;border-bottom:2px solid #efefef}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li a{display:block;outline:none;color:#000;text-decoration:none}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.active{background:none;border-left-width:5px;border-left-style:solid;padding-left:5px}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.active a{font-weight:700}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.selected-tab{background:#fff;position:relative;left:1px;border-style:solid;border-width:1px 0}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li:first-child.selected-tab{border-top:none}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li a.selected-tab{font-weight:700;text-decoration:none}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-powered{margin-bottom:10px;font-size:.8em;font-weight:400;color:#000;text-decoration:none}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-powered img{margin-left:5px;vertical-align:middle;height:20px;width:68px}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-content{background:#fff;padding:20px;overflow:auto;height:400px}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-content h4{margin:0 0 16px}#didomi-host #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-content ul li{margin-bottom:0}#didomi-host #didomi-policy-dialog table{border-collapse:collapse;border-spacing:0;margin-bottom:16px;border:1px solid #e5e5e5}#didomi-host #didomi-policy-dialog table thead th{text-align:left;color:rgba(0,0,0,.6);border-bottom:1px solid #e5e5e5;padding:15px}#didomi-host #didomi-policy-dialog table tr td{vertical-align:top;border-bottom:1px solid #e5e5e5;padding:15px}#didomi-host #didomi-policy-dialog table tr td.category{font-weight:700;width:30%}#didomi-host .didomi-mobile #didomi-policy-dialog{width:100%;height:100%;max-width:none}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;position:relative;height:100%}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs{width:100%;background-color:#f5f5f5}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.tab{float:left;border-bottom:none;padding:15px 8px;font-size:.9em}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.tab svg{display:none}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.tab.active{background-color:#fff;border-left:none;border-top-style:solid;border-top-width:5px;padding-top:10px}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-powered{display:none}#didomi-host .didomi-mobile #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-content{height:calc(100% - 125px)}#didomi-host .didomi-mobile.didomi-screen-small #didomi-policy-dialog #didomi-policy-dialog-body #didomi-policy-dialog-body-tabs-container #didomi-policy-dialog-body-tabs li.tab svg{display:inline}body.didomi-policy-dialog-open{overflow:hidden!important}#didomi-host #didomi-notice{background-color:#fff}#didomi-host #didomi-notice.didomi-regular-notice{position:fixed;font-size:13px;line-height:1.5em;z-index:11000000}#didomi-host #didomi-notice.didomi-regular-notice a{color:inherit;text-decoration:underline}#didomi-host #didomi-notice.didomi-regular-notice .didomi-notice-view-partners-link{text-decoration:underline}#didomi-host #didomi-notice.didomi-regular-notice.shape-box{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;padding:32px;max-width:310px}#didomi-host #didomi-notice.didomi-regular-notice.shape-box #buttons{margin-top:20px}#didomi-host #didomi-notice.didomi-regular-notice.shape-box #buttons.multiple,#didomi-host #didomi-notice.didomi-regular-notice.shape-box #buttons.single,#didomi-host #didomi-notice.didomi-regular-notice.shape-box #buttons.single button{width:100%}#didomi-host #didomi-notice.didomi-regular-notice.shape-box #buttons.multiple button{padding-right:.8em;width:100%}#didomi-host #didomi-notice.didomi-regular-notice.shape-box.top.left{margin:1em 0 0 1em}#didomi-host #didomi-notice.didomi-regular-notice.shape-box.top.right{margin:1em 1em 0 0}#didomi-host #didomi-notice.didomi-regular-notice.shape-box.bottom.left{margin:0 0 1em 1em}#didomi-host #didomi-notice.didomi-regular-notice.shape-box.bottom.right{margin:0 1em 1em 0}#didomi-host #didomi-notice.didomi-regular-notice.shape-banner{padding:1em 1.8em;left:0;right:0}#didomi-host #didomi-notice.didomi-regular-notice.shape-banner .didomi-notice__interior-border{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center}#didomi-host #didomi-notice.didomi-regular-notice.shape-banner #buttons button.didomi-button-standard{min-width:100px}#didomi-host #didomi-notice.didomi-regular-notice.shape-banner #buttons.multiple{-ms-flex:0 0 auto}#didomi-host #didomi-notice.didomi-regular-notice.shape-banner #buttons.multiple button{margin-right:10px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel{max-width:600px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel.right{right:100px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel.left{left:100px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel.bottom{padding:1px;border-top-width:1px;border-top-style:solid;border-right-width:1px;border-right-style:solid;border-left-width:1px;border-left-style:solid;border-top-left-radius:5px;border-top-right-radius:5px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel.bottom .didomi-notice__interior-border{border-top-width:1px;border-top-style:solid;border-right-width:1px;border-right-style:solid;border-left-width:1px;border-left-style:solid;border-top-left-radius:3px;border-top-right-radius:3px;padding:10px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel.top{padding:1px;border-bottom-width:1px;border-bottom-style:solid;border-right-width:1px;border-right-style:solid;border-left-width:1px;border-left-style:solid;border-bottom-left-radius:5px;border-bottom-right-radius:5px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel.top .didomi-notice__interior-border{border-bottom-width:1px;border-bottom-style:solid;border-right-width:1px;border-right-style:solid;border-left-width:1px;border-left-style:solid;border-bottom-left-radius:3px;border-bottom-right-radius:3px;padding:10px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel #buttons.multiple{margin-top:20px}#didomi-host #didomi-notice.didomi-regular-notice.shape-panel #buttons.multiple button{margin-right:10px}#didomi-host #didomi-notice.didomi-regular-notice.top{top:0}#didomi-host #didomi-notice.didomi-regular-notice.bottom{bottom:0}#didomi-host #didomi-notice.didomi-regular-notice.left{left:0}#didomi-host #didomi-notice.didomi-regular-notice.right{right:0}#didomi-host #didomi-notice.didomi-regular-notice #buttons{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:center;-moz-box-pack:center;-webkit-flex-pack:center;-ms-flex-pack:center;-moz-justify-content:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center}#didomi-host #didomi-notice.didomi-regular-notice #buttons button{display:block;padding:.4em .8em;font-size:.9em;font-weight:700;border-width:1px;border-style:solid;text-align:center;white-space:nowrap;min-width:140px;cursor:pointer;text-decoration:none}#didomi-host #didomi-notice.didomi-regular-notice #buttons button.didomi-button-standard{background-color:#eee;border:1px solid rgba(34,34,34,.2);color:#555}#didomi-host #didomi-notice.didomi-regular-notice #buttons button.didomi-button-highlight{text-decoration:underline}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice{left:0;right:0;font-size:11px;padding:1px}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice .didomi-notice__interior-border{padding:1em 1.8em;display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice.bottom,#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice.bottom .didomi-notice__interior-border{border-top-width:1px;border-top-style:solid}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice.top,#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice.top .didomi-notice__interior-border{border-bottom-width:1px;border-bottom-style:solid}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #text{width:100%}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #buttons{margin-top:20px}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #buttons.multiple,#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #buttons.single,#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #buttons.single button{width:100%}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #buttons.multiple button{margin-right:10px;padding-right:.8em;width:100%}#didomi-host .didomi-mobile #didomi-notice.didomi-regular-notice #buttons.multiple button:last-child{margin-right:0}#didomi-host .didomi-screen-xsmall #didomi-notice.didomi-regular-notice #buttons.multiple{-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column}#didomi-host .didomi-screen-xsmall #didomi-notice.didomi-regular-notice #buttons.multiple button{margin-bottom:10px;margin-right:0;padding-right:0;width:100%}#didomi-host .didomi-screen-xsmall #didomi-notice.didomi-regular-notice #buttons.multiple button:last-child{margin-bottom:0}#didomi-host .didomi-popup__backdrop{position:fixed;top:0;left:0;width:100%;height:100%;background-color:hsla(0,0%,100%,.8);overflow:auto;z-index:11000001;display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;align-items:flex-start;-webkit-overflow-scrolling:touch}#didomi-host .didomi-popup__exterior-border{border-style:solid;border-radius:5px;border-width:1px;padding:1px;margin:auto}#didomi-host .didomi-popup__dialog{background-color:#fff;opacity:1;border-style:solid;border-radius:3px;border-width:1px;-webkit-overflow-scrolling:touch}#didomi-host .didomi-popup-notice{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;align-items:center;max-width:600px;padding:50px}#didomi-host .didomi-popup-notice h1{text-align:center;margin-bottom:50px}#didomi-host .didomi-popup-notice .didomi-popup-notice-logo{width:200px;margin-bottom:35px}#didomi-host .didomi-popup-notice .didomi-popup-notice-text{max-width:600px}#didomi-host .didomi-popup-notice .didomi-notice-view-partners-link{display:block;text-align:center}#didomi-host .didomi-popup-notice .didomi-popup-notice-buttons{margin-top:30px;display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;justify-content:center;align-items:center}#didomi-host .didomi-popup-notice .didomi-popup-notice-buttons .didomi-components-button{padding:2px 25px}#didomi-host .didomi-popup-notice .didomi-popup-notice-buttons a{text-decoration:underline}#didomi-host .didomi-popup-notice .didomi-popup-notice-subtext{margin-top:30px}#didomi-host .didomi-mobile #didomi-popup{width:100%;height:100%;max-width:none}#didomi-host .didomi-mobile #didomi-popup .didomi-popup-notice{padding:30px}#didomi-host .didomi-mobile #didomi-popup .didomi-popup-notice h1{margin-bottom:35px}#didomi-host .didomi-mobile #didomi-popup .didomi-popup-notice p{text-align:justify}#didomi-host .didomi-mobile #didomi-popup .didomi-popup-notice .didomi-popup-notice-buttons{-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;margin-top:15px}#didomi-host .didomi-mobile #didomi-popup .didomi-popup-notice .didomi-popup-notice-buttons .didomi-components-button{margin:10px 0 0!important}body.didomi-popup-open{overflow:hidden!important}body.didomi-popup-open-ios{position:fixed}#didomi-host #didomi-notice.didomi-custom-notice-html{position:fixed;z-index:11000000}#didomi-host #didomi-notice.didomi-custom-notice-html.shape-box{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between}#didomi-host #didomi-notice.didomi-custom-notice-html.shape-banner{left:0;right:0}#didomi-host #didomi-notice.didomi-custom-notice-html.top{top:0}#didomi-host #didomi-notice.didomi-custom-notice-html.bottom{bottom:0}#didomi-host #didomi-notice.didomi-custom-notice-html.left{left:0}#didomi-host #didomi-notice.didomi-custom-notice-html.right{right:0}#didomi-host .didomi-mobile #didomi-notice.didomi-custom-notice-html{left:0;right:0}#didomi-host .didomi-consent-popup__backdrop{position:fixed;top:0;left:0;width:100%;height:100%;background-color:hsla(0,0%,100%,.8);z-index:11000002;overflow:auto;display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;align-items:flex-start}#didomi-host .didomi-consent-popup__exterior-border{border-style:solid;border-radius:5px;border-width:1px;padding:1px;margin:auto}#didomi-host .didomi-consent-popup__dialog{background-color:#fff;opacity:1;max-width:650px;border-style:solid;border-radius:3px;border-width:1px;-webkit-overflow-scrolling:touch}#didomi-host .didomi-consent-popup-header{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center;padding:30px 20px 0;font-weight:700;font-family:Arial}#didomi-host .didomi-consent-popup-header .didomi-consent-popup-header-close{font-family:Arial;opacity:.5;font-size:30px;font-weight:500;line-height:30px;color:#000;text-shadow:0 1px 0 #fff;transition:.5s}#didomi-host .didomi-consent-popup-header .didomi-consent-popup-header-close:hover{opacity:.7}#didomi-host .didomi-consent-popup-body{padding:30px 20px}#didomi-host .didomi-consent-popup-body .didomi-consent-popup-body__section{margin-bottom:22px}#didomi-host .didomi-consent-popup-body .didomi-consent-popup-body__section:last-child{margin-bottom:0}#didomi-host .didomi-consent-popup-body .didomi-consent-popup-body__title{font-size:12px;color:#999;text-transform:uppercase;margin-bottom:8px;display:block;font-weight:700;font-family:Arial}#didomi-host .didomi-consent-popup-body .didomi-consent-popup-body__subtext{margin-bottom:22px}#didomi-host .didomi-consent-popup-body .didomi-consent-popup-body__explanation a{font-weight:700;text-decoration:underline}#didomi-host .didomi-consent-popup-footer{-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;background-color:hsla(0,0%,93%,.4);height:58px}#didomi-host .didomi-consent-popup-footer,#didomi-host .didomi-consent-popup-footer .didomi-consent-popup-actions{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center}#didomi-host .didomi-consent-popup-footer .didomi-consent-popup-actions{-webkit-box-pack:end;-moz-box-pack:end;-webkit-flex-pack:end;-ms-flex-pack:end;-moz-justify-content:flex-end;-webkit-justify-content:flex-end;justify-content:flex-end}#didomi-host .didomi-consent-popup-footer .didomi-consent-popup-actions button,#didomi-host .didomi-consent-popup-footer .didomi-consent-popup-actions div{margin-right:10px}#didomi-host .didomi-mobile #didomi-consent-popup{width:100%;height:100%;max-width:none}body.didomi-consent-popup-open{overflow:hidden!important}body.didomi-consent-popup-open-ios{position:fixed}#didomi-host .didomi-consent-popup-preferences .didomi-consent-popup-data-processing__buttons{-webkit-flex-shrink:0;-webkit-box-flex:0;-moz-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;margin-left:15px}#didomi-host .didomi-consent-popup-preferences .didomi-consent-popup-data-processing,#didomi-host .didomi-consent-popup-preferences .didomi-consent-popup-vendor{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center;margin-bottom:8px}#didomi-host .didomi-consent-popup-preferences .didomi-consent-popup-vendor .didomi-consent-popup-vendor__buttons{-webkit-flex-shrink:0;-webkit-box-flex:0;-moz-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;margin-left:15px}#didomi-host .didomi-consent-popup-preferences .didomi-consent-popup-partner{display:inline-block;margin-right:15px;margin-bottom:5px}#didomi-host .didomi-consent-popup-preferences .didomi-consent-popup-partner a{border-bottom:1px dashed #000}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-vendor{-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-align:start;-ms-flex-align:start;-webkit-align-items:flex-start;-moz-align-items:flex-start;align-items:flex-start;margin-bottom:8px}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-vendor .didomi-consent-popup-vendor__buttons{-webkit-flex-shrink:0;-webkit-box-flex:0;-moz-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;margin-left:0;margin-top:10px}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-data-processing{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:start;-moz-box-pack:start;-webkit-flex-pack:start;-ms-flex-pack:start;-moz-justify-content:flex-start;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-box-align:start;-ms-flex-align:start;-webkit-align-items:flex-start;-moz-align-items:flex-start;align-items:flex-start}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-data-processing .didomi-consent-popup-category__name,#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-data-processing .didomi-consent-popup-data-processing__purpose{margin-bottom:6px}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-data-processing .didomi-consent-popup-category__description,#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-preferences .didomi-consent-popup-data-processing .didomi-consent-popup-data-processing__description{font-size:12px}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-category__description{margin-bottom:20px;font-size:12px}#didomi-host .didomi-mobile #didomi-consent-popup .didomi-consent-popup-data-processing__buttons{margin-left:0}#didomi-host .didomi-consent-popup-information .didomi-consent-popup-body{max-height:300px;overflow:auto}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-consent-popup-body_vendors-list{height:280px;overflow:auto;border:2px solid rgba(0,0,0,.05);padding:12px}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-consent-popup-body{padding:20px}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-privacy-policy-link{text-decoration:underline;padding-bottom:10px;display:inline-block}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-vendors-details-title{font-weight:700}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-consent-popup-container-click-all{font-weight:700;background:rgba(0,0,0,.05);padding:8px 12px;margin:0!important}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-popup-title{cursor:pointer}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-user-information-container{word-break:break-all;border:2px solid rgba(0,0,0,.05);padding:12px}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-user-information-trigger{font-size:12px;color:#b3b3b3;font-weight:700}#didomi-host .didomi-consent-popup-preferences-vendors .didomi-user-information-trigger>.trigger-icon{font-size:12px!important}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category{padding:10px;margin:12px 0 0}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .label-click{font-weight:700}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__children{border:1px solid #e7e2d6;padding:10px}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__name{font-weight:700;font-size:16px;padding-bottom:6px}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__description{font-size:14px;font-weight:300}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__children{margin-top:12px}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__children .didomi-consent-popup-category{padding:0}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__children .didomi-consent-popup-data-processing{border:none;padding:0}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-category .didomi-consent-popup-category__children .didomi-consent-popup-data-processing .didomi-consent-popup-data-processing__purpose{font-size:16px}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-data-processing{font-weight:700}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-data-processing__description{font-size:14px;color:#333}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-categories-nested .didomi-consent-popup-data-processing{padding:10px;margin:12px 0 0}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-categories-nested .didomi-consent-popup-data-processing__purpose{font-size:18px;padding-bottom:6px}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-view-vendors-list{display:flex;justify-content:space-between;align-items:center;text-align:center;margin-bottom:16px}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-view-vendors-list .didomi-consent-popup-body__title{margin-bottom:0}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-view-vendors-list .didomi-consent-popup-view-vendors-list-link{cursor:pointer;box-shadow:1px 1px 0 0 rgba(0,0,0,.1);background-color:#fff;border:1px solid #eee;font-size:12px;color:#b3b3b3;font-weight:700;padding:5px 15px;text-transform:none}#didomi-host .didomi-consent-popup-preferences-purposes .didomi-consent-popup-footer .didomi-consent-popup-actions .didomi-consent-popup-information-save{margin-right:15px;font-style:italic;color:#9b9b9b;font-size:14px}#didomi-host .didomi-mobile .didomi-consent-popup-preferences-purposes .didomi-consent-popup-footer{height:auto!important}#didomi-host .didomi-mobile .didomi-consent-popup-preferences-purposes .didomi-consent-popup-footer .didomi-consent-popup-actions{padding:8px 0}#didomi-host .didomi-mobile .didomi-consent-popup-preferences-purposes .didomi-consent-popup-footer .didomi-consent-popup-actions:not(.didomi-buttons-all){flex-direction:column-reverse}#didomi-host .didomi-mobile .didomi-consent-popup-preferences-purposes .didomi-consent-popup-footer .didomi-consent-popup-actions .didomi-consent-popup-information-save{text-align:center;margin-top:5px}#didomi-host .didomi-consent-popup-preferences-purposes-features div{display:inline}#didomi-host .didomi-components-button{cursor:pointer;display:block;height:38px;padding:0 20px;font-size:16px;line-height:18px;font-weight:700;text-align:center;color:#999;background-color:#eee;border:1px solid rgba(34,34,34,.2)}#didomi-host .didomi-components-button:disabled{opacity:.4;cursor:auto}#didomi-host .didomi-mobile .didomi-components-button{font-size:14px}#didomi-host .didomi-screen-xsmall .didomi-components-button{padding:0 10px}#didomi-host .didomi-components-radio{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center}#didomi-host .didomi-components-radio__option{margin-right:5px;cursor:pointer;height:25px;box-shadow:1px 1px 0 0 rgba(0,0,0,.1);background-color:#fff;border:1px solid #eee;padding:0 20px;line-height:12px;font-size:12px;color:#b3b3b3;font-weight:700;transition:background-color .5s,border-color .5s;transition-timing-function:ease}#didomi-host .didomi-components-radio__option:hover{color:gray;border-color:#bbb}#didomi-host .didomi-components-radio__option:last-child{margin-right:0}#didomi-host .didomi-components-radio__option>svg{margin-right:5px}#didomi-host .didomi-components-radio__option.didomi-components-radio__option--agree{background-color:#69ba73;color:#fff;border:1px solid rgba(0,0,0,.3);padding:0 11.5px}#didomi-host .didomi-components-radio__option.didomi-components-radio__option--agree>svg{vertical-align:middle}#didomi-host .didomi-components-radio__option.didomi-components-radio__option--disagree{background-color:#f55;color:#fff;border:1px solid rgba(0,0,0,.3);padding:0 13.5px}#didomi-host .didomi-components-accordion{flex:1}#didomi-host .didomi-components-accordion .label-click{cursor:pointer}#didomi-host .didomi-components-accordion .trigger-icon{width:15px;font-size:16px;display:inline-block;text-align:center}#didomi-host .didomi-components-accordion .content{overflow:hidden;max-height:0;opacity:0;visibility:hidden;font-weight:300;text-align:justify;-webkit-transition:all .5s ease-in-out;-moz-transition:all .5s ease-in-out;-o-transition:all .5s ease-in-out;transition:all .5s ease-in-out;transition-property:opacity,max-height,transform,visibility,padding-bottom}#didomi-host .didomi-components-accordion .content.active{max-height:3000px;opacity:1;visibility:visible;padding-bottom:10px;transition-property:opacity,max-height,transform,visibility}#didomi-host .didomi-components-accordion .didomi-components-accordion-label-container{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-moz-box-orient:horizontal;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-moz-box-pack:justify;-webkit-flex-pack:justify;-ms-flex-pack:justify;-moz-justify-content:space-between;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;-webkit-align-items:center;-moz-align-items:center;align-items:center}#didomi-host .didomi-mobile .didomi-components-accordion .didomi-components-accordion-label-container{display:-webkit-box;display:-moz-box;display:-webkit-flexbox;display:-ms-flexbox;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-moz-box-orient:vertical;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:start;-moz-box-pack:start;-webkit-flex-pack:start;-ms-flex-pack:start;-moz-justify-content:flex-start;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-box-align:start;-ms-flex-align:start;-webkit-align-items:flex-start;-moz-align-items:flex-start;align-items:flex-start}#didomi-host .lds-ellipsis-container{display:flex;align-items:center;justify-content:center;height:100%}#didomi-host .lds-ellipsis-container .lds-ellipsis{display:inline-block;position:relative;width:64px;height:64px}#didomi-host .lds-ellipsis-container .lds-ellipsis div{position:absolute;top:27px;width:11px;height:11px;border-radius:50%;background:#dcdcdc;animation-timing-function:cubic-bezier(0,1,1,0)}#didomi-host .lds-ellipsis-container .lds-ellipsis div:first-child{left:6px;animation:lds-ellipsis1 .6s infinite}#didomi-host .lds-ellipsis-container .lds-ellipsis div:nth-child(2){left:6px;animation:lds-ellipsis2 .6s infinite}#didomi-host .lds-ellipsis-container .lds-ellipsis div:nth-child(3){left:26px;animation:lds-ellipsis2 .6s infinite}#didomi-host .lds-ellipsis-container .lds-ellipsis div:nth-child(4){left:45px;animation:lds-ellipsis3 .6s infinite}@keyframes lds-ellipsis1{0%{transform:scale(0)}to{transform:scale(1)}}@keyframes lds-ellipsis3{0%{transform:scale(1)}to{transform:scale(0)}}@keyframes lds-ellipsis2{0%{transform:translate(0)}to{transform:translate(19px)}}#didomi-host .didomi-components-skip-link{position:absolute;top:-100px;left:-100px;margin-bottom:16px;display:block}#didomi-host .didomi-components-skip-link:focus{position:relative;top:0;left:0}</style><div id="didomi-host"><div class="notranslate didomi-screen-small didomi-mobile"><style type="text/css" scoped="true">
      #didomi-host {
        font-family: Arial;
      }
      #didomi-host a:not(.didomi-no-link-style) {
        text-decoration: underline;
        color: rgba(0,152,208,1)
      }
      
      </style></div></div><iframe name="__cmpLocator" style="display: none;"></iframe>
	    		    <!-- Google Tag Manager -->
<!-- End Google Tag Manager -->	    	            <div id="div-gpt-ad-test"></div>
    <script type="text/javascript">
        var checkDivElement = true;
    </script>
<script>
    var advertisingAbTest = {"controlEngineTestGroups":[[1,100]],"controlEngineTestGroupsMweb":[[1,100]],"BannerFeedbackTest_paused":"8b7ce476-2914-4609-ad34-2cff401110f6"};
</script>
    <script async="async" type="text/javascript" src="https://static.criteo.net/js/ld/publishertag.js" style="display: none !important;"></script>
    <script>
        window.Criteo = window.Criteo || {};
        window.Criteo.events = window.Criteo.events || [];
        window.criteoSlotsData = [{"abTest":[[1,100]],"container":{"dfpId":"div-gpt-ad-listing-top","criteoId":"Crt-1406558","dataAdFormat":"fluid","dataAdLayoutKey":"-he+h+43-24+52","dataAdClient":"ca-pub-6111053159423085","dataAdSlot":6644931680,"size":[90,728],"style":{"margin":"auto","padding":"10px","max-height":"90px"}},"slot":{"zoneId":1406558,"overrideZoneFloor":false}},{"abTest":[[1,100]],"container":{"dfpId":"div-gpt-ad-item-top","criteoId":"Crt-1406558-1","dataAdFormat":"fluid","dataAdLayoutKey":"-he+h+43-24+52","dataAdClient":"ca-pub-6111053159423085","dataAdSlot":6933255038,"size":[90,728],"style":{"margin":"auto","padding":"10px","max-height":"90px"}},"slot":{"zoneId":1406558,"overrideZoneFloor":false}},{"abTest":[[1,100]],"container":{"dfpId":"div-gpt-ad-item-sidebar","criteoId":"Crt-1406559","dataAdFormat":"fluid","dataAdLayoutKey":"-7g+ed+2w-11-82","dataAdClient":"ca-pub-6111053159423085","dataAdSlot":7759251544,"style":{"width":"300px","height":"250px"},"size":[250,300]},"slot":{"zoneId":1406559,"overrideZoneFloor":false}},{"abTest":[[1,100]],"container":{"dfpId":"div-gpt-ad-listing-sidebar","dataAdClient":"ca-pub-6111053159423085","dataAdFormat":"car","dataAdSlot":8943791968,"criteoId":"Crt-1406560","style":{"width":"160px","height":"600px"},"size":[600,160]},"slot":{"zoneId":1406560,"overrideZoneFloor":false}},{"abTest":[[1,100]],"container":{"dfpId":"div-gpt-ad-listing-middle","criteoId":"Crt-1406561","size":[165,890]},"slot":{"zoneId":1406561,"overrideZoneFloor":false}},{"abTest":[[1,100]],"container":{"dfpId":"div-gpt-liting-after-promoted","criteoId":"Crt-1406561-1","size":[165,890]},"slot":{"zoneId":1406561,"overrideZoneFloor":false}}];
    </script>
<script type="text/javascript">
    if (typeof window.CustomEvent !== "function") {
        function CustomEvent(event, params) {
            params = params || {bubbles: false, cancelable: false, detail: undefined};
            var evt = document.createEvent('CustomEvent');
            evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
            return evt;
        }
        CustomEvent.prototype = window.Event.prototype;
        window.CustomEvent = CustomEvent;
    }
</script>
    <!-- Start: GPT -->
    <script type="text/javascript">
        var campaignAllowedIds = [275163277,2436073177,2436077716,2483498347,2435559587,2436043834];
        var campaignProhibitedIds = [];
        var initGptScript = function () {
            (function () {
                var gads = document.createElement('script');
                gads.async = true;
                gads.type = 'text/javascript';
                var useSSL = 'https:' == document.location.protocol;
                gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
                var node = document.getElementsByTagName('script')[0];
                node.parentNode.insertBefore(gads, node);
            })();
        };
    </script>
                        <script type="text/javascript">
                var GPT = GPT || {};
                GPT.targeting = {"cat_l0":"elektronika","cat_l1":"noutbuki-i-aksesuary","cat_l2":"noutbuki","cat_l0_id":"37","cat_l1_id":"1502","cat_l2_id":"80","ad_title":"\u0438\u0433\u0440\u043e\u0432\u043e\u0439-\u043d\u043e\u0443\u0442\u0431\u0443\u043a-msi-gs60-6qc-ghost","ad_img":"https:\/\/apollo-ireland.akamaized.net:443\/v1\/files\/9cgxlwg85dcs1-UA\/image;s=644x461","ad_id":"613795209","offer_seek":"offer","private_business":"private","region":"dnp","subregion":"dnepropetrovsk","city":"dnepr","price":["20001-50000"],"ad_price":"26500","currency":"UAH","state":["used"],"display_size":["3"],"laptop_manufacturer":["2128"],"safedealads":"","premium_ad":"0","imported":"0","importer_code":"","ad_type_view":"normal","dfp_user_id":"","segment":[],"dfp_segment_test":"94","dfp_segment_test_v2":"77","dfp_segment_test_v3":"77","dfp_segment_test_v4":"84","dfp_segment_test_oa":"53","adx":["ud1p2","ud2p2","ud3p2","ud4p2","ud5p2","ud6p2","ud7p2","ud8p2","ud9p2","ud10p2","ud11p2","ud12p2","ud13p2","ud14p2","ud15p2","ud16p2","ud17p2","ud18p2"],"comp":["*"],"lister_lifecycle":"1","last_pv_imps":"0","user-ad-fq":"0","ses_pv_seq":"0","user-ad-dens":"0","listingview_test":"1","env":"production","url_action":"ad","lang":"ru","action_name":"ad","con_inf":"elektronikaxxnoutbuki-i-aksesuaryxx77"};
                GPT.slots = [{"divId":"div-gpt-ad-item-content2","adUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/infeed_btm2_ap","adUnitSizes":"[[617,120],[617,100]]","outOfPage":"0","targeting":{"pos":"Item_content2"},"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":false,"secondDivId":"","secondAdUnitPath":"","secondAdUnitSizes":"[]","order":"1","position":null,"container_config":null,"showOnlyOnAction":"userSeeSlot{slotId}"},{"divId":"div-gpt-ad-item-content3","adUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/infeed_btm3_ap","adUnitSizes":"[[617,120],[617,100],[580,400]]","outOfPage":"0","targeting":{"pos":"Item_content3"},"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":false,"secondDivId":"","secondAdUnitPath":"","secondAdUnitSizes":"[]","order":"1","position":null,"container_config":null,"showOnlyOnAction":"userSeeSlot{slotId}"},{"divId":"div-gpt-ad-item-content1","adUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/infeed_btm1_ap","adUnitSizes":"[[617,120],[617,100],\"fluid\"]","outOfPage":"0","targeting":{"pos":"Item_content1"},"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":false,"secondDivId":"","secondAdUnitPath":"","secondAdUnitSizes":"[]","order":"1","position":null,"container_config":null,"showOnlyOnAction":"userSeeSlot{slotId}"},{"divId":"div-gpt-ad-item-top","adUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/hrz_top_ap","adUnitSizes":"[[728,90],[750,100],[750,200],[930,180],[970,90],[970,250],[980,120]]","outOfPage":"0","targeting":{"pos":"Item_Top","Admixer":"1"},"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":true,"secondDivId":"div-gpt-ad-item-top-r","secondAdUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/hrz_top_rd1_ap","secondAdUnitSizes":"[[728,90],[750,100],[750,200],[930,180],[970,90],[970,250],[980,120]]","order":"1","position":"","container_config":"","showOnlyOnAction":""},{"divId":"div-gpt-ad-item-sidebar","adUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/vr_rgt1_ap","adUnitSizes":"[[300,400],[300,600],[300,250],[240,400],[250,400],[160,600],[336,280],[240,350],[250,250]]","outOfPage":"0","targeting":{"pos":"Item_Sidebar","Admixer":"1"},"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":true,"secondDivId":"div-gpt-ad-item-sidebar-r","secondAdUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/vr_rgt1_rd1_ap","secondAdUnitSizes":"[[300,400],[300,600],[300,250],[240,400],[250,400],[160,600],[336,280],[240,350],[250,250]]","order":"1","position":"","container_config":"","showOnlyOnAction":""},{"divId":"div-gpt-ad-rectangle_gallery","adUnitPath":"olxua_dsk\/elektronika\/noutbuki-i-aksesuary\/ad\/vr_gv_ap","adUnitSizes":"[[300,250],[250,250]]","outOfPage":"0","targeting":[],"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":false,"secondDivId":"","secondAdUnitPath":"","secondAdUnitSizes":"[]","order":"1","position":null,"container_config":null,"showOnlyOnAction":"showGallery"},{"divId":"div-gpt-ad-item-branding","adUnitPath":"olxbox.info\/elektronika\/noutbuki-i-aksesuary\/noutbuki","adUnitSizes":"[[1,1]]","outOfPage":"0","targeting":{"pos":"Item_Branding","Admixer":"1"},"isCollapsing":false,"exclusion":false,"openxBidder":false,"criteoZoneId":"","showActionAdblock":"1","sticky":false,"setClass":"0","isRefreshed":false,"secondDivId":"","secondAdUnitPath":"","secondAdUnitSizes":"[]","order":"1","position":null,"container_config":null,"showOnlyOnAction":""}];
                GPT.slotsShowOnlyWhenUserSee = [];
                var networkId = 55937117;
                var hasCriteoSlot = false;
                var hasPrebidSlot = false;
                var advertsViewPerPageView = 0;
                var advertsViewPerSession = 0;
                var pageViewPerSession = 0;
                var advertsAreEnabled = true;
                var prebidEnabled = true;
                var pbjsAdserverRequestIsSent = false;
                var initNewDFP = false;
                var amanager = true;
                                                var PREBID_TIMEOUT = 1200;
        var hasPrebidSlot = true;
        var adUnits = [{"code":"div-gpt-ad-item-top","bids":[{"bidder":"criteo","params":{"zoneId":1232890}},{"bidder":"rtbhouse","params":{"region":"prebid-eu","publisherId":"f0140097782b6671c3bc"}},{"bidder":"admixer","params":{"zone":"992f4a7b-7f87-48ec-849e-70cff8236eba"}},{"bidder":"smartadserver","params":{"domain":"https:\/\/prg.smartadserver.com","siteId":271349,"bidfloor":0.03,"networkId":3259,"pageId":1016200,"formatId":71230}}],"sizes":[[728,90],[970,250]]},{"code":"div-gpt-ad-item-sidebar","bids":[{"bidder":"criteo","params":{"zoneId":1173612}},{"bidder":"rtbhouse","params":{"region":"prebid-eu","publisherId":"f0140097782b6671c3bc"}},{"bidder":"admixer","params":{"id_by_cattegory":{"name":"zone","category_id":{"1":"8fccb2bd-a05e-4d76-a2e3-8b274766115a","3":"a593ab4d-aa45-4dfd-8c24-c4f1575464df","6":"9fd5fa34-b581-4421-a4c3-f2f517079854","7":"28707b61-3e58-4a55-b767-7eca37329bb6","35":"36924da3-aa8d-4d8f-bb8a-8994979e922e","36":"198ab0a3-f7ea-41b7-85e8-3e323e2fc607","37":"df7e920f-0cec-48fb-a48f-a5ff174cf5cb","891":"e5471cb5-bc1d-45a1-9554-cab4f0f5555a","899":"bcabe01d-a5db-492b-869e-9637bb88e3b1","903":"6ee161c7-5b17-479b-8aeb-0e26d7d25edd","1532":"22e5b705-fc8b-4210-9e7a-bf09e6b8af8b"}}}},{"bidder":"smartadserver","params":{"domain":"https:\/\/prg.smartadserver.com","siteId":271349,"bidfloor":0.03,"networkId":3259,"pageId":1016200,"formatId":71228}},{"bidder":"smartadserver","params":{"domain":"https:\/\/prg.smartadserver.com","siteId":271349,"bidfloor":0.03,"networkId":3259,"pageId":1016200,"formatId":71229}}],"sizes":[[300,600]]},{"code":"div-gpt-ad-rectangle_gallery","bids":[{"bidder":"criteo","params":{"zoneId":1173611}},{"bidder":"rtbhouse","params":{"region":"prebid-eu","publisherId":"f0140097782b6671c3bc"}},{"bidder":"admixer","params":{"zone":"5cfc8e72-ff0e-43ba-a12e-1f42c66bd0bd"}},{"bidder":"smartadserver","params":{"domain":"https:\/\/prg.smartadserver.com","siteId":271349,"bidfloor":0.03,"networkId":3259,"pageId":1016200,"formatId":71227}}],"sizes":[[300,250]]}];
        var slotToBid = ["div-gpt-ad-item-top","div-gpt-ad-item-sidebar"];
        var bidData = {"criteo":{"bidRate":1,"bidFloor":{"div-gpt-ad-item-top":0.03,"div-gpt-ad-item-sidebar":0.03,"div-gpt-ad-rectangle_gallery":0.03}},"rtbhouse":{"bidRate":1,"bidFloor":{"div-gpt-ad-item-top":0.03,"div-gpt-ad-item-sidebar":0.03,"div-gpt-ad-rectangle_gallery":0.03}},"admixer":{"bidRate":0.75,"bidFloor":{"div-gpt-ad-item-top":0.03,"div-gpt-ad-item-sidebar":0.03,"div-gpt-ad-rectangle_gallery":0.03}},"smartadserver":{"bidRate":0.86,"bidFloor":{"div-gpt-ad-item-top":0.03,"div-gpt-ad-item-sidebar":0.03,"div-gpt-ad-rectangle_gallery":0.03}}};
        var priceRanges = {"buckets":[{"min":0.01,"max":3,"increment":0.01},{"min":3,"max":30,"increment":0.1}]};
        var currencyConfig = {"adServerCurrency":"EUR","granularityMultiplier":1,"bidderCurrencyDefault":{"openx":"EUR"},"rates":{"USD":{"EUR":0.9}}};
        var bidderAliases = [];
        var prebidTargetingConfig = [];
                    var slotsPreventBeforeLoad = [];
        
        var pbjs = pbjs || {};
        pbjs.que = pbjs.que || [];;
    
                                </script>
                            <script type="text/javascript">
                    var gptadslots = [];
                    var googletag = googletag || {};
                    googletag.cmd = googletag.cmd || [];

                    initGptScript();
                    var performanceData = {"segment_key":"dfp_segment_test_v4","slots_to_control":["div-gpt-ad-listing-middle","div_gpt_listing_content1","div_gpt_listing_content2","div_gpt_listing_content3","div-gpt-liting-after-promoted","div-gpt-ad-listing-top","div-gpt-ad-listing-sidebar","div-gpt-ad-listing-bottom","div-gpt-ad-item-content1","div-gpt-ad-item-content2","div-gpt-ad-item-content3","div-gpt-ad-item-sidebar","div-gpt-ad-item-top","div-gpt-ad-rectangle_gallery"],"slots":[],"group":{"premium_ads":{"slots":["div-gpt-ad-item-content1","div-gpt-ad-item-content2","div-gpt-ad-item-content3","div-gpt-ad-item-sidebar","div-gpt-ad-item-top","div-gpt-ad-rectangle_gallery"],"targeting":{"premium_ad":"1"},"segments":[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100],"limit":-1,"pv_limit":0,"blocked":true,"unblocked":false,"setMaxBidValue":false}}};
                    var controlEngineSetting = {"div-gpt-ad-listing-bottom":{"name":"ud8","active":"true","cpm_id":"ud8","cpm":{"ud8p1":0,"ud8p2":0.01,"ud8p3":0.02,"ud8p4":0.03,"ud8p5":0.04,"ud8p6":0.05,"ud8p7":0.06,"ud8p8":0.07,"ud8p9":0.08,"ud8p10":0.09,"ud8p11":0.1,"ud8p12":0.11,"ud8p13":0.12,"ud8p14":0.13,"ud8p15":0.14,"ud8p16":0.15,"ud8p17":0.16,"ud8p18":0.17,"ud8p19":0.18,"ud8p20":0.19,"ud8p21":0.2,"ud8p22":0.21,"ud8p23":0.22,"ud8p24":0.23,"ud8p25":0.24,"ud8p26":0.25,"ud8p27":0.26,"ud8p28":0.27,"ud8p29":0.28,"ud8p30":0.29,"ud8p31":0.3,"ud8p32":0.32,"ud8p33":0.34,"ud8p34":0.36,"ud8p35":0.38,"ud8p36":0.4,"ud8p37":0.42,"ud8p38":0.44,"ud8p39":0.46,"ud8p40":0.48,"ud8p41":0.5,"ud8p42":0.55,"ud8p43":0.6,"ud8p44":0.65,"ud8p45":0.7,"ud8p46":0.75,"ud8p47":0.8,"ud8p48":0.85,"ud8p49":0.9,"ud8p50":0.95,"ud8p51":1,"ud8p52":1.1,"ud8p53":1.2,"ud8p54":1.3,"ud8p55":1.4,"ud8p56":1.5,"ud8p57":1.6,"ud8p58":1.7,"ud8p59":1.8,"ud8p60":1.9,"ud8p61":2}},"div-gpt-ad-item-top":{"name":"ud2","active":"true","cpm_id":"ud2","cpm":{"ud2p1":0,"ud2p2":0.01,"ud2p3":0.02,"ud2p4":0.03,"ud2p5":0.04,"ud2p6":0.05,"ud2p7":0.06,"ud2p8":0.07,"ud2p9":0.08,"ud2p10":0.09,"ud2p11":0.1,"ud2p12":0.11,"ud2p13":0.12,"ud2p14":0.13,"ud2p15":0.14,"ud2p16":0.15,"ud2p17":0.16,"ud2p18":0.17,"ud2p19":0.18,"ud2p20":0.19,"ud2p21":0.2,"ud2p22":0.21,"ud2p23":0.22,"ud2p24":0.23,"ud2p25":0.24,"ud2p26":0.25,"ud2p27":0.26,"ud2p28":0.27,"ud2p29":0.28,"ud2p30":0.29,"ud2p31":0.3,"ud2p32":0.32,"ud2p33":0.34,"ud2p34":0.36,"ud2p35":0.38,"ud2p36":0.4,"ud2p37":0.42,"ud2p38":0.44,"ud2p39":0.46,"ud2p40":0.48,"ud2p41":0.5,"ud2p42":0.55,"ud2p43":0.6,"ud2p44":0.65,"ud2p45":0.7,"ud2p46":0.75,"ud2p47":0.8,"ud2p48":0.85,"ud2p49":0.9,"ud2p50":0.95,"ud2p51":1,"ud2p52":1.1,"ud2p53":1.2,"ud2p54":1.3,"ud2p55":1.4,"ud2p56":1.5,"ud2p57":1.6,"ud2p58":1.7,"ud2p59":1.8,"ud2p60":1.9,"ud2p61":2}},"div-gpt-ad-listing-top":{"name":"ud1","active":"true","cpm_id":"ud1","cpm":{"ud1p1":0,"ud1p2":0.01,"ud1p3":0.02,"ud1p4":0.03,"ud1p5":0.04,"ud1p6":0.05,"ud1p7":0.06,"ud1p8":0.07,"ud1p9":0.08,"ud1p10":0.09,"ud1p11":0.1,"ud1p12":0.11,"ud1p13":0.12,"ud1p14":0.13,"ud1p15":0.14,"ud1p16":0.15,"ud1p17":0.16,"ud1p18":0.17,"ud1p19":0.18,"ud1p20":0.19,"ud1p21":0.2,"ud1p22":0.21,"ud1p23":0.22,"ud1p24":0.23,"ud1p25":0.24,"ud1p26":0.25,"ud1p27":0.26,"ud1p28":0.27,"ud1p29":0.28,"ud1p30":0.29,"ud1p31":0.3,"ud1p32":0.32,"ud1p33":0.34,"ud1p34":0.36,"ud1p35":0.38,"ud1p36":0.4,"ud1p37":0.42,"ud1p38":0.44,"ud1p39":0.46,"ud1p40":0.48,"ud1p41":0.5,"ud1p42":0.55,"ud1p43":0.6,"ud1p44":0.65,"ud1p45":0.7,"ud1p46":0.75,"ud1p47":0.8,"ud1p48":0.85,"ud1p49":0.9,"ud1p50":0.95,"ud1p51":1,"ud1p52":1.1,"ud1p53":1.2,"ud1p54":1.3,"ud1p55":1.4,"ud1p56":1.5,"ud1p57":1.6,"ud1p58":1.7,"ud1p59":1.8,"ud1p60":1.9,"ud1p61":2}},"div-gpt-ad-item-top-r":{"name":"ud9","active":"true","cpm_id":"ud9","cpm":{"ud9p1":0,"ud9p2":0.01,"ud9p3":0.02,"ud9p4":0.03,"ud9p5":0.04,"ud9p6":0.05,"ud9p7":0.06,"ud9p8":0.07,"ud9p9":0.08,"ud9p10":0.09,"ud9p11":0.1,"ud9p12":0.11,"ud9p13":0.12,"ud9p14":0.13,"ud9p15":0.14,"ud9p16":0.15,"ud9p17":0.16,"ud9p18":0.17,"ud9p19":0.18,"ud9p20":0.19,"ud9p21":0.2,"ud9p22":0.21,"ud9p23":0.22,"ud9p24":0.23,"ud9p25":0.24,"ud9p26":0.25,"ud9p27":0.26,"ud9p28":0.27,"ud9p29":0.28,"ud9p30":0.29,"ud9p31":0.3,"ud9p32":0.32,"ud9p33":0.34,"ud9p34":0.36,"ud9p35":0.38,"ud9p36":0.4,"ud9p37":0.42,"ud9p38":0.44,"ud9p39":0.46,"ud9p40":0.48,"ud9p41":0.5,"ud9p42":0.55,"ud9p43":0.6,"ud9p44":0.65,"ud9p45":0.7,"ud9p46":0.75,"ud9p47":0.8,"ud9p48":0.85,"ud9p49":0.9,"ud9p50":0.95,"ud9p51":1,"ud9p52":1.1,"ud9p53":1.2,"ud9p54":1.3,"ud9p55":1.4,"ud9p56":1.5,"ud9p57":1.6,"ud9p58":1.7,"ud9p59":1.8,"ud9p60":1.9,"ud9p61":2}},"div-gpt-ad-listing-top-r":{"name":"ud10","active":"true","cpm_id":"ud10","cpm":{"ud10p1":0,"ud10p2":0.01,"ud10p3":0.02,"ud10p4":0.03,"ud10p5":0.04,"ud10p6":0.05,"ud10p7":0.06,"ud10p8":0.07,"ud10p9":0.08,"ud10p10":0.09,"ud10p11":0.1,"ud10p12":0.11,"ud10p13":0.12,"ud10p14":0.13,"ud10p15":0.14,"ud10p16":0.15,"ud10p17":0.16,"ud10p18":0.17,"ud10p19":0.18,"ud10p20":0.19,"ud10p21":0.2,"ud10p22":0.21,"ud10p23":0.22,"ud10p24":0.23,"ud10p25":0.24,"ud10p26":0.25,"ud10p27":0.26,"ud10p28":0.27,"ud10p29":0.28,"ud10p30":0.29,"ud10p31":0.3,"ud10p32":0.32,"ud10p33":0.34,"ud10p34":0.36,"ud10p35":0.38,"ud10p36":0.4,"ud10p37":0.42,"ud10p38":0.44,"ud10p39":0.46,"ud10p40":0.48,"ud10p41":0.5,"ud10p42":0.55,"ud10p43":0.6,"ud10p44":0.65,"ud10p45":0.7,"ud10p46":0.75,"ud10p47":0.8,"ud10p48":0.85,"ud10p49":0.9,"ud10p50":0.95,"ud10p51":1,"ud10p52":1.1,"ud10p53":1.2,"ud10p54":1.3,"ud10p55":1.4,"ud10p56":1.5,"ud10p57":1.6,"ud10p58":1.7,"ud10p59":1.8,"ud10p60":1.9,"ud10p61":2}},"div-gpt-ad-item-content1":{"name":"ud11","active":"true","cpm_id":"ud11","cpm":{"ud11p1":0,"ud11p2":0.01,"ud11p3":0.02,"ud11p4":0.03,"ud11p5":0.04,"ud11p6":0.05,"ud11p7":0.06,"ud11p8":0.07,"ud11p9":0.08,"ud11p10":0.09,"ud11p11":0.1,"ud11p12":0.11,"ud11p13":0.12,"ud11p14":0.13,"ud11p15":0.14,"ud11p16":0.15,"ud11p17":0.16,"ud11p18":0.17,"ud11p19":0.18,"ud11p20":0.19,"ud11p21":0.2,"ud11p22":0.21,"ud11p23":0.22,"ud11p24":0.23,"ud11p25":0.24,"ud11p26":0.25,"ud11p27":0.26,"ud11p28":0.27,"ud11p29":0.28,"ud11p30":0.29,"ud11p31":0.3,"ud11p32":0.32,"ud11p33":0.34,"ud11p34":0.36,"ud11p35":0.38,"ud11p36":0.4,"ud11p37":0.42,"ud11p38":0.44,"ud11p39":0.46,"ud11p40":0.48,"ud11p41":0.5,"ud11p42":0.55,"ud11p43":0.6,"ud11p44":0.65,"ud11p45":0.7,"ud11p46":0.75,"ud11p47":0.8,"ud11p48":0.85,"ud11p49":0.9,"ud11p50":0.95,"ud11p51":1,"ud11p52":1.1,"ud11p53":1.2,"ud11p54":1.3,"ud11p55":1.4,"ud11p56":1.5,"ud11p57":1.6,"ud11p58":1.7,"ud11p59":1.8,"ud11p60":1.9,"ud11p61":2}},"div_gpt_listing_content1":{"name":"ud12","active":"true","cpm_id":"ud12","cpm":{"ud12p1":0,"ud12p2":0.01,"ud12p3":0.02,"ud12p4":0.03,"ud12p5":0.04,"ud12p6":0.05,"ud12p7":0.06,"ud12p8":0.07,"ud12p9":0.08,"ud12p10":0.09,"ud12p11":0.1,"ud12p12":0.11,"ud12p13":0.12,"ud12p14":0.13,"ud12p15":0.14,"ud12p16":0.15,"ud12p17":0.16,"ud12p18":0.17,"ud12p19":0.18,"ud12p20":0.19,"ud12p21":0.2,"ud12p22":0.21,"ud12p23":0.22,"ud12p24":0.23,"ud12p25":0.24,"ud12p26":0.25,"ud12p27":0.26,"ud12p28":0.27,"ud12p29":0.28,"ud12p30":0.29,"ud12p31":0.3,"ud12p32":0.32,"ud12p33":0.34,"ud12p34":0.36,"ud12p35":0.38,"ud12p36":0.4,"ud12p37":0.42,"ud12p38":0.44,"ud12p39":0.46,"ud12p40":0.48,"ud12p41":0.5,"ud12p42":0.55,"ud12p43":0.6,"ud12p44":0.65,"ud12p45":0.7,"ud12p46":0.75,"ud12p47":0.8,"ud12p48":0.85,"ud12p49":0.9,"ud12p50":0.95,"ud12p51":1,"ud12p52":1.1,"ud12p53":1.2,"ud12p54":1.3,"ud12p55":1.4,"ud12p56":1.5,"ud12p57":1.6,"ud12p58":1.7,"ud12p59":1.8,"ud12p60":1.9,"ud12p61":2}},"div-gpt-ad-item-content2":{"name":"ud13","active":"true","cpm_id":"ud13","cpm":{"ud13p1":0,"ud13p2":0.01,"ud13p3":0.02,"ud13p4":0.03,"ud13p5":0.04,"ud13p6":0.05,"ud13p7":0.06,"ud13p8":0.07,"ud13p9":0.08,"ud13p10":0.09,"ud13p11":0.1,"ud13p12":0.11,"ud13p13":0.12,"ud13p14":0.13,"ud13p15":0.14,"ud13p16":0.15,"ud13p17":0.16,"ud13p18":0.17,"ud13p19":0.18,"ud13p20":0.19,"ud13p21":0.2,"ud13p22":0.21,"ud13p23":0.22,"ud13p24":0.23,"ud13p25":0.24,"ud13p26":0.25,"ud13p27":0.26,"ud13p28":0.27,"ud13p29":0.28,"ud13p30":0.29,"ud13p31":0.3,"ud13p32":0.32,"ud13p33":0.34,"ud13p34":0.36,"ud13p35":0.38,"ud13p36":0.4,"ud13p37":0.42,"ud13p38":0.44,"ud13p39":0.46,"ud13p40":0.48,"ud13p41":0.5,"ud13p42":0.55,"ud13p43":0.6,"ud13p44":0.65,"ud13p45":0.7,"ud13p46":0.75,"ud13p47":0.8,"ud13p48":0.85,"ud13p49":0.9,"ud13p50":0.95,"ud13p51":1,"ud13p52":1.1,"ud13p53":1.2,"ud13p54":1.3,"ud13p55":1.4,"ud13p56":1.5,"ud13p57":1.6,"ud13p58":1.7,"ud13p59":1.8,"ud13p60":1.9,"ud13p61":2}},"div_gpt_listing_content2":{"name":"ud14","active":"true","cpm_id":"ud14","cpm":{"ud14p1":0,"ud14p2":0.01,"ud14p3":0.02,"ud14p4":0.03,"ud14p5":0.04,"ud14p6":0.05,"ud14p7":0.06,"ud14p8":0.07,"ud14p9":0.08,"ud14p10":0.09,"ud14p11":0.1,"ud14p12":0.11,"ud14p13":0.12,"ud14p14":0.13,"ud14p15":0.14,"ud14p16":0.15,"ud14p17":0.16,"ud14p18":0.17,"ud14p19":0.18,"ud14p20":0.19,"ud14p21":0.2,"ud14p22":0.21,"ud14p23":0.22,"ud14p24":0.23,"ud14p25":0.24,"ud14p26":0.25,"ud14p27":0.26,"ud14p28":0.27,"ud14p29":0.28,"ud14p30":0.29,"ud14p31":0.3,"ud14p32":0.32,"ud14p33":0.34,"ud14p34":0.36,"ud14p35":0.38,"ud14p36":0.4,"ud14p37":0.42,"ud14p38":0.44,"ud14p39":0.46,"ud14p40":0.48,"ud14p41":0.5,"ud14p42":0.55,"ud14p43":0.6,"ud14p44":0.65,"ud14p45":0.7,"ud14p46":0.75,"ud14p47":0.8,"ud14p48":0.85,"ud14p49":0.9,"ud14p50":0.95,"ud14p51":1,"ud14p52":1.1,"ud14p53":1.2,"ud14p54":1.3,"ud14p55":1.4,"ud14p56":1.5,"ud14p57":1.6,"ud14p58":1.7,"ud14p59":1.8,"ud14p60":1.9,"ud14p61":2}},"div-gpt-ad-item-content3":{"name":"ud7","active":"true","cpm_id":"ud7","cpm":{"ud7p1":0,"ud7p2":0.01,"ud7p3":0.02,"ud7p4":0.03,"ud7p5":0.04,"ud7p6":0.05,"ud7p7":0.06,"ud7p8":0.07,"ud7p9":0.08,"ud7p10":0.09,"ud7p11":0.1,"ud7p12":0.11,"ud7p13":0.12,"ud7p14":0.13,"ud7p15":0.14,"ud7p16":0.15,"ud7p17":0.16,"ud7p18":0.17,"ud7p19":0.18,"ud7p20":0.19,"ud7p21":0.2,"ud7p22":0.21,"ud7p23":0.22,"ud7p24":0.23,"ud7p25":0.24,"ud7p26":0.25,"ud7p27":0.26,"ud7p28":0.27,"ud7p29":0.28,"ud7p30":0.29,"ud7p31":0.3,"ud7p32":0.32,"ud7p33":0.34,"ud7p34":0.36,"ud7p35":0.38,"ud7p36":0.4,"ud7p37":0.42,"ud7p38":0.44,"ud7p39":0.46,"ud7p40":0.48,"ud7p41":0.5,"ud7p42":0.55,"ud7p43":0.6,"ud7p44":0.65,"ud7p45":0.7,"ud7p46":0.75,"ud7p47":0.8,"ud7p48":0.85,"ud7p49":0.9,"ud7p50":0.95,"ud7p51":1,"ud7p52":1.1,"ud7p53":1.2,"ud7p54":1.3,"ud7p55":1.4,"ud7p56":1.5,"ud7p57":1.6,"ud7p58":1.7,"ud7p59":1.8,"ud7p60":1.9,"ud7p61":2}},"div_gpt_listing_content3":{"name":"ud15","active":"true","cpm_id":"ud15","cpm":{"ud15p1":0,"ud15p2":0.01,"ud15p3":0.02,"ud15p4":0.03,"ud15p5":0.04,"ud15p6":0.05,"ud15p7":0.06,"ud15p8":0.07,"ud15p9":0.08,"ud15p10":0.09,"ud15p11":0.1,"ud15p12":0.11,"ud15p13":0.12,"ud15p14":0.13,"ud15p15":0.14,"ud15p16":0.15,"ud15p17":0.16,"ud15p18":0.17,"ud15p19":0.18,"ud15p20":0.19,"ud15p21":0.2,"ud15p22":0.21,"ud15p23":0.22,"ud15p24":0.23,"ud15p25":0.24,"ud15p26":0.25,"ud15p27":0.26,"ud15p28":0.27,"ud15p29":0.28,"ud15p30":0.29,"ud15p31":0.3,"ud15p32":0.32,"ud15p33":0.34,"ud15p34":0.36,"ud15p35":0.38,"ud15p36":0.4,"ud15p37":0.42,"ud15p38":0.44,"ud15p39":0.46,"ud15p40":0.48,"ud15p41":0.5,"ud15p42":0.55,"ud15p43":0.6,"ud15p44":0.65,"ud15p45":0.7,"ud15p46":0.75,"ud15p47":0.8,"ud15p48":0.85,"ud15p49":0.9,"ud15p50":0.95,"ud15p51":1,"ud15p52":1.1,"ud15p53":1.2,"ud15p54":1.3,"ud15p55":1.4,"ud15p56":1.5,"ud15p57":1.6,"ud15p58":1.7,"ud15p59":1.8,"ud15p60":1.9,"ud15p61":2}},"div-gpt-ad-listing-middle":{"name":"ud6","active":"true","cpm_id":"ud6","cpm":{"ud6p1":0,"ud6p2":0.01,"ud6p3":0.02,"ud6p4":0.03,"ud6p5":0.04,"ud6p6":0.05,"ud6p7":0.06,"ud6p8":0.07,"ud6p9":0.08,"ud6p10":0.09,"ud6p11":0.1,"ud6p12":0.11,"ud6p13":0.12,"ud6p14":0.13,"ud6p15":0.14,"ud6p16":0.15,"ud6p17":0.16,"ud6p18":0.17,"ud6p19":0.18,"ud6p20":0.19,"ud6p21":0.2,"ud6p22":0.21,"ud6p23":0.22,"ud6p24":0.23,"ud6p25":0.24,"ud6p26":0.25,"ud6p27":0.26,"ud6p28":0.27,"ud6p29":0.28,"ud6p30":0.29,"ud6p31":0.3,"ud6p32":0.32,"ud6p33":0.34,"ud6p34":0.36,"ud6p35":0.38,"ud6p36":0.4,"ud6p37":0.42,"ud6p38":0.44,"ud6p39":0.46,"ud6p40":0.48,"ud6p41":0.5,"ud6p42":0.55,"ud6p43":0.6,"ud6p44":0.65,"ud6p45":0.7,"ud6p46":0.75,"ud6p47":0.8,"ud6p48":0.85,"ud6p49":0.9,"ud6p50":0.95,"ud6p51":1,"ud6p52":1.1,"ud6p53":1.2,"ud6p54":1.3,"ud6p55":1.4,"ud6p56":1.5,"ud6p57":1.6,"ud6p58":1.7,"ud6p59":1.8,"ud6p60":1.9,"ud6p61":2}},"div-gpt-liting-after-promoted":{"name":"ud5","active":"true","cpm_id":"ud5","cpm":{"ud5p1":0,"ud5p2":0.01,"ud5p3":0.02,"ud5p4":0.03,"ud5p5":0.04,"ud5p6":0.05,"ud5p7":0.06,"ud5p8":0.07,"ud5p9":0.08,"ud5p10":0.09,"ud5p11":0.1,"ud5p12":0.11,"ud5p13":0.12,"ud5p14":0.13,"ud5p15":0.14,"ud5p16":0.15,"ud5p17":0.16,"ud5p18":0.17,"ud5p19":0.18,"ud5p20":0.19,"ud5p21":0.2,"ud5p22":0.21,"ud5p23":0.22,"ud5p24":0.23,"ud5p25":0.24,"ud5p26":0.25,"ud5p27":0.26,"ud5p28":0.27,"ud5p29":0.28,"ud5p30":0.29,"ud5p31":0.3,"ud5p32":0.32,"ud5p33":0.34,"ud5p34":0.36,"ud5p35":0.38,"ud5p36":0.4,"ud5p37":0.42,"ud5p38":0.44,"ud5p39":0.46,"ud5p40":0.48,"ud5p41":0.5,"ud5p42":0.55,"ud5p43":0.6,"ud5p44":0.65,"ud5p45":0.7,"ud5p46":0.75,"ud5p47":0.8,"ud5p48":0.85,"ud5p49":0.9,"ud5p50":0.95,"ud5p51":1,"ud5p52":1.1,"ud5p53":1.2,"ud5p54":1.3,"ud5p55":1.4,"ud5p56":1.5,"ud5p57":1.6,"ud5p58":1.7,"ud5p59":1.8,"ud5p60":1.9,"ud5p61":2}},"div-gpt-ad-item-sidebar":{"name":"ud4","active":"true","cpm_id":"ud4","cpm":{"ud4p1":0,"ud4p2":0.01,"ud4p3":0.02,"ud4p4":0.03,"ud4p5":0.04,"ud4p6":0.05,"ud4p7":0.06,"ud4p8":0.07,"ud4p9":0.08,"ud4p10":0.09,"ud4p11":0.1,"ud4p12":0.11,"ud4p13":0.12,"ud4p14":0.13,"ud4p15":0.14,"ud4p16":0.15,"ud4p17":0.16,"ud4p18":0.17,"ud4p19":0.18,"ud4p20":0.19,"ud4p21":0.2,"ud4p22":0.21,"ud4p23":0.22,"ud4p24":0.23,"ud4p25":0.24,"ud4p26":0.25,"ud4p27":0.26,"ud4p28":0.27,"ud4p29":0.28,"ud4p30":0.29,"ud4p31":0.3,"ud4p32":0.32,"ud4p33":0.34,"ud4p34":0.36,"ud4p35":0.38,"ud4p36":0.4,"ud4p37":0.42,"ud4p38":0.44,"ud4p39":0.46,"ud4p40":0.48,"ud4p41":0.5,"ud4p42":0.55,"ud4p43":0.6,"ud4p44":0.65,"ud4p45":0.7,"ud4p46":0.75,"ud4p47":0.8,"ud4p48":0.85,"ud4p49":0.9,"ud4p50":0.95,"ud4p51":1,"ud4p52":1.1,"ud4p53":1.2,"ud4p54":1.3,"ud4p55":1.4,"ud4p56":1.5,"ud4p57":1.6,"ud4p58":1.7,"ud4p59":1.8,"ud4p60":1.9,"ud4p61":2}},"div-gpt-ad-item-sidebar-r":{"name":"ud16","active":"true","cpm_id":"ud16","cpm":{"ud16p1":0,"ud16p2":0.01,"ud16p3":0.02,"ud16p4":0.03,"ud16p5":0.04,"ud16p6":0.05,"ud16p7":0.06,"ud16p8":0.07,"ud16p9":0.08,"ud16p10":0.09,"ud16p11":0.1,"ud16p12":0.11,"ud16p13":0.12,"ud16p14":0.13,"ud16p15":0.14,"ud16p16":0.15,"ud16p17":0.16,"ud16p18":0.17,"ud16p19":0.18,"ud16p20":0.19,"ud16p21":0.2,"ud16p22":0.21,"ud16p23":0.22,"ud16p24":0.23,"ud16p25":0.24,"ud16p26":0.25,"ud16p27":0.26,"ud16p28":0.27,"ud16p29":0.28,"ud16p30":0.29,"ud16p31":0.3,"ud16p32":0.32,"ud16p33":0.34,"ud16p34":0.36,"ud16p35":0.38,"ud16p36":0.4,"ud16p37":0.42,"ud16p38":0.44,"ud16p39":0.46,"ud16p40":0.48,"ud16p41":0.5,"ud16p42":0.55,"ud16p43":0.6,"ud16p44":0.65,"ud16p45":0.7,"ud16p46":0.75,"ud16p47":0.8,"ud16p48":0.85,"ud16p49":0.9,"ud16p50":0.95,"ud16p51":1,"ud16p52":1.1,"ud16p53":1.2,"ud16p54":1.3,"ud16p55":1.4,"ud16p56":1.5,"ud16p57":1.6,"ud16p58":1.7,"ud16p59":1.8,"ud16p60":1.9,"ud16p61":2}},"div-gpt-ad-rectangle_gallery":{"name":"ud17","active":"true","cpm_id":"ud17","cpm":{"ud17p1":0,"ud17p2":0.01,"ud17p3":0.02,"ud17p4":0.03,"ud17p5":0.04,"ud17p6":0.05,"ud17p7":0.06,"ud17p8":0.07,"ud17p9":0.08,"ud17p10":0.09,"ud17p11":0.1,"ud17p12":0.11,"ud17p13":0.12,"ud17p14":0.13,"ud17p15":0.14,"ud17p16":0.15,"ud17p17":0.16,"ud17p18":0.17,"ud17p19":0.18,"ud17p20":0.19,"ud17p21":0.2,"ud17p22":0.21,"ud17p23":0.22,"ud17p24":0.23,"ud17p25":0.24,"ud17p26":0.25,"ud17p27":0.26,"ud17p28":0.27,"ud17p29":0.28,"ud17p30":0.29,"ud17p31":0.3,"ud17p32":0.32,"ud17p33":0.34,"ud17p34":0.36,"ud17p35":0.38,"ud17p36":0.4,"ud17p37":0.42,"ud17p38":0.44,"ud17p39":0.46,"ud17p40":0.48,"ud17p41":0.5,"ud17p42":0.55,"ud17p43":0.6,"ud17p44":0.65,"ud17p45":0.7,"ud17p46":0.75,"ud17p47":0.8,"ud17p48":0.85,"ud17p49":0.9,"ud17p50":0.95,"ud17p51":1,"ud17p52":1.1,"ud17p53":1.2,"ud17p54":1.3,"ud17p55":1.4,"ud17p56":1.5,"ud17p57":1.6,"ud17p58":1.7,"ud17p59":1.8,"ud17p60":1.9,"ud17p61":2}},"div-gpt-ad-listing-sidebar":{"name":"ud3","active":"true","cpm_id":"ud3","cpm":{"ud3p1":0,"ud3p2":0.01,"ud3p3":0.02,"ud3p4":0.03,"ud3p5":0.04,"ud3p6":0.05,"ud3p7":0.06,"ud3p8":0.07,"ud3p9":0.08,"ud3p10":0.09,"ud3p11":0.1,"ud3p12":0.11,"ud3p13":0.12,"ud3p14":0.13,"ud3p15":0.14,"ud3p16":0.15,"ud3p17":0.16,"ud3p18":0.17,"ud3p19":0.18,"ud3p20":0.19,"ud3p21":0.2,"ud3p22":0.21,"ud3p23":0.22,"ud3p24":0.23,"ud3p25":0.24,"ud3p26":0.25,"ud3p27":0.26,"ud3p28":0.27,"ud3p29":0.28,"ud3p30":0.29,"ud3p31":0.3,"ud3p32":0.32,"ud3p33":0.34,"ud3p34":0.36,"ud3p35":0.38,"ud3p36":0.4,"ud3p37":0.42,"ud3p38":0.44,"ud3p39":0.46,"ud3p40":0.48,"ud3p41":0.5,"ud3p42":0.55,"ud3p43":0.6,"ud3p44":0.65,"ud3p45":0.7,"ud3p46":0.75,"ud3p47":0.8,"ud3p48":0.85,"ud3p49":0.9,"ud3p50":0.95,"ud3p51":1,"ud3p52":1.1,"ud3p53":1.2,"ud3p54":1.3,"ud3p55":1.4,"ud3p56":1.5,"ud3p57":1.6,"ud3p58":1.7,"ud3p59":1.8,"ud3p60":1.9,"ud3p61":2}},"div-gpt-ad-listing-sidebar-r":{"name":"ud18","active":"true","cpm_id":"ud18","cpm":{"ud18p1":0,"ud18p2":0.01,"ud18p3":0.02,"ud18p4":0.03,"ud18p5":0.04,"ud18p6":0.05,"ud18p7":0.06,"ud18p8":0.07,"ud18p9":0.08,"ud18p10":0.09,"ud18p11":0.1,"ud18p12":0.11,"ud18p13":0.12,"ud18p14":0.13,"ud18p15":0.14,"ud18p16":0.15,"ud18p17":0.16,"ud18p18":0.17,"ud18p19":0.18,"ud18p20":0.19,"ud18p21":0.2,"ud18p22":0.21,"ud18p23":0.22,"ud18p24":0.23,"ud18p25":0.24,"ud18p26":0.25,"ud18p27":0.26,"ud18p28":0.27,"ud18p29":0.28,"ud18p30":0.29,"ud18p31":0.3,"ud18p32":0.32,"ud18p33":0.34,"ud18p34":0.36,"ud18p35":0.38,"ud18p36":0.4,"ud18p37":0.42,"ud18p38":0.44,"ud18p39":0.46,"ud18p40":0.48,"ud18p41":0.5,"ud18p42":0.55,"ud18p43":0.6,"ud18p44":0.65,"ud18p45":0.7,"ud18p46":0.75,"ud18p47":0.8,"ud18p48":0.85,"ud18p49":0.9,"ud18p50":0.95,"ud18p51":1,"ud18p52":1.1,"ud18p53":1.2,"ud18p54":1.3,"ud18p55":1.4,"ud18p56":1.5,"ud18p57":1.6,"ud18p58":1.7,"ud18p59":1.8,"ud18p60":1.9,"ud18p61":2}},"ad_page_bottom":{"name":"um5","active":"true","cpm_id":"um5","cpm":{"um5p1":0,"um5p2":0.01,"um5p3":0.02,"um5p4":0.03,"um5p5":0.04,"um5p6":0.05,"um5p7":0.06,"um5p8":0.07,"um5p9":0.08,"um5p10":0.09,"um5p11":0.1,"um5p12":0.11,"um5p13":0.12,"um5p14":0.13,"um5p15":0.14,"um5p16":0.15,"um5p17":0.16,"um5p18":0.17,"um5p19":0.18,"um5p20":0.19,"um5p21":0.2,"um5p22":0.21,"um5p23":0.22,"um5p24":0.23,"um5p25":0.24,"um5p26":0.25,"um5p27":0.26,"um5p28":0.27,"um5p29":0.28,"um5p30":0.29,"um5p31":0.3,"um5p32":0.32,"um5p33":0.34,"um5p34":0.36,"um5p35":0.38,"um5p36":0.4,"um5p37":0.42,"um5p38":0.44,"um5p39":0.46,"um5p40":0.48,"um5p41":0.5,"um5p42":0.55,"um5p43":0.6,"um5p44":0.65,"um5p45":0.7,"um5p46":0.75,"um5p47":0.8,"um5p48":0.85,"um5p49":0.9,"um5p50":0.95,"um5p51":1,"um5p52":1.1,"um5p53":1.2,"um5p54":1.3,"um5p55":1.4,"um5p56":1.5,"um5p57":1.6,"um5p58":1.7,"um5p59":1.8,"um5p60":1.9,"um5p61":2}},"ad_page_gallery":{"name":"um1","active":"true","cpm_id":"um1","cpm":{"um1p1":0,"um1p2":0.01,"um1p3":0.02,"um1p4":0.03,"um1p5":0.04,"um1p6":0.05,"um1p7":0.06,"um1p8":0.07,"um1p9":0.08,"um1p10":0.09,"um1p11":0.1,"um1p12":0.11,"um1p13":0.12,"um1p14":0.13,"um1p15":0.14,"um1p16":0.15,"um1p17":0.16,"um1p18":0.17,"um1p19":0.18,"um1p20":0.19,"um1p21":0.2,"um1p22":0.21,"um1p23":0.22,"um1p24":0.23,"um1p25":0.24,"um1p26":0.25,"um1p27":0.26,"um1p28":0.27,"um1p29":0.28,"um1p30":0.29,"um1p31":0.3,"um1p32":0.32,"um1p33":0.34,"um1p34":0.36,"um1p35":0.38,"um1p36":0.4,"um1p37":0.42,"um1p38":0.44,"um1p39":0.46,"um1p40":0.48,"um1p41":0.5,"um1p42":0.55,"um1p43":0.6,"um1p44":0.65,"um1p45":0.7,"um1p46":0.75,"um1p47":0.8,"um1p48":0.85,"um1p49":0.9,"um1p50":0.95,"um1p51":1,"um1p52":1.1,"um1p53":1.2,"um1p54":1.3,"um1p55":1.4,"um1p56":1.5,"um1p57":1.6,"um1p58":1.7,"um1p59":1.8,"um1p60":1.9,"um1p61":2}},"homepage_top":{"name":"um7","active":"true","cpm_id":"um7","cpm":{"um7p1":0,"um7p2":0.01,"um7p3":0.02,"um7p4":0.03,"um7p5":0.04,"um7p6":0.05,"um7p7":0.06,"um7p8":0.07,"um7p9":0.08,"um7p10":0.09,"um7p11":0.1,"um7p12":0.11,"um7p13":0.12,"um7p14":0.13,"um7p15":0.14,"um7p16":0.15,"um7p17":0.16,"um7p18":0.17,"um7p19":0.18,"um7p20":0.19,"um7p21":0.2,"um7p22":0.21,"um7p23":0.22,"um7p24":0.23,"um7p25":0.24,"um7p26":0.25,"um7p27":0.26,"um7p28":0.27,"um7p29":0.28,"um7p30":0.29,"um7p31":0.3,"um7p32":0.32,"um7p33":0.34,"um7p34":0.36,"um7p35":0.38,"um7p36":0.4,"um7p37":0.42,"um7p38":0.44,"um7p39":0.46,"um7p40":0.48,"um7p41":0.5,"um7p42":0.55,"um7p43":0.6,"um7p44":0.65,"um7p45":0.7,"um7p46":0.75,"um7p47":0.8,"um7p48":0.85,"um7p49":0.9,"um7p50":0.95,"um7p51":1,"um7p52":1.1,"um7p53":1.2,"um7p54":1.3,"um7p55":1.4,"um7p56":1.5,"um7p57":1.6,"um7p58":1.7,"um7p59":1.8,"um7p60":1.9,"um7p61":2}},"listing_nonstandard":{"name":"um6","active":"true","cpm_id":"um6","cpm":{"um6p1":0,"um6p2":0.01,"um6p3":0.02,"um6p4":0.03,"um6p5":0.04,"um6p6":0.05,"um6p7":0.06,"um6p8":0.07,"um6p9":0.08,"um6p10":0.09,"um6p11":0.1,"um6p12":0.11,"um6p13":0.12,"um6p14":0.13,"um6p15":0.14,"um6p16":0.15,"um6p17":0.16,"um6p18":0.17,"um6p19":0.18,"um6p20":0.19,"um6p21":0.2,"um6p22":0.21,"um6p23":0.22,"um6p24":0.23,"um6p25":0.24,"um6p26":0.25,"um6p27":0.26,"um6p28":0.27,"um6p29":0.28,"um6p30":0.29,"um6p31":0.3,"um6p32":0.32,"um6p33":0.34,"um6p34":0.36,"um6p35":0.38,"um6p36":0.4,"um6p37":0.42,"um6p38":0.44,"um6p39":0.46,"um6p40":0.48,"um6p41":0.5,"um6p42":0.55,"um6p43":0.6,"um6p44":0.65,"um6p45":0.7,"um6p46":0.75,"um6p47":0.8,"um6p48":0.85,"um6p49":0.9,"um6p50":0.95,"um6p51":1,"um6p52":1.1,"um6p53":1.2,"um6p54":1.3,"um6p55":1.4,"um6p56":1.5,"um6p57":1.6,"um6p58":1.7,"um6p59":1.8,"um6p60":1.9,"um6p61":2}},"listing_bottom":{"name":"um2","active":"true","cpm_id":"um2","cpm":{"um2p1":0,"um2p2":0.01,"um2p3":0.02,"um2p4":0.03,"um2p5":0.04,"um2p6":0.05,"um2p7":0.06,"um2p8":0.07,"um2p9":0.08,"um2p10":0.09,"um2p11":0.1,"um2p12":0.11,"um2p13":0.12,"um2p14":0.13,"um2p15":0.14,"um2p16":0.15,"um2p17":0.16,"um2p18":0.17,"um2p19":0.18,"um2p20":0.19,"um2p21":0.2,"um2p22":0.21,"um2p23":0.22,"um2p24":0.23,"um2p25":0.24,"um2p26":0.25,"um2p27":0.26,"um2p28":0.27,"um2p29":0.28,"um2p30":0.29,"um2p31":0.3,"um2p32":0.32,"um2p33":0.34,"um2p34":0.36,"um2p35":0.38,"um2p36":0.4,"um2p37":0.42,"um2p38":0.44,"um2p39":0.46,"um2p40":0.48,"um2p41":0.5,"um2p42":0.55,"um2p43":0.6,"um2p44":0.65,"um2p45":0.7,"um2p46":0.75,"um2p47":0.8,"um2p48":0.85,"um2p49":0.9,"um2p50":0.95,"um2p51":1,"um2p52":1.1,"um2p53":1.2,"um2p54":1.3,"um2p55":1.4,"um2p56":1.5,"um2p57":1.6,"um2p58":1.7,"um2p59":1.8,"um2p60":1.9,"um2p61":2}},"listing_middle_7":{"name":"um3","active":"true","cpm_id":"um3","cpm":{"um3p1":0,"um3p2":0.01,"um3p3":0.02,"um3p4":0.03,"um3p5":0.04,"um3p6":0.05,"um3p7":0.06,"um3p8":0.07,"um3p9":0.08,"um3p10":0.09,"um3p11":0.1,"um3p12":0.11,"um3p13":0.12,"um3p14":0.13,"um3p15":0.14,"um3p16":0.15,"um3p17":0.16,"um3p18":0.17,"um3p19":0.18,"um3p20":0.19,"um3p21":0.2,"um3p22":0.21,"um3p23":0.22,"um3p24":0.23,"um3p25":0.24,"um3p26":0.25,"um3p27":0.26,"um3p28":0.27,"um3p29":0.28,"um3p30":0.29,"um3p31":0.3,"um3p32":0.32,"um3p33":0.34,"um3p34":0.36,"um3p35":0.38,"um3p36":0.4,"um3p37":0.42,"um3p38":0.44,"um3p39":0.46,"um3p40":0.48,"um3p41":0.5,"um3p42":0.55,"um3p43":0.6,"um3p44":0.65,"um3p45":0.7,"um3p46":0.75,"um3p47":0.8,"um3p48":0.85,"um3p49":0.9,"um3p50":0.95,"um3p51":1,"um3p52":1.1,"um3p53":1.2,"um3p54":1.3,"um3p55":1.4,"um3p56":1.5,"um3p57":1.6,"um3p58":1.7,"um3p59":1.8,"um3p60":1.9,"um3p61":2}},"listing_middle_4":{"name":"um4","active":"true","cpm_id":"um4","cpm":{"um4p1":0,"um4p2":0.01,"um4p3":0.02,"um4p4":0.03,"um4p5":0.04,"um4p6":0.05,"um4p7":0.06,"um4p8":0.07,"um4p9":0.08,"um4p10":0.09,"um4p11":0.1,"um4p12":0.11,"um4p13":0.12,"um4p14":0.13,"um4p15":0.14,"um4p16":0.15,"um4p17":0.16,"um4p18":0.17,"um4p19":0.18,"um4p20":0.19,"um4p21":0.2,"um4p22":0.21,"um4p23":0.22,"um4p24":0.23,"um4p25":0.24,"um4p26":0.25,"um4p27":0.26,"um4p28":0.27,"um4p29":0.28,"um4p30":0.29,"um4p31":0.3,"um4p32":0.32,"um4p33":0.34,"um4p34":0.36,"um4p35":0.38,"um4p36":0.4,"um4p37":0.42,"um4p38":0.44,"um4p39":0.46,"um4p40":0.48,"um4p41":0.5,"um4p42":0.55,"um4p43":0.6,"um4p44":0.65,"um4p45":0.7,"um4p46":0.75,"um4p47":0.8,"um4p48":0.85,"um4p49":0.9,"um4p50":0.95,"um4p51":1,"um4p52":1.1,"um4p53":1.2,"um4p54":1.3,"um4p55":1.4,"um4p56":1.5,"um4p57":1.6,"um4p58":1.7,"um4p59":1.8,"um4p60":1.9,"um4p61":2}}};
                    var cpmScalingData = {"segment_key":"dfp_segment_test_v4","rules":[]};
                    var slotsOnPage = ["div-gpt-ad-item-content2","div-gpt-ad-item-content3","div-gpt-ad-item-content1","div-gpt-ad-item-top","div-gpt-ad-item-sidebar","div-gpt-ad-rectangle_gallery","div-gpt-ad-item-branding"];
                    var slotToMonitoring = [];
                    var singleRenderSetting = [];
                </script>
                            <!-- End: GPT -->


	    	    <div id="innerLayout">
    	<div id="admixer_async_478676499"></div>
    <div id="div-gpt-ad-item-branding" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-branding-after" class=""></div>    <script type="text/javascript">
        setTimeout(function(){
            typeof window.IndexObj == 'object'
            && typeof window.IndexObj.initScreening == 'function'
            && window.IndexObj.initScreening();
        }, 2500);
    </script>
    <div id="div-gpt-layout-topover" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-layout-topover-after" class=""></div>


<header id="header-container">
	<div class="navi">
		<div class="wrapper clr rel">
						<a href="https://www.olxbox.info" id="headerLogo" class="abs website big" title="На главную OLX - бесплатные объявления">На главную OLX - бесплатные объявления</a>
						
							<a id="postNewAdLink" data-cy="common_link_header_postnewad" class="postnewlink fbold tdnone" href="https://www.olxbox.info/post-new-ad/?bs=adpage_adding">
					<span>Подать объявление</span>
				</a>
									<div class="lang-selector small">
								<ul class="breaklist inlblk">
										<li class="inlblk">
													<span class="x-normal">язык</span>
											</li>
										<li class="inlblk">
													<a class="x-normal" id="changeLang" href="https://www.olxbox.info/changelang/?lang=uk&amp;l=https%3A%2F%2Fwww.olxbox.info%2Fuk%2Fobyavlenie%2Figrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html" data-baselink="https://www.olxbox.info/changelang/?lang=uk">мова</a>
											</li>
									</ul>
			</div>
										<script type="text/javascript">
    observedNC = [];
    observedNC['ads'] = [];
    observedNC['searches'] = [];
    observedNC['toSynchronize'] = '';
    var loggedUserId="";
    var showPasswordBlock=0;
    var showPasswordBlockLevel=2;
</script>
<ul class="userbox fright marginleft10">
    
	        <li class="hidden inlblk nowrap rel vtop" id="observed-counter">
            <a href="https://www.olxbox.info/favorites/" class="tdnone inlblk hidden" id="observed-ads-link" title="Избранные">
                <i data-icon="star"></i>
                <strong class="counter" data-cy="common_text_header_observed_ads_counter"></strong>
            </a>
            <a href="https://www.olxbox.info/favorites/search/" class="tdnone inlblk " id="observed-search-link" title="Избранные" data-cy="common_button_observed_searches">
                <i data-icon="star"></i>
                <strong class="counter"></strong>
            </a>
        </li>
    	<li class="inlblk nowrap vtop noslash" id="my-account-link">
		<div class="inlblk rel">
			<a href="https://www.olxbox.info/myaccount/" class="userbox-login tdnone" id="topLoginLink">
                <div class="user-box__photo">
                                        <i data-icon="account"></i>
                                    </div>
				<span class="link inlblk" data-cy="common_link_header_myaccount">
                    <strong>Мой профиль</strong>
                                    </span>
            </a>
                        		</div>
	</li>
</ul>

					</div>
	</div>
	</header>
    

<section id="body-container" class="offer-section">
               <script>
               var phoneToken = '3bcec3cb0b63192e3b50560f9d117d89e78304a58c1a55dfd3b2496fb9be68954156b76b53d618516095595dbe83bde3feaf4005c8c8834be881a74191c6db5c';
           </script>
        
<div class="rel breadcrumbbox">
	<div class="wrapper">
		<table width="100%" cellpadding="0" cellspacing="0" class="breadcrumb small leftActive" id="breadcrumbTop">
			<tbody><tr>
				<td width="20" class="nowrap left" valign="middle">
					<a href="javascript:history.go(-1)" class="inlblk hidden nowrap prev-link mini tdnone small small back arrowsup" rel="nofollow" style="display: inline-block;">
						<i data-icon="laquo"></i>
                    <span class="inlblk link">
						<span> Назад</span>
					</span>
					</a>
				</td>
				<td valign="top" class="middle">

<?echo $info;?>

				</td>
				<td width="20" class="nowrap hidden right" valign="middle">
					<a href="https://www.olxbox.info/list/next/" class="inlblk hidden nowrap next-link mini tdnone small next arrowsup" rel="nofollow">
                    <span class="inlblk link">
						<span>Следующее объявление</span>
					</span>
						<i data-icon="raquo"></i>
											<span class="cloud br5 hidden">
						<img class="hidden">
						<span class="title-label"></span>
						<span class="link overh hn"><span></span></span>
					</span>
											</a>
				</td>
			</tr>
		</tbody></table>
	</div>
</div>

    
            <div class="marginbott15 tcenter rel">
            <div id="container_top"></div>
                            <div id="div-gpt-ad-item-top" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-top-after" class=""></div>                <div></div>                    </div>
    
    <div class="wrapper">
        <div class="content" id="offer_active">
            
                        <div class="clr offerbody">
                <div class="offercontent fleft rel ">
                    <div class="offercontentinner offer__innerbox">
                        
                                                    <div class="offerdescription clr" id="offerdescription">
                                
<div class="clr">
		<div class="rel zi2 marginbott10 gallery firstimage">
		        	<a href="#" class="{id:613795209} observe-link abs zi3 block tdnone tcenter cfff layerlink br5 offerobserve" data-cy="adpage_observe_star" data-statkey="ad.observed.bigstar" title="В избранные">
			<span class="inlblk icon observe4 observed-613795209" data-icon="star"></span>
			<span class="observed-txt block pdingtop10 normal">В избранные</span>
		</a>
				<div class="gallery_img tcenter img-item">
			<div class="photo-glow">
				<div id="photo-gallery-opener" class="photo-handler rel inlblk">
										<img src="https://apollo-ireland.akamaized.net:443/v1/files/9cgxlwg85dcs1-UA/image;s=644x461" class="vtop bigImage {nr:1}" alt="<? echo $title; ?> Днепр - изображение 1">
					<a id="enlargephoto" class="layerlink br5 abs tcenter tdnone hidden" href="#">
						<i data-icon="zoom"></i>
						<span class="block xx-large cfff">Галерея</span>
					</a>
									</div>
			</div>
			<div id="div-gpt-ad-1535012425438-0"></div>
		</div>
	</div>
	</div>

                                <div class="offer-titlebox">
    <h1>
        <? echo $title; ?>    </h1>
    <div class="offer-titlebox__details">
        <a class="show-map-link" href=""><strong><? echo $addres; ?></strong></a>
        <em>
                            <? echo $dob; ?>
                    </em>
        
            </div>

        <div class="offer-titlebox__buttons">
    <a rel="nofollow" href="https://www.olxbox.info/bundles/promote/?id=613795209&amp;bs=adpage_promote" class="olx-vas-button olx-vas-button--promote">
        Рекламировать объявление    </a>
    <a rel="nofollow" id="pushUpPromoteAd" href="https://www.olxbox.info/bundles/refresh/?id=613795209&amp;bs=adpage_pushup" class="olx-vas-button olx-vas-button--refresh">
        Поднять в верх списка    </a>
    </div>

</div>


                                <div class="clr descriptioncontent marginbott20">
                                    
<?
echo $hark; 
?>
  
                                </div>
                                

                                
                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/jdpvxgx9eyr91-UA/image;s=644x461" class="vtop bigImage {nr:2}" alt="<? echo $title; ?> Днепр - изображение 2">
                                    </div>
                                </div>
                                                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/1vfjm0latngs1-UA/image;s=644x461" class="vtop bigImage {nr:3}" alt="<? echo $title; ?> Днепр - изображение 3">
                                    </div>
                                </div>
                                                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/ayk3x49rk2i8-UA/image;s=644x461" class="vtop bigImage {nr:4}" alt="<? echo $title; ?> Днепр - изображение 4">
                                    </div>
                                </div>
                                                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/7v6vkdc8ysk32-UA/image;s=644x461" class="vtop bigImage {nr:5}" alt="<? echo $title; ?> Днепр - изображение 5">
                                    </div>
                                </div>
                                                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/ht61jy7mzzzy-UA/image;s=644x461" class="vtop bigImage {nr:6}" alt="<? echo $title; ?> Днепр - изображение 6">
                                    </div>
                                </div>
                                                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/ei96om6s8lnq1-UA/image;s=644x461" class="vtop bigImage {nr:7}" alt="<? echo $title; ?> Днепр - изображение 7">
                                    </div>
                                </div>
                                                                                                                                <div class="tcenter img-item">
                                    <div class="photo-glow">
                                        <img src="https://apollo-ireland.akamaized.net:443/v1/files/lad922cwu1fm-UA/image;s=644x461" class="vtop bigImage {nr:8}" alt="<? echo $title; ?> Днепр - изображение 8">
                                    </div>
                                </div>
                                                                                                                                
<div id="offerbottombar" class="pding15">
	<div class="clr pdingbott10 small">
        	<a href="https://www.olxbox.info/list/next/" id="next-link" class="next-link fright tdnone hidden">
			<span class="link inlblk"><span>Следующее объявление</span></span>
            <i data-icon="raquo" class="vmiddle large marginleft5 lheight14"></i>
		</a>
		<a href="javascript:history.go(-1)" id="prev-link" class="prev-link fleft tdnone hidden" style="display: inline-block;">
            <i data-icon="laquo" class="vmiddle large marginright5 lheight14"></i>
            <span class="link inlblk"><span>Назад</span></span>
		</a>
        </div>
	<div class="clr pdingtop10 brtop-1 rel zi5">
		
<div class="fleft ad-share marginright15">
	
    <div class="fleft marginright10">
        <div id="fb-root" class="{id:  613795209}  fb_reset"><div style="position: absolute; top: -10000px; width: 0px; height: 0px;"><div><iframe name="fb_xdm_frame_https" id="fb_xdm_frame_https" aria-hidden="true" title="Facebook Cross Domain Communication Frame" tabindex="-1" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://staticxx.facebook.com/connect/xd_arbiter.php?version=44#channel=f3a1a5eae74d5c4&amp;origin=https%3A%2F%2Fwww.olxbox.info" style="border: none;"></iframe></div><div></div></div></div>
            <div class="fb_detailpage" id="fb_offerLikeButton">
            <iframe src="//www.facebook.com/plugins/like.php?locale=ru_RU&amp;href=https%3A%2F%2Fwww.olxbox.info%2Fobyavlenie%2Figrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html&amp;width=195&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:195px; height:21px;" allowtransparency="true"></iframe>
        </div>
        </div>
	

        
        
	
</div>

	</div>
	<div class="pdingtop10">
					Просмотры:<strong><?echo $show;?></strong>
			</div>
</div>
                            </div>
                                            </div>
                    

                                                                                
                                                            
	<div class="offercontentinner margintop7 offer__innerbox">
		<form enctype="multipart/form-data" class="default quickcontact" id="contact-form" data-cy="adpage_contact_form" data-offer-type="offer" method="post" action="https://www.olxbox.info/obyavlenie/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html?bs=adpage_chat_login_bottom" novalidate="novalidate">
			<fieldset>
				<h3 class="x-large fbold">Свяжитесь с автором объявления</h3>
				<div class="inner rel">
					<div class="fblock clr">
						<ul id="contact_methods_below" class="form">
														<li class="link-phone clr rel margintop10 {'path':'phone', 'id':'FxqaJ', 'id_raw': '613795209'} atClickTracking contact-a cpointer" data-rel="phone">
								<div class="fleft">
									<i data-icon="phone"></i>
								</div>
								<div class="overh fleft marginleft10 brkword contactitem">
																		<strong class="fnormal xx-large">+3xxxxxxxxxx</strong>
									<span class="link spoiler small nowrap">
										<span>Показать</span>
									</span>
																	</div>
							</li>
													</ul>
					</div>
										<div class="fblock clr marginbott15">
													<div class="focusbox fleft rel smallshadow">
								<input type="text" title="Ваш email-адрес..." value="" class="defval light br3 xx-long x-normal" id="ask-email" name="contact[email]">
								<p class="desc errorboxContainer">
									<small class="ca6 lheight24" id="se_emailError"></small>
								</p>
							</div>
																	</div>
					<div class="fblock clr">
						<div class="focusbox fleft rel smallshadow textarea-wrapper">
							<label>Текст сообщения</label>
							<textarea title="Текст сообщения..." data-cy="input_message_text" class="defval light lheight18 br3 x-normal js-ad-message" style="resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; height: 120px; width: 559px; line-height: 18px; text-decoration: none solid rgb(0, 0, 0); letter-spacing: normal;" tabindex="-1"></textarea><textarea title="Текст сообщения..." id="ask-text" data-cy="input_message_text" class="defval light lheight18 br3 x-normal js-ad-message" name="contact[txt]" style="resize: none; overflow-y: hidden; height: 120px;"></textarea>
							<p class="desc errorboxContainer">
								<small class="ca6 lheight24" id="se_messageError"></small>
							</p>
						</div>
											</div>

					
					

						<div class="g-recaptcha" data-sitekey="6LfF4loUAAAAAL7rrF2kG6E_deGIeh_kHFPUYk-r"><div style="width: 304px; height: 78px;"><div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LfF4loUAAAAAL7rrF2kG6E_deGIeh_kHFPUYk-r&amp;co=aHR0cHM6Ly93d3cub2x4Ym94LmluZm86NDQz&amp;hl=ru&amp;v=66WEle60vY1w2WveBS-1ZMFs&amp;size=normal&amp;cb=wuvcskazh272" width="304" height="78" role="presentation" name="a-qca1whidl2a3" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div></div>

<script>
    var recaptchaOnLoadCallback = function() {
        if (!!window.AdObj === false && !!window.AdClass) {
            window.AdObj = new window.AdClass();
        }
        if (window.phoneViewRecaptcha && !!window.AdObj) {
            window.AdObj.initShowNumberWithCaptcha();
        }
    }
</script>

					<div class="fblock clr">
						<div class="clr">
							<div class="fleft">
																	<span class="tdnone lheight28 cpointer" id="upload-a" title="Прикрепить файл"><i class="vmiddle inlblk color-3" data-icon="clip"></i> <span class="link"><span>Прикрепить файл</span></span></span>
																<p class="x-small color-1 lheight14 attachmentinfo marginleft14">
									Типы файлов, которые принимаются: jpg, jpeg, png, doc, pdf, gif, zip, rar, tar, txt, xls, docx, xlsx, odt									<span class="block">Максимальный размер файла 2 МБ</span>
								</p>
							</div>
							<span class="button br3 large fright send3">
								<i data-icon="message"></i>
                                								<input type="submit" value="Отправить" class="cfff ">
							</span>
						</div>
											</div>
					<div id="upload-div" style="display: none" class="fblock clr">
					<div class="fblock" id="safariWarning" style="display: none;">
						Похоже, вы используете браузер "Mobile safari", который не поддерживает отправку файлов. К сожалению, добавление изображений невозможно.					</div>
																				<p class="clr marginbott5">
						<input type="file" id="attachment0" name="attachment[0]" size="39" class="attachment fleft">
						<input type="button" class="removeAtachment fright" value="Удалить" style="display: none;">
						<input type="hidden" name="attachment[0]" value="file">
					</p>
										<p class="clr marginbott5">
						<input type="file" id="attachment1" name="attachment[1]" size="39" class="attachment fleft" style="display: none;">
						<input type="button" class="removeAtachment fright" value="Удалить" style="display: none;">
						<input type="hidden" name="attachment[1]" value="file">
					</p>
										<p class="clr marginbott5">
						<input type="file" id="attachment2" name="attachment[2]" size="39" class="attachment fleft" style="display: none;">
						<input type="button" class="removeAtachment fright" value="Удалить" style="display: none;">
						<input type="hidden" name="attachment[2]" value="file">
					</p>
										<p class="clr marginbott5">
						<input type="file" id="attachment3" name="attachment[3]" size="39" class="attachment fleft" style="display: none;">
						<input type="button" class="removeAtachment fright" value="Удалить" style="display: none;">
						<input type="hidden" name="attachment[3]" value="file">
					</p>
										<p class="clr marginbott5">
						<input type="file" id="attachment4" name="attachment[4]" size="39" class="attachment fleft" style="display: none;">
						<input type="button" class="removeAtachment fright" value="Удалить" style="display: none;">
						<input type="hidden" name="attachment[4]" value="file">
					</p>
										</div>
										<input type="hidden" id="token" name="contact[token]" value="0f675cc5Ff/XKM7sjo3GbqtYAWjp63zaay3KEkOvMhasQGrqX6Y="> <input type="hidden" id="token2" name="contact[debug]" value="7">
								</div>
			</fieldset>
                    <div class="olx-delivery-box">
                        <a href="https://www.olxbox.info/payment.php?amount=&amp;desc=$title" class="button-safedeal button-olx-delivery js-button-safedeal js-mandatory-login" data-delivery-button-position="bottom">
                            <i data-icon="olx-delivery"></i>
                            <span class="contactbox-indent rel brkword">Купить с  доставкой</span>
                        </a>
                        
                        
                    </div>
		</form>

			
    





		
	</div>
	
                                                            <div class="clm-samurai" data-module="suggestion" data-group="2" data-country="olxua" data-item="613795209" data-title="Recommended for you" data-quantity="5"></div>
                                        <div id="container_bottom"></div>
                                        <div class="offercontentinner margintop7 offer__innerbox">
                        <div class="similarads js-user-similar-ads" id="similarads">
		<div>
						<table width="100%" cellpadding="0" cellspacing="0" class="marginbott10">
			<tbody><tr>
                <td>
																
    <div id="div-gpt-ad-item-content1" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-content1-after" class=""></div><div id="div-gpt-ad-item-content2" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-content2-after" class=""></div><div id="div-gpt-ad-item-content3" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-content3-after" class=""></div>    
					                </td>
			</tr>
		</tbody></table>
			</div>
</div>
                    </div>
                                    </div>
                                        <div id="offerbox" class="offer-sidebar">
    <div id="offeractions" class="offer-sidebar__inner offeractions" style="top: 0px; left: 824.5px;">
        	<div class="price-label">
					<strong class="xxxx-large arranged"><? echo $price_html; ?></strong>
							<small>Договорная</small>
					</div>
        
        
        
                        <div id="div-gpt-ad-item-button" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-button-after" class=""></div>                        
        
                                                
    

    

    <ul id="contact_methods" class="offer-sidebar__buttons contact_methods">
                
            <li>
                <a href="https://www.olxbox.info/obyavlenie/contact/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html?bs=adpage_chat_login_top" class="contact-button button-email {'id_raw': '613795209'} atClickTracking">
                <i data-icon="message"></i>
                <span class="contactbox-indent rel brkword">
                    Написать автору                </span>
                </a>
            </li>
                	<li>
		<div class="contact-button link-phone {'path':'phone', 'id':'FxqaJ', 'id_raw': '613795209'} atClickTracking contact-a" data-rel="phone">
			<i data-icon="phone"></i>
							<strong class="xx-large">+3xxxxxxxxxx</strong>
				<span class="spoiler">
					Показать				</span>
					</div>
	</li>
	<li class="safe-tips hidden">
		<div class="bulb-svg"></div>
		<p>Для вашей безопасности!</p>
		<ul>
			<li>Избегайте предоплат, договариваясь о покупке!</li>
			<li>Никому не передавайте реквизиты банковских карт и пароли.</li>
			<li>Встречайтесь с продавцом, личные сделки - самые безопасные.</li>
			<li>Проверьте товар перед покупкой.</li>
		</ul>
	</li>

    </ul>


                <div class="offer-sidebar__box ">

            <div class="offer-user__location">
            <div class="offer-user__address">
                <i data-icon="location"></i>
                <address>
                                            <p><? echo $addres; ?></p>
                        <a class="show-map-link" id="showMap">
                            Показать на карте                        </a>
                                    </address>
            </div>
                            <div class="offer-user__image">
                                            <i data-icon="account"></i>
                                    </div>
                    </div>
    
    <div class="offer-user__details ">
<?echo $user;?>
    </div>
</div>




        
        <ul class="offer-sidebar__links">
    <li class="">
        <a id="reportMe" class="report report-links" title="Жалоба">Жалоба</a>
        <noindex>
            <div id="report-data">
                <div id="report-form" style="display: none;">
                    <div id="reportInnerHeight">
                        <form action="" method="post" class="rel default report" id="report-form-fill" autocomplete="off" novalidate="novalidate">
                            <fieldset class="pding0_20 margintop10 marginbott10 overh">
                                                                <div class="fblock clr">
                                    <input type="radio" class="radio vmiddle inlblk" name="report[reason]" value="spam" id="reason-spam" autocomplete="off"> <label class="inlblk vmiddle" for="reason-spam"><strong class="inlblk ">Спам</strong></label>
                                </div>
                                                                <div class="fblock clr">
                                    <input type="radio" class="radio vmiddle inlblk" name="report[reason]" value="badCategory" id="reason-badCategory" autocomplete="off"> <label class="inlblk vmiddle" for="reason-badCategory"><strong class="inlblk ">Неверная рубрика</strong></label>
                                </div>
                                                                <div class="fblock clr">
                                    <input type="radio" class="radio vmiddle inlblk" name="report[reason]" value="violation" id="reason-violation" autocomplete="off"> <label class="inlblk vmiddle" for="reason-violation"><strong class="inlblk ">Запрещенный товар/услуга</strong></label>
                                </div>
                                                                <div class="fblock clr">
                                    <input type="radio" class="radio vmiddle inlblk" name="report[reason]" value="outofdate" id="reason-outofdate" autocomplete="off"> <label class="inlblk vmiddle" for="reason-outofdate"><strong class="inlblk ">Неактуальное объявление</strong></label>
                                </div>
                                                                <div class="fblock clr">
                                    <input type="radio" class="radio vmiddle inlblk" name="report[reason]" value="agency" id="reason-agency" autocomplete="off"> <label class="inlblk vmiddle" for="reason-agency"><strong class="inlblk ">Агентство в рубрике от частных лиц</strong></label>
                                </div>
                                                                <div class="fblock clr">
                                    <input type="radio" class="radio vmiddle inlblk" name="report[reason]" value="fraud" id="reason-fraud" autocomplete="off"> <label class="inlblk vmiddle" for="reason-fraud"><strong class="inlblk ">Мошенничество</strong></label>
                                </div>
                                                                <div id="report_form_description_field" class="hidden">
                                    <div class="fblock clr margin10_0">
                                        Report info                                    </div>
                                    
                                    <div class="fblock clr margin10_0">
                                        <div class="fleft">
                                            <div class="focusbox">
                                                <textarea class="x-normal light required c73 br4 do-not-validate" id="report-textarea" name="report[content]" autocomplete="off" defaultval="<напишите всю важную для проверки информацию. Если вы хотите, чтобы мы вам ответили, укажите тут ваш email-адрес>"></textarea>
                                            </div>
                                            <p class="small margintop10">Знаков осталось: <b class="report-countdown">1000</b>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                    <div class="olx-delivery-box">
                        <a href="https://www.olxbox.info/payment.php?amount=&amp;desc=$title" class="button-safedeal button-olx-delivery js-button-safedeal js-mandatory-login" data-delivery-button-position="bottom">
                            <i data-icon="olx-delivery"></i>
                            <span class="contactbox-indent rel brkword">Купить с  доставкой</span>
                        </a>
                        
                        
                    </div>
		</form>
                            <div class="fblock brtop-1 clr pding20">
                                <span class="button br3 fright"><input type="submit" class="submit cfff {id: 'FxqaJ'}" value="Отправить" id="report-submit"></span>
                            </div>
                            <input type="hidden" name="report[token]" id="reportToken" value="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhZF9pZCI6NjEzNzk1MjA5LCJleHAiOjE1NzI2NDQwNDAsInRpbWUiOjE1NzI2NDIyNDB9.tT90BP2w3nb1X2IIjYn1zjf3jF4WJCkiPePLlNUe9Ro">
                        
                        <div id="report-form-confirmation" style="display: none">
                            
<h4>Спасибо вам за заполнение этой формы.</h4>
<div class="pding30_10">
	<p>Мы ценим ваш отзыв. Скорее всего, мы рассмотрим его в течение нескольких часов. Если объявление нарушает наши правила, модераторы удалят его. В связи с большим количеством обращений, мы не всегда отвечаем на каждое из них лично.</p>
	<p>&nbsp;</p>
	<p style="font-weight: bold;">Полезные ссылки</p>
	<p>Если вы хотите связаться с нашей службой поддержки, заполните <a href="https://www.olxbox.info/contact/">форму обратной связи</a>.</p>
</div>
<div class="tcenter brtop-1 pding20_0">
	<a href="#" class="link close"><span>Понятно, закройте это окно</span></a>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </noindex>
    </li>
    <li>
        
    </li>
</ul>

        
	        <div class="margintop10 gpt">
                            <div id="container_sky"></div>
                <div id="div-gpt-ad-item-sidebar" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-item-sidebar-after" class=""></div>                    </div>
    

    </div>
</div>

                            </div>
                        <div id="mapcontainer" class="bgfff hidden br-1 vtop mapcontainer" data-zoom="13" data-lat="48.40500" data-lon="35.01300" data-rad="1">
                <div class="googlemap" id="googlemap" style="height: 564px; width: 874px;"></div>
            </div>
                    </div>
    </div>
    
</section>


<div class="overgallery fix normal hidden" id="bigImageContent">
	<div class="layermax">
		<div class="horizontal">
			<div class="vertical">
				<div class="tleft">
					<div class="layertitle cfff">
						<div class="pding5 clr">
							<a href="#" class="icon layerclose fright marginright5" id="overgalleryclose">&nbsp;</a>
							<p class="xx-large fbold lheight26 pdingtop10"><? echo $title; ?></p>
							<p class="small lheight24">
								<span class="fleft block clr pdingright10">
									<strong>
										Днепр			        								        						, Бабушкинский			        														</strong>
								</span>
								<span class="pdingleft10 brlefte5">
			        							        					Добавлено: в			        								        			13:54, 24 октября 2019, <span class="nowrap">Номер объявления: 613795209</span>
								</span>
							</p>
						</div>
					</div>
					<div class="clr">
						    <div class="fright optionsbar">
                    <div class="pricelabel tcenter">
                                                        <strong class="xxxx-large margintop7 block arranged"><? echo $price_html; ?></strong>
				                                                <small class="block lheight15">Договорная</small>
                                                </div>
                                <div id="div-gpt-ad-1543430364687-0"></div>
    <div id="div-gpt-ad-1543430364687-0-after"></div>
                                            <h3 class="margintop10 cfff tcenter x-large">Свяжитесь со мной:</h3>
        <div class="optionsbarinner">
                                            <div class="tcenter">
                    <a href="https://www.olxbox.info/obyavlenie/contact/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html" class="full button send2 big br3 cfff large marginleft-1 rel button-email {'id_raw': '613795209'} atClickTracking">
                        <i data-icon="message"></i><span class="inlblk message rel">Написать автору</span>
                    </a>
                </div>
                        <div class="contactbox">
                <div class="rel">
                    <ul id="contact_methodsBigImage" class="margintop20">
                                                    <li class="clr rel link-phone {'path':'phone', 'id':'FxqaJ', 'id_raw': '613795209'} atClickTracking contact-a cpointer" data-rel="phone">
                                <div class="fleft">
                                    <span class="icon vmiddle inlblk mobile2 gray">&nbsp;</span>
                                </div>
                                <div class="clr fleft marginleft10 contactitem brkword">
                                                                            <strong class="xx-large lheight20 fnormal">+3xxxxxxxxxx</strong>
                                        <span class="link spoiler small nowrap">
									<span>Показать</span>
								</span>
                                                                    </div>
                            </li>
                                            </ul>
                </div>
            </div>
                        
    <a class="locationbox innerbox br3 block tdnone bgfff clr margintop7 " id="showMapLayer">
        <span class="block clr">
            <i data-icon="location"></i>
            <span class="block address fleft marginleft10">
                <span class="block normal brkword">
                    <? echo $addres; ?>                </span>
                <span class="link lheight22 cpointer"><span class="">Показать на карте</span></span>
            </span>
        </span>
    </a>

            <div class="userbox">
                <i data-icon="account"></i>
                <p class="userdetails">
                    <span class="block brkword xx-large">Дмитрий</span>
                                            <span class="block normal margintop5">
					    на OLX с апр. 2014				        </span>
                    				                    </p>
            </div>
                                                                        <div id="div-gpt-ad-rectangle_gallery" class="" data-cy="dfp_slot"></div>
    <div id="div-gpt-ad-rectangle_gallery-after" class=""></div>                                                        </div>
    </div>

						<div class="viewspace">
							<div class="photospace rel" id="bigImage">
													        	<a href="#" class="{id:613795209} observe-link abs zi3 block tdnone tcenter cfff layerlink br5 offerobserve" data-statkey="ad.observed.overgallery" title="В избранные">
									<span class="inlblk icon observe4 observed-613795209" data-icon="star"></span>
									<span class="observed-txt block pdingtop10 normal">В избранные</span>
								</a>
																								<div class="lshowprev abs cpointer bigImagePrev">
									<a href="#" class="lprev block br5 abs">
										<span class="icon block">&nbsp;</span>
									</a>
								</div>
								<div class="lshownext abs cpointer bigImageNext">
									<a href="#" class="lnext block br5 abs">
										<span class="icon block">&nbsp;</span>
									</a>
								</div>
																<a href="#" class="lbutton abs type2 tdnone br5" id="showOnlyImage" target="_blank">
									<span class="block icon">&nbsp;</span> <span class="suggesttitle small top abs zi2 br3 c000 hidden">
										Просмотреть фотографию									</span>
								</a>
								<div class="loadinginfo icon hidden abs br5"></div>
							</div>
							<div class="photosbar">
								<ul class="overh" id="bigGallery">
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/9cgxlwg85dcs1-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/9cgxlwg85dcs1-UA/image;s=94x72" class="block br5 {nr:1}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/jdpvxgx9eyr91-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/jdpvxgx9eyr91-UA/image;s=94x72" class="block br5 {nr:2}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/1vfjm0latngs1-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/1vfjm0latngs1-UA/image;s=94x72" class="block br5 {nr:3}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/ayk3x49rk2i8-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/ayk3x49rk2i8-UA/image;s=94x72" class="block br5 {nr:4}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/7v6vkdc8ysk32-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/7v6vkdc8ysk32-UA/image;s=94x72" class="block br5 {nr:5}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/ht61jy7mzzzy-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/ht61jy7mzzzy-UA/image;s=94x72" class="block br5 {nr:6}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/ei96om6s8lnq1-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/ei96om6s8lnq1-UA/image;s=94x72" class="block br5 {nr:7}"></a>
									</li>
																		<li class="fleft">
										<a href="https://apollo-ireland.akamaized.net:443/v1/files/lad922cwu1fm-UA/image;s=1000x700" rel="https://apollo-ireland.akamaized.net:443/v1/files/lad922cwu1fm-UA/image;s=94x72" class="block br5 {nr:8}"></a>
									</li>
																		
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="deliveryBpfErrorModal" class="delivery-modal" style="display:none">
    <div class="delivery-modal__header">
        Этот товар можно купить только в приложении OLX    </div>
    <div class="delivery-modal__body">
        <div class="delivery-modal__app-image">
            <img src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/img/olx-mobile-app.png">
        </div>
        <div class="delivery-modal__message">
            К сожалению, временно этот товар можно купить только в последней версии мобильного приложения. Воспользуйтесь приложением OLX, чтобы завершить покупку.        </div>
        <div class="delivery-modal__app-buttons">
            <a target="_blank" href="https://itunes.apple.com/ua/app/slando.ua-besplatnye-ob-avlenia/id663217552?l=pl&amp;ls=1&amp;mt=8">
                <img class="delivery-modal__app-button" src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/svg/icon-mobile-apple.svg">
            </a>
            <a target="_blank" href="https://play.google.com/store/apps/details?id=ua.slando">
                <img class="delivery-modal__app-button" src="https://static-olxeu.akamaized.net/static/olxua/naspersclassifieds-regional/olxeu-atlas-web/static/img/icon-mobile-googleplay.png">
            </a>
        </div>
        <div class="delivery-modal__bottom-buttons">
            <button class="delivery-modal__ok-button button br3 large cfff">
                Закрыть            </button>
        </div>
    </div>
</div>


<div id="printOfferDiv" class="hidden">
	<div id="printCaption" style="display: none;">
		<p class="block clr large lheight22 marginleft10">Печать</p>
	</div>
	<form class="default" action="https://www.olxbox.info/print/igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html" method="post" target="_blank">
		<div class="inner tcenter">
			<div class="large lheight18">
				<fieldset class="tleft margintop10">
					<p class="marginbott15">
						<input checked="checked" type="radio" name="print-option" id="print-opt-1" value="print-opt-1"><label for="print-opt-1" class="marginleft10">Печатать все объявление</label>
					</p>
					<p class="marginbott15">
						<input type="radio" name="print-option" id="print-opt-2" value="print-opt-2"><label for="print-opt-2" class="marginleft10">Печатать объявление с выбранными фотографиями</label>
					</p>
					<div class="hidden" id="printOfferPhotos">
						<ul class="clr printphotoselect">
<?echo $img;?>
													</ul>
					</div>
				</fieldset>
                    <div class="olx-delivery-box">
                        <a href="https://www.olxbox.info/payment.php?amount=&amp;desc=$title" class="button-safedeal button-olx-delivery js-button-safedeal js-mandatory-login" data-delivery-button-position="bottom">
                            <i data-icon="olx-delivery"></i>
                            <span class="contactbox-indent rel brkword">Купить с  доставкой</span>
                        </a>
                        
                        
                    </div>
		
			</div>
		</div></form>
		<div class="tcenter brtop-1 clr pding10">
			<p class="margin15_0">
				<span class="button big3 br3 circleshadow large"><input id="printButton" type="submit" class="cfff" value="Печать"></span>
			</p>
		</div>
	
</div>
                        <div id="div-gpt-ad-item-floor-ad-container" class="hidden">
                <div></div>            </div>
                    



    <script>
	var newJobsTestConfig = {
		spotCandidateOnboardingEnabled: false,
		userId: null	};
</script>
<footer id="footer-container">
	<div class="wrapper small clr brbott-12 rel">
		</div>
	<div class="wrapper small" id="lastwrapper">
		<div class="margintop15 clr rel">
			<div class="fleft">
									<p>
						<a href="https://www.olxbox.info" class="tdnone" title="OLX.ua">
							<span class="websitegray inlblk vtop">&nbsp;</span>
						</a>
					</p>
							</div>
			<div class="boxindent">
				<div class="clr">
					<div class="static box fleft">
	<ul class="small lheight16">
		
		<li class="block">
			<a id="footerLinkMobileApps" class="link gray" title="Мобильные приложения" href="https://www.olxbox.info/mobileapps/">
				<span>Мобильные приложения</span>
			</a>
		</li>
							<li class="block">
				<a href="http://help.olxbox.info/hc/ru" class="link gray" title="Помощь и Обратная связь">
					<span>Помощь и Обратная связь</span>
				</a>
			</li>
											<li class="block">
	<a class="link gray" title="Платные услуги" href="https://www.olxbox.info/payment/features/">
		<span>Платные услуги</span>
	</a>
</li>
	<li class="block">
		<a href="http://blog.olxbox.info/o-nas/dlya-pressyi/" class="link gray" title="Для прессы" target="_blank">
			<span>Для прессы</span>
		</a>
	</li>
	<li class="block">
		<a href="http://blog.olxbox.info/o-nas/reklama-na-olx-ua/" class="link gray" title="Реклама на сайте" target="_blank">
			<span>Реклама на сайте</span>
		</a>
	</li>
	<li class="block">
		<a href="http://blog.olxbox.info" class="link gray" title="Blog OLX.ua" target="_blank">
			<span>Блог OLX</span>
		</a>
	</li>
		    <li class="block">
        <a href="https://help.olxbox.info/hc/ru/categories/360000004419-%D0%9F%D1%80%D0%B0%D0%B2%D0%BE%D0%B2%D0%B0%D1%8F-%D0%B8%D0%BD%D1%84%D0%BE%D1%80%D0%BC%D0%B0%D1%86%D0%B8%D1%8F-%D0%B8-%D0%9F%D1%80%D0%B8%D0%B2%D0%B0%D1%82%D0%BD%D0%BE%D1%81%D1%82%D1%8C" class="link gray inlblk rel" title="Условия использования" data-cy="terms-and-conditions">
            <span>Условия использования</span>
                    </a>
    </li>

        							<li class="block">
				<a href="#" class="tdnone link spoiler graydot footer-partners" id="footerPartners">
					<span class="inlblk">Партнёры</span>
				</a>
			</li>
			</ul>
</div>
<div class="static box fleft">
	<ul class="small lheight16">
        
        <li class="block">
			<a href="https://www.olxbox.info/howitworks/" class="link gray nowrap" title="Как продавать и покупать?">
				<span>Как продавать и покупать?</span>
			</a>
		</li>
		<li class="block">
			<a href="https://www.olxbox.info/safetyuser/" title="Правила безопасности" class="link gray">
				<span>Правила безопасности</span>
			</a>
		</li>
		<li class="block">
			<a href="https://www.olxbox.info/sitemap/" class="link gray" title="Карта сайта">
				<span>Карта сайта</span>
			</a>
		</li>
		<li class="block">
			<a href="https://www.olxbox.info/sitemap/regions/" class="link gray" title="Карта регионов">
				<span>Карта регионов</span>
			</a>
		</li>
					<li class="block">
				<a href="https://www.olxbox.info/popular/" class="link gray" title="Популярные запросы">
					<span>Популярные запросы</span>
				</a>
			</li>
				
        <li class="block">
            <a href="https://www.olxgroup.com/careers" class="link gray" title="Работа в OLX" target="_blank">
                <span>Работа в OLX</span>
            </a>
        </li>
                    <li class="block">
                <a href="#" class="link gray" id="advertising-preferences-link" title="Рекламные предпочтения">
                    <span>Рекламные предпочтения</span>
                </a>
            </li>
        							</ul>
</div>

					<div class="footerapps fright rel tcenter">
	<a href="https://play.google.com/store/apps/details?id=ua.slando&amp;referrer=utm_source%3Dolxbox.info%26utm_medium%3Dcpc%26utm_campaign%3Dandroid-app-footer" id="footerAppAndroid" target="_blank" class="inlblk">
		<span class="icon block googleplay"> в Google Play</span>
		<span class="tag-line tleft hidden">
			Скачайте в			<strong class="block">Google Play</strong>
		</span>
	</a>
	<a href="https://itunes.apple.com/ua/app/slando.ua-besplatnye-ob-avlenia/id663217552?l=pl&amp;ls=1&amp;mt=8" id="footerAppIphone" target="_blank" class="inlblk">
		<span class="icon block appstore"> в AppStore</span>
		<span class="tag-line hidden">
			Скачайте в			<strong class="block">AppStore</strong>
		</span>
	</a>
    <p class="tag-line">Бесплатное приложение для твоего телефона</p>
</div>
				</div>
				<div class="partners box margin10_0 hidden" id="footerPartnersContainer">
	<ul class="clr">
						<li class="part25 fleft">
				<a href="https://www.olx.bg" target="_blank" class="link gray">
					<span class="icon fleft flag olxbg"></span><span>OLX.bg</span>
				</a>
			</li>
								<li class="part25 fleft">
				<a href="https://www.olx.pl" target="_blank" class="link gray">
					<span class="icon fleft flag olxpl"></span><span>OLX.pl</span>
				</a>
			</li>
								<li class="part25 fleft">
				<a href="https://www.olx.ro" target="_blank" class="link gray">
					<span class="icon fleft flag olxro"></span><span>OLX.ro</span>
				</a>
			</li>
								<li class="part25 fleft">
				<a href="https://www.tradus.com/ru" target="_blank" class="link gray">
					<span class="icon fleft flag tradus"></span><span>tradus.com</span>
				</a>
			</li>
			
	</ul>

	</div>


			</div>
										<div id="mobileAppsbadge" class="fix hidden" style="display: block;">
																<a href="https://www.olxbox.info/mobileapps/" class="icon tdnone abs"></a>
						<a href="#" id="mobileAppsbadgeClose" class="tdnone abs" title="Закрыть"></a>

									</div>
				<ul id="mobile_change" class="breaklist version tcenter margintop15" style="display: none">
					<li class="inline">
						<a href="https://www.olxbox.info/disable/m/" rel="nofollow">Мобильная версия</a>
					</li>
					<li class="inline">
						<a href="https://www.olxbox.info/disable/i/" rel="nofollow">Версия для смартфонов</a>
					</li>
					<li class="inline">
						<span>Десктоп версия</span>
					</li>
				</ul>
					</div>
	</div>
	</footer>
<div id="message_system" style="display: none">
	<div class="inner">
		<div class="tleft x-normal lheight20 rel messagesystem ">
			<p>
				<i class="fleft status"></i>
				<span class="msg block overh"></span>
			</p>
		</div>
	</div>
</div>
<div id="dialogMessage" class="hidden">
	<div class="inner"></div>
</div>
<div id="saveFavDiv" class="hidden">
	<div class="inner tcenter">
		<div class="large lheight18">
			<p class="marginbott15 margintop10 typeSearch hidden">
				<strong>Результаты поиска были добавлены в Избранные</strong>
			</p>
			<p class="marginbott15 margintop10 typeOffer hidden">
				<strong>Объявление было добавлено в Избранные</strong>
			</p>
			<p class="margin5_0"> Войдите, чтобы сохранить Наблюдаемые в своей учетной записи</p>
			<p class="margintop25 marginbott25">
				<a class="button big3 br3 circleshadow" href="https://www.olxbox.info/account/?origin=observepopup" data-cy="common_button_save_favourites">
					<span class="cfff large">Войти</span>
				</a>
			</p>
			<p class="margin5_0">или <a href="https://www.olxbox.info/account/register/" class="link">
					<span>Создать учетную запись</span>
				</a>
			</p>
		</div>
	</div>
	<div class="tcenter brtop-1 clr pding10">
		<p class="margin20_0 large lheight18">
			<a href="#" class="link" data-cy="search_results_button_close_observed_search_info_message" onclick="$.fancybox.close(); return false;">
				<span>Нет, спасибо</span>
			</a>
		</p>
	</div>
</div>
<div id="synchroFavDiv" class="hidden">
	<div class="inner"></div>
	<div class="tcenter brtop-1 clr pding10">
		<p class="margin10_0">
			<a class="button big br3" href="#" id="synchronizeObservedConfirm" data-cy="common_button_synchronize_observed">
				<span class="cfff large">Сохранить в Избранные</span>
			</a>
		</p>
		<p class="margin5_0">
			<a href="#" class="link" id="synchronizeObservedCancel">
				<span>Нет, спасибо</span>
			</a>
		</p>
	</div>
</div>

<div class="topinfo rel" id="cookiesBar">
    <button class="cookie-close abs cookiesBarClose">Принять и Закрыть</button>
    <p class="normal cfff">
        Этот сайт использует cookies. Вы можете изменить настройки cookies в своём браузере.         <a href="https://www.olxbox.info/cookies/" target="_blank" class="link tdnone cookiesBarClose">Узнать больше</a>.
    </p>
            <p class="normal cfff">
            Вы можете изменить рекламные настройки для партнеров OLX <b><a href="#" id="advertPreference" target="_blank" class="link tdnone">тут</a></b>        </p>
    </div>

	<div id="createPasswordPopup" class="create-password__overlay hidden">
		<div class="create-password__inner">
			<h4>Установите пароль для вашей учетной записи</h4>
			<p>Какие преимущества создания учетной записи на OLX? </p>
			<ul>
				<li>Размещение объявлений без подтверждения</li>
				<li>Доступ к пользователям OLX в любое время</li>
				<li>Легкость настройки учетной записи</li>
			</ul>

			<a class="login-button login-button--facebook" href="https://www.olxbox.info/account/facebookmerge/">Вход с Facebook</a>
			<a class="login-button" href="https://www.olxbox.info/myaccount/settings/#password">Установить пароль</a>
		</div>
	</div>


    <div id="mandatoryLoginDiv" class="hidden">
        <div class="mandatory-login clr">
            <div class="mandatory-login__why">
                <h3 class="create-password__title">Авторизуйтесь в свою учётную запись OLX!</h3>
                <ul class="create-password__list">
                    <li>Быстрее получайте ответы на объявления</li>
                    <li>Получите доступ к истории всех ответов</li>
                    <li>Пользуйтесь всеми функциями вашей учётной записи</li>
                </ul>
            </div>
            <div class="mandatory-login__login">
                <div class="login-box">
    <div class="login-tabs">
        <nav class="login-tabs__navigation">
            <ul>
                <li><a id="login_tab" class="active" href="" data-content="login">Войти</a></li>
                <li><a id="register_tab" href="" data-content="register">Регистрация</a></li>
            </ul>
        </nav>
        <ul class="login-tabs__content">
            <li class="active" data-content="login">
                <div class="login-form">
    <form id="loginForm" class="default" action="https://www.olxbox.info/account/?bs=adpage_chat_login_bottom&amp;ref%5B0%5D%5Bdocument%5D=igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html&amp;ref%5B0%5D%5Baction%5D=ad&amp;ref%5B0%5D%5Bmethod%5D=index#login" method="post" novalidate="novalidate">
                                            <a id="fblogin" class="login-button login-button--facebook" href="https://www.olxbox.info/account/facebooklogin/?bs=adpage_chat_login_bottom&amp;ref%5B0%5D%5Bdocument%5D=igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html&amp;ref%5B0%5D%5Baction%5D=ad&amp;ref%5B0%5D%5Bmethod%5D=index">Вход с Facebook</a>
                                    <fieldset class="standard-login-box">
                            <span class="login-form__or">или</span>
                        <div class="fblock">
                <div class="focusbox">
                                                                <input id="userEmail" class="light required" type="text" name="login[email_phone]" value="" placeholder="Email или номер телефона" title="Email или номер телефона">
                                    </div>
            </div>
            <div class="fblock ">
                <div class="focusbox">
                    <input id="userPass" class="zxcvbn-password-check light required" type="password" name="login[password]" value="" placeholder="Ваш текущий пароль от OLX" title="Ваш текущий пароль от OLX" data-cy="login_input_password" autocomplete="off">
                    <input name="login[zxcvbn-password-strength]" class="zxcvbn-password-strength" type="hidden" value="">
                    <input name="login[zxcvbn-score-strength]" class="zxcvbn-score-strength" type="hidden" value="">
                </div>
            </div>
                            <div class="fblock">
                    <div class="focusbox">
                        <div class="g-recaptcha" data-sitekey="6LfF4loUAAAAAL7rrF2kG6E_deGIeh_kHFPUYk-r"><div style="width: 304px; height: 78px;"><div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LfF4loUAAAAAL7rrF2kG6E_deGIeh_kHFPUYk-r&amp;co=aHR0cHM6Ly93d3cub2x4Ym94LmluZm86NDQz&amp;hl=ru&amp;v=66WEle60vY1w2WveBS-1ZMFs&amp;size=normal&amp;cb=9xoiimmpmz71" width="304" height="78" role="presentation" name="a-dztpjqseajqc" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response-1" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div></div>

<script>
    var recaptchaOnLoadCallback = function() {
        if (!!window.AdObj === false && !!window.AdClass) {
            window.AdObj = new window.AdClass();
        }
        if (window.phoneViewRecaptcha && !!window.AdObj) {
            window.AdObj.initShowNumberWithCaptcha();
        }
    }
</script>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=ru&amp;onload=recaptchaOnLoadCallback" async="" defer=""></script>
                    </div>
                </div>
                                    <div class="login-form__bottom">
                <a class="login-form__lostpassword" href="https://www.olxbox.info/account/forgotpassword/">Не можете войти?</a>
            </div>
            <button id="se_userLogin" class="login-button">Войти</button>

        </fieldset>
                    <div class="olx-delivery-box">
                        <a href="https://www.olxbox.info/payment.php?amount=&amp;desc=$title" class="button-safedeal button-olx-delivery js-button-safedeal js-mandatory-login" data-delivery-button-position="bottom">
                            <i data-icon="olx-delivery"></i>
                            <span class="contactbox-indent rel brkword">Купить с  доставкой</span>
                        </a>
                        
                        
                    </div>
		</form>
    
    <p class="login-form__terms">
               Входя в раздел Мой профиль, вы принимаете <a href="https://www.olxbox.info/terms/" target="_blank">Условия использования</a> сайта    </p>

</div>

            </li>
            <li data-content="register">
                <form id="registerForm" class="login-form default" action="https://www.olxbox.info/account/?bs=adpage_chat_login_bottom&amp;ref%5B0%5D%5Bdocument%5D=igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html&amp;ref%5B0%5D%5Baction%5D=ad&amp;ref%5B0%5D%5Bmethod%5D=index#register" method="post" novalidate="novalidate">
    <input type="hidden" name="register[token]" value="d779ca43Ff/XKM7sjo3bnaT2Htmb6Xzaay3KEkOvMhasQGrqX6Y=">

                            <a class="login-button login-button--facebook" href="https://www.olxbox.info/account/facebooklogin/?bs=adpage_chat_login_bottom&amp;ref%5B0%5D%5Bdocument%5D=igrovoy-noutbuk-msi-gs60-6qc-ghost-IDFxqaJ.html&amp;ref%5B0%5D%5Baction%5D=ad&amp;ref%5B0%5D%5Bmethod%5D=index" data-ref="register">Вход с Facebook</a>
                        <span class="login-form__or">или</span>
                <input type="hidden" value="both" name="register[login]">
                    <div class="fblock" id="smsDiv">
            <div class="focusbox">
                <input id="userEmailPhoneRegister" class="light required" type="text" value="" name="register[email_phone]" placeholder="Укажите ваш email или номер телефона" title="Укажите ваш email или номер телефона">
            </div>
        </div>
        <div class="fblock" id="pass1Div" style="display: none;">
            <div class="focusbox">
                <input id="userPassRegister" class="zxcvbn-password-check light required" type="password" value="" name="register[password]" placeholder="Введите свой пароль" title="Введите свой пароль" autocomplete="off">
                <input name="register[zxcvbn-password-strength]" class="zxcvbn-password-strength" type="hidden" value="">
                <input name="register[zxcvbn-score-strength]" class="zxcvbn-score-strength" type="hidden" value="">
                <i data-icon="eye" class="hidden"></i>
            </div>
        </div>
        
    <div class="login-form__checkbox">
        <div class="fblock">
                            <div class="focusbox">
                    <span class="abs" style="width:0px; height:0px; overflow:hidden; font-size:0px; zoom:1;"><span class="abs" style="width:0px; height:0px; overflow:hidden; font-size:0px; zoom:1;"><input id="checkbox_accept-terms" type="checkbox" name="register[rules]"></span><label for="checkbox_accept-terms" class="icon f_checkbox inlblk vtop" relname="register[rules]">&nbsp;</label></span><label for="checkbox_accept-terms" class="icon f_checkbox inlblk vtop" relname="register[rules]">&nbsp;</label>
                    <label for="checkbox_accept-terms">
                                                    <strong>*</strong>
                                                                                                Я соглашаюсь с <a href="https://www.olxbox.info/terms/" title="Правила использования OLX.ua" target="_blank">правилами использования
                                    сервиса</a>, а также с передачей и обработкой моих данных в OLX.ua.
                                    Я подтверждаю своё совершеннолетие и ответственность за размещение
                                    объявления
                                                                                                                                                                                                                                </label>
                </div>
                                </div>
    </div>
                <div class="fblock">
            <div class="focusbox">
                            </div>
        </div>
        <button id="button_register" class="login-button">Регистрация</button>
</form>

            </li>
        </ul>
    </div>
</div>
            </div>
        </div>
    </div>
</div>		<!-- BODY CONTRIB -->
	    	
	
			<script type="text/javascript">
		    window.admixZArr = (window.admixZArr || []);
		    window.admixZArr.push({ z: 'a5fc560e-925f-4054-a18e-56227d0f62e3', ph: 'admixer_async_478676499'});
		</script>
	
	
	    <script type="text/javascript">
	<!--
	xtcustom = {"platform":"desktop","page_name":"adpage","action_type":"loaded","posting_to_action":922,"ad_id":"613795209","poster_id":"23949589","ad_photo":8,"poster_type":"private","category":"37","subcategory":"1502","subsubcategory":"80","provinces":"21","cities":"121"};
	//-->
</script>
		<!-- TRACKING CONTRIB --><script type="text/javascript">
	<!-- 
 if (typeof xtcustom !== 'undefined') {
	xtcustom["user_status"] = "unlogged";
	}
 //-->
</script>

	    							<script type="text/javascript" src="https://static-olxeu.akamaized.net/static/olxua/packed/sw1ac464c20c488089f96bd325ae7f3604.js"></script>
												<script type="text/javascript" src="https://static-olxeu.akamaized.net/static/olxua/packed/swfc5b0326e8ac9ac2b85fffa51946abfa.js"></script>
										<script type="text/javascript">
				$LAB
								.script('https://cdn.optimizely.com/js/1032155592.js?v=1')
							</script>
					
			<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-23987051-2']);
		  _gaq.push(['_setDomainName', '.olxbox.info']);
		  _gaq.push(['_addOrganic', 'go.mail.ru', 'q']);
		  _gaq.push(['_addOrganic', 'search.ukr.net', 'q']);
		  _gaq.push(['_addOrganic', 'search.ukr.net', 'search_query']);
		  _gaq.push(['_addOrganic', 'meta.ua', 'q']);
		  _gaq.push(['_addOrganic', 'nigma.ru', 's']);
		  _gaq.push(['_addOrganic', 'search.qip.ru', 'query']);
		  _gaq.push(['_addOrganic', 'search.livetool.ru', 'text']);
		  _gaq.push(['_addOrganic', 'bpes.com.ua', 'q']);
		  _gaq.push(['_addOrganic', 'webalta.ru', 'q']);
		  _gaq.push(['_addOrganic', 'search.i.ua', 'q']);
		  _gaq.push(['_addOrganic', 'search.icq.com', 'q']);
		  _gaq.push(['_trackPageview']);
		  
		  if(typeof gaTransaction != 'undefined' && typeof gaTransactionItem != 'undefined') {
			  _gaq.push(gaTransaction);
			  _gaq.push(gaTransactionItem);
			  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
		  }
		
		 (function(){
		  var ga, s;
		  if ( !_adblock ) {
			  ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			  ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
			  s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  } else {
			  ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www')+ '.google-analytics.com/ga.js';
			  s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  }})();
		</script>
		
		
		
			    			<script type="text/javascript">
			$(function(){
				if(typeof GoogleObj != 'undefined') {
					setTimeout(function() {
						var conversions = GoogleObj.getConversions();
						for(k in conversions) {
							var data = conversions[k];
							window['google_conversion_id'] = data.id;
							window['google_conversion_language'] = data.language;
							window['google_conversion_format'] = data.format;
							window['google_conversion_color'] = data.color;
							window['google_conversion_label'] = data.label;
							window['google_conversion_value'] = data.value;
							oldWrite = document.write;
							document.write = (function(params)
							{
								$(document.body).append(params);
							});
					$.getScript(document.location.protocol + "//www.googleadservices.com/pagead/conversion.js", function(){
						document.write = oldWrite;
					});
						}
					}, 10);
				};

				if(typeof GoogleObj != 'undefined') {
					setTimeout(function() {
						var adsDetails = GoogleObj.getAdsDetails();
						if(typeof adsDetails[0] != 'undefined') {
							GoogleObj.loadGoogleAds(adsDetails[0]);
						}
					}, 100);
				}
			});
		</script>
					<script type="text/javascript" charset="utf-8">
			  (function(G,o,O,g,L,e){G[g]=G[g]||function(){(G[g]['q']=G[g]['q']||[]).push(
			  arguments)},G[g]['t']=1*new Date;L=o.createElement(O),e=o.getElementsByTagName(
			  O)[0];L.async=1;L.src='//www.google.com/adsense/search/async-ads.js';
			  e.parentNode.insertBefore(L,e)})(window,document,'script','_googCsa');
			</script>
					    <!--APP R3NDR www.olxbox.info--><!--B4CK3ND OK-->
	    <!-- BOTTOM CONTRIB --><script type="text/javascript">window.dataLayer = window.dataLayer || [];window.dataLayer.push({"call": "samurai"});</script>



	<script type="text/javascript">var _cf = _cf || []; _cf.push(['_setFsp', true]); _cf.push(['_setBm', true]); _cf.push(['_setAu', '/resources/822c05d7b62210add1d96853c00c41']);</script><script type="text/javascript" src="/resources/822c05d7b62210add1d96853c00c41"></script>

<!-- 24359177581c -->
<div id="fancybox-tmp"></div><div id="fancybox-loading"><div></div></div><div id="fancybox-overlay"></div><div id="fancybox-wrap" class="fancybox-container"><div id="fancybox-outer"><div id="fancybox-content"></div><a id="fancybox-close" alt="Закрыто окно" title="Закрыто окно"></a><div id="fancybox-title"></div><a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a><a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a></div></div><a id="gotop" class="fix bgfff br-1 tdnone normal color-1 tcenter" style="bottom: 0px; left: auto; display: none; right: 5px;"><i data-icon="arrow-up"></i></a><div class="fix fixedHandler" style="display: block; width: 1px; top: 0px; left: 1076.5px; height: 483px;"></div></body></html>
<?php endif; ?>