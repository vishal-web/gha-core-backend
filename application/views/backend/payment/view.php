<p class="">
	<a href="<?=$manage_url?>">
		<button type="button" class="btn bg-primary btn-flat margin-r-5">Manage Payment</button>
	</a>
	<!-- <a href="<?=$edit_url?>">
		<button type="button" class="btn bg-olive btn-flat margin-r-5">Update Question</button>
	</a> -->
</p>

<div class="row">

	<div class="col-xs-6 col-lg-6">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">User Details</h3>
			</div>
			<div class="box-body table-responsive">
				<table class='table table-bordered'>
          <tr>
            <th>Name</td>
            <td><?=$query[0]['firstname'] .' '. $query[0]['lastname']?></td>
          </tr>
          <tr>
            <th>Email</td>
            <td><?=$query[0]['email']?></td>
          </tr>
          <tr>
            <th>Phone</th>
            <td><?=$query[0]['phone']?></td>
          </tr>
        </table>
			</div>
		</div>
		<!-- /.box -->
	</div>

	<div class="col-xs-6 col-lg-6">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Payment Details</h3>
			</div>
			 
      <div class="box-body table-responsive">
				<table class='table table-bordered'>
          <tr>
            <th>Transaction ID</td>
            <td><?=$query[0]['transaction_id']?></td>
          </tr>
          <tr>
            <th>Mode</td>
            <td><?=$query[0]['mode']?></td>
          </tr>
          <tr>
            <th>Description</td>
            <td><?=$query[0]['response_description']?></td>
          </tr>
          <tr>
            <th>Amount</td>
            <td><?=($query[0]['amount'] / 100)?></td>
          </tr>
          <tr>
            <th>Date</td>
            <td><?=Date('Y-m-d H:i:s A', strtotime($query[0]['payment_date']))?></td>
          </tr>
        </table>
			</div>
		</div>
		<!-- /.box -->
	</div>

	<div class="col-xs-6 col-lg-6">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Course Details</h3>
			</div>
			
			<div class="box-body table-responsive">
        <table class='table table-bordered'>
          <tr>
            <th>Course</td>
            <td><?=$query[0]['course_title']?></td>
          </tr>
          <tr>
            <th>Duration</td>
            <td><?=$query[0]['course_duration'] .' Month'?></td>
          </tr>
          <tr>
            <th>Price</th>
            <td><?=$query[0]['course_price']?></td>
          </tr>
        </table>
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>