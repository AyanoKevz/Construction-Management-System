<?php
include 'db_connection.php';
$accept = $reject = $done = "";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (isset($_POST["set"])) {

  $name = mysqli_real_escape_string($conn, $_POST["name"]);
  $contact = mysqli_real_escape_string($conn, $_POST["number"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $date = mysqli_real_escape_string($conn, $_POST["date"]);
  $time = mysqli_real_escape_string($conn, $_POST["time"]);

  $query = "INSERT INTO `schedule` (`Name`, `Number`, `Email`, `Sched_Date`, `Sched_Time`) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sssss", $name, $contact, $email, $date, $time);
  if (mysqli_stmt_execute($stmt)) {

    $delete_query = "DELETE FROM `req_appoint` WHERE `Number` = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, "s", $contact);
    if (mysqli_stmt_execute($delete_stmt)) {

      $accept = "The appointment scheduled has been successfully set.";
      //Server settings
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'rosalasconstruction00@gmail.com';
      $mail->Password   = 'gotruryjuxbqeary';
      $mail->SMTPSecure = 'ssl';
      $mail->Port       = 465;

      //Recipients
      $mail->setFrom('rosalasconstruction00@gmail.com', 'R.O.Salas Construction (Admin)');
      $mail->addAddress($email);

      //Content
      $mail->isHTML(true);
      $mail->Subject = 'Appointment Scheduled';
      $mail->Body = "Good Day, " . $name . ". We received your message, and your appointment has been scheduled for " . $date . " at " . $time . ". Thank you!";
      $mail->send();
      header("Location: appointment.php?message=" . urlencode($accept));
    }
  }
}


if (isset($_POST["reject"])) {
  $id = mysqli_real_escape_string($conn, $_POST["id"]);
  $name = mysqli_real_escape_string($conn, $_POST["name"]);
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $query = "DELETE FROM `req_appoint` WHERE `ID` = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $id);

  if (mysqli_stmt_execute($stmt)) {
    $reject = "The inquiry was successfully deleted from the list.";

    //Server settings
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rosalasconstruction00@gmail.com';
    $mail->Password   = 'gotruryjuxbqeary';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('rosalasconstruction00@gmail.com', 'R.O.Salas Construction (Admin)');
    $mail->addAddress($email);

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Sorry For Inconvinient';
    $mail->Body = "Good Day, " . $name . ". We received your message, and we are sorry to tell you that we cannot set you an appointment as our company is fully scheduled right now. Kindly reply to this email if you have a preferred date, and we will talk about it. Thank you!";
    $mail->send();
  }
}


if (isset($_POST["done"])) {
  $id = mysqli_real_escape_string($conn, $_POST["id"]);
  $query = "DELETE FROM `schedule` WHERE `ID` = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $done = "The scheduled appointment has been removed from the list.";
}
