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

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $invalid = false;

    $userName = $_POST["userName"];
    $roles = empty($_POST["role"]) ? array() : $_POST["role"];

    $updateRolesResult = $userService->updateRoles($userName, $roles);
    $error = $updateRolesResult ? false : true;

    if ($error)
        $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
    else {
        $_SESSION["flashMessage"] = "Cập nhật thành công";
        $editedUser = $userService->getUser($_GET["id"]);
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Phân quyền</li>
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
    <div class="col-md-6">
        <form action="" method="post">
            <input type="hidden" name="userName" value="<?php echo $editedUser->userName; ?>">
            <div class="form-group">
                <label for="">Phân quyền</label>
                <select name="role[]" class="form-control" multiple>
                    <?php foreach ($allRoles as $role): ?>
                        <?php if (in_array($role["id"], array_map(function ($value) {
                            return $value["id"];
                        }, $editedUser->roles))): ?>
                            <option value="<?php echo $role["id"] ?>"
                                    selected><?php echo $role["name"] ?></option>
                        <?php else: ?>
                            <option value="<?php echo $role["id"] ?>"><?php echo $role["name"] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
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





