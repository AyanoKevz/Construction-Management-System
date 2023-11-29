<?php
session_start();
include 'db_connection.php';
include 'schedule.php';
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
    <link href="../assets/css/inquiries.css" rel="stylesheet">
    <script src="../assets/js/all.js"></script>
    <script src="../assets/js/date.js"></script>
    <script src="../assets/js/jquery.min.js"></script>


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
                        <a class="nav-link active collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#appoitment" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                            Appointment
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="appoitment" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="appointment.php">Appointment Scheduled</a>
                                <a class="nav-link active" href="inquiries.php">Inquiries</a>
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
            if ($reject) {
                echo '<label class="text-danger error" id="alert">' . $reject . '</label>';
            }
            ?>
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <h1 class="mt-3 mb-4">Inquiries</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $query = "SELECT * FROM `req_appoint`";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>

                                        <tr>
                                            <td><?php echo $row["Name"]; ?></td>
                                            <td><?php echo $row["Number"]; ?></td>
                                            <td><?php echo $row["Email"]; ?></td>
                                            <td>
                                                <a href="#" class="add-btn fs-6" data-bs-toggle="modal" data-bs-title="Client Message" data-bs-target="#view<?php echo $row['ID']; ?>">
                                                    <i class=" fa-solid fa-eye fa-xs me-1" style="color: #ffffff;"></i>View</a>
                                            </td>
                                            <td><?php echo $row["req_date"]; ?></td>
                                            <td>
                                                <button type="button" class="popover pop1" data-bs-toggle="modal" data-bs-target="#schedule<?php echo $row['ID']; ?>"><i class="fas fa-circle-check fa-2xl" style="color: #35f500;"></i></button>
                                                <button type="button" class="popover pop2" data-bs-toggle="modal" data-bs-target="#reject<?php echo $row['ID']; ?>"><i class="fas fa-circle-xmark fa-2xl" style="color: #f50000;"></i></button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="view<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticView">Message Details</h1>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label who ">From:</label>
                                                                <input type="text" class="form-control" id="from-name" disabled value="<?php echo $row['Email']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text" class="col-form-label">Message:</label>
                                                                <textarea disabled class="form-control" id="message-text"><?php echo $row['Message']; ?></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="schedule<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticSchedule">Schedule an appointment</h1>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form method="post" action="#">
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label who">Recipient:</label>
                                                                <input type="text" class="form-control" id="recipient-name" disabled value="<?php echo $row["Email"]; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="time" class="col-form-label who">Date:</label>
                                                                <input type="date" class="form-control" id="date" name="date">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="time" class="col-form-label who">Time:</label>
                                                                <input type="time" class="form-control" id="time" name="time">
                                                            </div>
                                                            <input type="hidden" name="name" value="<?php echo $row["Name"]; ?>">
                                                            <input type="hidden" name="number" value="<?php echo $row["Number"]; ?>">
                                                            <input type="hidden" name="email" value="<?php echo $row["Email"]; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="set" name="set" class="btn btn-primary" data-bs-toggle="modal">Set</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="reject<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticView">Do you want to reject?</h1>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form method="post" action="#">
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label who ">From:</label>
                                                                <input type="text" class="form-control" id="from-name" disabled value="<?php echo $row['Email']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text" class="col-form-label">Message:</label>
                                                                <textarea disabled class="form-control" id="message-text"><?php echo $row['Message']; ?></textarea>
                                                            </div>
                                                            <input type="hidden" name="name" value="<?php echo $row["Name"]; ?>">
                                                            <input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
                                                            <input type="hidden" name="email" value="<?php echo $row["Email"]; ?>">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="reject" name="reject" class="btn btn-danger" data-bs-toggle="modal">Reject</button>
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