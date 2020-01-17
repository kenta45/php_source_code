<?php

require_once(__DIR__ . '/Calendar.php');
require_once(__DIR__ . '/functions.php');

$cal = new \MyApp\Calendar();

$html = $cal->show();


 ?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Calendar</title>
  </head>
  <link rel="stylesheet" href="styles.css">
  <body>
    <div class="container">
      <table>
        <thead>
          <tr>
            <th colspan="2"><a href="/?t=<?php echo h($cal->prev); ?>">&laquo;</a></th>
            <th colspan="3"><p><?php echo h($cal->thisYearMonth); ?></p></th>
            <th colspan="2"><a href="/?t=<?php echo h($cal->next); ?>">&raquo;</a></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>SUN</td>
            <td>MON</td>
            <td>TUE</td>
            <td>MED</td>
            <td>THU</td>
            <td>FRI</td>
            <td>SAT</td>
          </tr>
          <tr>
            <?php echo $html; ?>
            <!-- <td class="youbi_0">1</td>
            <td class="youbi_1">2</td>
            <td class="youbi_2">3</td>
            <td class="youbi_3">4</td>
            <td class="youbi_4">5</td>
            <td class="youbi_5 today">6</td>
            <td class="youbi_6">7</td>
          </tr>
          <tr>
            <td class="youbi_0">29</td>
            <td class="youbi_1">30</td>
            <td class="youbi_2">31</td>
            <td class="gray">1</td>
            <td class="gray">2</td>
            <td class="gray">3</td>
            <td class="gray">4</td> -->
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th colspan = "7" >
              <a class="" href="/?t=<?php echo h($cal->today); ?>">Today</a>
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
  </body>
</html>
