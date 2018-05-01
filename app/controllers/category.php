<?php

session_start();
include '../services/connection.php';
include '../services/categoryService.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$categoryService = new CategoryService($conn);

switch ($requestMethod) {
    case 'POST':
        $function = $_POST["function"];
        if ($function == 'delete') {
            $id = $_POST["id"];
            $error = !$categoryService->delete($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        break;
}

?>