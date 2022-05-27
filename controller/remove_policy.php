<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('../model/api.php');
$api = new api();
switch($requestMethod) {
    case 'GET':
        if($_GET['policy_id']&&$_GET['client_id']) {
            $api->remove_policy($_GET['policy_id'],$_GET['client_id']);
            header("Location: get_policies.php?client_id={$_SESSION["client_id"]}&&filter=default");
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}