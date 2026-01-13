<?php
require_once 'db_connectie.php';
$verbinding = maakVerbinding();
///////////////////////////PAGINA OPMAAK////////////////////////////////////////

function navbar() {
    echo '<h1>Pizzeria Sole Machina 🍕</h1>'; 

    $menu = [
        'Privacypagina' => 'privacyPagina.php',
        'Menu' => 'menuPagina.php'
    ];

    if (isset($_SESSION['username'])) {
        echo '<h3>Hartelijk welkom, ' . htmlspecialchars($_SESSION['username']) . '!</h3>';
        $menu['Log Out'] = 'logout.php';

    } else {
        $menu['Sign Up'] = 'SignUp.php';
        $menu['Log In']  = 'LogIn.php';
    } if (isset($_SESSION['Rol'])&& $_SESSION['Rol'] === 'personnel'){
        $menu['Orders'] = 'OrderPagina.php';
    }

    echo '<nav>';
        echo '<ul>';
        foreach ($menu as $name => $url) {
            echo "<li><a href=\"$url\">$name</a></li>";
        }
        echo '</ul>';
    echo '</nav>';
    }

Function Errors(){

            if (isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"   ){
                echo"<p> Vul alle velden in</p>";
            }
            else if ($_GET["error"] == "usernameOngeldig"){
                echo "<p> Username bevat ongeldige tekens";
            }
             else if ($_GET["error"] == "DubbelUsername"){
                echo "<p> Username is al in gebruik";
            }
            else if ($_GET["error"] == "WachtoordNietGelijk"){
                echo "<p> de wachtwoorden die zijn ingevuld zijn niet gelijk";
            }    
            else if ($_GET["error"] == "signupGeslaagd"){
                echo "<p> Sign up is geslaagd";
            }   
             else if ($_GET["error"] == "geenToegang"){
                echo "<p> Alleen toegang voor personeel";
            }   
        }

    }


function Footer() {
    echo '
    <footer>
        <p>Tel: 06 12345678</p>
        <p>Email: PizzeriaSoleMachina@gmail.com</p>
    </footer>
    ';
}
//////////////////////////////////MENU Pagina///////////////////////////////

$MenuQuery =   $MenuQuery = "
  SELECT p.name AS product, p.price AS prijs, p.type_id AS type, STRING_AGG(i.ingredient_name, ', ') AS ingredienten
  FROM Product p LEFT JOIN Product_Ingredient i ON p.name = i.product_name
  GROUP BY p.name, p.price, p.type_id
  order BY p.type_id
";
;

$data2 = $verbinding ->query($MenuQuery);

$html_table2 = '<table>';
$html_table2 = $html_table2 . '<tr><th>product</th><th>prijs</th><th>type</th><th>ingredienten</th></tr>';

while($rij = $data2->fetch()) {
  $product = $rij['product'];
  $prijs = $rij['prijs'];
  $type = $rij['type'];
  $ingredienten = $rij['ingredienten'];
  
  $html_table2 = $html_table2 . "<tr><td>$product</td><td>$prijs</td><td>$type</td><td>$ingredienten</td></tr>";
}

$html_table2 = $html_table2 . "</table>";

///////////////////////////////////SIGN IN PAGNIA//////////////////////////////////////////////
function emptyInputSignup($username,$Voornaam, $Achternaam, $wachtwoord, $wachtwoord_HH ){
    $result;
    if (empty($username)|| empty($Voornaam) ||empty($Achternaam)||empty($wachtwoord)||empty($wachtwoord_HH)){
    $result= true; 
         }
    
    else {
     $result= false;    
    }
    return $result; 
}

function usernameOngeldig($username){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
    $result= true; 
         }
    
    else {
     $result= false;    
    }
    return $result; 
}

function WachtwoordMatch($wachtwoord, $wachtwoord_HH ){
    $result;
    if ($wachtwoord !== $wachtwoord_HH) {
    $result= true; 
         }
    
    else {
     $result= false;    
    }
    return $result; 
} 

function dubbelUsername($verbinding, $username) {
    $sql = "SELECT * FROM [dbo].[User] WHERE username = ?;";
    $stmt = $verbinding->prepare($sql);
    $stmt->execute([$username]);
   return $stmt->fetch(PDO::FETCH_ASSOC);
}




