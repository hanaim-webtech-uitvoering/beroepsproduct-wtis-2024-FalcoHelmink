<?php
require_once 'db_connectie.php';
$verbinding = maakVerbinding();
///////////////////////////PAGINA OPMAAK////////////////////////////////////////

function navbar() {
    echo '<h1>Pizzeria Sole Machina 🍕</h1>'; 

    $menu = [
        'Privacypagina' => 'privacyPagina.php',
        'Menu' => 'menuPagina.php',
        'bestellen' => 'ProductenAantal.php'
    ];

    if (isset($_SESSION['username'])) {
        echo '<h3>Hartelijk welkom, ' . htmlspecialchars($_SESSION['username']) . '!</h3>';
        $menu['Log Out'] = 'logout.php';
        $menu['Account'] = 'AccountPagina.php';

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
            
             else if ($_GET["error"] == "geenToegangAccount"){
                echo "<p> U moet eerst ingelogd zijn voor u de account pagina kan bereiken";
            }  
            else if ($_GET["error"] == "geenAantal"){
                echo "<p> U moet eerst het aantal producten invullen dat u wilt bestellen";
            } 
             else if ($_GET["error"] == "usernameNietGevonden"){
                echo "<p> De username die is ongevoerd is ongeldig ";
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


        $stmt->execute([$username, $hashedWW, $voornaam, $achternaam, 'Client']);
        header("location:../signup.php?error=signupGeslaagd");
        exit();
    
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

$html_table3 = '<table border="1" cellpadding="5" cellspacing="0">';
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

    $stmt = $verbinding->prepare("SELECT o.order_id,o.client_username,o.client_name,o.personnel_username, o.status,o.address, o.datetime,
                                STRING_AGG(CONCAT(p.product_name, ' (', p.quantity, ')'), ', ') AS products
                                FROM Pizza_Order o JOIN Pizza_Order_Product p ON p.order_id = o.order_id
                                where o.order_id = ?
                                GROUP BY o.order_id,o.client_username, o.client_name,o.personnel_username, o.status,o.datetime,o.address
                                ORDER BY o.order_id;");
    $stmt->execute([$id]);

$html_table4 = '<table border="1" cellpadding="5" cellspacing="0">';
$html_table4 = $html_table4 . 

'<tr>
    <th>order_id</th>
    <th>username</th>
    <th>naam</th>
    <th>personeel</th>
    <th>status</th>
    <th>adres</th>
    <th>datum</th>
    <th>products</th>
</tr>';
while($rij = $stmt->fetch()){
  $order_id = $rij['order_id'];
  $client_username = $rij['client_username'];
  $client_name = $rij['client_name'];
  $personnel_username = $rij['personnel_username'];
  $status = $rij['status'];
  $datetime = $rij['datetime'];
  $address = $rij['address']; 
  $products = $rij['products'];
  
  $html_table4 = $html_table4 .
    "<tr>
        <td>$order_id</td>
        <td>$client_username</td>
        <td>$client_name</td>
        <td>$address</td>
        <td>$personnel_username</td>
        <td>$status</td>
        <td>$datetime</td>
        <td>$products</td>
    </tr>";
    }
$html_table4 = $html_table4 . "</table>";
}   

function ChangeStatus($verbinding, $newStatus, $order_id){

    $stmt = $verbinding->prepare("UPDATE Pizza_Order 
                                    SET status = ? 
                                    WHERE order_id = ?");

    return $stmt->execute([$newStatus, $order_id]);
}
////////////////////////////ACCOUNT PAGINA/////////////////////////////////////////
function TabelAccountInfo($username, $verbinding){

$MenuQuery = "
            SELECT username, first_name, last_name, address, role
            FROM [dbo].[User]
            WHERE username = :username
";

$stmt = $verbinding->prepare($MenuQuery);
$stmt->execute(['username' => $username]);


$html_table5 = '<table border="1" cellpadding="5" cellspacing="0">';
$html_table5 = $html_table5 . 

'<tr>
    <th>Username</th>
    <th>Voornaam</th>
    <th>Achternaam</th>
    <th>adres</th>
    <th>rol</th>
</tr>';

    while($rij = $stmt->fetch()){
  $username = $rij['username'];
  $first_name = $rij['first_name'];
  $last_name = $rij['last_name'];
  $address = $rij['address'];
  $role = $rij['role'];

  
  $html_table5 = $html_table5 .
    "<tr>
        <td>$username</td>
        <td>$first_name</td>
        <td>$last_name</td>
        <td>$address</td>
        <td>$role</td>
    </tr>";

    }
 $html_table5 = $html_table5 . "</table>";
return $html_table5;
}
/////////////////////////////////////////////////////////////////////ACCOUNT PAGINA


function TabelAccountOrders($username, $verbinding){
 $MenuQuery = "

                SELECT o.order_id,o.client_username,o.client_name,o.address, o.datetime,
                STRING_AGG(CONCAT(p.product_name, ' (', p.quantity, ')'), ', ') AS products
                FROM Pizza_Order o JOIN Pizza_Order_Product p ON p.order_id = o.order_id
                where o.client_username= :username
                GROUP BY o.order_id,o.client_username, o.client_name,o.datetime,o.address
                 ORDER BY o.order_id;
                ";

$stmt = $verbinding->prepare($MenuQuery);
$stmt->execute(['username' => $username]);


$html_table6 = '<table border="1" cellpadding="5" cellspacing="0">';
$html_table6 = $html_table6 . 

'<tr>
    <th>order_id</th>
    <th>username</th>
    <th>naam</th>
    <th>adres</th>
    <th>datum</th>
    <th>products</th>
</tr>';
while($rij = $stmt->fetch()){
  $order_id = $rij['order_id'];
  $client_username = $rij['client_username'];
  $client_name = $rij['client_name'];
  $datetime = $rij['datetime'];
  $address = $rij['address'];
  $products = $rij['products'];
  
  $html_table6 = $html_table6 .
    "<tr>
        <td>$order_id</td>
        <td>$client_username</td>
        <td>$client_name</td>
        <td>$address</td>
        <td>$datetime</td>
        <td>$products</td>
    </tr>";

}
 $html_table6 = $html_table6 . "</table>";
 return $html_table6;
}
///////////////////////Bestelfunctie//////////////////////////////////////////////////


function MaakOrder($verbinding, $username,$clientname, $products, $address) {
        $status = "1"; 
        $personnel_username ='FalcoChef';
    $sql = "INSERT INTO Pizza_Order (client_username, client_name,personnel_username, datetime, status, address) 
            VALUES (?, ?, ?, GETDATE(), ?, ?)";
    $stmt = $verbinding->prepare($sql);

        $stmt->execute([$username, $clientname, $personnel_username, $status, $address ]);
   $order_id = $verbinding->lastInsertId();
    
    foreach ($products as $product) {
        $product_name = $product['name'];
        $quantity = $product['quantity'];
            if ($product_name != "" && $quantity > 0) {
                    $stmt2 = $verbinding->prepare
                    (
                        "INSERT INTO Pizza_Order_Product (order_id, product_name, quantity) VALUES (?, ?, ?)"
                    );
                    $stmt2->execute([$order_id, $product_name, $quantity]);
            }
    }
    return $order_id;
}

function dynamischBestel($db,$product_count){
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
    <label>Aantal:</label>
    <input type="number" name="quantity[]" min="1" value="1" required><br><br>
<?php endfor; }

        
