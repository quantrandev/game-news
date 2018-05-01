<?php

include "../../../services/connection.php";
include "../../../services/newsService.php";
include "../../../services/categoryService.php";
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

$newsService = new NewsService($conn);
$latestNews = $newsService->all(0, 5);
$mostViews = $newsService->mostViews(0, 5);

$post = null;
if (isset($_GET["id"])) {
    $post = $newsService->get($_GET["id"]);
}

$postInSameCategory = $newsService->getWithCategory(0, 4, $post["categoryId"]);
$relatedPosts = array_filter($postInSameCategory, function ($value) use ($post) {
    return $value["id"] != $post["id"];
});


include "../templates/head.php";
include "../templates/header.php";

?>
<!-- content-section-starts-here -->
<div class="main-body">
    <div class="wrap" style="margin-top: 20px">
        <div class="single-page">
            <div class="col-md-8 content-left single-post">
                <div class="blog-posts">
                    <h3 class="post"><?php echo $post["title"]; ?></h3>
                    <p><b><?php echo $post["author"]; ?></b>
                        - <?php echo date('d/m/Y h:i:s', strtotime($post["createdAt"])); ?></p>
                    <p class="italic m-t-15 m-b-15"><?php echo $post["summary"]; ?></p>
                    <div class="last-article">
                        <?php echo $post["content"]; ?>
                        <div class="clearfix"></div>

                        <div class="response">
                            <hr>
                            <h4>Bình luận</h4>
                            <div class="media response-info">
                                <div class="media-left response-text-left">
                                    <a href="#">
                                        <img class="media-object" src="images/c1.jpg" alt=""/>
                                    </a>
                                    <h5><a href="#">Username</a></h5>
                                </div>
                                <div class="media-body response-text-right">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                                        variations of passages of Lorem Ipsum available,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <ul>
                                        <li>Sep 21, 2015</li>
                                        <li><a href="single.html">Reply</a></li>
                                    </ul>
                                    <div class="media response-info">
                                        <div class="media-left response-text-left">
                                            <a href="#">
                                                <img class="media-object" src="images/c2.jpg" alt=""/>
                                            </a>
                                            <h5><a href="#">Username</a></h5>
                                        </div>
                                        <div class="media-body response-text-right">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                                                variations of passages of Lorem Ipsum available,
                                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            <ul>
                                                <li>July 17, 2015</li>
                                                <li><a href="single.html">Reply</a></li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="media response-info">
                                <div class="media-left response-text-left">
                                    <a href="#">
                                        <img class="media-object" src="images/c3.jpg" alt=""/>
                                    </a>
                                    <h5><a href="#">Username</a></h5>
                                </div>
                                <div class="media-body response-text-right">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                                        variations of passages of Lorem Ipsum available,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <ul>
                                        <li>June 21, 2015</li>
                                        <li><a href="single.html">Reply</a></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="media response-info">
                                <div class="media-left response-text-left">
                                    <a href="#">
                                        <img class="media-object" src="images/c4.jpg" alt=""/>
                                    </a>
                                    <h5><a href="#">Username</a></h5>
                                </div>
                                <div class="media-body response-text-right">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                                        variations of passages of Lorem Ipsum available,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <ul>
                                        <li>Mar 28, 2015</li>
                                        <li><a href="single.html">Reply</a></li>
                                    </ul>
                                    <div class="media response-info">
                                        <div class="media-left response-text-left">
                                            <a href="#">
                                                <img class="media-object" src="images/c5.jpg" alt=""/>
                                            </a>
                                            <h5><a href="#">Username</a></h5>
                                        </div>
                                        <div class="media-body response-text-right">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                                                variations of passages of Lorem Ipsum available,
                                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            <ul>
                                                <li>Feb 19, 2015</li>
                                                <li><a href="single.html">Reply</a></li>
                                            </ul>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="media response-info">
                                <div class="media-left response-text-left">
                                    <a href="#">
                                        <img class="media-object" src="images/c6.jpg" alt=""/>
                                    </a>
                                    <h5><a href="#">Username</a></h5>
                                </div>
                                <div class="media-body response-text-right">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,There are many
                                        variations of passages of Lorem Ipsum available,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <ul>
                                        <li>Jan 20, 2015</li>
                                        <li><a href="single.html">Reply</a></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="coment-form">
                            <h4>Bình luận về bài viết này</h4>
                            <form>
                                <input type="text" placeholder="Tên"
                                       required="">
                                <textarea required="" placeholder="Bình luận của bạn"></textarea>
                                <input type="submit" value="Gửi bình luận">
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
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
                                                <?php foreach ($mostViews as $new): ?>
                                                    <div class="popular-post-grid">
                                                        <div class="post-img">
                                                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><img
                                                                        src="/game-news/assets/<?php echo $new["image"]; ?>"
                                                                        alt="<?php echo $new["title"]; ?>"/></a>
                                                        </div>
                                                        <div class="post-text">
                                                            <a class="pp-title"
                                                               href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><?php echo $new["title"]; ?></a>
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
                                                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><img
                                                                        src="/game-news/assets/<?php echo $new["image"]; ?>"
                                                                        alt="<?php echo $new["title"]; ?>"/></a>
                                                        </div>
                                                        <div class="post-text">
                                                            <a class="pp-title"
                                                               href="/game-news/app/pages/client/news/single.php?id=<?php echo $new["id"]; ?>"><?php echo $new["title"]; ?></a>
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
</div>
<!-- content-section-ends-here -->

<?php
include "../templates/footer.php";
?>

<script>
    $.ajax({
        url: '/game-news/app/controllers/client.php',
        type: 'post',
        data: {function: 'view', postId: '<?php echo $_GET["id"];?>'},
        success: function (res) {
            console.log(res);
        },
        error: function (err) {

        }
    });
</script>

<?php
include "../templates/end.php";
?>
