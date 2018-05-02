<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
$userService = new UserService($conn);

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý người dùng'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$confirmPasswordFailErrorMessage = "";
$duplicateUserNameErrorMessage = "";
$emptyErrorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $invalid = false;

    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $roles = empty($_POST["role"]) ? array() : $_POST["role"];

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

        $attachRolesResult = $userService->attachRoles($userName, $roles);
        $error = $attachRolesResult ? $error : true;

        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else
            $_SESSION["flashMessage"] = "Thêm thành công người dùng mới";
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Thêm người dùng</li>
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
            <div class="form-group">
                <label for="" class="control-label">Tên người dùng</label>
                <input type="text" class="form-control" name="userName" autofocus>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Quyền người dùng</label>
                <select name="role[]" class="form-control" multiple>
                    <?php foreach ($allRoles as $role): ?>
                        <option value="<?php echo $role["id"]; ?>"><?php echo $role["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
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

<?php
include '../templates/footer.php';
?>


<?php
include '../templates/end.php';
?>





