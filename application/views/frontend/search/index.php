<div class="list-group">
  <?php if (!empty($query)) { ?>
    <?php foreach ($query as $row) { ?>
      <a href="<?=base_url('course/'.$row['url_title'])?>" class="list-group-item"><?=$row['title']?></a> 
    <?php } ?>
  </div>
  <?php } else { ?> 
    <a href="#" class="list-group-item">No search found</a>
  <?php } ?>
</div>