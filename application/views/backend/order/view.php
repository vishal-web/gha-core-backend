<p class="">
	<a href="<?=$manage_url?>">
		<button type="button" class="btn bg-primary btn-flat margin-r-5">Manage Payment</button>
	</a>
	<!-- <a href="<?=$edit_url?>">
		<button type="button" class="btn bg-olive btn-flat margin-r-5">Update Question</button>
	</a> -->
</p>

<div class="row">

	<div class="col-xs-12 col-lg-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Order Details</h3>
			</div>
			<div class="box-body table-responsive">
        <div class='table-responsive'>
          <table class='table table-bordered m-b-30'>
            <tr>
              <th class='col-md-6'>Payment Info</th> 
              <th class='col-md-6'>Billing Details</th> 
            </tr>
            <tr> 
              <?php
                if ($query['status'] == 1) {
                  $status_text = 'Success';
                } else if ($query['status'] == 2) {
                  $status_text = 'Failed';
                } else if ($query['status'] == 0) {
                  $status_text = 'Order Initiated';
                }
              ?>
              <td  style='vertical-align:middle'> 
                Transaction ID: <?=$query['transaction_id']?></br>

                Mode: <?=$query['mode']?></br>

                Description: <?=$query['response_description']?></br>

                Amount: <?=number_in_inr($query['amount'] / 100)?></br>

                Status: <?=$status_text?></br>

                Date: <?=Date('Y-m-d h:i:s A', strtotime($query['order_date']))?>

              </td>
              <td style='vertical-align:middle'>
                <?php 
                  echo 'Name: '. $query['billing_name'].'</br>'; 
                  echo 'Email: '. $query['billing_email'].'</br>'; 
                  echo 'Address: '. $query['billing_street_address'].', '.$query['billing_city_name'].', '.$query['billing_state_name'].' '.$query['billing_pincode'].', '.$query['billing_country_name'].'</br>'; 
                ?>
              </td>
            </tr> 
          </table>
        

          <?php if (!empty($order_items)) { ?>

          <table class='table table-bordered vertical-align-middle'>
            <tr> 
              <th>Course Name</th>
              <th>Duration</th>
              <th class='text-right col-md-2'>Price</th>  
            </tr>
            <?php 
              $total = 0;
              foreach ($order_items as $row) {  
                $course_title_desc = '<a href="'.base_url('course/').$row['url_title'].'"><b class="fs-16">'.$row['title'].'</b><br/><small>Duration: '.$row['duration'].'Months</small></a>';
                $total += $row['price'];
                $thumb_path = base_url('uploads/course/thumb/'.$row['featured_image']);
            ?>
            <tr>
              <td class='vcenter col-md-2'><img width='75' height='75' class='' src='<?=$thumb_path?>'/></td>
              <td class='vcenter middle-desc'><?=$course_title_desc?></td>
              <td class='vcenter text-right'><?=number_in_inr($row['price'])?></td>
            </tr>
            <?php } ?>
            
            <tr>
              <td colspan="2" class='text-right'><b>Total</b></td>
              <td class='text-right'><?=number_in_inr($total)?></td>
            </tr>
          </table>
          <?php } ?> 
        </div>
			</div>
		</div>
		<!-- /.box -->
	</div>

</div>