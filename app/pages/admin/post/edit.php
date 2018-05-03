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
if (!$userService->isAuthorize('Quản lý bài viết'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$postService = new PostService($conn);
$editedNews = $postService->get($_GET["id"]);
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $image = !empty($_FILES["image"]["name"]) ? "images/" . $_FILES["image"]["name"] : null;
    $summary = $_POST["summary"];
    $categoryId = $_POST["categoryId"];
    $content = $_POST["content"];
    $author = $_POST["author"];

    //upload image
    $target_dir = "../../../../assets/images/";
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $_FILES['image']['name']);

    //insert
    if (empty($title) || empty($summary) || empty($categoryId) || empty($content) || empty($author))
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
    else {
        $error = !$postService->update($id, array(
            "title" => $title,
            "image" => $image,
            "summary" => $summary,
            "categoryId" => $categoryId,
            "content" => $content,
            "author" => $author
        ));
        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else {
            $_SESSION["flashMessage"] = "Cập nhật thành công";
            $editedNews = $postService->get($_GET["id"]);
        }
    }
}
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
    <div class="col-md-10">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $editedNews["id"]; ?>">
            <div class="form-group">
                <label for="">Tiêu đề</label>
                <input type="text" class="form-control" name="title" required autofocus
                       value="<?php echo $editedNews["title"]; ?>">
            </div>
            <div class="form-group">
                <label for="">Hình ảnh</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Tác giả</label>
                <input type="text" class="form-control" name="author" required autofocus
                       value="<?php echo $editedNews["author"]; ?>">
            </div>
            <div class="form-group">
                <label for="">Tóm tắt</label>
                <textarea name="summary" rows="5" class="form-control" required>
                    <?php echo $editedNews["summary"]; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="">Chuyên mục</label>
                <select name="categoryId" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <?php if ($category["id"] == $editedNews["categoryId"]): ?>
                            <option value="<?php echo $category["id"]; ?>"
                                    selected><?php echo $category["name"]; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Nội dung</label>
                <textarea name="content" id="txtContent" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                <a class="btn btn-secondary"
                   href="/game-news/app/pages/admin/post/list.php?<?php echo $queryString; ?>">Quay lại danh sách</a>
            </div>
        </form>
    </div>
</div>

<?php
include '../templates/footer.php';
?>

<script>
    let editor = CKEDITOR.replace('txtContent');
    CKFinder.setupCKEditor(editor);

    CKEDITOR.instances["txtContent"].setData(`<?php echo $editedNews["content"];?>`);
</script>

<?php
include '../templates/end.php';
?>





