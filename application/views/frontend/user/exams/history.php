<div class='default-padding'>
  <div class='container custom-table'>
    <h3><?=$headline?></h3>
    <table class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th>S.No</th>
          <th>Exam</th>
          <th>Total Question</th>
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
          <td><?=$row['total_question']?></td>
          <td><?=$row['total_score']?></td>
          <td><?=$row['percentage'].'%'?></td>
          <td><span class="label label-<?=$status_label?>"><?=$status_text?></span></td> 
          <td><?=Date('Y-m-d H:i:s', strtotime($row['started_at']))?></td>
          <td>
            <a href='<?=base_url('user/exams/summary/'.$row['id'])?>'>
              <button type="button" class="btn btn-primary ">View Summary</button>
            </a>
          </td>
        </tr>
      <?php } } else { ?> 
        <tr>
          <td colspan='8'>Unfortunately you have not taken any of our courses yet</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>