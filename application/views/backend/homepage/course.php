<div class="row"> 
  <div class="col-md-12">
  	<?php if($flash_message != '' && $flash_type != '') { ?>
		<div class="alert alert-<?=$flash_type?> alert-dismissible">
	   	<?=$flash_message?>
	  </div>
		<?php } ?>  
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$headline_top?></h3>
      </div> 
			<form action="<?=$form_location?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="box-body">

          <div class="form-group">
            <label for="" class="col-md-2 control-label">Course</label>
            <div class="col-md-6">
              <?php
                $course_id_value = set_value('course_id') == '' ? (isset($course_id) ? $course_id : '') : set_value('course_id');
                
                $additional_option = ['class' => 'form-control'];

                echo form_dropdown('course_id', $course_dd, $course_id_value, $additional_option);
                echo form_error('course_id');
              ?>
            </div>
          </div>
 
					
					
          <div class="form-group">
            <label for="" class="col-md-2 control-label">Status</label>
              <div class="col-md-6">
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
            <label for="" class="col-md-2 control-label">Fetured Image</label>
            <?php
              $featured_image_value = set_value('featured_image') == '' ? (isset($featured_image) ? $featured_image : '') : set_value('featured_image');
							?>
            <div class="col-md-6">
							<input type="file" class="form-control" name="featured_image">
              <?= isset($featured_image_error) ? $featured_image_error : '' ?>
            </div>
          </div>
					
					<div class="form-group">
						<label for="" class="col-md-2 control-label">Description</label>
						<div class="col-md-6">
							<?php
								$description_value = set_value('description') == '' ? (isset($description) ? $description : '') : set_value('description');
							?>
							<textarea type='text' class='form-control' name='description'><?=$description_value?></textarea>
							<?=form_error('description');?>				
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

    <?php if($update_id > 0) {?>
    <div class="box box-primaryox">
      <div class="box-header">
        <h3 class="box-title">Featured Image</h3>
      </div>
      <div class="box-body">
        <?php if($featured_image !== '') {
          $full_path_image = base_url().'uploads/homepage/course/'.$featured_image;  
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

<div class="row"> 
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Courses List</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover table-bordered">
					<tr>
						<th>SN</th>
						<th>Title</th>
						<th>Description</th>
						<th>Featured Image</th> 
						<th>Status</th> 
						<th>Action</th>
					</tr>

					<?php
						if (!empty($query)) {
							$sn = 0 + (int)$this->input->get('per_page');
							foreach ($query as $row) {

								if ($row['status'] == 1) {
									$status_text = 'Active';
									$status_label = 'success';
								} else if ($row['status'] == 2) {
									$status_text = 'Blocked';
									$status_label = 'danger';
								} else if ($row['status'] == 0) {
									$status_text = 'Inactive';
									$status_label = 'warning';
								}

								$image_html = '';
								if ($row['featured_image']) {
									$image_src = base_url().'uploads/homepage/course/'.$row['featured_image'];
									$image_html = '<a target="_blank" href="'.$image_src.'"><img width="100" height="50" src="'.$image_src.'"></a>';	
								}
					?>
					
					<tr>
						<td><?=++$sn?></td>
						<td><?=$row['course_title']?></td> 
						<td><?=substr($row['description'], 0, 20)?></td>
						<td><?=$image_html?></td>
						<td><span class="label label-<?=$status_label?>"><?=$status_text?></span></td> 
						<td><a class="btn btn-sm btn-primary" href="<?=$edit_url.'/'.$row['id']?>">Edit</a></td>
					</tr>
					<?php
							}
						} else {
					?>
					<tr>
						<td colspan="6">No Record Found</td>
					</tr>
					<?php
						}
					?>
				</table>
				
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>