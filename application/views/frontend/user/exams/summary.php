<style>
  .question-summary table tr td {
    border-top:none !important;
    padding: 15px 8px !important; 
  }

  .question-summary table {
    border-collapse:separate; 
    border-spacing: 0 1em;
  }
</style>
<div class='default-padding fuelux'>
  <div class='container'>
    <h3><?=$headline?></h3>
    <div class='row'>
      
      <div class='col-md-8 question-summary'>
      
        <?php if (!empty($query)) { $count = count($query); $counter = 0; ?>
        <div class="panel-group" id="accordion">
          <?php foreach ($query as $row) { 
            ++$counter;
            $answers = unserialize($row['answers']);
            $user_answer_id = $answers['user_answer_id'];
            $choices = array_chunk($answers['answers'], 2); 
          ?>

          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$counter?>">
                Question <?=$counter?> of <?=$count?></a>
              </h4>
            </div>
            <div id="collapse<?=$counter?>" class="panel-collapse collapse">
              <div class="panel-body">
                <?=$row['question_title']?>

                <table class="table">

                  <?php if (!empty($choices)) {
                    $counter_statement = 0;
                    for ($i=0; $i < count($choices); $i++) {
                      echo "<tr>";
                      if (!empty($choices[$i])) {
                        foreach ($choices[$i] as $choice) {
                          
                          $text_color = '';
                          if ($user_answer_id > 0) {
                            if ($user_answer_id == $choice['id'] && $choice['correct'] == 1) {
                              $text_color = 'text-success correct-answer bg-success';
                            } else if ($user_answer_id == $choice['id'] && $choice['correct'] == 0) {
                              $text_color = 'text-warning incorrect-answer bg-danger';
                            } else if ($choice['correct'] == 1){
                              $text_color = 'text-success bg-success';
                            }
                          } else if ($choice['correct'] == 1){
                            $text_color = 'text-success bg-success';
                          }
                  ?>
                          <td class='<?=$text_color?>'>
                            <span><?=++$counter_statement?>. <?=$choice['answer']?></span>                                                                                                            </label>                                                
                          </td>

                  <?php
                        }
                      }
                      echo "</tr>";
                    }
                  } ?>
                </table>

              </div>
            </div>
          </div>

          <?php } ?>
        </div>
        <?php } ?>
      </div>

      <div class='col-md-4'>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            Exam Details
          </h4>
        </div>
        
        <div class="panel-body">
          <table class='table table-bordered'>
            
            <tr>
              <th class='col-md-6'>Total Score</th>
              <td><?=$exam_details[0]['total_score']?></td>
            </tr>
            <tr>
              <th class='col-md-6'>Percentage</th>
              <td><?=$exam_details[0]['percentage'].'%'?></td>
            </tr>
            <tr>
              <th class='col-md-6'>Exam Taken Date</th>
              <td><?=Date('Y-m-d h:i A',strtotime($exam_details[0]['started_at']))?></td>
            </tr>
          </table>
        </div> 
      </div>
      </div>
    </div>
  </div>
</div>
