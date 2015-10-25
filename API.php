<?php
require_once 'DataBase.php';
$MyDB = new DataBase();
$file = fopen("test.txt","a");
fwrite($file,json_encode($_POST));
fclose($file);
$ben = array();
$ben['Task'] = '';
$ben['Disciples'] = array();
$ben['Schedules'] = array();
if(isset($_POST['US_Email']) && isset($_POST['US_Password'])){
    $User = $MyDB->get_user($_POST['US_Email'],$_POST['US_Password'])['result'];
    $Mentor_ID = $User['mentor_id'];
    $User_ID = $User['id'];
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
        }elseif(isset($_POST['Task']) && $_POST['Task'] == "Send_Schedule"){
            $res = $MyDB->add_new_schedule($User_ID,$_POST['Time'],$_POST['Description'])['status'];
            if($res == 1){
                $ben['Task'] = 2;
            }

        }elseif(isset($_POST['Task']) && $_POST['Task']== "Get_Schedule"){
            $Schedules = $MyDB->get_Schedules($User_ID);
            if(isset($Schedules) && isset($Schedules['result'])){
                foreach($Schedules['result'] as $Schedule){
                    $found = array();
                    $found['Time'] = $Schedule['time'];
                    $found['Description'] = $Schedule['description'];
                    array_push($ben['Schedules'],$found);
                }
            }
        }
    }
}
echo json_encode($ben);
?>