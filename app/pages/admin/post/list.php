<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../services/newsService.php';
$userService = new UserService($conn);
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý bài viết'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$newsService = new NewsService($conn);

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Danh sách bài viết</li>
</ol>

<div class="row">
    <div class="col-md-12">

    </div>
</div>

<?php
include '../templates/footer.php';
?>

<?php
include '../templates/end.php';
?>





