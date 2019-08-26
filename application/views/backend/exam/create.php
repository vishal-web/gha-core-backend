<div class="row"> 
  <div class="col-md-12">
  	<?php if($flash_message != '' && $flash_type != '') { ?>
		<div class="alert alert-<?=$flash_type?> alert-dismissible">
	   	<?=$flash_message?>
	  </div>
		<?php } ?>  
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$headline?></h3>
      </div> 
      <form action="<?=$form_location?>" method="post" enctype="multipart/form-data">
        <div class="box-body">

        	<div class="row"> 
        		<div class="col-md-6">
        			<div class="form-group">
        			  <label for="">Title</label>
        			  <?php
        			  	$title_value = set_value('title') == '' ? (isset($title) ? $title : '') : set_value('title');
        			  ?>
        			  <input type="text" class="form-control" name="title" value="<?=$title_value?>" placeholder="Enter title">
        			  <?=form_error('title')?>
        			</div>
        		</div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Featured Image</label>
                <?php
                  $featured_image_value = set_value('featured_image') == '' ? (isset($featured_image) ? $featured_image : '') : set_value('featured_image');
                ?>
                <input type="file" class="form-control" name="featured_image">
                <?= isset($featured_image_error) ? $featured_image_error : '' ?>
              </div>
            </div>
        	</div>
          
        	<div class="row"> 
        		<div class="col-md-6">
        			<div class="form-group">
        			  <label for="">Price</label>
        			  <?php
        			  	$price_value = set_value('price') == '' ? (isset($price) ? $price : '') : set_value('price');
        			  ?>
        			  <input type="text" class="form-control" name="price" value="<?=$price_value?>" placeholder="Enter price">
        			  <?=form_error('price')?>
        			</div>
        		</div>
            
        		<div class="col-md-6">
        			<div class="form-group">
        			  <label for="">Duration</label>
        			  <?php
        			  	$duration_value = set_value('duration') == '' ? (isset($duration) ? $duration : '') : set_value('duration');
        			  ?>
        			  <input type="text" class="form-control" name="duration" value="<?=$duration_value?>" placeholder="Enter duration">
        			  <?=form_error('duration')?>
        			</div>
        		</div>
            
        	</div>
          
          <div class="row"> 
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Description</label>
                <?php
                  $description_value = set_value('description') == '' ? (isset($description) ? $description : '') : set_value('description');
                ?>
                <textarea class="form-control" name="description" rows="10" placeholder="Enter description"><?=$description_value?></textarea>
                <?=form_error('description')?>
              </div>
            </div>
          </div>
        </div>  
        <div class="box-footer">
          <button type="submit" name='submit' value='submit' class="btn btn-primary">Submit</button>
          <button type="submit" name='submit' value='cancel' class="btn btn-warning">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>