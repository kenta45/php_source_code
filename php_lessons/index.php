<?php

$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // code...
    $err = false;

  $username = $_POST['username'];
  if (strlen($username) > 8 ) {
    // code...
    $err = true;
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Check username</title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="user name" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Check!">
    <?php if ($err) {
      // code...
      echo 'too long';
    } ?>
  </form>
</body>
</html>
