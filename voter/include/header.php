<?php 
    session_start();
    require_once("../admin/include/database.php");

    if($_SESSION['Key'] != "VoterKey")
    {
        echo "<script> location.assign('../admin/logout.php'); </script>";
        die;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Panel</title>
    <link rel="stylesheet" href="include/style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    
