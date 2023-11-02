<?php
include('db_connection.php');

if (isset($_POST["login"])) {

  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);


  if (!preg_match("/^[a-zA-Z0-9_]+$/", $username) || !preg_match("/^[a-zA-Z0-9_]+$/", $password)) {
    $error_login = "Username and Password can only contain letters, numbers, and underscores.";

    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
      $invalid_user = "Username can only contain letters, numbers, and underscores.";
    }
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $password)) {
      $invalid_pass = "Password can only contain letters, numbers, and underscores.";
    }
  } else {

    $query = "SELECT * FROM `login` WHERE BINARY `username` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {

      $query = "SELECT * FROM `login` WHERE BINARY `username` = ? AND BINARY `password` = ? ";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $username, $password);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_row($result);

      if (mysqli_num_rows($result) > 0) {
        $_SESSION['ID'] = $row[0];
        header("location: php/dashboard.php");
        exit();
      } else {

        $invalid_pass = "Invalid Password.";
        $error_login = "Invalid login credentials.";
      }
    } else {

      $invalid_user = "Invalid Username.";
    }
  }
}
