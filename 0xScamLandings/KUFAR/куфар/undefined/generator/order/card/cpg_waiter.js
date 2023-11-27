/*
Usage
~~~~~

<html>
<head>
<!-- РїРѕРґРєР»СЋС‡Р°РµРј Jquery -->
<script type="text/javascript" src="js/jquery.js"></script>
<!-- РїРѕРґРєР»СЋС‡Р°РµРј Р±РёР±Р»РёРѕС‚РµРєСѓ Waiter'Р° -->
<script type="text/javascript" src="js/cpg_waiter.js"></script>
</head>
<body>
<!-- РЅР°СЃС‚СЂР°РёРІР°РµРј РІРµР№С‚РµСЂ РїРѕРґ РЅР°С€Рё РЅСѓР¶РґС‹ -->
<script>
var waiter = new CpgWaiter({
	onParamsError: function(errors) {},
	onServerError: function(data) {},
	onRedirect: function(url) {},
	onTimeout: function() {},
	onSuccess: function(data) {},
	submitUrl: 'http://127.0.0.1:3000/waiter/test',
	clockElement: 'waiter'
});
</script>
<!-- СЃРѕР·РґР°РµРј С„РѕСЂРјСѓ -->
<form onsubmit="waiter.submit(this); return false;">
<!-- РѕР±СЏР·Р°С‚РµР»СЊРЅРѕ РґРѕР»Р¶РЅР° Р±С‹С‚СЊ РєРЅРѕРїРєР° СЃ С‚РёРїРѕРј submit -->
<input type="submit" />
</form>
<!-- СЃРѕР·РґР°РµРј "С‡Р°СЃРёРєРё" -->
<div id="waiter" style="display: none; border: solid 1px black;">wait</div>
</body>
</html>
*/

