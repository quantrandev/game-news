<?php

include "../services/connection.php";
include "../services/newsService.php";
$newsService = new NewsService($conn);

$function = $_POST["function"];

switch ($function) {
    case 'view':
        $postId = $_POST["postId"];
        $newsService->view($postId);
            break;
}

?>