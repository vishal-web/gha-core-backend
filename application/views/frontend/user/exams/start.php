<div class='default-padding'>
  <div class='container'>
    <div class="col-sm-7 fu-example section ">
      <div class="box outheBoxShadow wizard bg-light" data-initialize="wizard" id="questionWizard">
        <div class="steps-container bg-light">
          <ul class="steps hidden" style="margin-left: 0">
            <?php for ($i = 1; $i <= $query->num_rows(); $i++) { ?>
            <li data-step="<?=$i?>" class="<?=$i == 1 ? 'active' : ''?>"></li>
            <?php } ?>
          </ul>
        </div>
        <form id="answerForm" method="post">
          <div class="box-body step-content">
            <input style="display:none" type="text" name="studentfinishstatus">
            <?php
              $total_count = $query->num_rows();
              $counter = 1;
              foreach ($query->result_array() as $key => $row) {
            ?> 
            <div class="clearfix step-pane sample-pane active" data-questionID="10" data-step="1">
              <div class="question-body">
                <label class="lb-title">Question <?=$counter?> of <?=$total_count?></label>
                <label class="lb-content">
                  <?=$row['question_title']?>
                </label>
                <label class="lb-mark"> 1 Mark </label>
              </div>
              <div class="question-answer" id="step<?=$counter?>">
                <table class="table">
                  <tr>
                    <td>
                      <input id="option91" value="91" name="answer[1][10][]" type="radio">
                      <label for="option91">
                      <span class="fa-stack radio-button">
                      <i class="active fa fa-check">                                                            </i>                                                        </span>
                      <span >   Muslim League</span>                                                                                                            </label>                                                
                    </td>
                    <td>
                      <input id="option92" value="92" name="answer[1][10][]" type="radio">
                      <label for="option92">
                      <span class="fa-stack radio-button">
                      <i class="active fa fa-check">                                                            </i>                                                        </span>
                      <span >   Awami League</span>                                                                                                            </label>                                                
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input id="option93" value="93" name="answer[1][10][]" type="radio">
                      <label for="option93">
                      <span class="fa-stack radio-button">
                      <i class="active fa fa-check">                                                            </i>                                                        </span>
                      <span >   Pakistan People's Party</span>                                                                                                            </label>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <?php ++$counter; } ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>