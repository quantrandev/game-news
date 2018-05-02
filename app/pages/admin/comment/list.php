<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../services/commentService.php';
$userService = new UserService($conn);
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Duyệt bình luận'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$commentService = new CommentService($conn);
$result = $commentService->search(empty($_GET["page"]) ? 1 : $_GET["page"], 10, $_GET);
$comments = $result["comments"];
$count = $result["count"];

$page = empty($_GET["page"]) ? 1 : $_GET["page"];
$queryStringArr = array();
parse_str($_SERVER["QUERY_STRING"], $queryStringArr);
unset($queryStringArr["page"]);
$queryString = http_build_query($queryStringArr);

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Duyệt comment</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12" style="padding: 0">
            <div class="form-group">
                <a href="" class="btn btn-primary">
                    <i class="fa fa-search"></i>
                    Tìm kiếm
                </a>
            </div>
        </div>
        <table class="table table-bordered table-hover valign-middle">
            <thead>
            <tr>
                <th style="width: 100px">Hình ảnh</th>
                <th style="width: 300px">Bài viết</th>
                <th>Nội dung bình luận</th>
                <th style="width: 120px">Ngày đăng</th>
                <th style="width: 110px">Tình trạng</th>
                <th style="width: 140px">Công cụ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td style="width: 100px; padding: 5px">
                        <img style="max-width: 100%" src="/game-news/assets/<?php echo $comment["postImage"]; ?>"
                             alt="">
                    </td>
                    <td><?php echo $comment["postTitle"]; ?></td>
                    <td><?php echo $comment["content"]; ?></td>
                    <td><?php echo date('d/m/Y h:i:s', strtotime($comment["createdAt"])); ?></td>
                    <td>
                        <?php if ($comment["isActive"]): ?>
                            <span class="badge badge-success">Đã duyệt</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Chưa duyệt</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-info js-approve" data-id="<?php echo $comment["id"]; ?>">
                            <i class="fa fa-check-circle"></i>
                            Duyệt bình luận
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <ul class="store-pages">
            <li><span class="text-uppercase">Page:</span></li>
            <li class="<?php if ($page == 1) echo 'hide'; ?>">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . ($page - 1); ?>">
                    <i class="glyphicon glyphicon-chevron-left"></i>
                </a>
            </li>
            <?php if (ceil($count / 12) < 20): ?>
                <?php for ($i = 1; $i <= ceil($count / 12); $i++): ?>
                    <?php if ($page == $i): ?>
                        <li class="active"><?php echo $i; ?></li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php else: ?>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if ($page == $i): ?>
                        <li class="active"><?php echo $i; ?></li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
                <li class="active">...</li>
                <?php for ($i = 6; $i <= ceil($count / 12) - 5; $i++): ?>
                    <?php if ($page == $i): ?>
                        <li class="active"><?php echo $i; ?></li>
                        <li class="active">...</li>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php for ($i = ceil($count / 12) - 4; $i <= ceil($count / 12); $i++): ?>
                    <?php if ($page == $i): ?>
                        <li class="active"><?php echo $i; ?></li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>
            <li class="<?php if ($page == ceil($count / 12)) echo 'hide'; ?>">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . ($page + 1); ?>">
                    <i class="glyphicon glyphicon-chevron-right"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

<?php
include '../templates/footer.php';
?>

<script>
    $(document).on('click', '.js-approve', function () {
        let id = $(this).attr('data-id');
        if (confirm('Duyệt bình luận được chọn')) {
            $.ajax({
                url: '/game-news/app/controllers/comment.php',
                type: 'post',
                data: {id: id, function: 'approve'},
                success: function (res) {
                    res = JSON.parse(res);
                    if (res.error)
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                    else {
                        alert('Duyệt thành công bình luận');
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





