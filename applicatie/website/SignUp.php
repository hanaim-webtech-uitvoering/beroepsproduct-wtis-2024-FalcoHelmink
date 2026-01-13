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
      <form action="includes/signUp.inc.php" method="POST"> 
        <input type="text" name="Username" placeholder="Username">
        <input type="text" name="voornaam" placeholder="voornaam">
        <input type="text" name="achternaam" placeholder="achternaam">
        <input type="password" name="wachtwoord" placeholder="wachtwoord">
        <input type="password" name="wachtwoord_HH" placeholder="wachtwoord herhalen">
        <button type="submit" name="submit"> SignUp </button>
      </form>

    <?php      

     ?>
</body>

<?php footer(); ?>