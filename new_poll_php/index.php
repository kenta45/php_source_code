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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // code...
  $poll->post();
}


$err = $poll->getError();


 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Poll</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php if (isset($err)): ?>
      <div class="error">
        <?php echo h($err); ?>
      </div>
    <?php endif ?>
    <h1>Which do you like the best?</h1>
    <form class="" action="" method="post">
      <div class="container">
        <div class="box" id="box_0" data-id="0"></div>
        <div class="box" id="box_1" data-id="1"></div>
        <div class="box" id="box_2" data-id="2"></div>
        <input type="hidden" id="answer" name="answer" value="">
        <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
      </div>
      <div id="btn" class="btn">Vote and See Results</div>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="poll.js"></script>
  </body>
</html>
