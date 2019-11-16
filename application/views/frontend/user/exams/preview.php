<div class='default-padding custom-preview'>
  <div class='container'>
    <div class='col-md-7 col-md-offset-3'>
      <?php if (!empty($query)) { $query = $query[0]; ?>

      <h3 class='text-danger'>Instruction read carefully</h3>
      <ul>
        <li>You have 3 attempts for the course.</li>
        <li> Once you have started your exam, it will be counted as an attempt even
        if you opt out mid-way.</li>
        <li> First unsuccessful attempt will lock the test for 48 hours and you will be
        required to go through the knowledge materials to brush up the topics.</li>
        <li> After the test you will be able to review your complete performance.</li>
        <li> Carefully read the questions and submit your answers make the most of
        our answer submission options.</li> 
      </ul>     
      <br>
      <ul>
        <li>Exam - <?=$query['title']?></li>
        <li>Question - <?=$query['total_question']?></li>
        <li>Marking per question - <?=$query['each_marks']?></li>
        <li>Passing marks/percentage: - <?=$query['passing_percentage'].'%'?></li>
        <li>Duration - <?=$query['duration'].' '.ucfirst($query['duration_type'])?> </li>
        <li>Attempt - 0</li>
      </ul>
      <br>
      <a id="start-exam" data-id='<?=$query['id']?>' data-href='<?=base_url('user/exams/start/'.$query['id'])?>'>
        <button type="button" class="btn btn-danger ">Start Exam</button>
      </a>
      <?php } ?>
    </div>
  </div>
</div>

<div class="modal fade" id="verificationModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Please confirm before starting the exam.</h4>
        </div>
        <div class="modal-body">
          <ul>
            <li>You have 3 attempts for the course.</li>
            <li> Once you have started your exam, it will be counted as an attempt even
            if you opt out mid-way.</li>
            <li> First unsuccessful attempt will lock the test for 48 hours and you will be
            required to go through the knowledge materials to brush up the topics.</li>
            <li> After the test you will be able to review your complete performance.</li>
            <li> Carefully read the questions and submit your answers make the most of
            our answer submission options.</li> 
          </ul>
          <br> 
          <div class="checkbox">
            <label>
              <input type="checkbox" style="margin: 7px -20px 0;" id="confirmation" value=""> I have read and understood all of the instructions.
            </label>
          </div>
           
        </div>
        <div class="modal-footer ">
          <div class='text-left'>
            <button type="button" class="btn btn-success" id="yesConf">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>
