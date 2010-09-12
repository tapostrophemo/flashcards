<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Addition - Flashcards</title>
<link rel="stylesheet" type="text/css" href="res/style.css"/>
<script type="text/javascript" src="res/jquery-1.4.2.min.js"/></script>
</head>
<body>

<div id="wrapper">
<div id="content">

<h1 id="header">Addition - Flashcards</h1>

<?php
global $current;
$current = 'addition';
include_once('mathnav.php');
?>

<p>In this exercise you will have to complete addition problems. Based on your skill level, several
 of the problems will already be answered. Answer the problems as quickly as you can; try to get
 faster and faster.</p>
<p>The activity begins with a screen that pops-up on the window. Type your answer in the box, then
 press the "Answer" button (tip: pressing the "Enter" key on you keyboard is even faster). The cell
 with that problem will be colored <span class="correct">green if you correctly answer the problem</span>,
 or <span class="incorrect">red if your answer is incorrect</span>.</p>

<p>Choose your skill level:<br/><label>Beginner . . . Intermediate . . . Advanced</label></p>
<?php for ($i = 3; $i <= 10; $i++): ?>
<input type="radio" name="level" value="<?=$i?>"/>
<?php endfor; ?>

<br/><br/>

<div id="field" class="rounded" style="display:none">
 <img src="res/x.png" id="close" alt="close"/>
 <div>
  <p><span id="first">0</span><br/>+ <span id="second">0</p>
  <hr size="2"/>
  <input type="text" size="10" id="answer"/><br/>
  <input type="button" value="Answer" id="respond"/>
  <input type="hidden" value="0" id="correct"/>
  <p><span id="remaining"><?=count($nums)*count($nums)?></span> problems left</p>
 </div>
 <p id="msg"></p>
</div>

<table>
<?php $nums = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10); foreach ($nums as $row): ?>
 <tr>
 <?php foreach ($nums as $col): ?>
  <td id="cell_<?=$row?>_<?=$col?>" class="unanswered">
   <?php printf('%d + %d<hr size="1">%d', $row, $col, $row + $col); ?>
  </td>
 <?php endforeach; ?>
 </tr>
<?php endforeach; ?>
</table>

</div>
</div>

<script type="text/javascript">
function getAnswerCells() {
  return $("td[id^=cell_]");
}

function exposeFreebies(skillFactor) {
  getAnswerCells().each(function (i, node) {
    if (Math.random() > skillFactor) {
      $("#"+node.id).removeClass("unanswered");
    }
  });
}

function resetFreebies() {
  getAnswerCells().each(function (i, node) {
    $("#"+node.id).removeClass("correct");
    $("#"+node.id).removeClass("incorrect");
    $("#"+node.id).addClass("unanswered");
  });
}

function getProblems() {
  return $("td[id^=cell_][class=unanswered]");
}

function getSkillFactor() {
  var level = $("input[name=level][checked]:radio");
  return level ? level.attr("value") / 10 : null;
}

function play(data, current) {
  $("#remaining").text(data.length - current);

  if (current < data.length) {
    $("#answer").val("").focus();
    $("#first").text(data[current].first);
    $("#second").text(data[current].second);
    $("#correct").val(data[current].correct);
    $("#field").fadeIn();

    $("#respond").unbind("click");
    $("#respond").click(function () {
      var cell = $("#cell_"+data[current].first+"_"+data[current].second);
      cell.removeClass("unanswered");
      cell.addClass($("#answer").val() == data[current].correct ? "correct" : "incorrect");

      play(data, current + 1);
    });
  }
  else {
    $("#respond").unbind("click");
    $("#msg").html("<p>You've completed all problems!</p><p>Check your results below.</p>");
    $("#field div").slideUp();
  }
}

function rnd() {
  return 0.5 - Math.random();
}

function startPlay() {
  var skillFactor = getSkillFactor();
  if (skillFactor) {
    exposeFreebies(skillFactor);
    $("#msg").html("");
    $("#field div").slideDown();

    var problems = getProblems();
    $("#remaining").text(problems.length);
    var data = $.map(problems, function (problem, i) {
      var parts = problem.id.split("_");
      return {
        first: parts[1],
        second: parts[2],
        correct: parts[1]*1 + parts[2]*1};
    });
    data.sort(rnd).sort(rnd).sort(rnd).sort(rnd).sort(rnd);

    play(data, 0);
  }
  else {
    alert("Please choose your skill level to start play...");
  }
}

$(document).ready(function () {
  $("input[name=level]").each(function (i, node) {
    $(node).click(function () {
      resetFreebies();
      startPlay();
    });
  });

  $("#answer").keypress(function (event) {
    if (event.keyCode == 13) {
      $("#respond").click();
    }
  });

  $("#close").click(function () {
    $("#field").fadeOut("fast");
  });

  startPlay();
});
</script>

</body>
</html>

