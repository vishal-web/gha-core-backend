<?php if (isset($top_bar_nav)) { ?>
<div class="top-bar-area address-two-lines bg-dark text-light">
  <div class="container">
    <div class="row">
      <div class="col-md-8 address-info">
        <div class="info">
          <ul> 
            <li>
              <span><i class="fas fa-envelope-open"></i> Email: Info@gmail.com </span>
            </li>
            <li>
              <span><i class="fas fa-phone"></i> Phone: +123 456 7890</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="user-login text-right col-md-4">
        <?php if(empty($this->session->userdata('logged_in_user_data'))) { ?>
        <a class="" href="<?=base_url()?>login"><i class="fas fa-user"></i> Login</a>
        <a class="" href="<?=base_url()?>register"><i class="fas fa-edit"></i> Register</a>
        <?php } else { $logged_user_name = $this->session->userdata('logged_in_user_data')['user_name'];?>
        <a href="<?=base_url()?>user/dashboard"  class="popup-with-form1">Welcome: <?=$logged_user_name?></a>
        <a href="<?=base_url()?>user/dashboard"  class="popup-with-form1"><i class="fas fa-user"></i> Dashboard</a>
        <?php } ?>
        <a class="" href="#login-form"><i class="fas fa-shopping-cart"></i></a>
      </div>
    </div>
  </div>
</div> 
<?php } ?>
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
        <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
          <li>
            <a href="<?=base_url()?>" class="dropdown-toggle active" data-toggle="dropdown" >Home</a>                        
          </li>
          <?php if(isset($this->navbar) && $this->navbar !== '') { ?>

          <li class="dropdown megamenu-fw">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Courses</a>
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
          <li><a href="<?=base_url()?>contact" >contact Us</a></li>
          <?php if(empty($this->session->userdata('logged_in_user_data'))) { ?>
          <li><a href="<?=base_url()?>login"  class="popup-with-form1"> Log In</a></li>
          <li><a href="<?=base_url()?>register"  class="popup-with-form1"> Register</a></li>
          <?php } else { ?>
            <li><a href="<?=base_url()?>user/dashboard"  class="popup-with-form1"> My Account</a></li>
            <li class="dropdown user-menu"> 
              <a href="#" class="dropdown-toggle active" data-toggle="dropdown" ><i class="fas fa-user"></i> </a>
              <ul class="dropdown-menu">
                <li><a href="<?=base_url()?>user/profile">User Profile</a></li>
                <li><a href="<?=base_url()?>user/payment">Payment History</a></li>
                <li><a href="<?=base_url()?>user/exams">Online Exam</a></li>
                <li><a href="<?=base_url()?>user/exams/history">Exam History</a></li>
                <li><a href="<?=base_url()?>user/studymaterial">Study Material</a></li>
                <li><a href="<?=base_url()?>user/certificate">Download Certificate</a></li>
                <li><a href="<?=base_url()?>user/logout">Logout</a></li>
              </ul>                        
            <li> 
          <?php } ?>
          <li><a class="" href="<?=base_url()?>cart"><i class="fas fa-shopping-cart"></i> <span id='cart_items_count'></span></a></li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
  </nav>
  <!-- End Navigation -->
</header>