<header id="home">
  <!-- Start Navigation -->
  <?php
    $nav_class = "navbar navbar-default navbar-fixed navbar-transparent white bootsnav"; 
    $logo_display = TRUE;
    if (!$this->homepage) {
      $logo_display = FALSE; 
      $nav_class = "navbar navbar-default attr-border navbar-sticky bootsnav on no-full";
    }
  ?>
  <nav class="<?=$nav_class?>">
    <div class="container">
      <!-- Start Atribute Navigation -->
      <!-- End Atribute Navigation -->
      <!-- Start Header Navigation -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
        <i class="fa fa-bars"></i></button>
        <a class="navbar-brand" href="index.html">
        <?php if ($logo_display) { ?>
        <img src="<?=base_url()?>assets/frontend/img/logo1.png" class="logo logo-display" alt="Logo">
        <?php } ?>
        <img src="<?=base_url()?>assets/frontend/img/logo2.png" class="logo logo-scrolled" alt="Logo">                    </a>                
      </div>
      <!-- End Header Navigation -->
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-menu" >
        <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#" style="margin-top:30px;">
          <li>
            <a href="index.html" class="dropdown-toggle active" data-toggle="dropdown" style="font-size:18px;" >Home</a>                        
          </li>
          <li class="dropdown megamenu-fw">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size:18px;" >Online Courses</a>
            <ul class="dropdown-menu megamenu-content" role="menu">
              <li>
                <div class="row">
                  <div class="col-menu col-md-3">
                    <h6 class="title">Courses</h6>
                    <div class="content">
                      <ul class="menu-col">
                        <li><a href="course-details.html">Basic Life Support</a></li>
                        <li><a href="#">Gallery Three Colum</a></li>
                        <li><a href="#">Gallery Four Colum</a></li>
                        <li><a href="#">Gallery Six Colum</a></li>
                      </ul>
                    </div>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-menu col-md-3">
                    <h6 class="title">Advisor</h6>
                    <div class="content">
                      <ul class="menu-col">
                        <li><a href="#">Advisor Carousel</a></li>
                        <li><a href="#">Advisor Two Colum</a></li>
                        <li><a href="#">Advisor Three Colum</a></li>
                        <li><a href="#">Advisor Carousel Two</a></li>
                      </ul>
                    </div>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-menu col-md-3">
                    <h6 class="title">User Pages</h6>
                    <div class="content">
                      <ul class="menu-col">
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Edit Profile</a></li>
                        <li><a href="#">login</a></li>
                        <li><a href="#">register</a></li>
                      </ul>
                    </div>
                  </div>
                  <!-- end col-3 -->
                  <div class="col-menu col-md-3">
                    <h6 class="title">Other Pages</h6>
                    <div class="content">
                      <ul class="menu-col">
                        <li><a href="<?=base_url()?>about">About Us</a></li>
                        <li><a href="<?=base_url()?>faq">Faq</a></li>
                        <li><a href="<?=base_url()?>about">Pricing Table</a></li>
                        <li><a href="<?=base_url()?>contact">Contact</a></li>
                        <li><a href="<?=base_url()?>about">Error Page</a></li>
                      </ul>
                    </div>
                  </div>
                  <!-- end col-3 -->
                </div>
                <!-- end row -->
              </li>
            </ul>
          </li>
          <li><a href="<?=base_url()?>contact"  style="font-size:18px;">contact Us</a></li>
          <?php if(empty($this->session->userdata('logged_in_user_data'))) { ?>
          <li><a href="<?=base_url()?>login"  style="font-size:18px;" class="popup-with-form1"><i class="fas fa-user"></i> Login</a></li>
          <li><a href="<?=base_url()?>register"  style="font-size:18px;" class="popup-with-form1"><i class="fas fa-edit"></i> Register</a></li>
          <?php } else { ?>
            <li class="dropdown"> 
              <a href="#" class="dropdown-toggle active" data-toggle="dropdown" style="font-size:18px;" ><i class="fas fa-user"></i> </a>
              <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>user/profile">User Profile</a></li>
                  <li><a href="<?=base_url()?>user/payment">Payment History</a></li>
                  <li><a href="<?=base_url()?>user/exam">Online Exam</a></li>
                  <li><a href="<?=base_url()?>user/studymaterial">Study Material</a></li>
                  <li><a href="<?=base_url()?>user/certificate">Dwonlaod Certificate</a></li>
              </ul>                        
            <li>  
          <li><a href="<?=base_url()?>user/dashboard"  style="font-size:18px;" class="popup-with-form1">Dashboard</a></li>
          <?php } ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    </div>
    </nav>
  <!-- End Navigation -->
</header>