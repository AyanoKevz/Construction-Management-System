<?php
include('db_connection.php');

$update_success = $update_error = $targetFile = "";



if (isset($_POST["updateDetails"])) {
  $projectID = $_POST['projectID'];
  $projectName = mysqli_real_escape_string($conn, $_POST["projectName"]);
  $projectCost = mysqli_real_escape_string($conn, $_POST["projectCost"]);
  $location = mysqli_real_escape_string($conn, $_POST["location"]);
  $startDate = mysqli_real_escape_string($conn, $_POST["startDate"]);
  $deadline = mysqli_real_escape_string($conn, $_POST["deadline"]);

  if (!preg_match('/^[0-9,]+$/', $projectCost)) {
    $update_error = "Project Cost should contain only numbers";
  } else {

    $query = "UPDATE `project` SET `projectName`=?, `cost`=?, `location`=?, `startingDate`=?, `deadline`=? WHERE `ID`=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $projectName, $projectCost, $location, $startDate, $deadline, $projectID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      $update_success = "Employee details updated successfully.";
    } else {

      $update_success = "Nothing change.";
    }
  }
}



if (isset($_POST["updateHouse"])) {
  $projectID = $_POST['projectID'];
  $projectType = $_POST['projectType'];
  $foundation = mysqli_real_escape_string($conn, $_POST["foundation"]);
  $structure = mysqli_real_escape_string($conn, $_POST["structure"]);
  $exterior = mysqli_real_escape_string($conn, $_POST["exterior"]);
  $interior = mysqli_real_escape_string($conn, $_POST["interior"]);
  $util = mysqli_real_escape_string($conn, $_POST["util"]);

  // Update project progress
  $query = "UPDATE `$projectType` SET `foundation`=?, `structure`=?, `exterior`=?, `interior`=?, `utilities`=?, `updateDate` = NOW() WHERE `projectID`=?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "iiiiii", $foundation, $structure, $exterior, $interior, $util, $projectID);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Update successful
    $update_success = "Project progress updated successfully.";
  } else {
    $update_success = "Nothing changed.";
  }

  mysqli_stmt_close($stmt);

  // Handle file uploads for project images
  $targetDirectory =  "../assets/project_pic/";
  $fileNames = [];

  for ($i = 1; $i <= 5; $i++) {
    $fileName = 'pic' . $i;
    if (isset($_FILES[$fileName]) && $_FILES[$fileName]['error'] === UPLOAD_ERR_OK) {
      $targetFile = $targetDirectory . basename($_FILES[$fileName]['name']);

      // Check file size
      if ($_FILES[$fileName]['size'] > 5000000) {
        $update_error = "Sorry, file size too large (5MB limit).";
        break;
      }

      // Allow certain file formats
      $allowedFormats = ["jpg", "jpeg", "png", "gif"];
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

      if (!in_array($imageFileType, $allowedFormats)) {
        $update_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        break;
      }

      if (!move_uploaded_file($_FILES[$fileName]['tmp_name'], $targetFile)) {
        $update_error = "Sorry, there was an error uploading files.";
        break;
      }

      // Save file names for database update
      $fileNames[$fileName] = $targetFile;
    }
  }

  // Update database with file paths
  foreach ($fileNames as $key => $file) {
    $query = "UPDATE `$projectType` SET `$key`=?, `updateDate` = NOW() WHERE `projectID`=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $file, $projectID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) <= 0) {
      $update_error = "Error updating images.";
      break;
    } else {
      $update_success = "Images uploaded successfully.";
    }

    mysqli_stmt_close($stmt);
  }
}


if (isset($_POST["updateRoad"])) {
  $projectID = $_POST['projectID'];
  $projectType = $_POST['projectType'];
  $earthwork = mysqli_real_escape_string($conn, $_POST["earth"]);
  $surface = mysqli_real_escape_string($conn, $_POST["surface"]);
  $drainage = mysqli_real_escape_string($conn, $_POST["drain"]);
  $util = mysqli_real_escape_string($conn, $_POST["util"]);

  // Update project progress
  $query = "UPDATE `$projectType` SET `earthwork`=?, `roadsurface`=?, `drainage`=?, `utilities`=?, `updateDate` = NOW() WHERE `projectID`=?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "iiiii", $earthwork, $surface, $drainage, $util, $projectID);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Update successful
    $update_success = "Project progress updated successfully.";
  } else {
    $update_success = "Nothing changed.";
  }

  mysqli_stmt_close($stmt);

  // Handle file uploads for project images
  $targetDirectory =  "../assets/project_pic/";
  $fileNames = [];

  for ($i = 1; $i <= 5; $i++) {
    $fileName = 'pic' . $i;
    if (isset($_FILES[$fileName]) && $_FILES[$fileName]['error'] === UPLOAD_ERR_OK) {
      $targetFile = $targetDirectory . basename($_FILES[$fileName]['name']);

      // Check file size
      if ($_FILES[$fileName]['size'] > 5000000) {
        $update_error = "Sorry, file size too large (5MB limit).";
        break;
      }

      // Allow certain file formats
      $allowedFormats = ["jpg", "jpeg", "png", "gif"];
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

      if (!in_array($imageFileType, $allowedFormats)) {
        $update_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        break;
      }

      if (!move_uploaded_file($_FILES[$fileName]['tmp_name'], $targetFile)) {
        $update_error = "Sorry, there was an error uploading files.";
        break;
      }

      // Save file names for database update
      $fileNames[$fileName] = $targetFile;
    }
  }

  // Update database with file paths
  foreach ($fileNames as $key => $file) {
    $query = "UPDATE `$projectType` SET `$key`=?, `updateDate` = NOW()  WHERE `projectID`=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $file, $projectID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) <= 0) {
      $update_error = "Error updating images.";
      break;
    } else {
      $update_success = "Images uploaded successfully.";
    }

    mysqli_stmt_close($stmt);
  }
}


