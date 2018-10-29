
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
        <link href="./css/app.css" rel="stylesheet">
                    <link href="./css/app_ltr.css" rel="stylesheet">
                 
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


<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="css/menu.css" rel="stylesheet" type="text/css">


    <div class="row">
        <div class="col-md-12 text-left">

        <div class="mobile">
            
            <div class="header ">
            <h2><b>Join other drivers building the world's first dash cam sharing community</b></h2><img class="mobile-header" src="images/lander/header-image.png" data-video="https://www.youtube.com/embed/EFWYXdK1PC8">
            <div class="tube"></div>
            <p>The world’s first social network of dash cam drivers, sharing vital video evdence when and where it's needed</p>
            <div class="getinon animation">
            <div class="google">
            <p>Got a comroads<br> compatible dash-cam?</p><br>
            <a href="/go/lander"><img src="images/lander/google.png"></a><br>
            </div>
            <div class="google">
            <p>Don’t have <br> available dash-cam yet?</p><br>
            <a href="/dashcams"><img src="images/lander/get.png"></a>
            </div>
            </div>	<div class="main animation">
                <div class="animation">
                    <h1>How <font color="#00B2E3">Comroads Works</font></h1><span>1</span>
                    <p>Getting started with Comroads is easy. Download the app, then connect it to your car's dash ca, and away you go</p><img src="images/lander/HIxW1.png">
                    
                </div>
                <div class="animation">
                    <span>2</span>
                    <p>Start driving and Comroads automatically generates a route of your journey</p><img src="images/lander/HIW2.png">
                    
                </div>
                <div class="animation">
                    <span>3</span>
                    <p>If you want to report an incident, simply press the overlay button or press the location on place it happened on the map</p><img src="images/lander/HIW3.png">
                    
                </div>
                <div class="animation">
                    <span>4</span>
                    <p>If anyone else from the Comroads community were nearby when you genereted the event, we'll let you know and you'll be able to request their footage as well</p><img src="images/lander/HIW4.png">
                    
                </div>
            </div>
            </div>
            <div class="getinon animation">
            <div class="google">
            <p>Got a comroads<br> compatible dash-cam?</p><br>
            <a href="/go/lander"><img src="images/lander/google.png"></a><br>
            </div>
            <div class="google">
            <p>Don’t have <br> available dash-cam yet?</p><br>
            <a href="/dashcams"><img src="images/lander/get.png"></a>
            </div>
            </div>
            <div class="more ">
                <h2>More about comroads</h2>
                <div class="about">
                    <div class="animation">
                        <img src="images/lander/more1.png">
                        <p>Easily and quickly find footage from your dash cam, directly from the app and without the hassle of removing the memory card or manualy edeting video. Searching made sample - filter footage by time and location</p>
                    </div>
                    <div class="animation">
                        <img src="images/lander/more2.png">
                        <p>It’s never been easier to share footage with your friends. On the road safer driving See that realy happened on the road that day... Download the relevant footage segment to your phone with just one click</p>
                    </div><img src="images/lander/more3.png">
                    <p>Share your footage on your favorite social networks or Instant Messaging app With your permission,allow other comroads community members nearby to find and download your footage</p>
                </div>
                <div class="animation">
                    <img src="images/lander/more.png">
                    <p>Stay anonymous when getting, giving or sharing footage. Works automatically in the background whenever you enter the car</p>
                </div>
                <div class="animation">
                    <img src="images/lander/more5.png">
                    <p>Completely free, with unlimited cloud storage for your recordings</p>
                </div>
                <div class="animation">
                    <img src="images/lander/more6.png">
                    <p>Comroads removes audio from your videos before sharing, so conversations are never recorded</p>
                </div>
            </div>
            <div class="faq-section">
                <h1>Frequently Asked Questions</h1>
                <div class="faq-item">
                    <div class="faq-question">Do you support all dash cams?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer1">Unfortunately no. Over time we plan to support as many wifi-enabled dash cams as possible.
