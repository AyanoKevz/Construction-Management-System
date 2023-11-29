<?php
include('db_connection.php');

$success = $update_success = "";

if (isset($_POST["create"])) {
  $teamName = mysqli_real_escape_string($conn, $_POST["teamName"]);
  $teamEngineer = mysqli_real_escape_string($conn, $_POST["teamEngineer"]);
  $teamForeman = mysqli_real_escape_string($conn, $_POST["teamForeman"]);

  // Insert team into the team table
  $queryTeam = "INSERT INTO `team` (`teamName`) VALUES (?)";
  $stmtTeam = mysqli_prepare($conn, $queryTeam);
  mysqli_stmt_bind_param($stmtTeam, "s", $teamName);
  mysqli_stmt_execute($stmtTeam);
  $teamID = mysqli_insert_id($conn);


  // Update the teamID in the employee table for the engineer
  $queryUpdateEngineer = "UPDATE `employee` SET `teamID` = ? WHERE `ID` = ?";
  $stmtUpdateEngineer = mysqli_prepare($conn, $queryUpdateEngineer);
  mysqli_stmt_bind_param($stmtUpdateEngineer, "ii", $teamID, $teamEngineer);
  mysqli_stmt_execute($stmtUpdateEngineer);

  // Update the teamID in the employee table for the foreman
  $queryUpdateForeman = "UPDATE `employee` SET `teamID` = ? WHERE `ID` = ?";
  $stmtUpdateForeman = mysqli_prepare($conn, $queryUpdateForeman);
  mysqli_stmt_bind_param($stmtUpdateForeman, "ii", $teamID, $teamForeman);
  mysqli_stmt_execute($stmtUpdateForeman);

  // Update the teamID in the employee table for the workers
  if (isset($_POST["selectedWorkers"]) && is_array($_POST["selectedWorkers"])) {
    $selectedWorkers = $_POST["selectedWorkers"];
    foreach ($selectedWorkers as $worker) {
      $queryUpdateWorker = "UPDATE `employee` SET `teamID` = ? WHERE `ID` = ?";
      $stmtUpdateWorker = mysqli_prepare($conn, $queryUpdateWorker);
      mysqli_stmt_bind_param($stmtUpdateWorker, "ii", $teamID, $worker);
      mysqli_stmt_execute($stmtUpdateWorker);
    }
  }

  $success = "Successfully created a team.";

  mysqli_stmt_close($stmtTeam);
  mysqli_stmt_close($stmtUpdateEngineer);
  mysqli_stmt_close($stmtUpdateForeman);
  mysqli_stmt_close($stmtUpdateWorker);
}


if (isset($_POST["update"])) {

  $teamID = $_POST['teamID'];
  $teamName = mysqli_real_escape_string($conn, $_POST["teamName"]);
  $teamEngineer = mysqli_real_escape_string($conn, $_POST["teamEngineer"]);
  $teamForeman = mysqli_real_escape_string($conn, $_POST["teamForeman"]);

  $queryTeam = "UPDATE `team` SET `teamName` = ?  WHERE `ID` = ?";
  $stmtTeam = mysqli_prepare($conn, $queryTeam);
  mysqli_stmt_bind_param($stmtTeam, "si", $teamName, $teamID);
  mysqli_stmt_execute($stmtTeam);

  // Update the teamID in the employee table for the engineer, set the old to null
  $queryUpdateNullEngr = "UPDATE `employee` SET `teamID` = NULL WHERE `teamID` = ? AND `position` = 'Engineer' ";
  $queryUpdateNullEngr = mysqli_prepare($conn, $queryUpdateNullEngr);
  mysqli_stmt_bind_param($queryUpdateNullEngr, "i", $teamID);
  mysqli_stmt_execute($queryUpdateNullEngr);

  // Update the teamID in the employee table for the engineer
  $queryUpdateNewEngr = "UPDATE `employee` SET `teamID` = ? WHERE `ID` = ?";
  $queryUpdateNewEngr = mysqli_prepare($conn, $queryUpdateNewEngr);
  mysqli_stmt_bind_param($queryUpdateNewEngr, "ii", $teamID, $teamEngineer);
  mysqli_stmt_execute($queryUpdateNewEngr);

  // Update the teamID in the employee table for the forman, set the old to null
  $queryUpdateNullFore = "UPDATE `employee` SET `teamID` = NULL WHERE `teamID` = ? AND `position` = 'Foreman' ";
  $queryUpdateNullFore = mysqli_prepare($conn, $queryUpdateNullFore);
  mysqli_stmt_bind_param($queryUpdateNullFore, "i", $teamID);
  mysqli_stmt_execute($queryUpdateNullFore);

  // Update the teamID in the employee table for the Foreman
  $queryUpdateNewFore = "UPDATE `employee` SET `teamID` = ? WHERE `ID` = ?";
  $queryUpdateNewFore = mysqli_prepare($conn, $queryUpdateNewFore);
  mysqli_stmt_bind_param($queryUpdateNewFore, "ii", $teamID, $teamForeman);
  mysqli_stmt_execute($queryUpdateNewFore);

  // Update the teamID in the employee table for the workers, set the old teamID to null
  $queryUpdateNullWorkers = "UPDATE `employee` SET `teamID` = NULL WHERE `teamID` = ? AND `position` = 'Worker'";
  $stmtUpdateNullWorkers = mysqli_prepare($conn, $queryUpdateNullWorkers);
  mysqli_stmt_bind_param($stmtUpdateNullWorkers, "i", $teamID);
  mysqli_stmt_execute($stmtUpdateNullWorkers);

  // Update the teamID in the employee table for the workers to the new teamID
  $queryUpdateNewWorkers = "UPDATE `employee` SET `teamID` = ? WHERE `ID` = ?";
  $stmtUpdateNewWorkers = mysqli_prepare($conn, $queryUpdateNewWorkers);

  if (isset($_POST["selectedWorkers"]) && is_array($_POST["selectedWorkers"])) {
    $selectedWorkers = $_POST["selectedWorkers"];
    foreach ($selectedWorkers as $worker) {
      mysqli_stmt_bind_param($stmtUpdateNewWorkers, "ii", $teamID, $worker);
      mysqli_stmt_execute($stmtUpdateNewWorkers);
    }
  }
  $update_success = "Updated successfully";

  mysqli_stmt_close($stmtTeam);
  mysqli_stmt_close($queryUpdateNullEngr);
  mysqli_stmt_close($queryUpdateNewEngr);
  mysqli_stmt_close($queryUpdateNullFore);
  mysqli_stmt_close($queryUpdateNewFore);
  mysqli_stmt_close($stmtUpdateNullWorkers);
  mysqli_stmt_close($stmtUpdateNewWorkers);
}
