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
        $this->connection->query("USE DeepLife"); // datebase selection
    }
    public function my_Exceptions($expt){

    }
    public function add_new_user($Full_Name, $Password, $Email,$Phone,$Picture,$Mentor_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "INSERT INTO users (full_name, password, email, phone, picture, mentor_id) VALUES (:us_fn,password(:us_ps),:us_em,:us_ph,,:us_pc,:us_mn)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_fn', $Full_Name, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ps', $Password, PDO::PARAM_STR);
            $stmt->bindvalue(':us_em', $Email, PDO::PARAM_STR);
            $stmt->bindvalue(':us_ph', $Phone, PDO::PARAM_STR);
            $stmt->bindvalue(':us_pc', $Picture, PDO::PARAM_STR);
            $stmt->bindvalue(':us_mn', $Mentor_ID, PDO::PARAM_INT);
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
        try {
            $sql = "SELECT * FROM users WHERE email=:us_em AND password=password(:us_ps)";
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
    public function get_user_($Phone,$Password)
    {
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM users WHERE phone=:us_ph AND password=password(:us_ps)";
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
    public function get_childrens($Mentor_ID){
        $res = array();
        $res['status'] = 1;
        try {
            $sql = "SELECT * FROM users WHERE mentor_id = :us_mt";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindvalue(':us_mt', $Mentor_ID, PDO::PARAM_INT);
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
}