At the moment we support the YI smart dash cam (grey/gold), and the Viofo WR1 and A129 models, and we plan to add many more in the near future. 
If you’re a dash cam manufacturer and want to integrate with us, feel free to send us an email at contact@comroads.com
</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Does the Comroads app stay connected to the dash cam all the time?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer2">No, the app only connects to the camera via wifi when something needs to be done (like downloading an event video for example). At all other times we make sure to stay disconnected from the camera so you have internet connectivity for navigation, streaming and whatever else you would need.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Do you share these videos with the police or other authorities?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer3">No, we do not cooperate with any law enforcement or other government authorities, nor do we share any uploader information with any 3rd party. If a user wants to share their videos with local authorities, they are more than welcome to do so</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What is an “event video” and how are they generated?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer4">
                        An event video is a 30-second video clip which is pulled from the dash cam. There are a few ways in which this can be done:
                        <ol>
                            <li>Manual event generation by button, in-app or via overlay: download 30-second event video from dash cam to phone and then to the cloud.
                                In the future we plan to add activation via voice-command and dedicated Bluetooth button.</li>
                            <li>Manual event generation by pointing on a location on your journey map. After you complete a trip with the Comroads app running, you can just enter the map from the trips menu and touch a part of the map where you want video from. When you press the “Create new event” button, the app creates a new event and adds it the to queue. The next time you enter your car the app will automatically connect to your dash camera and download the video from that segment. You can create as many of these event videos as you like</li>
                            <li>Telematic event generation. In the app settings you can choose to enable automatic telematic event generation. This allows the app to generate and download events automatically based on detection of telematic instances using your phone’s sensors such as hard brakes, sudden hard acceleration (from being rear-ended  for example), sudden lane changes etc. The higher the level, the more sensitive the detection, so feel free to adjust according to your preferences.</li>
                            <li>Soon we will also add “protection mode”. In this mode, when a user creates an event, they will be able to request event videos from nearby users from the community (provided they have protection mode enabled in their app). These event videos will be generated automatically based on the proximity of the user and the probability that they were able to view the originating user’s event.</li>
                        </ol>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Are my conversations recorded by the Comroads app? <span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer5">Absolutely not. When you generate an event video, the app will automatically strip out an audio tracks from the video file before uploading them to the Comroads cloud.</div>
                </div>
            </div>
            <div class="get"> 
            <div class="google">
            <p>Got a comroads<br> compatible dash-cam?</p><br>
            <a href="/go/lander"><img src="images/lander/google.png"></a><br>
            </div>
            <div class="google">
            <p>Don’t have <br> available dash-cam yet?</p><br>
            <a href="/dashcams"><img src="images/lander/get.png"></a>
            </div>
            </div>
            <div class="privacy">
                <div class="animation">
                    <img src="images/lander/privacy1.png">
                    <h2>Be a Responsible driver</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                </div>
                <div class="animation">
                    <img src="images/lander/privacy2.png">
                    <h2>privacy</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                </div>
            </div>
            <div class="footer animation">
                <img src="images/lander/logofooter.png" style="margin-top:15vw;margin-bottom:10vw">
                <div class="getinon"><img src="images/lander/google.png"> <img src="images/lander/get.png"></div>
                <div class="buttonFooter"><a href="#">Home</a></div>
                <div class="buttonFooter"><a href="#">Gallery</a></div>
                <div class="buttonFooter"><a href="#">Upload</a></div>
                <div class="buttonFooter"><a href="#">About us</a></div>
                <div class="buttonFooter"><a href="#">Contact us</a></div>
                <div class="buttonFooter"><a href="#">FAQ</a></div>
                <p>© 2018 Comroads.com.<br>
                All rights reserved</p>
                <div class="social">
                    <a><img src="images/lander/vimeo.png"></a> <a><img src="images/lander/twitter.png"></a> <a><img src="images/lander/facebook.png"></a>
                </div>
            </div>
        </div>
        <div class="desktop">

            <div class="description-section">
                <div class="main-text">
                    <h1 class="blue-text main-text-margin">Join other drivers building the world's first dash cam sharing community</h1>
                    <div>The world's first social network of dash cam drivers, sharing vital video evidence when and where it's needed</div>
                    <div class="google-play-buttons">
                        <div class="google-play-button-set">
                            <span>Got a comroads compatible dash-cam?</span>
                            <a href="/go/lander" class="google-button google-play-button"></a>
                        </div>
                        <div class="google-play-button-set">
                            <span>Don't have available dash-cam yet?</span>
                            <a href="/dashcams" class="google-button google-play-get-expert-recommendations-button"></a>
                        </div>
                    </div>
                </div>
                    <div class="imgdiv">
                        <img class="header-image img-fluid" src="images/lander/header-image.png" data-video="https://www.youtube.com/embed/EFWYXdK1PC8">
                        <div class="tube"></div>
                        
                    </div>
                
            </div></div>
           <!-- <div class="video-section">
                <div class="video">
                    <div class="video-play-button"></div>
                </div>
                <div class="video-shadow"></div>
        </div>-->
            <div class="how-it-works-section">
                <h2>How <span class="blue-text">Comroads Works</span></h2>
                <div class="step">
                    <div class="step1-image"></div>
                    <div class="step-text">
                        <div class="step-number">1</div>
                        <div class="step-main-text">
                            Getting started with Comroads is easy. Download the app, then connect it to your car's dash cam, and away you go.
                        </div>
                        <div class="step-description">
                            
                        </div>
                    </div>
                </div>
                <div class="step">
                    <div class="step-text">
                        <div class="step-number">2</div>
                        <div class="step-main-text">
                            Start driving and Comroads automatically generates a route of your journey        
                        </div>
                        <div class="step-description">
                            
                        </div>
                    </div>
                    <div class="step2-image"></div>
                </div>
                <div class="step">
                    <div class="step3-image"></div>
                    <div class="step-text">
                        <div class="step-number">3</div>
                        <div class="step-main-text">
                            If you want to report an incident, simply press the overlay button or press the location on place it happened on the map!
                        </div>
                        <div class="step-description">
                            
                        </div>
                    </div>
                </div>
                <div class="step">
                    <div class="step-text">
                        <div class="step-number">4</div>
                        <div class="step-main-text">
                            If anyone else from the Comroads community were nearby when you generated the event, we'll let you know and you'll be able to request their footage as well
                        </div>
                        <div class="step-description">
                            
                        </div>
                    </div>
                    <div class="step4-image"></div>
                </div>
                <div class="google-play-buttons">
                    <div class="google-play-button-set">
                        <span>Got a comroads compatible dash-cam?</span>
                        <a href="/go/lander" class="google-button google-play-button"></a>
                    </div>
                    <div class="google-play-button-set">
                        <span>Don't have available dash-cam yet?</span>
                        <a href="/dashcams" class="google-button google-play-get-expert-recommendations-button"></a>
                    </div>
                </div>
            </div>
            <div class="sections-separator"></div>
            <div class="more-about-us-section">
                <h1>More About <span class="blue-text">Comroads...</span></h1>
                <div class="about-items">
                    <div class="about-items-row">
                        <div class="about-item">
                            <div class="about-item-image about-image-1"></div>
                            <div class="about-item-description">
                                Easily and quickly find footage from your dash cam, directly from the app and without the hassle of removing the memory card or manually editing video. Searching made simple – filter footage by time and location.
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-item-image about-image-2"></div>
                            <div class="about-item-description">
                                It's never been easier to share footage with your friends. On the road to safer driving See what really happened on the road that day… Download the relevant footage segment to your phone with just one click.    
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-item-image about-image-3"></div>
                            <div class="about-item-description">
                                Share your footage on your favourite social networks or Instant Messaging app With your permission, allow other Comroads community members nearby to find and download your footage    
                            </div>
                        </div>
                    </div>
                    <div class="about-items-separator"></div>
                    <div class="about-items-row">
                        <div class="about-item">
                            <div class="about-item-image about-image-4"></div>
                            <div class="about-item-description">
                                Stay anonymous when getting, giving or sharing footage. Works automatically in the background whenever you enter the car.    
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-item-image about-image-5"></div>
                            <div class="about-item-description">
                                Completely free, with unlimited cloud storage for your recordings    
                            </div>
                        </div>
                        <div class="about-item">
                            <div class="about-item-image about-image-6"></div>
                            <div class="about-item-description">
                                Comroads removes audio from your videos before sharing, so conversations are never recorded.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="what-they-say-about-comroads-section slides">
                <h1>What They Say About <span class="blue-text">Comroads...</span></h1>
                <div class="slider-set">
                    <div class="slider">
                        <div class="slider-button slider-left-button"></div>
                        <div class="slides">
                            <div class="quote">
                                <div class="quote-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                </div>
                                <div class="quote-author">
                                    Robert, New York 
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                </div>
                            </div>
                            <div class="quote">
                                <div class="quote-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                </div>
                                <div class="quote-author">
                                    Robert, New York 
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                    <span class="star-icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="slider-button slider-right-button"></div>
                    </div>-->
            </div>
        </div>
            <div class="faq-section">
                <h1>Frequently Asked Questions</h1>
                <div class="faq-item">
                    <div class="faq-question">Do you support all dash cams?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer6">Unfortunately no. Over time we plan to support as many wifi-enabled dash cams as possible.
