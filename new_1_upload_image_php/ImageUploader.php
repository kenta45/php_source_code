<?php

namespace MyApp;

class ImageUploader{

  private $_imageFileName;
  private $_imageType;


  public function upload(){

    try {
      //error check
      $this->_validateUpload();
      //type check
      $ext = $this->_validateImageType();

      //save
      $savePath = $this->_save($ext);
      //create thumbnail
      $this->_createThumbnail($savePath);

      //send 'success' to session
      $_SESSION['success'] = 'Upload Done';

    } catch (\Exception $e) {
      $_SESSION['error'] = $e->getMessage();
      exit;
    }

    //redirect
    header('Location: http://' . $_SERVER['HTTP_HOST']);
    exit;

  }


    private function _validateUpload(){
      if (!isset($_FILES['image']) ||
      !isset($_FILES['image']['error'])) {
        throw new \Exception("Upload fails A");
      }

      switch ($_FILES['image']['error']) {
          case UPLOAD_ERR_OK:
          return true;

          case UPLOAD_ERR_INI_SIZE:
          case UPLOAD_ERR_FORM_SIZE:
          throw new \Exception("Image Size Too Large");

          default:
          throw new \Exception("ERR:" . $_FILES['image']['error']);
        }

    }

    private function _validateImageType(){
      $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);

      switch ($this->_imageType) {
        case IMAGETYPE_GIF:
        // code...
        return 'gif';

        case IMAGETYPE_JPEG:
        // code...
        return 'jpeg';

        case IMAGETYPE_PNG:
        // code...
        return 'png';

        default:
        // code...
        throw new \Exception("PNG/JPEG/PNG Only");
      }
    }

    private function _save($ext){
      $this->_imageFileName = sprintf(
        '%s_$s.%s',
        time(),
        sha1(uniqid(mt_rand(),true)),
        $ext
      );

      $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
      $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
      if ($res === false){
        throw new \Exception("Could not upload");

      }

      return $savePath;
    }

    private function _createThumbnail($savePath){
      $imageSize = getimagesize($savePath);
      $width = $imageSize[0];
      $height = $imageSize[1];
      if ($width > THUMBNAIL_WIDTH) {
        // code...
        $this->_createThumbnailMain($savePath,$width,$height);
      }
    }

    private function _createThumbnailMain($savePath,$width,$height){

      // create image resource for thumbnail corresponding to image type
      switch ($this->_imageType) {
        case IMAGETYPE_GIF:
          $srcImage = imagecreatefromgif($savePath);
          break;
        case IMAGETYPE_JPEG:
          $srcImage = imagecreatefromjpeg($savePath);
          break;
        case IMAGETYPE_PNG:
          $srcImage = imagecreatefrompng($savePath);
          break;
        default:

        throw new \Exception("");
      }

      // set thumbnail height and create thumbnail frame

      $thumnailHeight = round($height * THUMBNAIL_WIDTH / $width);
      $thumbnailImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumnailHeight);

      // create thumbnail by copying

      imagecopyresampled($thumbnailImage,$srcImage,0,0,0,0,THUMBNAIL_WIDTH,$thumnailHeight,$width,$height);

      // save thumnail to thumbnai_dir
            switch ($this->_imageType) {
              case IMAGETYPE_GIF:
                $srcImage = imagegif($thumbnailImage,THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
              case IMAGETYPE_JPEG:
                $srcImage = imagejpeg($thumbnailImage,THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
              case IMAGETYPE_PNG:
                $srcImage = imagepng($thumbnailImage,THUMBNAIL_DIR . '/' . $this->_imageFileName);
                break;
              default:

              throw new \Exception("");
            }
    }

    public function getImages(){
      $images = [];
      $files = [];
      $imageDir = opendir(IMAGES_DIR);
      while (false !== ($file = readdir($imageDir))) {
        if ($file === '.' ||
            $file === '..') {
          // code...
          continue;
        }
        $files[] = $file;
        if (file_exists(THUMBNAIL_DIR . '/' . $file)) {
          $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
        }else{
          $images[] = basename(IMAGES_DIR) . '/' . $file;
        }

      }
      array_multisort($files, SORT_DESC, $images);
      return $images;
    }

    public function getResults(){
      $success = null;
      $error = null;

      if (isset($_SESSION['success'])) {
        // code...
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
      }
      if (isset($_SESSION['error'])) {
        // code...
        $success = $_SESSION['error'];
        unset($_SESSION['error']);
      }

      return [$success,$error];
    }


}



 ?>
