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
            $ff = $MyDB->add_new_user('sur_name',$_POST['First_Name'],'Middle_Name','Display_Name',$_POST['Email'],$_POST['Phone'],'country','pass',$Mentor_ID,'Pic')['status'];
            if($ff == 1) {
                $ben['Task'] = '1';
            }
        }elseif(isset($_POST['Task']) && $_POST['Task']== "Get_Disciples"){
            $Disciples = $MyDB->get_childrens($Mentor_ID);

            if(isset($Disciples) && isset($Disciples['result'])){
                foreach($Disciples['result'] as $Disciple){
                    $found = array();
                    $found['First_Name'] = $Disciple['firstName'];
                    $found['Middle_Name'] = $Disciple['email'];
                    $found['Phone'] = $Disciple['phone_no'];
                    $found['Email'] = $Disciple['phone_no'];
                    $found['Country'] = $Disciple['phone_no'];
                    array_push($ben['Disciples'],$found);
                }
            }
        }
    }
}
echo json_encode($ben);
?>