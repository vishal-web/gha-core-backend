<div class="login-area default-padding" style="background-image: url(<?=base_url()?>assets/frontend/img/banner/registration.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form action="<?=current_url()?>" method="post" id="register-form" class="white-popup-block" style="background: url(<?=base_url()?>assets/frontend/img/banner/bg.png);">
                    <div class="col-md-4 login-social">
                        <h4>Register with social</h4>
                        <ul>
                            <li class="facebook">
                                <a href="#">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="g-plus" >
                                <a href="#">
                                    <i class="fab fa-google"></i>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="col-md-8 login-custom">
                        <h4>Register a new account</h4>
                        <?php if($flash_message != '' && $flash_type != '') { ?>
                            <div class="alert alert-<?=$flash_type?> alert-dismissible">
                            <?=$flash_message?>
                            </div>
                        <?php } ?>
                          
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="firstname" value="<?=set_value('firstname')?>" placeholder="First Name*" style="color:#000000;" type="First Name">
                                    <?=form_error('firstname')?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="lastname" value="<?=set_value('lastname')?>" placeholder="Last Name*" type="text">
                                    <?=form_error('lastname')?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">

                                    <?php
                                        $addional_options = [
                                            'class' => 'form-control',
                                            'style' => 'height:50px;',
                                        ];

                                        echo form_dropdown('profession', $profession_dropdown, set_value('profession'), $addional_options);
                                        echo form_error('profession');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="email" placeholder="Email ID*" value="<?=set_value('email')?>" type="text">
                                    <?=form_error('email')?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="password" placeholder="Password*" value="<?=set_value('password')?>" type="password">
                                    <?=form_error('password')?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="phone" value="<?=set_value('phone')?>" placeholder="Phone" type="text">
                                    <?=form_error('phone')?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <?php
                                        $country_default = set_value('country') == '' ? (isset($country) ? $country : '') : set_value('country');
                                        $country_options= ['class' => 'form-control', 'id' => 'country', 'style' => 'height:50px;'];
                                        echo form_dropdown('country', $country_dropdown, $country_default, $country_options);
                                        echo form_error('country');
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <?php
                                        $state_default = set_value('state') == '' ? (isset($state) ? $state : '') : set_value('state');
                                        $state_options= ['class' => 'form-control', 'id' => 'state', 'style' => 'height:50px;',];
                                        echo form_dropdown('state', $state_dropdown, $state_default, $state_options);
                                        echo form_error('state');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                <?php 
                                    $city_default = set_value('city') == '' ? (isset($city) ? $city : '') : set_value('city');
                                    $city_options= ['class' => 'form-control', 'id' => 'city', 'style' => 'height:50px;'];
                                    echo form_dropdown('city', $city_dropdown, $city_default, $city_options);
                                    echo form_error('city');
                                ?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Message Box"><?=set_value('comment')?></textarea>
                                    <?=form_error('comment')?>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="col-md-12">
                            <div class="row">
                                <button type="submit" value="submit" name='submit'>Sign up</button>
                            </div>
                        </div>
                        <p class="link-bottom">Are you a member? <a href="login">Login now</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>