<?php
session_start();
include 'db_connection.php';
include 'login.php';
include 'deliveryMaterials.php';

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
    <link href="../assets/css/delivery.css" rel="stylesheet">
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
                                <a class="nav-link" href="projectList.php">Project Lists</a>
                                <a class="nav-link active" href="delivery.php">Materials Deliveries </a>
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
                    <h1 class="mt-3 mb-4">Materials Deliveries</h1>

                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Project Status</th>
                                        <th>Delivery log</th>
                                        <th>Send Materials</th>
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
                                            <td>
                                                <a href="deliveryLog.php?id=<?php echo $row['ID']; ?>&status=<?php echo $row['status']; ?>&projectName=<?php echo $row['projectName']; ?>&projectCode=<?php echo $row['projectCode']; ?>" class="add-btn fs-6">
                                                    <i class="fa-solid fa-eye fa-xs me-1" style="color: #ffffff;"></i>View
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#send-deliver<?php echo $row['ID']; ?>"><i class="fa-solid fa-truck fa-xl" style="color: #001eb3;"></i></button>
                                            </td>
                                        </tr>


                                        <!-- Deliver Materials Modal-->
                                        <div class="modal fade" id="send-deliver<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticSchedule">Deliver materials for the project.</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body text-start">
                                                        <form method="post" action="#">

                                                            <!-- Input for Concrete and Cement -->
                                                            <div class="mb-4">
                                                                <label>Concrete and Cement (in cubic meters/yards):</label>
                                                                <input type="text" class="form-control concrete" name="concrete" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input concreteCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <!-- Input for Lumber and Wood Products -->
                                                            <div class="mb-4">
                                                                <label>Lumber and Wood Products (size/pieces):</label>
                                                                <input type="text" class="form-control lumber" name="lumber" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input lumberCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <!-- Input for Steel -->
                                                            <div class="mb-4">
                                                                <label>Steel and Metal Products (in tons/lengths):</label>
                                                                <input type="text" class="form-control steel" name="steel" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input steelCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <!-- Input for Aggregates -->
                                                            <div class="mb-4">
                                                                <label>Aggregates (in tons):</label>
                                                                <input type="text" class="form-control aggregates" name="aggregates" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input aggregatesCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <!-- Input for Bricks, Blocks, and Masonry Materials -->
                                                            <div class="mb-4">
                                                                <label>Bricks, Blocks, and Masonry Materials (number of units):</label>
                                                                <input type="text" class="form-control bricks" name="bricks" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input bricksCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <!-- Input for Roofing Materials -->
                                                            <div class="mb-4">
                                                                <label>Roofing Materials (number of units):</label>
                                                                <input type="text" class="form-control roofing" name="roofing" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input roofingCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <!-- Input for Finishing Materials -->
                                                            <div class="mb-4">
                                                                <label>Finishing Materials (number of units):</label>
                                                                <input type="text" class="form-control finishing" name="finishing" required autocomplete="off">
                                                                <div class="mt-2">
                                                                    <input type="checkbox" class="form-check-input finishingCheckbox">
                                                                    <label class="form-check-label">Check if None</label>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="deliDate" class="col-form-label who">Delivery Date:</label>
                                                                <input type="date" class="form-control" id="deliDate" name="deliDate" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="deliTime" class="col-form-label who">Delivery Time:</label>
                                                                <input type="time" class="form-control" id="deliTime" name="deliTime" required>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <input type="hidden" name="projectID" value="<?php echo $row["ID"]; ?>">
                                                                <input type="hidden" name="status" value="<?php echo $row["status"]; ?>">
                                                                <input type="hidden" name="pname" value="<?php echo $row["projectName"]; ?>">
                                                                <input type="hidden" name="pcode" value="<?php echo $row["projectCode"]; ?>">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" id="deliverMaterials" name="deliverMaterials" class="btn btn-primary">Deliver</button>
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

        function handleCheckboxChange() {
            var checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var input = this.parentElement.parentElement.querySelector('.form-control');
                    input.disabled = this.checked;
                    input.value = this.checked ? "None" : "";
                });
            });
        }

        handleCheckboxChange();
    </script>

</body>

</html>