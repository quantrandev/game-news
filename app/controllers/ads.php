<?php

session_start();
include '../services/connection.php';
include '../services/adService.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$adService = new AdService($conn);

switch ($requestMethod) {
    case 'POST':
        $function = $_POST["function"];
        if ($function == 'delete') {
            $id = $_POST["id"];
            $error = !$adService->delete($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        break;
}

?>