<div class="login-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="<?=current_url()?>" method="post" id="login-form" class="white-popup-block">
                    
                    <div class="col-md-8 login-custom">
                        <h4>Verfiy Otp</h4>

                        <?php if($flash_message != '' && $flash_type != '') { ?>
                            <div class="alert alert-<?=$flash_type?> alert-dismissible">
                            <?=$flash_message?>
                            </div>
                        <?php } ?>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="otp" value="<?=set_value('otp')?>" placeholder="Enter OTP" type="text">
                                    <?=form_error('otp')?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="row">
                                <button type="submit" name="submit" value="submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>