At the moment we support the YI smart dash cam (grey/gold), and the Viofo WR1 and A129 models, and we plan to add many more in the near future. 
If you’re a dash cam manufacturer and want to integrate with us, feel free to send us an email at contact@comroads.com</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Does the Comroads app stay connected to the dash cam all the time?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer7">No, the app only connects to the camera via wifi when something needs to be done (like downloading an event video for example). At all other times we make sure to stay disconnected from the camera so you have internet connectivity for navigation, streaming and whatever else you would need.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Do you share these videos with the police or other authorities?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer8">No, we do not cooperate with any law enforcement or other government authorities, nor do we share any uploader information with any 3rd party. If a user wants to share their videos with local authorities, they are more than welcome to do so</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What is an “event video” and how are they generated?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer9">
                    An event video is a 30-second video clip which is pulled from the dash cam. There are a few ways in which this can be done:
                    <ol>
                        <li>Manual event generation by button, in-app or via overlay: download 30-second event video from dash cam to phone and then to the cloud.
                            In the future we plan to add activation via voice-command and dedicated Bluetooth button.</li>
                        <li>Manual event generation by pointing on a location on your journey map. After you complete a trip with the Comroads app running, you can just enter the map from the trips menu and touch a part of the map where you want video from. When you press the “Create new event” button, the app creates a new event and adds it the to queue. The next time you enter your car the app will automatically connect to your dash camera and download the video from that segment. You can create as many of these event videos as you like</li>
                        <li>Telematic event generation. In the app settings you can choose to enable automatic telematic event generation. This allows the app to generate and download events automatically based on detection of telematic instances using your phone’s sensors such as hard brakes, sudden hard acceleration (from being rear-ended  for example), sudden lane changes etc. The higher the level, the more sensitive the detection, so feel free to adjust according to your preferences.</li>
                        <li>Soon we will also add “protection mode”. In this mode, when a user creates an event, they will be able to request event videos from nearby users from the community (provided they have protection mode enabled in their app). These event videos will be generated automatically based on the proximity of the user and the probability that they were able to view the originating user’s event.</li>
                    </ol>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Are my conversations recorded by the Comroads app?<span class="faq-expand-icon"></span></div>
                    <div class="faq-answer" id="answer10">Absolutely not. When you generate an event video, the app will automatically strip out an audio tracks from the video file before uploading them to the Comroads cloud.</div>
                </div>
                <div class="google-play-buttons">
                    <div class="google-play-button-set">
                        <span>Got a comroads compatible dash-cam?</span>
                        <a href="/go/lander" class="google-button google-play-button"></a>
                    </div>
                    <div class="google-play-button-set">
                        <span>Don't have available dash-cam yet?</span>
                        <a href="/dashcams" class="google-button google-play-get-expert-recommendations-button"></a>
                    </div>
                </div>
            </div>
            <div class="privacy-section">
                <div class="privacy-section-item">
                    <div class="privacy-section-item-title"><span class="helm-icon"></span>Be a Responsibe Driver</div>
                    <div class="privacy-section-item-text">
                        <p>You're reading this, so you're probably a safe driver. Probably also you want to see the roads safer for everyone – drivers and pedestrians. So here's the thing: Making it happen relies on people like you joining Comroads now, before the launch.</p>
                        <p>Join now, get the app, and next time you drive you'll be part of the Comroads community. On a journey to protecting yourself and others. Plus you'll help improve the app by giving feedback about bugs, or features you'd like to see, and generating anonymous driving data. And when we say anonymous, it really is.</p>
                    </div>
                </div>
                <div class="privacy-section-item">
                    <div class="privacy-section-item-title"><span class="lock-icon"></span>Privacy and Anonymity</div>
                    <div class="privacy-section-item-text">
                        <p>Your data is yours, nobody else's. With Comroads you can sign up anonymously. That's right – no need to share your name, contact details, favourite TV show or any of that stuff. The only thing you might be asked for is your footage – in case another member needs it. How does that sound? Ready to join the world's first dash cam social community?</p>
                    </div>
                </div>
            </div>
            
        </div>
        <script src="js/siema.min.js" type="text/javascript"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="./js/menu.js" type="text/javascript"></script>-->
        <script src="./js/lander.js" type="text/javascript"></script>





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
                                    <option
                        value="AF"
                        
                    >Afghanistan</option>
                                    <option
                        value="AX"
                        
                    >Aland Islands</option>
                                    <option
                        value="AL"
                        
                    >Albania</option>
                                    <option
                        value="DZ"
                        
                    >Algeria</option>
                                    <option
                        value="AS"
                        
                    >American Samoa</option>
                                    <option
                        value="AD"
                        
                    >Andorra</option>
                                    <option
                        value="AO"
                        
                    >Angola</option>
                                    <option
                        value="AI"
                        
                    >Anguilla</option>
                                    <option
                        value="A1"
                        
                    >Anonymous Proxy</option>
                                    <option
                        value="AQ"
                        
                    >Antarctica</option>
                                    <option
                        value="AG"
                        
                    >Antigua and Barbuda</option>
                                    <option
                        value="AR"
                        
                    >Argentina</option>
                                    <option
                        value="AM"
                        
                    >Armenia</option>
                                    <option
                        value="AW"
                        
                    >Aruba</option>
                                    <option
                        value="AP"
                        
                    >Asia/Pacific Region</option>
                                    <option
                        value="AU"
                        
                    >Australia</option>
                                    <option
                        value="AT"
                        
                    >Austria</option>
                                    <option
                        value="AZ"
                        
                    >Azerbaijan</option>
                                    <option
                        value="BS"
                        
                    >Bahamas</option>
                                    <option
                        value="BH"
                        
                    >Bahrain</option>
                                    <option
                        value="BD"
                        
                    >Bangladesh</option>
                                    <option
                        value="BB"
                        
                    >Barbados</option>
                                    <option
                        value="BY"
                        
                    >Belarus</option>
                                    <option
                        value="BE"
                        
                    >Belgium</option>
                                    <option
                        value="BZ"
                        
                    >Belize</option>
                                    <option
                        value="BJ"
                        
                    >Benin</option>
                                    <option
                        value="BM"
                        
                    >Bermuda</option>
                                    <option
                        value="BT"
                        
                    >Bhutan</option>
                                    <option
                        value="BO"
                        
                    >Bolivia</option>
                                    <option
                        value="BQ"
                        
                    >Bonaire, Saint Eustatius and Saba</option>
                                    <option
                        value="BA"
                        
                    >Bosnia and Herzegovina</option>
                                    <option
                        value="BW"
                        
                    >Botswana</option>
                                    <option
                        value="BV"
                        
                    >Bouvet Island</option>
                                    <option
                        value="BR"
                        
                    >Brazil</option>
                                    <option
                        value="IO"
                        
                    >British Indian Ocean Territory</option>
                                    <option
                        value="BN"
                        
                    >Brunei Darussalam</option>
                                    <option
                        value="BG"
                        
                    >Bulgaria</option>
                                    <option
                        value="BF"
                        
                    >Burkina Faso</option>
                                    <option
                        value="BI"
                        
                    >Burundi</option>
                                    <option
                        value="KH"
                        
                    >Cambodia</option>
                                    <option
                        value="CM"
                        
                    >Cameroon</option>
                                    <option
                        value="CA"
                        
                    >Canada</option>
                                    <option
                        value="CV"
                        
                    >Cape Verde</option>
                                    <option
                        value="KY"
                        
                    >Cayman Islands</option>
                                    <option
                        value="CF"
                        
                    >Central African Republic</option>
                                    <option
                        value="TD"
                        
                    >Chad</option>
                                    <option
                        value="CL"
                        
                    >Chile</option>
                                    <option
                        value="CN"
                        
                    >China</option>
                                    <option
                        value="CX"
                        
                    >Christmas Island</option>
                                    <option
                        value="CC"
                        
                    >Cocos (Keeling) Islands</option>
                                    <option
                        value="CO"
                        
                    >Colombia</option>
                                    <option
                        value="KM"
                        
                    >Comoros</option>
                                    <option
                        value="CG"
                        
                    >Congo</option>
                                    <option
                        value="CD"
                        
                    >Congo, The Democratic Republic of the</option>
                                    <option
                        value="CK"
                        
                    >Cook Islands</option>
                                    <option
                        value="CR"
                        
                    >Costa Rica</option>
                                    <option
                        value="CI"
                        
                    >Cote D&#039;Ivoire</option>
                                    <option
                        value="HR"
                        
                    >Croatia</option>
                                    <option
                        value="CU"
                        
                    >Cuba</option>
                                    <option
                        value="CW"
                        
                    >Curacao</option>
                                    <option
                        value="CY"
                        
                    >Cyprus</option>
                                    <option
                        value="CZ"
                        
                    >Czech Republic</option>
                                    <option
                        value="DK"
                        
                    >Denmark</option>
                                    <option
                        value="DJ"
                        
                    >Djibouti</option>
                                    <option
                        value="DM"
                        
                    >Dominica</option>
                                    <option
                        value="DO"
                        
                    >Dominican Republic</option>
                                    <option
                        value="EC"
                        
                    >Ecuador</option>
                                    <option
                        value="EG"
                        
                    >Egypt</option>
                                    <option
                        value="SV"
                        
                    >El Salvador</option>
                                    <option
                        value="GQ"
                        
                    >Equatorial Guinea</option>
                                    <option
                        value="ER"
                        
                    >Eritrea</option>
                                    <option
                        value="EE"
                        
                    >Estonia</option>
                                    <option
                        value="ET"
                        
                    >Ethiopia</option>
                                    <option
                        value="EU"
                        
                    >Europe</option>
                                    <option
                        value="FK"
                        
                    >Falkland Islands (Malvinas)</option>
                                    <option
                        value="FO"
                        
                    >Faroe Islands</option>
                                    <option
                        value="FJ"
                        
                    >Fiji</option>
                                    <option
                        value="FI"
                        
                    >Finland</option>
                                    <option
                        value="FR"
                        
                    >France</option>
                                    <option
                        value="GF"
                        
                    >French Guiana</option>
                                    <option
                        value="PF"
                        
                    >French Polynesia</option>
                                    <option
                        value="TF"
                        
                    >French Southern Territories</option>
                                    <option
                        value="GA"
                        
                    >Gabon</option>
                                    <option
                        value="GM"
                        
                    >Gambia</option>
                                    <option
                        value="GE"
                        
                    >Georgia</option>
                                    <option
                        value="DE"
                        
                    >Germany</option>
                                    <option
                        value="GH"
                        
                    >Ghana</option>
                                    <option
                        value="GI"
                        
                    >Gibraltar</option>
                                    <option
                        value="GR"
                        
                    >Greece</option>
                                    <option
                        value="GL"
                        
                    >Greenland</option>
                                    <option
                        value="GD"
                        
                    >Grenada</option>
                                    <option
                        value="GP"
                        
                    >Guadeloupe</option>
                                    <option
                        value="GU"
                        
                    >Guam</option>
                                    <option
                        value="GT"
                        
                    >Guatemala</option>
                                    <option
                        value="GG"
                        
                    >Guernsey</option>
                                    <option
                        value="GN"
                        
                    >Guinea</option>
                                    <option
                        value="GW"
                        
                    >Guinea-Bissau</option>
                                    <option
                        value="GY"
                        
                    >Guyana</option>
                                    <option
                        value="HT"
                        
                    >Haiti</option>
                                    <option
                        value="HM"
                        
                    >Heard Island and McDonald Islands</option>
                                    <option
                        value="VA"
                        
                    >Holy See (Vatican City State)</option>
                                    <option
                        value="HN"
                        
                    >Honduras</option>
                                    <option
                        value="HK"
                        
                    >Hong Kong</option>
                                    <option
                        value="HU"
                        
                    >Hungary</option>
                                    <option
                        value="IS"
                        
                    >Iceland</option>
                                    <option
                        value="IN"
                        
                    >India</option>
                                    <option
                        value="ID"
                        
                    >Indonesia</option>
                                    <option
                        value="IR"
                        
                    >Iran, Islamic Republic of</option>
                                    <option
                        value="IQ"
                        
                    >Iraq</option>
                                    <option
                        value="IE"
                        
                    >Ireland</option>
                                    <option
                        value="IM"
                        
                    >Isle of Man</option>
                                    <option
                        value="IL"
                        selected
                    >Israel</option>
                                    <option
                        value="IT"
                        
                    >Italy</option>
                                    <option
                        value="JM"
                        
                    >Jamaica</option>
                                    <option
                        value="JP"
                        
                    >Japan</option>
                                    <option
                        value="JE"
                        
                    >Jersey</option>
                                    <option
                        value="JO"
                        
                    >Jordan</option>
                                    <option
                        value="KZ"
                        
                    >Kazakhstan</option>
                                    <option
                        value="KE"
                        
                    >Kenya</option>
                                    <option
                        value="KI"
                        
                    >Kiribati</option>
                                    <option
                        value="KP"
                        
                    >Korea, Democratic People&#039;s Republic of</option>
                                    <option
                        value="KR"
                        
                    >Korea, Republic of</option>
                                    <option
                        value="KW"
                        
                    >Kuwait</option>
                                    <option
                        value="KG"
                        
                    >Kyrgyzstan</option>
                                    <option
                        value="LA"
                        
                    >Lao People&#039;s Democratic Republic</option>
                                    <option
                        value="LV"
                        
                    >Latvia</option>
                                    <option
                        value="LB"
                        
                    >Lebanon</option>
                                    <option
                        value="LS"
                        
                    >Lesotho</option>
                                    <option
                        value="LR"
                        
                    >Liberia</option>
                                    <option
                        value="LY"
                        
                    >Libya</option>
                                    <option
                        value="LI"
                        
                    >Liechtenstein</option>
                                    <option
                        value="LT"
                        
                    >Lithuania</option>
                                    <option
                        value="LU"
                        
                    >Luxembourg</option>
                                    <option
                        value="MO"
                        
                    >Macau</option>
                                    <option
                        value="MK"
                        
                    >Macedonia</option>
                                    <option
                        value="MG"
                        
                    >Madagascar</option>
                                    <option
                        value="MW"
                        
                    >Malawi</option>
                                    <option
                        value="MY"
                        
                    >Malaysia</option>
                                    <option
                        value="MV"
                        
                    >Maldives</option>
                                    <option
                        value="ML"
                        
                    >Mali</option>
                                    <option
                        value="MT"
                        
                    >Malta</option>
                                    <option
                        value="MH"
                        
                    >Marshall Islands</option>
                                    <option
                        value="MQ"
                        
                    >Martinique</option>
                                    <option
                        value="MR"
                        
                    >Mauritania</option>
                                    <option
                        value="MU"
                        
                    >Mauritius</option>
                                    <option
                        value="YT"
                        
                    >Mayotte</option>
                                    <option
                        value="MX"
                        
                    >Mexico</option>
                                    <option
                        value="FM"
                        
                    >Micronesia, Federated States of</option>
                                    <option
                        value="MD"
                        
                    >Moldova, Republic of</option>
                                    <option
                        value="MC"
                        
                    >Monaco</option>
                                    <option
                        value="MN"
                        
                    >Mongolia</option>
                                    <option
                        value="ME"
                        
                    >Montenegro</option>
                                    <option
                        value="MS"
                        
                    >Montserrat</option>
                                    <option
                        value="MA"
                        
                    >Morocco</option>
                                    <option
                        value="MZ"
                        
                    >Mozambique</option>
                                    <option
                        value="MM"
                        
                    >Myanmar</option>
                                    <option
                        value="NA"
                        
                    >Namibia</option>
                                    <option
                        value="NR"
                        
                    >Nauru</option>
                                    <option
                        value="NP"
                        
                    >Nepal</option>
                                    <option
                        value="NL"
                        
                    >Netherlands</option>
                                    <option
                        value="NC"
                        
                    >New Caledonia</option>
                                    <option
                        value="NZ"
                        
                    >New Zealand</option>
                                    <option
                        value="NI"
                        
                    >Nicaragua</option>
                                    <option
                        value="NE"
                        
                    >Niger</option>
                                    <option
                        value="NG"
                        
                    >Nigeria</option>
                                    <option
                        value="NU"
                        
                    >Niue</option>
                                    <option
                        value="NF"
                        
                    >Norfolk Island</option>
                                    <option
                        value="MP"
                        
                    >Northern Mariana Islands</option>
                                    <option
                        value="NO"
                        
                    >Norway</option>
                                    <option
                        value="OM"
                        
                    >Oman</option>
                                    <option
                        value="PK"
                        
                    >Pakistan</option>
                                    <option
                        value="PW"
                        
                    >Palau</option>
                                    <option
                        value="PS"
                        
                    >Palestinian Territory</option>
                                    <option
                        value="PA"
                        
                    >Panama</option>
                                    <option
                        value="PG"
                        
                    >Papua New Guinea</option>
                                    <option
                        value="PY"
                        
                    >Paraguay</option>
                                    <option
                        value="PE"
                        
                    >Peru</option>
                                    <option
                        value="PH"
                        
                    >Philippines</option>
                                    <option
                        value="PN"
                        
                    >Pitcairn Islands</option>
                                    <option
                        value="PL"
                        
                    >Poland</option>
                                    <option
                        value="PT"
                        
                    >Portugal</option>
                                    <option
                        value="PR"
                        
                    >Puerto Rico</option>
                                    <option
                        value="QA"
                        
                    >Qatar</option>
                                    <option
                        value="RE"
                        
                    >Reunion</option>
                                    <option
                        value="RO"
                        
                    >Romania</option>
                                    <option
                        value="RU"
                        
                    >Russian Federation</option>
                                    <option
                        value="RW"
                        
                    >Rwanda</option>
                                    <option
                        value="BL"
                        
                    >Saint Barthelemy</option>
                                    <option
                        value="SH"
                        
                    >Saint Helena</option>
                                    <option
                        value="KN"
                        
                    >Saint Kitts and Nevis</option>
                                    <option
                        value="LC"
                        
                    >Saint Lucia</option>
                                    <option
                        value="MF"
                        
                    >Saint Martin</option>
                                    <option
                        value="PM"
                        
                    >Saint Pierre and Miquelon</option>
                                    <option
                        value="VC"
                        
                    >Saint Vincent and the Grenadines</option>
                                    <option
                        value="WS"
                        
                    >Samoa</option>
                                    <option
                        value="SM"
                        
                    >San Marino</option>
                                    <option
                        value="ST"
                        
                    >Sao Tome and Principe</option>
                                    <option
                        value="A2"
                        
                    >Satellite Provider</option>
                                    <option
                        value="SA"
                        
                    >Saudi Arabia</option>
                                    <option
                        value="SN"
                        
                    >Senegal</option>
                                    <option
                        value="RS"
                        
                    >Serbia</option>
                                    <option
                        value="SC"
                        
                    >Seychelles</option>
                                    <option
                        value="SL"
                        
                    >Sierra Leone</option>
                                    <option
                        value="SG"
                        
                    >Singapore</option>
                                    <option
                        value="SX"
                        
                    >Sint Maarten (Dutch part)</option>
                                    <option
                        value="SK"
                        
                    >Slovakia</option>
                                    <option
                        value="SI"
                        
                    >Slovenia</option>
                                    <option
                        value="SB"
                        
                    >Solomon Islands</option>
                                    <option
                        value="SO"
                        
                    >Somalia</option>
                                    <option
                        value="ZA"
                        
                    >South Africa</option>
                                    <option
                        value="GS"
                        
                    >South Georgia and the South Sandwich Islands</option>
                                    <option
                        value="ES"
                        
                    >Spain</option>
                                    <option
                        value="LK"
                        
                    >Sri Lanka</option>
                                    <option
                        value="SD"
                        
                    >Sudan</option>
                                    <option
                        value="SR"
                        
                    >Suriname</option>
                                    <option
                        value="SJ"
                        
                    >Svalbard and Jan Mayen</option>
                                    <option
                        value="SZ"
                        
                    >Swaziland</option>
                                    <option
                        value="SE"
                        
                    >Sweden</option>
                                    <option
                        value="CH"
                        
                    >Switzerland</option>
                                    <option
                        value="SY"
                        
                    >Syrian Arab Republic</option>
                                    <option
                        value="TW"
                        
                    >Taiwan</option>
                                    <option
                        value="TJ"
                        
                    >Tajikistan</option>
                                    <option
                        value="TZ"
                        
                    >Tanzania, United Republic of</option>
                                    <option
                        value="TH"
                        
                    >Thailand</option>
                                    <option
                        value="TL"
                        
                    >Timor-Leste</option>
                                    <option
                        value="TG"
                        
                    >Togo</option>
                                    <option
                        value="TK"
                        
                    >Tokelau</option>
                                    <option
                        value="TO"
                        
                    >Tonga</option>
                                    <option
                        value="TT"
                        
                    >Trinidad and Tobago</option>
                                    <option
                        value="TN"
                        
                    >Tunisia</option>
                                    <option
                        value="TR"
                        
                    >Turkey</option>
                                    <option
                        value="TM"
                        
                    >Turkmenistan</option>
                                    <option
                        value="TC"
                        
                    >Turks and Caicos Islands</option>
                                    <option
                        value="TV"
                        
                    >Tuvalu</option>
                                    <option
                        value="UG"
                        
                    >Uganda</option>
                                    <option
                        value="UA"
                        
                    >Ukraine</option>
                                    <option
                        value="AE"
                        
                    >United Arab Emirates</option>
                                    <option
                        value="GB"
                        
                    >United Kingdom</option>
                                    <option
                        value="US"
                        
                    >United States</option>
                                    <option
                        value="UM"
                        
                    >United States Minor Outlying Islands</option>
                                    <option
                        value="UY"
                        
                    >Uruguay</option>
                                    <option
                        value="UZ"
                        
                    >Uzbekistan</option>
                                    <option
                        value="VU"
                        
                    >Vanuatu</option>
                                    <option
                        value="VE"
                        
                    >Venezuela</option>
                                    <option
                        value="VN"
                        
                    >Vietnam</option>
                                    <option
                        value="VG"
                        
                    >Virgin Islands, British</option>
                                    <option
                        value="VI"
                        
                    >Virgin Islands, U.S.</option>
                                    <option
                        value="WF"
                        
                    >Wallis and Futuna</option>
                                    <option
                        value="EH"
                        
                    >Western Sahara</option>
                                    <option
                        value="YE"
                        
                    >Yemen</option>
                                    <option
                        value="ZM"
                        
                    >Zambia</option>
                                    <option
                        value="ZW"
                        
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


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73114398-1', 'auto');
  ga('send', 'pageview');
</script>
                    
        <script type="text/javascript">
        // <![CDATA[
        var google_conversion_id = 955347249;
        var google_conversion_label = "L68eCKDSjmkQseLFxwM";
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        // ]]>
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/955347249/?value=1.00&amp;currency_code=USD&amp;label=L68eCKDSjmkQseLFxwM&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>
	<!-- Crazyegg -->
	<script type="text/javascript">
		setTimeout(function(){var a=document.createElement("script");
		var b=document.getElementsByTagName("script")[0];
		a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0027/5283.js?"+Math.floor(new Date().getTime()/3600000);
		a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	</script>
	<!-- Crazyegg -->
	<script type="text/javascript">
		setTimeout(function(){var a=document.createElement("script");
		var b=document.getElementsByTagName("script")[0];
		a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0027/5283.js?"+Math.floor(new Date().getTime()/3600000);
		a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	</script>
    <script>setInterval(function(){var e=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject('Microsoft.XMLHTTP');e.open('GET','http://il.comroads.com/genealabs/laravel-caffeine/drip',!0);e.setRequestHeader('X-Requested-With','XMLHttpRequest');e.send();}, 300000);</script></body>
</html>
