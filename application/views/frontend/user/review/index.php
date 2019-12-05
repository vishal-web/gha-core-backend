<div class='default-padding'>
  <div class='container custom-table'>

    <h3><?=$headline?></h3>
    <?php if($flash_message != '' && $flash_type != '') { ?>
      <div class="alert alert-<?=$flash_type?> alert-dismissible">
      <?=$flash_message?>
      </div>
    <?php } ?>

    <?php if (empty($query)) { ?>
    <form action='<?=current_url()?>' method='POST'>
      <h5>Please give us your review</h5>
      <div class="col-md-12">
          <div class="row">
              <div class="form-group">
                  <input class="form-control" name="review" placeholder="Review" type="text">
                  <?=form_error('review')?>
              </div>
          </div>
      </div>
                    
      <div class="col-md-12">
          <div class="row">
              <button name="submit" class='btn btn-primary' value="submit" type="submit">Submit</button>
          </div>
      </div> 
    </form> 
    <?php } else { ?>
    <table class='table table-bordered'>
      <tr>
        <th class='col-md-8'>Review</th>
        <th>Date</th>
      </tr>

      <tr>
        <td><?=$query[0]['review']?></td>
        <td><?=date('Y-m-d h:i A', strtotime($query[0]['created_at']))?></td>
      </tr>

    </table>
    
    <?php }  ?>
  </div>
</div>