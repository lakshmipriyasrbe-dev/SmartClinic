<?php
    session_start();

    include("include/label.php");
    include("include/functions.php");
    include("include/validation.php");  
    
    $obj = new Core_Functions();
    $valid = new validation();

    $project_title = "";
    $project_title = $obj->getProjectTitle();
?>