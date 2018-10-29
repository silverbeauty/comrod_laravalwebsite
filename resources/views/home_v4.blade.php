@extends('layouts.master')

@section('external_js')
    @include('underscore.no_map_templates')
@endsection

@section('underscore')
@stop

@section('modals')
    @include('modals.home_page_categories')
@stop

@section('title', 'Comroads')
@section('description', 'Comroads')
@section('body_class', 'home v3')

@section('content4')
  <!--  <div class="container-fluid center-block" style="max-width:1350px;"> -->
    <div class="mobile">
        <div class="header ">
        <h2><b>Location-based dash cam footage when you need it</b></h2><img src="img/first.png">
        <p>The world’s first social network of dash cam drivers, sharing vital video evdence when and where it's needed</p>
        <div class="getinon animation">
        <div class="google">
        <p>Got a comroads<br> compatible dash-cam?</p><br>
        <img src="img/google.png"><br>
        </div>
        <div class="google">
        <p>Don’t have <br> available dash-cam yet?</p><br>
        <img src="img/get.png">
        </div>
        </div>  <div class="main animation">
            <div class="animation">
                <h1>How <font color="#00B2E3">Comroads Works</font></h1><span>1</span>
                <p>Getting started with Comroads is easy. Download the app, then connect it to your car's dash ca, and away you go</p><img src="img/HIxW1.png">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
            </div>
            <div class="animation">
                <span>2</span>
                <p>Start driving and Comroads automatically generates a route of your journey</p><img src="img/HIW2.png">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
            </div>
            <div class="animation">
                <span>3</span>
                <p>If you want to report an incident, simply press the overlay button or press the location on place it happened on the map</p><img src="img/HIW3.png">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
            </div>
            <div class="animation">
                <span>4</span>
                <p>If anyone else from the Comroads community were nearby when you genereted the event, we'll let you know and you'll be able to request their footage as well</p><img src="img/HIW4.png">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
            </div>
        </div>
        </div>
        <div class="getinon animation">
        <div class="google">
        <p>Got a comroads<br> compatible dash-cam?</p><br>
        <img src="img/google.png"><br>
        </div>
        <div class="google">
        <p>Don’t have <br> available dash-cam yet?</p><br>
        <img src="img/get.png">
        </div>
        </div>
        <div class="more ">
            <h2>More about comroads</h2>
            <div class="about">
                <div class="animation">
                    <img src="img/more1.png">
                    <p>Easily and quickly find footage from your dash cam, directly from the app and without the hassle of removing the memory card or manualy edeting video. Searching made sample - filter footage by time and location</p>
                </div>
                <div class="animation">
                    <img src="img/more2.png">
                    <p>It’s never been easier to share footage with your friends. On the road safer driving See that realy happened on the road that day... Download the relevant footage segment to your phone with just one click</p>
                </div><img src="img/more3.png">
                <p>Share your footage on your favorite social networks or Instant Messaging app With your permission,allow other comroads community members nearby to find and download your footage</p>
            </div>
            <div class="animation">
                <img src="img/more.png">
                <p>Stay anonymous when getting, giving or sharing footage. Works automatically in the background whenever you enter the car</p>
            </div>
            <div class="animation">
                <img src="img/more5.png">
                <p>Completely free, with unlimited cloud storage for your recordings</p>
            </div>
            <div class="animation">
                <img src="img/more6.png">
                <p>Comroads removes audio from your videos before sharing, so conversations are never recorded</p>
            </div>
        </div>
        <div class="faq-section">
            <h1>Frequently Asked Questions</h1>
            <div class="faq-item">
                <div id="1" class="faq-question">Can I upload any type of video?<span class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer1">So long as it's road related and you can tell us where and when it happened, you can upload. Any video that you think other people will find interesting or perhaps useful is welcomed as long as it abides to our T&C and uploading guidelines.</div>
            </div>
            <div class="faq-item">
                <div id="2" class="faq-question">I just uploaded my video but can't see it on the map. What's wrong?<span class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer2">All videos by new uploaders are manually checked and verified to make sure they abide by the guidelines and to fill in and missing data (date, map, categories etc.). This usually doesn't take long and users that consistently upload fully detailed videos are usually granted autopublish rights, meaning that the videos appear automatically on the site within a few minutes of uploading.</div>
            </div>
            <div class="faq-item">
                <div id="3" class="faq-question">Do you share these videos with the police or other authorities?<span class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer3">No, we do not cooperate with any law enforcement or other government authorities, nor do we share any uploader information with any 3rd party. If local law enforcement independently finds a video and wants to take action, they are free to do so. Should they need details from the uploader, they can contact them through the website's internal messaging system or ask us to email them. We will not provide user details to any 3rd party unless given explicit permission by the user.</div>
            </div>
            <div class="faq-item">
                <div id="4" class="faq-question">Why do you have advertisements on the site?<span class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer4">It might not seem like much, but Comroads has quite a high running cost. We host all the videos that are uploaded to the site, so apart from the actual website servers, we also have video storage, CDN streaming costs, Google Maps API costs (yeah, they charge for it) among other things. So, while the advertising doesn't come close to covering it, it is one way of helping us absorb it.</div>
            </div>
            <div class="faq-item">
                <div id="5" class="faq-question">How do I post a video onto Comroads?<span class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer5">Posting a video is actually really easy. You can either upload the file to the site, or simply post a YouTube URL. Here's a quick demo video<center><iframe src="https://www.youtube.com/embed/QADhkXRd5tc" allowfullscreen="" width="100%" frameborder="0"></iframe></center></div>
            </div>
        </div>
        <div class="get"> 
        <div class="google">
        <p>Got a comroads<br> compatible dash-cam?</p><br>
        <img src="img/google.png"><br>
        </div>
        <div class="google">
        <p>Don’t have <br> available dash-cam yet?</p><br>
        <img src="img/get.png">
        </div>
        </div>
        <div class="privacy">
            <div class="animation">
                <img src="img/privacy1.png">
                <h2>Be a Responsible driver</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
            <div class="animation">
                <img src="img/privacy2.png">
                <h2>privacy</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
        </div>
    </div>
