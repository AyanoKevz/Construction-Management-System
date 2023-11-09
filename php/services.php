<?php

include 'request.php'
?>

<!DOCTYPE HTML>

<html>

<head>
	<title>Services</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/style.css" />
	<noscript>
		<link rel="stylesheet" href="../assets/css/noscript.css" />
	</noscript>
	<link rel="shortcut icon" href="../assets/images/ros-icon.ico" type="image/x-icon">
</head>

<body class="is-preload">

	<!-- Page Wrapper -->
	<div id="page-wrapper">

		<!-- Header -->
		<header id="header" class="alt">
			<nav class="navbar">
				<div class="container-fluid">
					<a class="navbar-brand" href="../index.php">
						<img src="../assets/images/ros.jpg" alt="R.O.Salas Construction" width="70" height="50">
					</a>
					<ul class="nav nav-underline">
						<li class="nav-item">
							<a class="nav-link" href="../index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="services.php">Services</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.php">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#footer">Contact Us</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Wrapper -->
		<section id="wrapper">
			<header>
				<?php
				if ($success) {
					echo '<label class="text-success success" id="alert">' . $success . '</label>';
				}
				if ($req_error) {
					echo '<label class="text-danger error" id="alert">' . $req_error . '</label>';
				}
				?>
				<div class="inner">

					<h2>Services</h2>
					<p>We offer a construction service.</p>
				</div>
			</header>

			<!-- Content -->
			<div class="wrapper">
				<div class="inner">

					<h2 class="major">What is construction Services?</h2>
					<p> Construction services means the physical construction work undertaken by a CM/GC contractor to construct a project or a portion of the project (including early work packages). Construction services include all costs to perform, supervise, and administer physical construction work. </p>

					<section class="features">
						<article>
							<a href="#" class="image"><img src="../assets/images/value.jpg" alt="" /></a>
							<h3 class="major">Quality Service</h3>
							<p>We make sure we give our absolute best in everything we do, going above and beyond to ensure that our clients are not just satisfied, but truly delighted with the services we provide.</p>
						</article>
						<article>
							<a href="#" class="image"><img src="../assets/images/construction.jpg" alt="" /></a>
							<h3 class="major">Construction Industry</h3>
							<p>Debris from all the construction activity will only occupy precious space, which is why it is best that it be removed right away. Furthermore, construction materials such as steel bars and scaffolding can also be delivered by our company.</p>
						</article>
					</section>

				</div>
			</div>

		</section>

		<!-- Footer -->
		<section id="footer">
			<div class="inner">
				<h2 class="mtitle">Contact Us</h2>
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
							<input type="text" name="number" id="number" autocomplete="off" required="on" placeholder="<?php echo $contact_error; ?>">
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
						<li><input type="submit" value="Send Message" name="send" /></li>
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

	<script src="../assets/js/bootstrap.bundle.min.js"></script>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/breakpoints.min.js"></script>

</body>

</html>