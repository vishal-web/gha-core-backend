<div class='default-padding custom-preview'>
  <div class='container'>
    <div class='col-md-7 col-md-offset-3'>
      <?php 
        if (!empty($query)) { 
          $query = $query[0]; 
          if ($query['type'] === 'img') {
            $img_path = base_url().'uploads/studymaterial/'.$query['study_material'];
      ?>
      <div class=''>
        <img src="<?=$img_path?>" class="img-responsive" alt="Image">
      </div>
      <?php
          }
        }
      ?>    
    </div>
  </div>
</div>
