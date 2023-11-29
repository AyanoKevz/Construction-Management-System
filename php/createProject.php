<?php
include('db_connection.php');

$success = $error = "";

if (isset($_POST["createProject"])) {

  $projectCodeInput = $_POST["projectCode"];
  $projectCode = "ROS-" . $projectCodeInput;
  $projectCode = mysqli_real_escape_string($conn, $projectCode);
  $projectType = mysqli_real_escape_string($conn, $_POST["projectType"]);
  $projectName = mysqli_real_escape_string($conn, $_POST["projectName"]);
  $projectCost = mysqli_real_escape_string($conn, $_POST["projectCost"]);
  $location = mysqli_real_escape_string($conn, $_POST["location"]);
  $startDate = mysqli_real_escape_string($conn, $_POST["startDate"]);
  $deadline = mysqli_real_escape_string($conn, $_POST["deadline"]);
  $teamID = mysqli_real_escape_string($conn, $_POST["team"]);
  $status = "On-Going";
  $default_image = "../assets/images/default_house.jpg";


  $queryCheck = "SELECT * FROM `project` WHERE `projectCode` = ?";
  $stmtCheck = mysqli_prepare($conn, $queryCheck);
  mysqli_stmt_bind_param($stmtCheck, "s", $projectCode);
  mysqli_stmt_execute($stmtCheck);
  $resultCheck = mysqli_stmt_get_result($stmtCheck);

  if (mysqli_num_rows($resultCheck) > 0) {
    $error = "Project code already exists.";
  } else {

    if (!preg_match('/^[0-9,]+$/', $projectCost)) {
      $error = "Project Cost should contain only numbers";
    } else {

      $query = ("INSERT INTO `project` (`teamID`, `projectCode`, `projectType`, `projectName`, `cost`, `location`,  `startingDate`,  `deadline`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "issssssss", $teamID, $projectCode, $projectType, $projectName, $projectCost, $location, $startDate, $deadline, $status);
      mysqli_stmt_execute($stmt);
      $projectID = mysqli_insert_id($conn);


      $query2 = "INSERT INTO `$projectType`  (`projectID`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`) VALUES (?, ? , ? , ? , ?, ? )";
      $stmt2 = mysqli_prepare($conn, $query2);
      mysqli_stmt_bind_param($stmt2, "isssss", $projectID,  $default_image,  $default_image,  $default_image,  $default_image,  $default_image);
      mysqli_stmt_execute($stmt2);


      $query3 = "UPDATE  `team` SET `projectID` = ? WHERE `ID` = ?  ";
      $stmt3 = mysqli_prepare($conn, $query3);
      mysqli_stmt_bind_param($stmt3, "ii", $projectID, $teamID);
      mysqli_stmt_execute($stmt3);
      $success = "Successfully created a project.";
    }
  }
}
