<?php
require_once 'Bcrypt.php';
require_once 'DataBase.php';
$MyDB = new DataBase();
//$res = $MyDB->add_new_user("ben","ben","ben@ben","091641","1","Male","Ethiopia","c:---","1");

//$Crypt = new \Zend\Crypt\Password\Bcrypt();

//print_r($Crypt->create($_POST['Text']));
?>
<form method="POST" action="">
    Text<input type="text" name="Text" value="ben@ben"><br>
    Crypt Salt<input type="text" name="Salt" value="ben"><br>
    <input type="submit" name="btn" value="Go">
</form>