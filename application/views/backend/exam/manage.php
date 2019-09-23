<p class="">
	<!-- <a href="<?=base_url()?>development/exam">
		<button type="button" class="btn bg-maroon btn-flat margin-r-5">Create Question</button>
	</a>
	<a href="<?=base_url()?>development/exam">
		<button type="button" class="btn bg-purple btn-flat margin-r-5">.btn.bg-purple.btn-flat</button>
	</a>
	<a href="<?=base_url()?>development/exam">
		<button type="button" class="btn bg-navy btn-flat margin-r-5">.btn.bg-navy.btn-flat</button>
	</a>
	<a href="<?=base_url()?>development/exam">
		<button type="button" class="btn bg-orange btn-flat margin-r-5">.btn.bg-orange.btn-flat</button>
	</a> -->
	<a href="<?=base_url()?>development/exam/create">
		<button type="button" class="btn bg-olive btn-flat margin-r-5">Add New Exam</button>
	</a>
</p>

<?php
	$show_filter = FALSE;
?>

<div class="row">
	<?php if($show_filter === TRUE) { ?>
	<div class="col-xs-12"> 
		<div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title">Filters</h3>
		  </div> 
		  <form action="<?=$form_location?>" method="get">
		    <div class="box-body"> 
		    	<div class="row"> 
		    		<div class="col-md-3">
		    			<div class="form-group">
		    			  <label for="">Search By Email / Phone</label>
		    			  <input type="text" class="form-control" name="search" value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>" placeholder="Enter Email / Phone">
		    			</div>
		    		</div>
		    		<div class="col-md-3">
		    			<div class="form-group">
		    			  <label for="">Start Date</label>
		    			  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="start_date" value="<?=isset($_GET['start_date']) ? $_GET['start_date'] : ''?>" id="start-datepicker">
                </div>
		    			</div>
		    		</div>
		    		<div class="col-md-3">
		    			<div class="form-group">
		    			  <label for="">End Date</label>
		    			  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="end_date" value="<?=isset($_GET['end_date']) ? $_GET['end_date'] : ''?>" id="end-datepicker">
                </div>
		    			</div>
		    		</div>
		    	</div>
		    </div>  
		    <div class="box-footer">
		      <button type="submit" value='submit' class="btn btn-primary">Submit</button>
		      <a href="<?=base_url()?>development/exam" class="btn btn-warning">Cancel</a>
		    </div>
		  </form>
		</div> 
	</div>
	<?php } ?>

	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Exam List</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-condensed table-bordered">
					<tr>
						<th>SN</th>
						<th>Exam Title</th>
						<th>Course</th> 
						<th>No of question</th> 
						<th>Passing (%)</th> 
						<th>Marks</th> 
						<th>Status</th> 
						<th>Date</th> 
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
                
                
					?>
					
					<tr>
						<td><?=++$sn?></td>
						<td><?=substr($row['title'], 0, 110)?></td>
            <td><?=$row['course_title']?></td>
            <td><?=$row['total_question']?></td>
            <td><?=$row['passing_percentage']?></td>
            <td><?=$row['each_marks']?></td>
						<td><span class="label label-<?=$status_label?>"><?=$status_text?></span></td> 
            <td><?=Date('Y-m-d h:s A', strtotime($row['created_at']))?></td>
          	<td> 
							<a class="btn btn-sm btn-primary" href="<?=$edit_url.'/'.$row['id']?>">Edit</a>
						</td>
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
				<div class="col-md-12">
					<?=$this->pagination->create_links();?>
				</div>
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>