<div class="desktop">
        <div class="description-section">
            <div class="main-text">
                <h1 class="blue-text main-text-margin">Location-based dash cam footage when you need it</h1>
                <div>The world's first social network of dash cam drivers, sharing vital video evidence when and where it's needed</div>
                <div class="google-play-buttons">
                    <div class="google-play-button-set">
                        <span>Got a comroads compatible dash-cam?</span>
                        <a href="#" class="google-button google-play-button"></a>
                    </div>
                    <div class="google-play-button-set">
                        <span>Don't have available dash-cam yet?</span>
                        <a href="#" class="google-button google-play-get-expert-recommendations-button"></a>
                    </div>
                </div>
            </div>
            <div class="header-image"></div>
            <div class="arrow-from-header-image"></div>
        </div>
        <div class="video-section">
            <div class="video">
                <div class="video-play-button"></div>
            </div>
            <div class="video-shadow"></div>
        </div>
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>
                <div class="step4-image"></div>
            </div>
            <div class="google-play-buttons">
                <div class="google-play-button-set">
                    <span>Got a comroads compatible dash-cam?</span>
                    <a href="#" class="google-button google-play-button"></a>
                </div>
                <div class="google-play-button-set">
                    <span>Don't have available dash-cam yet?</span>
                    <a href="#" class="google-button google-play-get-expert-recommendations-button"></a>
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
        <div class="what-they-say-about-comroads-section">
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
                            <div class="quote-author" st>
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
                </div>
            </div>
        </div>
        <div class="faq-section">
            <h1>Frequently Asked Questions</h1>
            <div class="faq-item">
                <div id="6" class="faq-question">Can I upload any type of video?<span  class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer6">So long as it's road related and you can tell us where and when it happened, you can upload. Any video that you think other people will find interesting or perhaps useful is welcomed as long as it abides to our T&C and uploading guidelines.</div>
            </div>
            <div class="faq-item">
                <div id="7" class="faq-question">I just uploaded my video but can't see it on the map. What's wrong?<span  class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer7">All videos by new uploaders are manually checked and verified to make sure they abide by the guidelines and to fill in and missing data (date, map, categories etc.). This usually doesn't take long and users that consistently upload fully detailed videos are usually granted autopublish rights, meaning that the videos appear automatically on the site within a few minutes of uploading.</div>
            </div>
            <div class="faq-item">
                <div id="8" class="faq-question">Do you share these videos with the police or other authorities?<span class="faq-expand-icon" ></span></div>
                <div class="faq-answer" id="answer8">No, we do not cooperate with any law enforcement or other government authorities, nor do we share any uploader information with any 3rd party. If local law enforcement independently finds a video and wants to take action, they are free to do so. Should they need details from the uploader, they can contact them through the website's internal messaging system or ask us to email them. We will not provide user details to any 3rd party unless given explicit permission by the user.</div>
            </div>
            <div class="faq-item">
                <div id="9" class="faq-question">Why do you have advertisements on the site?<span  class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer9">It might not seem like much, but Comroads has quite a high running cost. We host all the videos that are uploaded to the site, so apart from the actual website servers, we also have video storage, CDN streaming costs, Google Maps API costs (yeah, they charge for it) among other things. So, while the advertising doesn't come close to covering it, it is one way of helping us absorb it.</div>
            </div>
            <div class="faq-item">
                <div id="10" class="faq-question">How do I post a video onto Comroads?<span  class="faq-expand-icon"></span></div>
                <div class="faq-answer" id="answer10">Posting a video is actually really easy. You can either upload the file to the site, or simply post a YouTube URL. Here's a quick demo video<center><iframe src="https://www.youtube.com/embed/QADhkXRd5tc" allowfullscreen="" width="720" height="400" frameborder="0"></iframe></center></div>
            </div>
            <div class="google-play-buttons">
                <div class="google-play-button-set">
                    <span>Got a comroads compatible dash-cam?</span>
                    <a href="#" class="google-button google-play-button"></a>
                </div>
                <div class="google-play-button-set">
                    <span>Don't have available dash-cam yet?</span>
                    <a href="#" class="google-button google-play-get-expert-recommendations-button"></a>
                </div>
            </div>
        </div>
        <div class="privacy-section">
            <div class="privacy-section-item">
                <div class="privacy-section-item-title"><span class="helm-icon"></span>Be a Responsibe Driver</div>
                <div class="privacy-section-item-text">
                    <p>Igor You're reading this, so you're probably a safe driver. Probably also you want to see the roads safer for everyone – drivers and pedestrians. So here's the thing: Making it happen relies on people like you joining Comroads now, before the launch.</p>
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
        <script src="js/script.js" type="text/javascript"></script>
        <script src="https://unpkg.com/scrollreveal"></script>
        <script>
            ScrollReveal({ reset: true });
        </script>
        <script>
            $(document).ready( function(){
            $(".faq-button").click(function() {
                    console.log('clicknuo si');
                    $('html,body').animate({
                        scrollTop: $(".faq-section").offset().top},
                        1500);
            });
        });
        </script>


   <!-- </div>  -->
@endsection
