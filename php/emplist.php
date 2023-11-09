<?php

$total = " ";
include 'db_connection.php';
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
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-contract"></i></div>
                            Contract Project
                        </a>
                        <a class="nav-link collapsed active" href="#" data-bs-toggle="collapse" data-bs-target="#team" aria-expanded="false" aria-controls="collapseLayouts">
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
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h1 class="mt-2 mb-4">Employee List</h1>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4>Inquiries</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/request.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="total">Total:</h5>
                                    <a class="small text-white stretched-link" href="inquiries.php">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4>Scheduled Appointment</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/schedule.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="total">Total:</h5>
                                    <a class="small text-white stretched-link" href="appointment.php">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4> Contracts</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/contract.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="total">Total:</h5>
                                    <a class="small text-white stretched-link icons" href="#">
                                        <div class="small"><i class="fas fa-angle-right fa-xl stretched-link"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-logo2 text-white mb-4">
                                <div class="card-header">
                                    <h4> Transactions</h4>
                                </div>
                                <div class="card-body">
                                    <img src="../assets/images/arrange.png" alt="" height="150px" width="170px">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <h5 class="total">Total:</h5>
                                    <a class="small text-white stretched-link icons" href="#">
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

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.3.0/dist/umd/simple-datatables.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/side.js"></script>
    <script src="../assets/js/table.js"></script>
</body>

</html>