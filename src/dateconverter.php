<?php

function clientDateToServerDate($date) {
  $date_array = explode("/",$date);
  $day = $date_array[0];
  $month = $date_array[1];
  $year = $date_array[2];
  $result = "$year-$month-$day";
  return $result;
}

function isEmptyDate($date) {
  $result = false;
  if ($date == '0000-00-00') {
    $result = true;
  }
  return $result;
}

?>
