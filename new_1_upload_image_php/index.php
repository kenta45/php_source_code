<?php


require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/ImageUploader.php');

$uploader = new \MyApp\ImageUploader();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // code...
  $uploader->upload();
}

$images = $uploader->getImages();
list($success,$error) = $uploader->getResults();

 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Image Uploader</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div class="container">
      <h1>Upload Your Images</h1>
      <div class="btn">
        Upload!
        <form class="" action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
          <input type="file" name="image">
        </form>
      </div>
      <?php if(isset($success)): ?>
        <div class="msg success">
          <?php echo h($success); ?>
        </div>
      <?php endif ?>
      <?php if(isset($error)): ?>
        <div class="msg success">
          <?php echo h($error); ?>
        </div>
      <?php endif ?>
      <ul>
        <?php foreach($images as $image): ?>
          <li>
            <a href="<?php echo h(basename(IMAGES_DIR)) . '/' . basename($image); ?>">
              <img src = "<?php echo h($image); ?>">
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
      $(function(){
        $('.msg').fadeOut(3000);
      });
    </script>
  </body>
</html>
