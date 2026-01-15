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
    <h3>Bestellingen met meer dan 8 verschillende items dienen 2 uur van te voren per telefoon te worden besteld. <br></h3>
    <form method="POST" action="BestelPagina.php">
        <label>aantal producten:</label>
        <input type="number" name="product_count" min="1" max="8" required>
        <input type="submit" value="Next">
    </form>
<?php 
    Footer(); 
?>
</body>
</html>