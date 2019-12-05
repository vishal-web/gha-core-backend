<div class="row"> 
  <div class="col-md-12">
  	<?php if($flash_message != '' && $flash_type != '') { ?>
		<div class="alert alert-<?=$flash_type?> alert-dismissible">
	   	<?=$flash_message?>
	  </div>
		<?php } ?> 


    <?php if(isset($custom_error) && $custom_error == 1) { ?>
    <div class="alert alert-danger alert-dismissible">
      <?=$custom_error_msg?>
    </div>
    <?php } ?>  

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$headline?></h3>
      </div> 
      <form action="<?=$form_location?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="box-body">
    			<div class="form-group">
    			  <label for="" class="col-md-2 control-label">Question Title</label>
    			  <?php
    			  	$question_title_value = set_value('question_title') == '' ? (isset($question_title) ? $question_title : '') : set_value('question_title');
    			  ?>
            <div class="col-md-9">
              <textarea rows="6" class="form-control col-md-9" name="question_title" id="editor1" placeholder="Enter Question title"><?=$question_title_value?></textarea>
              <?=form_error('question_title')?>
            </div>
    			</div>
          
          
          <div class="form-group">
    			  <label for="" class="col-md-2 control-label">Question Image</label>
            <div class="col-md-9">
              <input type="file" class="form-control" name="image" /> 
              <?=isset($img_upload_error_msg) ? $img_upload_error_msg : null?>
            </div>
    			</div>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Description</label>
            <?php
              $description_value = set_value('description') == '' ? (isset($description) ? $description : '') : set_value('description');
            ?>
            <div class="col-md-9">
              <textarea rows="2" class="form-control col-md-9" name="description"  placeholder="Enter Question description"><?=$description_value?></textarea>
              <?=form_error('description')?>
            </div>
          </div> 
          <?php /* ?>
          <div class="form-group">
            <label for="" class="col-md-2 control-label">Question Type</label>
            <?php
              $is_multiple_choice_value = set_value('is_multiple_choice') == '' ? (isset($is_multiple_choice) ? $is_multiple_choice : '') : set_value('is_multiple_choice');
            ?>
            <div class="col-md-9">

              <?php

                $dd_options = [
                  '' => 'Choose Choice',
                  0 => 'Single Choice',
                  1 => 'Multiple Choice',
                ];

                $additional_options = [
                  'class' => 'form-control',
                ];
                
                echo form_dropdown('is_multiple_choice', $dd_options, $is_multiple_choice_value,$additional_options);

                echo form_error('is_multiple_choice');
              ?>
              <span class="text-danger help-block">Note: Please do not select more than one answer in <span style="color: red">single choice</span></span>
            </div>
          </div> 
          <?php */ ?>

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Course</label>
            <?php
              $course_id_value = set_value('course_id') == '' ? (isset($course_id) ? $course_id : '') : set_value('course_id');
            ?>
            <div class="col-md-9">

              <?php
                $additional_options = [
                  'class' => 'form-control',
                ];
                
                echo form_dropdown('course_id', $courses_dd, $course_id_value,$additional_options);

                echo form_error('course_id');
              ?>
            </div>
          </div> 

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Status</label>
            <?php
              $status_value = set_value('status') == '' ? (isset($status) ? $status : '') : set_value('status');
            ?>
            <div class="col-md-9">

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

          <?php


            if ($choice !== null && count($choice) > 0) {
              $counter = 0;
              foreach ($choice as $row) {
                $checked_ans = $row['correct'] == 1 ? 'checked' : '';
                $initializer = $counter + 1;
                $answer_id = isset($row['id']) ? $row['id'] : 0;
                $option_image = isset($row['image']) ? $row['image'] : '';
                $option_image_full_path = $option_image !== '' ? base_url('uploads/question/options/'.$option_image) : '';
          ?>
          <div class="form-group choice removeChoice-<?=$initializer?>">
            <label for="" class="col-md-2 control-label">Choice <?= $initializer ?></label>
            <div class="col-md-9">
              <div class="row">
                
                <div class="col-md-12 m-b-15"> 
                  <input type="text" class="form-control" value="<?=$row['answer']?>" name="choice[<?=$counter?>][answer]" placeholder="Enter Answer">
                </div>

                <div class="col-md-6"> 
                  <input type="hidden" name="choice[<?=$counter?>][image]" value="<?=$option_image?>">
                  <input type="file" class="form-control" name="choice[<?=$counter?>][image]" /> 
                </div>

                <div class="col-md-6">
                  <div class="checkbox">
                    <label>
                      <input type="hidden" name="choice[<?=$counter?>][correct]" value="0">
                      <input type="hidden" name="choice[<?=$counter?>][answer_id]" value="<?=$answer_id?>">
                      <input type="checkbox" name="choice[<?=$counter?>][correct]" value="1" <?=$checked_ans?>  style="margin-top: 1px;">&nbsp;&nbsp;Correct ?
                      <?php if($counter > 0) { ?>
                      <a class="removeChoice" data-question="<?=$update_id?>" data-choice="<?=$initializer?>" data-answer="<?=$answer_id?>" href="javascript:void(0);">&nbsp;&nbsp;&nbsp;&nbsp;Remove Choice</a>
                      <?php } ?>

                    </label>
                    <?php if($option_image_full_path !== '') { ?>
                    <a href="<?=$option_image_full_path?>" target="_blank"><img src="<?=$option_image_full_path?>" class="img-thumbnail" width='50' height='50'/></a>
                    <?php } ?>
                  </div>
                </div> 
                
              </div>
            </div>
          </div>
          <?php
            ++$counter;
              }
            }else {
          ?>
          <div class="form-group choice removeChoice-1">
            <label for="" class="col-md-2 control-label">Choice 1</label>
            <div class="col-md-9">
              <div class="row"> 

                <div class="col-md-12 m-b-15"> 
                  <input type="text" class="form-control" name="choice[0][answer]" placeholder="Enter Answer">
                </div>

                <div class="col-md-6"> 
                  <input type="file" class="form-control" name="choice[0][image]" /> 
                </div>

                <div class="col-md-4">
                  <div class="checkbox">
                    <label>
                      <input type="hidden" name="choice[0][correct]" value="0">
                      <input type="checkbox" name="choice[0][correct]" value="1" style="margin-top: 1px;">&nbsp;&nbsp;Correct ?
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php } ?>


          <div class="form-group">
            <div class="col-md-offset-2 col-md-10"><span id="addChoice" class="btn btn-danger btn-sm" href="javascript:void(0);">Add Choice</span></div>
          </div>
          
        </div>  
        <div class="box-footer m-t-40">
          <div class="form-group"> 
            <div class="col-md-offset-2 col-sm-10">
              <button type="submit" name='submit' value='submit' class="btn btn-primary">Submit</button>
              <button type="submit" name='submit' value='cancel' class="btn btn-warning">Cancel</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

