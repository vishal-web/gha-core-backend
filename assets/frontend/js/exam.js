$('#reviewbutton').on('click', function () {
  marked = 1;
  $('#questionWizard').wizard('next');
});

$('#clearbutton').on('click', function () {
  clearAnswer();
});

$('#questionWizard').on('actionclicked.fu.wizard', function (evt, data) {

  totalQuestions = parseInt(totalQuestions);
  var steps = 0;
  if (data.direction == "next") {
    steps = data.step + 1;
  } else {
    steps = data.step - 1;
  }

  if (steps == totalQuestions) {
    $('#nextbutton').removeClass('oe-btn-answered');
    $('#nextbutton').addClass('oe-btn-notanswered');
    $('#nextbutton i').remove();
    $('#finishedbutton').hide();
  } else if (steps == totalQuestions + 1) {
    finished();
  } else {
    $('#nextbutton').removeClass('oe-btn-notanswered');
    $('#nextbutton').addClass('oe-btn-answered');
    $('#nextbutton i').remove();
    $('#nextbutton').append(' <i class="fa fa-angle-right"></i>');
    $('#finishedbutton').show();
  }
  NowStep = steps;

  changeColor(data.step);
  summaryUpdate();
});

function summaryUpdate() {
  var summaryNotVisited = $('.questionColor li .notvisited').length;
  var summaryAnswered = $('.questionColor li .answered').length;
  var summaryMarked = $('.questionColor li .marked').length;
  var summaryNotAnswered = $('.questionColor li .notanswered').length;
  $('#summaryNotVisited').html(summaryNotVisited);
  $('#summaryAnswered').html(summaryAnswered);
  $('#summaryMarked').html(summaryMarked);
  $('#summaryNotAnswered').html(summaryNotAnswered);

  document.getElementsByName('answered')[0].value = summaryAnswered;
  document.getElementsByName('marked')[0].value = summaryMarked;
  document.getElementsByName('not_visited')[0].value = summaryNotVisited;
  document.getElementsByName('not_answered')[0].value = summaryNotAnswered;
}

function changeColor(stepID) {
  list = $('#answerForm #step' + stepID + ' input ');
  var have = 0;
  var result = $.each(list, function () {
    elementType = $(this).attr('type');
    if (elementType == 'radio' || elementType == 'checkbox') {
      if ($(this).prop('checked')) {
        have = 1;
        return have;
      }
    } else if (elementType == 'text') {
      if ($(this).val() != '') {
        have = 1;
        return have;
      }
    }
  });
  if (have) {
    $('#question' + stepID).removeClass('notvisited');
    $('#question' + stepID).removeClass('notanswered');
    $('#question' + stepID).removeClass('marked');
    $('#question' + stepID).addClass('answered');
  } else {
    $('#question' + stepID).removeClass('notvisited');
    $('#question' + stepID).removeClass('answered');
    if ($('#question' + stepID).attr('class') != 'marked') {
      $('#question' + stepID).addClass('notanswered');
    }
  }

  if (marked) {
    marked = 0;
    if ($('#question' + stepID).attr('class') != 'answered') {
      $('#question' + stepID).removeClass('notvisited');
      $('#question' + stepID).removeClass('notanswered');
      $('#question' + stepID).addClass('marked');
    }
  }
}

function jumpQuestion(questionNumber) {
  changeColor(NowStep);
  NowStep = questionNumber;
  $('#questionWizard').wizard('selectedItem', {
    step: questionNumber
  });
  changeColor(questionNumber);
  if (questionNumber == totalQuestions) {
    $('#nextbutton').removeClass('oe-btn-answered');
    $('#nextbutton').addClass('oe-btn-notanswered');
    $('#nextbutton i').remove();
    $('#finishedbutton').hide();
  } else {
    $('#nextbutton').removeClass('oe-btn-notanswered');
    $('#nextbutton').addClass('oe-btn-answered');
    $('#nextbutton i').remove();
    $('#nextbutton').append(' <i class="fa fa-angle-right"></i>');
    $('#finishedbutton').show();
  }
  summaryUpdate();
}

function clearAnswer() {
  list = $('#answerForm #step' + NowStep + ' input ');
  $.each(list, function () {
    elementType = $(this).attr('type');
    switch (elementType) {
      case 'radio':
        $(this).prop('checked', false);
        break;
      case 'checkbox':
        $(this).attr('checked', false);
        break;
      case 'text':
        $(this).val('');
        break;
    }
  });
  if ($('#question' + NowStep).attr('class') == 'marked') {
    $('#question' + NowStep).removeClass('marked');
    $('#question' + NowStep).addClass('notanswered');
  }
}

function finished() {
  summaryUpdate();
  $('#answerForm').submit();
}

function counter() {
  interval = setInterval(function () {
    durationUpdate();
    $('#timerdiv').html(((hours < 10) ? '0' + hours : hours) + ':' + ((minutes < 10) ? '0' + minutes : minutes) + ':' + ((seconds < 10) ? '0' + seconds : seconds));
    duration = (hours * 60) + minutes;
  }, 1000);
}

function durationUpdate() {
  hours = 0;
  minutes = duration;
  if (minutes > 60) {
    hours = parseInt(duration / 60, 10);
    minutes = duration % 60;
  }
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  if (minutes < 0 && hours != 0) {
    --hours;
    minutes = 59;
  }

  if (hours < 0) {
    hours = 0;
  }

  seconds = (seconds < 0) ? 59 : seconds;
  if (minutes < 0 && hours == 0) {
    minutes = 0;
    seconds = 0;
    finished();
    clearInterval(interval);
  }
}

function timeString() {
  return ((hours < 10) ? '0' + hours : hours) + ':' + ((minutes < 10) ? '0' + minutes : minutes) + ':' + ((seconds < 10) ? '0' + seconds : seconds);
}

var duration = parseInt(document.getElementById('examDuration').value);
var totalQuestions = parseInt(document.getElementById('totalQuestion').value);
var seconds = 0;
var hours = 0;
var minutes = -1;
var NowStep = 1;
var marked = 0;
var interval = 0;
var end = atob(document.getElementById('end').value);
var start = new Date();
var result = (parseInt(new Date(end) - start) / 1000);
var totalMinute = Math.floor(result / 60);
var totalSecond = Math.floor(result % 60); 
seconds = totalSecond > 0 ? totalSecond : seconds;
duration = totalMinute > 0 ? totalMinute : 0;

var calculate = (totalMinute * 60 ) + seconds;

console.log('start', start, 'end', end,'totalMinute', totalMinute, 'totalSecond', totalSecond);

durationUpdate();
// $('.duration').html(timeString());
if (duration != 0) {
  counter();
} else {
  finished();
  $('.counterDiv').hide();
}
summaryUpdate();

$('.sidebar-menu li a').css('pointer-events', 'none');

function disableF5(e) {
  if (((e.which || e.keyCode) == 116) || (e.keyCode == 82 && e.ctrlKey)) {
    e.preventDefault();
  }
}

// $(document).bind("keydown", disableF5);

function Disable(event) {
  if (event.button == 2) {
    window.oncontextmenu = function () {
      return false;
    }
  }
}

// document.onmousedown = Disable;

if (totalQuestions == 1) {
  $('#nextbutton').removeClass('oe-btn-answered');
  $('#nextbutton').addClass('oe-btn-notanswered');
  $('#nextbutton i').remove();
  $('#finishedbutton').hide();
}