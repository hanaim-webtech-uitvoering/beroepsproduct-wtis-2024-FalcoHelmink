<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();

if (isset($_POST['product_count'])) {
    $product_count = (int)$_POST['product_count'];
$_SESSION['product_count'] = $product_count;
} elseif (isset($_SESSION['product_count'])) {
    $product_count = $_SESSION['product_count'];
}   else {
    header("Location: ProductenAantal.php?error=geenAantal");
    exit;
}

?>
<!DOCTYPE html>
<html>
<body>
<?php
Navbar();
Errors();
?>

<h2>Bestel uw producten</h2>
<h3>Om misbruik te voorkomen wordt er een maximaal aantal van 5 per product gehanteerd </h3>
<h3>Bij verdenking van misbruik wordt de bestelling geanuleerd. Misbruik kan worden bestraft.</h3>
<h5>Om annulering te voorkoemn raden wij aan om grote bestellingen telefonisch te bestellen. een bestelling van meer dan 7 pizza's wordt beschouwd als groot</h5>
<form method="POST" action="Includes/Bestellen.inc.php">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>

    <label>Voor + achternaam:</label><br>
    <input type="text" name="clientname" required><br>

    <label>Adres:</label><br>
    <input type="text" name="Adres" placeholder="bakkerstraat 4 Amsterdam, 1234AB"required><br><br>

<?php
dynamischBestel($db, $product_count); 
?>

<input type="submit" name="submit" value="Add Order">

 <?php 
 Footer(); 
 ?>
</body>
</html>
