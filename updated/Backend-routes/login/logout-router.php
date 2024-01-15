<?php
session_start();

session_unset();
session_destroy();

header("Location: ../../Resources/views/login/login.php");
exit;

