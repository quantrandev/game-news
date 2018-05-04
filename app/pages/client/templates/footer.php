<!-- footer-section-starts-here -->
<div class="footer">
    <div class="footer-bottom">
        <div class="wrap">
            <div class="copyrights col-md-6">
                <p> © <?php echo date('Y'); ?> Tên website. All Rights Reserved | Design by <a
                            href="http://w3layouts.com/"> Tên người bảo vệ</a>
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

        $('.marquee').marquee({pauseOnHover: true, duration: 7000});
    });
</script>
<a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!---->