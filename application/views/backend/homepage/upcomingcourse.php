<p class="">
	<a href="<?=base_url()?>development/course/create">
		<button type="button" class="btn bg-olive btn-flat margin-r-5">Add New Course</button>
	</a>
</p>

<div class="row"> 
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Upcoming Courses List</h3>
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
									$image_src = base_url().'uploads/course/'.$row['featured_image'];
									$image_html = '<a target="_blank" href="'.$image_src.'"><img width="100" height="40" src="'.$image_src.'"></a>';	
								}
					?>
					
					<tr>
						<td><?=++$sn?></td>
						<td><?=$row['title']?></td> 
						<td><?=substr(strip_tags($row['description']), 0, 20)?></td>
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