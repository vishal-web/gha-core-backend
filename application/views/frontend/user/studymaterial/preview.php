<div class='default-padding custom-preview'>
  <div class='container'>
    <h3><?=$headline .' For '.$course_details['title']?> <span class='pull-right'><a class='btn btn-primary' href='<?=base_url('user/studymaterial')?>'><i class='fa fa-arrow-left'></i> Back</a></span></h3>
    
    <?php if (!empty($query)) { ?>
    <div class="col-md-12 adviros-details-area" style='border: 1px solid #f1f2'>
      <div class='row'>
        <div class="tab-info"> 
          <ul class="nav nav-pills">
            <?php foreach ($query as $key => $row) { 
              $active = ''; $expanded = 'false';
              if ($key == 0) {
                $active = 'active';
                $expanded = 'true';
              }
            ?>
            <li class="<?=$active?>"><a data-toggle="tab" href="#tab<?=$key?>" aria-expanded="<?=$expanded?>"><?=get_material_dd()[$row['type']]?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content tab-content-info">
            <?php
              foreach ($query as $key => $row) {  
                $full_file_path = base_url().'uploads/studymaterial/';
            ?>
            <div id="tab<?=$key?>" class="tab-pane fade <?= $key == 0 ? 'active in' : '' ?>">
              <div class="info title col-md-8 p-t-20"> 
                <?php if ($row['type'] == 'img') { $full_file_path .= 'img/'.$row['study_material']; ?>
                  <img src="<?=$full_file_path?>" class="img-responsive">
                <?php } else if ($row['type'] == 'youtube') { ?>
                  <iframe width="420" height="345" src="<?=$row['study_material']?>" frameborder="0" allowfullscreen></iframe>
                <?php } else if ($row['type'] == 'pdf') { $full_file_path .= 'pdf/'.$row['study_material'];?>
                  <iframe width="100%" height="100%" id="iframe"  style='min-height:100vh' src="<?=$full_file_path?>#toolbar=0" toolbar="0"></iframe>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  
  </div>
</div>

