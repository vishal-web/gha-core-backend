<style>
  .fuelux {
    background: #ccc;
  }

</style>

<div class='default-padding fuelux'>
  <div class='container'>
    <div class='row'>
      <div class="col-sm-8 fu-example section">
        <div class="box outheBoxShadow wizard bg-light" data-initialize="wizard" id="questionWizard">
          <div class="steps-container bg-light">
            <ul class="steps hidden" style="margin-left: 0">
              <?php for ($i = 1; $i <= $query->num_rows(); $i++) { ?>
              <li data-step="<?=$i?>" class="<?=$i == 1 ? 'active' : ''?>"></li>
              <?php } ?>
            </ul>
          </div>
          <form id="answerForm" action="<?=current_url()?>" method="post">
            <div class="box-body step-content">
              <input style="display:none" type="text" name="studentfinishstatus">
              <input type="hidden" id='end' value='<?=base64_encode($exam_session_data['exam_end_at'])?>' />
              <input type="hidden" id='start' value='<?=base64_encode($exam_session_data['exam_start_at'])?>' />
              <?php
                $total_count = $query->num_rows();
                $counter = 1;
                foreach ($query->result_array() as $key => $row) {
                  $choices = array_chunk($controller->get_options($row['id']), 2); 

              ?> 
              <input type="hidden" value="<?=$row['id']?>" name="question[<?=$row['id']?>]"/>
              <div class="clearfix step-pane sample-pane active" data-questionID="10" data-step="<?=$counter?>">
                <div class="question-body">
                  <label class="lb-title">Question <?=$counter?> of <?=$total_count?></label>
                  <label class="lb-mark"> 1 Mark </label>
                  <label class="lb-content">
                    <?=$row['question_title']?>
                  </label>
                </div>
                <div class="question-answer" id="step<?=$counter?>">
                  <table class="table">

                    <?php if (!empty($choices)) {
                      for ($i=0; $i < count($choices); $i++) {
                        echo "<tr>";
                        if (!empty($choices[$i])) {
                          foreach ($choices[$i] as $choice) {

                    ?>
                            <td>
                              <input type='hidden' name="answer[<?=$row['id']?>][]" value='0'/>
                              <input id="option<?=$choice['id']?>" value="<?=$choice['id']?>" name="answer[<?=$row['id']?>][]" type="radio">
                              <label for="option<?=$choice['id']?>">
                              <span class="fa-stack radio-button">
                              <i class="active fa fa-check"></i></span>
                              <span> <?=$choice['answer']?></span></label>
                              
                              <?php if ($choice['image'] !== '') { 
                                echo "<img class='img-thumbnail' width='100' src='".base_url('uploads/question/options/'.$choice['image'])."' class='img-control' />";
                              } ?>                                                                                                          </label>                                                
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
              <?php ++$counter; } ?>
              <input type='hidden' name='marked' value=''/>
              <input type='hidden' name='not_visited' value=''/>
              <input type='hidden' name='not_answered' value=''/>
              <input type='hidden' name='answered' value=''/>
              <div class="question-answer-button">
                <button class="btn oe-btn-answered btn-prev" type="button" name="" id="prevbutton" disabled><i class="fa fa-angle-left"></i> Previous                    </button>
                <button class="btn oe-btn-notvisited" type="button" name="" id="reviewbutton">Mark For Review & Next</button>
                <button class="btn oe-btn-answered btn-next" type="button" name="" id="nextbutton" data-last="Finish ">Next <i class="fa fa-angle-right"></i></button>
                <button class="btn oe-btn-notvisited" type="button" name="" id="clearbutton">Clear Answer</button>
                <input type='hidden' value='submitexam' name='submitexam' />
                <button class="btn oe-btn-notanswered" type="submit" name="submitexam" value="submitexam" id="finishedbutton" onClick="finished()">Finish</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="row">
          
          <div class="col-sm-12">
            <div class="box outheBoxShadow">
              <div class="box-body outheMargAndBox">
                <div class="box-header bg-white">
                  <h3 class="box-title fontColor">
                    <?=substr($exam_query['title'], 0, 40)?>                         
                  </h3>
                </div>
                <div class="box-body margAndBox" style="">
                    
                  <nav aria-label="Page navigation">
                    <ul class="examQuesBox questionColor">
                      <input type="hidden" value="<?=$exam_query['duration']?>" id="examDuration"/>
                      <input type="hidden" value="<?=$exam_query['total_question']?>" id="totalQuestion"/>
                      <?php for ($i = 1; $i <= $query->num_rows(); $i++) { ?>
                      <li><a class="notvisited" id="question<?=$i?>" href="javascript:void(0);" onClick="jumpQuestion(<?=$i?>)"><?=$i?></a></li>
                      <?php } ?>
                    </ul>
                  </nav>
                  <nav aria-label="Page navigation">
                    <h2>Summary</h2>
                    <ul class="examQuesBox text">
                      <li><a class="answered" id="summaryAnswered" href="#">0</a> Answered</li>
                      <li><a class="marked" id="summaryMarked" href="#">0</a> Marked</li>
                      <li><a class="notanswered" id="summaryNotAnswered" href="#">0</a> Not Answered</li>
                      <li><a class="notvisited" id="summaryNotVisited" href="#">0</a>Not Visited</li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 counterDiv">
            <div class="box outheBoxShadow">
              <div class="box-body outheMargAndBox">
                <div class="box outheBoxShadow">
                  <div class="box-header bg-white">
                   
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-sm-6 padding-md-top">
                        <h3 class="fontColor">Total Time Left</h3>
                      </div>
                    </div>

                    <h3 class="box-title fontColor"> <div id="timerdiv" class="timer"></div></h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 

if (!empty($exam_session_data) && Date('Y-m-d H:i:s') > $exam_session_data['exam_end_at']) { ?>
<script>
  // let form = document.forms[0].submit(); 
</script>
<?php } ?>

