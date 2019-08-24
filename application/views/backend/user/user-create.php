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
      <form action="<?=$form_location?>" method="post">
        <div class="box-body">

        	<div class="row"> 
        		<div class="col-md-6">
        			<div class="form-group">
        			  <label for="">Firstname</label>
        			  <?php
        			  	$firstname_value = set_value('firstname') == '' ? (isset($firstname) ? $firstname : '') : set_value('firstname');
        			  ?>
        			  <input type="text" class="form-control" name="firstname" value="<?=$firstname_value?>" placeholder="Enter firstname">
        			  <?=form_error('firstname')?>
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        			  <label for="">Lastname</label>
        			  <?php
        			  	$lastname_value = set_value('lastname') == '' ? (isset($lastname) ? $lastname : '') : set_value('lastname');
        			  ?>
        			  <input type="text" class="form-control" name="lastname" value="<?=$lastname_value?>" placeholder="Enter lastname">
        			  <?=form_error('lastname')?>
        			</div>
        		</div>
        	</div>

        	<div class="row"> 
        		<div class="col-md-4">
        			<div class="form-group">
        			  <label for="">Email Address</label>
        			  <?php
        			  	$email_value = set_value('email') == '' ? (isset($email) ? $email : '') : set_value('email');
        			  ?>
        			  <input type="email" class="form-control" name="email" value="<?=$email_value?>" placeholder="Enter email">
        			  <?=form_error('email')?>
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        			  <label for="">Phone</label>
        			  <?php
        			  	$phone_value = set_value('phone') == '' ? (isset($phone) ? $phone : '') : set_value('phone');
        			  ?>
        			  <input type="text" class="form-control" name="phone" value="<?=$phone_value?>" placeholder="Enter phone">
        			  <?=form_error('phone')?>
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        			  <label for="">Profession</label>

        			  <?php
        			  	$profession_default = set_value('profession') == '' ? (isset($profession) ? $profession : '') : set_value('profession');
 
        			  	$profession_options= ['class' => 'form-control', 'id' => 'profession'];
        			  	echo form_dropdown('profession', $profession_dropdown, $profession_default, $profession_options);
        			  	echo form_error('profession');
        			  ?>
        			</div>
        		</div>
        	</div>

        	<div class="row"> 
        		<div class="col-md-4">
        			<div class="form-group">
        			  <label for="">Country</label>

        			  <?php 
        			  	$country_default = set_value('country') == '' ? (isset($country) ? $country : '') : set_value('country');
        			  	$country_options= ['class' => 'form-control', 'id' => 'country'];
        			  	echo form_dropdown('country', $country_dropdown, $country_default, $country_options);
        			  	echo form_error('country');
        			  ?>
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        			  <label for="">State</label>
        			  <?php 
        			  	$state_default = set_value('state') == '' ? (isset($state) ? $state : '') : set_value('state');
        			  	$state_options= ['class' => 'form-control', 'id' => 'state'];
        			  	echo form_dropdown('state', $state_dropdown, $state_default, $state_options);
        			  	echo form_error('state');
        			  ?>
        			</div>
        		</div>
        		<div class="col-md-4">
        			<div class="form-group">
        			  <label for="">City</label>
        			  <?php 
        			  	$city_default = set_value('city') == '' ? (isset($city) ? $city : '') : set_value('city');
        			  	$city_options= ['class' => 'form-control', 'id' => 'city'];
        			  	echo form_dropdown('city', $city_dropdown, $city_default, $city_options);
        			  	echo form_error('city');
        			  ?>
        			</div>
        		</div>
        	</div>

        <!-- 	<div class="row"> 
        		<div class="col-md-12">
        			<label>Message</label>
        			<textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
        		</div>
        	</div> -->
        </div>  
        <div class="box-footer">
          <button type="submit" name='submit' value='submit' class="btn btn-primary">Submit</button>
          <button type="submit" name='submit' value='cancel' class="btn btn-warning">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>