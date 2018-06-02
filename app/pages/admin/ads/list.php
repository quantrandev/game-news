<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../services/postService.php';
include '../../../services/adService.php';

$userService = new UserService($conn);

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý quảng cáo'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$adService = new AdService($conn);
$result = $adService->all(empty($_GET["page"]) ? 1 : $_GET["page"], 10);
$ads = $result["ads"];
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
    <li class="breadcrumb-item active">Danh sách quảng cáo</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Vị trí</th>
                <th style="width: 170px">Công cụ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ads as $ad): ?>
                <tr>
                    <td style="width: 150px; padding: 5px">
                        <img style="max-width: 100%" src="/game-news/assets/<?php echo $ad["content"]; ?>" alt="">
                    </td>
                    <td>
                        <span class="badge badge-info"><?php echo $ad["position"]; ?></span>
                    </td>
                    <td>
                        <a href="/game-news/app/pages/admin/ads/edit.php?id=<?php echo $ad["id"];?>"
                           class="btn btn-primary">
                            <i class="fa fa-pencil"></i>
                            Sửa
                        </a>
                        <button class="btn btn-danger js-delete" data-id="<?php echo $ad["id"]; ?>">
                            <i class="fa fa-trash"></i>
                            Xóa
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
    $(document).on('click', '.js-delete', function () {
        let id = $(this).attr('data-id');
        if (confirm('Xóa quảng cáo được chọn')) {
            $.ajax({
                url: '/game-news/app/controllers/ads.php',
                type: 'post',
                data: {id: id, function: 'delete'},
                success: function (res) {
                    res = JSON.parse(res);
                    if (res.error)
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                    else {
                        alert('Xóa thành công quảng cáo');
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





