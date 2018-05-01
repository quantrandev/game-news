<?php
session_start();

include '../../../services/connection.php';
include '../../../viewModels/userViewModel.php';

include '../../../services/userService.php';
$userService = new UserService($conn);

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý người dùng'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$rolesFromClient = isset($_GET["role"]) ? $_GET["role"] : array();
$users = $userService->getUsers($rolesFromClient);

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Quản lý người dùng</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Tên người dùng</th>
                <th>Quyền</th>
                <th>Công cụ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->userName; ?></td>
                    <td>
                        <?php foreach ($user->roles as $role): ?>
                            <span class="badge badge-info"><?php echo $role["name"]; ?></span>
                        <?php endforeach; ?>
                    </td>
                    <td style="width: 300px">
                        <a class="btn btn-info"
                           href="/game-news/app/pages/admin/user/authorize.php?id=<?php echo $user->userName; ?>">
                            <i class="fa fa-bolt"></i>
                            Phân quyền
                        </a>
                        <a class="btn btn-primary"
                           href="/game-news/app/pages/admin/user/edit.php?id=<?php echo $user->userName; ?>">
                            <i class="fa fa-pencil"></i>
                            Sửa
                        </a>
                        <a class="btn btn-danger js-delete" data-id="<?php echo $user->userName; ?>" role="button"
                           href="#">
                            <i class="fa fa-pencil"></i>
                            Xóa
                        </a>
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
        if (confirm('Xóa người dùng được chọn')) {
            $.ajax({
                url: '/game-news/app/controllers/user.php',
                type: 'post',
                data: {userName: id, function: 'delete'},
                success: function (res) {
                    res = JSON.parse(res);
                    if (res.error)
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                    else {
                        alert('Xóa thành công người dùng');
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





