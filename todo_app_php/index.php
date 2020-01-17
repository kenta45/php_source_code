<?php

session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Todo.php');

$todoApp = new \MyApp\Todo();
$todos = $todoApp->getAll();




?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>My Todos</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id="container">
      <h1>Todos</h1>
      <form action="" id = "new_todo_form">
        <input type="text" id = "new_todo" placeholder="what needs to be done?">
      </form>
        <ul id = 'todos'>
          <?php foreach($todos as $todo): ?>
            <li id = "todo_template" data-id = "" >
              <input type="checkbox" class="update_todo">
              <span class="todo_title"></span>
              <div class="delete_todo">
                x
              </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <input type="hidden" id="token" value="<?php echo h($_SESSION['token']); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="todo.js"></script>
  </body>
</html>
