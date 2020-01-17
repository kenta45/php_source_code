<?php

namespace MyApp;

class Controller {


  private $_errors;

  public function __construct(){
    $this->errors = new \stdClass();
  }

  protected function setErrors($key, $error){

  }

  protected function isLoggedIn() {
    // $_SESSION['me']
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

}
