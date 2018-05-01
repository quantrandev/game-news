<?php
session_start();

include '../../services/connection.php';

include '../../services/userService.php';
$userService = new UserService($conn);
if (!$userService->isAuthenticate())
    header("Location: ../authentication/login.php");


include 'templates/head.php';
include 'templates/navigation.php';

?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Chào mừng đến với ...</li>
</ol>

<?php
include 'templates/footer.php';
?>


<?php
include 'templates/end.php';
?>
