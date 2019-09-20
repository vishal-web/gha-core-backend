<?php
    $profile_picture = '';
    if (strpos($profile['profile_picture'], '.com') !== false) {
        $profile_picture = $profile['profile_picture'];
    } else if ($profile['profile_picture']) {
        $profile_picture = base_url().'uploads/profile/'.$profile['profile_picture'];
    }
?>
<div class="edit-profile adviros-details-area default-padding  bg-gray form-custom-control">
    <div class="container bg-light default-padding">
        <div class="row">
            <?php if(isset($message) && $message !== '') { ?>
            <div class="col-md-12">
                <p class="text-danger">*<?=$message?></p>
            </div>
            <?php } ?>

            <?php if(trim($flash_message) !== '') { ?>
          
            <div class="alert alert-<?=$flash_type?>">
                <p class="text-<?=$flash_type?>">*<?=$flash_message?></p>
            </div>
            <?php } ?>



        	<div class="col-md-3 about-user">
                <img src="<?=$profile_picture?>" alt="Thumb">
            </div>
            <div class="col-md-5 update-info">
                <h4>Update Current Info</h4>
                <div class="row">
                    <form action="<?=current_url()?>" method="post" enctype="multipart/form-data" class="">
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label class='' for=''>Firstname</label>
                                <?php
                                    $firstname_default = set_value('firstname') == '' ? ($profile['firstname'] !== '' ? $profile['firstname'] : '') : set_value('firstname');
                                ?>
                                <input type="text" name="firstname" value="<?=$firstname_default?>" class="form-control custom"/>
                                <?=form_error('firstname')?>
                            </div>
                        </div> 
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class='' for=''>Lastname</label>
                                <?php
                                    $lastname_default = set_value('lastname') == '' ? ($profile['lastname'] !== '' ? $profile['lastname'] : '') : set_value('lastname');
                                ?>
                               <input type="text" name="lastname" value="<?=$lastname_default?>" class="form-control custom"/>
                               <?=form_error('lastname')?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class='' for=''>Email</label> 
                                <div class="form-control custom"><?=$profile['email']?></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class='' for=''>Phone</label>
                                <?php

                                    $phone_value = set_value('phone') !== '' ? set_value('phone') : $profile['phone'];
                                ?>

                                <input class="form-control" name="phone" value="<?=$phone_value?>" placeholder="Phone" type="text">
                                <?=form_error('phone')?>
                                <span class="text-warning"><small>If you are not from India (+91), please add your country code.</small></span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label class="">Professional</label>
                                <?php
                                    $addional_options = [
                                        'class' => 'form-control',
                                        'style' => 'height:50px;',
                                    ];

                                    $profession_default = set_value('profession') == '' ? ($profile['profession'] > 0 ? $profile['profession'] : '') : set_value('profession');
                                    echo form_dropdown('profession', $profession_dropdown, $profession_default, $addional_options);
                                    echo form_error('profession');
                                ?>
                            </div> 
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label class="">Country</label>
                                <?php
                                    $country_default = set_value('country') == '' ? ($profile['country'] > 0 ? $profile['country'] : '') : set_value('country');
                                    $country_options= ['class' => 'form-control', 'id' => 'country', 'style' => 'height:50px;'];
                                    echo form_dropdown('country', $country_dropdown, $country_default, $country_options);
                                    echo form_error('country');
                                ?>
                            </div> 
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group">
                                <label class="">State</label>
                                <?php
                                    $state_default = set_value('state') == '' ? ($profile['state'] > 0 ? $profile['state'] : '') : set_value('state');
                                    $state_options= ['class' => 'form-control', 'id' => 'state', 'style' => 'height:50px;',];
                                    echo form_dropdown('state', $state_dropdown, $state_default, $state_options);
                                    echo form_error('state');
                                ?>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            
                            <div class="form-group">
                            <label class="">City</label>
                            <?php 
                                $city_default = set_value('city') == '' ? ($profile['city'] > 0 ? $profile['city'] : '') : set_value('city');
                                $city_options= ['class' => 'form-control', 'id' => 'city', 'style' => 'height:50px;'];
                                echo form_dropdown('city', $city_dropdown, $city_default, $city_options);
                                echo form_error('city');
                            ?>
                            </div> 
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group comments">
                            <label>Upload Profile Pic</label>
                                <input class="form-control" type="file" name="userprofile" accept="image/*"> 
                                <?=isset($image_error) ? $image_error : ''?>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="form-group comments">
                                <?php
                                    $about_default = set_value('about') == '' ? ($profile['about'] !== '' ? $profile['about'] : '') : set_value('about');
                                ?>
                                <textarea class="form-control" name="about" placeholder="About Yourself"><?=$about_default?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" name="submit" value="update" style="background:#FF0000; color:#FFFFFF;">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 update-pass">
                <h4>Change Password</h4>
                <div class="row">
                    <form action="<?=current_url()?>" method="post">
                        <?php if($profile['password'] !== ''){ ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Old password</label>
                                <input class="form-control" name="oldpass" value="<?=set_value('oldpass')?>" placeholder="Old Password" type="password">
                                <?=isset($password_match_err_message) ? $password_match_err_message : ''?>
                                <?=str_replace(array('The', 'field'),'',form_error('oldpass'))?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="pass" value="<?=set_value('pass')?>" placeholder="Choose Password" type="password">
                                <?=str_replace(array('The', 'field'),'',form_error('pass'))?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirm password</label>
                                <input class="form-control" name="confpass" value="<?=set_value('confpass')?>" placeholder="Retype Password" type="password">
                                <?=str_replace(array('The', 'field'),'',form_error('confpass'))?>
                            </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" name="submit" value="changepass" style="background:#FF0000; color:#FFFFFF;">
                                Update
                            </button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>