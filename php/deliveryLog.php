<?php
session_start();
include 'db_connection.php';
include 'login.php';
include 'deliveryMaterials.php';

if (!isset($_SESSION["ID"])) {
    header("location: ../admin.php");
    exit();
}



$projectID = $_GET['id'];
$status = $_GET['status'];
$projectName = $_GET['projectName'];
$projectCode = $_GET['projectCode'];


/*if (isset($_POST["finish"])) {
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
}*/


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
    <link href="../assets/css/deliveryLog.css" rel="stylesheet">
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
            ?>
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h3 class="mt-3 mb-4">Materials Deliveries on <?php echo $projectName . " / Project Code: " . $projectCode ?></h3>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Concrete and Cement</th>
                                        <th>Lumber and Wood</th>
                                        <th>Steel and Metal</th>
                                        <th>Aggregates</th>
                                        <th>Masonry Materials</th>
                                        <th>Roofing Materials</th>
                                        <th>Finishing Materials</th>
                                        <th>Delivery Date</th>
                                        <th>Delivery Time</th>
                                        <?php if ($status == 'On-Going') { ?>
                                            <th>Update</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $query = "SELECT * FROM `materials` WHERE `projectID` = $projectID ";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['concrete']; ?></td>
                                            <td><?php echo $row['lumber']; ?></td>
                                            <td><?php echo $row['steel']; ?></td>
                                            <td><?php echo $row['aggregates']; ?></td>
                                            <td><?php echo $row['bricks']; ?></td>
                                            <td><?php echo $row['roofing']; ?></td>
                                            <td><?php echo $row['finishing']; ?></td>
                                            <td><?php echo $row['deliDate']; ?></td>
                                            <td><?php echo $row['deliTime']; ?></td>
                                            <?php if ($status == 'On-Going') { ?>
                                                <td>
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#update-materials<?php echo $row['ID']; ?> "><i class="fas fa-pen-to-square fa-lg" style="color: #13a300;"></i></button>
                                                </td>
                                            <?php } ?>
                                        </tr>


                                        <!-- Update Materials Modal-->
                                        <div class="modal fade" id="update-materials<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticSchedule">Update delivery materials details.</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body text-start">
                                                        <form method="post" action="#">

                                                            <!-- Input for Concrete and Cement -->
                                                            <div class="mb-3">
                                                                <label for="concrete">Concrete and Cement (in cubic meters/yards):</label>
                                                                <input type="text" class="form-control" id="concrete" name="concrete" required autocomplete="off" value="<?php echo $row['concrete']; ?>">
                                                            </div>

                                                            <!-- Input for Lumber and Wood Products -->
                                                            <div class="mb-3">
                                                                <label for="lumber">Lumber and Wood Products (size/pieces):</label>
                                                                <input type="text" class="form-control" id="lumber" name="lumber" required autocomplete="off" value="<?php echo $row['lumber']; ?>">
                                                            </div>

                                                            <!-- Input for Steel and Metal Products -->
                                                            <div class="mb-3">
                                                                <label for="steel">Steel and Metal Products (in tons/lengths):</label>
                                                                <input type="text" class="form-control" id="steel" name="steel" required autocomplete="off" value="<?php echo $row['steel']; ?>">
                                                            </div>

                                                            <!-- Input for Aggregates -->
                                                            <div class="mb-3">
                                                                <label for="aggregates">Aggregates (in tons):</label>
                                                                <input type="text" class="form-control" id="aggregates" name="aggregates" required autocomplete="off" value="<?php echo $row['aggregates']; ?>">
                                                            </div>

                                                            <!-- Input for Bricks, Blocks, and Masonry Materials -->
                                                            <div class="mb-3">
                                                                <label for="bricks">Bricks, Blocks, and Masonry Materials (number of units):</label>
                                                                <input type="text" class="form-control" id="bricks" name="bricks" required autocomplete="off" value="<?php echo $row['bricks']; ?>">
                                                            </div>

                                                            <!-- Input for Roofing Materials -->
                                                            <div class="mb-3">
                                                                <label for="roofing">Roofing Materials (number of units):</label>
                                                                <input type="text" class="form-control" id="roofing" name="roofing" required autocomplete="off" value="<?php echo $row['roofing']; ?>">
                                                            </div>

                                                            <!-- Input for Finishing Materials -->
                                                            <div class="mb-3">
                                                                <label for="finishing">Finishing Materials (number of units):</label>
                                                                <input type="text" class="form-control" id="finishing" name="finishing" required autocomplete="off" value="<?php echo $row['finishing']; ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="deliDate" class="col-form-label who">Delivery Date:</label>
                                                                <input type="date" class="form-control" id="deliDate" name="deliDate" required value="<?php echo $row['deliDate']; ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="deliTime" class="col-form-label who">Delivery Time:</label>
                                                                <input type="time" class="form-control" id="deliTime" name="deliTime" required value="<?php echo $row['deliTime']; ?>">
                                                            </div>

                                                            <div class="modal-footer">
                                                                <input type="hidden" name="materialsID" value="<?php echo $row["ID"]; ?>">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" id="updateMaterials" name="updateMaterials" class="btn btn-primary">Update</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex  justify-content-center">
                        <a class="add-btn" href="delivery.php" role="button">Back</a>
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