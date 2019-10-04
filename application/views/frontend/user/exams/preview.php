<div class='default-padding custom-preview'>
  <div class='container'>
    <div class='col-md-7 col-md-offset-3'>
      <?php if (!empty($query)) { $query = $query[0]; ?>

      <h3 class='text-danger'>Instruction read carefully</h3>

      <p>Once you have start exam your attempt will be counting as your first attempt</p>
      <p>You have only 2 attempts for each exam.</p>
      <p>If you have not finished your exam it will be counting as your attempts and as well as you will also be blocked for 48 hours.</p>
      <p>Exam - <?=$query['title']?></p>
      <p>Question - <?=$query['total_question']?></p>
      <p>Marking - <?=$query['each_marks']?></p>
      <p>Passing Marks - <?=$query['passing_percentage'].'%'?></p>
      <p>Duration - <?=$query['duration'].' '.ucfirst($query['duration_type'])?> </p>
      <p>Attempt - 0</p>
      <a id="start-exam" data-id='<?=$query['id']?>' data-href='<?=base_url('user/exams/start/'.$query['id'])?>'>
        <button type="button" class="btn btn-danger ">Start Exam</button>
      </a>
      <?php } ?>
    </div>
  </div>
</div>
