<?php
session_start();
$invalid_user = $invalid_pass = "";
include('php/login.php');

if (isset($_SESSION["ID"])) {
  header("location: php/dashboard.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="shortcut icon" href="assets/images/ros-icon.ico" type="image/x-icon">
  <title>Admin Login</title>
</head>

<body>

  <div class="container-fluid">

    <div class="row">

      <div class="banner">
        <div class="logo">
          <img src="../assets/images/ros.jpg" alt="">
        </div>
        <h2>R.O.SALAS CONSTRUCTION</h2>
        <p>Admin</p>
      </div>

      <div class="login">
        <h1>Admin Login</h1>
        <form class="form" method="post" action="">
          <p class="heading">Welcome Admin!</p>
          <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="2000">
                <img src="assets/images/ros.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <img src="assets/images/trucks.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="assets/images/pride.jpg" class="d-block w-100" alt="...">
              </div>
            </div>
          </div>
          <input class="input" placeholder="Username" name="username" type="text" autocomplete="off" required="on">
          <span class="text-danger fs-6"><?php echo $invalid_user ?></span>
          <input class="input" placeholder="Password" name="password" type="password" autocomplete="off" required="on">
          <span class="text-danger fs-6"><?php echo $invalid_pass ?></span>
          <button class="btn" type="submit" name="login" id="login">Login</button>
        </form>
      </div>

    </div>

    <div class="footer">
      <div class="footer-container">
        <p>&copy; R.O.Salas Construction. All rights reserved.</p>
        <a href="index.php">Client Page</a>
      </div>
    </div>

  </div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>