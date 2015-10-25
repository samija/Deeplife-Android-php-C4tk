<?php
require_once 'DataBase.php';
$MyDB = new DataBase();
$file = fopen("test.txt","a");
fwrite($file,json_encode($_POST));
fclose($file);
$ben = array();
$ben['Task'] = '';
$ben['Disciples'] = array();
if(isset($_POST['US_Email']) && isset($_POST['US_Password'])){
    $User = $MyDB->get_user($_POST['US_Email'],$_POST['US_Password'])['result'];
    $Mentor_ID = $User['mentor_id'];

    if($User != null){
        if(isset($_POST['Task']) && $_POST['Task']== "Send_Disciple"){
            $ff = $MyDB->add_new_user($_POST['Full_Name'],$_POST['Password'],$_POST['Email'],$_POST['Phone'],$_POST['Pic'],$Mentor_ID)['status'];
            if($ff == 1) {
                $ben['Task'] = '1';
            }
        }elseif(isset($_POST['Task']) && $_POST['Task']== "Get_Disciples"){
            $Disciples = $MyDB->get_childrens($Mentor_ID);

            if(isset($Disciples) && isset($Disciples['result'])){
                foreach($Disciples['result'] as $Disciple){
                    $found = array();
                    $found['First_Name'] = $Disciple['full_name'];
                    $found['Password'] = $Disciple['password'];
                    $found['Email'] = $Disciple['email'];
                    $found['Phone'] = $Disciple['phone'];
                    $found['Pic'] = $Disciple['picture'];
                    array_push($ben['Disciples'],$found);
                }
            }
        }
    }
}
echo json_encode($ben);
?>