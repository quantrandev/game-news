<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../services/postService.php';
$userService = new UserService($conn);
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Duyệt bình luận'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$postService = new PostService($conn);
$result = $postService->search(empty($_GET["page"]) ? 1 : $_GET["page"], 10, $_GET);
$posts = $result["posts"];
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
    <li class="breadcrumb-item active">Danh sách bài viết</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12" style="padding: 0">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tiêu đề</label>
                            <input type="text" class="form-control" name="title"
                                   value="<?php echo isset($_GET["title"]) ? $_GET["title"] : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Chuyên mục</label>
                            <select name="category" class="form-control">
                                <option value>Chọn</option>
                                <?php foreach ($categories as $category): ?>
                                    <?php if ($category["id"] == $_GET["category"]): ?>
                                        <option value="<?php echo $category["id"]; ?>"
                                                selected><?php echo $category["name"]; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="visibility: hidden">Tiêu đề</label>
                            <div>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th style="width: 120px">Tác giả</th>
                <th style="width: 180px">Ngày đăng</th>
                <th style="width: 110px">Tình trạng</th>
                <th style="width: 170px">Công cụ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td style="width: 100px; padding: 5px">
                        <img style="max-width: 100%" src="/game-news/assets/<?php echo $post["image"]; ?>" alt="">
                    </td>
                    <td><?php echo $post["title"]; ?></td>
                    <td><?php echo $post["author"]; ?></td>
                    <td><?php echo date('d/m/Y h:i:s', strtotime($post["createdAt"])); ?></td>
                    <td>
                        <?php if ($post["isActive"]): ?>
                            <span class="badge badge-success">Đã duyệt</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Chưa duyệt</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/game-news/app/pages/admin/comment/list.php?postId=<?php echo $post["id"] . "&" . $_SERVER["QUERY_STRING"]; ?>"
                           class="btn btn-primary">
                            <i class="fa fa-comments-o"></i>
                            Xem bình luận
                        </a>
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

<?php
include '../templates/end.php';
?>





