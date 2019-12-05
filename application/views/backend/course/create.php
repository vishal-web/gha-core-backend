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
      <form action="<?=$form_location?>" method="post" class='form-horizontal' enctype="multipart/form-data">
        <div class="box-body">
        
          <div class="form-group">
            <label for="" class="col-md-2 control-label">Title</label>
            <div class="col-md-8">
              <?php $title_value = set_value('title') == '' ? (isset($title) ? $title : '') : set_value('title'); ?>
              <input type="text" class="form-control" name="title" value="<?=$title_value?>" placeholder="Enter title">
              <?=form_error('title')?>
            </div>
          </div>
 
          <div class="form-group">
            <label for="" class="col-md-2 control-label">Price</label>
            <div class="col-md-8">
              <?php
                $price_value = set_value('price') == '' ? (isset($price) ? $price : '') : set_value('price');
              ?>
              <input type="text" class="form-control" name="price" value="<?=$price_value?>" placeholder="Enter price">
              <?=form_error('price')?>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Featured Image</label>
            <div class="col-md-8">
              <?php
                $featured_image_value = set_value('featured_image') == '' ? (isset($featured_image) ? $featured_image : '') : set_value('featured_image');
              ?>
              <input type="file" class="form-control" name="featured_image">
              <?= isset($featured_image_error) ? $featured_image_error : '' ?> 
            </div>
          </div>


          <div class="form-group">
            <label for="" class="col-md-2 control-label">Duration</label>
            <div class="col-md-4">
              <?php
                $duration_value = set_value('duration') == '' ? (isset($duration) ? $duration : '') : set_value('duration');
                $duration_options[''] = 'Select Course Duration';
                for($i = 1; $i <= 12; $i++) {
                  $duration_options[$i] = $i.' Month';
                }
                $additional_option = ['class' => 'form-control'];

                echo form_dropdown('duration', $duration_options, $duration_value, $additional_option);
                echo form_error('duration');
              ?>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Status</label>
            <div class="col-md-4">
              <?php
                $status_value = set_value('status') == '' ? (isset($status) ? $status : '') : set_value('status');
                $status_options[''] = 'Select status';
                $status_options[1] = 'Active';
                $status_options[0] = 'Inactive';
                
                echo form_dropdown('status', $status_options, $status_value, $additional_option);
                echo form_error('status');
              ?>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Related Courses</label>
            <div class="col-md-8">
              <?php
                $related_courses_value = set_value('related_courses') == '' ? (isset($related_courses) ? $related_courses : 0) : set_value('related_courses');
                $additional_option = ['class' => 'form-control select2','data-placeholder' => "Select Related Course"];
                echo form_multiselect('related_courses[]', $related_courses_options, $related_courses_value, $additional_option);
                echo form_error('related_courses');
              ?>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Description</label>
            <div class="col-md-8">
              <?php
                $description_value = set_value('description') == '' ? (isset($description) ? $description : '') : set_value('description');
              ?>
              <textarea class="form-control" id="editor1" name="description" rows="6" placeholder="Enter description"><?=$description_value?></textarea>
              <?=form_error('description')?>
            </div>
          </div> 

          <div class="form-group">
            <label for="" class="col-md-2 control-label"></label>
            <div class="col-md-8">
              <?php
                $upcoming_course_value = isset($upcoming_course) && $upcoming_course == 1 ? 'checked' : '';
              ?>
               
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="upcoming_course" value="1" <?=$upcoming_course_value?>> Upcoming Course
                </label>
              </div>
              

              <?=form_error('upcoming_course')?>
            </div>
          </div> 
        </div>  
        <div class="box-footer">
          <div class='col-md-offset-2'>
            <button type="submit" name='submit' value='submit' class="btn btn-primary">Submit</button>
            <button type="submit" name='submit' value='cancel' class="btn btn-warning">Cancel</button>
          </div>
        </div>
      </form>
    </div>

    <?php if($update_id > 0) {?>
    <div class="box box-primaryox">
      <div class="box-header">
        <h3 class="box-title">Featured Image</h3>
      </div>
      <div class="box-body">
        <?php if($featured_image !== '') {
          $full_path_image = base_url().'uploads/course/'.$featured_image;  
        ?>
        <div class="row">
          <div class="col-md-12">
            <img src='<?=$full_path_image?>' class='img-responsive'>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>

  </div>
</div>