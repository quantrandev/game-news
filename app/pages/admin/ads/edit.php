<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/adService.php';
$userService = new UserService($conn);

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý quảng cáo'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$adService = new AdService($conn);
$editedAds = $adService->find($_GET["id"]);
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $image = !empty($_FILES["image"]["name"]) ? "images/" . $_FILES["image"]["name"] : null;
    $position = $_POST["position"];

    //upload image
    $target_dir = "../../../../assets/images/";
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $_FILES['image']['name']);

    //insert
    if (empty($position))
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
    else {
        $error = !$adService->update($_GET["id"], array(
            "content" => $image,
            "position" => $position
        ));
        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else
            $_SESSION["flashMessage"] = "Cập nhật thành công quảng cáo";
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa quảng cáo</li>
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Hình ảnh mới</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Vị trí</label>
                <select name="position" class="form-control">
                    <option value="1" <?php echo $editedAds["position"] == 1 ? 'selected' : '' ?>>1</option>
                    <option value="2" <?php echo $editedAds["position"] == 2 ? 'selected' : '' ?>>2</option>
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





