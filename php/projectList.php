<?php
session_start();
include 'db_connection.php';
include 'login.php';
include 'createProject.php';

if (!isset($_SESSION["ID"])) {
    header("location: ../admin.php");
    exit();
}

if (isset($_POST["finish"])) {
    $projectID = mysqli_real_escape_string($conn, $_POST["id"]);

    $query1 = "UPDATE `project` SET `status` = 'Finished' WHERE `ID`= ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $projectID);
    mysqli_stmt_execute($stmt1);

    if ($stmt1) {
        $query2 = "UPDATE `team` SET `projectID` = NULL WHERE `projectID`= ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "i", $projectID);
        mysqli_stmt_execute($stmt2);

        if ($stmt2) {
            $success = "The project has been finished and moved to the finished project list.";
        } else {
            $error = "Error updating team project ID.";
        }
    } else {
        $error = "Error updating project status.";
    }
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
    <link href="../assets/css/projectList.css" rel="stylesheet">
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
                        <a class="nav-link active collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#project" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-contract"></i></div>
                            Project Contract
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="project" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link active" href="projectList.php">Project Lists</a>
                                <a class="nav-link" href="delivery.php">Materials Deliveries</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#team" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-people-group"></i></div>
                            Company Team
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="team" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="emplist.php">Employee Lists</a>
                                <a class="nav-link" href="teamList.php">Project Teams </a>
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

            if ($success) {
                echo '<label class="text-sucess success" id="alert">' . $success . '</label>';
            }

            if ($error) {
                echo '<label class="text-error error" id="alert">' . $error . '</label>';
            }

            ?>
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h1 class="mt-3 mb-4">Project List</h1>

                    <div class="d-flex justify-content-between mx-1">
                        <a href="finishProject.php" class="add-btn p-2">
                            <i class="fa-solid fa-circle-check fa-sm me-2" style="color: #ffffff;"></i>Finished Project
                        </a>
                        <button type="button" class="add-btn p-2" data-bs-toggle="modal" data-bs-target="#createProject">
                            <i class="fas fa-plus fa-sm" style="color: #ffffff;"></i> Create Project
                        </button>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Project Status</th>
                                        <th>Deadline</th>
                                        <th>Details</th>
                                        <th>Finish</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $query = "SELECT * FROM `project` WHERE `status` = 'On-going'";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['projectCode']; ?></td>
                                            <td><?php echo $row['projectType']; ?></td>
                                            <td><?php echo $row['projectName']; ?></td>
                                            <td>
                                                <button type="button" class="btn bg-success text-white fw-bold" disabled><?php echo $row['status']; ?></button>
                                            </td>
                                            <td><?php echo $row['deadline']; ?></td>
                                            <td>
                                                <a href="projectDetails.php?id=<?php echo $row['ID']; ?>&type=<?php echo $row['projectType']; ?>" class="add-btn fs-6">
                                                    <i class="fa-solid fa-eye fa-xs me-1" style="color: #ffffff;"></i>View</a>
                                            </td>
                                            <td>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#done<?php echo $row['ID']; ?>"><i class="fas fa-circle-check fa-xl" style="color: #35f500;"></i></button>
                                            </td>
                                        </tr>

                                        <!-- Done Project Modal-->
                                        <div class="modal fade" id="done<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h2 class="modal-title fs-5" id="staticView">Are you sure this project is finished?</h2>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <form method="post" action="#">
                                                            <h5>This will be remove from the list.</h5>
                                                            <input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="finish" name="finish" class="btn btn-success" data-bs-toggle="modal">Yes</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

    <!-- Create Project Modal-->
    <div class="modal fade" id="createProject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Create Project Contract</h1>
                </div>

                <?php
                $query = "SELECT * FROM `team` WHERE projectID IS NULL";
                $result = mysqli_query($conn, $query);
                ?>
                <div class="modal-body text-start">
                    <form method="post" action="#">

                        <div class="mb-3">
                            <label for="projectCode" class="col-form-label">Project Code:</label>
                            <div class="input-group">
                                <span class="input-group-text">ROS-</span>
                                <input type="text" class="form-control" id="projectCode" name="projectCode" autocomplete="off" required maxlength="6">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="projectType" class="col-form-label">Project Type:</label>
                            <select name="projectType" class="form-select" aria-label="Default select example" required>
                                <option selected disabled>Select Project Type</option>
                                <option>House/Building</option>
                                <option>Road/Highway</option>
                                <option>Covered Court</option>
                                <option>Hauling Transport</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="projectName" class="col-form-label">Project Name:</label>
                            <input type="text" class="form-control" id="projectName" name="projectName" autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                            <label for="projectCost" class="col-form-label">Project Cost:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="projectCost" name="projectCost" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="col-form-label">Location:</label>
                            <input type="text" class="form-control" id="location" name="location" autocomplete="off" required>
                        </div>

                        <div class="mb-3">
                            <label for="startDate" class="col-form-label who">Start Date:</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>

                        <div class="mb-3">
                            <label for="deadline" class="col-form-label who">Deadline:</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div>

                        <div class="mb-3">
                            <label for="team" class="col-form-label">Select Team:</label>
                            <select name="team" class="form-select" aria-label="Default select example" required>
                                <option selected disabled>Select Team</option>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?php echo $row['ID'] ?>"><?php echo $row['teamName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="createProject" name="createProject" class="btn btn-primary">Create</button>
                </div>

                </form>
            </div>
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