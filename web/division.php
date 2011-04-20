<?php
$title = 'Division';
$current = 'division';
$note = 'Note that these are whole-number division problems. For example, 4 / 3 = 1, not 1.333333....';
$sign = '/';
$displaySign = '&#xF7';

function op($first, $second) {
  return $first / $second;
}

include_once('math/game.php');
