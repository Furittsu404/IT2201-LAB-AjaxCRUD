<?php
session_start();
include '../../db/ADMIN.action.php';
include '../../db/connection.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../login");
}
$connection = new Connection();
$database = new adminAction($connection->connect());

$database->create($_POST);