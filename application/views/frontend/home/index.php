<?php
  $homepage_banner_image = base_url().'assets/frontend/img/banner/banner_1.jpg';
  if (!empty($homepage_banner)) {
    $homepage_banner_image = base_url().'uploads/homepage/banner/'.$homepage_banner[0]['featured_image'];
  }
?>
<style>
.list-group-item:first-child {
  border-top-left-radius: 30px;
  border-top-right-radius: 30px;
}

.list-group-item:last-child {
  border-bottom-left-radius: 30px;
  border-bottom-right-radius: 30px;
}
.list-group {
  text-align: left;
}
.list-group a {
  margin-top: 0px !important;
  color: #676767;
}
</style>
<div class="banner-area transparent-nav banner-search content-top-heading bg-fixed text-light text-normal text-center" style="background-image: url(<?=$homepage_banner_image?>);">
  <div class="item">
    <div class="box-table shadow dark">
      <div class="box-cell">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="content">
                <h1 style="font-size:40px; line-height:50px;">GROW YOUR CAREER ANYTIME FROM ANYWHERE WITH OUR COURSES</h1>
                <form id='searchForm'>
                  <input type="text" id='searchCourse' placeholder="Enter course name" style="font-size:19px; color:#000000;" class="form-control" style="color:#000000;" name="searchCourse">
                  <button type="button" id='srchBtn'>Search Courses</button> 
                  <div id="srchResult"></div> 
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Banner -->
<!-- Start Advisor Area
  ============================================= -->
<section id="advisor" class="advisor-area bg-gray circle default-padding">
  <div class="container">
    <div class="row">
      <div class="site-heading text-center">
        <div class="col-md-8 col-md-offset-2">
          <h2>FEATURED COURSES</h2>
          <p class="fontsyle">
            Learn From Our Featured Courses To Spur Your skills To the Global Level
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="advisor-carousel owl-carousel owl-theme text-center text-light">

          <?php if (!empty($homepage_course)) { 
            foreach ($homepage_course as $row) {
          ?>
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>uploads/homepage/course/<?=$row['featured_image']?>" alt="Thumb">  
              <div class="info-title">
                <h4><?=$row['course_title']?></h4>
              </div>
              <div class="overlay">
                <div class="box">
                  <div class="content">
                    <div class="overlay-content">
                      <h4><?=$row['course_title']?></h4>
                      <p>
                        <?=substr($row['description'], 0, 100)?>
                      </p>
                      <a href="<?=base_url()?>course/<?=$row['url_title']?>">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <?php
            } 
          } else { 
          ?>

          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/01.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Basic Life Support</h4>
              </div>
              <div class="overlay">
                <div class="box">
                  <div class="content">
                    <div class="overlay-content">
                      <h4>Basic Life Support</h4>
                      <p>
                        Great explorer of the truth, the master-builder of human happiness.
                      </p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/02.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Covers Big Data analysis</h4>
              </div>
              <div class="overlay">
                <div class="box">
                  <div class="content">
                    <div class="overlay-content">
                      <h4>Covers Big Data analysis</h4>
                      <p>
                        Great explorer of the truth, the master-builder of human happiness.
                      </p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/03.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Social Science & Humanities</h4>
              </div>
              <div class="overlay">
                <div class="box">
                  <div class="content">
                    <div class="overlay-content">
                      <h4>Social Science & Humanities</h4>
                      <p>
                        Great explorer of the truth, the master-builder of human happiness.
                      </p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/04.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Online Programming</h4>
              </div>
              <div class="overlay">
                <div class="box">
                  <div class="content">
                    <div class="overlay-content">
                      <h4>Online Programming</h4>
                      <p>
                        Great explorer of the truth, the master-builder of human happiness.
                      </p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/05.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Machine Learning Management</h4>
              </div>
              <div class="overlay">
                <div class="box">
                  <div class="content">
                    <div class="overlay-content">
                      <h4>Machine Learning Management</h4>
                      <p>
                        Great explorer of the truth, the master-builder of human happiness.
                      </p>
                      <a href="#">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($homepage_upcoming_courses)) { ?>
<div class="popular-courses bg-light circle carousel-shadow default-padding">
  <div class="container">
    <div class="row">
      <div class="site-heading text-center">
        <div class="col-md-8 col-md-offset-2">
          <h2>UPCOMING COURSES</h2>
          <p>New courses going online soon.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div style="background-image:url(<?=base_url()?>'assets/frontend/img/advisor/bg.png');" class="popular-courses-items bottom-price popular-courses-carousel owl-carousel owl-theme">
          <?php foreach ($homepage_upcoming_courses as $course) { 
            $course_full_path_image = base_url().'uploads/course/'.$course['featured_image'];
            $course_target = base_url('course/'.$course['url_title']);
          ?>
          <div class="item">
            <div class="thumb">
              <a href="<?=$course_target?>"> <img src="<?=$course_full_path_image?>" alt="Thumb"> </a>
              <div class="overlay">
                <p class="fontcolor"><?=substr(strip_tags($course['description']),0, 200)?></p>
                <a class="btn btn-theme effect btn-sm left" href="<?=$course_target?>"><i class="fas fa-chart-bar"></i> Enroll Now </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="<?=$course_target?>"><?=$course['title']?></a></h4>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<!-- Start Advisor Area
  ============================================= -->
<section id="advisor" class="advisor-area bg-gray default-padding">
  <div class="container">
    <div class="row">
      <div class="site-heading text-center">
        <div class="col-md-8 col-md-offset-2">
          <h2>COURSES GALLERY</h2>
          <p>
            Able an hope of body. Any nay shyness article matters own removal nothing his forming. Gay own additions education satisfied the perpetual. If he cause manor happy. Without farther she exposed saw man led. Along on happy could cease green oh.                        
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="advisor-carousel owl-carousel owl-theme text-center text-light">
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/1.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Professon. Nuri Paul</h4>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/2.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>John Babu</h4>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/3.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Mridul Druva</h4>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/4.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Sufia Nilla</h4>
              </div>
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="advisor-item">
            <div class="info-box">
              <img src="<?=base_url()?>assets/frontend/img/advisor/5.jpg" alt="Thumb">  
              <div class="info-title">
                <h4>Professon. Nuri Paul</h4>
              </div>
            </div>
          </div>
          <!-- Single Item -->
        </div>
      </div>
    </div>
  </div>
</section>
<!--End Advisor Area -->
<!-- Start Testimonials 
  ============================================= -->
<?php if (!empty($homepage_reviews)) {  ?>
<div class="testimonials-area carousel-shadow default-padding bg-dark text-light">
  <div class="container">
    <div class="row">
      <div class="site-heading text-center">
        <div class="col-md-8 col-md-offset-2">
          <h2>Students Review</h2>
          <p>Analysis of our courses from those who have done courses with us.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="clients-review-carousel owl-carousel owl-theme">
          <?php
            foreach ($homepage_reviews as $reviews) {  
              if (strpos($reviews['profile_picture'], '.com') !== false) {
                $profile_picture = $reviews['profile_picture'];
              } else if ($reviews['profile_picture']) {
                $profile_picture = base_url().'uploads/profile/'.$reviews['profile_picture'];
              } else {
                $profile_picture = '';
              }
          ?>
          
          <div class="item">
            <div class="col-md-5 thumb">
              <img src="<?=$profile_picture?>" alt="Thumb">                            
            </div>
            <div class="col-md-7 info">
              <p><?=substr($reviews['review'], 0, 200)?></p>
              <h4><?=$reviews['name']?></h4>                       
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<!-- End Testimonials -->