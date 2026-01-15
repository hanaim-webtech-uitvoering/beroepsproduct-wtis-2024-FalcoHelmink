  <?php
require_once '../db_connectie.php';
require_once '../function.php';
$verbinding = maakVerbinding();

 if(isset($_POST["submit"])){
   $username = $_POST["Username"];
   $Voornaam = $_POST["voornaam"];
   $Achternaam = $_POST["achternaam"];
   $Adres = $_POST["Adres"];
   $wachtwoord = $_POST["wachtwoord"];
   $wachtwoord_HH = $_POST["wachtwoord_HH"];

if (usernameOngeldig($username ) !== false){ 
header("location:../signup.php?error=usernameOngeldig"); 
exit();
}

if (dubbelUsername($verbinding, $username) !==false) {
    header("Location: ../signup.php?error=DubbelUsername");
    exit();
}

if (WachtwoordMatch($wachtwoord, $wachtwoord_HH )!== false){ 
header("location:../signup.php?error=WachtoordNietGelijk"); 
exit();
}

CreateUser($verbinding,$username,$Voornaam, $Achternaam, $Adres, $wachtwoord);
} else { 
   header("location:../signup.php"); 
   exit();
}
   