/*
РџСЂРёРЅС†РёРї СЂР°Р±РѕС‚С‹
~~~~~~~~~~~~~~
РџСЂРё РІС‹Р·РѕРІРµ РјРµС‚РѕРґР° submit РІРµР№С‚РµСЂ РѕС‚РѕР±СЂР°Р¶Р°РµС‚ С‡Р°СЃРёРєРё, Р±Р»РѕРєРёСЂСѓРµС‚ РєРЅРѕРїРєСѓ submit, СЃРѕР±РёСЂР°РµС‚ РґР°РЅРЅС‹Рµ С„РѕСЂРјС‹ (РµСЃР»Рё РЅРµ РїРµСЂРµРґР°РЅ СЏРІРЅРѕ Р°СЂРіСѓРјРµРЅС‚ params) Рё РѕС‚РїСЂР°РІР»СЏРµС‚ РёС… РЅР° СЃРµСЂРІРµСЂ РїРѕ Р°РґСЂРµСЃСѓ, СѓРєР°Р·Р°РЅРЅРѕРјСѓ РІ submitUrl. Р’ РєР°С‡РµСЃС‚РІРµ СЂРµР·СѓР»СЊС‚Р°С‚Р° РѕС‚ СЃРµСЂРІРµСЂР° РѕР¶РёРґР°РµС‚СЃСЏ JSON-РѕР±СЉРµРєС‚ СЃ РєР»СЋС‡Р°РјРё:

* status - РєРѕРґ СЂРµР·СѓР»СЊС‚Р°С‚Р°. РњРѕР¶РµС‚ РїСЂРёРЅРёРјР°С‚СЊ Р·РЅР°С‡РµРЅРёСЏ: OK, ERR_ARGUMENTS, Р»СЋР±РѕР№ РґСЂСѓРіРѕР№ РїСЂРѕРёР·РІРѕР»СЊРЅС‹Р№ РєРѕРґ РѕС€РёР±РєРё.
* redirect - СЂРµРґРёСЂРµРєС‚ РЅР° РґСЂСѓРіРѕР№ Р°РґСЂРµСЃ. РћР±СЂР°Р±Р°С‚С‹РІР°РµС‚СЃСЏ РІРµР№С‚РµСЂРѕРј С‚РѕР»СЊРєРѕ РїСЂРё status = OK
* message - РѕРїРёСЃР°РЅРёРµ РѕС€РёР±РєРё. РњРѕР¶РµС‚ Р±С‹С‚СЊ РїРѕР»РµР·РЅРѕ РєРѕР»Р»Р±СЌРєСѓ, РєРѕС‚РѕСЂС‹Р№ РѕР±СЂР°Р±Р°С‚С‹РІР°РµС‚ РѕС€РёР±РєРё СЃРµСЂРІРµСЂР° (onServerError)
* errors - РјР°СЃСЃРёРІ РїРѕР»РµР№ СЃ РѕС€РёР±РєР°РјРё. РћР±СЂР°Р±Р°С‚С‹РІР°РµС‚СЃСЏ РІРµР№С‚РµСЂРѕРј РїСЂРё status = ERR_ARGUMENTS
* poll - URL РґР»СЏ РїРѕСЃР»РµРґСѓСЋС‰РµРіРѕ Р·Р°РїСѓСЃРєР° РѕРїСЂРѕСЃР°. РћР±СЂР°Р±Р°С‚С‹РІР°РµС‚СЃСЏ РІРµР№С‚РµСЂРѕРј С‚РѕР»СЊРєРѕ РїСЂРё status = OK Рё РµСЃР»Рё РЅРµ Р·Р°РґР°РЅ РєР»СЋС‡ redirect
* params - РїР°СЂР°РјРµС‚СЂС‹ Р·Р°РїСЂРѕСЃР°, РєРѕС‚РѕСЂС‹Рµ РІ РґР°Р»СЊРЅРµР№С€РµРј Р±СѓРґСѓС‚ РїРµСЂРµРґР°РІР°С‚СЊСЃСЏ РїСЂРё РїРѕР»Р»РёРЅРіРµ. Р•СЃР»Рё РєР»СЋС‡ РЅРµ Р·Р°РґР°РЅ, С‚Рѕ РёСЃРїРѕР»СЊР·СѓСЋС‚СЃСЏ РѕСЂРёРіРёРЅР°Р»СЊРЅС‹Рµ РїР°СЂР°РјРµС‚СЂС‹ С„РѕСЂРјС‹

РџСЂРё РѕРїСЂРѕСЃРµ СЃРµСЂРІРµСЂР° РІРµР№С‚РµСЂ РѕР¶РёРґР°РµС‚ JSON-РѕР±СЉРµРєС‚ СЃ РєР»СЋС‡Р°РјРё:

* status - РєРѕРґ СЂРµР·СѓР»СЊС‚Р°С‚Р°. РњРѕР¶РµС‚ РїСЂРёРЅРёРјР°С‚СЊ Р·РЅР°С‡РµРЅРёСЏ: OK_CONTINUE (РїСЂРѕРґРѕР»Р¶РёС‚СЊ РѕРїСЂРѕСЃ), OK_FINISH (С„РёРЅР°Р»СЊРЅС‹Р№ СЃС‚Р°С‚СѓСЃ, РїСЂРµРєСЂР°С‚РёС‚СЊ РѕРїСЂРѕСЃ), ERR_ARGUMENTS (РЅРµРїСЂР°РІРёР»СЊРЅС‹Рµ Р°СЂРіСѓРјРµРЅС‚С‹ Р·Р°РїСЂРѕСЃР°, РїСЂРµРєСЂР°С‚РёС‚СЊ РѕРїСЂРѕСЃ), Р»СЋР±РѕР№ РґСЂСѓРіРѕР№ РїСЂРѕРёР·РІРѕР»СЊРЅС‹Р№ РєРѕРґ РѕС€РёР±РєРё
* redirect - СЂРµРґРёСЂРµРєС‚ РЅР° РґСЂСѓРіРѕР№ Р°РґСЂРµСЃ. РћР±СЂР°Р±Р°С‚С‹РІР°РµС‚СЃСЏ РІРµР№С‚РµСЂРѕРј РїСЂРё РїРѕР»СѓС‡РµРЅРёРё СЃС‚Р°С‚СѓСЃР° OK_FINISH. Р’ СЃР»СѓС‡Р°Рµ, РµСЃР»Рё СЃРµСЂРІРµСЂ РЅРµ РїРµСЂРµРґР°Р» РєР»СЋС‡ redirect, С‚Рѕ Р±СѓРґРµС‚ РІС‹Р·РІР°РЅ РєРѕР»Р»Р±СЌРє onSuccess
* message - СЃРѕРѕР±С‰РµРЅРёРµ РѕР± РѕС€РёР±РєРµ

РџСЂРё Р»СЋР±С‹С… РѕС€РёР±РєР°С… РІРµР№С‚РµСЂ СЃРєСЂС‹РІР°РµС‚ С‡Р°СЃРёРєРё Рё СЂР°Р·Р±Р»РѕРєРёСЂСѓРµС‚ РєРЅРѕРїРєСѓ submit.
*/
function CpgWaiter(settings) {
	/* РљРѕР»Р»Р±СЌРєРё */

	/* onParamsError - РІС‹Р·С‹РІР°РµС‚СЃСЏ РІ СЃР»СѓС‡Р°Рµ, РµСЃР»Рё РІРµР№С‚РµСЂ РїРѕР»СѓС‡РёР» РѕС‚ СЃРµСЂРІРµСЂР° РѕС€РёР±РєСѓ ERR_ARGUMENTS.
	РќР° РІС…РѕРґ С„СѓРЅРєС†РёСЏ РїРѕР»СѓС‡Р°РµС‚ РјР°СЃСЃРёРІ РїРѕР»РµР№ СЃ РѕС€РёР±РєР°РјРё */
	this.onParamsError = settings.onParamsError;
	/* onServerError - РѕС€РёР±РєР° СЃРµСЂРІРµСЂР°. Р’ СЃР»СѓС‡Р°Рµ, РµСЃР»Рё СЃРµСЂРІРµСЂ РІРµСЂРЅСѓР» РєРѕРґ РѕС€РёР±РєРё,
	С‚Рѕ РЅР° РІС…РѕРґ С„СѓРЅРєС†РёРё РїРѕРґР°РµС‚СЃСЏ РІРµСЃСЊ РѕС‚РІРµС‚ СЃРµСЂРІРµСЂР° (json-РѕР±СЉРµРєС‚, СЃРѕРґРµСЂР¶Р°С‰РёР№ РєРѕРґ
	Рё СЃРѕРѕР±С‰РµРЅРёРµ РѕР± РѕС€РёР±РєРµ). Р•СЃР»Рё Р±С‹Р»Р° РѕС€РёР±РєР° РІР·Р°РёРјРѕРґРµР№СЃС‚РІРёСЏ СЃ СЃРµСЂРІРµСЂРѕРј РёР»Рё РѕС‚РІРµС‚
	РЅРµ СЏРІР»СЏРµС‚СЃСЏ РІР°Р»РёРґРЅС‹Рј JSON, С‚Рѕ РєРѕР»Р»Р±СЌРє РІС‹Р·С‹РІР°РµС‚СЃСЏ СЃ РїР°СЂР°РјРµС‚СЂР°РјРё null, textStatus (С‚РёРї РѕС€РёР±РєРё) */
	this.onServerError = settings.onServerError;
	/* onTimeout - РєРѕР»Р»Р±СЌРє РІС‹Р·С‹РІР°РµС‚СЃСЏ, РєРѕРіРґР° РёСЃС‡РµСЂРїР°РЅ Р»РёРјРёС‚ РѕРїСЂРѕСЃР° СЃРµСЂРІРµСЂР° */
	this.onTimeout = settings.onTimeout;
	/* onConfirm - РєРѕР»Р»СЌРє РІС‹Р·С‹РІР°РµС‚СЃСЏ, РєРѕРіРґР° РЅРµРѕР±С…РѕРґРёРјРѕ РїРѕРґС‚РІРµСЂР¶РґРµРЅРёРµ С‚СЂР°РЅР·Р°РєС†РёРё РїРѕР»СЊР·РѕРІР°С‚РµР»РµРј РґРѕ РїРµСЂРµС…РѕРґР° РЅР° 3ds.
	РќР° РІС…РѕРґ РїРѕР»СѓС‡Р°РµС‚ РѕС‚РІРµС‚ СЃРµСЂРІРµСЂР° (JSON-РѕР±СЉРµРєС‚) */
	this.onConfirm = settings.onConfirm;
	/* onSuccess - РєРѕР»Р»Р±СЌРє РІС‹Р·С‹РІР°РµС‚СЃСЏ, РµСЃР»Рё РІ СЂРµР·СѓР»СЊС‚Р°С‚Рµ РѕРїСЂРѕСЃР° РїРѕР»СѓС‡РµРЅ С„РёРЅР°Р»СЊРЅС‹Р№ СЃС‚Р°С‚СѓСЃ,
	РЅРѕ РѕРЅ РЅРµ СЏРІР»СЏРµС‚СЃСЏ СЂРµРґРёСЂРµРєС‚РѕРј. РќР° РІС…РѕРґ РєРѕР»Р»Р±СЌРє РїРѕР»СѓС‡Р°РµС‚ РѕС‚РІРµС‚ СЃРµСЂРІРµСЂР° (JSON-РѕР±СЉРµРєС‚) */
	this.onSuccess = settings.onSuccess;
	this.onError = settings.onError;
	/* onShow - РѕРїС†РёРѕРЅР°Р»СЊРЅС‹Р№ РєРѕР»Р»Р±СЌРє, РєРѕС‚РѕСЂС‹Р№ РјРѕР¶РµС‚ РІС‹Р·С‹РІР°С‚СЊСЃСЏ РїРµСЂРµРґ РїРѕРєР°Р·РѕРј "С‡Р°СЃРёРєРѕРІ" */
	this.onShow = settings.onShow;
	/* onHide - РѕРїС†РёРѕРЅР°Р»СЊРЅС‹Р№ РєРѕР»Р»Р±СЌРє, РєРѕС‚РѕСЂС‹Р№ РјРѕР¶РµС‚ РІС‹Р·С‹РІР°С‚СЊСЃСЏ РїРµСЂРµРґ СЃРєСЂС‹С‚РёРµРј "С‡Р°СЃРёРєРѕРІ" */
	this.onHide = settings.onHide;
	/* onRedirect - РµСЃР»Рё Р·Р°РґР°РЅ СЌС‚РѕС‚ РєРѕР»Р»Р±СЌРє, С‚Рѕ РѕРЅ РІС‹Р·С‹РІР°РµС‚СЃСЏ РІРјРµСЃС‚Рѕ СЂРµРґРёСЂРµРєС‚Р° РїСЂРё
	РїРѕР»СѓС‡РµРЅРёРё РІ РѕС‚РІРµС‚Рµ СЃРµСЂРІРµСЂР° РєРѕРјР°РЅРґС‹ redirect. РќР° РІС…РѕРґ С„СѓРєРЅС†РёСЏ РїРѕР»СѓС‡Р°РµС‚ url РґР»СЏ СЂРµРґРёСЂРµРєС‚Р° */
	this.onRedirect = settings.onRedirect;

	/* onBackUrlRedirect - РµСЃР»Рё Р·Р°РґР°РЅ СЌС‚РѕС‚ РєРѕР»Р»Р±СЌРє, С‚Рѕ РѕРЅ РІС‹Р·С‹РІР°РµС‚СЃСЏ РїСЂРё РїРѕР»СѓС‡РµРЅРёРё РѕС€РёР±РєРё СЃР°Р±РјРёС‚Р° С„РѕСЂРјС‹, РµСЃР»Рё РѕС€РёР±РєР°
	РЅРµ СЃРѕРґРµСЂР¶РёС‚ Р°РґСЂРµСЃР° СЂРµРґРёСЂРµРєС‚Р°. РџСЂРµРґРїРѕР»Р°РіР°РµС‚СЃСЏ, С‡С‚Рѕ РґРѕР»Р¶РЅР° РїРµСЂРµРЅР°РїСЂР°РІР»СЏС‚СЊ РЅР° back_url c РІС‹СЃС‚Р°РІР»РµРЅРЅС‹Рј С„Р»Р°РіРѕРј РѕС€РёР±РєРё.
	РќР° РІС…РѕРґ РєРѕР»Р»Р±СЌРє РїРѕР»СѓС‡Р°РµС‚ РѕС‚РІРµС‚ СЃРµСЂРІРµСЂР° (JSON-РѕР±СЉРµРєС‚). */
	this.onBackUrlRedirect = settings.onBackUrlRedirect;

	/* requestMethod - РјРµС‚РѕРґ Р·Р°РїСЂРѕСЃР°. РџРѕ СѓРјРѕР»С‡Р°РЅРёСЋ POST */
	this.requestMethod = settings.requestMethod || 'POST';
	/* clockElement - id СЌР»РµРјРµРЅС‚Р°, РґРµРјРѕРЅСЃС‚СЂРёСЂСѓСЋС‰РµРіРѕ "С‡Р°СЃРёРєРё". РџРѕ СѓРјРѕР»С‡Р°РЅРёСЋ "waiter" */
	this.clockElement = settings.clockElement || 'cpg_waiter';
	this.submitElement = settings.submitElement || 'cpg_submit';
	/* pollLimit - Р»РёРјРёС‚ РїРѕРїС‹С‚РѕРє РѕРїСЂРѕСЃР° СЃРµСЂРІРµСЂР°. РџРѕ СѓРјРѕР»С‡Р°РЅРёСЋ 20 */
	this.pollLimit = settings.pollLimit || 20;
	/* pollInterval - РёРЅС‚РµСЂРІР°Р» РјРµР¶РґСѓ РїРѕРїС‹С‚РєР°РјРё РѕРїСЂРѕСЃР° СЃРµСЂРІРµСЂР° (РІ РјРёР»Р»РёСЃРµРєСѓРЅРґР°С…). РџРѕ СѓРјРѕР»С‡Р°РЅРёСЋ - 1000 */
	this.pollInterval = settings.pollInterval || 1000;

	/* submitUrl - Р°РґСЂРµСЃ РґР»СЏ РѕС‚РїСЂР°РІРєРё С„РѕСЂРјС‹ */
	this.submitUrl = settings.submitUrl;
	/* pollUrl - РѕРїС†РёРѕРЅР°Р»СЊРЅРѕ РјРѕР¶РЅРѕ Р·Р°РґР°С‚СЊ url РґР»СЏ РѕРїСЂРѕСЃР° РЅР° СЃР»СѓС‡Р°Р№, РµСЃР»Рё РѕРЅ РЅРµ РІРµСЂРЅРµС‚СЃСЏ
	РІ СЂРµР·СѓР»СЊС‚Р°С‚Рµ РѕС‚РїСЂР°РІРєРё С„РѕСЂРјС‹ */
	this.pollUrl = settings.pollUrl;

	/* fakeAjax - РµСЃР»Рё true Рё РїРѕРґРєР»СЋС‡РµРЅ РїР»Р°РіРёРЅ jquery.ajax.fake - РёРјРёС‚Р°С†РёСЏ Р·Р°РїСЂРѕСЃР° РЅР° СЃРµСЂРІРµСЂ */
	this.fakeAjax = settings.fakeAjax;

	var pollTimer = 0;
	var pollCount = 0;
	var sourceForm = undefined;
	var ajaxParams = undefined;

	/* РћС‚РїСЂР°РІРєР° С„РѕСЂРјС‹ РЅР° СЃРµСЂРІРµСЂ. Р¤СѓРЅРєС†РёСЏ РґРѕР»Р¶РЅР° РїСЂРёРЅРёРјР°С‚СЊ РЅР° РІС…РѕРґ РѕР±СЏР·Р°С‚РµР»СЊРЅС‹Р№ РїР°СЂР°РјРµС‚СЂ - РѕР±СЉРµРєС‚ С„РѕСЂРјС‹. РўР°РєР¶Рµ РґРѕРїСѓСЃРєР°РµС‚СЃСЏ СЏРІРЅР°СЏ РїРµСЂРµРґР°С‡Р° Р·Р°СЂР°РЅРµРµ СЃРѕР±СЂР°РЅРЅС‹С… РїР°СЂР°РјРµС‚СЂРѕРІ. Р•СЃР»Рё Р°СЂРіСѓРјРµРЅС‚ params РЅРµ Р·Р°РґР°РЅ, С‚Рѕ РґР°РЅРЅС‹Рµ С„РѕСЂРјС‹ Р±СѓРґСѓС‚ СЃРѕР±СЂР°РЅС‹ СЃ РїРѕРјРѕС‰СЊСЋ РјРµС‚РѕРґР° jQuery serialize
	 */
	this.submit = function(form, params) {
		if (! params) {
			params = $(form).serialize();
		}

		/* РїРѕС‡РёСЃС‚РёРј РѕС€РёР±РєРё С„РѕСЂРјС‹ */
		if (this.onParamsError) {
			this.onParamsError(null, 1);
		}

		ajaxParams = params;
		sourceForm = form;

		pollCount = 0; /* РѕР±РЅСѓР»СЏРµРј С‡РёСЃР»Рѕ РїРѕРїС‹С‚РѕРє РѕРїСЂРѕСЃР° */
		this.showClock(); /* РїРѕРєР°Р·С‹РІР°РµРј С‡Р°СЃРёРєРё */
		var waiter = this;
		$.ajax({
			url: waiter.submitUrl,
			type: waiter.requestMethod,
			fake: waiter.fakeAjax,
			dataType: 'json',
			data: params
		}).done(function(data) {
			if (data.error) {
				if (data.error.error_fields) {
					if (waiter.onParamsError) {
						waiter.onParamsError(data.error.error_fields);
					}
					waiter.finish();
				} else if (data.url) {
					if (waiter.onRedirect) {
						waiter.onRedirect(data.url);
					} else {
						redirect(data.url);
					}
				} else {
					if (waiter.onBackUrlRedirect) {
						waiter.onBackUrlRedirect(data);
					}
					waiter.finish();
				}
			} else {
				if (waiter.onSubmitSuccess) {
					waiter.onSubmitSuccess(data);
				} else {
					waiter.startPoll(data.url, data.params);
				}
			}
		}).fail(function(jqXHR, textStatus, err) {
			/* РќРµ РґРѕСЃС‚СѓС‡Р°Р»РёСЃСЊ РґРѕ СЃРµСЂРІРµСЂР° РёР»Рё РЅРµ РїРѕР»СѓС‡РёР»Рё РІР°Р»РёРґРЅС‹Р№ JSON - РІС‹Р·С‹РІР°РµРј РєРѕР»Р»Р±СЌРє */
			if (waiter.onServerError) {
				waiter.onServerError(null, textStatus);
			}
			waiter.finish();
		});
	};

	this.resetPollCount = function() {
		pollCount = 0;
	}

	this.showClock = function() {
		if (this.onShow) {
			this.onShow();
		}
		$("#" + this.submitElement).prop('disabled', true);
		$('#' + this.clockElement).show();
	};

	this.finish = function() {
		if (this.onHide) {
			this.onHide();
		}
		$('#' + this.clockElement).hide();
		$("#" + this.submitElement).prop('disabled', false);
	};

	var redirect = function(url) {
		window.location.href = url;
	};

	this.startPoll = function(url, params) {
		/* РЎ СЃРµСЂРІРµСЂР° РјРѕРіР»Рё РїСЂРёР№С‚Рё РєР°СЃС‚РѕРјРЅС‹Рµ РїР°СЂР°РјРµС‚СЂС‹ РґР»СЏ РґР°Р»СЊРЅРµС€РµР№ РѕС‚РїСЂР°РІРєРё РїСЂРё РѕРїСЂРѕСЃРµ - СЃРѕС…СЂР°РЅСЏРµРј РёС… */
		if (params) {
			ajaxParams = params;
		}
		clearTimeout(pollTimer);
		var waiter = this;
		pollCount++;
		if (pollCount > this.pollLimit) {
			if (this.onTimeout) {
				this.onTimeout();
			}
			return this.finish();
		}
		pollTimer = setTimeout(function() {
			$.ajax({
				url: url || waiter.pollUrl,
				type: waiter.requestMethod,
				fake: waiter.fakeAjax,
				dataType: 'json'
			}).done(function(data) {
				switch (data.status) {
					case 'OK_CONTINUE':
						/* РџСЂРѕРґРѕР»Р¶Р°РµРј РѕРїСЂРѕСЃ */
						waiter.startPoll(url);
						break;
					case 'OK_FINISH':
						/* Р¤РёРЅР°Р»СЊРЅС‹Р№ СЃС‚Р°С‚СѓСЃ */
						if (data.acs_url) {
							if ( waiter.on3DS ) {
								waiter.on3DS(data);
							} else {
								waiter.submit3DS(data);
							}
						} else if (data.confirm_data && waiter.onConfirm) {
							waiter.onConfirm(data);
						} else if (waiter.onSuccess) {
							waiter.onSuccess(data);
						} else if (data.url) {
							/* РџСЂРёС€РµР» СЂРµРґРёСЂРµРєС‚ - РІС‹РїРѕР»РЅСЏРµРј */
							if (waiter.onRedirect) {
								waiter.onRedirect(data.url);
							} else {
								redirect(data.url);
							}
						}
						waiter.finish();
						break;
					 case 'ERR_FINISH':
						if ( waiter.onError ) {
							waiter.onError(data);
						} else if (data.url) {
							if (waiter.onRedirect) {
								waiter.onRedirect(data.url)
							} else {
								redirect(data.url);
							}
						}
						waiter.finish();
						break;
					default:
						/* РџСЂРѕРёР·РІРѕР»СЊРЅР°СЏ РѕС€РёР±РєР° - РІС‹Р·С‹РІР°РµРј РєРѕР»Р»Р±СЌРє, РїРµСЂРµРґР°РµРј С‚СѓРґР° РІРµСЃСЊ РѕС‚РІРµС‚ СЃРµСЂРІРµСЂР° */
						if (waiter.onServerError) {
							waiter.onServerError(data);
						}
						waiter.finish();
						break;
				}
			}).fail(function(jqXHR, textStatus, err) {
				/* РћС€РёР±РєР° РІР·Р°РёРјРѕРґРµР№СЃС‚РІРёСЏ СЃ СЃРµСЂРІРµСЂРѕРј РёР»Рё РЅРµРІР°Р»РёРґРЅС‹Р№ JSON-РѕР±СЉРµРєС‚ */
				if (waiter.onServerError) {
					waiter.onServerError(null, textStatus);
				}
				waiter.finish();
			});
		}, waiter.pollInterval);
	};

	this.submit3DS = function(data) {
		this.create3DSform(data);
		document.getElementById('cpg_acs_form').submit();
	}

	this.create3DSform = function(data) {
		var tds = data.threeds_data;
		$('body').append('<form id="cpg_acs_form" action="' + data.acs_url + '"' + ( typeof(data.target) != 'undefined' ? ('target=' + data.target) : '' ) + ' method="POST">'
			+ '<input type="hidden" name="PaReq" value="' + tds.PaReq + '" />'
			+ '<input type="hidden" name="TermUrl" value="' + tds.TermUrl + '" />'
			+ '<input type="hidden" name="MD" value="' + tds.MD + '" />'
			+ '</form>');
	}
}

