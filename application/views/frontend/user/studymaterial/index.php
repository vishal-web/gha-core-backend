<div class='default-padding'>
  <div class='container custom-table'>
    <h3><?=$headline?></h3>
    <table class='table table-bordered table-condensed'>
      <thead>
        <tr>
          <th>S.No</th> 
          <th>Course</th>
          <th>Material Type</th> 
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
          <td><?=$row['course_title']?></td>
          <td><?=get_material_dd()[$row['type']]?></td> 
          <td>
            <a href='<?=base_url('user/studymaterial/preview/'.$row['id'])?>'>
              <button type="button" class="btn btn-primary ">View</button>
            </a>
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