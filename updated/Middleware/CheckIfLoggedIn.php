<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Connections/DB_connection.php";

if(!isset($_SESSION['id'])){
    header("Location: ../login/login.php");
    exit();
}
