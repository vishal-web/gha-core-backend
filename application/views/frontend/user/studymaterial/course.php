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
                <th>Module</th>
                <?php /*?><th>Material Type</th><?php */?> 
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
                <td><?= $row['title'] !== '' ? $row['title'] : 'Module'  ?></td>
                <?php /*?><td><?=get_material_dd()[$row['type']]?></td> <?php */?> 
                <td>
                  <a href='<?=base_url('user/studymaterial/preview/'.$course_id.'/'.$row['id'])?>'>
                    <button type="button" class="btn btn-primary ">View</button>
                  </a>
                </td>
              </tr>
            <?php } } else { ?> 
              <tr>
                <td colspan='8'>Not found</td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

