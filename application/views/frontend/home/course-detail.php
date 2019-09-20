<?php
	$banner_image = base_url('uploads/course/').$course_details['featured_image'];
	$redirect_url = '';
	if (!empty($this->logged_in_user_data)) {
		$redirect_url = base_url().'course/enroll/'.$this->uri->segment(2);
	} else {
		$redirect_url = base_url().'login';
	}
?>

<div class="breadcrumb-area shadow dark text-center bg-fixed text-light" style="background-image: url(<?=$banner_image?>);">
  <div class="container">
		<div class="row">
		  <div class="col-md-12">
		    <h1><?=$course_details['title']?></h1>  
		  </div>
		</div>
  </div>
</div>

<div class="course-details-area default-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="course-details-info">
					<!-- Star Top Info -->
					<div class="top-info">
						<!-- Title-->
						<div class="title">
							<h2><?=$course_details['title']?></h2>
						</div>
						<!-- End Title-->

					   

						<!-- Course Meta -->
						<div class="course-meta"> 
							
							<div class="item price">
								<h4 style="font-size:25px;">Price : INR <?=$course_details['price']?></h4>
								
							</div>
							<div class="align-right">
								<a class="btn btn-dark effect btn-sm" href="<?=$redirect_url?>" style="width:250px; font-size:17px;">
									<i class="fas fa-chart-bar"></i> Enroll
								</a>
							</div>
						</div>
						<!-- End Course Meta -->
					</div>
					<!-- End Top Info -->

					<!-- Star Tab Info -->
					<div class="tab-info">
					   
						<!-- End Tab Nav -->
						<!-- Start Tab Content -->
						<div class="tab-content tab-content-info">
							<!-- Single Tab -->
							<div id="tab1" class="tab-pane fade active in">
								<div class="info title">
									<h4>Course Desscription</h4>
									<?=$course_details['description']?>
								</div>
							</div>
							<!-- End Single Tab -->

						   
						</div>
						<!-- End Tab Content -->
					</div>
					<!-- End Tab Info -->
				</div>
			</div>
			<?php /*?>
			<!-- Start Sidebar -->
			<div class="col-md-4">
				<div class="sidebar">
					<aside>
						<!-- Sidebar Item -->
						<div class="sidebar-item search">
							<div class="sidebar-info">
								<form>
									<input type="text" placeholder="Course name" class="form-control">
									<input type="submit" value="search">
								</form>
							</div>
						</div>
						<!-- End Sidebar Item --> 
						

						<!-- Sidebar Item -->
						<div class="sidebar-item recent-post">
							<div class="title">
								<h4>Popular Courses</h4>
							</div>
							
							<div class="item">
								<div class="content">
									<div class="thumb">
										<a href="#">
											<img src="assets/img/courses/g1.jpg" alt="Thumb">
										</a>
									</div>
									<div class="info">
										<h4>
											<a href="#">Profession paython learing</a>
										</h4>
										<div class="rating">
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star-half-alt"></i>
											<span>4.5 (23,890)</span>
										</div>
										<div class="meta">
											<i class="fas fa-user"></i> By <a href="#">Drup Paul</a> 
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="content">
									<div class="thumb">
										<a href="#">
											<img src="assets/img/courses/g2.jpg" alt="Thumb">
										</a>
									</div>
									<div class="info">
										<h4>
											<a href="#">Profession paython learing</a>
										</h4>
										<div class="rating">
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star-half-alt"></i>
											<span>4.5 (23,890)</span>
										</div>
										<div class="meta">
											<i class="fas fa-user"></i> By <a href="#">Drup Paul</a> 
										</div>
									</div>
								</div>
							</div>
							
							
							
							
							<div class="item">
								<div class="content">
									<div class="thumb">
										<a href="#">
											<img src="assets/img/courses/g2.jpg" alt="Thumb">
										</a>
									</div>
									<div class="info">
										<h4>
											<a href="#">Profession paython learing</a>
										</h4>
										<div class="rating">
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star-half-alt"></i>
											<span>4.5 (23,890)</span>
										</div>
										<div class="meta">
											<i class="fas fa-user"></i> By <a href="#">Drup Paul</a> 
										</div>
									</div>
								</div>
							</div>
							
							<div class="item">
								<div class="content">
									<div class="thumb">
										<a href="#">
											<img src="assets/img/courses/g3.jpg" alt="Thumb">
										</a>
									</div>
									<div class="info">
										<h4>
											<a href="#">Profession paython learing</a>
										</h4>
										<div class="rating">
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star-half-alt"></i>
											<span>4.5 (23,890)</span>
										</div>
										<div class="meta">
											<i class="fas fa-user"></i> By <a href="#">Drup Paul</a> 
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Sidebar Item -->

					</aside>
				</div>
			</div>
			<?php */?>
			<!-- End Sidebar -->
		</div>
	</div>
</div>