<div class='default-padding custom-preview'>
  <div class='container'>
    <h3><?=$headline .' For '.$course_details['title']?> </h3>
    <div class='col-md-12-1'> 
      <?php 
        if (!empty($query)) { 
          $query = $query[0]; 
          $full_file_path = base_url().'uploads/studymaterial/';
          if ($query['type'] == 'img') {
            $full_file_path .= 'img/'.$query['study_material'];
      ?>
      <div class=''>
        <img src="<?=$full_file_path?>" class="img-responsive" alt="Image">
      </div>
      <?php } else if ($query['type'] == 'youtube') { ?>
        <iframe width="420" height="345" src="<?=$query['study_material']?>" frameborder="0" allowfullscreen></iframe>
      <?php } else if ($query['type'] == 'pdf') { $full_file_path .= 'pdf/'.$query['study_material'];?>
        <iframe width="100%" height="100%" id="iframe"  style='min-height:100vh' src="<?=$full_file_path?>#toolbar=0" toolbar="0"></iframe>
      <?php } } ?>
    </div>
  </div>
</div>

