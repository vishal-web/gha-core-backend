<div class="row"> 


  <div class="col-md-12">
  	<?php if($flash_message != '' && $flash_type != '') { ?>
		<div class="alert alert-<?=$flash_type?> alert-dismissible">
	   	<?=$flash_message?>
	  </div>
		<?php } ?>  
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$title?></h3>
      </div> 
      <form action="<?=$form_location?>" class='form-horizontal' method="post">
        <div class="box-body">

        	<div class="row"> 
        		<div class="form-group">
        			<label for="" class="col-md-2 control-label">Name</label>
        		  <div class="col-md-6">
        			  <?php
        			  	$name_value = set_value('name') == '' ? (isset($name) ? $name : '') : set_value('name');
        			  ?>
        			  <input type="text" class="form-control" disabled name="name" value="<?=$name_value?>" placeholder="Enter name">
        			  <?=form_error('name')?>
        			</div>
        		</div>
        	</div>
          
        	<div class="row"> 
        		<div class="form-group">
        			<label for="" class="col-md-2 control-label">Email Address</label>
        		  <div class="col-md-6">
        			  <?php
        			  	$email_value = set_value('email') == '' ? (isset($email) ? $email : '') : set_value('email');
        			  ?>
        			  <input type="email" class="form-control" disabled name="email" value="<?=$email_value?>" placeholder="Enter email">
        			  <?=form_error('email')?>
        			</div>
        		</div> 
        	</div> 

          <div class="row"> 
            <div class="form-group">
              <label for="" class="col-md-2 control-label">Status</label>
              <?php
                $status_value = set_value('status') == '' ? (isset($status) ? $status : '') : set_value('status');
              ?>
              <div class="col-md-6">

                <?php

                  $dd_options = [
                    '' => 'Choose Status',
                    1 => 'Active',
                    0 => 'Inactive',
                  ];

                  $additional_options = [
                    'class' => 'form-control',
                  ];
                  
                  echo form_dropdown('status', $dd_options, $status_value,$additional_options);

                  echo form_error('status');
                ?>
              </div>
            </div>
          </div>

          <div class="row"> 
        		<div class="form-group">
        			<label for="" class="col-md-2 control-label">Review</label>
        		  <div class="col-md-6">
        			  <?php
        			  	$review_value = set_value('review') == '' ? (isset($review) ? $review : '') : set_value('review');
        			  ?>
        			  <textarea type="text" class="form-control" rows='6' name="review"  placeholder="Enter review"><?=$review_value?></textarea>
                
        			  <?=form_error('review')?>
        			</div>
        		</div> 
        	</div> 

        

        </div>  
        <div class="box-footer m-t-40">
          <div class="col-md-offset-2 col-sm-10">
            <div class="row form-group"> 
              <button type="submit" name='submit' value='submit' class="btn btn-primary">Submit</button>
              <button type="submit" name='submit' value='cancel' class="btn btn-warning">Cancel</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>