<?php
global $current;
?>

<ul id="nav">
 <li><a href="index.html">Home</a></li>
 <li<?=$current == 'addition' ? ' class="current"' : ''?>><a href="addition.php">Addition</a></li>
 <li<?=$current == 'subtraction' ? ' class="current"' : ''?>><a href="subtraction.php">Subtraction</a></li>
 <li<?=$current == 'multiplication' ? ' class="current"' : ''?>><a href="multiplication.php">Multiplication</a></li>
 <li<?=$current == 'division' ? ' class="current"' : ''?>><a href="division.php">Division</a></li>
</ul>

<div class="clearing"></div>

