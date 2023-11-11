<?php
session_start();
include 'db_connection.php';
include 'login.php';

if (!isset($_SESSION["ID"])) {
    header("location: ../admin.php");
    exit();
}


$update_success = $update_error = $targetFile = "";

if (isset($_POST["update"])) {
    $employeeID = $_POST['employee_id'];
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $contact = mysqli_real_escape_string($conn, $_POST["number"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $position = mysqli_real_escape_string($conn, $_POST["position"]);
    $targetFile = "";

    if (!preg_match('/^[0-9+]+$/', $contact)) {
        $update_error = "Contact number should contain only numbers";
    } else {

        $query = "SELECT `number`, `fname`, `lname`, `emp_img` FROM `employee` WHERE `number` = ? AND `fname` = ? AND `lname` = ? AND  `ID` != ? ";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $contact, $fname,  $lname,   $employeeID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $update_error = "Employee with the same details already exists.";
        } else {
            // Update the employee details without changing the image
            $query = "UPDATE `employee` SET `fname`=?, `lname`=?, `number`=?, `gender`=?, `position`=? WHERE `ID`=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssssi", $fname, $lname, $contact, $gender, $position, $employeeID);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Update successful
                $update_success = "Employee details updated successfully.";
            } else {

                $update_success = "Nothing change.";
            }

            mysqli_stmt_close($stmt);

            // Handle file upload if a file is provided
            if (isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {
                $targetDirectory = "../assets/emp_pic/";
                $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);

                // Check file size (you can adjust the file size limit)
                if ($_FILES["file"]["size"] > 5000000) {
                    $update_error = "Sorry, your file is too large. 5mb is the limit only";
                } else {
                    // Allow certain file formats
                    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    if (!in_array($imageFileType, $allowedFormats)) {
                        $update_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    } else {
                        // Move the uploaded file
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                            // Update the employee image
                            $query = "UPDATE `employee` SET `emp_img`=? WHERE `ID`=?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "si", $targetFile, $employeeID);
                            mysqli_stmt_execute($stmt);

                            if (mysqli_stmt_affected_rows($stmt) > 0) {
                                // Image update successful
                                $update_success = "Employee image updated successfully.";
                            } else {
                                // Image update failed
                                $update_error = "Error updating employee image.";
                            }

                            mysqli_stmt_close($stmt);
                        } else {
                            $update_error = "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            }
        }
    }
}

if (isset($_POST["delete"])) {
    $employeeID = $_POST['employee_id'];
    $query = "DELETE FROM `employee` WHERE `ID` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $employeeID);
    mysqli_stmt_execute($stmt);
    $update_success = "The employee has been removed from the list.";
    mysqli_stmt_close($stmt);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin</title>
    <link rel="shortcut icon" href="../assets/images/ros-icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.3.0/dist/style.min.css">
    <link href="../assets/css/allList.css" rel="stylesheet">
    <script src="../assets/js/all.js"></script>
    <script src="../assets/js/date.js"></script>



</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-logo1">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-5" href="dashboard.php">
            <img src="../assets/images/ros.jpg" alt="">
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-lg-0 me-6 me-lg-4 " id="sidebarToggle" href="#"><i class="fas fa-bars fa-xl"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-2">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-xl"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>


    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion bg-logo2" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Admin Menu</div>
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#appoitment" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                            Appointment
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="appoitment" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="appointment.php">Appointment Scheduled</a>
                                <a class="nav-link " href="inquiries.php">Inquiries</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-contract"></i></div>
                            Contract Project
                        </a>
                        <a class="nav-link active collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#team" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-people-group"></i></div>
                            Company Team
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="team" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link active" href="emplist.php">Employee List</a>
                                <a class="nav-link" href="#">Project Team </a>
                            </nav>
                        </div>

                    </div>
                </div>
                <div class="sb-sidenav-footer bg-logo1">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <?php
            if ($update_success) {
                echo '<label class="text-sucess success" id="alert">' . $update_success . '</label>';
            }
            if ($update_error) {
                echo '<label class="text-danger error" id="alert">' . $update_error . '</label>';
            }
            ?>
            <main>
                <?php
                if (isset($_GET['position'])) {
                    $position = mysqli_real_escape_string($conn, $_GET['position']);
                    $query = "SELECT * FROM `employee` WHERE `position` = '$position'";
                    $result = mysqli_query($conn, $query);
                ?>
                    <div class="container-fluid px-4">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item active"></li>
                        </ol>
                        <?php
                        if ($position == "Engineer") {
                            echo '<h1 class="mt-3 mb-4">Engineers</h1>';
                        } else if ($position == "Forman") {
                            echo '<h1 class="mt-3 mb-4">Formen</h1>';
                        } else if ($position == "Worker") {
                            echo '<h1 class="mt-3 mb-4">Workers</h1>';
                        } else if ($position == "Human Resource") {
                            echo '<h1 class="mt-3 mb-4">Human Resources</h1>';
                        }
                        ?>


                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Contact Number</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>
                                                <td><img src="<?php echo $row["emp_img"]; ?>" alt="Profile Photo" width="50" height="50" class="border border-secondary"></td>
                                                <td><?php echo $row["fname"]; ?></td>
                                                <td><?php echo $row["lname"]; ?></td>
                                                <td><?php echo $row["number"]; ?></td>
                                                <td><?php echo $row["gender"]; ?></td>
                                                <td>
                                                    <button type="button" class="popover pop1" data-bs-toggle="modal" data-bs-target="#update<?php echo $row['ID']; ?>"><i class="fas fa-pen-to-square fa-2xl" style="color: #13a300;"></i></button>
                                                    <button type="button" class="popover pop2" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['ID']; ?>"><i class="fas fa-trash fa-2xl" style="color: #ff0000;"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="update<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticSchedule">Update Employee</h1>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <form method="post" action="#" enctype="multipart/form-data">

                                                                <div class="d-flex flex-column  align-items-center">
                                                                    <img src="<?php echo $row["emp_img"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                                                                    <p>Upload Image</p>
                                                                    <div class="input-group mb-4">
                                                                        <input type="file" class="form-control" id="inputGroupFile02" name="file">
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="fname" class="col-form-label">First Name:</label>
                                                                    <input type="text" class="form-control" id="fname" name="fname" autocomplete="off" required="on" value="<?php echo $row["fname"]; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="lname" class="col-form-label">Last Name:</label>
                                                                    <input type="text" class="form-control" id="lname" name="lname" autocomplete="off" required="on" value="<?php echo $row["lname"]; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="number" class="col-form-label">Contact Number:</label>
                                                                    <input type="text" maxlength="11" class="form-control" type="text" name="number" id="number" autocomplete="off" required="on" value="<?php echo $row["number"]; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <select name="gender" class="form-select" aria-label="Default select example">
                                                                        <option selected value="<?php echo $row["gender"]; ?>"><?php echo $row["gender"]; ?></option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <select name="position" class="form-select" aria-label="Default select example">
                                                                        <option selected value="<?php echo $row["position"]; ?>"><?php echo $row["position"]; ?></option>
                                                                        <option value="Engineer">Engineer</option>
                                                                        <option value="Forman">Forman</option>
                                                                        <option value="Worker">Worker</option>
                                                                        <option value="Human Resource">Human Resource</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="employee_id" value="<?php echo $row['ID']; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" id="update" name="update" class="btn btn-primary">Update</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h2 class="modal-title fs-5" id="staticView">Are you sure this scheduled appointment done?</h2>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <form method="post" action="#">
                                                                <h5>This will be deleted from the list.</h5>
                                                                <input type="hidden" name="employee_id" value="<?php echo $row["ID"]; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" id="delete" name="delete" class="btn btn-success" data-bs-toggle="modal">Yes</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex flex-column  align-items-center">
                            <a class="back" href="emplist.php" role="button">Back</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">&copy; R.O.Salas Construction. All rights reserved</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.3.0/dist/umd/simple-datatables.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/side.js"></script>
    <script src="../assets/js/table.js"></script>
    <script>
        setTimeout(function() {
            var alert = document.getElementById('alert');
            if (alert) {
                alert.remove();
            }
        }, 3500);
    </script>
</body>

</html>