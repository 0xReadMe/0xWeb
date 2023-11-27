<!DOCTYPE html>
<? 
include "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$name;?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="header__img">
            <img src="img/illustration.png" alt="">
        </div>
        <div class="header-top">
            <div class="logo">
                <a href="#">
                    <img src="img/logo.png" alt="">
                </a>
            </div>
            <a class="button" href="download.php">
                Try it
            </a>
        </div>
        <div class="container">
            <input type="checkbox" id="menu-checkbox">
            <nav class="menu" role="navigation">
                <label for="menu-checkbox" class="toggle-button" 
                data-open="Menu" data-clouse="Close" onclick></label>
                <ul class="menu__list">
                    <li class="menu__item"><a href="#aboutz">About</a></li>
                    <li class="menu__item"><a href="#featuresz">Features</a></li>
                    <li class="menu__item"><a href="contacts.php">Contact Us</a></li>
                    <li class="menu__item"><a href="#tryfree">Try it for free</a></li>
                    <a class="button-l-menu" href="download.php">
                        Try it
                    </a>
                </ul>
                
            </nav>
            <div class="header-content">
                <h1 class="header-content__title">
                    Use the Internet 
                    without annoying ads
                </h1>
                <p class="header-content__text">
                    Get cleaner and faster Internet access
                     and block annoying ads
                </p>
                <a class="button-content" href="download.php">
                    Try it for free
                </a>
            </div>
        </div>
    </header>

    <section class="anyBlock">
        <div class="container">
            <h2 class="anyBlock__h2" id="featuresz">
                Unique features of 
                <?=$name;?>
            </h2>
            <div class="three-cards">
            <div class="cards">
                <div class="card-left card">
                    <img src="img/secure.png" alt="">
                    <h3 class="card__h3">
                        Secure your data and 
                        devices
                    </h3>
                    <p class="card__p">
                        With <?=$name;?>, you can easily avoid tracking and malware. 
                        Blocking Intrusive ads reduces the risk of malware infection. 
                        Blocking tracking prevents companies from 
                        tracking your online activity.
                    </p>
                </div>
                <div class="cards-right">
                    <div class="card-right-1 card">
                        <img src="img/block.png" alt="">
                    <h3 class="card__h3">
                        Block ads that prevent you 
                        from viewing Internet resources.
                    </h3>
                    <p class="card__p">
                        Say goodbye to ads in videos, pop-up on top of the
                         Windows, flashing banners, etc.
                         When this annoying ads blocked,
                          pages load faster.
                    </p>
                    </div>
                    <div class="card-right-2 card">
                        <img src="img/bad.png" alt="">
                    <h3 class="card__h3">
                        Not all advertising is bad
                    </h3>
                    <p class="card__p">
                        Sites need finance in 
                        order to remain free. Support 
                        them by allowing acceptable ads
                         (enabled by default). Do you want 
                         to hide any ads? No problems.
                    </p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="about">
        <div class="container">
            <div class="about__about-h2-p">
                <h2 class="about__about-h2" id="aboutz">
                    About <?=$name;?>
                </h2>
                <p class="about__about-p">
                    We created <?=$name;?> so that everyone can freely use the Internet and 
                    not be distracted by anything. Tens of millions of people around the 
                    world use <?=$name;?> — in all browsers, in 30 languages! AdBlock was created
                    by Michael 
                    Gundlach back in 2009. Currently,
                    AdBlock is one of the most popular browser tools.
                </p>
            </div>
            <div class="smart">
                <div class="con">
                <h3 class="smart__smart-h3">
                    Smart use <?=$name;?>
                </h3>
                <p class="smart__smart-p">
                    Open source software is designed to ensure
                    that each user has full control over what they
                    want to see in their browser.
                </p>
                </div>
            </div>
            <div class="blocks">
                <div class="block-left block">
                    <h3 class="block-left__block-h3">
                        Сonfidentiality data
                    </h3>
                    <p class="block-left__block-p">
                        <?=$name;?> allows users to protect the privacy of
                        their data; it blocks many of the tools that 
                        companies use to track people over the 
                        Internet.
                    </p>
                </div>
                <div class="block-right block">
                    <h3 class="block-right__block-h3">
                        Monetization of content
                    </h3>
                    <p class="block-right__block-p">
                        However, we believe that webmasters should be
                        able to monetize content through advertising. 
                        Some of the things that we like have come to 
                        light through advertising. Our users actively 
                        place ads for authors they like, thanks to the 
                        features available in <?=$name;?>.
                    </p>
                </div>
            </div>
        </div>
    </section>

   <footer class="footer">
        <div class="angle-left">
                <div class="angle-right">
                    <div class="angle-right__line"></div>
                    <div class="container">
                        <div class="angle-right-all">
                            <div class="angle-right-t-p">
                                <h2 class="angle-right__title" id="tryfree">
                                    Intersted to work
                                    with our team?
                                </h2>
                                <p class="angle-right__text">
                                    You can join our team and work on 
                                    creating the perfect
                                     AdBlock highlighting unwanted 
                                     content on sites
                                </p>
                            </div>
                            <div class="btn-footer">
                                <a class="button-content" href="download.php">
                                    Try it for free
                                </a>
                            </div>
                        </div>
                        <div class="footer-down">
                            <div class="footer-down__left">
                                <div class="logo-footer">
                                    <a href="#">
                                        <img src="img/logo.png" alt="">
                                    </a>
                                    <h3 class="footer-down__left-title">
                                        <?=$name;?>
                                    </h3>
                                </div>
                                <ul class="footer-list">
                                    <li class="f-item">1.<p>MELBOURNE<br>
                                        134 Gwynne Street<br>
										 Richmond VIC 3121 </p>
										</li>
                                    <li class="f-item">2.<p>T 03 8320 5700</p></li>
                                </ul>
                                <p class="f-l">
                                    2020 © <?=$name;?>. All rights reserved.
                                </p>
                            </div>
                            <div class="footer-down__right">
                                <h4 class="footer-down__right-title">
                                    About US
                                </h4>
                                <ul class="f-r">
                                    <li class="f-r-item"><a href="#aboutz">About</a></li>
                                    <li class="f-r-item"><a href="#aboutz">What We Do</a></li>
                                    <li class="f-r-item"><a href="#">Project</a></li>
                                    <li class="f-r-item"><a href="#">How It Work With Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
        
                </div>
                <div class="container">
                    <div class="angle-left-all">
                        <div class="angle-left-t-p">
                            <h2 class="angle-left__title">
                                Blocks ads from 
                                all over the world
                            </h2>
                            <p class="angle-left__text">
                                No matter what country you are in and
                             what language you speak
                             <?=$name;?> blocks absolutely
                              all unwanted ads
                            </p>
                        </div>
                        <div class="angle-left__map">
                            <img src="img/map.png" alt="">
                        </div>
                    </div>                           
            </div>
        </div>
    </footer>
</body>
</html>