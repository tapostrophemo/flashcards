<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
$levels = array(3, 4, 5, 6, 7, 8, 9, 10);
$notes = explode(' ', 'G, A, B, C D E F G A B c d e f g a b c\'');
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

<div id="field" class="rounded">
 <div id="fieldWrapper">
  <a id="close" href="#"><img src="res/x.png" alt="close"/></a>
 <?php $i = 1; foreach ($notes as $note): $id = str_replace(',', '_', $note); ?>
  <pre id="<?=$id?>" class="notedef">
  X: <?=$i++?>

  M: 0
  L: 1/4
  <?=$note?>
  </pre>
 <?php endforeach; ?>
  <input id="answer" type="text" size="1" maxlength="1"/>
  <br/>
  <input id="respond" type="button" value="Answer"/>
  <p><span id="remaining">17</span> problems left</p>
 </div>
</div>

<table id="problems">
<?php foreach ($notes as $row): ?>
 <tr>
 <?php foreach ($notes as $col): ?>
  <td><?=$col?></td>
 <?php endforeach; ?>
 </tr>
<?php endforeach; ?>
</table>

<script type="text/javascript">
abc_plugin["show_midi"] = false;
abc_plugin["hide_abc"] = true;
$(document).ready(function () {
  $("#G_").show();
});
</script>

</body>
</html>

