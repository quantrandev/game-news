<?php

session_start();
include '../services/connection.php';
include '../services/userService.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$userService = new UserService($conn);

switch ($requestMethod) {
    case 'POST':
        $function = $_POST["function"];
        if ($function == 'logout') {
            $userService->logout();
            header("Location: ../pages/authentication/login.php");
        }
        if ($function == 'delete') {
            $userName = $_POST["userName"];
            $error = !$userService->delete($userName);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        break;
}

?>