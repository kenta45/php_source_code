<?php


spl_autoload_register(function($class){
  $prefix = 'MyApp\\';

  if (strpos($class, $prefix) === 0) {
    // code...
    $className = substr($class, strlen($prefix));
    $classFilePath = __DIR__ . '/' . $className . '.php';

    if (file_exists($classFilePath)) {
      // code...
      require $classFilePath;
    }else {
      echo 'No such class: ' . $className;
      exit;
    }
  }

});
