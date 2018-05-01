<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../viewModels/userViewModel.php';
$userService = new UserService($conn);
$allRoles = $userService->getAllRoles();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý chuyên mục'))
    header("Location: ../../authentication/login.php");

$categoryService = new CategoryService($conn);
$editedCategory = $categoryService->get($_GET["id"]);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $isActive = $_POST["isActive"];
    $position = $_POST["position"];
    if (empty($name))
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
    else {
        $error = !$categoryService->update($id, array(
            "name" => $name,
            "isActive" => $isActive,
            "position" => $position
        ));
        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else
            $_SESSION["flashMessage"] = "Cập nhật thành công";
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>


<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa chuyên mục</li>
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
            <input type="hidden" name="id" value="<?php echo $editedCategory["id"]; ?>">
            <div class="form-group">
                <label for="" class="control-label">Tên chuyên mục</label>
                <input type="text" class="form-control" name="name" autofocus required
                       value="<?php echo $editedCategory["name"]; ?>">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Vị trí</label>
                <input type="number" min="1" name="position" class="form-control" required
                       value="<?php echo $editedCategory["position"]; ?>">
            </div>
            <div class="form-group">
                <label for="" class="control-label">Khóa</label>
                <div>
                    <label>
                        <input type="radio" name="isActive"
                               value="1" <?php echo $editedCategory["isActive"] ? 'checked' : ''; ?>>
                        Kích hoạt
                    </label>
                    <label style="margin-right: 7px">
                        <input type="radio" name="isActive" value="0"
                            <?php echo $editedCategory["isActive"] ? '' : 'checked'; ?>>
                        Khóa
                    </label>
                </div>
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





