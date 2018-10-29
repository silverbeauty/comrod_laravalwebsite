	<!-- Privacy content -->
	<section class="privacy-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h3><img src="images/wheel-icon.png" alt="wheel-icon"> Be a Responsibe Driver</h3>
					<p>You’re reading this, so you’re probably a safe driver. Probably also you want to see the roads safer for everyone – drivers and pedestrians. So here’s the thing: Making it happen relies on people like you joining Comroads now, before the launch.</p>
					<p>Join now, get the app, and next time you drive you’ll be part of the Comroads community. On a journey to protecting yourself and others. Plus you’ll help improve the app by giving feedback about bugs, or features you’d like to see, and generating anonymous driving data. And when we say anonymous, it really is.</p>
				</div>
				<div class="col-md-6">
					<h3><img src="images/lock-icon.png" alt="lock-icon"> Privacy and Anonymity</h3>
					<p>Your data is yours, nobody else’s. With Comroads you can sign up anonymously. That’s right – no need to share your name, contact details, favourite TV show or any of that stuff. The only thing you might be asked for is your footage – in case another member needs it. How does that sound? Ready to join the world’s first dash cam social community?</p>
				</div>
			</div>
		</div>
		<div class="privacy-content-image"></div>
	</section>
	<!-- Privacy content end -->

	<!-- Footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="footer-logo">
						<a href="#"><img src="images/footer-logo.png" alt="footer-logo" class="images-responsive"></a>
					</div>
					<ul class="footer-buttons">
						<li><input type="image" src="images/google-play-btn.png"></li>
						<li><input type="image" src="images/get-expert-btn.png"></li>
					</ul>
				</div>
				<div class="col-md-6 tar">
					<nav>
						<ul class="footer-menu">
							<li><a href="#">Home</a></li>
							<li><a href="#">Upload</a></li>
							<li><a href="#">About Us</a></li>
							<li><a href="#">Contact Us</a></li>
							<li><a href="#">FAQ</a></li>
						</ul>
					</nav>
					<p>© 2018 Comroads.com. All rights reserved</p>
					<ul class="social-buttons">
						<li><a href="#"><img src="images/vimeo-icon.png" alt="vimeo-icon"></a></li>
						<li><a href="#"><img src="images/twitter-icon.png" alt="twitter-icon"></a></li>
						<li><a href="#"><img src="images/facebook-icon.png" alt="facebook-icon"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer end -->

	<!-- Scripts -->
	<script src="js/slick.js" charset="utf-8"></script>
	<script>
		$(document).ready(function() {
			// Slider
		    $('.single-item').slick({
		        dots: true,
		        infinite: true,
		        speed: 500,
		        slidesToShow: 1,
		        slidesToScroll: 1
		    });

		    // Mobile menu toggle
			$(".mobile-btn").click(function(e){
				e.preventDefault();
				$(".menu, .menu-bottom-mobile").slideToggle();
			})
		});
	</script>
</body>
</html>