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
        <a class="navbar-brand" href="<?=base_url()?>">
        <?php if ($logo_display) { ?>
        <img src="<?=base_url()?>assets/frontend/img/logo1.png" class="logo logo-display" alt="Logo">
        <?php } ?>
        <img src="<?=base_url()?>assets/frontend/img/logo2.png" class="logo logo-scrolled" alt="Logo">                    </a>                
      </div>
      <!-- End Header Navigation -->
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-menu" >
        <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#" style="margin-top:30px;">
          <?php if ($this->uri->segment('1') !== "user") { ?>
          <li>
            <a href="<?=base_url()?>" class="dropdown-toggle active" data-toggle="dropdown" style="font-size:18px;" >Home</a>                        
          </li>
          <?php if(isset($this->navbar) && $this->navbar !== '') { ?>

          <li class="dropdown megamenu-fw">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size:18px;" >Online Courses</a>
            <ul class="dropdown-menu megamenu-content" role="menu">
              <li>
                <div class="row">
                  <?=$this->navbar?>
                </div>
                <!-- end row -->
              </li>
            </ul>
          </li>
          <?php } ?>
          <li><a href="<?=base_url()?>contact"  style="font-size:18px;">contact Us</a></li>
          <?php } ?>
          <?php if(empty($this->session->userdata('logged_in_user_data'))) { ?>
          <li><a href="<?=base_url()?>login"  style="font-size:18px;" class="popup-with-form1"><i class="fas fa-user"></i> Login</a></li>
          <li><a href="<?=base_url()?>register"  style="font-size:18px;" class="popup-with-form1"><i class="fas fa-edit"></i> Register</a></li>
          <?php } else { ?>
            <li class="dropdown"> 
              <a href="#" class="dropdown-toggle active" data-toggle="dropdown" style="font-size:18px;" ><i class="fas fa-user"></i> </a>
              <ul class="dropdown-menu">
                  <li><a href="<?=base_url()?>user/profile">User Profile</a></li>
                  <li><a href="<?=base_url()?>user/payment">Payment History</a></li>
                  <li><a href="<?=base_url()?>user/exams">Online Exam</a></li>
                  <li><a href="<?=base_url()?>user/exams/history">Exam History</a></li>
                  <li><a href="<?=base_url()?>user/studymaterial">Study Material</a></li>
                  <li><a href="<?=base_url()?>user/certificate">Dwonlaod Certificate</a></li>
                  <li><a href="<?=base_url()?>user/logout">Logout</a></li>
              </ul>                        
            <li>  
          <li><a href="<?=base_url()?>user/dashboard"  style="font-size:18px;" class="popup-with-form1">Dashboard</a></li>
          <?php } ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
  </nav>
  <!-- End Navigation -->
</header>