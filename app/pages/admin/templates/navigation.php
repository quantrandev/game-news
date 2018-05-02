<?php

$userRoles = $userService->getRoles(unserialize($_SESSION["user"])["userName"]);

?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Tên website</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="index.html">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Trang quản trị</span>
                </a>
            </li>
            <?php if (in_array('Quản lý bài viết', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#news"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-file-pdf-o"></i>
                        <span class="nav-link-text">Quản lý bài viết</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="news">
                        <li>
                            <a href="/game-news/app/pages/admin/post/add.php">Thêm bài viết</a>
                        </li>
                        <li>
                            <a href="/game-news/app/pages/admin/post/list.php">Danh sách bài viết</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array('Quản lý chuyên mục', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#categories"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-list-ol"></i>
                        <span class="nav-link-text">Quản lý chuyên mục</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="categories">
                        <li>
                            <a href="/game-news/app/pages/admin/category/add.php">Thêm chuyên mục</a>
                        </li>
                        <li>
                            <a href="/game-news/app/pages/admin/category/list.php">Danh sách chuyên mục</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array('Quản lý người dùng', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#users"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-user-circle-o"></i>
                        <span class="nav-link-text">Quản lý người dùng</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="users">
                        <li>
                            <a href="/game-news/app/pages/admin/user/add.php">Thêm người dùng</a>
                        </li>
                        <li>
                            <a href="/game-news/app/pages/admin/user/list.php">Danh sách người dùng</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array('Quản lý quảng cáo', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#ads"
                       data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-image"></i>
                        <span class="nav-link-text">Quản lý quảng cáo</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="ads">
                        <li>
                            <a href="navbar.html">Thêm quảng cáo</a>
                        </li>
                        <li>
                            <a href="cards.html">Danh sách quảng cáo</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (in_array('Duyệt bình luận', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                    <a class="nav-link" href="charts.html">
                        <i class="fa fa-fw fa-comment-o"></i>
                        <span class="nav-link-text">Duyệt bình luận</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array('Duyệt bài', array_map(function ($value) {
                return $value["name"];
            }, $userRoles))): ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                    <a class="nav-link" href="/game-news/app/pages/admin/post/approve.php">
                        <i class="fa fa-fw fa-file-archive-o"></i>
                        <span class="nav-link-text">Duyệt bài viết</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="post" action="/game-news/app/controllers/user.php"
                      onclick="document.querySelector('#logoutForm').submit()" id="logoutForm">
                    <input type="hidden" name="function" value="logout">
                    <a class="nav-link">
                        <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </form>
            </li>
        </ul>
    </div>
</nav>
<div class="content-wrapper">
    <div class="container-fluid">