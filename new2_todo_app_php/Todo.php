<?php

namespace MyApp;

class Todo {

  private $_db;

  function __construct(){

    $this->_createToken();

    try {
      $this->_db = new \PDO(DSN,DB_USERNAME,DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }


  }

  public function getAll(){
    $sql = "select * from todos order by id desc";
    $stmt = $this->_db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post(){
    $this->_validateToken();
    if (!isset($_POST['mode'])) {
      throw new \Exception("Mode Not Set");
    }

    switch ($_POST['mode']) {
      case 'update':
        return $this->_update();

      case 'delete':
        return $this->_delete();

      case 'create':
        return $this->_create();
    }

  }

  private function _update(){
    if (!isset($_POST['id'])) {
      throw new \Exception("[update] id not set");
    }
    $this->_db->beginTransaction();
      $sql = sprintf('update todos set state = ( state + 1 ) %% 2 where id = %d ',$_POST['id']);
      $stmt = $this->_db->prepare($sql);
      $stmt->execute();

      $sql = sprintf('select state from todos where id = %d ',$_POST['id']);
      $stmt = $this->_db->query($sql);
      $state = $stmt->fetchColumn();
    $this->_db->commit();

    return [
      'state' => $state
    ];

  }


  public function _createToken(){
    if (!isset($_SESSION['Token'])) {
      $_SESSION['Token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  public function _validateToken(){
    if (!isset($_POST['Token'])||
        !isset($_SESSION['Token'])||
        $_SESSION['Token'] !== $_POST['Token'])
        // code...
        throw new \Exception("Invalid Token");

  }

  public function _delete(){
    if (!isset($_POST['id'])) {
      throw new \Exception("[delete] id not set");
    }
      $sql = sprintf('delete from todos where id = %d ',$_POST['id']);
      $stmt = $this->_db->prepare($sql);
      $stmt->execute();

      return [];
  }

  public function _create(){
    if (!isset($_POST['title']) || $_POST['title'] === '') {
      throw new \Exception('[create] title not set!');
    }

    $sql = "insert into todos (title) values (:title)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([':title' => $_POST['title']]);

    return [
      'id' => $this->_db->lastInsertId()
    ];
  }


}





 ?>
