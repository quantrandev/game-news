<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../viewModels/userViewModel.php';
$userService = new UserService($conn);
$allRoles = $userService->getAllRoles();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý người dùng'))
    header("Location: ../../authentication/login.php");

$editedUser = $userService->getUser($_GET["id"]);

$confirmPasswordFailErrorMessage = "";
$emptyErrorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $invalid = false;

    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if (empty($password) || empty($confirmPassword)) {
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
        $invalid = true;
    }

    if ($password != $confirmPassword) {
        $confirmPasswordFailErrorMessage = "Mật khẩu nhập lại không khớp";
        $invalid = true;
    }
    if (!$invalid) {
        $error = !$userService->update($userName, array(
            "userName" => $userName,
            "password" => $password
        ));

        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else {
            $_SESSION["flashMessage"] = "Cập nhật thành công";

        }
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>


<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Đổi mật khẩu</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php
            if (isset($_SESSION["flashMessage"])) {
                echo '<div class="alert alert-success">' . $_SESSION["flashMessage"] . '</div>';
                unset($_SESSION["flashMessage"]);
            }
            if (isset($_SESSION["errorMessage"])) {
                echo '<div class="alert alert-danger">' . $_SESSION["errorMessage"] . '</div>';
                unset($_SESSION["errorMessage"]);
            }
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <form action="" method="post">
            <input type="hidden" name="userName" value="<?php echo $editedUser->userName; ?>">
            <div class="form-group">
                <label for="" class="control-label">Mật khẩu mới</label>
                <input type="password" class="form-control" name="password" autofocus>
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

<?php
include '../templates/footer.php';
?>

<?php
include '../templates/end.php';
?>





