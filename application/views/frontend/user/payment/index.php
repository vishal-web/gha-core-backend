<div class='default-padding'>
  <div class='container custom-table'>

    <h3><?=$headline?></h3>

    <table class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th>S.No</th> 
          <th>Transaction id</th>
          <th>Mode</th>
          <th>Amount</th>
          <th>Course</th>
          <th>Course duration</th>
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
          <td><?=$row['course_title']?></td>
          <td><?=$row['course_duration'] .' Month'?></td>
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