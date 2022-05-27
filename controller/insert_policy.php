<?php
session_start();
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('api.php');
$api = new api();
switch($requestMethod) {
    case 'POST':
        if($_POST['customer_id']) {

            $api->insert_policy($_SESSION['client_id'],$_POST['customer_id'],$_POST['policy_type_id'],$_POST['insurer_id'],$_POST['premium']);
            header("Location: ../view/policies.php");
        }

        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}