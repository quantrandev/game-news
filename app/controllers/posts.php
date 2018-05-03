<?php

session_start();
include '../services/connection.php';
include '../services/postService.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$postService = new PostService($conn);

switch ($requestMethod) {
    case 'POST':
        $function = $_POST["function"];
        if ($function == 'delete') {
            $id = $_POST["id"];
            $error = !$postService->delete($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        if ($function == 'approve') {
            $id = $_POST["id"];
            $error = !$postService->approve($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        if ($function == 'dis-approve') {
            $id = $_POST["id"];
            $error = !$postService->disableApprove($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        break;
}

?>