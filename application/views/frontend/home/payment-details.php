<div class="container">
	<div class="col-md-offset-3 col-md-6">
		<div class="table-responsive text-center" style="margin: 50px 0px">
			<h3>Payment Details</h3>
		  <table class="table table-striped table-bordered">
		    <tbody>
		      <tr>
		        <td><b>Amount</b></td>
		        <td><?=($query['amount'] / 100)?></td>
		      </tr>
		      
		      <tr>
		        <td><b>Transaction ID</b></td>
		        <td><?=$query['transaction_id']?></td>
		      </tr>
		      
		      <tr>
		        <td><b>Status</b></td>
		        <td>Success</td>
		      </tr>
		    </tbody>
		  </table>
		</div>
	</div>

</div>