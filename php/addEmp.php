<?php
include('db_connection.php');
$contact_error = $add_error = $success = "";

if (isset($_POST["add"])) {
  $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
  $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
  $contact = mysqli_real_escape_string($conn, $_POST["number"]);
  $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
  $position = mysqli_real_escape_string($conn, $_POST["position"]);


  $default_image = "../assets/images/no_img.jpg";

  if (!preg_match('/^[0-9+]+$/', $contact)) {
    $contact_error = "Contact number should contain only numbers";
    $add_error = "The form was unsuccessfully submitted.";
  } else {

    $query = "SELECT `number`, `fname`, `lname` FROM `employee` WHERE `number` = ? AND `fname` = ? AND `lname` = ? ";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $contact, $fname,  $lname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      $add_error = "Employee is already on the list";
    } else {

      $query = "INSERT INTO `employee` (`fname`, `lname`, `number`, `gender`, `position`, `emp_img`) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ssssss", $fname, $lname, $contact, $gender, $position, $default_image);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      $success = "Employee successfully submitted.";
    }
  }
}


$totalEngineers = $totalForman = $totalWorkers = $totalHR = 0;


$query = "SELECT `position`, COUNT(*) AS total FROM `employee` GROUP BY `position`";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  $position = $row['position'];
  $count = $row['total'];


  if ($position === 'Engineer') {
    $totalEngineers = $count;
  } elseif ($position === 'Forman') {
    $totalForman = $count;
  } elseif ($position === 'Worker') {
    $totalWorkers = $count;
  } elseif ($position === 'Human Resource') {
    $totalHR = $count;
  }
}

mysqli_close($conn);
