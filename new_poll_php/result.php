<?php


require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Poll.php');

try {
  $poll = new \MyApp\Poll();
} catch (\Exception $e) {
  echo $e->getMessage();
  exit;
}

$results = $poll->getResults();



 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Poll Result</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>Results ...</h1>
      <div class="container">
        <?php for ($i=0; $i < 3; $i++):?>
        <div class="box" id="box_<?php echo h($i)?>"><?php echo h($results[$i]) ?></div>
      <?php endfor ?>
      </div>
      <a href="/">
        <div id="btn" class="btn">Go Back</div>
      </a>
  </body>
</html>
