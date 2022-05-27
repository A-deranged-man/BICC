<?php
session_start();
// Destroy session
session_unset();
session_destroy();
// Redirecting To Home Page
session_start();
header("Location: ../view/account.php");
exit();

