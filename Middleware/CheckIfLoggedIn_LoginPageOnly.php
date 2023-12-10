<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/Connections/DB_connection.php";

if(isset($_SESSION['id']) && isset($_SESSION['role'])){
    $role = $_SESSION['role'];
    header("Location: ../$role");
    exit();
}