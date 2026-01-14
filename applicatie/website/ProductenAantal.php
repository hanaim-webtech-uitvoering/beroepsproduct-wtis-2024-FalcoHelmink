<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();
?>
<!DOCTYPE html>
<html>
<body>
   <?php 
   Navbar();
   Errors();
?>
  
    <h2>Selecteer het aantal verschillende producten dat u wilt bestellen</h2>
    <form method="POST" action="BestelPagina.php">
        <label>aantal productens:</label>
        <input type="number" name="product_count" min="1" max="20" required>
        <input type="submit" value="Next">
    </form>
</body>
</html>