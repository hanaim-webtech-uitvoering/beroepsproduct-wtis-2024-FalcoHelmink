<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();
?>
    <Title> Log in </Title>
<?php navbar(); ?>

<body>
      <h1>Log in</h1>
      <form action="includes/LogIn.inc.php" method="POST"> 
        <input type="text" name="Username" placeholder="Username"required>
        <input type="password" name="wachtwoord" placeholder="wachtwoord"required>
        <button type="submit" name="submit"> log in </button>
      </form>
</body>
<?php
if (isset($_GET["error"])){
             if ($_GET["error"] == "UserBestaatNiet"){
                echo "<p> Username bestaat niet";
            }
            else if ($_GET["error"] == "VerkeerdWachtwoord"){
                echo "<p> wachtwoord is onjuist";
            }
        }

?>

<?php footer(); ?>