<!DOCTYPE html>
<?
include "config.php";

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$name;?></title>
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/overview.css">
  <link rel="stylesheet" href="./css/features.css">
  <link rel="stylesheet" href="./css/technology.css">
  <link rel="stylesheet" href="./css/focused.css">
  <link rel="stylesheet" href="./css/slider.css">
  <link rel="stylesheet" href="./css/contact.css">
  <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
  <header class="header" id="header">
    <div class="container">
      <nav class="nav" id="nav">
        <a href="/" class="nav__logo">
          <img src="./img/logo.png" alt="">
          <span><?=$name;?></span>
        </a>
        <ul class="nav__menu">
          <li><a href="#overview">OVERVIEW</a></li>
          <li><a href="#features">FEATURES</a></li>
          <li><a href="#technology">TECHNOLOGY</a></li>
          <li><a href="#contact">CONTACT</a></li>
        </ul>
        <div class="wrapper">
          <a href="#" class="nav__lang">
            <img src="./img/en-lang.png" alt="">
            <span>EN</span>
          </a>
          <a href="download.php" class="nav__download">DOWNLOAD</a>
        </div>
        <button class="nav__btn" id="nav__btn">&#x2261;</button>
        <div class="nav__m-menu" id="nav__m-menu">
          <ul class="nav__menu">
            <li><a href="#overview">OVERVIEW</a></li>
            <li><a href="#features">FEATURES</a></li>
            <li><a href="#technology">TECHNOLOGY</a></li>
            <li><a href="#contact">CONTACT</a></li>
          </ul>
          <a href="#" class="nav__lang">
            <img src="./img/en-lang.png" alt="">
            <span>EN</span>
          </a>
          <a href="#" class="nav__download">DOWNLOAD</a>
        </div>
      </nav>
      <main class="header__main">
        <h1 class="header__caption"><?=$name;?></h1>
        <span class="header__subtitle">
          Fully enjoy your music without any restrictions.<br>$30 a Month After a 14 Day Free Trial
        </span>
        <a href="download.php" class="header__link">Get <?=$name;?> now</a>
      </main>
    </div>
  </header>
  <section class="overview" id="overview">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5">
          <h2 class="caption">Switch to HiFi Mode</h2>
          <p class="overview__text">Fully enjoy your music with <?=$name;?> the high-performance universal audio playback
            software that makes music a priority on your computer, adapts its settings to your sound system, and offers
            you all the features you need to optimize your setup.</p>
        </div>
        <div class="col-md-6 offset-md-0 col-lg-5 offset-lg-1">
          <img src="./img/overview-img.png" alt="">
        </div>
      </div>
    </div>
  </section>
  <section class="features" id="features">
    <div class="container">
      <div class="row justify-content-center">
        <h2 class="caption">Features</h2>
      </div>
      <div class="row">
        <div class="features__item col-md-4">
          <img src="./img/features-img-0.png" alt="">
          <div>
            <h3>High sound quality</h3>
            <p>It reduces CPU activity and stabilizes power supply to minimize digital distortion and possible radio
              frequency interference.</p>
          </div>
        </div>
        <div class="features__item col-md-4">
          <img src="./img/features-img-1.png" alt="">
          <div>
            <h3>Turn your computer into a true high-resolution audio source</h3>
            <p>By taking control on your computer’s audio flow, <?=$name;?> prevents other applications from interfering
              during listening and from making hidden changes to audio samples.</p>
          </div>
        </div>
        <div class="features__item col-md-4">
          <img src="./img/features-img-2.png" alt="">
          <div>
            <h3>Enhanced performance</h3>
            <p>It improves the performance of your computer's digital-to-analog.Converter-both internal and external-by
              providing it with an adapted and pre-decoded digital stream.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="technology" id="technology">
    <div class="container">
      <div class="row justify-content-center">
        <h2 class="caption">Technology</h2>
      </div>
      <div class="row">
        <div class="technology__item col-md-3">
          <img src="./img/technology-img-0.png" alt="">
          <h3>Artificial Intelligence</h3>
          <p>Added artificial intelligence technologies for a more detailed analysis of the sound</p>
        </div>
        <div class="technology__item col-md-3">
          <img src="./img/technology-img-1.png" alt="">
          <h3>High-quality audio recording</h3>
          <p>High-quality audio recording due to the very large number of settings that are adjusted to the user</p>
        </div>
        <div class="technology__item col-md-3">
          <img src="./img/technology-img-2.png" alt="">
          <h3>Reconfiguring your microphone</h3>
          <p>The program adjusts your microphone itself for better performance</p>
        </div>
        <div class="technology__item col-md-3">
          <img src="./img/technology-img-3.png" alt="">
          <h3>Adjusts the music playlist to your taste</h3>
          <p>The program analyzes the user's tastes and creates a playlist based on them</p>
        </div>
      </div>
    </div>
  </section>
  <section class="focused" id="focused">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-12">
          <h2 class="caption">Stay focused on your work</h2>
          <p class="focused__text">It is important to be focused on your work while listening to music, our program has
            a mode for working slightly muffling the sound, without interfering with your work</p>
        </div>
        <div class="col-lg-8 col-md-12 focused__slider slider">
          <img src="./img/slider-img-0.png" alt="">
          <img class="active" src="./img/slider-img-1.png" alt="">
          <img src="./img/slider-img-2.png" alt="">
        </div>
      </div>
    </div>
  </section>
  <section class="contact" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <h2 class="caption">Contact</h2>
          <p class="contact__text">Questions or concerns? Write us an email and you will receive a response within 24
            hours</p>
        </div>
        <div class="col-md-5 offset-md-1 contact__email">
          <h3>Our email- <?=$name;?>.manager@gmail.com</h3>
          <img src="./img/contact-img.png" alt="">
        </div>
      </div>
    </div>
  </section>
  <footer class="footer" id="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 offset-lg-2 col-md-4 col-sm-4  footer__col">
          <h3>Address</h3>
          <p>
            Pipang Ltd, Griva Digeni,<br>
            81-83 Jacovides Tower, 1st Floor<br>
            1090 Picosia USA
          </p>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4  footer__col">
          <h3>Services</h3>
          <a href="#overview">Overview</a>
          <a href="#features">Features</a>
          <a href="#technology">Technology</a>
        </div>
        <div class="col-lg-3 offset-lg-1 col-md-4 col-sm-4 footer__col">
          <h3>Get in Touch</h3>
          <a href="mailto:<?=$name;?>.manager@gmail.com"><?=$name;?>.manager@gmail.com</a>
        </div>
      </div>
    </div>
    <span class="footer__copyright">
      Copyright 2020 <?=$name;?>
    </div>
  </footer>

  <script src="./js/main.js"></script>
</body>

</html>