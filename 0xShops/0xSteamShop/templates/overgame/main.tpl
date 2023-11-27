<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
{headers}
<script src="https://yastatic.net/share2/share.js" async="async"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic" rel="stylesheet">
<link rel="stylesheet" href="{THEME}/style/style.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="{THEME}/style/app.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="{THEME}/style/font-awesome.min.css"> 
<link rel="sitemap" type="application/xml" title="Sitemap" href="/overgame/sitemap.xml" />

	<link href="{THEME}/js/jquery-ui.css" rel="stylesheet" type="text/css">
	<script src="{THEME}/js/jquery-latest.js"></script>
	<script src="{THEME}/js/jquery-ui.js"></script>

	<script src="{THEME}/js/jquery-migrate-1.js"></script>
	<script type="text/javascript" src="{THEME}/js/reveal.js"></script>
	<script src="{THEME}/js/jquery.bxslider.min.js"></script>
    <script src="{THEME}/js/custom-select-menu.jquery.min.js"></script>
    <script src="{THEME}/js/jquery.checkbox.min.js"></script>
    <script src="{THEME}/js/jquery.mousewheel.js"></script>
    <script src="{THEME}/js/SelectBox.js"></script>
    <script src="{THEME}/js/jScrollPane.js"></script>
    <script src="{THEME}/js/main.js"></script>
    <link href="{THEME}/images/favicon.png" rel="shortcut icon" type="image/x-icon">
    
</head>
<style>
		
	</style>

<body class="hasJS">
{AJAX}




<body style="('{THEME}/images/bg/blackflag.png') no-repeat scroll center top black;">


<div class="container header-container">
<header>
				<div class="row">
					<a class="logo" href="/">Магазин игр</a>
					<form class="header-search-form" action method="post">
                    
                        <input type="hidden" name="do" value="search" />
                        <input type="hidden" name="subaction" value="search" />
						<input class="search-input" type="search" placeholder="Поиск товаров в нашем интернет-магазине" name="story" required autocomplete="off">
						<button class="search-btn" type="submit">Поиск</button>
						<div class="search-autocomplete">
							<div class="autocomplete-list"></div>
							<div class="autocomplete-nav">
								<div class="autocomplete-nav-count">Найдено: <span></span></div>
								<div class="autocomplete-nav-pages">
									<span class="arrow-next"></span>
									<span class="count-pages"></span>
									<span class="arrow-prev disabled"></span>
								</div>
							</div>
						</div>
					</form>
					<ul class="header-top-menu">
                        <li style="margin-right:8px;"><a class="b-support" target="_blank" href="#">Поддержка</a></li>
                        <li><a class="b-purchase" id="PURCHASE" href="">Мои покупки</a></li>
					</ul>
					<div class="header-user-menu">
						<span class="navicon">Меню</span>
						<ul class="popup-user-menu">
                           <!-- <li><a href="/about_shop.html" title="О нас">О магазине</a></li>-->
                            <li><a href="/otzyv.html" title="Отзывы о магазине">Отзывы</a></li>
                            <li><a href="/garanty.html" title="Гарантии">Гарантии</a></li>
                            <li><a href="/vopros.html" title="Вопросы">Вопросы</a></li>
                            <li><a href="/kontakt.html" title="Контакты">Контакты</a></li>
						</ul>
					</div>

					<div class="header-user-menu hidden">
						<select style="display: none;">
							<option value="rub">RUB</option>
							<option value="usd">USD</option>
							<option value="uah" selected="selected">UAH</option>
						</select><div class="list-curr-menu hidden" tabindex="0" id="list-curr-select"><label class="has-been-selected">UAH</label><ul data-select-name="undefined" style="display: none;"><li data-option-value="rub">RUB</li><li data-option-value="usd">USD</li><li data-option-value="uah" class="active">UAH</li></ul><input type="hidden" name="undefined" value="uah"></div>
					</div>

				</div>
			{include file="catalog-nav.tpl"}<br />

			</header>
</div>

