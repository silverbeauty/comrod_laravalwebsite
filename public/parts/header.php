<!doctype html>
<html>
<head>
	<!-- meta -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- title -->
	<title>Comroads-DashCam | <?php echo $title; ?></title>
	
	<!-- css -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/slick.css">
	<link rel="stylesheet" type="text/css" href="css/slick-theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- js -->
	<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="<?php echo $bodyClass; ?>">

	<!-- Header -->
	<header>

		<!-- Header top -->
		<div class="header-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3 col-xs-9">
						<div class="logo">
							<a href="#"><img src="img/logo.png" alt="logo" class="img-responsive"></a>
						</div>
					</div>
					<div class="col-xs-3 hidden-md hidden-lg tar">
						<a href="#" class="mobile-btn">
							<svg class="svg-inline--fa fa-bars fa-w-14" aria-hidden="true" data-prefix="fa" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>
						</a>
					</div>
					<div class="col-md-5 col-xs-12 tar">
						<nav>
							<ul class="menu">
								<li><a href="#">Home</a></li>
								<li><a href="#">Upload</a></li>
								<li><a href="#">About Us</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">FAQ</a></li>
							</ul>
						</nav>
					</div>
					<div class="col-md-4 col-xs-12 tar">
						<div class="menu-bottom-mobile">
							<button><img src="img/sign-up-icon.png" alt="sign-up-icon"> Sign Up</button>
							<button><img src="img/login-icon.png" alt="login-icon"> login</button>
							<div class="language-box">
								<img src="img/language-icon.png" alt="language-icon">
								<select>
									<option value="en">EN</option>
									<option value="il">IL</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php if (isset($bodyClass) && $bodyClass == 'review-page') { ?>

		<!-- Subheader -->
		<div class="container">
			<div class="subheader">
				<div class="row">
					<div class="col-md-6 col-sm-4 hidden-xs">
						<p><a href="#"><img src="img/left-angle-icon.png" alt="left-angle-icon"> back to comparison page</a></p>
					</div>
					<div class="col-md-6 col-sm-8 tar">
						<p>Choose Your Dash-cam
							<select>
								<option value="">Xiaomi YI</option>
								<option value="">Xiaomi YI</option>
							</select>
						</p>
					</div>
				</div>
			</div>
		</div>

		<?php } ?>

	</header>
	<!-- Header end -->