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
 
  <?php navbar(); ?>
</head>

<body>
  <h1>Orders</h1>
  <?php 
  echo ($html_table4);
  ?>
  <br>
<form action="includes/UpdateOrder.inc.php" method="POST">
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
  <label for="status">nieuw status:</label>
    <select name="status" id="status">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
    <br>
  <input name= "submit" type="submit" value="Submit">
</form>

<?php Footer() ?>
</body>
</html>