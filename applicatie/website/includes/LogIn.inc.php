<?php
require_once '../db_connectie.php';
require_once '../function.php';
$verbinding = maakVerbinding();

if(isset($_POST["submit"])){

$username = $_POST["Username"];
$wachtwoord = $_POST["wachtwoord"];

if (emptyInputLogIn($username,$wachtwoord)!== false){ 
header("location:../LogIn.php?error=emptyinput"); 
exit();
}

loginUser($verbinding,$username,$wachtwoord);
}else { 
   header("location:../Login.php"); 
   exit();
}