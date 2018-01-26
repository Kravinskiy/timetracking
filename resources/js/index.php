<!DOCTYPE html>
<html lang="en" ng-app="stagkiss">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Stag Do Budapest (FUNNY PRANK ACTIVITIES)</title>
    <meta name="description"
          content="„Only their guides are better from their prices...”  - Facebook review. Build your stag do party and get a price offer with a discount.">
    <link href="/frontend/css/font-awesome.css" rel="stylesheet">
    <link href="/frontend/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--[if lt IE 9]>
    <script src="/frontend/js/css3-mediaqueries.js"></script>
    <![endif]-->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0,  maximum-scale=1.0">


    <!--<script type="text/javascript">
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:381050,hjsv:5};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
    </script>-->

    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-88916964-1', 'auto');
        ga('send', 'pageview');

    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

    <script src="/frontend/js/animateScroll.js"></script>

    <script src="/frontend/js/ngResource.js"></script>
    <script src="/frontend/js/ui.router.js"></script>
    <script src="/frontend/js/oc.lazyLoad.js"></script>
    <script src="/frontend/js/config.js"></script>
    <script src="/frontend/js/controller.js"></script>
</head>
<body ng-controller="MainCtrl as main">

<base href="/<?php echo $url[1]; ?>">

<div id="header">
    <div class="container">

        <div class="inline left">
            <a ui-sref="home" class="nohover">
                <img src="/frontend/img/logo.png" class="logo" alt="Stag Kiss Logo"/>
            </a>
        </div>

        <div class="inline right navigation_phone">
            <i class="fa fa-bars" aria-hidden="true" ng-click="showMenu ? showMenu = false : showMenu = true"></i>
        </div>

        <div class="inline right menu">
            <a ng-class="{ active: isActive('/home') }" ui-sref="home">Activities</base></a>
            <a ng-class="{ active: isActive('/our-team') }" ui-sref="our-team">Our Team</a>
            <a onclick="$('#contact-us').animatescroll({ scrollSpeed: 1300 });">Contact Us</a>
            <a href="http://stagkissbudapest.com/blog" target="_blank">Blog</a>
        </div>

        <div class="menu_phone" ng-show="showMenu">
            <a ng-class="{ active: isActive('/home') }" ui-sref="home">Activities</base></a>
            <a ng-class="{ active: isActive('/our-team') }" ui-sref="our-team">Our Team</a>
            <a onclick="$('#contact-us').animatescroll({ scrollSpeed: 1300 });">Contact Us</a>
            <a href="http://stagkissbudapest.com/blog" target="_blank">Blog</a>
        </div>

    </div>
</div>

<div ui-view style="height:100%;"></div>

<div id="customer-videos">

    <div class="container">

        <p class="title">Customer Reviews</p>

        <iframe class="youtube-container" src="https://www.youtube.com/embed/CDS8Ksb16ms" frameborder="0"
                allowfullscreen></iframe>

        <iframe class="youtube-container" src="https://www.youtube.com/embed/w2oY7hHrEgE" frameborder="0"
                allowfullscreen></iframe>


    </div>

</div>

<div id="contact-us">

    <div class="container block">

        <div class="inline left">
            <b>Contact us</b><br/><br/>

            London: <a href="tel://+44 20 3287 5773" style="text-decoration: underline;">+44 20 3287 5773</a><br/>
            Budapest: <a href="tel://+44 20 3287 5773" style="text-decoration: underline;">+36 20 261 4599</a><br/>
            E-mail: hello@stagkissbudapest.com<br/><br/>

            Address: 1068 Budapest, Király utca 80.<br/>

            Company name: Stag Kiss Kft. (registration number 01-09-208122)<br/>
            Tax number: 25318218-1-42<br/><br/>

            <a ui-sref="our-team"><b>Our Team >></b></a>
        </div>

        <div class="inline right">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.2485697280194!2d19.065398615627018!3d47.5045501791781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc6fa4def8f7%3A0xffe5e5ed76137093!2sBudapest%2C+Kir%C3%A1ly+u.+80%2C+1068!5e0!3m2!1shu!2shu!4v1479075960123"
                    width="100%" height="230" frameborder="0" style="border:0" allowfullscreen></iframe>


        </div>

    </div>

</div>

<div id="footer">
    <div class="container">
        <div class="inline left">
            Copyright &copy stagkissbudapest.com
        </div>

        <div class="inline right">
            Design and development by <a href="http://kravinskiy.com/" target="_blank">kravinskiy.com</a>
        </div>
    </div>
</div>
</body>
</html>
