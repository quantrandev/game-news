<!-- header-section-starts-here -->
<div class="header">
    <div class="header-top">
        <div class="wrap">
            <div class="top-menu">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="privacy-policy.html">Privacy Policy</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
            <div class="num">
                <p> Call us : 032 2352 782</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="logo text-center">
            <a href="index.html"><img src="images/logo.jpg" alt=""/></a>
        </div>
        <div class="navigation">
            <nav class="navbar navbar-default" role="navigation">
                <div class="wrap">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                    </div>
                    <!--/.navbar-header-->

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="/game-news/app/pages/client/">HOME</a></li>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="/game-news/app/pages/client/news/list.php?id=<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!--/.navbar-collapse-->
                <!--/.navbar-->
        </div>
        </nav>
    </div>
</div>
<!-- header-section-ends-here -->