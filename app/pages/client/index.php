<?php

include "../../services/connection.php";
include "../../services/newsService.php";
include "../../services/categoryService.php";
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

$newsService = new NewsService($conn);
$latestNews = $newsService->all(0, 5);
$mostViews = $newsService->mostViews(0, 5);
$news1 = $newsService->getWithCategory(0, 4, $categories[0]["id"]);
$news2 = $newsService->getWithCategory(0, 4, $categories[1]["id"]);
$news3 = $newsService->getWithCategory(0, 4, $categories[2]["id"]);
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
                <?php foreach ($latestNews as $new): ?>
                    <div class="article">
                        <div class="article-left">
                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><img
                                        src="/game-news/assets/<?php echo $new["image"]; ?>"></a>
                        </div>
                        <div class="article-right">
                            <div class="article-title">
                                <p><?php echo date('d-m-Y - h:i:s', strtotime($new["createdAt"])); ?> <a
                                            class="span_link" href="#"><span
                                                class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link"
                                                                                                    href="#"><span
                                                class="glyphicon glyphicon-eye-open"></span><?php echo $new["views"]; ?>
                                    </a></p>
                                <h5>
                                    <a class="title" href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><?php echo $new["title"]; ?></a>
                                </h5>
                            </div>
                            <div class="article-text">
                                <p><?php echo $new["summary"]; ?></p>
                                <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><img
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
                    <?php for ($i = 0; $i < count($news1) / 2; $i++): ?>
                        <div class="life-style-left-grid">
                            <a href="/game-news/app/pages/client/single.php?id=<?php echo $news1[$i]["id"]; ?>"><img
                                        src="/game-news/assets/<?php echo $news1[$i]["image"]; ?>"
                                        alt="<?php echo $news1[$i]["title"]; ?>"/></a>
                            <a class="title title-small"
                               href="/game-news/app/pages/client/single.php?id=<?php echo $news1[$i]["id"]; ?>"><?php echo strlen($news1[0]["title"]) > 60 ? mb_substr($news1[0]["title"], 0, 60) . "..." : $news1[0]["title"]; ?></a>
                            <p class="summary">
                            <p>
                                <small class="italic"><?php echo date('d-m-Y - h:i:s', strtotime($new["createdAt"])); ?></small>
                            </p>
                            <?php echo $news1[$i]["summary"]; ?>
                            </p>
                        </div>
                    <?php endfor; ?>
                    <div class="clearfix"></div>
                </div>
                <div class="life-style-grids">
                    <?php for ($i = count($news1) / 2; $i < count($news1); $i++): ?>
                        <div class="life-style-left-grid">
                            <a href="/game-news/app/pages/client/single.php?id=<?php echo $news1[$i]["id"]; ?>"><img
                                        src="/game-news/assets/<?php echo $news1[$i]["image"]; ?>"
                                        alt="<?php echo $news1[$i]["title"]; ?>"/></a>
                            <a class="title title-small"
                               href="/game-news/app/pages/client/single.php?id=<?php echo $news1[$i]["id"]; ?>"><?php echo strlen($news1[0]["title"]) > 60 ? mb_substr($news1[0]["title"], 0, 60) . "..." : $news1[0]["title"]; ?></a>
                            <p class="summary">
                            <p>
                                <small class="italic"><?php echo date('d-m-Y - h:i:s', strtotime($new["createdAt"])); ?></small>
                            </p>
                            <?php echo $news1[$i]["summary"]; ?>
                            </p>
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
                                <a href="/game-news/app/pages/client/single.php?id=<?php echo $news2[0]["id"] ?>"><img
                                            src="/game-news/assets/<?php echo $news2[0]["image"]; ?>"
                                            alt="<?php echo $news2[0]["title"]; ?>"/></a>
                            </div>
                            <div class="c-text">
                                <a class="power"
                                   href="/game-news/app/pages/client/single.php?id=<?php echo $news2[0]["id"] ?>"><?php echo strlen($news2[0]["title"]) > 60 ? mb_substr($news2[0]["title"], 0, 60) . "..." : $news2[0]["title"]; ?></a>
                                <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($news2[0]["createdAt"])); ?></p>
                                <a class="reu"
                                   href="/game-news/app/pages/client/single.php?id=<?php echo $news2[0]["id"] ?>"><img
                                            src="/game-news/assets/images/more.png" alt=""/></a>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php for ($i = 1; $i < count($news2); $i++): ?>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="/game-news/app/pages/client/single.php?id=<?php echo $news2[$i]["id"] ?>"><img
                                                src="/game-news/assets/<?php echo $news2[$i]["image"]; ?>"
                                                alt="<?php echo $news2[$i]["title"]; ?>"/></a>
                                </div>
                                <div class="sc-text">
                                    <a class="power"
                                       href="/game-news/app/pages/client/single.php?id=<?php echo $news2[$i]["id"] ?>"><?php echo strlen($news2[$i]["title"]) > 60 ? mb_substr($news2[$i]["title"], 0, 60) . "..." : $news2[$i]["title"]; ?></a>
                                    <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($news2[$i]["createdAt"])); ?></p>
                                    <a class="reu"
                                       href="/game-news/app/pages/client/single.php?id=<?php echo $news2[$i]["id"] ?>"><img
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
                            <h3 class="title-popular"><?php echo $categories[2]["name"];?></h3>
                        </header>
                        <div class="c-sports-main">
                            <div class="c-image">
                                <a href="/game-news/app/pages/client/single.php?id=<?php echo $news3[0]["id"] ?>"><img
                                            src="/game-news/assets/<?php echo $news3[0]["image"]; ?>"
                                            alt="<?php echo $news3[0]["title"]; ?>"/></a>
                            </div>
                            <div class="c-text">
                                <a class="power"
                                   href="/game-news/app/pages/client/single.php?id=<?php echo $news3[0]["id"] ?>"><?php echo strlen($news3[0]["title"]) > 60 ? mb_substr($news3[0]["title"], 0, 60) . "..." : $news3[0]["title"]; ?></a>
                                <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($news3[0]["createdAt"])); ?></p>
                                <a class="reu"
                                   href="/game-news/app/pages/client/single.php?id=<?php echo $news3[0]["id"] ?>"><img
                                            src="/game-news/assets/images/more.png" alt=""/></a>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php for ($i = 1; $i < count($news3); $i++): ?>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="/game-news/app/pages/client/single.php?id=<?php echo $news3[$i]["id"] ?>"><img
                                                src="/game-news/assets/<?php echo $news3[$i]["image"]; ?>"
                                                alt="<?php echo $news3[$i]["title"]; ?>"/></a>
                                </div>
                                <div class="sc-text">
                                    <a class="power"
                                       href="/game-news/app/pages/client/single.php?id=<?php echo $news3[$i]["id"] ?>"><?php echo strlen($news3[$i]["title"]) > 60 ? mb_substr($news3[$i]["title"], 0, 60) . "..." : $news3[$i]["title"];; ?></a>
                                    <p class="date"><?php echo date('d-m-Y - h:i:s', strtotime($news3[$i]["createdAt"])); ?></p>
                                    <a class="reu"
                                       href="/game-news/app/pages/client/single.php?id=<?php echo $news3[$i]["id"] ?>"><img
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
                                            <?php foreach ($mostViews as $new): ?>
                                                <div class="popular-post-grid">
                                                    <div class="post-img">
                                                        <a href="/game-news/app/pages/client/single.php?id=<?php echo $new["id"]; ?>"><img
                                                                    src="/game-news/assets/<?php echo $new["image"]; ?>"
                                                                    alt="<?php echo $new["title"]; ?>"/></a>
                                                    </div>
                                                    <div class="post-text">
                                                        <a class="pp-title"
                                                           href="/game-news/app/pages/client/single.php?id=<?php echo $new["id"]; ?>"><?php echo $new["title"]; ?></a>
                                                        <p><?php echo date('d-m-Y - h:i:s', strtotime($new["createdAt"])); ?>
                                                            <a class="span_link" href="#"><span
                                                                        class="glyphicon glyphicon-comment"></span>0</a><a
                                                                    class="span_link" href="#"><span
                                                                        class="glyphicon glyphicon-eye-open"></span><?php echo $new["views"]; ?>
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
                                            <?php foreach ($latestNews as $new): ?>
                                                <div class="popular-post-grid">
                                                    <div class="post-img">
                                                        <a href="/game-news/app/pages/client/single.php?id=<?php echo $new["id"]; ?>"><img
                                                                    src="/game-news/assets/<?php echo $new["image"]; ?>"
                                                                    alt="<?php echo $new["title"]; ?>"/></a>
                                                    </div>
                                                    <div class="post-text">
                                                        <a class="pp-title"
                                                           href="/game-news/app/pages/client/single.php?id=<?php echo $new["id"]; ?>"><?php echo $new["title"]; ?></a>
                                                        <p><?php echo date('d-m-Y - h:i:s', strtotime($new["createdAt"])); ?>
                                                            <a class="span_link" href="#"><span
                                                                        class="glyphicon glyphicon-comment"></span>0</a><a
                                                                    class="span_link" href="#"><span
                                                                        class="glyphicon glyphicon-eye-open"></span><?php echo $new["views"]; ?>
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

<?php
include "templates/end.php";
?>
