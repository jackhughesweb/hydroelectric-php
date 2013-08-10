<?php 
session_start(); 
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Hydroelectric</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" href="/css/normalize.min.css">
        <link rel="stylesheet" href="/css/main.css">

        <script src="/js/vendor/modernizr-2.6.2.min.js"></script>
        
    </head>
    <body>
        <?php 
        
        if(isset($_SESSION['valid'])){ ?>
        <style>.logintable{
            display: none;
            }</style>
        <?php } ?>

        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
<span class="re">Refresh</span>
<table class="maintable" id="scrollable">
            <tr>
                
                <td class="maincontent">
                    <header>
                    <nav>
                        <table>
                            <tr>
                                <td><img src="/hydroelectric.png" class="home" height="49px" width="49px" style="padding-left: 10px;"><span class="loc"></span><span class="hoverText"><img src="/pic.php" height="18px" width="18px" style="border-radius: 200em; verticle-align: top;" class="profilepic"><span class="name"></span>
                        <span class="options"><span class="button editpagebutton">Edit</span> <span class="button optionsbutton">Options</span> <span class="button importexportbutton">Import/Export</span> <span class="button logoutbutton">Logout</span></span></span>
                        
                    </td></tr></table>

                    </nav>
                    
                </header>
                    <dl class="accordion">
                            
                        </dl>
                </td>
            </tr>
        </table>

        <table class="logintable">
            <tr>
            <td><table width="400px" style="margin-left: auto; margin-right:auto;"><tr><td>                <td class="login">
               <img src="/hydroelectric.png" height="250px" width="250px" class="loginlogo"><div class="hidelarge"><div class="indicator i1">&nbsp;</div> <div class="indicator i2">&nbsp;</div> <div class="indicator i3">&nbsp;</div></div>
               <br><input type="password" class="passwordbox" id="passwordbox" placeholder="Password"></input><span class="loginbutton button buttonjoined">Login</span><div style="min-height:90px;">&nbsp;</div>
                </td>
                <td class="cardside">
                    <div class="reader"><div class="indicator i1"></div><div class="indicator i2"></div><div class="indicator i3"></div><div class="card"><div class="magswipe"></div></div></div>
                </td>
            </td>
        </tr></table>
            </tr>
            <tr>
                <td class="stripe" colspan="2">
                </td>

            </tr>
        </table>

        <table class="overlay">

            <tr>
                <td>
                    <div class="popup">
                        <span class="popuptext">Loading...</span><div id="floatingCirclesG" class="popupSpinner">
                            <div class="f_circleG" id="frotateG_01">
                            </div>
                            <div class="f_circleG" id="frotateG_02">
                            </div>
                            <div class="f_circleG" id="frotateG_03">
                            </div>
                            <div class="f_circleG" id="frotateG_04">
                            </div>
                            <div class="f_circleG" id="frotateG_05">
                            </div>
                            <div class="f_circleG" id="frotateG_06">
                            </div>
                            <div class="f_circleG" id="frotateG_07">
                            </div>
                            <div class="f_circleG" id="frotateG_08">
                            </div>
                            </div>
                        <div class="button okbutton">Ok</div>
                    </div>
                </td>
            </tr>

        </table>


        
        <script src="/js/vendor/jquery-1.9.1.min.js"></script>
        
        <script src="/js/plugins.js"></script>
        <script src="/js/sha256.js"></script>
        <script src="/js/fastclick.js"></script>
        <script src="/js/jquery.animate-colors-min.js"></script>
        <script src="/js/md5-min.js"></script>
        <?php   
      
        if(isset($_SESSION['valid'])){ ?>
        <script>var htmlheight = $('html').height();
htmlheight = "-" + htmlheight + "px";
$('.logintable').css('top', htmlheight);</script>
        <?php } ?>
        <script src="/js/main.js"></script>
     <!-- <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script> -->
       <!-- <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>-->
    </body>
</html>
