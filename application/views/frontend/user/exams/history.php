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
                <th>Score</th>
                <th>Percentage</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php if (!empty($query)) {
              $counter = 0;
              foreach ($query as $row) {
                if ($row['status'] == 1) {
                  $status_text = 'Passed';
                  $status_label = 'success';
                } else if ($row['status'] == 2) {
                  $status_text = 'Blocked';
                  $status_label = 'danger';
                } else if ($row['status'] == 0) {
                  $status_text = 'Failed';
                  $status_label = 'warning';
                }

            ?>
              <tr>
                <td><?=++$counter?></td>
                <td><?=$row['title']?></td> 
                <td><?=$row['total_score']?></td>
                <td><?=$row['percentage'].'%'?></td>
                <td><span class="label label-<?=$status_label?>"><?=$status_text?></span></td> 
                <td><?=Date('Y-m-d H:i:s', strtotime($row['started_at']))?></td>
                <td>
                  <?php if ($row['status'] == 1) { ?><a href='<?=base_url('user/exams/summary/'.$row['id'])?>'>
                    <span class="label label-success">Download Certificate</span>
                  </a>
                  <?php } else { echo '---';} ?>
                </td>
                <?php /*?><td>
                  <a href='<?=base_url('user/exams/summary/'.$row['id'])?>'>
                    <button type="button" class="btn btn-primary ">View Summary</button>
                  </a>
                </td><?php */?>
              </tr>
            <?php } } else { ?> 
              <tr>
                <td colspan='8'>Unfortunately you have not taken any of examinations yet</td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>