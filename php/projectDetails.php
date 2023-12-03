<?php
session_start();
include 'db_connection.php';
include 'updatePD.php';
include 'login.php';

if (!isset($_SESSION["ID"])) {
    header("location: ../admin.php");
    exit();
}

$projectID = $_GET['id'];
$projectType = $_GET['type'];

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
    <link href="../assets/css/projectDetails.css" rel="stylesheet">
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
                                <a class="nav-link" href="inquiries.php">Inquiries</a>
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

            if ($update_success) {
                echo '<label class="text-sucess success" id="alert">' . $update_success . '</label>';
            }
            if ($update_error) {
                echo '<label class="text-danger error" id="alert">' . $update_error . '</label>';
            }

            ?>
            <main>
                <div class="container-fluid p-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h1 class="mt-3 mb-2">Project Details</h1>

                    <?php

                    $query = "SELECT * FROM `project` WHERE `ID` =  $projectID ";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_array($result);
                    $teamID = $row['teamID'];
                    $projectCode = $row['projectCode'];
                    $projectName = $row['projectName'];
                    $status = $row['status'];


                    $queryTeam = "SELECT * FROM `team` WHERE `ID` =  $teamID; ";
                    $resultTeam = mysqli_query($conn, $queryTeam);
                    $rowTeam = mysqli_fetch_array($resultTeam);

                    $queryEngineer = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Engineer' ";
                    $resultEngineer = mysqli_query($conn, $queryEngineer);

                    if ($resultEngineer && mysqli_num_rows($resultEngineer) > 0) {
                        $rowEngineer = mysqli_fetch_array($resultEngineer);
                        $engineerID = $rowEngineer['ID'];
                        $nameEngineer = $rowEngineer['fname'] . " " . $rowEngineer['lname'];
                    } else {
                        $engineerID = null;
                        $nameEngineer = "Assign an engineer to the project team.";
                    }

                    $queryForeman = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Foreman' ";
                    $resultForeman = mysqli_query($conn, $queryForeman);

                    if ($resultForeman && mysqli_num_rows($resultForeman) > 0) {
                        $rowForeman = mysqli_fetch_array($resultForeman);
                        $foremanID = $rowForeman['ID'];
                        $nameForeman = $rowForeman['fname'] . " " . $rowForeman['lname'];
                    } else {

                        $foremanID = null;
                        $nameForeman = "Assign an foreman to the project team.";
                    }

                    $queryWorker = "SELECT * FROM `employee` WHERE `teamID` = $teamID AND `position` = 'Worker' ";
                    $resultWorker = mysqli_query($conn, $queryWorker);
                    ?>

                    <div class="row">
                        <div class="card bg-body-secondary text-start mt-3 p-4">

                            <div class="mb-4 d-flex border-bottom border-secondary">
                                <h2 class="mb-3 me-2">Project Name:</h2>
                                <h2 class="mb-3"><?php echo $row['projectName']; ?></h2>
                            </div>

                            <div class="details d-flex justify-content-evenly">

                                <div class="column1">
                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Project Code:</h5>
                                        <p class="my-auto fs-5"><?php echo $row['projectCode']; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Project Type:</h5>
                                        <p class="my-auto fs-5"><?php echo $row['projectType']; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Project Cost:</h5>
                                        <p class="my-auto fs-5"><?php echo "₱" . $row['cost']; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Status:</h5>
                                        <p class="my-auto fs-5"><?php echo $status; ?></p>
                                    </div>
                                </div>

                                <div class="column2">
                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Start Date:</h5>
                                        <p class="my-auto fs-5"><?php echo $row['startingDate']; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Deadline:</h5>
                                        <p class="my-auto fs-5"><?php echo $row['deadline']; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Location:</h5>
                                        <p class="my-auto fs-5"><?php echo $row['location']; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Team:</h5>
                                        <p class="my-auto fs-5"><?php echo $rowTeam['teamName']; ?></p>
                                    </div>

                                </div>

                                <div class="column3">
                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Engineer:</h5>
                                        <p class="my-auto fs-5"><?php echo $nameEngineer; ?></p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="my-auto me-2">Foreman:</h5>
                                        <p class="my-auto fs-5"><?php echo $nameForeman ?></p>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="my-auto me-2">Workers:</h5>
                                        <ol class="mt-2">
                                            <?php
                                            if ($resultWorker && mysqli_num_rows($resultWorker) > 0) {
                                                while ($rowWorker = mysqli_fetch_array($resultWorker)) {
                                                    $nameWorker = $rowWorker['fname'] . " " . $rowWorker['lname'];
                                            ?>
                                                    <li class="mt-2"><?php echo $nameWorker; ?></li>
                                            <?php
                                                }
                                            } else {
                                                echo "Assign an workers to the project team.";
                                            } ?>
                                        </ol>
                                    </div>
                                </div>

                            </div>

                            <div class="my-3 d-flex border-bottom border-secondary ">
                                <h2 class="mb-3">Project Development</h2>
                            </div>

                            <?php
                            if ($projectType == 'House/Building') {

                                $query = "SELECT * FROM `$projectType` WHERE `projectID` = $projectID ";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_array($result);

                                $dataValues = [$row['foundation'], $row['structure'], $row['exterior'], $row['interior'], $row['utilities']];
                                $totalAverage = array_sum($dataValues) / count($dataValues);
                                $dataValues[] = $totalAverage;

                                $dataHB = json_encode($dataValues);
                            ?>

                                <div class="development-details mt-3">
                                    <h4 class="text-center mb-5">Project Images</h4>
                                    <div class="houseImages d-flex justify-content-evenly mb-5">

                                        <div class="image d-flex flex-column align-items-center">
                                            <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                            <p class="mt-1">Image 1</p>
                                        </div>

                                        <div class="image d-flex flex-column align-items-center">
                                            <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                            <p class="mt-1">Image 2</p>
                                        </div>

                                        <div class="image d-flex flex-column align-items-center">
                                            <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                            <p class="mt-1">Image 3</p>
                                        </div>


                                        <div class="image d-flex flex-column align-items-center">
                                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                            <p class="mt-1">Image 4</p>
                                        </div>

                                        <div class="image d-flex flex-column align-items-center">
                                            <img src="<?php echo $row["pic5"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                            <p class="mt-1">Image 5</p>
                                        </div>


                                    </div>

                                    <div class="card">
                                        <div class="card-header p-3 fs-5 text-center bg-secondary-subtle">House/Building Progress</div>
                                        <div class="card-body"><canvas id="hbChart" width="100%" height="20"></canvas></div>
                                        <div class="card-footer p-3 fs-5 text-center bg-secondary-subtle"><?php echo "Updated at " . $row['updateDate']; ?></div>
                                    </div>
                                </div>

                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <?php if ($status == 'Finished') { ?>
                                <a href="finishProject.php" class="add-btn me-3">Back</a>
                                <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                                    Materials Delivery
                                </a>
                            <?php } ?>
                            <?php if ($status == 'On-Going') { ?>
                                <a href="projectList.php" class="add-btn me-3">Back</a>
                                <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                                    Materials Delivery
                                </a>
                                <button type="button" class="add-btn mx-3" data-bs-toggle="modal" data-bs-target="#editDetails<?php echo $projectID; ?>">Edit Details</button>
                                <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#house<?php echo $projectID; ?>">Update Progress</button>
                            <?php } ?>
                        </div>

                    <?php  } else if ($projectType == 'Road/Highway') {

                                $query = "SELECT * FROM `$projectType` WHERE `projectID` = $projectID ";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_array($result);

                                $dataValues = [$row['earthwork'], $row['roadsurface'], $row['drainage'], $row['utilities']];
                                $totalAverage = array_sum($dataValues) / count($dataValues);
                                $dataValues[] = $totalAverage;

                                $dataHB = json_encode($dataValues);
                    ?>

                        <div class="development-details mt-3">
                            <h4 class="text-center mb-5">Project Images</h4>
                            <div class="houseImages d-flex justify-content-evenly mb-5">

                                <div class="image d-flex flex-column align-items-center">
                                    <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                    <p class="mt-1">Image 1</p>
                                </div>

                                <div class="image d-flex flex-column align-items-center">
                                    <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                    <p class="mt-1">Image 2</p>
                                </div>

                                <div class="image d-flex flex-column align-items-center">
                                    <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                    <p class="mt-1">Image 3</p>
                                </div>


                                <div class="image d-flex flex-column align-items-center">
                                    <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                    <p class="mt-1">Image 4</p>
                                </div>

                                <div class="image d-flex flex-column align-items-center">
                                    <img src="<?php echo $row["pic5"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                    <p class="mt-1">Image 5</p>
                                </div>


                            </div>

                            <div class="card">
                                <div class="card-header p-3 fs-5 text-center bg-secondary-subtle">Road/Highway Progress</div>
                                <div class="card-body"><canvas id="rhChart" width="100%" height="20"></canvas></div>
                                <div class="card-footer p-3 fs-5 text-center bg-secondary-subtle"><?php echo "Updated at " . $row['updateDate']; ?></div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex  justify-content-center mt-4">
                        <?php if ($status == 'Finished') { ?>
                            <a href="finishProject.php" class="add-btn me-3">Back</a>
                            <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                                Materials Delivery
                            </a>
                        <?php } ?>
                        <?php if ($status == 'On-Going') { ?>
                            <a href="projectList.php" class="add-btn me-3">Back</a>
                            <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                                Materials Delivery
                            </a>
                            <button type="button" class="add-btn mx-3" data-bs-toggle="modal" data-bs-target="#editDetails<?php echo $projectID; ?>"> Edit Details</button>
                            <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#road<?php echo $projectID; ?>"> Update Progress</button>
                        <?php } ?>
                    </div>
                <?php
                            } else if ($projectType == 'Covered Court') {

                                $query = "SELECT * FROM `$projectType` WHERE `projectID` = $projectID ";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_array($result);

                                $dataValues = [$row['foundation'], $row['roofing'], $row['walls'], $row['flooring'], $row['utilities']];
                                $totalAverage = array_sum($dataValues) / count($dataValues);
                                $dataValues[] = $totalAverage;

                                $dataHB = json_encode($dataValues);
                ?>

                    <div class="development-details mt-3">
                        <h4 class="text-center mb-5">Project Images</h4>
                        <div class="houseImages d-flex justify-content-evenly mb-5">

                            <div class="image d-flex flex-column align-items-center">
                                <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                <p class="mt-1">Image 1</p>
                            </div>

                            <div class="image d-flex flex-column align-items-center">
                                <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                <p class="mt-1">Image 2</p>
                            </div>

                            <div class="image d-flex flex-column align-items-center">
                                <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                <p class="mt-1">Image 3</p>
                            </div>


                            <div class="image d-flex flex-column align-items-center">
                                <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                <p class="mt-1">Image 4</p>
                            </div>

                            <div class="image d-flex flex-column align-items-center">
                                <img src="<?php echo $row["pic5"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                                <p class="mt-1">Image 5</p>
                            </div>


                        </div>

                        <div class="card">
                            <div class="card-header p-3 fs-5 text-center bg-secondary-subtle">Covered Court Progress</div>
                            <div class="card-body"><canvas id="courtChart" width="100%" height="20"></canvas></div>
                            <div class="card-footer p-3 fs-5 text-center bg-secondary-subtle"><?php echo "Updated at " . $row['updateDate']; ?></div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-center mt-4">
                    <?php if ($status == 'Finished') { ?>
                        <a href="finishProject.php" class="add-btn me-3">Back</a>
                        <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                            Materials Delivery
                        </a>
                    <?php } ?>
                    <?php if ($status == 'On-Going') { ?>
                        <a href="projectList.php" class="add-btn me-3">Back</a>
                        <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                            Materials Delivery
                        </a>
                        <button type="button" class="add-btn mx-3" data-bs-toggle="modal" data-bs-target="#editDetails<?php echo $projectID; ?>">Edit Details</button>
                        <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#court<?php echo $projectID; ?>">Update Progress</button>
                    <?php } ?>
                </div>


            <?php
                            } else if ($projectType == 'Hauling Transport') {

                                $query = "SELECT * FROM `$projectType` WHERE `projectID` = $projectID ";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_array($result);

                                $dataValues = [$row['removal'], $row['transport']];
                                $totalAverage = array_sum($dataValues) / count($dataValues);
                                $dataValues[] = $totalAverage;

                                $dataHB = json_encode($dataValues);
            ?>

                <div class="development-details mt-3">
                    <h4 class="text-center mb-5">Project Images</h4>
                    <div class="houseImages d-flex justify-content-evenly mb-5">

                        <div class="image d-flex flex-column align-items-center">
                            <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                            <p class="mt-1">Image 1</p>
                        </div>

                        <div class="image d-flex flex-column align-items-center">
                            <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                            <p class="mt-1">Image 2</p>
                        </div>

                        <div class="image d-flex flex-column align-items-center">
                            <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                            <p class="mt-1">Image 3</p>
                        </div>


                        <div class="image d-flex flex-column align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                            <p class="mt-1">Image 4</p>
                        </div>

                        <div class="image d-flex flex-column align-items-center">
                            <img src="<?php echo $row["pic5"]; ?>" alt="Profile Photo" width="150" height="120" class="border border-secondary">
                            <p class="mt-1">Image 5</p>
                        </div>


                    </div>

                    <div class="card">
                        <div class="card-header p-3 fs-5 text-center bg-secondary-subtle">Hauling Transport Progress</div>
                        <div class="card-body"><canvas id="haulingChart" width="100%" height="20"></canvas></div>
                        <div class="card-footer p-3 fs-5 text-center bg-secondary-subtle"><?php echo "Updated at " . $row['updateDate']; ?></div>
                    </div>
                </div>

        </div>

        <div class="d-flex justify-content-center mt-4">
            <?php if ($status == 'Finished') { ?>
                <a href="finishProject.php" class="add-btn me-3">Back</a>
                <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                    Materials Delivery
                </a>
            <?php } ?>
            <?php if ($status == 'On-Going') { ?>
                <a href="projectList.php" class="add-btn me-3">Back</a>
                <a href="deliveryLog.php?id=<?php echo $projectID ?>&status=<?php echo $status ?>&projectName=<?php echo $projectName; ?>&projectCode=<?php echo $projectCode; ?>" class="add-btn fs-6">
                    Materials Delivery
                </a>
                <button type="button" class="add-btn mx-3" data-bs-toggle="modal" data-bs-target="#editDetails<?php echo $projectID; ?>">Edit Details</button>
                <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#hauling<?php echo $projectID; ?>">Update Progress</button>
            <?php } ?>
        </div>

    <?php }  ?>

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


    <!-- Edit Details Project Modal-->
    <div class="modal fade" id="editDetails<?php echo $projectID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Edit Project Details</h1>
                </div>

                <?php
                $query = "SELECT * FROM `project` WHERE `ID` =  $projectID ";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="modal-body text-start">
                    <form method="post" action="#">

                        <div class="mb-3">
                            <label for="projectCode" class="col-form-label">Project Code:</label>
                            <input type="text" class="form-control" id="projectCode" name="projectCode" autocomplete="off" disabled value="<?php echo $row['projectCode']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="projectType" class="col-form-label">Project Type:</label>
                            <select name="projectType" class="form-select" aria-label="Default select example" disabled>
                                <option selected><?php echo $row['projectType']; ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="projectName" class="col-form-label">Project Name:</label>
                            <input type="text" class="form-control" id="projectName" name="projectName" autocomplete="off" required="on" value="<?php echo $row['projectName']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="projectCost" class="col-form-label">Project Cost:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="projectCost" name="projectCost" autocomplete="off" required="on" value="<?php echo $row['cost']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="col-form-label">Location:</label>
                            <input type="text" class="form-control" id="location" name="location" autocomplete="off" required="on" value="<?php echo $row['location']; ?>">
                        </div>

                        <div class=" mb-3">
                            <label for="startDate" class="col-form-label who">Start Date:</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $row['startingDate']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="deadline" class="col-form-label who">Deadline:</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $row['deadline']; ?>">
                        </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updateDetails" name="updateDetails" class="btn btn-primary">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>


    <!-- Update House/Building Progress-->
    <div class="modal fade" id="house<?php echo $projectID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Update Project Progress</h1>
                </div>

                <?php
                $query = "SELECT * FROM `$projectType` WHERE `projectID` =  $projectID ";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="modal-body text-start">
                    <form method="post" action="#" enctype="multipart/form-data">

                        <div class="d-flex flex-column  align-items-center">
                            <h4 class="mb-4 mt-2">Project Images</h4>
                            <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 1</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic1">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 2</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic2">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 3</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic3">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 4</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic4">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 5</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foundation" class="col-form-label who">Foundation:</label>
                            <h4 class="mt-3 mb-4 text-center">Project Progress</h4>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="foundation" name="foundation" min="0" max="100" value="<?php echo $row['foundation']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="structure" class="col-form-label who">Structure:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="structure" name="structure" min="0" max="100" value="<?php echo $row['structure']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="exterior" class="col-form-label who">Exterior Work:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="exterior" name="exterior" min="0" max="100" value="<?php echo $row['exterior']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="interior" class="col-form-label who">Interior Work:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="interior" name="interior" min="0" max="100" value="<?php echo $row['interior']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="util" class="col-form-label who">Utilities:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="util" name="util" min="0" max="100" value="<?php echo $row['utilities']; ?>">
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="projectType" value="<?php echo $projectType; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updateHouse" name="updateHouse" class="btn btn-primary">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Update Road/Highway Progress-->
    <div class="modal fade" id="road<?php echo $projectID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Update Project Progress</h1>
                </div>

                <?php
                $query = "SELECT * FROM `$projectType` WHERE `projectID` =  $projectID ";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="modal-body text-start">
                    <form method="post" action="#" enctype="multipart/form-data">

                        <div class="d-flex flex-column  align-items-center">
                            <h4 class="mb-4 mt-2">Project Images</h4>
                            <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 1</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic1">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 2</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic2">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 3</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic3">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 4</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic4">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 5</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <h4 class="mt-3 mb-4 text-center">Project Progress</h4>
                            <label for="earth" class="col-form-label who">Earthwork:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="earth" name="earth" min="0" max="100" value="<?php echo $row['earthwork']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="surface" class="col-form-label who">Road Surface:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="surface" name="surface" min="0" max="100" value="<?php echo $row['roadsurface']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="drain" class="col-form-label who">Drainage Systems:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="drain" name="drain" min="0" max="100" value="<?php echo $row['drainage']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="util" class="col-form-label who">Utilities:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="util" name="util" min="0" max="100" value="<?php echo $row['utilities']; ?>">
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="projectType" value="<?php echo $projectType; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updateRoad" name="updateRoad" class="btn btn-primary">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Update Covered Court Progress-->
    <div class="modal fade" id="court<?php echo $projectID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Update Project Progress</h1>
                </div>

                <?php
                $query = "SELECT * FROM `$projectType` WHERE `projectID` =  $projectID ";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="modal-body text-start">
                    <form method="post" action="#" enctype="multipart/form-data">

                        <div class="d-flex flex-column  align-items-center">
                            <h4 class="mb-4 mt-2">Project Images</h4>
                            <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 1</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic1">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 2</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic2">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 3</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic3">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 4</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic4">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 5</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <h4 class="mt-3 mb-4 text-center">Project Progress</h4>
                            <label for="foundation" class="col-form-label who">Foundation:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="foundation" name="foundation" min="0" max="100" value="<?php echo $row['foundation']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="roofing" class="col-form-label who">Roofing:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="roofing" name="roofing" min="0" max="100" value="<?php echo $row['roofing']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="walls" class="col-form-label who">Walls & Enclosures:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="walls" name="walls" min="0" max="100" value="<?php echo $row['walls']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="flooring" class="col-form-label who">Flooring:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="flooring" name="flooring" min="0" max="100" value="<?php echo $row['flooring']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="util" class="col-form-label who">Utilities:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="util" name="util" min="0" max="100" value="<?php echo $row['utilities']; ?>">
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="projectType" value="<?php echo $projectType; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updateRoad" name="updateCourt" class="btn btn-primary">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Update hauling Progress-->
    <div class="modal fade" id="hauling<?php echo $projectID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Update Project Progress</h1>
                </div>

                <?php
                $query = "SELECT * FROM `$projectType` WHERE `projectID` =  $projectID ";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="modal-body text-start">
                    <form method="post" action="#" enctype="multipart/form-data">

                        <div class="d-flex flex-column  align-items-center">
                            <h4 class="mb-4 mt-2">Project Images</h4>
                            <img src="<?php echo $row["pic1"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 1</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic1">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic2"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 2</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic2">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic3"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 3</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic3">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 4</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic4">
                            </div>
                        </div>

                        <div class="d-flex flex-column  align-items-center">
                            <img src="<?php echo $row["pic4"]; ?>" alt="Profile Photo" width="100" class="border border-secondary mb-2">
                            <p>Image 5</p>
                            <div class="input-group mb-4">
                                <input type="file" class="form-control" id="inputGroupFile02" name="pic5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <h4 class="mt-3 mb-4 text-center">Project Progress</h4>
                            <label for="debris" class="col-form-label who">Debris and Waste Removal:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="debris" name="debris" min="0" max="100" value="<?php echo $row['removal']; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="transport" class="col-form-label who">Transport Waste:</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="number" class="form-control" id="transport" name="transport" min="0" max="100" value="<?php echo $row['transport']; ?>">
                            </div>
                        </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" name="projectID" value="<?php echo $projectID; ?>">
                    <input type="hidden" name="projectType" value="<?php echo $projectType; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="updateRoad" name="updateHauling" class="btn btn-primary">Update</button>
                </div>

                </form>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
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

    <script>
        var ctx = document.getElementById("hbChart");
        var dataValues = <?php echo $dataHB; ?>;
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Foundation", "Structure", "Exterior Work", "Interior Work", "Utilities", "Total Finish"],
                datasets: [{
                    label: '% division percentage',
                    data: dataValues,
                    backgroundColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            }
        });
    </script>

    <script>
        var ctx2 = document.getElementById("rhChart");
        var dataValues = <?php echo $dataHB; ?>;
        var myBarChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["Earth Work", "Road Surface", "Drainage Systems", "Utilities", "Total Finish"],
                datasets: [{
                    label: '% division percentage',
                    data: dataValues,
                    backgroundColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            }
        });
    </script>

    <script>
        var ctx3 = document.getElementById("courtChart");
        var dataValues = <?php echo $dataHB; ?>;
        var myBarChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ["Foundation", "Roofing", "Walls & Enclosures", "Flooring", "Utilities", "Total Finish"],
                datasets: [{
                    label: '% division percentage',
                    data: dataValues,
                    backgroundColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            }
        });
    </script>

    <script>
        var ctx4 = document.getElementById("haulingChart")
        var dataValues = <?php echo $dataHB; ?>;
        var myBarChart = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ["Debris & Waste Removal", "Transport Waste", "Total Finish"],
                datasets: [{
                    label: '% division percentage',
                    data: dataValues,
                    backgroundColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderColor: ["rgba(2,117,216,1)", "rgba(2,117,216,1)", "green"],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            }
        });
    </script>

</body>

</html>