if (isset($_POST["updateCourt"])) {
  $projectID = $_POST['projectID'];
  $projectType = $_POST['projectType'];
  $foundation = mysqli_real_escape_string($conn, $_POST["foundation"]);
  $roofing = mysqli_real_escape_string($conn, $_POST["roofing"]);
  $walls = mysqli_real_escape_string($conn, $_POST["walls"]);
  $flooring = mysqli_real_escape_string($conn, $_POST["flooring"]);
  $util = mysqli_real_escape_string($conn, $_POST["util"]);

  // Update project progress
  $query = "UPDATE `$projectType` SET `foundation`=?, `roofing`=?, `walls`=?, `flooring`=?, `utilities`=?, `updateDate` = NOW() WHERE `projectID`=?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "iiiiii", $foundation, $roofing, $walls, $flooring, $util, $projectID);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Update successful
    $update_success = "Project progress updated successfully.";
  } else {
    $update_success = "Nothing changed.";
  }

  mysqli_stmt_close($stmt);

  // Handle file uploads for project images
  $targetDirectory =  "../assets/project_pic/";
  $fileNames = [];

  for ($i = 1; $i <= 5; $i++) {
    $fileName = 'pic' . $i;
    if (isset($_FILES[$fileName]) && $_FILES[$fileName]['error'] === UPLOAD_ERR_OK) {
      $targetFile = $targetDirectory . basename($_FILES[$fileName]['name']);

      // Check file size
      if ($_FILES[$fileName]['size'] > 5000000) {
        $update_error = "Sorry, file size too large (5MB limit).";
        break;
      }

      // Allow certain file formats
      $allowedFormats = ["jpg", "jpeg", "png", "gif"];
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

      if (!in_array($imageFileType, $allowedFormats)) {
        $update_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        break;
      }

      if (!move_uploaded_file($_FILES[$fileName]['tmp_name'], $targetFile)) {
        $update_error = "Sorry, there was an error uploading files.";
        break;
      }

      // Save file names for database update
      $fileNames[$fileName] = $targetFile;
    }
  }

  // Update database with file paths
  foreach ($fileNames as $key => $file) {
    $query = "UPDATE `$projectType` SET `$key`=?, `updateDate` = NOW() WHERE `projectID`=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $file, $projectID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) <= 0) {
      $update_error = "Error updating images.";
      break;
    } else {
      $update_success = "Images uploaded successfully.";
    }

    mysqli_stmt_close($stmt);
  }
}


if (isset($_POST["updateHauling"])) {
  $projectID = $_POST['projectID'];
  $projectType = $_POST['projectType'];
  $debris = mysqli_real_escape_string($conn, $_POST["debris"]);
  $transport = mysqli_real_escape_string($conn, $_POST["transport"]);


  // Update project progress
  $query = "UPDATE `$projectType` SET `removal`=?, `transport`=?, `updateDate` = NOW() WHERE `projectID`=?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "iii", $debris, $transport, $projectID);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    // Update successful
    $update_success = "Project progress updated successfully.";
  } else {
    $update_success = "Nothing changed.";
  }

  mysqli_stmt_close($stmt);

  // Handle file uploads for project images
  $targetDirectory =  "../assets/project_pic/";
  $fileNames = [];

  for ($i = 1; $i <= 5; $i++) {
    $fileName = 'pic' . $i;
    if (isset($_FILES[$fileName]) && $_FILES[$fileName]['error'] === UPLOAD_ERR_OK) {
      $targetFile = $targetDirectory . basename($_FILES[$fileName]['name']);

      // Check file size
      if ($_FILES[$fileName]['size'] > 5000000) {
        $update_error = "Sorry, file size too large (5MB limit).";
        break;
      }

      // Allow certain file formats
      $allowedFormats = ["jpg", "jpeg", "png", "gif"];
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

      if (!in_array($imageFileType, $allowedFormats)) {
        $update_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        break;
      }

      if (!move_uploaded_file($_FILES[$fileName]['tmp_name'], $targetFile)) {
        $update_error = "Sorry, there was an error uploading files.";
        break;
      }

      // Save file names for database update
      $fileNames[$fileName] = $targetFile;
    }
  }

  // Update database with file paths
  foreach ($fileNames as $key => $file) {
    $query = "UPDATE `$projectType` SET `$key`=?, `updateDate` = NOW() WHERE `projectID`=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $file, $projectID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) <= 0) {
      $update_error = "Error updating images.";
      break;
    } else {
      $update_success = "Images uploaded successfully.";
    }

    mysqli_stmt_close($stmt);
  }
}
