<?php
require_once 'db_connectie.php';
$db = maakVerbinding();
require_once 'function.php';
session_start();
?>
    <Title> Sign Up </Title>
<?php
 navbar();
 Errors();
?>

<body>
      <h1>Sign Up</h1>
      <form action="includes/signUp.inc.php" method="POST"required> 
        <input type="text" name="Username" placeholder="Username"required><br><br>
        <input type="text" name="voornaam" placeholder="voornaam"required><br><br>
        <input type="text" name="achternaam" placeholder="achternaam"required><br><br>
        <input type="password" name="wachtwoord" placeholder="wachtwoord"required><br><br>
        <input type="password" name="wachtwoord_HH" placeholder="wachtwoord herhalen"required><br><br>
        <button type="submit" name="submit"> SignUp </button>
      </form>

    <?php      

     ?>
</body>

<?php footer(); ?>