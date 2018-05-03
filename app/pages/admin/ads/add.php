<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../services/adsService.php';
$userService = new UserService($conn);
$adsService = new AdsService($conn);

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý quảng cáo'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$emptyErrorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $content = empty($_FILES["content"]["name"]) ? '' : "images/" . $_FILES["content"]["name"];
    $isActive = $_POST["isActive"];
    $position = $_POST["position"];
    if (empty($content))
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
    else {
        //upload image
        $target_dir = "../../../../assets/images/";
        move_uploaded_file($_FILES["content"]["tmp_name"], $target_dir . $_FILES['content']['name']);

        $error = !$adsService->insert(array(
            "content" => $content,
            "isActive" => $isActive,
            "position" => $position
        ));
        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else
            $_SESSION["flashMessage"] = "Thêm thành công quảng cáo mới";
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Thêm quảng cáo</li>
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="" class="control-label">Nội dung</label>
                <input type="file" class="form-control" name="content" autofocus required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Vị trí</label>
                <input type="number" min="1" name="position" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Khóa</label>
                <div>
                    <label>
                        <input type="radio" name="isActive" checked value="1">
                        Kích hoạt
                    </label>
                    <label style="margin-right: 7px">
                        <input type="radio" name="isActive" value="0">
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





