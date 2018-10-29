
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="
כל הזמן פונים אלינו ומבקשים מאתנו המלצות לגבי מצלמות רכב, אז החלטנו לרכז עבורכם מ...">
        <meta name="author" content="comroads.com">
        
        <link rel="icon" href="http://jspl.comroads.com/images/favicon.ico">
        <title>מצלמות רכב - סרטוני מצלמת רכב בדרכים</title>
        <link href="css/app.css" rel="stylesheet">
                    <link href="css/app_ltr.css" rel="stylesheet">
                 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script type="text/javascript">
            var interval = null;
            var counterInterval = null;
            function refreshIt(element, seconds)
            {
                var timeout = seconds * 1000;

                interval = setInterval(function () { changeSrc(element) }, timeout);
                counterInterval = setInterval(function () {
                    refreshCounter(seconds);
                }, 1000);
            }

            function changeSrc(element)
            {
                var $this = $(element);
                var src = $this.attr('src').split('?')[0] + '?' + new Date().getTime();

                $this.attr('src', src);
                console.log(src);

                clearInterval(interval);
            }

            function refreshCounter(seconds)
            {
                var counter = parseInt($('#refresh-counter').html());

                if (counter == 0) {
                    counter = seconds + 1;
                    clearInterval(counterInterval);
                }

                $('#refresh-counter').html(counter - 1);

            }
        </script>
        
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-6372912809903417",
            enable_page_level_ads: true
          });
        </script>
    </head>
    <body class="" id="pjax-container">
                                    <div class="Header">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12 logo-cont text-left">
                <a href="http://il.comroads.com">
                    <img src="http://jspl.comroads.com/images/logo.png">
                                    </a>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
                <ul class="Header__Menu">
                    <li>
                        <div class="dropdown">
                            <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down fa-lg"></i></a>
                            <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                                                    <li>
                                        <a href="//www.comroads.com/dashcams">
                                            EN <i class="flag-icon flag-icon-gb"></i>
                                        </a>
                                    </li>
                                                                    <li>
                                        <a href="//ru.comroads.com/dashcams">
                                            RU <i class="flag-icon flag-icon-ru"></i>
                                        </a>
                                    </li>
                                                                    <li>
                                        <a href="//ro.comroads.com/dashcams">
                                            RO <i class="flag-icon flag-icon-ro"></i>
                                        </a>
                                    </li>
                                                                    <li>
                                        <a href="//ar.comroads.com/dashcams">
                                            AR <i class="flag-icon flag-icon-sa"></i>
                                        </a>
                                    </li>
                                                            </ul>
                            <i class="flag-icon flag-icon-il"></i>
                            <span>:שפה</span>
                        </div>
                    </li>
                                                                        <li><a data-toggle="modal" data-target="#loginModal" data-backdrop="static">כניסה למערכת</a></li>
                                                                            <li><a data-toggle="modal" data-target="#signUpModal" data-backdrop="static">הרשמה</a></li>
                                                            </ul>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-default navbar-static-top Main__Menu">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://il.comroads.com">Comroads</a>
        </div>
        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav">
                <li><a href="http://il.comroads.com">דף הבית</a></li>
                <li><a href="http://il.comroads.com/upload/video">העלאה</a></li>
                <li><a href="http://il.comroads.com/about-us">אודותנו</a></li>
                <li><a href="http://il.comroads.com/contact-us">צור קשר</a></li>
                <li><a href="http://il.comroads.com/faq">שאלות נפוצות</a></li>
                <li><a href="http://il.comroads.com/blog">בלוג</a></li>
                            </ul>
            <ul class="nav navbar-nav navbar-right navbar-social">
                                <li><a href="https://www.facebook.com/comroads.il" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                <li><a href="https://twitter.com/Comroads_Global" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
                <li><a href=""><i class="fa fa-vimeo-square"></i></a></li>
            </ul>
        </div>
    </div>
</nav>

                                <div class="container">
        <div class="row">
            <div class="dashcam-compare text-left">


