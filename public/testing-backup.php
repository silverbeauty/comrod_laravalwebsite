
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

                                <div class="container">
<div class="row">
    <div class="col-md-12 text-left">





            <link rel="stylesheet" type="text/css" href="./css/jquery.dataTables.css">
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
            <link href="./css/dashcams.css" rel="stylesheet">                


            כל הזמן פונים אלינו ומבקשים מאתנו המלצות לגבי מצלמות רכב, אז החלטנו לרכז עבורכם מספר מצלמות פופולריות בקרב משתמשנו ולהציג את היתרונות והחסרונות של כל אחד מהם<br />

            <table id="dashtable" class="table table-bordered tablesorter">
                <thead>
                    <tr>
                        <!--<th>מצלמה</th>
                        <th>תמיכה בקומרודס</th>
                        <th>קבל (במקום בטריה)</th>
                        <th>רזולוציה מקסימלית</th>
                        <th>מסך</th>
                        <th>מהירות WIFI</th>
                        <th>מצב חניה</th>
                        <th>מחיר</th>
                        <th>תוספות</th>-->
                        <th></th>
                        <th>Viofo WR1</th>
                        <th>Xiaomi YI</th>
                        <th>YI Ultra</th>
                    </tr>

                </thead>
            </table>
            <script>
            $.getJSON('./content/dashcam-content-column-heb.json', function(data) {
                filedata = data;
                name = [];
                for (let i = 0; i < filedata.length; i++){
                    name.push(filedata[i].name)
                }
            })

            jQuery(function ($){
                $('#dashtable').DataTable({
                    paging: false,
                    searching: false,
                    ordering: false,
                    data: filedata,
                    columns: [
                        { data: "feature_name"},
                        //{ data: "azdome"},
                        { data: "wr1"},
                        { data: "xiaomi_yi"},
                        { data: "yi_ultra"}
                    ]
                    
                    
                    /*[
                        { data: "name"},
                        { data: "support_app"},
                        { data: "capacitor"},
                        { data: "max_res"},
                        { data:  "screen"},
                        { data: "wifi speed"},
                        { data:  "parking mode"},
                        { data:   "price"},
                        { data: "additional"}
                    ]*/
                });
            });





            </script>


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
