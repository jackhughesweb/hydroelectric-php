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
        <script src="/js/vendor/jquery-1.9.1.min.js"></script>

        <script src="/js/plugins.js"></script>
        <script src="/js/sha256.js"></script>
        <script src="/js/fastclick.js"></script>
        <script src="/js/jquery.animate-colors-min.js"></script>
        <script src="/js/md5-min.js"></script>
        <script>
        	history.pushState(null, null, "/");
        	function popup(text, opacity, speed, cancel, functionWhenComplete, buttonText) {
	opacity = opacity || "0.5";
	opacity = 'rgba(68,68,68,' + opacity + ')';
	speed = speed || 500;
	buttonText = buttonText || "Ok";
	$('.overlay').css('background-color', opacity);
	$('.okbutton').html(buttonText);
	$('.popuptext').html(text);
	$('.overlay').fadeIn(speed, function () {
		$('.popup').fadeIn(speed);
	});
	if (typeof cancel !== 'undefined') {
		$('.overlay tr').click(function () {
			popupHide();
		});
		$('.popup').click(function (e) {
			e.stopPropagation();
		});
		$('.popup').find('*').not('.okbutton').click(function (e) {
			e.stopPropagation();
		});
	}
	if (typeof functionWhenComplete === 'undefined') {

	} else {
		functionWhenComplete();
	}
}

function popupHide(speed, functionWhenComplete) {
	speed = speed || 500;
	$('.overlay tr').unbind();

	$('.popup').unbind();
	$('.popup').find('*').not('.okbutton').unbind();
	$('.popup').fadeOut(speed, function () {
		$('.overlay').fadeOut(speed, function () {
			$('.okbutton').css('display', 'block');
			$('.popupSpinner').css('display', 'none');
			if (typeof flashAmber === 'undefined') {
				if (typeof functionWhenComplete === 'undefined') {

				} else {
					functionWhenComplete();
				}
			} else {
				clearTimeout(flashAmber);
				if (typeof functionWhenComplete === 'undefined') {

				} else {
					functionWhenComplete();
				}
			}
		});
	});
}

$(document).ready(function () {
	

	$.post("/isinstalled.php", function (data) {
		if (data == "1") {
			window.location = "/";
		}else{
			$('.popup').attr('style', '');
			$('.overlay').animate({'background-color': 'rgba(68,68,68,0.5)'}, 2000);







			$('.okbutton').click(function(){
		switch ($('.popup').data('slide')) {
  		 case 1:
  		    $('.popuptext').html("Before continuing, ensure you have entered the database credentials into config.php first");
  		    $('.popup').data('slide', 2);
  		    break;
  		 case 2:
  		    $('.popuptext').html('<input type="text" class="newsubject namebox" id="passwordbox" placeholder="Name"></input><br><input type="text" class="newsubject emailbox" id="passwordbox" placeholder="Email"></input><br><input type="password" class="newsubject passbox" id="passwordbox" placeholder="Password"></input>');
  		    $(".passwordbox").keyup(function (e) {
				if (e.keyCode == 13) {
				$('.okbutton').click();
				}
			});
  		    $('.popup').data('slide', 3);
  		    break;
  		 case 3:
  		 	if($('.namebox').val() != "" && $('.passbox').val() != "" && $('.email').val() != ""){
  		 	$('.okbutton').attr('style', 'display: none !important;');
  		 	$('.popupSpinner').attr('style', 'display: block !important;');
  		 	
  		 	var password = CryptoJS.SHA256($('.passbox').val()).toString(CryptoJS.enc.Hex);
  		 	var name = $('.namebox').val();
  		 	var email = md5($('.emailbox').val());
  		 	$('.popuptext').html('Loading...');
  		    $.post("/installajax.php", {
				"password": password,
				"name": name,
				"email": email
			},
				function (data) {
					$('.okbutton').attr('style', 'display: block !important;');
					$('.popupSpinner').attr('style', 'display: none !important;');
  		 			
					console.log(data);
					if (data == "1") {
						$('.popuptext').html('Hydroelectric is installed!');
						$('.popup').data('slide', 4);
						
					}else{
						$('.popuptext').html('Database error, check your credentials');
						$('.popup').data('slide', 2);
					}
				});
  			}else{
  				$('.popuptext').html('Please fill in your details');
				$('.popup').data('slide', 2);
  			}
  		    break;
  		 case 4:
  		    	window.location = "/";
  		    break;

		}
});











		}
	});

	
});
        </script>
    </head>
    <body>
<table class="overlay">

            <tr>
                <td>
                    <div class="popup" data-slide="1" style="display: none !important;">
                        <span class="popuptext">Welcome to Hydroelectric</span><div id="floatingCirclesG" class="popupSpinner" style="display: none !important;">
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
                        <div class="button okbutton" style="display: block !important;">Continue</div>
                    </div>
                </td>
            </tr>

        </table>
    </body>
    </html>