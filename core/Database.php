<?php
namespace app\core;
use app\models\Fields;

class Database
{
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'list_of_users';

    private static $_instance;
    private $conn;



    private function __construct()
    {
        $this->conn = new \mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
    }


    public function insert($insert) {
        return $this->conn->query($insert);
    }

    public function update($table,  $dataValues, $id) {
        foreach ($dataValues as $keyTable => $value) {
            if ($keyTable == 'submit') continue;
            $column[] = $keyTable. " = " . "'". $value. "'";
        }
        $column = implode(', ', $column);
        $update ='UPDATE '. $table. ' SET ' . $column . ' WHERE ' . $table .'. id='.$id;
        print_r($update);
        $this->conn->query($update);
    }


    public function display()
    {
        $result = $this->conn->query("SELECT * FROM `users` ORDER BY `name` ASC, `surname` ASC, `age` ASC, `telephone` ASC");
        if ($result->num_rows >= 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }


    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function getConnection(){
        return $this->conn;
    }

}

