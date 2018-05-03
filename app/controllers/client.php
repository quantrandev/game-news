<?php

include "../services/connection.php";
include "../services/postService.php";
$postService = new postService($conn);

$function = $_POST["function"];

switch ($function) {
    case 'view':
        $postId = $_POST["postId"];
        $postService->view($postId);
            break;
}

?>