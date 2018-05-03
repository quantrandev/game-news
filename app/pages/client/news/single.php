<?php

include "../../../services/connection.php";
include "../../../services/postService.php";
include "../../../services/commentService.php";
include "../../../services/categoryService.php";
$categoryService = new CategoryService($conn);
$categories = $categoryService->allActive();

$postService = new PostService($conn);
$latestNews = $postService->all(0, 5);
$mostViews = $postService->mostViews(0, 5);

$post = null;
if (isset($_GET["id"])) {
    $post = $postService->get($_GET["id"]);
}

$commentService = new CommentService($conn);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST["postId"];
    $parentId = isset($_POST["parentId"]) ? $_POST["parentId"] : 0;
    $author = $_POST["author"];
    $content = $_POST["content"];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $createdAt = date('Y-m-d h:i:s', time());

    $commentService->insert(array(
        "author" => $author,
        "postId" => $postId,
        "parentId" => $parentId,
        "content" => $content,
        "createdAt" => $createdAt
    ));
}

function generateComments($comment, $comments)
{
    $childComments = array_filter($comments, function ($c) use ($comment) {
        return $c["parentId"] == $comment["id"];
    });

    //parent comment
    echo '
        <div class="media response-info">
            <div class="media-left">
                <img class="media-object" src="/game-news/assets/images/avatar4.png" alt="" style="width: 60px;"/>
            </div>
            <div class="media-body response-text-right">
                 <h5 class="media-heading">' . $comment["author"] . '
                 <h5>
                     <small style="font-style: italic; margin: 0 5px 0 0">' . date("d-m-Y h:i:s", strtotime($comment["createdAt"])) . '</small>
                     <small><a role="button" class="js-reply" style="margin-right: 5px">Trả lời</a></small>
                     <small><a role="button" class="js-reply-count">Phản hồi (' . count($childComments) . ')</a></small>
                 </h5>
                 </h5>
                 <p>' . $comment["content"] . '</p>
                 <div class="coment-form hide" style="margin-top: 5px;">
                     <form method="post" action="">
                         <input type="hidden" name="postId" value="' . $comment["postId"] . '">
                         <input type="hidden" name="parentId" value="' . $comment["id"] . '">
                         <input type="text" placeholder="Tên"
                                required name="author">
                         <textarea required="" placeholder="Bình luận của bạn" name="content"></textarea>
                         <input type="submit" value="Gửi bình luận">
                     </form>
                 </div>
        ';

    if (count($childComments) == 0) {
        echo '
        </div>
              <div class="clearfix"></div>
        </div>
        ';
        return;
    }

    foreach ($childComments as $comment) {
        generateComments($comment, $comments);
    }
    echo '
    </div>
        <div class="clearfix"></div>
    </div>
        ';
}

$comments = $commentService->getByPost(array("postId" => $post["id"]));


$topLevelComments = array_filter($comments, function ($comment) {
    return $comment["parentId"] == 0;
});
$topLevelComments = array_values($topLevelComments);
$count = count($topLevelComments);

$page = empty($_GET["page"]) ? 1 : $_GET["page"];
$queryStringArr = array();
parse_str($_SERVER["QUERY_STRING"], $queryStringArr);
unset($queryStringArr["page"]);
$queryString = http_build_query($queryStringArr);

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

                        <div class="response" id="comments">
                            <hr>
                            <h4>Bình luận (<?php echo $count; ?>)</h4>
                            <?php
                            for ($i = ($page - 1) * 5; $i < (($page - 1) * 5) + 5 && $i < $count; $i++) {
                                generateComments($topLevelComments[$i], $comments);
                            }
                            ?>
                            <ul class="store-pages" style="margin-top: 20px;">
                                <li><span class="text-uppercase">Page:</span></li>
                                <li class="<?php if ($page == 1) echo 'hide'; ?>">
                                    <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . ($page - 1); ?>">
                                        <i class="glyphicon glyphicon-chevron-left"></i>
                                    </a>
                                </li>
                                <?php if (ceil($count / 5) < 20): ?>
                                    <?php for ($i = 1; $i <= ceil($count / 5); $i++): ?>
                                        <?php if ($page == $i): ?>
                                            <li class="active"><?php echo $i; ?></li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . $i . "#comments"; ?>">
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
                                    <?php for ($i = 6; $i <= ceil($count / 5) - 5; $i++): ?>
                                        <?php if ($page == $i): ?>
                                            <li class="active"><?php echo $i; ?></li>
                                            <li class="active">...</li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <?php for ($i = ceil($count / 5) - 4; $i <= ceil($count / 12); $i++): ?>
                                        <?php if ($page == $i): ?>
                                            <li class="active"><?php echo $i; ?></li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . $i . "#comments"; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php endif; ?>
                                <li class="<?php if ($page == ceil($count / 5)) echo 'hide'; ?>">
                                    <a href="<?php echo $_SERVER["PHP_SELF"] . "?" . $queryString . "&page=" . ($page + 1); ?>">
                                        <i class="glyphicon glyphicon-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="coment-form">
                            <h4>Bình luận về bài viết này</h4>
                            <form method="post" action="">
                                <input type="hidden" name="postId" value="<?php echo $post["id"]; ?>">
                                <input type="text" placeholder="Tên"
                                       required name="author">
                                <textarea required="" placeholder="Bình luận của bạn" name="content"></textarea>
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
                                                            <a href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><img
                                                                        src="/game-news/assets/<?php echo $post["image"]; ?>"
                                                                        alt="<?php echo $post["title"]; ?>"/></a>
                                                        </div>
                                                        <div class="post-text">
                                                            <a class="pp-title"
                                                               href="/game-news/app/pages/client/news/single.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a>
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
    $(document).on('click', '.js-reply', function () {
        $(this).closest('.media-body').find('.coment-form:first').toggleClass('hide');
    });

    $('.media-body').find('.media').hide();
    $(document).on('click', '.js-reply-count', function () {
        $(this).closest('.media-body').children('.media').toggle();
    });
</script>

<?php
include "../templates/end.php";
?>