<link href="css/dashcams.css" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/slick.css">
	<link rel="stylesheet" type="text/css" href="css/slick-theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- Main part -->
	<main>
		<div class="container">

			<!-- Title -->
			<div class="row">
				<div class="col-md-12">
					<h1>Viofo WR1 Review</h1>
				</div>
			</div>

			<!-- Review -->
			<div class="review">
				<div class="top-rated-banner">
					<img src="images/dashcams/top-rated-banner.png" alt="top-rated-banner">
				</div>
				<div class="row">
					<div class="col-md-12">
						<img src="images/dashcams/viofo-a129-header.png" alt="cameras-img" class="img-responsive ma">
						<p>Viofo is today one of the world's leading dash cam brands, focusing on high quality devices with great support. Dual dash cams, especially those with good wifi, are hard to come by. Those that are available today are usually VERY expensive, at the $300+ mark. Viofo's breakthrough A129 model has changed that and offers, what coud be considered the near ultimate dash cam, at a very reasonable price.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title mb">
							<h4><img src="images/dashcams/info-icon.png" alt="info-icon">Specifications</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Novatek 96663 chipset)</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Sony Starvis sensor (both front and rear)</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>140 degree lens</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Resolution: 1920x1080 30fps both front and rear (60fps if only front is used)</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Supports SD cards up to 256GB</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Dual band 2.4Ghz and 5Ghz WIFI</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Includes a capacitor, not a lithium battery</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="white-box">
							<p>Quick release mount with GPS</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/camera-icon.png" alt="camera-icon.png">Design</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>Much like many of Viofo's previous popular dashcams, the A129 has a very discrete, wedge build. As you can see in the picture below, it blends in very well in the car, unlike other box-shaped non-black dash cams. The camera also has a nice screen, which helps with the intial alignment. The camera mount uses very strong 3M glue which holds the A129 very firmly in place. The camera itself is however easily detatcheable so you can remove it if you need to.</p>
						<img src="images/dashcams/viofo-a129-dashboard.png" alt="car-with-camera-photo" class="img-responsive ma">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/package-icon.png" alt="package-icon">What's in the box?</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">

						<!-- Slider -->
						<section class="single-item slider">
							<div>
								<img src="images/dashcams/viofo-a129-unboxing.png" class="img-responsive ma">
							</div>
						</section>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/support-icon.png" alt="support-icon">Comroads app support</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
                        <p>The Comroads app fully supports the Viofo A129 dashcam. However, right now, we appeared to have a few issues when the 2.4Ghz wifi was enabled. After switching to 5Ghz, everything worked perfectly. We hope this issue will be rectified by Viofo with future firmware upgrades.</p>
                        <p>Keep in mind, that the Comroads app currently only downloads the videos from the front camera. In the future we'll add support also for the rear.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/camera-icon.png" alt="camera-icon">Daytime video</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>The Viofo A129 produces excellent daytime images. The video is very clear and sharp. License plates are clearly visible even while moving./p>
                        <video class="vid-border img-responsive ma" width="70%"  controls>
                            <source src="http://s31.comroads.com/comroads01/dashcam-review/viofo-wr1-day.MOV" type="video/mp4">
                        </video>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/camera-icon.png" alt="camera-icon">Twilight video</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>Evening, or twilight videos are important because they are an intermediate state between day and night when there is less light but is not quite dark. The A129 does not disappoint and still manages to perform very well. While there is of course a reduction in quality, the A129's large aperature means it can still product great images even at low light.</p>
                        <video class="vid-border img-responsive ma" width="70%"  controls>
                            <source src="http://s31.comroads.com/comroads01/dashcam-review/viofo-wr1-evening.MOV" type="video/mp4">
                        </video>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/camera-icon.png" alt="camera-icon">Night video</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>Good quality night video is a rare occurance with dash cams. This is one of the points where the A129 shines and is in quality comparable with much more expensive cameras. The Sony sensor with a large aperature allows good exposure even at low light conditions, resulting in great night time image</p>
                        <video class="vid-border img-responsive ma" width="70%"  controls>
                            <source src="http://s31.comroads.com/comroads01/dashcam-review/viofo-wr1-night.MOV" type="video/mp4">
                        </video>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="blue-title">
							<h4><img src="images/dashcams/conclusion-icon.png" alt="conclusion-icon">Summary</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>If the A129 is within your budget, this is argueably one of the best dash cams on the market today. With excellent build quality, a discrete design, great image quality, and very fast WIFI, this dual camera dash cam great at this price point. Keep in mind that Viofo has announced that they will be releasing an IR addon to the camera soon which will make the second camera very useful for rideshare drivers as they can face it into the cabin.</p>
					</div>
				</div>
				<hr>
				<h5>BUY NOW</h5>
				<div class="row">
					<div class="col-md-12 tac">
                    <?php 
                        $obj = json_decode(file_get_contents('content/prices-heb.json'));
                        foreach($obj->viofo_a129 as $key => $value)
                        {
                            echo '<a href="/go/' . $value->link . '" target="_blank"><div class="buy-now-item"><img src="images/' . $key . '-icon.png"/>';
                            echo '<p>' . $value->price->price . '</p></div></a>';
                            echo "</tr>";
                        }   
                    ?>
                    </div>
				</div>
			</div>
		</div>
	</main>
    <!-- Main part end -->
</table>
    
    </div>
</div>


        </div>
    </div> 

    




    



                    <footer>
    <div class="container text-center">
        <ul class="nav">
            <li><a href="http://il.comroads.com/about-us">אודותנו</a></li>
            <li><a href="http://il.comroads.com/contact-us">צור קשר</a></li>
            <li><a href="http://il.comroads.com/terms-and-conditions">תנאי שימוש</a></li>
            <li><a href="http://il.comroads.com/uploading-guidelines">הנחיות להעלאה</a></li>
                        <li><a href="http://il.comroads.com/explainervideo">סרטון הסבר</a></li>
                    </ul><br/>
        <ul class="nav with-padding-li">
            <li>&copy; 2018</li>
            <li>Comroads.com</li>
            <li>כל הזכויות שמורות</li>            
        </ul>
    </div>
