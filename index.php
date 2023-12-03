<?php

include 'php/request.php'
?>

<!DOCTYPE HTML>

<html>

<head>
	<title>R.O.Salas Construction</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
	<link rel="shortcut icon" href="assets/images/ros-icon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/style.css" />

</head>

<body class="is-preload">

	<!-- Page Wrapper -->
	<div id="page-wrapper">

		<!-- Header -->
		<header id="header" class="alt">

			<nav class="navbar">
				<div class="container-fluid">
					<a class="navbar-brand" href="index.php">
						<img src="assets/images/ros.jpg" alt="R.O.Salas Construction" width="70" height="50">
					</a>
					<ul class="nav nav-underline">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="php/services.php">Services</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="php/about.php">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#footer">Contact Us</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Banner -->
		<section id="banner">
			<?php
			if ($success) {
				echo '<label class="text-success success" id="alert">' . $success . '</label>';
			}
			if ($req_error) {
				echo '<label class="text-danger error" id="alert">' . $req_error . '</label>';
			}
			?>
			<div class="inner">
				<div class="logo">
					<img src="assets/images/ros.jpg" alt="">
				</div>
				<h2>R.O.SALAS CONSTRUCTION</h2>
				<p>OFFERING CONSTRUCTION <a href="php/services.php">SERVICES</a></p>
			</div>
		</section>

		<!-- Wrapper -->
		<section id="wrapper">

			<!-- One -->
			<section id="one" class="wrapper spotlight style1">
				<div class="inner">
					<a href="#" class="image"><img src="assets/images/pic01.jpg" alt="" /></a>
					<div class="content">
						<h2 class="major">Mission</h2>
						<p>To deliver excellence in services on construction fields, exceeding the expectations of our clients, and positively impacting the communities we serve.
							Fostering a safe and inclusive workplace that empowers our dedicated team to achieve excellence in every project.
						</p>
					</div>
				</div>
			</section>

			<!-- Two -->
			<section id="two" class="wrapper alt spotlight style2">
				<div class="inner">
					<a href="#" class="image"><img src="assets/images/pic02.jpg" alt="" /></a>
					<div class="content">
						<h2 class="major">VISION</h2>
						<p>To continuously innovate, adapt to evolving technologies,
							while maintaining the highest ethical standards and serving as a model of excellence for the industry.
						</p>
					</div>
				</div>
			</section>

			<!-- Three -->
			<section id="three" class="wrapper alt style1">
				<div class="inner">
					<h2 class="major">We value our clients!</h2>
					<p> As we look to the years ahead we renew our pledge to remain committed to excellence, keep abreast of changes and
						innovations, adopt better management and construction techniques and successfully overcome all challenges before us.</p>
					<section class="features">
						<article>
							<a href="#" class="image"><img src="assets/images/fast.gif" alt="" /></a>
							<h3 class="major">Timely</h3>
							<p>Our company is a highly reputable and timely construction company known for its commitment to serving clients on schedule.</p>

						</article>
						<article>
							<a href="#" class="image"><img src="assets/images/competitive.gif" alt="" /></a>
							<h3 class="major">Competitiveness</h3>
							<p>Our company competitiveness shines through as they provide timely, reliable, and cost-effective hauling solutions.</p>

						</article>
						<article>
							<a href="#" class="image"><img src="assets/images/quality.gif" alt="" /></a>
							<h3 class="major">Highest Quality</h3>
							<p>Their unwavering dedication to excellence ensures that every project is executed with precision, craftsmanship, and an uncompromising commitment to the finest standards.</p>

						</article>
						<article>
							<a href="#" class="image"><img src="assets/images/safe.gif" alt="" /></a>
							<h3 class="major">Safety Performance</h3>
							<p>We places paramount importance on safety performance. With a rigorous commitment to creating a secure and hazard-free environment, we
								consistently prioritize the well-being of our team and clients. </p>
						</article>
					</section>
				</div>
			</section>

		</section>

		<!-- Footer -->
		<section id="footer">
			<div class="inner">
				<h2 class="mtitle">Connect with us</h2>
				<h3>Drop us a message</h3>
				<p>
					We are open to discussion. For your concerns and inquiries, kindly send us a message. Here at R.O. Salas Construction,
					we value our clients. We will reach out to you and arrange a schedule for the appointment at the contacts that you provided below.
				</p>
				<form method="post" action="#" onsubmit="clearTextArea()">
					<div class="fields">
						<div class="field">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" autocomplete="off" required="on">
						</div>
						<div class="field">
							<label for="email">Contact Number</label>
							<input type="text" name="number" id="number" autocomplete="off" required="on" placeholder="<?php echo $contact_error; ?>" maxlength="11">
						</div>
						<div class="field">
							<label for="email">Email</label>
							<input type="email" name="email" id="email" autocomplete="off" required="on" placeholder="<?php echo $email_error; ?>">
						</div>
						<div class="field">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="4"></textarea>
						</div>
					</div>
					<ul class="actions">
						<li><input type="submit" value="Send Message" name="send" id="liveAlertBtn" /></li>
					</ul>
				</form>
				<ul class="contact">
					<li class="icon solid fa-home">
						R.O.Salas Construction<br />
						34 Fema Road Bahay Toro<br />
						1106, Quezon City
					</li>
					<li class="icon solid fa-phone">(+63) 923 123 6285</li>
					<li class="icon solid fa-envelope"><a href="https://mail.google.com/mail/u/0/#inbox?compose=GTvVlcSMTSGfrKRgpRdCcRcPdrpWdqZGhjfdWQwTbnfQbrKxhWLwmTfHrCfJcWRhVvpGXWGmjPSNv">rosalasconstruction00@gmail.com</a></li>
					<li class="icon brands fa-facebook-f"><a href="https://www.facebook.com/rosalasconstruction">facebook/R.O.Salas Construction</a></li>
					<li class="icon brands fa-instagram"><a href="#">instagram.com/R.O.Salas Construction</a></li>
				</ul>
				<ul class="copyright">
					<li>&copy; R.O.Salas Construction. All rights reserved.</li>
				</ul>
			</div>
		</section>

	</div>

	<!-- Scripts -->

	<script>
		function clearTextArea() {

			var textArea = document.getElementById("message");

			textArea.reset();
		}

		setTimeout(function() {
			var alert = document.getElementById('alert');
			if (alert) {
				alert.remove();
			}
		}, 3500);
	</script>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>