<div class="container">
	<main>
        [aviable=main]
        <div class="main-top-section">
                        <div class="row">
                            <div class="column middle" style="margin-left:3px; width:100%">
                                <script src="{THEME}/js/jquery.orbit-1.2.3.min.js"></script>
                                
                                <script type="text/javascript">
                                $(window).load(function() {
                                    $('#home-slider').orbit({					
                                        directionalNav: true,
                                        timer: true	     
                                    });
                                });
                                </script>  
                                {include file="slider.tpl"} 
                            
                            </div>
                        </div>
                    </div>
        [/aviable]
        [not-aviable=main]
			</a>
        [/not-aviable]
        [aviable=main]
    	<div class="catalog-section">
			<!--   CATALOG CONTENT   -->
            {include file="tab_content.tpl"}
			<!--   END CATALOG CONTENT   -->
			<!--   CATALOG SIDEBAR   -->
			<aside class="sidebar right">
				<!--   TOP SALE MODULE   -->
            	{include file="lider.tpl"}
				<!--   END TOP SALE MODULE   -->
				<!--   LATEST SALE MODULE   -->
				<div class="module latest-sale slide-module">

							<img alt="" height="339" src="https://steambuy.com/bezkom.jpg" width="309">
							</div>
				<!--   END LATEST SALE MODULE   -->
			</aside>
			<!--   END CATALOG SIDEBAR   -->
		</div>
        [/aviable] 
    	<!--   REVIEWS MODULE   -->
        [aviable=main]{include file="reviews.tpl"}[/aviable] 
        <!--   END REVIEWS MODULE   -->
        <!--   MODULE ROW   -->
        [aviable=main]{include file="share.tpl"}[/aviable] 
        <!--   END MODULE ROW   -->
        
        
        [aviable=cat|catalog|search|tags]
        <link rel="stylesheet" href="{THEME}/style/list.css" type="text/css" media="screen, projection">
        <div class="list">        
        <!--   LIST CONTENT   -->
        <section class="list-content">
        
            <div class="list-main module">
        
                <div class="module-head">
                    <div class="list-find-counter">
                        Найдено: <span class="counter">0</span>
                    </div>
                    <ul class="list-view-menu">
                        <li><a id="view-extended" data-view="extended" class="list-icon active" href="javascript:void(0)" onclick="list_view()">Список</a></li>
                        <li><a id="view-net" data-view="net" class="net-icon" href="javascript:void(0)" onclick="item_view()">Плитка</a></li>
                    </ul>
                    <form class="list-sort-form">
                        <span class="list-sort-label">Сортировать по:</span>
                        <select onchange="filter()" name="sort">
                          <option value="data_old">дата выхода, сперва старые</option>
                          <option value="data_new">дата выхода, сперва новые</option>
                          <option value="name_a-z">названию, A-Z</option>
                          <option value="name_z-a">названию, Z-A</option>
                          <option value="top_up" selected="selected">популярности, по убыванию</option>
                          <option value="top_down">популярности, по возрастанию</option>
<!--                          <option value="system_old">системным требованиям, меньше</option>
                          <option value="system_new">системным требованиям, больше</option>-->
                     <!--     <option value="price_low">цене, сначала недорогие</option>
                          <option value="price_high">цене, сначала дорогие</option>
                          <option value="economy_high">экономии, больше</option>-->
                         <!-- <option value="economy_percent-high">экономии, больше в %</option>-->
                        <!--  <option value="economy_low">экономии, меньше</option>-->
                         <!-- <option value="economy_percent-low">экономии, меньше в %</option>-->
                        </select>
                    </form>
                </div>
        
                <div class="module-content" id="catalog-list">
                    <div class="catalog-list">
						<div id="main-catalog"> <div class="clearfix"></div></div>
                        {content} 
                    </div>
                 </div>
            </div>
        
            <!--   PAGINATION   -->
            <div class="pagination hidden"><ul class="pagination-list"><li class="active"><a href="javascript:void(0)">1</a></li><li><a href="javascript:void(0)" data-page="2">2</a></li><li><a href="javascript:void(0)" data-page="3">3</a></li><li><a href="javascript:void(0)" data-page="4">4</a></li><li><a href="javascript:void(0)" data-page="5">5</a></li><li>...</li><li><a href="javascript:void(0)" data-page="88">88</a></li></ul><a class="next-btn" href="javascript:void(0)" data-page="2">ВПЕРЕД</a></div>
            <!--   END PAGINATION   -->
        
        </section>        
        <!--   END LIST CONTENT   -->        
                
        <!--   LIST SIDEBAR   -->      
        <aside class="list-sidebar">
        {include file="filter.tpl"}
        </aside>
        <!--   END LIST SIDEBAR   -->
        </div>
        [/aviable]
        [not-aviable=main|cat|catalog|search]    
        {content}   
        [/not-aviable]    
        
        
    </main>
</div>

 
<footer id="footer" class="container">
{include file="footer.tpl"}
</footer><!-- #footer -->
</body>
 <script type='text/javascript'>
$(document).snowfall({round : true, minSize: 5, maxSize:8, shadow : false}); // add rounded
</script>
<script>
		//$(window).load(function(){
		$(document).ready(function() {
			$('#PURCHASE').click(function() {
				var w = 960, h = 700;
				window.open(encodeURI('https://www.oplata.info/info/'), '', "scrollbars=1,resizable=1,menubar=0,toolbar=0,status=0,left=" + ((screen.width - w) / 2 - 12) + ",top=" + ((screen.height - h) / 2) + ",width=" + w + ",height=" + h);
				return false;
			});
		});
		</script>
</html>