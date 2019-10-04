<div class="login-area default-padding"  style="background:#CCCCCC;">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 ">
                <form action="<?=current_url()?>" method="post" id="login-form" class="white-popup-block" style="background:url(<?=base_url()?>assets/frontend/img/banner/bg.png);">
                    <h4>login to your registered account!</h4>
                    <?php if($flash_message != '' && $flash_type != '') { ?>
                        <div class="alert alert-<?=$flash_type?> alert-dismissible">
                        <?=$flash_message?>
                        </div>
                    <?php } ?>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <input class="form-control" name="email" placeholder="Email" type="email">
                                <?=form_error('email')?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <input class="form-control" name="password" placeholder="Password*" type="password">
                                <?=form_error('password')?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <label for="login-remember"><input type="checkbox" name="login-remember" id="login-remember">Remember Me</label>
                            <a title="Lost Password" href="forgotpassword" class="lost-pass-link">Lost your password?</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <button name="submit" value="submit" type="submit">
                                Login
                            </button>
                        </div>
                    </div>
                    <p class="link-bottom">Not a member yet? <a href="register">Register now</a></p>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>