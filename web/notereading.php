<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
define('NUM_ROWS', 3);

$levels = array(3, 4, 5, 6, 7, 8, 9, 10);
$notes = explode(' ', 'G, A, B, C D E F G A B c d e f g a b c\'');

function safeCssId($str) {
  return str_replace("'", '_', str_replace(',', '_', $str));
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Note Reading - Flashcards</title>
<link rel="stylesheet" type="text/css" href="res/style.css"/>
<script type="text/javascript" src="res/jquery-1.4.2.min.js"/></script>
<script type="text/javascript" src="res/abcjs_plugin-nojquery_1.0.2-min.js"></script>
<style type="text/css">
.notedef {
  width: 115px;
  overflow: hidden;
  display: none;
  background-color: white;
  border-right: 15px solid white;
  margin: 30px auto;
}
.abctext {
  display: none ! important;
}
</style>
</head>
<body>

<div id="wrapper">
<div id="content">

<h1 id="header">Note Reading - Flashcards</h1>

<ul id="nav">
 <li><a href="index.html">Home</a></li>
 <li class="current"><a href="notereading.php">Note Reading</a></li>
</ul>

<div class="clearing"></div>

<p>In this game you will ... read musical notes ...</p>

<p>Choose your skill level:</p>
<p><label>Beginner . . . Intermediate . . . Advanced</label><br/>
<?php foreach ($levels as $level): ?>
 <input type="radio" name="level" value="<?=$level?>"/>
<?php endforeach; ?>
</p>
<p>The timer starts when you answer the first question.</p>

<div id="field" class="rounded" style="display:none">
 <div id="fieldWrapper">
  <a href="#" id="close"><img src="res/x.png" alt="close"/></a>
  <div>
  <?php $i = 1; foreach ($notes as $note): ?>
   <pre id="<?=safeCssId($note)?>" class="notedef">
   X: <?=$i++?>

   M: 0
   L: 1/4
   <?=$note?>
   </pre>
  <?php endforeach; ?>
   <input id="answer" type="text" size="1" maxlength="1"/>
   <br/>
   <input id="respond" type="button" value="Answer"/>
   <p><span id="remaining">0</span> problems left</p>
  </div>
  <p id="msg"></p>
 </div>
</div>

<table id="problems">
<?php for ($row = 0; $row < NUM_ROWS; $row++): ?>
 <tr>
 <?php foreach ($notes as $n): ?>
  <?php
  $letter = strtolower(substr($n, 0, 1));
  $noteid = $letter . $row . safeCssId($n);
  ?>
  <td id="<?=$noteid?>"><?=$letter?></td>
 <?php endforeach; ?>
 </tr>
<?php endfor; ?>
</table>

<script type="text/javascript">
function getAnswerCells() {
  return $("#problems td");
}

function exposeFreebies(skillFactor) {
  getAnswerCells().each(function (i, node) {
    if (Math.random() > skillFactor) {
      $("#"+node.id).removeClass("unanswered");
    }
  });
}

function reset() {
  getAnswerCells().each(function (i, node) {
    $("#"+node.id).removeClass("correct").removeClass("incorrect");
    $("#"+node.id).addClass("unanswered");
  });
  $("#msg").html("");
  $("[class=yourAnswer]").remove();
  $("#field div").slideDown();
  $("#problems").animate({opacity:0}, 200);
}

function play(data, current) {
  $("#remaining").text(data.length - current);
  $("#respond").unbind("click");
  $(".notedef").hide();

  if (current < data.length) {
    $("#"+data[current].visid).fadeIn("fast");
    $("#answer").val("").focus();

    $("#respond").click(function () {
      var cell = $("#"+data[current].id);
      cell.removeClass("unanswered");
      var yourAnswer = $("#answer").val();
      if (yourAnswer.toLowerCase() == data[current].correct) {
        cell.addClass("correct");
      }
      else {
        cell.addClass("incorrect");
        cell.append('<div class="yourAnswer">' + yourAnswer + '</div>');
      }

      if (!data.timer) {
        data.timer = new Date();
      }

      play(data, current + 1);
    });
  }
  else {
    $("#fieldWrapper div").slideUp();

    var seconds = ((new Date()) - data.timer) / 1000;
    var msg = "<p>Finished! You completed " + data.length + " problems in " + seconds + " seconds.</p>";
    msg += "<p>Close this window and check your answers.</p>";
    $("#msg").html(msg);
    $("#problems").animate({opacity:1}, 400);
  }
}

function rnd() {
  return 0.5 - Math.random();
}

function getSkillFactor() {
  var level = $("input[name=level][checked]:radio");
  return level ? level.attr("value") / 10 : null;
}

function startPlay() {
  var skillFactor = getSkillFactor();
  if (skillFactor) {
    exposeFreebies(skillFactor);

    var problems = $("#problems td[class=unanswered]");
    var data = $.map(problems, function (problem, i) {
      return {
        id: problem.id,
        visid: problem.id.split(/\d/)[1],
        correct: problem.id.substr(0, 1)};
    });
    data.sort(rnd).sort(rnd).sort(rnd).sort(rnd).sort(rnd);
    data.timer = null;

    $("#field").fadeIn();
    play(data, 0);
  }
  else {
    alert("Please choose your skill level to start play...");
  }
}

abc_plugin["show_midi"] = false;
abc_plugin["hide_abc"] = true;

$(document).ready(function () {
  $("input[name=level]").each(function (i, node) {
    $(node).click(function () {
      reset();
      startPlay();
    });
  });

  $("#answer").keypress(function (event) {
    if (event.keyCode == 13) {
      $("#respond").click();
    }
  });

  $("#close").click(function (event) {
    event.preventDefault();
    $("#field").fadeOut("fast");
  });

  startPlay();
});
</script>

</body>
</html>

