<footer class="bg-fixed shadow dark-hard default-padding-top text-light" style=" background-color:#000000;">
    <div class="container">
        <div class="row">
            <div class="f-items">
                <div class="col-md-4 item">
                    <div class="f-item">
                        <img src="<?=base_url()?>assets/frontend/img/logo_1.png" alt="Logo" align="middle" style="margin-left:70px;">
                        <p>Excellence doesn’t come to you, it is achieved with constant practice and testing your knowledge. We sincerely hope that we proved to be a helpful medium for you to take a step forward in your quest to be a better healthcare provider.</p>
                        <?php /*?>
                        <div class="social">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                            </ul>
                        </div>
                        <?php */?>
                    </div>
                </div> 
                <div class="col-md-4 item">
                    <div class="f-item link">
                        <h4>Courses</h4>
                        <ul>
                            <?php if (!empty($this->courseList)) {
                                // shuffle($this->courseList); 
                                $counter = 0;
                                foreach($this->courseList as $course) {
                                    if ($counter ==  6) {
                                        break;
                                    }    
                            ?>

                            <li><a href="<?=base_url('course/'.$course['url_title'])?>"><?=$course['title']?></a></li>
                            <?php $counter++; }  
                            } ?>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4 item">
                    <div class="f-item recent-post">
                        <h4>Popular Courses</h4>
                        <ul>
                            <?php if (!empty($this->upcomingCourseList)) { 
                                foreach($this->upcomingCourseList as $upcomingCourse) { 
                                    $thumb_path = base_url('uploads/course/thumb/'.$upcomingCourse['featured_image']);   
                                    $course_details_url = base_url().'course/'.$upcomingCourse['url_title'];
                            ?>
                            <li>
                                <div class="thumb">
                                    <a href="<?=$course_details_url?>">
                                        <img src="<?=$thumb_path?>" alt="Thumb">                                        
                                    </a>                                    
                                </div>
                                <div class="info">
                                    <a href="<?=$course_details_url?>"><?=$upcomingCourse['title']?></a>
                                    <div class="meta-title">
                                        <span class="post-date"><?=Date('d M  Y ',strtotime($upcomingCourse['created_at']))?></span>
                                    </div>
                                </div>
                            </li>
                            <?php } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Footer Bottom -->
    <div class="footer-bottom bg-transparent">
        <div class="container">
            <div class="row">
                <div class="copyrights-col-left col-md-6 col-sm-6">
                    <p>© <?=Date('Y')?>, <a href="http://www.ghahealth.com/">Global Health Alliance</a>, A Unit of <strong>Fit Heart Matters Pvt. Ltd.</strong> All Rights Reserved.<br>
                        <a href="/Terms-of-Use.php">Terms of Use</a>, <a href="/Privacy-Policy.php">Privacy Policy</a>, <a href="/Refund-Policy.php">Refund Policy</a> D&amp;M by <a href="http://spidersofweb.com" target="_blank">   &nbsp;Spiders Of Web</a>
                    </p>
                </div>
                <div class="copyrights-col-right col-md-6 col-sm-6">
                    <div class="social pull-right mini">
                        <ul>
                            <li><a href="https://www.facebook.com/pages/Global-Health-Alliance/401372073343623" target="_blank"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="https://twitter.com/ghahealth" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://plus.google.com/104405833494998711002" target="_blank"><i class="fab fa-google-plus"></i></a></li>
                        </ul> 
                        <!--<a href="http://www.pinterest.com/" target="_blank"><i class="fab fa-pinterest"></i></a> -->
                        
                        <!--<a href="http://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a> -->
                        <!--<a href="#"><i class="fab fa-rss"></i></a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>