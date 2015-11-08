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
$ben['User_Profile'] = array();

if(isset($_POST['Email_Phone']) && isset($_POST['Password'])){
    $User = $MyDB->get_profile($_POST['Email_Phone'],$_POST['Password']);
    if(isset($User) && isset($User['result']) && is_array($User['result'])){
        $User = $User['result'];
        $Mentor_ID = $User['mentor_id'];
        $User_ID = $User['id'];
        if(isset($_POST['Task']) && $_POST['Task']== "Send_Disciple"){
            $ff = $MyDB->add_new_user($_POST['Full_Name'],'-',$_POST['Email'],$_POST['Phone'],$_POST['Build_phase'],$_POST['Gender'],$_POST['Country'],$_POST['Picture'],$User_ID)['status'];
            $MyDB->add_new_UserLog($User_ID,$MyDB->get_last_userID()['result'][0]);
            if($ff == 1) {
                $ben['Task'] = '1';
            }
        }
        if(isset($_POST['Task1']) && $_POST['Task1']== "My_Disciples"){
            $Disciples = $MyDB->get_childrens($User_ID);
            $MyDB->delete_UserLog($User_ID);
            if(isset($Disciples) && isset($Disciples['result'])){
                foreach($Disciples['result'] as $Disciple){
                    $found = array();
                    $found['Full_Name'] = $Disciple['full_name'];
                    $found['Password'] = $Disciple['password'];
                    $found['Email'] = $Disciple['email'];
                    $found['Phone'] = $Disciple['phone'];
                    $found['Country'] = $Disciple['phone'];
                    $found['Password'] = $Disciple['password'];
                    $found['Email'] = $Disciple['email'];
                    $found['Phone'] = $Disciple['phone'];
                    $found['Country'] = $Disciple['phone'];
                    array_push($ben['Disciples'],$found);
                    $MyDB->add_new_UserLog($User_ID,$Disciple['id']);
                }
            }
        }elseif(isset($_POST['Task1']) && $_POST['Task1']== "Get_Disciples"){
            $Disciples = $MyDB->get_new_childrens($User_ID);
            if(isset($Disciples) && isset($Disciples['result'])){
                foreach($Disciples['result'] as $Disciple){
                    $found = array();
                    $found['Full_Name'] = $Disciple['full_name'];
                    $found['Password'] = $Disciple['password'];
                    $found['Email'] = $Disciple['email'];
                    $found['Phone'] = $Disciple['phone'];
                    $found['Country'] = $Disciple['phone'];
                    array_push($ben['Disciples'],$found);
                    $MyDB->add_new_UserLog($User_ID,$Disciple['id']);
                }
            }
        }
        if(isset($_POST['Task']) && $_POST['Task'] == "Send_Schedule"){
            $res = $MyDB->add_new_schedule($User_ID,$_POST['Dis_Phone'],$_POST['Alarm_Time'],$_POST['Alarm_Repeat'],$_POST['Description'])['status'];
            $MyDB->add_new_scheduleLog($User_ID,$MyDB->get_last_scheduleID()['result'][0]);
            if($res == 1){
                $ben['Task'] = 1;
            }

        }
        if(isset($_POST['Task2']) && $_POST['Task2']== "My_Schedules"){
            $Schedules = $MyDB->get_Schedules($User_ID);
            $MyDB->delete_ScheduleLog($User_ID);
            if(isset($Schedules) && isset($Schedules['result'])){
                foreach($Schedules['result'] as $Schedule){
                    $found = array();
                    $found['Dis_Phone'] = $Schedule['dis_phone'];
                    $found['Alarm_Time'] = $Schedule['alarm_time'];
                    $found['Alarm_Repeat'] = $Schedule['alarm_repeat'];
                    $found['Description'] = $Schedule['description'];
                    array_push($ben['Schedules'],$found);
                    $MyDB->add_new_scheduleLog($User_ID,$Schedule['id']);
                }
            }
        }elseif(isset($_POST['Task2']) && $_POST['Task2']== "Get_Schedules"){

            $Schedules = $MyDB->get_New_Schedules($User_ID);
            if(isset($Schedules) && isset($Schedules['result'])){
                foreach($Schedules['result'] as $Schedule){
                    $found = array();
                    $found['Dis_Phone'] = $Schedule['dis_phone'];
                    $found['Alarm_Time'] = $Schedule['alarm_time'];
                    $found['Alarm_Repeat'] = $Schedule['alarm_repeat'];
                    $found['Description'] = $Schedule['description'];
                    array_push($ben['Schedules'],$found);
                    $MyDB->add_new_scheduleLog($User_ID,$Schedule['id']);
                }
            }
        }
        if(isset($_POST['Task']) && $_POST['Task']== "Authenticate"){
            $Profiles = $MyDB->get_profile($_POST['Email_Phone'],$_POST['Password']);
            if(isset($Profiles) && isset($Profiles['result'])){
                $Profile = $Profiles['result'];
                $found = array();
                $found['Full_Name'] = $Profile['full_name'];
                $found['Email'] = $Profile['email'];
                $found['Phone'] = $Profile['phone'];
                $found['Password'] = $_POST['Password'];
                $found['Country'] = $Profile['phone'];
                array_push($ben['User_Profile'],$found);
            }
        }
    }
    if(isset($_POST['Task']) && $_POST['Task']== "Register"){

            $Profiles = $MyDB->get_profile_($_POST['Email_Phone']);

            if(isset($Profiles) && isset($Profiles['result']) && is_array($Profiles['result'])){
                $Profile = $Profiles['result'];
                $profile_id = $Profile['id'];
                $state = $MyDB->update_user($profile_id,$_POST['Full_Name'],$_POST['Password'],$_POST['Email'],$_POST['Phone'],$_POST['Pic']);
            }else{
                add_new_user($_POST['Full_Name'],$_POST['Password'],$_POST['Email'],$_POST['Phone'],$_POST['Build_phase'],$_POST['Gender'],$_POST['Country'],$_POST['Picture'],$User_ID);
            }


            $Profiles = $MyDB->get_profile($_POST['Phone'],$_POST['Password']);
            if(isset($Profiles) && isset($Profiles['result'])){
                $Profile = $Profiles['result'];
                $found = array();
                $found['Full_Name'] = $Profile['full_name'];
                $found['Email'] = $Profile['email'];
                $found['Phone'] = $Profile['phone'];
                $found['Password'] = $_POST['Password'];
                $found['Country'] = $Profile['phone'];
                array_push($ben['User_Profile'],$found);
            }
    }
}

echo json_encode($ben);
?>
