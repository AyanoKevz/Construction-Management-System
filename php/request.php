<?php
include('db_connection.php');
$contact_error = $email_error = $req_error = $success = "";

if (isset($_POST["send"])) {

  $name = mysqli_real_escape_string($conn, $_POST["name"]);
  $contact = mysqli_real_escape_string($conn, $_POST["number"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $message = mysqli_real_escape_string($conn, $_POST["message"]);

  if (!preg_match('/^[0-9+]+$/', $contact) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    if (!preg_match('/^[0-9+]+$/', $contact)) {
      $contact_error = "Contact number should contain only numbers";
      $req_error = "The form was unsuccessfully submitted.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Please enter a valid email address.";
      $req_error = "The form was unsuccessfully submitted.";
    }
  } else {

    $query = ("SELECT `Number`, `Email` FROM `req_appoint` WHERE (`Number` = ? OR `Email` = ?)");
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $contact, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

      while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Number'] == $contact) {
          $contact_error = "The contact number is already submitted";
          $req_error = "The form was unsuccessfully submitted.";
        }
        if ($row['Email'] == $email) {
          $email_error = "The email is already submitted";
          $req_error = "The form was unsuccessfully submitted.";
        }
      }
    } else {

      $query = ("INSERT INTO `req_appoint` (`Name`, `Number`, `Email`, `Message`) VALUES (?, ?, ?, ?)");
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ssss", $name, $contact, $email, $message);
      mysqli_stmt_execute($stmt);
      $success = "The form was successfully submitted.";
    }
  }
}
