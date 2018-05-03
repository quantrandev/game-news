<?php

include "../../services/connection.php";
include "../../services/postService.php";
include "../../services/categoryService.php";
$categoryService = new CategoryService($conn);
$categories = $categoryService->allActive();

$postService = new PostService($conn);
$latestNews = $postService->all(0, 5);
foreach ($latestNews as &$post) {
    $post["comments"] = empty($postService->getComments($post["id"])) ? 0 : $postService->getComments($post["id"]);
}

$mostViews = $postService->mostViews(0, 5);
foreach ($mostViews as &$post) {
    $post["comments"] = empty($postService->getComments($post["id"])) ? 0 : $postService->getComments($post["id"]);
}

$posts1 = $postService->getWithCategory(0, 4, $categories[0]["id"]);
$posts2 = $postService->getWithCategory(0, 4, $categories[1]["id"]);
$posts3 = $postService->getWithCategory(0, 4, $categories[2]["id"]);
include "templates/head.php";
include "templates/header.php";

?>
<!-- content-section-starts-here -->
<div class="main-body">
    <div class="wrap">
        <div class="col-md-8 content-left">
            <div class="articles">
                <header>
                    <h3 class="title-head">Tin tức mới nhất</h3>
                </header>
                <?php foreach ($latestNews as $post): ?>
                    <div class="article">
                        <div class="article-left">
                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><img
                                        src="/game-news/assets/<?php echo $post["image"]; ?>"></a>
                        </div>
                        <div class="article-right">
                            <div class="article-title">
                                <p><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?> <a
                                            class="span_link" href="#"><span
                                                class="glyphicon glyphicon-comment"></span><?php echo $post["comments"]; ?>
                                    </a><a class="span_link"
                                           href="#"><span
                                                class="glyphicon glyphicon-eye-open"></span><?php echo $post["views"]; ?>
                                    </a></p>
                                <h5>
                                    <a class="title"
                                       href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a>
                                </h5>
                            </div>
                            <div class="article-text">
                                <p><?php echo $post["summary"]; ?></p>
                                <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><img
                                            src="/game-news/assets/images/more.png" alt=""/></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="life-style">
                <header>
                    <h3 class="title-head"><?php echo $categories[0]["name"]; ?></h3>
                </header>
                <div class="life-style-grids">
                    <?php for ($i = 0; $i < count($posts1) / 2; $i++): ?>
                        <div class="life-style-left-grid">
                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts1[$i]["id"]; ?>"><img
                                        src="/game-news/assets/<?php echo $posts1[$i]["image"]; ?>"
                                        alt="<?php echo $posts1[$i]["title"]; ?>"/></a>
                            <a title="<?php echo $posts1[$i]["title"]; ?>" class="title title-small"
                               href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts1[$i]["id"]; ?>"><?php echo strlen($posts1[$i]["title"]) > 60 ? mb_substr($posts1[$i]["title"], 0, 60) . "..." : $posts1[$i]["title"]; ?></a>
                            <div class="summary">
                                <p>
                                    <small class="italic"><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?></small>
                                </p>
                                <div data-full-summary="<?php echo $posts1[$i]["summary"]; ?>">
                                    <p class="js-display-summary"><?php echo strlen($posts1[$i]["summary"]) > 150 ? mb_substr($posts1[$i]["summary"], 0, 150) . " ..." : $posts1[$i]["summary"]; ?></p>
                                    <?php if (strlen($posts1[$i]["summary"]) > 150): ?>
                                        <a role="button" class="js-expand-summary">Xem thêm</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <div class="clearfix"></div>
                </div>
                <div class="life-style-grids">
                    <?php for ($i = count($posts1) / 2; $i < count($posts1); $i++): ?>
                        <div class="life-style-left-grid">
                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts1[$i]["id"]; ?>"><img
                                        src="/game-news/assets/<?php echo $posts1[$i]["image"]; ?>"
                                        alt="<?php echo $posts1[$i]["title"]; ?>"/></a>
                            <a title="<?php echo $posts1[$i]["title"]; ?>" class="title title-small"
                               href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts1[$i]["id"]; ?>"><?php echo strlen($posts1[$i]["title"]) > 60 ? mb_substr($posts1[$i]["title"], 0, 60) . "..." : $posts1[$i]["title"]; ?></a>
                            <div class="summary">
                                <p>
                                    <small class="italic"><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?></small>
                                </p>
                                <div data-full-summary="<?php echo $posts1[$i]["summary"]; ?>">
                                    <p class="js-display-summary"><?php echo strlen($posts1[$i]["summary"]) > 150 ? mb_substr($posts1[$i]["summary"], 0, 150) . " ..." : $posts1[$i]["summary"]; ?></p>
                                    <?php if (strlen($posts1[$i]["summary"]) > 150): ?>
                                        <a role="button" class="js-expand-summary">Xem thêm</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="sports-top">
                <div class="s-grid-left">
                    <div class="cricket">
                        <header>
                            <h3 class="title-head"><?php echo $categories[1]["name"]; ?></h3>
                        </header>
                        <div class="c-sports-main">
                            <div class="c-image">
                                <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts2[0]["id"] ?>"><img
                                            src="/game-news/assets/<?php echo $posts2[0]["image"]; ?>"
                                            alt="<?php echo $posts2[0]["title"]; ?>"/></a>
                            </div>
                            <div class="c-text">
                                <a class="power"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts2[0]["id"] ?>"><?php echo strlen($posts2[0]["title"]) > 60 ? mb_substr($posts2[0]["title"], 0, 60) . "..." : $posts2[0]["title"]; ?></a>
                                <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($posts2[0]["createdAt"])); ?></p>
                                <a class="reu"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts2[0]["id"] ?>"><img
                                            src="/game-news/assets/images/more.png" alt=""/></a>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php for ($i = 1; $i < count($posts2); $i++): ?>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts2[$i]["id"] ?>"><img
                                                src="/game-news/assets/<?php echo $posts2[$i]["image"]; ?>"
                                                alt="<?php echo $posts2[$i]["title"]; ?>"/></a>
                                </div>
                                <div class="sc-text">
                                    <a class="power"
                                       href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts2[$i]["id"] ?>"><?php echo strlen($posts2[$i]["title"]) > 60 ? mb_substr($posts2[$i]["title"], 0, 60) . "..." : $posts2[$i]["title"]; ?></a>
                                    <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($posts2[$i]["createdAt"])); ?></p>
                                    <a class="reu"
                                       href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts2[$i]["id"] ?>"><img
                                                src="/game-news/assets/images/more.png" alt=""/></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="s-grid-right">
                    <div class="cricket">
                        <header>
                            <h3 class="title-popular"><?php echo $categories[2]["name"]; ?></h3>
                        </header>
                        <div class="c-sports-main">
                            <div class="c-image">
                                <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts3[0]["id"] ?>"><img
                                            src="/game-news/assets/<?php echo $posts3[0]["image"]; ?>"
                                            alt="<?php echo $posts3[0]["title"]; ?>"/></a>
                            </div>
                            <div class="c-text">
                                <a class="power"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts3[0]["id"] ?>"><?php echo strlen($posts3[0]["title"]) > 60 ? mb_substr($posts3[0]["title"], 0, 60) . "..." : $posts3[0]["title"]; ?></a>
                                <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($posts3[0]["createdAt"])); ?></p>
                                <a class="reu"
                                   href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts3[0]["id"] ?>"><img
                                            src="/game-news/assets/images/more.png" alt=""/></a>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php for ($i = 1; $i < count($posts3); $i++): ?>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts3[$i]["id"] ?>"><img
                                                src="/game-news/assets/<?php echo $posts3[$i]["image"]; ?>"
                                                alt="<?php echo $posts3[$i]["title"]; ?>"/></a>
                                </div>
                                <div class="sc-text">
                                    <a class="power"
                                       href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts3[$i]["id"] ?>"><?php echo strlen($posts3[$i]["title"]) > 60 ? mb_substr($posts3[$i]["title"], 0, 60) . "..." : $posts3[$i]["title"];; ?></a>
                                    <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($posts3[$i]["createdAt"])); ?></p>
                                    <a class="reu"
                                       href="/game-news/app/pages/client/news/single.php?id=<?php echo $posts3[$i]["id"] ?>"><img
                                                src="/game-news/assets/images/more.png" alt=""/></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4 side-bar">
            <div class="first_half">
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
                                                        <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><img
                                                                    src="/game-news/assets/<?php echo $post["image"]; ?>"
                                                                    alt="<?php echo $post["title"]; ?>"/></a>
                                                    </div>
                                                    <div class="post-text">
                                                        <a class="pp-title"
                                                           href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a>
                                                        <p><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?>
                                                            <a class="span_link" href="#"><span
                                                                        class="glyphicon glyphicon-comment"></span><?php echo $post["comments"]; ?>
                                                            </a><a
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
                                                        <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><img
                                                                    src="/game-news/assets/<?php echo $post["image"]; ?>"
                                                                    alt="<?php echo $post["title"]; ?>"/></a>
                                                    </div>
                                                    <div class="post-text">
                                                        <a class="pp-title"
                                                           href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a>
                                                        <p><?php echo date('d-m-Y - h:i:s', strtotime($post["createdAt"])); ?>
                                                            <a class="span_link" href="#"><span
                                                                        class="glyphicon glyphicon-comment"></span><?php echo $post["comments"]; ?>
                                                            </a><a
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
<!-- content-section-ends-here -->

<?php
include "templates/footer.php";
?>

<script>

    $(document).on('click', '.js-expand-summary', function () {
        let fullsSummary = $(this).closest('div').attr('data-full-summary');
        $(this).closest('div').find('.js-display-summary').text(fullsSummary);
        $(this).remove();
    });

</script>

<?php
include "templates/end.php";
?>
