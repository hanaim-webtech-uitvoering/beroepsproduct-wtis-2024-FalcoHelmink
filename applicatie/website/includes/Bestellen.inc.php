<?php

require_once '../db_connectie.php';
require_once '../function.php';
session_start();
$db = maakVerbinding();

if (isset($_POST["submit"])) {
    $username   = $_POST["username"];
    $clientname = $_POST["clientname"];
    $address    = $_POST["Adres"];
    $products = [];

    if (!dubbelUsername($db, $username)) {
    header("Location: ../BestelPagina.php?error=usernameNietGevonden");        exit;
    }

    for ($i = 0; $i < 3; $i++) {
        if (!empty($_POST['productname'][$i]) && !empty($_POST['quantity'][$i])) {
            $products[] = [
                'name'     => $_POST['productname'][$i],
                'quantity' => (int)$_POST['quantity'][$i]
            ];
        }
    }

    addOrder($db, $username, $clientname, $products,$address);

    unset($_SESSION['product_count'])
}  
?>
