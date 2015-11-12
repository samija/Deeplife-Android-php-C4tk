<?php
/**
 * Created by PhpStorm.
 * User: BENGEOS-PC
 * Date: 10/24/2015
 * Time: 11:18 AM
 */
require_once "DB_Access.php";
class DataBase {
    private $connection;
    private $database;

    public function __construct(){
        $this->database = new DB_Access();
        $this->connection = $this->database->pass_connection();
        $this->connection->query("USE seacccor_deeplifesys"); // datebase selection
    }
    public function my_Exceptions($expt){
		

    }
    public function add_new_user($Full_Name, $Password, $Email,$Phone,$Phase,$Gender,$Country,$Picture,$Mentor_ID){
        $res = array();
        $res['status'] = 1;
        $Password = crypt($Password,14);
        try {
            $sql = "INSERT INTO users (full_name, password, email, phone, picture, mentor_id, phase, gender, country) VALUES (:us_fn,:us_ps,:us_em,:us_ph,:us_pc,:us_mn,:us_hs,:us_gn,:us_cn)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_fn', $Full_Name, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->bindvalue(':us_em', $Email, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ph', $Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_pc', $Picture, PDO::PARAM_STR);
            $stmt->bindvalue(':us_mn', $Mentor_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':us_hs', $Phase, PDO::PARAM_STR);
            $stmt->bindvalue(':us_gn', $Gender, PDO::PARAM_STR);
            $stmt->bindvalue(':us_cn', $Country, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_user($Email,$Password)
    {
        $res = array();
        $res['status'] = 1;
        $Password = crypt($Password,14);
        try {
            $sql = "SELECT * FROM users WHERE email=:us_em AND password=:us_ps";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_em', $Email, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function get_last_userID()
    {
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT max(id) FROM users ";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function update_user($User_ID,$Full_Name,$Password,$Email,$Phone,$Picture){

        $res = array();
        $res['status'] = 1;
        $Password = crypt($Password,14);
        try {
            $sql = "UPDATE users SET full_name=:us_fn,password=:us_ps,email=:us_em,phone=:us_ph,picture=:us_pc WHERE id=:us_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':us_fn', $Full_Name, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->bindvalue(':us_em', $Email, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ph', $Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_pc', $Picture, PDO::PARAM_STR);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function get_profile($Email_Phone,$Password)
    {
        $res = array();
        $res['status'] = 1;
        $Password = crypt($Password,14);
        try {
            $sql = "SELECT * FROM users WHERE (email=:us_em OR phone=:us_ph) AND (password=:us_ps)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_em', $Email_Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ph', $Email_Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function get_profile_($Email_Phone,$Password)
    {
        $res = array();
        $res['status'] = 1;
        $Password = crypt($Password,14);
        try {
            $sql = "SELECT * FROM users WHERE (email=:us_em OR phone=:us_ph) AND password=:us_ps";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_em', $Email_Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ph', $Email_Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function get_user_($Phone,$Password)
    {
        $res = array();
        $res['status'] = 1;
        $Password = crypt($Password,14);
        try {
            $sql = "SELECT * FROM users WHERE phone=:us_ph AND password=:us_ps";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_ph', $Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function delete_user($User_ID)
    {
        $res = array();
        $res['status'] = 1;
        try{
            $sql = "DELETE FROM users WHERE id=:c_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':c_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e)
        {
            $res['status'] =0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function get_childrens($User_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM users WHERE mentor_id=:us_mt";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_mt', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;

            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_all_users(){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM users";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;
            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_new_childrens($User_id){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM users WHERE mentor_id=:us_id  AND (id NOT IN (SELECT mentor_id FROM mentor_log WHERE user_id=:us_id ))";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_id, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;
            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function add_new_schedule($User_ID,$Dis_Phone, $Time,$Repeat, $Description){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO user_schedule(user_id, dis_phone, alarm_time, alarm_repeat, description) VALUES (:us_id,:us_ph,:us_tm,:us_rp,:us_ds)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':us_tm', $Time, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ph', $Dis_Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_rp', $Repeat, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ds', $Description, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_Schedules($User_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM user_schedule WHERE user_id=:us_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;
            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_last_scheduleID()
    {
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT max(id) FROM user_schedule";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $res['result'] = $stmt->fetch();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function get_New_Schedules($User_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM user_schedule WHERE user_id=:us_id AND id NOT IN (SELECT schedule_id FROM schedule_log WHERE user_id=:us_id )";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;
            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function delete_Schedule($User_ID){
        $res = array();
        $res['status'] = 1;
        try{
            $sql = "DELETE FROM user_schedule WHERE user_id=:c_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':c_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e)
        {
            $res['status'] =0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function add_new_scheduleLog($User_ID,$Schedule_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO schedule_log(user_id, schedule_id) VALUES (:us_id,:sc_id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':sc_id', $Schedule_ID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function delete_ScheduleLog($User_ID){
        $res = array();
        $res['status'] = 1;
        try{
            $sql = "DELETE FROM schedule_log WHERE user_id=:c_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':c_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e)
        {
            $res['status'] =0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function add_new_UserLog($User_ID,$Mentor_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO mentor_log(mentor_id, user_id) VALUES (:mt_id,:us_id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':mt_id', $Mentor_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function delete_UserLog($User_ID){
        $res = array();
        $res['status'] = 1;
        try{
            $sql = "DELETE FROM mentor_log WHERE user_id=:c_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':c_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e)
        {
            $res['status'] =0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
    public function add_new_roll_linker($User_ID,$Roll_Num){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO user_role_linker (user_id, role_id) VALUES (:us_id,:sc_id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':sc_id', $Roll_Num, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function add_new_question($Category,$Description,$Note,$Mandatory){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO questions(category, description, note, mandatory) VALUES (:qs_ct,:qs_ds,:qs_nt,:qs_mn)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':qs_ct', $Category, PDO::PARAM_STR);
            $stmt->bindvalue(':qs_ds', $Description, PDO::PARAM_STR);
            $stmt->bindvalue(':qs_nt', $Note, PDO::PARAM_STR);
            $stmt->bindvalue(':qs_mn', $Mandatory, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_all_questions(){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM questions";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;
            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function get_new_questions_for($User_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM questions WHERE id NOT IN (SELECT question_id FROM question_log WHERE user_id=:us_id )";;
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $res['result'][] = $row;

            }
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function add_new_Question_Log($User_ID,$Question_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO question_log( user_id, question_id) VALUES (:us_id,:qs_id)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_id', $User_ID, PDO::PARAM_INT);
            $stmt->bindvalue(':qs_id', $Question_ID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            $res['status'] = 0;
            $res['report'] = $e->getMessage();
            $this->my_Exceptions($res);
        }
        return $res;
    }
    public function delete_QuestionLog($User_ID){
        $res = array();
        $res['status'] = 1;
        try{
            $sql = "DELETE FROM question_log WHERE user_id=:c_id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':c_id', $User_ID, PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e)
        {
            $res['status'] =0;
            $res['report'] = $e->getMessage();
        }
        return $res;
    }
}