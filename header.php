<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="<?php echo $base_url; ?>css/styles.css" rel="stylesheet" />
        <link href="<?php echo $base_url; ?>css/dataTables.bootstrap5.min.css" rel="stylesheet" />

        <link href="<?php echo $base_url; ?>css/bootstrap-select.min.css" rel="stylesheet" />
        <link href="<?php echo $base_url; ?>css/daterangepicker.css" rel="stylesheet" />

        <script src="<?php echo $base_url; ?>js/jquery-3.5.1.js"></script>
        <script src="<?php echo $base_url; ?>js/jquery.dataTables.min.js"></script>
        <script src="<?php echo $base_url; ?>js/dataTables.bootstrap5.min.js"></script>
        <script src="<?php echo $base_url; ?>js/font-awesome-5-all.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo $base_url; ?>js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo $base_url; ?>js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        
        <script src="<?php echo $base_url; ?>js/bootstrap-select.min.js"></script>     

        <script src="<?php echo $base_url; ?>js/moment.min.js"></script>
        <script src="<?php echo $base_url; ?>js/daterangepicker.min.js"></script>
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Fees Management</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!--<div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>!-->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <?php
                        if(is_master_user())
                        {
                        ?>
                        <li><a class="dropdown-item" href="setting.php">Setting</a></li>
                        <?php
                        }
                        ?>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <?php
                            if(is_master_user())
                            {
                            ?>
                            <a class="nav-link" href="user.php">User</a>
                            <a class="nav-link" href="academic_year.php">Academic Year</a>
                            <a class="nav-link" href="academic_standard.php">Academic Standard</a>
                            <a class="nav-link" href="student.php">Student Master</a>
                            <a class="nav-link" href="student_standard.php">Student Standard</a>
                            <a class="nav-link" href="fees_master.php">Fees Master</a>
                            <?php
                            }
                            ?>
                            <a class="nav-link" href="fees_paid.php">                                
                                Receive Fees
                            </a>
                            <a class="nav-link" href="fees_data.php">                                
                                Fees Data
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as: <?php echo $_SESSION['username'];?></div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>