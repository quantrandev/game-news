<?php
session_start();

include '../../services/connection.php';

include '../../services/userService.php';
$userService = new UserService($conn);
if (!$userService->isAuthenticate())
    header("Location: ../authentication/login.php");

include '../../services/postService.php';
include '../../services/commentService.php';
$postService = new PostService($conn);
$commentService = new CommentService($conn);
$newPosts = $postService->newPostCount();
$newComments = $commentService->newComments();

include 'templates/head.php';
include 'templates/navigation.php';

?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Trang quản trị</a>
    </li>
    <li class="breadcrumb-item active">Chào mừng đến với ...</li>
</ol>

<div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-newspaper-o"></i>
                </div>
                <div class="mr-5"><?php echo $newPosts; ?> Bài viết mới!</div>
            </div>
            <?php if (in_array('Duyệt bài', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <a class="card-footer text-white clearfix small z-1"
                   href="/game-news/app/pages/admin/post/approve.php?isActive=0">
                    <span class="float-left">Xem chi tiết</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            <?php elseif (in_array('Quản lý bài viết', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <a class="card-footer text-white clearfix small z-1"
                   href="/game-news/app/pages/admin/post/list.php?isActive=0">
                    <span class="float-left">Xem chi tiết</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
                <div class="card-body-icon">
                    <i class="fa fa-fw fa-comments-o"></i>
                </div>
                <div class="mr-5"><?php echo $newComments; ?> Bình luận mới!</div>
            </div>
            <?php if (in_array('Duyệt bình luận', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <a class="card-footer text-white clearfix small z-1"
                   href="/game-news/app/pages/admin/comment/list.php?isActive=0">
                    <span class="float-left">Xem chi tiết</span>
                    <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'templates/footer.php';
?>


<?php
include 'templates/end.php';
?>
