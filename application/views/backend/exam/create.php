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
            <label for="" class="col-md-2 control-label">Exam Title</label>
            <div class="col-md-9">
              <?php
                $title_value = set_value('title') == '' ? (isset($title) ? $title : '') : set_value('title');
                $additional_option = ['class' => 'form-control'];
              ?>
              <input type='text' name='title' value="<?=$title_value?>" class="form-control" />
							<?=form_error('title')?>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Duration</label>
            <div class="col-md-9">
              <div class="row">
                <div class='col-md-4'>
                  <?php
                    $duration_value = set_value('duration') == '' ? (isset($duration) ? $duration : 0) : set_value('duration');
                  ?>
                  <input type='number' class='form-control' name='duration' value='<?=$duration_value?>' min='0' />
                  <?=form_error('duration')?>
                </div>

                <div class='col-md-4'>
                  <?php
                    $duration_type_value = set_value('duration_type') == '' ? (isset($type) ? $type : '') : set_value('duration_type');
                    $duration_dd = ['minute' => 'Minute' , 'hour' => 'Hour'];
                    echo form_dropdown('duration_type', $duration_dd, $duration_type_value, $additional_option);
                    echo form_error('duration_type');
                  ?>
                </div>
              </div>
            </div>
          </div>  

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Each Question Marks</label>
              <div class="col-md-4">
              <?php
                $each_marks_value = set_value('each_marks') == '' ? (isset($each_marks) ? $each_marks : 0) : set_value('each_marks');
              ?>
              <input type="number" class="form-control" name="each_marks" min='0' value="<?=$each_marks_value?>">
              <?=form_error('each_marks')?>
            </div>
          </div>   
          
          <div class="form-group">
            <label for="" class="col-md-2 control-label">Passing <small>(%)</small></label>
              <div class="col-md-4">
              <?php
                $passing_percentage_value = set_value('passing_percentage') == '' ? (isset($passing_percentage) ? $passing_percentage : '10') : set_value('passing_percentage');
              ?>
              <input type="number" class="form-control" name="passing_percentage"  min='10' value="<?=$passing_percentage_value?>">
              <?=form_error('passing_percentage')?>
            </div>
          </div> 

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Course</label>
              <div class="col-md-4">
              <?php
                $course_id_value = set_value('course_id') == '' ? (isset($course_id) ? $course_id : '') : set_value('course_id');
                echo form_dropdown('course_id', $course_dd, $course_id_value, $additional_option);
                echo form_error('course_id');
              ?>
            </div>
          </div>  

          <div class="form-group">
            <label for="" class="col-md-2 control-label">No of question</label>
              <div class="col-md-4">
              <?php
                $total_question_value = set_value('total_question') == '' ? (isset($total_question) ? $total_question : '0') : set_value('total_question');
              ?>
              <input type="number" class="form-control" name="total_question"  min='0' value="<?=$total_question_value?>">
              <?=form_error('total_question')?>
              <?=isset($total_question_error) ? $total_question_error : ''?>
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

  </div>
</div>