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
      $mail->Body = "
      <html>
      <head>
          <title>Your Appointment</title>
      </head>
      <body>
          <p>Dear <strong>$name</strong>,</p>
          <p>Thank you for reaching out to R.O.Salas Construction.</p>
          <p>We have successfully scheduled your appointment for <strong>$date at $time</strong>.</p>
          <p>If you have any questions or need to make changes, please don't hesitate to contact us.</p>
          <p>Best Regards,<br><strong>R.O.Salas Construction Team</strong></p>
      </body>
      </html>
  ";
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
    $reject = "The inquiry was successfully has been rejected.";

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
    $mail->Subject = 'Sorry For Inconvenience';
    $mail->Body = "
        <html>
        <head>
            <title>Apology for Inconvenience</title>
        </head>
        <body>
            <p>Good Day, <strong>$name</strong>,</p>
            <p>We sincerely appreciate your interest in R.O.Salas Construction.</p>
            <p>Regrettably, due to our current high demand, we are unable to accommodate additional appointments at this time. We understand the inconvenience this may cause and apologize for any disappointment.</p>
            <p>Please reply to this email with your preferred date, and we'll make every effort to accommodate your schedule. Your satisfaction is important to us, and we want to ensure we find a suitable arrangement.</p>
            <p>Thank you for your understanding and patience.</p>
            <p>Best Regards,<br><strong>R.O.Salas Construction Team</strong></p>
        </body>
        </html>
    ";
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
