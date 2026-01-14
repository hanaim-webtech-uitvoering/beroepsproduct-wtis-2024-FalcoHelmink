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
<form method="POST" action="Includes/Bestellen.inc.php">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>

    <label>Client Name:</label><br>
    <input type="text" name="clientname" required><br>

    <label>Address:</label><br>
    <input type="text" name="Adres" placeholder="bakkerstraat 4 Amsterdam, 1234AB"required><br><br>

<?php
dynamischBestel($db, $product_count); 
?>

<input type="submit" name="submit" value="Add Order">

   
</body>
</html>
