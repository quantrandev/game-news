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
if (!$userService->isAuthorize('Duyệt bài'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$postService = new PostService($conn);
$editedNews = $postService->get($_GET["id"]);
$category = array_values(array_filter($categories, function ($category) use ($editedNews) {
    return $category["id"] == $editedNews["categoryId"];
}))[0]["name"];


$queryStringArr = array();
parse_str($_SERVER["QUERY_STRING"], $queryStringArr);
unset($queryStringArr["id"]);
$queryString = http_build_query($queryStringArr);

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Chỉnh sửa bài viết</li>
</ol>

<div class="row">
    <div class="col-md-10">
        <input type="hidden" name="id" value="<?php echo $editedNews["id"]; ?>">
        <div class="form-group">
            <label for="">Tiêu đề</label>
            <input type="text" class="form-control" name="title" autofocus
                   value="<?php echo $editedNews["title"]; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="">Hình ảnh</label>
            <div style="width: 300px;">
                <img src="/game-news/assets/<?php echo $editedNews["image"]; ?>" alt="" style="max-width: 100%">
            </div>
        </div>
        <div class="form-group">
            <label for="">Tác giả</label>
            <input type="text" class="form-control" name="author" autofocus
                   value="<?php echo $editedNews["author"]; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="">Tóm tắt</label>
            <textarea name="summary" rows="5" class="form-control" readonly>
                    <?php echo $editedNews["summary"]; ?>
                </textarea>
        </div>
        <div class="form-group">
            <label for="">Chuyên mục</label>
            <p><span class="badge badge-primary"><?php echo $category; ?></span></p>
        </div>
        <div class="form-group">
            <label for="">Nội dung</label>
            <div class="card">
                <div class="card-body">
                    <?php echo $editedNews["content"]; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php if (!$editedNews["isActive"]): ?>
                <button class="btn btn-info js-approve" data-id="<?php echo $editedNews["id"]; ?>">
                    <i class="fa fa-check-circle"></i>
                    Duyệt bài
                </button>
            <?php else: ?>
                <button class="btn btn-danger js-disable-approve" data-id="<?php echo $editedNews["id"]; ?>">
                    <i class="fa fa-check-circle"></i>
                    Hủy duyệt
                </button>
            <?php endif; ?>
            <a class="btn btn-secondary"
               href="/game-news/app/pages/admin/post/approve.php?<?php echo $queryString; ?>">Quay lại danh sách</a>
        </div>
    </div>
</div>

<?php
include '../templates/footer.php';
?>

<script>
    $(document).on('click', ' .js-approve', function () {
        let id = $(this).attr('data-id');
        if (confirm('Duyệt bài viết được chọn')) {
            $.ajax({
                url: '/game-news/app/controllers/posts.php',
                type: 'post',
                data: {id: id, function: 'approve'},
                success: function (res) {
                    res = JSON.parse(res);
                    if (res.error)
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                    else {
                        alert('Duyệt thành công bài viết');
                        window.location.reload();
                    }
                },
                error: function (err) {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            })
        }
    });
    $(document).on('click', ' .js-disable-approve', function () {
        let id = $(this).attr('data-id');
        if (confirm('Hủy duyệt bài viết được chọn')) {
            $.ajax({
                url: '/game-news/app/controllers/posts.php',
                type: 'post',
                data: {id: id, function: 'dis-approve'},
                success: function (res) {
                    res = JSON.parse(res);
                    if (res.error)
                        alert('Có lỗi xảy ra, vui lòng thử lại');
                    else {
                        alert('Hủy duyệt thành công bài viết');
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





