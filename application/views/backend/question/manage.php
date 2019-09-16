<p class="">
	<!-- <a href="<?=base_url()?>development/question">
		<button type="button" class="btn bg-maroon btn-flat margin-r-5">Create Question</button>
	</a>
	<a href="<?=base_url()?>development/question">
		<button type="button" class="btn bg-purple btn-flat margin-r-5">.btn.bg-purple.btn-flat</button>
	</a>
	<a href="<?=base_url()?>development/question">
		<button type="button" class="btn bg-navy btn-flat margin-r-5">.btn.bg-navy.btn-flat</button>
	</a>
	<a href="<?=base_url()?>development/question">
		<button type="button" class="btn bg-orange btn-flat margin-r-5">.btn.bg-orange.btn-flat</button>
	</a> -->
	<a href="<?=base_url()?>development/question/create">
		<button type="button" class="btn bg-olive btn-flat margin-r-5">Add New Question</button>
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
		      <a href="<?=base_url()?>development/question" class="btn btn-warning">Cancel</a>
		    </div>
		  </form>
		</div> 
	</div>
	<?php } ?>

	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Questions List</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-condensed table-bordered">
					<tr>
						<th>SN</th>
						<th>Question</th>
						<!-- <th>Question Type</th> --> 
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

								$question_type = 'Single Choice';
								if ($row['is_multiple_choice'] === 1) {
									$question_type = 'Multiple Choice';
								}

								$options = !empty(unserialize($row['options'])) ? unserialize($row['options']) : [];
					?>
					
					<tr>
						<td><?=++$sn?></td>
						<td class="col-md-8"><?=substr($row['question_title'], 0, 110)?></td>
						
						<?php /* ?>
						<td>
							<table class="table table-bordered table-striped m-b-0">
								<thead>
									<tr>
										<th>Q. <?=$row['question_title']?></th> 
									</tr>
									<tr> 
										<td>
											<table class="table table-bordered table-striped m-b-0">
												<tr>
													<th>No.</th>
													<th>Option</th>
													<th>Correct</th>
												</tr>

												<?php
													if (!empty($options)) {
														$total_option_count = count($options);
														$option_counter = 0;
														foreach ($options as $key => $options_row) {
												?>
												<tr>
													<td><?= ++$option_counter ?></td>
													<td><?= $options_row['answer'] ?></td>
													<td><?= $options_row['correct'] == 1 ? 'Yes' : 'No' ?></td>
												</tr>
												<?php
														}
													}
												?>
											</table>
										</td>
									</tr>									
								</thead>
							</table>
						</td>
						<?php */?>

						<!-- <td><?=$question_type?></td> -->
						<td><span class="label label-<?=$status_label?>"><?=$status_text?></span></td> 
						<td>
							<a class="btn btn-sm btn-warning" href="<?=$view_url.'/'.$row['id']?>">View</a>
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