<?php

// New2

session_start();

require_once( __DIR__ . '/' .'config.php');
require_once( __DIR__ . '/' .'functions.php');
require_once( __DIR__ . '/' .'Todo.php');


$todoApp = new \MyApp\Todo();

$todos = $todoApp->getAll();

 ?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>My Todo List</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div class="container">
      <h1>Todos</h1>
      <form action="" id="new_todo_form" method="post">
        <input id="new_todo" class="textarea" type="text" placeholder="What you need to do ?">
      </form>
      <ul id="todos">
        <?php foreach ($todos as $todo):?>
        <li id="todo_<?php echo h($todo->id);?>" data-id="<?php echo h($todo->id);?>">
          <input class="update_todo" type="checkbox" <?php if($todo->state === '1') {echo 'checked';} ?>>
          <span class="todo_title <?php if($todo->state === '1') {echo 'done';} ?>">
              <?php echo h($todo->title); ?>
          </span>
          <div class="delete_todo">x</div>
        </li>
      <?php endforeach; ?>
      <li id="todo_template" data-id="">
        <input class="update_todo" type="checkbox" <?php if($todo->state === '1') {echo 'checked';} ?>>
        <span class="todo_title"></span>
        <div class="delete_todo">x</div>
      </li>
      </ul>
    </div>
    <input type="hidden" id="Token" name="Token" value="<?php echo h($_SESSION['Token']); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="todo.js"></script>
  </body>
</html>
