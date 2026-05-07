<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include_once("main/basic_functions.php");
    include_once("main/validation.php");

    $bf = new Basic_Functions();
    $con = $bf->con;
    $valid = new validation();
?>