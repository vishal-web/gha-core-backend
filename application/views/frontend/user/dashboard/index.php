<?php

    function getUserAddress($data) {
        $address = '';
        if ($data[0]['city_name'] !== null) {
            $address .= $data[0]['city_name'].', ';
        }

        if ($data[0]['state_name'] !== null) {
            $address .= $data[0]['state_name'].', ';
        }

        if ($data[0]['country_name'] !== null) {
            $address .= $data[0]['country_name'];
        }

        return $address;
    }

    $profile_picture = '';
    if ($user_data[0]['oauth_provider'] !== '') {
        $profile_picture = $user_data[0]['profile_picture'];
    }

    $profile_picture = '';
    if (strpos($user_data[0]['profile_picture'], '.com') !== false) {
        $profile_picture = $user_data[0]['profile_picture'];
    } else if ($user_data[0]['profile_picture']) {
        $profile_picture = base_url().'uploads/profile/'.$user_data[0]['profile_picture'];
    }
?>

<div class="course-details-area default-padding">
    <div class="container">
        <div class="row">
            <?php $this->load->view('frontend/user/inc/sidebar'); ?>
            <?php /* ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box">
                    <a class="small-box-footer bg-aqua" href="#">
                        <div class="icon  bg-aqua" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa fa-book" aria-hidden="true"></i>
                        </div>
                        <div class="inner ">
                            <h4 class="text-white">
                            Course                    </h4 class="text-white">
                            <p class="text-white">
                                Basic Life Support                    
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-blue" href="#">
                        <div class="icon bg-blue" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <div class="inner ">
                            <h4 class="text-white">
                            Exam 1                   </h4 class="text-white">
                            <p class="text-white">
                                25-09-2019                  
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-green" href="#">
                        <div class="icon bg-green" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <div class="inner ">
                            <h4 class="text-white">
                            Exam 2                    </h4 class="text-white">
                            <p class="text-white">
                                2-09-2019                   
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box ">
                    <a class="small-box-footer bg-black" href="#">
                        <div class="icon  bg-black" style="padding: 9.5px 18px 8px 18px;">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                        <div class="inner ">
                            <h4 class="text-white">
                            Result                    </h4 class="text-white">
                            <p class="text-white">
                                Pass                   
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <section class="panel">
                    <div class="profile-db-head  bg-yellow-gradient">
                        <a href="javascript:void();">
                        <img src="<?=$profile_picture?>" alt="profile" /></a>
                        <h1 style="color:#FFFFFF;"><?=$user_data[0]['firstname']?></h1>
                        <p style="color:#FFFFFF;"><?=$user_data[0]['profession_name']?></p>
                    </div>
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fa fa-user text-black"></i>
                                </td>
                                <td>Username</td>
                                <td><?=$user_data[0]['firstname'] .' '.$user_data[0]['lastname']?></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-envelope text-black"></i>
                                </td>
                                <td>Email</td>
                                <td><?=$user_data[0]['email']?></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-phone text-black"></i>
                                </td>
                                <td>Phone</td>
                                <td><?=$user_data[0]['phone']?></td>
                            </tr>
                            <tr>
                                <td>
                                    <i class=" fa fa-globe text-black"></i>
                                </td>
                                <td>Address</td>
                                <td><?=getUserAddress($user_data)?></td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div>
            <div class="col-sm-8">
                <div class="box">
                    <div class="box-body" style="padding: 0px;height: 320px">
                        <div class="box">
                            <div class="box-header" style="background-color: #fff;">
                                <h3 class="box-title text-black" style="font-size:25px;">
                                    ABOUT ME         
                                </h3>
                            </div>
                            <div class="box-body" style="padding: 0px;">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                            <?php if($user_data[0]['about'] !== '') { 
                                                echo $user_data[0]['about']; } else {
                                            ?>
                                            So, practice yourself by reading sample myself essays, write yourself in few words like 200,500,1000 words about yourself. In this way, you will be able to express fully about your personality, your interests and your future goals. <?php } ?></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php */ ?>

            <div class='col-md-9 p-t-60 custom-table'>
                <div class='table-responsive'>
                <table class='table table-bordered table-condensed'>
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Exam</th> 
                            <th>Course</th>  
                            <th>Attempt Left</th>  
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($query)) {
                        $counter = 0;
                        foreach ($query as $row) {
                            $take_exam = false;
                            if ($row['payment_date'] && $row['course_duration']) {
                                $expiry_date = Date('Y-m-d', strtotime('+ '.$row['course_duration'].' months', strtotime($row['payment_date'])));
                                if ($expiry_date >= Date('Y-m-d')) {
                                    $take_exam = true;
                                }
                            }
                        ?>
                        <tr>
                            <td><?=++$counter?></td>
                            <td><?=$row['title']?></td> 
                            <td><?=$row['course_title']?></td>  
                            <td><?=$row['attempt_left']?></td>  
                            <td> 
                                <a href='<?=base_url('user/exams/history/'.$row['order_product_id'])?>'>
                                    <button type="button" class="btn btn-danger ">View Details</button>
                                </a> 
                            </td>
                        </tr>
                        <?php } } else { ?> 
                        <tr>
                            <td colspan='8'>Unfortunately no exam is available for you</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 