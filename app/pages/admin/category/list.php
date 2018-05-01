<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
$userService = new UserService($conn);
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý chuyên mục'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Danh sách danh mục</li>
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
    <div class="col-md-12">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Tên danh mục</th>
                <th>Kích hoạt</th>
                <th>Vị trí</th>
                <th>Công cụ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category["name"]; ?></td>
                    <td><?php echo $category["isActive"] ? '<span class="badge badge-success">Kích hoạt</span>' : '<span class="badge badge-danger">Khóa</span>'; ?></td>
                    <td><?php echo $category["position"]; ?></td>
                    <td style="width: 170px">
                        <a class="btn btn-primary"
                           href="/game-news/app/pages/admin/category/edit.php?id=<?php echo $category["id"]; ?>">
                            <i class="fa fa-pencil"></i>
                            Sửa
                        </a>
                        <button class="btn btn-danger js-delete" data-id="<?php echo $category["id"]; ?>">
                            <i class="fa fa-trash"></i>
                            Xóa
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include '../templates/footer.php';
?>

<script>
    $(document).on('click', '.js-delete', function () {
        let id = $(this).attr('data-id');
        if (confirm('Xóa chuyên mục được chọn')) {
            $.ajax({
                url: '/game-news/app/controllers/category.php',
                type: 'post',
                data: {id: id, function: 'delete'},
                success: function (res) {
                    res = JSON.parse(res);
                    if (res.error)
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                    else {
                        alert('Xóa thành công chuyên mục');
                        window.location.reload();
                    }
                },
                error: function (err) {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            })
        }
    });
</script>

<?php
include '../templates/end.php';
?>





