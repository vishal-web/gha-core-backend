<!-- Start Banner 
  ============================================= -->
<?php
  $homepage_banner_image = base_url().'assets/frontend/img/banner/banner_1.jpg';
  if (!empty($homepage_banner)) {
    $homepage_banner_image = base_url().'uploads/homepage/banner/'.$homepage_banner[0]['featured_image'];
  }
?>

<div class="banner-area transparent-nav banner-search content-top-heading bg-fixed text-light text-normal text-center" style="background-image: url(<?=$homepage_banner_image?>);">
  <div class="item">
    <div class="box-table shadow dark">
      <div class="box-cell">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="content">
                <h1 style="font-size:40px; line-height:50px;">GROW YOUR CAREER ANYTIME FROM ANYWHERE WITH OUR COURSES</h1>
                <form action="#">
                  <input type="text" placeholder="Enter course name" style="font-size:19px; color:#000000;" class="form-control" style="color:#000000;" name="text">
                  <button type="submit">
                  Search Courses                                        </button>  
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
<!--End Advisor Area -->
<!-- Start Popular Courses 
  ============================================= -->
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
          <!-- Single Item -->
          <div class="item">
            <div class="thumb">
              <a href="#">
              <img src="<?=base_url()?>assets/frontend/img/courses/6.jpg" alt="Thumb">
              </a>
              <div class="overlay">
                <p class="fontcolor">Discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection off. Connection stimulated estimating excellence an to impression. </p>
                <a class="btn btn-theme effect btn-sm left" href="#">
                <i class="fas fa-chart-bar"></i> Enroll Now     
                </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="#">Basic Life Support</a></h4>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="thumb">
              <a href="#">
              <img src="<?=base_url()?>assets/frontend/img/courses/1.jpg" alt="Thumb">
              </a>
              <div class="overlay">
                <p class="fontcolor">Discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection off. Connection stimulated estimating excellence an to impression. </p>
                <a class="btn btn-theme effect btn-sm left" href="#">
                <i class="fas fa-chart-bar"></i> Enroll Now     
                </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="#">Machine Learning Management</a></h4>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="thumb">
              <a href="#">
              <img src="<?=base_url()?>assets/frontend/img/courses/2.jpg" alt="Thumb">
              </a>
              <div class="overlay">
                <p class="fontcolor">Discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection off. Connection stimulated estimating excellence an to impression. </p>
                <a class="btn btn-theme effect btn-sm left" href="#">
                <i class="fas fa-chart-bar"></i> Enroll Now     
                </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="#">Java Programming Masterclass</a></h4>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="thumb">
              <a href="#">
              <img src="<?=base_url()?>assets/frontend/img/courses/3.jpg" alt="Thumb">
              </a>
              <div class="overlay">
                <p class="fontcolor">Discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection off. Connection stimulated estimating excellence an to impression. </p>
                <a class="btn btn-theme effect btn-sm left" href="#">
                <i class="fas fa-chart-bar"></i> Enroll Now     
                </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="#">Online Programming</a></h4>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="thumb">
              <a href="#">
              <img src="<?=base_url()?>assets/frontend/img/courses/4.jpg" alt="Thumb">
              </a>
              <div class="overlay">
                <p class="fontcolor">Discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection off. Connection stimulated estimating excellence an to impression. </p>
                <a class="btn btn-theme effect btn-sm left" href="#">
                <i class="fas fa-chart-bar"></i> Enroll Now     
                </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="#">Machine Learning Management</a></h4>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="thumb">
              <a href="#">
              <img src="<?=base_url()?>assets/frontend/img/courses/5.jpg" alt="Thumb">
              </a>
              <div class="overlay">
                <p class="fontcolor">Discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection off. Connection stimulated estimating excellence an to impression. </p>
                <a class="btn btn-theme effect btn-sm left" href="#">
                <i class="fas fa-chart-bar"></i> Enroll Now     
                </a>
              </div>
            </div>
            <div class="info">
              <h4 style="text-align: center;"><a href="#">Covers Big Data analysis</a></h4>
            </div>
          </div>
          <!-- End Single Item -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Popular Courses -->	
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
          <!-- Single Item -->
          <div class="item">
            <div class="col-md-5 thumb">
              <img src="<?=base_url()?>assets/frontend/img/team/2.jpg" alt="Thumb">                            
            </div>
            <div class="col-md-7 info">
              <p>
                Procuring continued suspicion its ten. Pursuit brother are had fifteen distant has. Early had add equal china quiet visit. Appear an manner as no limits either praise..                                
              </p>
              <h4>Druna Patia</h4>
              <span>Biology Student</span>                            
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="col-md-5 thumb">
              <img src="<?=base_url()?>assets/frontend/img/team/3.jpg" alt="Thumb">                            
            </div>
            <div class="col-md-7 info">
              <p>
                Procuring continued suspicion its ten. Pursuit brother are had fifteen distant has. Early had add equal china quiet visit. Appear an manner as no limits either praise..                                
              </p>
              <h4>Astron Brun</h4>
              <span>Science Student</span>                            
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="col-md-5 thumb">
              <img src="<?=base_url()?>assets/frontend/img/team/4.jpg" alt="Thumb">                            
            </div>
            <div class="col-md-7 info">
              <p>
                Procuring continued suspicion its ten. Pursuit brother are had fifteen distant has. Early had add equal china quiet visit. Appear an manner as no limits either praise..                                
              </p>
              <h4>Paol Druva</h4>
              <span>Development Student</span>                            
            </div>
          </div>
          <!-- Single Item -->
          <!-- Single Item -->
          <div class="item">
            <div class="col-md-5 thumb">
              <img src="<?=base_url()?>assets/frontend/img/team/7.jpg" alt="Thumb">                            
            </div>
            <div class="col-md-7 info">
              <p>
                Procuring continued suspicion its ten. Pursuit brother are had fifteen distant has. Early had add equal china quiet visit. Appear an manner as no limits either praise..                                
              </p>
              <h4>Druna Patia</h4>
              <span>Biology Student</span>                            
            </div>
          </div>
          <!-- Single Item -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Testimonials -->