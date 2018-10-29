@extends('layouts.master')

@section('title', trans('pages.dashcams_title'))
@section('description', substr(strip_tags_content(trans('pages.dashcams_body')), 0, 150) . '...')

<meta property="og:title" content="Comroads - The world's first dashcam sharing community"/>
<meta property="og:image" content=""/>
<meta property="og:description" content="Join other drivers building the world's first dashcam sharing community"/>


@section('content')
<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="css/menu.css" rel="stylesheet" type="text/css">


    <div class="row">
        <div class="col-md-12 text-left">

        <div class="mobile">
            
            <div class="header ">
            <h2><b>Join other drivers building the world's first dash cam sharing community</b></h2><img class="mobile-header" src="images/lander/header-image.png" data-video="https://www.youtube.com/embed/EFWYXdK1PC8">
            <div class="tubemobile"></div>
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
@stop