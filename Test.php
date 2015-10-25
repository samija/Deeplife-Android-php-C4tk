<?php
require_once 'DataBase.php';
$MyDB = new DataBase();
//print_r($MyDB->add_new_user('sds','sdsd','midd','dis','BENGEOS','phone','coun','BENGEOS','1','picture'))
/*$val = $MyDB->get_user('BENGEOS','BENGEOS')['result'];
if($val == null){
    print_r('dfdwfssadfasdf');
}
*/

?>
<form method="POST" action="API.php">
    <input type="text" name="US_Email" value="BENGEOS"><br>
    <input type="text" name="US_Password" value="BENGEOS"><br>
    <input type="text" name="Task" value="Get_Disciples"><br>
    <input type="submit" name="btn" value="Go">
</form>