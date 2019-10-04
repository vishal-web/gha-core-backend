<div class="login-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="<?=current_url()?>" method="post" id="login-form" class="white-popup-block">
                    
                    <div class="col-md-8 login-custom">
                        <h4>Lost Your Password ?</h4>

                        <?php if($flash_message != '' && $flash_type != '') { ?>
                            <div class="alert alert-<?=$flash_type?> alert-dismissible">
                            <?=$flash_message?>
                            </div>
                        <?php } ?>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" name="email" value="<?=set_value('email')?>" placeholder="Email ID" type="email">
                                    <?=form_error('email')?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-12">
                            <div class="row">
                                <button type="submit" name="submit" value="submit">
                                    RESET PASSWORD
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>