<div class='default-padding course-details-area'>
  <div class='container custom-table'>
    <div class='row'>
      <?php $this->load->view('frontend/user/inc/sidebar'); ?>
      <div class='col-md-9 p-t-60'>
        <div class='table-responsive'>
          <table class='table table-bordered table-condensed'>
            <thead>
              <tr>
                <th>S.No</th>
                <th>Exam</th> 
                <th>Passing (%)</th> 
                <th>Available Attempt</th> 
                <th>Exam Expiry Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php if (!empty($query)) {
              $counter = 0;
              foreach ($query as $row) {
                $take_exam = false;
                if ($row['payment_date'] && $row['course_duration']) {
                  $expiry_date = Date('Y-m-d', strtotime('+ '.$row['course_duration'].' months', strtotime($row['payment_date'])));
                  if ($expiry_date >= Date('Y-m-d')) {
                    $take_exam = true;
                  }
                }
            ?>
              <tr>
                <td><?=++$counter?></td>
                <td><?=$row['title'].'<br> <b><small>Course - '.$row['course_title']?></small></b></td> 
                <td><?=$row['passing_percentage']?></td>  
                <td><?=$row['attempt_left']?></td>  
                <td><?=Date('Y-m-d h:i A', strtotime('+ '.$row['course_duration'].' months', strtotime($row['payment_date'])))?></td>
                <td>
                  <?php if ($take_exam && $row['attempt_left'] > 0) { ?>
                  <a href='<?=base_url('user/exams/preview/'.$row['id'].'/'.$row['order_product_id'])?>'>
                    <button type="button" class="btn btn-danger ">Take Exam</button>
                  </a>
                  <?php } else { ?>
                    <button type="button" class="btn btn-primary">Not Available</button>
                  <?php } ?>
                </td>
              </tr>
            <?php } } else { ?> 
              <tr>
                <td colspan='8'>Unfortunately no exam is available for you</td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>      
      </div>
    </div>
  </div>
</div>