<?php

namespace Lib;

function draw_calendar($month, $year, $data) {
  $headings = array('Week','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
  $month_name = date('F', mktime(0, 0, 0, $month, 10));
  echo "<h2> $month_name $year </h2>";
  echo '<table cellpadding="0" cellspacing="0" class="calendar">';
  echo '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
  foreach ($data as $week => $days) {
    echo "<tr class=\"calendar-row\"><td class=\"week\">$week</td>";
    for($i = 1; $i < 8; $i++) {
      echo array_key_exists($i, $days) ?
        '<td class="calendar-day '.$days[$i]['type'].'"><div class="temperature">'.$days[$i]['DAY_TEMP'].' / '.$days[$i]['NIGHT_TEMP'].'</div><div class="day-number">'.date('j',strtotime($days[$i]['day'])).'</div>'.'</td>'
        : '<td class="calendar-day"></td>';
    }
  }
  echo '</table>';
}
