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
<head>
    <title>Order Products</title>
</head>
<body>
<?php
Navbar();
Errors();
?>

<h2>Order Your Products</h2>
<form method="POST" action="Includes/Bestellen.inc.php">
    <label>Username:</label><br>
    <input type="text" name="username" required><br>

    <label>Client Name:</label><br>
    <input type="text" name="clientname" required><br>

    <label>Address:</label><br>
    <input type="text" name="Adres" required><br><br>

<?php




require_once 'db_connectie.php';
$db = maakVerbinding();

$stmt = $db->query("SELECT name FROM Product");
$all_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < $product_count; $i++):
?>
    <label>Product <?php echo $i + 1; ?>:</label><br>
    <select name="productname[]" required>
        <option value="">-- Choose product --</option>
        <?php foreach ($all_products as $p): ?>
            <option value="<?php echo htmlspecialchars($p['name']); ?>">
                <?php echo htmlspecialchars($p['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Quantity:</label>
    <input type="number" name="quantity[]" min="1" value="1" required><br><br>
<?php endfor; ?>

<input type="submit" name="submit" value="Add Order">

   
</body>
</html>
