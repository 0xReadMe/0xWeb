<? 
include "config.php";
$contact = $_SERVER['SERVER_NAME'];
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$name;?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  
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
                    <li class="menu__item"><a href="index.php#aboutz">About</a></li>
                    <li class="menu__item"><a href="index.php#featuresz">Features</a></li>
                    <li class="menu__item"><a href="#">Contact Us</a></li>
                    <li class="menu__item"><a href="index.php#tryfree">Try it for free</a></li>
                    <a class="button-l-menu" href="download.php">
                        Try it
                    </a>
                </ul>
                
            </nav>
        </div>
        <div class="top-header-img">
            <div class="container">
                <div class="top-header-block">
                    <h2 class="top-header-block__title">
                        Contact Us
                    </h2> 
                    <p class="top-header-block__text">
                        Do you have any questions about the extension? 
                        Write to us we are always ready to help.
                    </p>
                </div>    
            </div>
        </div>
    </header>

    <section class="information">
        <div class="container container-information">
            <div class="information-block">
                <div class="information-block__contacts">
                    <img src="img/baby.png" alt="">
                    <div class="contacts-block contacts-block-1">
                        <h4 class="contacts-block__title">
                            ADDRESS
                        </h4>
                        <p class="contacts-block__text">
                            MELBOURNE<br>
                            134 Gwynne Street<br>
							Richmond VIC 3121
                        </p>
                    </div>
                    <div class="contacts-block contacts-block-2">
                        <h4 class="contacts-block__title">
                            PHONE
                        </h4>
                        <div class="contacts-block__text-block">
                            <div class="contacts-block_img">
                            <img src="img/phone.png" alt="">
                        </div>
                            <p class="contacts-block__text">
                                T 03 8320 5700
                            </p>
                        </div>
                    </div>
                    <div class="contacts-block">
                        <h4 class="contacts-block__title">
                            SITE
                        </h4>
                        <div class="contacts-block__text-block">
                            <div class="contacts-block_img">
                            <img src="img/world.png" alt="">
                        </div>
                            <p class="contacts-block__text">
                                www.<?=$contact;?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form">
                <h4 class="contacts-block__title">
                    SEND US MESSAGE (SOON)
                </h4>
                <p class="form-text">
                    Full Name
                </p>
                <input type="text" class="name" placeholder="Your Name">
                <p class="form-text">
                    Email
                </p>
                <input type="text" class="name" placeholder="Your Email">
                <p class="form-text">
                    Message
                </p>
                <input type="text" class="name name-m" placeholder="Your Message">
                <input class="form-button" type="button" value="submit" >
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
                                <h2 class="angle-right__title">
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
                                    <li class="f-r-item"><a href="index.php#aboutz">About</a></li>
                                    <li class="f-r-item"><a href="#featuresz">What We Do</a></li>
                                    <li class="f-r-item"><a href="index.php">Project</a></li>
                                    <li class="f-r-item"><a href="#tryfree">How It Work With Us</a></li>
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