function createUser($verbinding, $username, $voornaam, $achternaam, $wachtwoord) {
    $sql = "INSERT INTO [dbo].[User] (username, password, first_name, last_name, role) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $verbinding->prepare($sql);

    $hashedWW = password_hash($wachtwoord, PASSWORD_DEFAULT);

    try {
        $stmt->execute([$username, $hashedWW, $voornaam, $achternaam, 'Client']);
        header("location:../signup.php?error=signupGeslaagd");
        exit();
    } 
    catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            header("Location: ../signup.php?error=DubbelUsername");
            exit();
        } else {
            throw $e; 
        }
    }
}


///////////////////////////////////LOGIN PAGINA//////////////////////////////////

function emptyInputLogIn($username,$wachtwoord ){
    $result;
    if (empty($username) || empty($wachtwoord)){
    $result= true; 
         }
    
    else {
     $result= false;    
    }
    return $result; 
}



function LoginUser($verbinding,$username,$wachtwoord){

$UsernameBestaat = dubbelUsername($verbinding, $username);
if($UsernameBestaat === False){
header("location:../Login.php?error=UserBestaatNiet"); 
   exit();
}

$WWHashed = $UsernameBestaat["password"];

$CheckWW = password_verify($wachtwoord, $WWHashed);
if( $CheckWW === false) {
header("location:../Login.php?error=VerkeerdWachtwoord"); 
   exit();
}
else if ($CheckWW === true ){
    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["Rol"] =  $UsernameBestaat["role"];
header("location:../menuPagina.php?Login=geslaagd"); 
   exit();
}
}
//////////////////////ORDER PAGINA////////////////////////////////

$MenuQuery = "
                Select * 
                from Pizza_Order P
                where CAST( P.datetime as date) = cast(GETDATE() as date)
                order by order_id;
                ";


$data3 = $verbinding ->query($MenuQuery);

$html_table3 = '<table>';
$html_table3 = $html_table3 . 

'<tr>
    <th>order_id</th>
    <th>username</th>
    <th>naam</th>
    <th>personnel_username</th>
    <th>datum + tijd</th>
    <th>status</th>
    <th>adres</th>
    <th>update</th>
</tr>';

while($rij = $data3->fetch()) {
  $order_id = $rij['order_id'];
  $client_username = $rij['client_username'];
  $client_name = $rij['client_name'];
  $personnel_username = $rij['personnel_username'];
  $datetime = $rij['datetime'];
  $status = $rij['status'];
  $address = $rij['address'];
  
  $html_table3 = $html_table3 .
    "<tr>
        <td>$order_id</td>
        <td>$client_username</td>
        <td>$client_name</td>
        <td>$personnel_username</td>
        <td>$datetime</td>
        <td>$status</td>
        <td>$address</td>
        <td>
            <a href='updateOrder.php?id=$order_id'>Update</a>
        </td>
    </tr>";
}

$html_table3= $html_table3 . "</table>";

///////////////////alter order///////////////////////////////////////////

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int)$_GET['id']; 

    $stmt = $verbinding->prepare("SELECT * FROM Pizza_Order WHERE order_id = ?");
    $stmt->execute([$id]);
    $data4 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$data4) {
        $html_table4 = "<p>Geen order gevonden met ID $id.</p>";
    } else {

        $html_table4 = '<table>';

        $html_table4 .= 
        '<tr>
            <th>order_id</th>
            <th>username</th>
            <th>naam</th>
            <th>personnel_username</th>
            <th>datum + tijd</th>
            <th>status</th>
            <th>adres</th>
            <th>update</th>
        </tr>';

        foreach ($data4 as $rij) {
            $order_id = $rij['order_id'];
            $client_username = $rij['client_username'];
            $client_name = $rij['client_name'];
            $personnel_username = $rij['personnel_username'];
            $datetime = $rij['datetime'];
            $status = $rij['status'];
            $address = $rij['address'];

            $html_table4 .=
            "<tr>
                <td>$order_id</td>
                <td>$client_username</td>
                <td>$client_name</td>
                <td>$personnel_username</td>
                <td>$datetime</td>
                <td>$status</td>
                <td>$address</td>
                <td>
                    <a href='updateOrder.php?id=$order_id'>Update</a>
                </td>
            </tr>";
        }

        $html_table4 .= "</table>";
    }

} else {
    $html_table4 = "<p>Geen order geselecteerd of ongeldig ordernummer.</p>";
}



function ChangeStatus($verbinding, $newStatus, $order_id){

    $stmt = $verbinding->prepare("UPDATE Pizza_Order 
                                    SET status = ? 
                                    WHERE order_id = ?");

    return $stmt->execute([$newStatus, $order_id]);
}