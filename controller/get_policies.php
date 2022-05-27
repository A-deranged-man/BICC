<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('../model/api.php');
$api = new api();
switch($requestMethod) {
    case 'GET':
        if($_GET['client_id']&&$_GET['filter']) {
            $_SESSION["policy_json"] = $api->get_policies($_GET['client_id'],$_GET['filter']);
            header("Location: ../view/policies.php");
        }
        break;
    case 'POST':
        if($_POST['client_id']&&$_POST['filter']) {
            $_SESSION["policy_json"] = $api->get_policies($_POST['client_id'],$_POST['filter']);
            header("Location: ../view/policies.php");
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}