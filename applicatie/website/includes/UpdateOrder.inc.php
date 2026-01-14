<?php
require_once '../db_connectie.php';
require_once '../function.php';
$verbinding = maakVerbinding();
session_start();

if (!isset($_SESSION['Rol']) || $_SESSION['Rol'] !== 'personnel') {
header("location:../menuPagina.php?error=geenToegang"); 
exit();
}
$newStatus = $_POST["status"];
$order_id = $_POST["order_id"];

ChangeStatus($verbinding,$newStatus, $order_id);
header('location:../OrderPagina.php?Status-changed');