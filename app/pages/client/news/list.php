<?php

include "../../../services/connection.php";
include "../../../services/newsService.php";
include "../../../services/categoryService.php";
$categoryService = new CategoryService($conn);
$categories = $categoryService->all();

$newsService= new NewsService($conn);
$latestNews = $newsService->all(0, 5);
$mostViews = $newsService->mostViews(0, 5);

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
    <div class="wrap">
        <div class="privacy-page">
            <div class="col-md-8 content-left">
                <div class="fashion">
                    <div class="fashion-top">
                        <div class="fashion-left">
                            <a href="single.html"><img src="images/f1.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Jun 20, 2015 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">Contrary to popular belief</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="fashion-right">
                            <a href="single.html"><img src="images/f2.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Apr 18, 2015 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">Lorem Ipsum is simply</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fashion-top">
                        <div class="fashion-left">
                            <a href="single.html"><img src="images/f3.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Mar 28, 2015 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">There are many variations</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="fashion-right">
                            <a href="single.html"><img src="images/f4.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Feb 25, 2015 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">Sed ut perspiciatis</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fashion-top">
                        <div class="fashion-left">
                            <a href="single.html"><img src="images/f5.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Jan 28, 2015 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">denouncing pleasure</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="fashion-right">
                            <a href="single.html"><img src="images/f6.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Jan 08, 2015 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">At vero eos et accusamus</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fashion-top">
                        <div class="fashion-left">
                            <a href="single.html"><img src="images/f7.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Dec 29, 2014 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>0 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>52</a></p>
                            </div>
                            <h3><a href="single.html">On the other hand</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="fashion-right">
                            <a href="single.html"><img src="images/f8.jpg" class="img-responsive" alt=""></a>
                            <div class="blog-poast-info">
                                <p class="fdate"><span class="glyphicon glyphicon-time"></span>On Dec 18, 2014 <a class="span_link1" href="#"><span class="glyphicon glyphicon-comment"></span>5 </a><a class="span_link1" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>22</a></p>
                            </div>
                            <h3><a href="single.html">blanditiis praesentium</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="photos fashion-photos">
                    <header>
                        <h3 class="title-head">Gallery</h3>
                    </header>
                    <div class="course_demo1">
                        <ul id="flexiselDemo">
                            <li>
                                <a href="single.html"><img src="images/f2.jpg" alt="" /></a>
                            </li>
                            <li>
                                <a href="single.html"><img src="images/f3.jpg" alt="" /></a>
                            </li>
                            <li>
                                <a href="single.html"><img src="images/f8.jpg" alt="" /></a>
                            </li>
                            <li>
                                <a href="single.html"><img src="images/f6.jpg" alt="" /></a>
                            </li>
                        </ul>
                    </div>
                    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
                    <script type="text/javascript">
                        $(window).load(function() {
                            $("#flexiselDemo").flexisel({
                                visibleItems: 4,
                                animationSpeed: 1000,
                                autoPlay: true,
                                autoPlaySpeed: 3000,
                                pauseOnHover: true,
                                enableResponsiveBreakpoints: true,
                                responsiveBreakpoints: {
                                    portrait: {
                                        changePoint:480,
                                        visibleItems: 2
                                    },
                                    landscape: {
                                        changePoint:640,
                                        visibleItems: 2
                                    },
                                    tablet: {
                                        changePoint:768,
                                        visibleItems: 3
                                    }
                                }
                            });

                        });
                    </script>
                    <script type="text/javascript" src="js/jquery.flexisel.js"></script>

                    <div class="course_demo1">
                        <ul id="flexiselDemo1">
                            <li>
                                <a href="single.html"><img src="images/f1.jpg" alt="" /></a>
                            </li>
                            <li>
                                <a href="single.html"><img src="images/f4.jpg" alt="" /></a>
                            </li>
                            <li>
                                <a href="single.html"><img src="images/f7.jpg" alt="" /></a>
                            </li>
                            <li>
                                <a href="single.html"><img src="images/f5.jpg" alt="" /></a>
                            </li>
                        </ul>
                    </div>
                    <script type="text/javascript">
                        $(window).load(function() {
                            $("#flexiselDemo1").flexisel({
                                visibleItems: 4,
                                animationSpeed: 1000,
                                autoPlay: true,
                                autoPlaySpeed: 3000,
                                pauseOnHover: true,
                                enableResponsiveBreakpoints: true,
                                responsiveBreakpoints: {
                                    portrait: {
                                        changePoint:480,
                                        visibleItems: 2
                                    },
                                    landscape: {
                                        changePoint:640,
                                        visibleItems: 2
                                    },
                                    tablet: {
                                        changePoint:768,
                                        visibleItems: 3
                                    }
                                }
                            });

                        });
                    </script>
                </div>


                <div class="life-style">
                    <header>
                        <h3 class="title-head">Life Style</h3>
                    </header>
                    <div class="life-style-grids">
                        <div class="life-style-left-grid">
                            <a href="single.html"><img src="images/l1.jpg" alt="" /></a>
                            <a class="title" href="single.html">It is a long established fact that a reader will be distracted.</a>
                        </div>
                        <div class="life-style-right-grid">
                            <a href="single.html"><img src="images/l2.jpg" alt="" /></a>
                            <a class="title" href="single.html">There are many variations of passages of Lorem Ipsum available.</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="life-style-grids">
                        <div class="life-style-left-grid">
                            <a href="single.html"><img src="images/l3.jpg" alt="" /></a>
                            <a class="title" href="single.html">Contrary to popular belief, Lorem Ipsum is not simply random text.</a>
                        </div>
                        <div class="life-style-right-grid">
                            <a href="single.html"><img src="images/l4.jpg" alt="" /></a>
                            <a class="title" href="single.html">Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="sports-top">
                    <div class="s-grid-left">
                        <div class="cricket">
                            <header>
                                <h3 class="title-head">Business</h3>
                            </header>
                            <div class="c-sports-main">
                                <div class="c-image">
                                    <a href="single.html"><img src="images/bus1.jpg" alt="" /></a>
                                </div>
                                <div class="c-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Feb 25, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="single.html"><img src="images/bus2.jpg" alt="" /></a>
                                </div>
                                <div class="sc-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Mar 21, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="single.html"><img src="images/bus3.jpg" alt="" /></a>
                                </div>
                                <div class="sc-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Jan 25, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="single.html"><img src="images/bus4.jpg" alt="" /></a>
                                </div>
                                <div class="sc-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Jul 19, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="s-grid-right">
                        <div class="cricket">
                            <header>
                                <h3 class="title-popular">Technology</h3>
                            </header>
                            <div class="c-sports-main">
                                <div class="c-image">
                                    <a href="single.html"><img src="images/tec1.jpg" alt="" /></a>
                                </div>
                                <div class="c-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Apr 22, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="single.html"><img src="images/tec2.jpg" alt="" /></a>
                                </div>
                                <div class="sc-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Jan 19, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="single.html"><img src="images/tec3.jpg" alt="" /></a>
                                </div>
                                <div class="sc-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Jun 25, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="s-grid-small">
                                <div class="sc-image">
                                    <a href="single.html"><img src="images/tec4.jpg" alt="" /></a>
                                </div>
                                <div class="sc-text">
                                    <h6>Lorem Ipsum</h6>
                                    <a class="power" href="single.html">It is a long established fact that a reader</a>
                                    <p class="date">On Jul 19, 2015</p>
                                    <a class="reu" href="single.html"><img src="images/more.png" alt="" /></a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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
                                <li><a href="/game-news/app/pages/client/news/list.php?id=<?php echo $category["id"];?>"><?php echo $category["name"];?></a></li>
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
</div>
<!-- content-section-ends-here -->

<?php
include "../templates/footer.php";
?>

<?php
include "../templates/end.php";
?>
