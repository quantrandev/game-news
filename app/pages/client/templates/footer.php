<!-- footer-section-starts-here -->
<div class="footer">
    <div class="footer-top">
        <div class="wrap">
            <div class="col-md-3 col-xs-6 col-sm-4 footer-grid">
                <h4 class="footer-head">About Us</h4>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when
                    looking at its layout.</p>
                <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as
                    opposed to using 'Content here.</p>
            </div>
            <div class="col-md-2 col-xs-6 col-sm-2 footer-grid">
                <h4 class="footer-head">Categories</h4>
                <ul class="cat">
                    <li><a href="business.html">Business</a></li>
                    <li><a href="technology.html">Technology</a></li>
                    <li><a href="entertainment.html">Entertainment</a></li>
                    <li><a href="sports.html">Sports</a></li>
                    <li><a href="shortcodes.html">Health</a></li>
                    <li><a href="fashion.html">Fashion</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-xs-6 col-sm-6 footer-grid">
                <h4 class="footer-head">Flickr Feed</h4>
                <ul class="flickr">
                    <li><a href="#"><img src="images/bus4.jpg"></a></li>
                    <li><a href="#"><img src="images/bus2.jpg"></a></li>
                    <li><a href="#"><img src="images/bus3.jpg"></a></li>
                    <li><a href="#"><img src="images/tec4.jpg"></a></li>
                    <li><a href="#"><img src="images/tec2.jpg"></a></li>
                    <li><a href="#"><img src="images/tec3.jpg"></a></li>
                    <li><a href="#"><img src="images/bus2.jpg"></a></li>
                    <li><a href="#"><img src="images/bus3.jpg"></a></li>
                    <div class="clearfix"></div>
                </ul>
            </div>
            <div class="col-md-3 col-xs-12 footer-grid">
                <h4 class="footer-head">Contact Us</h4>
                <span class="hq">Our headquaters</span>
                <address>
                    <ul class="location">
                        <li><span class="glyphicon glyphicon-map-marker"></span></li>
                        <li>CENTER FOR FINANCIAL ASSISTANCE TO DEPOSED NIGERIAN ROYALTY</li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="location">
                        <li><span class="glyphicon glyphicon-earphone"></span></li>
                        <li>+0 561 111 235</li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="location">
                        <li><span class="glyphicon glyphicon-envelope"></span></li>
                        <li><a href="mailto:info@example.com">mail@example.com</a></li>
                        <div class="clearfix"></div>
                    </ul>
                </address>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="wrap">
            <div class="copyrights col-md-6">
                <p> © 2015 Express News. All Rights Reserved | Design by <a href="http://w3layouts.com/"> W3layouts</a>
                </p>
            </div>
            <div class="footer-social-icons col-md-6">
                <ul>
                    <li><a class="facebook" href="#"></a></li>
                    <li><a class="twitter" href="#"></a></li>
                    <li><a class="flickr" href="#"></a></li>
                    <li><a class="googleplus" href="#"></a></li>
                    <li><a class="dribbble" href="#"></a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- footer-section-ends-here -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/game-news/assets/client/js/jquery.min.js"></script>
<!-- for bootstrap working -->
<script type="text/javascript" src="/game-news/assets/client/js/bootstrap.js"></script>
<!-- //for bootstrap working -->
<script src="/game-news/assets/client/js/responsiveslides.min.js"></script>
<script>
    $(function () {
        $("#slider").responsiveSlides({
            auto: true,
            nav: true,
            speed: 500,
            namespace: "callbacks",
            pager: true,
        });
    });
</script>
<script type="text/javascript" src="/game-news/assets/client/js/move-top.js"></script>
<script type="text/javascript" src="/game-news/assets/client/js/easing.js"></script>
<script type="text/javascript" src="/game-news/assets/client/js/jquery.marquee.min.js"></script>
<!--/script-->
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 900);
        });

        $('.marquee').marquee({ pauseOnHover: true,duration: 7000 });
    });
</script>
<a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!---->