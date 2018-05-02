<?php

session_start();
include '../services/connection.php';
include '../services/newsService.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$newService = new NewsService($conn);

switch ($requestMethod) {
    case 'POST':
        $function = $_POST["function"];
        if ($function == 'delete') {
            $id = $_POST["id"];
            $error = !$newService->delete($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        if ($function == 'approve') {
            $id = $_POST["id"];
            $error = !$newService->approve($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        if ($function == 'dis-approve') {
            $id = $_POST["id"];
            $error = !$newService->disableApprove($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        break;
}

?>