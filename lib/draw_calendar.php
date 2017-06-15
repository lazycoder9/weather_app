<?php

namespace Lib;

function draw_calendar($month, $year, $data) {
  $month_name = date('F', mktime(0, 0, 0, $month, 10));
  echo "<h2> $month_name $year </h2>";
  echo '<table cellpadding="0" cellspacing="0" class="calendar">';
  echo draw_calendar_header();
  foreach ($data as $week => $days) {
    echo '<tr class="calendar-row"><td class="week">'.$week.'</td>';
    for($i = 1; $i < 8; $i++) {
      echo draw_calendar_day($days, $i);
    }
  }
  echo '</table>';
}

function draw_calendar_header() {
  $headings = array('Week','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
  $header_map = array_map(function($week_day) {
    return '<td class="calendar-day-head">'.$week_day.'</td>';
  }, $headings);

  return '<tr class="calendar-row">'.implode('', $header_map).'</tr>';
}

function draw_calendar_day($daily_data, $day_number) {
  if (array_key_exists($day_number, $daily_data)) {
    $data_type = $daily_data[$day_number]['type'];
    $temperature_data = $daily_data[$day_number]['DAY_TEMP'].' / '.$daily_data[$day_number]['NIGHT_TEMP'];
    $day_number = date('j',strtotime($daily_data[$day_number]['day']));
    return '<td class="calendar-day '.$data_type.'"><div class="temperature">'.$temperature_data.'</div><div class="day-number">'.$day_number.'</div></td>';
  } else {
    return '<td class="calendar-day"></td>';
  }
}
