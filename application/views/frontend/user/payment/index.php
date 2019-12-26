<div class='default-padding course-details-area'>
  <div class='container custom-table'>
    <div class="row">
    
      <?php $this->load->view('frontend/user/inc/sidebar'); ?>
      <div class='col-md-9 p-t-60'>
        <div class='table-responsive'>
          <table class='table table-bordered table-condensed'>
            <thead>
              <tr>
                <th>S.No</th> 
                <th>Transaction id</th>
                <th>Mode</th>
                <th>Amount</th> 
                <th>Message</th>
                <th>Date</th> 
              </tr>
            </thead>
            <tbody>
            <?php if (!empty($query)) {
              $counter = 0;
              foreach ($query as $row) {
            ?>
              <tr>
                <td><?=++$counter?></td>
                <td><?=$row['transaction_id']?></td>
                <td><?=$row['mode']?></td>
                <td><?=($row['amount'] / 100)?></td> 
                <td><?=$row['response_description']?></td>
                <td><?=$row['payment_date']?></td>
              </tr>
            <?php } } else { ?>
              <tr>
                <td colspan="8" class='text-center'>No Record Found</td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div> 
    </div>
  </div>
</div>