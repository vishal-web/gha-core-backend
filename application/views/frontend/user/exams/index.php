<div class='default-padding'>
  <div class='container custom-table'>
    <table class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th>S.No</th>
          <th>Exam</th>
          <th>Course</th>
          <th>Passing (%)</th>
          <th>Total question</th>
          <th>Each question marks</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($query)) {
        $counter = 0;
        foreach ($query as $row) {
      ?>
        <tr>
          <td><?=++$counter?></td>
          <td><?=$row['title']?></td>
          <td><?=$row['course_title']?></td>
          <td><?=$row['passing_percentage']?></td>
          <td><?=$row['total_question']?></td>
          <td><?=$row['each_marks']?></td>
          <td>
            <a href='<?=base_url('user/exams/start/'.$row['id'])?>'>
              <button type="button" class="btn btn-danger ">Take Exam</button>
            </a>
          </td>
        </tr>
      <?php } } ?>
      </tbody>
    </table>
  </div>
</div>