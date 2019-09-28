<div class='default-padding custom-preview'>
  <div class='container'>
    <h3><?=$headline .' For '.$course_details['title']?> </h3>
    <div class='col-md-12-1'> 
      <?php 
        if (!empty($query)) { 
          $query = $query[0]; 
          if ($query['type'] === 'img') {
            $img_path = base_url().'uploads/studymaterial/'.$query['study_material'];
      ?>
      <div class=''>
        <img src="<?=$img_path?>" class="img-responsive" alt="Image">
      </div>
      <?php } else if ($query['type'] === 'youtube') { ?>
        <iframe width="420" height="345" src="<?=$query['study_material']?>" frameborder="0" allowfullscreen></iframe>
      <?php } } ?>    
    </div>
  </div>
</div>
