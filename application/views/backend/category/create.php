<div class="row"> 
  <div class="col-md-12">
  	<?php if($flash_message != '' && $flash_type != '') { ?>
		<div class="alert alert-<?=$flash_type?> alert-dismissible">
	   	<?=$flash_message?>
	  </div>
		<?php } ?>  
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><?=$table_head_title?></h3>
      </div> 
      <form action="<?=$form_location?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="box-body">

        	<div class="col-md-12"> 
        		<div class="form-group">
              <label for="" class="col-md-3 control-label">Title</label>
        		  <div class="col-md-6"> 
        			  <?php
        			  	$title_value = set_value('title') == '' ? (isset($title) ? $title : '') : set_value('title');
        			  ?>
        			  <input type="text" class="form-control" name="title" value="<?=$title_value?>" placeholder="Enter title">
        			  <?=form_error('title')?>
        			</div>
        		</div>
          </div>

          <div class="col-md-12"> 
            <div class="form-group">
              <label for="" class="col-md-3 control-label">Description <span class="text-danger">(Optional)</span></label>
              <div class="col-md-6">
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
          <div class="col-md-9 col-md-offset-3">
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
          $full_path_image = base_url().'uploads/backend/course/'.$featured_image;  
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