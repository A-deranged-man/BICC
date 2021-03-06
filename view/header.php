<!DOCTYPE html>
<html lang="en">
    <head>
        <title>BICC</title>

        <!-- Required meta tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Personal Stylesheet & Icon -->
        <link href="favicon.png" rel="icon">
        <link href="styles.css" rel="stylesheet">

        <!-- Google Roboto, Google Montserrat & Font Awesome -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" rel="stylesheet">

        <!-- jQuery, Popper.js, Bootstrap JS -->
        <script crossorigin="anonymous"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script crossorigin="anonymous"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
                src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script crossorigin="anonymous"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


        <style>
            .st-sidebar a {font-family: "Roboto", sans-serif}
            body,h1,h2,h3,h4,h5,h6,.st-wide {font-family: "Montserrat", sans-serif;}
        </style>

    </head>
<body class="st-content" style="max-width:1200px">
<?php
session_start();

?>
<!-- Sidebar/menu -->
<nav class="st-sidebar st-bar-block st-white st-collapse st-top" style="z-index:3;width:250px" id="mySidebar">

    <div class="st-container st-display-container st-padding-16">
        <i onclick="js_close()" class="fa fa-remove st-hide-large st-button st-display-topright"></i>
        <h3 class="st-wide">BI Code Challenge</h3>
    </div>
    <div class="st-padding-64 st-large st-text-grey" style="font-weight:bold">

        <a class="st-bar-item st-white st-left-align" id="myBtn" >
            <?php
            if(isset($_SESSION['client_name'])) {
                echo $_SESSION['client_name'];
            }

            else{
                echo " ";
            }
            ?>
            </a>
        <a href="policies.php" class="st-bar-item st-button st-block st-white st-left-align">Home Page</a>
        <br>

        <a onclick="user_account()" href="javascript:void(0)" class="st-button st-block st-white st-left-align" id="myBtn">
            User Settings
            <i class="fa fa-caret-down"></i>
        </a>
        <div id="user_account" class="st-bar-block st-hide st-padding-large st-medium">
            <?php
            if($_SESSION["logged-in"] === true) {
                echo "<a href=\"../controller/logout.php\" class=\"st-bar-item st-button\">Log-out</a>";
            }

            else{
                echo "<a href=\"account.php\" class=\"st-bar-item st-button\">Log-in or Register</a>";
            }
            ?>
        </div>
    <br>
</nav>

<!-- Top menu on small screens -->
<header class="st-bar st-top st-hide-large st-light-gray st-xlarge">
    <div class="st-bar-item st-padding-24 st-wide"><h3>BI Code Challenge</h3></div>
    <a href="javascript:void(0)" class="st-bar-item st-button st-padding-24 st-right" onclick="js_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="st-overlay st-hide-large" onclick="js_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<div class="st-main" style="margin-left:250px">

    <!-- Push down content on small screens -->
    <div class="st-hide-large" style="margin-top:83px"></div>

    <!-- Top header -->
    <header class="st-container st-xlarge">
        <p class="st-left">
        </p>

        <p class="st-right">
            <br>
        </p>
    </header>
<!-- end of header -->
    <!-- !PAGE CONTENT! -->