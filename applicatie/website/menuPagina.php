<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  
</head>
<?php 
  navbar();
  Errors()
  ?>

<body>
  <h1>MENU</h1>
  <?php 
  echo ($html_table2);
  ?>
<?php Footer() ?>
</body>
</html>