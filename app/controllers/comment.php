<?php

session_start();
include '../services/connection.php';
include '../services/commentService.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$commentService = new CommentService($conn);

switch ($requestMethod) {
    case 'POST':
        $function = $_POST["function"];
        if ($function == 'delete') {
            $id = $_POST["id"];
            $error = !$commentService->delete($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        if ($function == 'approve') {
            $id = $_POST["id"];
            $error = !$commentService->approve($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        if ($function == 'dis-approve') {
            $id = $_POST["id"];
            $error = !$commentService->disableApprove($id);
            if ($error)
                echo json_encode(array("error" => true));
            else
                echo json_encode(array("error" => false));
        }
        break;
}

?>