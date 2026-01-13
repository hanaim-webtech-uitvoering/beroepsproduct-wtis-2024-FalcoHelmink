<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();

if (!isset($_SESSION['Rol']) || $_SESSION['Rol'] !== 'personnel') {
    header("Location: menuPagina.php");
    echo "Alleen toegang voor personeel" ;
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <?php navbar(); ?>
</head>

<body>
  <h1>Orders</h1>
  <?php 
  echo ($html_table3);
  ?>
<?php Footer() ?>
</body>
</html>