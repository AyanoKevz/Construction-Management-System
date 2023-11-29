<?php
session_start();
include 'db_connection.php';
include 'addEmp.php';
include 'login.php';

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
    <link href="../assets/css/emplist.css" rel="stylesheet">
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
                                <a class="nav-link active" href="emplist.php">Employee Lists</a>
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
            if ($add_error) {
                echo '<label class="text-danger error" id="alert">' . $add_error . '</label>';
            }
            if ($success) {
                echo '<label class="text-success success" id="alert">' . $success . '</label>';
            }
            ?>
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h1 class="mt-3 mb-2">Employee List</h1>
                    <div class="d-flex  justify-content-end me-1">
                        <button type="button" class="add-btn p-2" data-bs-toggle="modal" data-bs-target="#add-emp">
                            <i class="fas fa-plus fa-sm" style="color: #ffffff;"></i> Add Employee
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4>Engineers</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/engineer.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="my-0 mx-auto">Total: <?php echo $totalEngineers; ?></h5>
                                    <a class="small text-white stretched-link" href="allList.php?position=Engineer">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4>Foremen</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/foreman.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="my-0 mx-auto">Total: <?php echo  $totalForeman; ?></h5>
                                    <a class="small text-white stretched-link" href="allList.php?position=Foreman">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4>Workers</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/workers.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="my-0 mx-auto">Total: <?php echo  $totalWorkers; ?></h5>
                                    <a class="small text-white stretched-link icons" href="allList.php?position=Worker">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4>Human Resources</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/hr.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="my-0 mx-auto">Total: <?php echo  $totalHR; ?></h5>
                                    <a class="small text-white stretched-link icons" href="allList.php?position=Human Resource">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
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

    <div class="modal fade" id="add-emp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticSchedule">Add Employee</h1>
                </div>
                <div class="modal-body text-start">
                    <form method="post" action="#">
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">First Name:</label>
                            <input type="text" class="form-control" id="fname" name="fname" autocomplete="off" required="on">
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="col-form-label">Last Name:</label>
                            <input type="text" class="form-control" id="lname" name="lname" autocomplete="off" required="on">
                        </div>
                        <div class="mb-3">
                            <label for="number" class="col-form-label">Contact Number:</label>
                            <input type="text" maxlength="11" class="form-control" type="text" name="number" id="number" autocomplete="off" required="on">
                            <span class="text-danger fs-6"><?php echo $contact_error ?></span>
                        </div>
                        <div class="mb-3">
                            <select name="gender" class="form-select" aria-label="Default select example">
                                <option selected disabled>Select the gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="position" class="form-select" aria-label="Default select example">
                                <option selected disabled>Select position</option>
                                <option value="Engineer">Engineer</option>
                                <option value="Foreman">Foreman</option>
                                <option value="Worker">Worker</option>
                                <option value="Human Resource">Human Resource</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="add" name="add" class="btn btn-primary">Add</button>
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