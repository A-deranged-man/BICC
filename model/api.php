<?php
    // Connect to database
    include("../controller/DBController.php");
    $db = new DBController();
    $conn =  $db->getConnstring();
    session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    class api
    {
        function make_safe_SS($uname)
        {
            global $conn;
            mysqli_real_escape_string($conn, $uname);
            return stripslashes($uname);
        }

        function register_user($client_email,$client_name,$client_password)
        {
            global $conn;
            $client_email = $this->make_safe_SS($client_email);
            $client_name = $this->make_safe_SS($client_name);
            $client_password = password_hash($client_password, PASSWORD_DEFAULT);
            $stmt = mysqli_stmt_init($conn);
            $sql = "INSERT INTO `clients` (client_name, client_email, client_password) VALUES (?, ?, ?)";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, 'sss', $client_name, $client_email, $client_password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result)
            {
                $message = "User registered.";
                $status = 1;
            }
            else
            {
                $message = "User creation failed.";
                $status = 0;
            }
            $response = array('status' => $status, 'status_message' => $message);
            header('Content-Type: application/json');
            return json_encode($response);
        }

        function login_user($client_email, $client_password)
        {
            global $conn;
            $stmt = mysqli_stmt_init($conn);
            $sql = "SELECT client_id, client_name, client_email, client_password FROM `clients` WHERE client_email=?";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, 's', $client_email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = $result->fetch_assoc();
            if (password_verify($client_password, $row['client_password']))
            {
                $_SESSION["client_id"] = $row['client_id'];
                $_SESSION["client_name"] = $row['client_name'];
                $_SESSION["client_email"] = $row['client_email'];
                $_SESSION["logged-in"] = true;
                $status = 1;
                $response = array('status' => $status ,'client_id'=>$row['client_id'],'client_email' => $row['client_email'], 'client_name' => $row['client_name']);
            }
            else
            {
                $status = 0;
                $message = "Login Fail";
                $response = array('status' => $status, 'status_message' => $message);
            }
            header('Content-Type: application/json');
            return json_encode($response);
        }

        function insert_policy($client_id,$customer_id,$policy_type_id,$insurer_id,$premium)
        {
              global $conn;

                //Add data from function to database
                $stmt2 = mysqli_stmt_init($conn);
                $sql2 = "INSERT INTO `policies` (client_id, customer_id, policy_type_id, insurer_id, premium) VALUES (?, ?, ?, ?, ?)";
                mysqli_stmt_prepare($stmt2, $sql2);
                mysqli_stmt_bind_param($stmt2, 'iiiid', $client_id,$customer_id,$policy_type_id,$insurer_id,$premium);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);
                if ($result2)
                {
                    $message = "Policy created";
                    $status = 1;
                }
                else
                {
                    $message = "Policy creation failed.";
                    $status = 0;
                }
                $response = array('status' => $status, 'status_message' => $message);
                header('Content-Type: application/json');
                return json_encode($response);
            
        }

        function get_policies($client_id, $filter)
        {
            global $conn;

            $sql = "";

            if(!isset($filter)){
                $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ?";
            }
            else{
                if ($filter === "default"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ?";
                }
                if ($filter === "premiumasc"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ? ORDER BY `policies`.`premium` ASC";
                }
                if ($filter === "premiumdesc"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ? ORDER BY `policies`.`premium` DESC";
                }
                if ($filter === "insurnameasc"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ? ORDER BY `insurers`.`insurer_name` ASC";
                }
                if ($filter === "insurnamedesc"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ? ORDER BY `insurers`.`insurer_name` DESC";
                }
                if ($filter === "custnameasc"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ? ORDER BY `customers`.`customer_name` ASC";
                }
                if ($filter === "custnamedesc"){
                    $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.client_id = ? ORDER BY `customers`.`customer_name` DESC";
                }
            }

            $stmt = mysqli_stmt_init($conn);

            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $client_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $policies = array();
            while($r = mysqli_fetch_assoc($result)) {
                $policies[] = $r;
            }

            if($result) {
                $response = $policies;
                }
            else {
                    $message = "Data retrieval failed.";
                    $status = 0;
                    $response = array('status' => $status, 'status_message' => $message);
                }
                //Return response to client
                return json_encode($response);
        }

        function get_single_policy($policy_id){
            global $conn;

            $stmt = mysqli_stmt_init($conn);

            $sql = "SELECT policies.policy_id, customers.customer_name, customers.customer_address, policy_types.policy_type, 
                    insurers.insurer_name, policies.premium
                    FROM policies
                    INNER JOIN customers ON customers.customer_id = policies.customer_id
                    INNER JOIN policy_types ON policy_types.policy_type_id = policies.policy_type_id
                    INNER JOIN insurers ON insurers.insurer_id = policies.insurer_id
                    WHERE policies.policy_id = ?";

            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $policy_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $policy = array();
            while($r = mysqli_fetch_assoc($result)) {
                $policy[] = $r;
            }

            if($result) {
                $response = $policy;
            }
            else {
                $message = "Data retrieval failed.";
                $status = 0;
                $response = array('status' => $status, 'status_message' => $message);
            }
            //Return response to client
            return json_encode($response);
        }


        function remove_policy($policy_id,$client_id)
        {
                global $conn;
                $stmt = mysqli_stmt_init($conn);
                $sql = "DELETE FROM `policies` WHERE `policies`.`policy_id` = ? AND `policies`.`client_id` = ?";
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, 'ii', $policy_id, $client_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($result)
                {
                    $message = "Entry removed";
                    $status = 1;
                }
                else
                {
                    $message = "Entry deletion error";
                    $status = 0;
                }
                $response = array('status' => $status, 'status_message' => $message);
                header('Content-Type: application/json');
                return json_encode($response);
            }

    }