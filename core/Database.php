<?php
namespace app\core;

use app\models\config\Debag;
use app\models\Fields;

class Database
{
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = 'root';
    private $db_name = 'list_of_users';
    private static $_instance;
    private $conn;

    private function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn = new \mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
    }

    /**
     * @param $sql
     * @return bool|\mysqli_result
     */
    function query($sql) {
        try {
            return $this->getConnection()->query($sql);
        } catch (\mysqli_sql_exception $exception) {
            $e = new DatabaseExp();
            $e->setSql($sql);
            throw $e;
        }
    }

    public function insert($sql) {
        $this->query($sql);
        return $this->getConnection()->insert_id;
    }

    public function update($sql) {
        $this->query($sql);
        return $this->getConnection()->affected_rows;
    }

    public function delete($sql) {
        $this->query($sql);
        return $this->getConnection()->affected_rows;
    }

//    function getRow($sql) {
//        $query = $this->getConnection()->query($sql);
//        return ($query && $query->num_rows >= 0) ? $query->fetch_assoc() : [];
//    }

    public function result($sql){
        $query = $this->query($sql);
        $data = [];
        if ($query && $query->num_rows >= 0) {
            $query->fetch_all(MYSQLI_ASSOC);
            foreach ($query as $elem) {
                $data[] = $elem;
            }
        }
        return $data;
    }

    public function row($sql): ?array {
        $query = $this->query($sql);
        return ($query && $query->num_rows >= 0)
            ? $query->fetch_assoc()
            : [];
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection(){
        return $this->conn;
    }

   public function column($sql) {
       $query = $this->query($sql);
       $data = [];
       if ($query && $query->num_rows >= 0) {
           $data = $query->fetch_assoc();
       }
       return current($data);
   }

    public function info(){
        return $this->conn->info;
    }
}


