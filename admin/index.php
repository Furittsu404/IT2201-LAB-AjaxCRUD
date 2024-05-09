<?php
session_start();
include '../db/action.php';
include '../db/connection.php';
$_SESSION['site'] = 'adminIndex';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login");
}


$connection = new Connection();
$database = new Database($connection->connect());
?>

<!DOCTYPE html>
<html>

<head>
    <?php include '../includes/head.Include.php' ?>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <a class="toggle-btn">
                    <i class="lni lni-grid-alt"></i>
                </a>
                <div class="sidebar-logo">
                    <a>Dashboard</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="users" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="../db/logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">
            <div class="welcome">
                <p>WELCOME TO THE ADMIN DASHBOARD</p>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/admin.js"></script>
</body>

</html>