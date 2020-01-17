<?php



require_once(__DIR__ . '/../config/config.php');

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id="container">
      <form action="" method="post">
        <p>
          <input type="text" name="email" placeholder="email">
        </p>
        <p>
          <input type="text" name="password" placeholder="password">
        </p>
        <div class="btn">
          Log In
        </div>
        <p><a class="fs12" href="/signup.php">Sign Up</a></p>
      </form>
    </div>
  </body>
</html>
