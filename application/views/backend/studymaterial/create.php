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
      <form action="<?=$form_location?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="box-body">

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Course</label>
            <div class="col-md-9">
              <?php
                $course_id_value = set_value('course_id') == '' ? (isset($course_id) ? $course_id : '') : set_value('course_id');
                
                $additional_option = ['class' => 'form-control'];

                echo form_dropdown('course_id', $course_dd, $course_id_value, $additional_option);
                echo form_error('course_id');
              ?>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Material Type</label>
              <div class="col-md-9">
              <?php
                $material_type_value = set_value('material_type') == '' ? (isset($type) ? $type : '') : set_value('material_type');
                
                echo form_dropdown('material_type', $material_dd, $material_type_value, $additional_option);
                echo form_error('material_type');
              ?>
            </div>
          </div>  

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Youtube link</label>
              <div class="col-md-9">
              <?php
                $study_material_value = set_value('study_material') == '' && $material_type_value == 'youtube' ? (isset($study_material) ? $study_material : '') : set_value('study_material');
              ?>
              <input type="text" class="form-control" name="study_material" value="<?=$study_material_value?>">
              <?=form_error('study_material')?>
            </div>
          </div>   

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Status</label>
              <div class="col-md-9">
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
            <label for="" class="col-md-2 control-label">File Upload</label>
            <?php
              $featured_image_value = set_value('featured_image') == '' ? (isset($featured_image) ? $featured_image : '') : set_value('featured_image');
            ?>
            <div class="col-md-9">
              <input type="file" class="form-control" name="featured_image">
              <?= isset($featured_image_error) ? $featured_image_error : '' ?>
            </div>
          </div>

        </div>  
        <div class="box-footer">
          <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
              <button type="submit" name='submit' value='submit' class="btn btn-primary">Submit</button>
              <button type="submit" name='submit' value='cancel' class="btn btn-warning">Cancel</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <?php if($update_id > 0) { $full_file_path = base_url().'uploads/studymaterial/';?>
    <div class="box box-primaryox">
      <div class="box-header">
        <h3 class="box-title">File</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
          <?php if($type == 'img') { $full_file_path .= 'img/'.$study_material; ?>
            <img src='<?=$full_file_path?>' class='img-responsive' style='max-width: 300px'>
          <?php } else if($type == 'pdf') { $full_file_path .= 'pdf/'.$study_material;?> 
            <iframe width="100%" height="100%" style='min-height:100vh' src="<?=$full_file_path?>"></iframe>    
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>
</div>