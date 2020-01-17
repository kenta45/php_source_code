<?php

namespace MyApp;

class ImageUploader{

  private $_imageType;
  private $_imageFileName;

  public function upload(){

    try {

      //error check
      $this->_validateUpload();

      //type check
      $ext = $this->_validateCheck();

      //save
      $savePath = $this->_save($ext);

      //create thumnail
      $this->_createThumbnail($savePath);

      //send session success


    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  private function _validateUpload(){
    if (!isset($_FILES['image']) ||
        !isset($_FILES['image']['error'])) {
      // code...
      throw new \Exception("Select Image");

    }
    switch ($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception("Image Size Too Large");
      default:
        throw new \Exception("Err" . $_FILES['image']['error']);

        break;
    }
  }

  private function _validateCheck(){
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch ($this->_imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_PNG:
        return 'png';
      case IMAGETYPE_JPEG:
        return 'jpeg';
      default:
        throw new \Exception("gif/png/jpeg ONLY");
      }

    }

    private function _save($ext){
      $this->_imageFileName = sprintf('%s_%s.%s',
                        time(),
                        sha1(uniqid(mt_rand(),true)),
                        $ext);

      $savePath = IMAGES_DIR . '/' . $this->_imageFileName;
      $res = move_uploaded_file($_FILES['image']['tmp_name'],$savePath);

      if ($res === false) {
        // code...
        throw new \Exception("Cannot Save Image");

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
      switch ($this->_imageType) {
        case IMAGETYPE_GIF:
          $srcImage = imagecreatefromgif($savePath);
          break;
        case IMAGETYPE_PNG:
          $srcImage = imagecreatefrompng($savePath);
          break;
        case IMAGETYPE_JPEG:
          $srcImage = imagecreatefromjpeg($savePath);
          break;
        }

      $thumnailHeight = round($height * THUMBNAIL_WIDTH / $width);
      $thumbnailImage = imagecreatetruecolor($width,$thumnailHeight);

      imagecopyresampled($thumbnailImage,$srcImage,0,0,0,0,THUMBNAIL_WIDTH,$thumnailHeight,$width,$height);

      switch ($this->_imageType) {
        case IMAGETYPE_GIF:
          $srcImage = imagegif($thumbnailImage, THUMBNAIL_DIR . $this->_imageFileName);
          break;
        case IMAGETYPE_PNG:
        $srcImage = imagepng($thumbnailImage, THUMBNAIL_DIR . $this->_imageFileName);
          break;
        case IMAGETYPE_JPEG:
        $srcImage = imagejpeg($thumbnailImage, THUMBNAIL_DIR . $this->_imageFileName);
          break;
        }

    }


    public function getImages(){
      $images = [];
      $files = [];
      $imageDir = opendir(IMAGES_DIR);
      while (false !== ($file = readdir($imageDir))) {
        // code...
        if ($file === '.' ||
            $file === '..') {
          // code...
          continue;
        }

        $files[] = $file;

        if (file_exists(THUMBNAIL_DIR . '/' . $file)) {
          // code...
        }
      }
    }





}


 ?>