</footer>            <script type="text/javascript">
                var global_js_vars = {
                    cancelButtonText: "ביטול",
                    player: "flowplayer",
                };
            </script>
                        <div id="appJsContainer">
                <script type="text/javascript" src="http://jspl.comroads.com/build/js/app-2a6f63d6a8.js" class="reloadable"></script>
            </div>
                    
        
                        
                                    <div class="modal fade" id="signUpModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                
            </div>
            <div class="modal-body">
                <h4 class="Content__Heading text-center"><span>Create a free account</span></h4>
                <div class="form-group clearfix">
    <div class="text-center col-md-8 col-md-offset-2">
        <h5 >הרשמה מהירה בעזרת חשבון חברתי</h5>
        <div>
            <a href="http://il.comroads.com/auth/facebook"><i class="fa fa-facebook-square facebook fa-5x"></i></a>&nbsp;&nbsp;
            <a href="http://il.comroads.com/auth/twitter"><i class="fa fa-twitter-square twitter fa-5x"></i></a>&nbsp;&nbsp;
                        <a href="http://il.comroads.com/auth/google"><i class="fa fa-google-plus-square google fa-5x"></i></a>
        </div>
    </div>
</div>

<h5 ><span>או הרשמה בעזרת כתובת מייל</span></h5><br/>



<form action="http://il.comroads.com/signup" method="post" class="form-horizontal gutter-5 registration-form">
    <input type="hidden" name="_token" value="ZFaFfFTrP8glfsvJyqG0M3h5XjVBmcddLDxVqUxr">

    
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">שם משתמש <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="username" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mail <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="email" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">סיסמה <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="password" name="password" value="" class="form-control" placeholder="">
        </div>
    </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Country <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <select name="country_code" class="form-control chosen-select" data-placeholder="בחר/י מדינה">
                <option></option>
                    >Zimbabwe</option>
                            </select>
        </div>
    </div>

            <div class="form-group">
        <div >
            <button type="submit" class="btn btn-primary btn-rounded">Complete Registration</button>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center col-md-8 col-md-offset-2">
            <p>Have an account?</p>
            <a href="http://il.comroads.com/login" class="btn btn-primary btn-rounded">&nbsp;&nbsp;כניסה למערכת&nbsp;&nbsp;</a>
        </div>
    </div>
</form>            </div>            
        </div>
    </div>
</div>            
                            <div class="modal fade" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                
            </div>
            <div class="modal-body">
                <h4 class="Content__Heading text-center"><span>Login</span></h4>
                <div class="alert alert-info text-center hidden"></div>

<form action="http://il.comroads.com/login" method="post" class="form-horizontal gutter-5 login-form">
    <input type="hidden" name="_token" value="ZFaFfFTrP8glfsvJyqG0M3h5XjVBmcddLDxVqUxr">

    <input type="hidden" name="birth_day" value="" id="birthDay">

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">שם משתמש</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="username" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">סיסמה</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="password" name="password" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="checkbox no-padding">
                        <label>
                            <input type="checkbox" name="remember" >
                            זכור אותי
                        </label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                    <a href="http://il.comroads.com/password/email">שכחתי סיסמה?</a>
                </div>
            </div>
        </div>
    </div>
        <div class="form-group">
        <div class="text-center col-md-8 col-md-offset-2">
            <button type="submit" class="btn btn-primary btn-rounded">&nbsp;&nbsp;&nbsp;כניסה למערכת&nbsp;&nbsp;&nbsp;</button>
        </div>
    </div>
    <div class="form-group">
    <div class="text-center col-md-8 col-md-offset-2">
        <h4 class="Content__Heading text-center"><span>או כניסה למערכת באמצעות</span></h4>
        <div class="Social__Login">
            <a href="http://il.comroads.com/auth/facebook"><i class="fa fa-facebook-square facebook"></i></a>
            <a href="http://il.comroads.com/auth/twitter"><i class="fa fa-twitter-square twitter"></i></a>
                        <a href="http://il.comroads.com/auth/google"><i class="fa fa-google-plus-square google"></i></a>
        </div>
    </div>
</div>    <div class="form-group">
        <div class="text-center col-md-8 col-md-offset-2">
            <p>אין לי חשבון?</p>
            <a href="http://il.comroads.com/signup" class="btn btn-primary btn-rounded">הרשמה</a>
        </div>
    </div>
</form>            </div>            
        </div>
    </div>
</div>            
                    

                    <script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//comroads.com/pk/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//comroads.com/pk/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>        

<script type="text/javascript">
    var _mfq = _mfq || [];
    (function () {
    var mf = document.createElement("script"); mf.type = "text/javascript"; mf.async = true;
    mf.src = "//cdn.mouseflow.com/projects/2fbcc7ee-556b-4dfd-9e01-f2ea636456d4.js";
    document.getElementsByTagName("head")[0].appendChild(mf);
  })();
</script>


    <script>setInterval(function(){var e=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject('Microsoft.XMLHTTP');e.open('GET','http://il.comroads.com/genealabs/laravel-caffeine/drip',!0);e.setRequestHeader('X-Requested-With','XMLHttpRequest');e.send();}, 300000);</script></body>
</html>
