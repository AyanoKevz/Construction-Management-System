<?php
include('db_connection.php');
$success = "";

if (isset($_POST["deliverMaterials"])) {
  $projectID = $_POST['projectID'];
  $concrete = $_POST["concrete"];
  $lumber = $_POST["lumber"];
  $steel = $_POST["steel"];
  $aggregates = $_POST["aggregates"];
  $bricks = $_POST["bricks"];
  $roofing = $_POST["roofing"];
  $finishing = $_POST["finishing"];
  $deliDate = $_POST["deliDate"];
  $deliTime = $_POST["deliTime"];

  $query = "INSERT INTO `materials` 
        (`projectID`, `concrete`, `lumber`, `steel`, `aggregates`, `bricks`, `roofing`, `finishing`, `deliDate`, `deliveryTime`)
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "isssssssss", $projectID, $concrete, $lumber, $steel, $aggregates, $bricks, $roofing, $finishing, $deliDate, $deliTime);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  $success = "Data for material delivery was successfully inserted! See the delivery logs.";
}




if (isset($_POST["updateMaterials"])) {
  $materialsID = $_POST['materialsID'];
  $concrete = $_POST["concrete"];
  $lumber = $_POST["lumber"];
  $steel = $_POST["steel"];
  $aggregates = $_POST["aggregates"];
  $bricks = $_POST["bricks"];
  $roofing = $_POST["roofing"];
  $finishing = $_POST["finishing"];
  $deliDate = $_POST["deliDate"];
  $deliTime = $_POST["deliTime"];

  $query = "UPDATE `materials` SET 
            `concrete` = ?, 
            `lumber` = ?, 
            `steel` = ?, 
            `aggregates` = ?, 
            `bricks` = ?, 
            `roofing` = ?, 
            `finishing` = ?, 
            `deliDate` = ?, 
            `deliTime` = ? 
            WHERE `ID` = ?";

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sssssssssi", $concrete, $lumber, $steel, $aggregates, $bricks, $roofing, $finishing, $deliDate, $deliTime, $materialsID);
  mysqli_stmt_execute($stmt);
  if (mysqli_stmt_affected_rows($stmt) > 0) {
    $success = "Material delivery data updated successfully!";
  } else {

    $success = "Nothing change.";
  }
}
