<p class="">
	<a href="<?=$manage_url?>">
		<button type="button" class="btn bg-primary btn-flat margin-r-5">Manage Questions</button>
	</a>
	<a href="<?=$edit_url?>">
		<button type="button" class="btn bg-olive btn-flat margin-r-5">Update Question</button>
	</a>
</p>

<div class="row">

	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Questions Details</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<?php
					$question_data = $query[0]; 

					echo $question_data['question_title'];
					echo "<br><br>";
					
					if ($question_data['image']) {
						echo "<img src='".base_url('uploads/question/'.$question_data['image'])."' width='150' class='img-responsive'>";
						echo "<br><br>";
					}


					echo "Choices-";
					echo "<br><br>";



					if (!empty($options)) {
						echo "<table class='table'>";
						$counter = 0;

						foreach ($options as $key => $row) {
							$answer = $row['answer']; 
							$option_image_full_path = $row['image'] !== '' ? base_url('uploads/question/options/'.$row['image']) : '';
							echo "<tr>";
							echo "<td>".++$counter."</td>";
							echo "<td>".$answer;
							if ($option_image_full_path !== '') {
								echo "<img src='".$option_image_full_path."'width='100'/>";
							}
							echo "</td>";;
							echo "</tr>";
						}
						echo "</table>";
					}

					echo "<br><br>";
					echo $question_data['description'];
					echo "<br><br>";
					echo "<br><br>";

				?>
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>