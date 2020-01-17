<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/ImageUploader.php');

$uploader = new \MyApp\ImageUploader();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // code...
  $uploader->upload();
}

$images = $uploader->getImages();



 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Uploader</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>Upload Your Images !</h1>
    <div class="container">
      <div class="btn">
        <p>Upload!</p>
        <form method="post" enctype="multipart/form-data" id="my_form">
          <input type="file" name="image" id='my_file'>
          <input type="hidden" name="MAX_FILE_SIZE" value="">
        </form>
      </div>
      <?php foreach ($images as $image): ?>
        <li>
          <a href="<?php basename(IMAGES_DIR) . '/' . basename($image); ?>">
            <img src="<?php echo h($image); ?>">
          </a>
        </li>
      <?php endforeach; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script>
    $(function() {
      $('.msg').fadeOut(3000);
      $('#my_file').on('change', function() {
        $('#my_form').submit();
      });
    });
    </script>
  </body>
</html>
