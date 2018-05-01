<?php
session_start();

include '../../../services/connection.php';

include '../../../services/userService.php';
include '../../../services/categoryService.php';
include '../../../services/newsService.php';
$userService = new UserService($conn);
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

if (!$userService->isAuthenticate())
    header("Location: ../../authentication/login.php");
if (!$userService->isAuthorize('Quản lý bài viết'))
    header("Location: ../../authentication/login.php");

$allRoles = $userService->getAllRoles();

$newsService = new NewsService($conn);
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $title = $_POST["title"];
    $image = "images/" . $_FILES["image"]["name"];
    $summary = $_POST["summary"];
    $categoryId = $_POST["categoryId"];
    $content = $_POST["content"];
    $author = $_POST["author"];
    $createdAt = date('Y-m-d h:i:s', time());

    //upload image
    $target_dir = "../../../../assets/images/";
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $_FILES['image']['name']);

    //insert
    if (empty($title) || empty($summary) || empty($categoryId) || empty($content) || empty($author))
        $emptyErrorMessage = "Vui lòng nhập đầy đủ thông tin";
    else {
        $error = !$newsService->insert(array(
            "title" => $title,
            "image" => $image,
            "summary" => $summary,
            "categoryId" => $categoryId,
            "content" => $content,
            "author" => $author,
            "createdAt" => $createdAt
        ));
        if ($error)
            $_SESSION["errorMessage"] = "Có lỗi xảy ra, vui lòng thử lại";
        else
            $_SESSION["flashMessage"] = "Thêm thành công bài viết mới";
    }
}

include '../templates/head.php';
include '../templates/navigation.php';

?>

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Thêm bài viết</li>
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
            <div class="form-group">
                <label for="">Tiêu đề</label>
                <input type="text" class="form-control" name="title" required autofocus>
            </div>
            <div class="form-group">
                <label for="">Hình ảnh</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Tác giả</label>
                <input type="text" class="form-control" name="author" required autofocus>
            </div>
            <div class="form-group">
                <label for="">Tóm tắt</label>
                <textarea name="summary" rows="5" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="">Chuyên mục</label>
                <select name="categoryId" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Nội dung</label>
                <textarea name="content" id="txtContent" class="form-control" required></textarea>
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

<script>
    let editor = CKEDITOR.replace('txtContent');
    CKFinder.setupCKEditor(editor);
</script>

<?php
include '../templates/end.php';
?>





