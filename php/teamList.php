<?php
session_start();
include 'db_connection.php';
include 'login.php';
include 'createTeam.php';

if (!isset($_SESSION["ID"])) {
    header("location: ../admin.php");
    exit();
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
    <link href="../assets/css/teamList.css" rel="stylesheet">
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#project" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-contract"></i></div>
                            Project Contract
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="project" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="projectList.php">Project Lists</a>
                                <a class="nav-link" href="delivery.php">Materials Deliveries</a>
                            </nav>
                        </div>
                        <a class="nav-link active collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#team" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-people-group"></i></div>
                            Company Team
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="team" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="emplist.php">Employee Lists</a>
                                <a class="nav-link active" href="teamList.php">Project Teams </a>
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

            if ($success) {
                echo '<label class="text-sucess success" id="alert">' . $success . '</label>';
            }
            ?>
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h1 class="mt-3 mb-2">Project Teams</h1>
                    <div class="d-flex justify-content-end me-1">
                        <button type="button" class="add-btn p-2" data-bs-toggle="modal" data-bs-target="#create-team">
                            <i class="fas fa-plus fa-sm" style="color: #ffffff;"></i> Create Team
                        </button>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Team Name</th>
                                        <th>Engineer</th>
                                        <th>Foreman</th>
                                        <th>Workers</th>
                                        <th>Projects</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM `team`";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $teamID = $row['ID'];
                                        $teamName = $row["teamName"];


                                        $queryEngineer = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Engineer' ";
                                        $resultEngineer = mysqli_query($conn, $queryEngineer);

                                        // Check if there are results
                                        if ($resultEngineer && mysqli_num_rows($resultEngineer) > 0) {
                                            $rowEngineer = mysqli_fetch_array($resultEngineer);
                                            $engineerID = $rowEngineer['ID'];
                                            $nameEngineer = $rowEngineer['fname'] . " " . $rowEngineer['lname'];
                                        } else {
                                            // Handle case where no engineer is found for the team
                                            $engineerID = null;
                                            $nameEngineer = "Select a engineer"; // or any default name
                                        }

                                        $queryForeman = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Foreman' ";
                                        $resultForeman = mysqli_query($conn, $queryForeman);

                                        // Check if there are results
                                        if ($resultForeman && mysqli_num_rows($resultForeman) > 0) {
                                            $rowForeman = mysqli_fetch_array($resultForeman);
                                            $foremanID = $rowForeman['ID'];
                                            $nameForeman = $rowForeman['fname'] . " " . $rowForeman['lname'];
                                        } else {

                                            $foremanID = null;
                                            $nameForeman = "Select a foreman.";
                                        }

                                        $queryWorker = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Worker' ";
                                        $resultWorker = mysqli_query($conn, $queryWorker);

                                    ?>
                                        <tr>

                                            <td><?php echo $teamName; ?></td>
                                            <td> <?php echo $nameEngineer; ?></td>
                                            <td> <?php echo $nameForeman; ?></td>
                                            <td>
                                                <button class="add-btn fs-6" data-bs-toggle="modal" data-bs-target="#view-workers<?php echo $teamID; ?>">
                                                    <i class=" fa-solid fa-eye fa-xs me-1" style="color: #ffffff;"></i>View</button>
                                            </td>
                                            <td>
                                                <button class="add-btn fs-6" data-bs-toggle="modal" data-bs-target=#view-project<?php echo $teamID; ?>>
                                                    <i class=" fa-solid fa-eye fa-xs me-1" style="color: #ffffff;"></i>View</button>
                                            </td>
                                            <td>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#update-team<?php echo $teamID; ?> "><i class="fas fa-pen-to-square fa-lg" style="color: #13a300;"></i></button>

                                            </td>
                                        </tr>

                                        <!-- View Workers Name-->
                                        <div class="modal fade" id="view-workers<?php echo $teamID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content ">
                                                    <div class="modal-header ">
                                                        <h1 class="modal-title fs-3 mx-auto">All Workers</h1>
                                                    </div>

                                                    <div class="modal-body text-start">
                                                        <ol>
                                                            <?php
                                                            $queryWorker = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Worker'";
                                                            $resultWorker = mysqli_query($conn, $queryWorker);

                                                            if ($resultWorker && mysqli_num_rows($resultWorker) > 0) {
                                                                while ($rowWorker = mysqli_fetch_array($resultWorker)) {
                                                                    $nameWorker = $rowWorker['fname'] . " " . $rowWorker['lname'];
                                                            ?>
                                                                    <li class="fs-5"><?php echo $nameWorker; ?></li>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <div class="text-center fs-4">
                                                                    <p>No workers found.</p>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ol>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Projects-->
                                        <div class="modal fade" id="view-project<?php echo $teamID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content ">
                                                    <div class="modal-header ">
                                                        <h1 class="modal-title fs-2 mx-auto">Projects of <?php echo $teamName; ?></h1>
                                                    </div>

                                                    <div class="modal-body text-start">
                                                        <?php
                                                        $queryProject = "SELECT * FROM project WHERE teamID = $teamID";
                                                        $resultProject = mysqli_query($conn, $queryProject);
                                                        $ongoingDisplayed = false;

                                                        if ($resultProject && mysqli_num_rows($resultProject) > 0) {
                                                            while ($rowProject = mysqli_fetch_array($resultProject)) {
                                                                $status = $rowProject['status'];

                                                                if ($status == "On-Going" && !$ongoingDisplayed) {
                                                        ?>
                                                                    <div class="mb-3">
                                                                        <label for="ongoing" class="col-form-label fs-5 fw-medium me-1">On-Going:</label>
                                                                        <a class="ongoing" href="projectDetails.php?id=<?php echo $rowProject['ID']; ?>&type=<?php echo $rowProject['projectType']; ?>"><?php echo $rowProject['projectName']; ?></a>
                                                                    </div>
                                                            <?php
                                                                    $ongoingDisplayed = true;
                                                                }
                                                            }

                                                            mysqli_data_seek($resultProject, 0); // Reset result set pointer to fetch finished projects again

                                                            ?>
                                                            <!-- Display finished projects -->
                                                            <div class="mb-3 fs-5 fw-medium">
                                                                <label for="finished" class="col-form-label">Finished:</label>
                                                                <ol>
                                                                    <?php
                                                                    while ($rowProject = mysqli_fetch_array($resultProject)) {
                                                                        $status = $rowProject['status'];
                                                                        if ($status == "Finished") {
                                                                    ?>
                                                                            <li><a class="finished" href="projectDetails.php?id=<?php echo $rowProject['ID']; ?>&type=<?php echo $rowProject['projectType']; ?>"><?php echo $rowProject['projectName']; ?></a></li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ol>
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="text-center fs-4">
                                                                <p>No projects found.</p>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Update Team Modal-->
                                        <div class="modal fade" id="update-team<?php echo $teamID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticSchedule">Update Team</h1>
                                                    </div>

                                                    <?php
                                                    $queryEngineer = "SELECT * FROM `employee` WHERE ( position = 'Engineer' AND `teamID` IS NULL) OR (`teamID` IS NOT NULL AND `teamID` != $teamID AND position = 'Engineer')";
                                                    $resultEngineer = mysqli_query($conn, $queryEngineer);

                                                    $queryForeman = "SELECT * FROM `employee` WHERE ( position = 'Foreman' AND `teamID` IS NULL) OR (`teamID` IS NOT NULL AND `teamID` != $teamID AND position = 'Foreman') ";
                                                    $resultForeman = mysqli_query($conn, $queryForeman);

                                                    $queryWorker = "SELECT * FROM `employee` WHERE ( position = 'Worker' AND `teamID` IS NULL) OR (`teamID` IS NOT NULL AND `teamID` != $teamID AND position = 'Worker')";
                                                    $resultWorker = mysqli_query($conn, $queryWorker);
                                                    ?>

                                                    <div class="modal-body text-start">
                                                        <form method="post" action="#">
                                                            <div class="mb-3">
                                                                <label for="teamName" class="col-form-label">Team Name:</label>
                                                                <input type="text" class="form-control" id="teamName" name="teamName" autocomplete="off" required="on" value="<?php echo $teamName; ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="engineer" class="col-form-label">Engineer:</label>
                                                                <select name="teamEngineer" class="form-select" aria-label="Default select example">
                                                                    <option selected value="<?php echo $engineerID; ?>"><?php echo $nameEngineer; ?></option>
                                                                    <?php
                                                                    while ($row = mysqli_fetch_array($resultEngineer)) {
                                                                    ?>
                                                                        <option value="<?php echo $row['ID'] ?>"><?php echo $row['fname'] . ' ' . $row['lname']; ?></option>

                                                                    <?php } ?>
                                                                </select>
                                                            </div>


                                                            <div class="mb-3">
                                                                <label for="engineer" class="col-form-label">Foreman:</label>
                                                                <select name="teamForeman" class="form-select" aria-label="Default select example">
                                                                    <?php if ($nameForeman) { ?>
                                                                        <option selected value="<?php echo  $foremanID; ?>"><?php echo $nameForeman; ?></option>
                                                                    <?php } else { ?>
                                                                        <option selected disabled>Select Engineer</option>
                                                                    <?php } ?>

                                                                    <?php
                                                                    while ($row = mysqli_fetch_array($resultForeman)) {
                                                                    ?>
                                                                        <option value="<?php echo $row['ID'] ?>"><?php echo $row['fname'] . ' ' . $row['lname']; ?></option>

                                                                    <?php } ?>
                                                                </select>
                                                            </div>


                                                            <div class="mb-3">
                                                                <label for="workers" class="col-form-label">Select Workers:</label>

                                                                <?php
                                                                $querySelectedWorker = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Worker' ";
                                                                $resultSelectedWorker = mysqli_query($conn, $querySelectedWorker);

                                                                while ($rowWorker = mysqli_fetch_array($resultSelectedWorker)) {
                                                                    $workerID = $rowWorker['ID'];
                                                                    $nameWorker = $rowWorker['fname'] . ' ' . $rowWorker['lname'];
                                                                    $isChecked = ($rowWorker['teamID'] == $teamID) ? 'checked' : '';
                                                                ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="selectedWorkers[]" value="<?php echo $workerID ?>" id="worker" <?php echo $isChecked; ?>>
                                                                        <label class="form-check-label" for="worker"><?php echo $nameWorker; ?></label>
                                                                    </div>
                                                                <?php } ?>

                                                                <?php
                                                                while ($row = mysqli_fetch_array($resultWorker)) {
                                                                ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="selectedWorkers[]" value="<?php echo $row['ID'] ?>" id="worker">
                                                                        <label class="form-check-label" for="worker"><?php echo $row['fname'] . ' ' . $row['lname']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <input type="hidden" name="teamID" value="<?php echo $teamID; ?>">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="update" name="update" class="btn btn-primary">Update</button>
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

    <!-- Create Team Modal-->
    <div class="modal fade" id="create-team" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Create Team</h1>
                </div>

                <?php
                $queryEngineer = "SELECT * FROM `employee` WHERE position = 'Engineer' AND `teamID` IS NULL";
                $resultEngineer = mysqli_query($conn, $queryEngineer);

                $queryForeman = "SELECT * FROM `employee` WHERE position = 'Foreman' AND `teamID` IS NULL";
                $resultForeman = mysqli_query($conn, $queryForeman);

                $queryWorker = "SELECT * FROM `employee` WHERE position = 'Worker' AND `teamID` IS NULL";
                $resultWorker = mysqli_query($conn, $queryWorker);
                ?>

                <div class="modal-body text-start">
                    <form method="post" action="#">
                        <div class="mb-3">
                            <label for="teamName" class="col-form-label">Team Name:</label>
                            <input type="text" class="form-control" id="teamName" name="teamName" autocomplete="off" required="on">
                        </div>

                        <div class="mb-3">
                            <label for="engineer" class="col-form-label">Engineer:</label>
                            <select name="teamEngineer" class="form-select" aria-label="Default select example">
                                <option selected disabled>Select Engineer</option>
                                <?php
                                while ($row = mysqli_fetch_array($resultEngineer)) {
                                ?>
                                    <option value="<?php echo $row['ID'] ?>"><?php echo $row['fname'] . ' ' . $row['lname']; ?></option>

                                <?php } ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="Foreman" class="col-form-label">Foreman:</label>
                            <select name="teamForeman" class="form-select" aria-label="Default select example">
                                <option selected disabled>Select Foreman</option>
                                <?php
                                while ($row = mysqli_fetch_array($resultForeman)) {
                                ?>
                                    <option value="<?php echo $row['ID'] ?>"><?php echo $row['fname'] . ' ' . $row['lname']; ?></option>

                                <?php } ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="workers" class="col-form-label">Select Workers:</label>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultWorker)) {
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="selectedWorkers[]" value="<?php echo $row['ID'] ?>" id="worker">
                                    <label class="form-check-label" for="worker"><?php echo $row['fname'] . ' ' . $row['lname']; ?></label>
                                </div>
                            <?php } ?>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="create" name="create" class="btn btn-primary">Create</button>
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