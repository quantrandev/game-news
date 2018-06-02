<?php
session_start();

include '../../services/connection.php';

include '../../services/userService.php';
$userService = new UserService($conn);

$confirmPasswordFailErrorMessage = "";
$duplicateUserNameErrorMessage = "";
$emptyErrorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $invalid = false;

    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (empty($userName) || empty($password) || empty($confirmPassword)) {
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
        $invalid = true;
    }

    if ($password != $confirmPassword) {
        $confirmPasswordFailErrorMessage = "Mật khẩu nhập lại không khớp";
        $invalid = true;
    }
    if ($userService->isDuplicateUserName($userName)) {
        $duplicateUserNameErrorMessage = "Tên tài khoản đã tồn tại";
        $invalid = true;
    }

    if (!$invalid) {
        $error = !$userService->add(array(
            "userName" => $userName,
            "password" => $password
        ));

        $attachRolesResult = $userService->attachRoles($userName, array(7));

        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else
            $_SESSION["flashMessage"] = "Đăng ký thành công";
    }
}


include '../admin/templates/head.php';
?>

<div class="card card-login mx-auto mt-5">
    <div class="card-header">Đăng ký</div>
    <div class="card-body">
        <div class="form-group">
            <?php
            if (isset($_SESSION["flashMessage"])) {
                echo '<div class="alert alert-success">' . $_SESSION["flashMessage"] . '<a style="margin-left: 10px;" href="/game-news/app/pages/authentication/login.php">Đăng nhập</a></div>';
                unset($_SESSION["flashMessage"]);
            }
            if (isset($_SESSION["errorMessage"])) {
                echo '<div class="alert alert-danger">' . $_SESSION["errorMessage"] . '</div>';
                unset($_SESSION["errorMessage"]);
            }
            ?>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="" class="control-label">Tên người dùng</label>
                <input type="text" class="form-control" name="userName" autofocus>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Mật khẩu</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" name="confirmPassword">
                <span class="text-danger"><?php echo $confirmPasswordFailErrorMessage ?></span>
            </div>
            <div class="form-group">
                <span class="text-danger"><?php echo $emptyErrorMessage ?></span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>