function getBaseUrl() {
	var url = document.URL;
	var re = /(https?:\/\/.+?)(\/|\?)/;
	var found = url.match(re);
	return found[1];
}

function createCpgWaiter() {
	var baseUrl = getBaseUrl();
	return new CpgWaiter({
		submitUrl: baseUrl + $("#cpg_form").attr('action'),
		clockElement: 'cpg_waiter',
		submitElement: 'cpg_submit',
		requestMethod: 'POST',
		onServerError: function(data) {
			$("#cpg_form").hide();
			$("#cpg_error").show();
		},
		onParamsError: function(errors, remove) {
			if (remove) {
				$("#cpg_form").find('label').removeClass('cpg_error');
			} else {
				for (var field in errors) {
					$('#' + errors[field]).addClass('cpg_error');
				}
				$("#cpg_form").find("input[type=submit]").removeAttr('disabled');
			}
		},
		onTimeout: function(data) {
			$('#cpg_error').show();
		},
		onBackUrlRedirect: function(data) {
			var code = data.error.code || "UNKNOWN_ERROR";

			var $holder = $('a#cpg_error_back_url');
			if ($holder.length) {
				var url = $holder.attr('src');
				if (url) {
					url += url.indexOf('?') < 0 ? '?' : '&';
					url += 'cpg_error_code=' + code;
					window.location.href = url;
				}
			} else if (this.onError) {
				this.onError(data);
			}
		}
	});
}