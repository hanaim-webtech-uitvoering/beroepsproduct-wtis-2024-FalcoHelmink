<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();

if (!isset($_SESSION['username']) ) {
header("location:menuPagina.php?error=geenToegangAccount"); 
exit();
}
$html_table5 = TabelAccountInfo(($_SESSION['username']), $db);
$html_table6 = TabelAccountOrders($_SESSION['username'], $db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <?php 
  navbar();
  ?>
</head>


<body>
  <h1>Account </h1>
  <?php 
  echo ($html_table5);
  ?>
  <h2>bestelling historie </h2> <?php 
  echo ($html_table6);
  ?> 
<?php Footer() ?>
</body>
</html>