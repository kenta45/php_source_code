<?php

namespace MyApp;


class Calendar {

  public $thisMonth;
  public $thisYearMonth;
  public $prev;
  public $next;
  public $today;


  function __construct(){
    try {

      if (!isset($_GET['t']) ||
          !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
        // code...
        throw new \Exception("Error Processing Request");

      }
      $this->thisMonth = new \DateTime($_GET['t']);


    } catch (\Exception $e) {
      echo $e->getMessage();
      // $this->thisYearMonth = 'this month';
    }

      $this->thisYearMonth = $this->thisMonth->format('F Y');
      $this->prev = $this->getPrev();
      $this->next = $this->getNext();
      $this->today = $this->getTodayYearMonth();


  }


  public function getTodayYearMonth(){
    $today = new \DateTime('today');
    return $todayYearMonth = $today->format('Y-m');
  }

  public function getPrev(){
    $clone = clone $this->thisMonth;
    return $clone->modify('-1 month')->format('Y-m');
  }

  public function getNext(){
    $clone = clone $this->thisMonth;
    return $clone->modify('+1 month')->format('Y-m');
  }


  public function show(){
      $tail = $this->getTail();
      $body = $this->getBody();
      $head = $this->getHead();
      $html = $tail . $body . $head;
      return $html;
  }

  public function getBody(){
    $start = new \DateTime('first day of ' . $this->thisYearMonth);
    $interval = new \DateInterval('P1D');
    $firstDayOfNextMonth = new \DateTime('first day of ' . $this->thisYearMonth . '+1 month');
    $period = new \DatePeriod($start,$interval,$firstDayOfNextMonth);

    $body = "";
    $today = new \DateTime('today');

    foreach ($period as $day) {
      // code...
    if ($day->format('w') % 7 === 0) {  $body .= '</tr><tr>'; }
      $todayClass = ($today->format('Y-m-d') === $day->format('Y-m-d')) ? 'today' : '';
      $body .= sprintf('<td class = "youbi_%d %s">%d</td>',
                      $day->format('w'),
                      $todayClass,
                      $day->format('d'));
    }
    return $body;
  }

  public function getTail(){
    $lastDayofPreviousMonth = new \DateTime('last day of ' . $this->thisYearMonth . '-1 month');
    $tail = "";
    while ($lastDayofPreviousMonth->format('w') < 6) {
      // code...
      $tail = sprintf('<td class = "gray">%d</td>',$lastDayofPreviousMonth->format('d')) . $tail;
      $lastDayofPreviousMonth->sub(new \DateInterval('P1D'));
    }
    return $tail;
  }

  public function getHead(){
    $firstDayOfNextMonth = new \DateTime('first day of ' . $this->thisYearMonth . '+1 month');
    $head = '';
    while ($firstDayOfNextMonth->format('w') > 0) {
      // code...
      $head .= sprintf('<td class = "gray">%d</td>', $firstDayOfNextMonth->format('d'));
      $firstDayOfNextMonth->add(new \DateInterval('P1D'));
    }
    return $head;
  }


}



 ?>
