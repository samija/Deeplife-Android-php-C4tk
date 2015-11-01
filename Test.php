<?php
require_once 'DataBase.php';
$MyDB = new DataBase();
$res = $MyDB->get_Schedules('1262');
print_r($res);
//print_r($MyDB->add_new_user('sds','sdsd','midd','dis','BENGEOS','phone','coun','BENGEOS','1','picture'))
/*$val = $MyDB->get_user('BENGEOS','BENGEOS')['result'];
if($val == null){
    print_r('dfdwfssadfasdf');
}
*/
?>
<form method="POST" action="API.php">
    <input type="text" name="Email_Phone" value="ben"><br>
    <input type="text" name="Password" value="ben"><br>
    <input type="text" name="Task2" value="My_Disciples"><br>
    <input type="text" name="Email" value="BENGEOS"><br>
    <input type="text" name="Phone" value="091641"><br>
    <input type="text" name="Pic" value="BENGEOS"><br>
    <input type="text" name="Country" value="BENGEOS"><br>


    <input type="text" name="Task" value="Regiuuster"><br>
    <input type="submit" name="btn" value="Go">
</form>