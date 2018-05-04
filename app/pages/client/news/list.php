<?php

include "../../../services/connection.php";
include "../../../services/postService.php";
include "../../../services/categoryService.php";
$categoryService = new CategoryService($conn);
$categories = $categoryService->allActive();

$postService = new PostService($conn);
$latestNews = $postService->all(0, 5);
$mostViews = $postService->mostViews(0, 5);

$result = $postService->getByCategoryWithPaging(empty($_GET["page"]) ? 1 : $_GET["page"], 10, $_GET["id"]);
$posts = $result["posts"];
$count = $result["count"];

$page = empty($_GET["page"]) ? 1 : $_GET["page"];
$queryStringArr = array();
parse_str($_SERVER["QUERY_STRING"], $queryStringArr);
unset($queryStringArr["page"]);
$queryString = http_build_query($queryStringArr);
include "../templates/head.php";
include "../templates/header.php";

?>

<div class="main-body">
    <div class="wrap" style="margin-top: 40px;">
        <div class="privacy-page">
            <div class="col-md-8 content-left">
                <div class="fashion">
                    <?php for ($i = 0; $i < count($posts) - 1; $i += 2): ?>
                        <div class="fashion-top">
                            <div class="fashion-left">
                                <a class="my-thumbnail"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts[$i]["id"]; ?>"><img
                                            src="/game-news/assets/<?php echo $posts[$i]["image"]; ?>"
                                            class="img-responsive" alt="<?php echo $posts[$i]["title"]; ?>"></a>
                                <div class="blog-poast-info">
                                    <p class="fdate"><span
                                                class="glyphicon glyphicon-time"></span><?php echo date('d-m-Y - h:i:s', strtotime($posts[$i]["createdAt"])); ?>
                                        <a
                                                class="span_link1" href="#"><span
                                                    class="glyphicon glyphicon-comment"></span>0 </a><a
                                                class="span_link1" href="#"><span
                                                    class="glyphicon glyphicon-eye-open"></span><?php echo $posts[$i]["views"]; ?>
                                        </a></p>
                                </div>
                                <h3 class="list-title"><a title="<?php echo $posts[$i]["title"]; ?>"
                                                          href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts[$i]["id"]; ?>"><?php echo strlen($posts[$i]["title"]) > 50 ? mb_substr($posts[$i]["title"], 0, 50) . " ..." : $posts[$i]["title"]; ?></a>
                                </h3>
                                <div class="summary">
                                    <div data-full-summary="<?php echo str_replace("\"", "'", $posts[$i]["summary"]); ?>">
                                        <p class="js-display-summary"><?php echo strlen($posts[$i]["summary"]) > 150 ? mb_substr(str_replace("\"", "'", $posts[$i]["summary"]), 0, 100) . " ..." : str_replace("\"", "'", $posts[$i]["summary"]); ?></p>
                                        <?php if (strlen($posts[$i]["summary"]) > 150): ?>
                                            <a role="button" class="js-expand-summary">Xem thêm</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a class="reu"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts[$i]["id"]; ?>"><img
                                            src="images/more.png" alt=""/></a>
                            </div>
                            <div class="fashion-right">
                                <a class="my-thumbnail"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts[$i + 1]["id"]; ?>"><img
                                            src="/game-news/assets/<?php echo $posts[$i + 1]["image"]; ?>"
                                            class="img-responsive" alt="<?php echo $posts[$i + 1]["title"]; ?>"></a>
                                <div class="blog-poast-info">
                                    <p class="fdate"><span
                                                class="glyphicon glyphicon-time"></span><?php echo date('d-m-Y - h:i:s', strtotime($posts[$i + 1]["createdAt"])); ?>
                                        <a
                                                class="span_link1" href="#"><span
                                                    class="glyphicon glyphicon-comment"></span>0 </a><a
                                                class="span_link1" href="#"><span
                                                    class="glyphicon glyphicon-eye-open"></span><?php echo $posts[$i + 1]["views"]; ?>
                                        </a></p>
                                </div>
                                <h3 class="list-title"><a title="<?php echo $posts[$i]["title"]; ?>"
                                            href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts[$i + 1]["id"]; ?>"><?php echo strlen($posts[$i + 1]["title"]) > 50 ? mb_substr($posts[$i + 1]["title"], 0, 50) . " ..." : $posts[$i + 1]["title"]; ?></a>
                                </h3>
                                <div class="summary">
                                    <div data-full-summary="<?php echo str_replace("\"", "'", $posts[$i + 1]["summary"]); ?>">
                                        <p class="js-display-summary"><?php echo strlen($posts[$i + 1]["summary"]) > 150 ? mb_substr(str_replace("\"", "'", $posts[$i + 1]["summary"]), 0, 100) . " ..." : str_replace("\"", "'", $posts[$i + 1]["summary"]); ?></p>
                                        <?php if (strlen($posts[$i + 1]["summary"]) > 150): ?>
                                            <a role="button" class="js-expand-summary">Xem thêm</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a class="reu"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts[$i + 1]["id"]; ?>"><img
                                            src="images/more.png" alt=""/></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php endfor; ?>
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
            <div class="col-md-4 side-bar">
                <div class="first_half">
                    <div class="categories">
                        <header>
                            <h3 class="side-title-head">Danh mục</h3>
                        </header>
                        <ul>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="/game-news/app/pages/client/news/list.php?id=<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="list_vertical">
                        <section class="accordation_menu">
                            <div>
                                <input id="label-1" name="lida" type="radio" checked/>
                                <label for="label-1" id="item1"><i class="ferme"> </i>Tin tức xem nhiều nhất<i
                                            class="icon-plus-sign i-right1"></i><i
                                            class="icon-minus-sign i-right2"></i></label>
                                <div class="content" id="a1">
                                    <div class="scrollbar" id="style-2">
                                        <div class="force-overflow">
                                            <div class="popular-post-grids">
                                                <?php foreach ($mostViews as $post): ?>
                                                    <div class="popular-post-grid">
                                                        <div class="post-img">
                                                            <a href="/game-news/app/pages/client/single.php?id=<?php echo $post["id"]; ?>"><img
                                                                        src="/game-news/assets/<?php echo $post["image"]; ?>"
                                                                        alt="<?php echo $post["title"]; ?>"/></a>
                                                        </div>
                                                        <div class="post-text">
                                                            <a class="pp-title"
                                                               href="/game-news/app/pages/client/single.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a>
                                                            <p><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?>
                                                                <a class="span_link" href="#"><span
                                                                            class="glyphicon glyphicon-comment"></span>0</a><a
                                                                        class="span_link" href="#"><span
                                                                            class="glyphicon glyphicon-eye-open"></span><?php echo $post["views"]; ?>
                                                                </a>
                                                            </p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input id="label-2" name="lida" type="radio"/>
                                <label for="label-2" id="item2"><i class="icon-leaf" id="i2"></i>Tin tức mới nhất<i
                                            class="icon-plus-sign i-right1"></i><i
                                            class="icon-minus-sign i-right2"></i></label>
                                <div class="content" id="a2">
                                    <div class="scrollbar" id="style-2">
                                        <div class="force-overflow">
                                            <div class="popular-post-grids">
                                                <?php foreach ($latestNews as $post): ?>
                                                    <div class="popular-post-grid">
                                                        <div class="post-img">
                                                            <a href="/game-news/app/pages/client/single.php?id=<?php echo $post["id"]; ?>"><img
                                                                        src="/game-news/assets/<?php echo $post["image"]; ?>"
                                                                        alt="<?php echo $post["title"]; ?>"/></a>
                                                        </div>
                                                        <div class="post-text">
                                                            <a class="pp-title"
                                                               href="/game-news/app/pages/client/single.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a>
                                                            <p><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?>
                                                                <a class="span_link" href="#"><span
                                                                            class="glyphicon glyphicon-comment"></span>0</a><a
                                                                        class="span_link" href="#"><span
                                                                            class="glyphicon glyphicon-eye-open"></span><?php echo $post["views"]; ?>
                                                                </a>
                                                            </p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php
include "../templates/footer.php";
?>
<script>

    $(document).on('click', '.js-expand-summary', function () {
        let fullsSummary = $(this).closest('div').attr('data-full-summary');
        $(this).closest('div').find('.js-display-summary').text(fullsSummary);
        $(this).remove();
    });

</script>

<?php
include "../templates/end.php";
?>
