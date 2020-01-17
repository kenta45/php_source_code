<?php

namespace MyApp;

class Todo {
  private $_db;

  public function __construct() {
    $this->_createToken();
    try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  public function getAll() {
    $stmt = $this->_db->query("select * from todos order by id desc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function post(){
    $this->_validateToken();
    if (!isset($_POST['mode'])) {

      // code...
      throw new Exception("Mode not set");

    }

      switch ($_POST['mode']) {
        case 'update':
          // code...
          return $this->_update();

        case 'create':
          // code...
          return $this->_create();

        case 'delete':
          // code...
          return $this->_delete();

      }




  }


  private function _update() {
    if (!isset($_POST['id'])) {
      throw new \Exception('[update] id not set!');
    }

    $this->_db->beginTransaction();

    $sql = sprintf("update todos set state = (state + 1) %% 2 where id = %d", $_POST['id']);
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();

    $sql = sprintf("select state from todos where id = %d", $_POST['id']);
    $stmt = $this->_db->query($sql);
    $state = $stmt->fetchColumn();

    $this->_db->commit();

    return [
      'state' => $state
    ];

  }

    private function _create(){
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
    private function _delete(){

      if (!isset($_POST['id'])) {
        throw new \Exception('[update] id not set!');
      }


      $sql = sprintf("delete from todos where id = %d", $_POST['id']);
      $stmt = $this->_db->prepare($sql);
      $stmt->execute();


      return [];


  }


    private function _createToken(){
      if (!(isset($_SESSION['token']))) {
        // code...
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
      }
    }


    private function _validateToken(){
      if (
          !isset($_POST['token']) ||
          !isset($_SESSION['token'])||
          $_POST['token'] !== $_SESSION['token']) {

          throw new \Exception("Invalid Token");

      }
    }

}