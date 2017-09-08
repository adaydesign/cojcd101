<?php

    class Database{
        //http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/
        //https://github.com/lincanbin/PHP-PDO-MySQL-Class
        private $host   = DB_HOST;
        private $user   = DB_USER;
        private $pass   = DB_PASS;
        private $dbname = DB_NAME;
        
        private $db;
        private $stmt;
        private $connected;
        private $error;

        public function __construct(){

            $dsn = "mysql:host=". $this->host .";dbname=". $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT            => true,
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES      => false,
                PDO::MYSQL_ATTR_INIT_COMMAND    => "SET NAMES utf8"
            );

            try{
                $this->db = new PDO($dsn, $this->user, $this->pass, $options);
                $this->connected = true;
            }
            catch(PDOException $e){
                $this->error = $e->getMessage();
                $this->connected = false;
                die();
            }
        }

        public function query($query){
            $this->stmt = $this->db->prepare($query);
        }

        public function bind($param, $value, $type = null){
            if(is_null($type)){
                if(is_int($value)){
                    $type = PDO::PARAM_INT;
                }
                else if(is_bool($value)){
                    $type = PDO::PARAM_BOOL;
                }
                else if(is_null($value)){
                    $type = PDO::PARAM_NULL;
                }
                else{
                    $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        // values = array(param=>value,param=>value)
        public function bindValues($values){
            if(is_array($values)){
                foreach($values as $param => $value){
                    $this->bind($param,$value);
                }
            }
        }

        public function execute(){
            return $this->stmt->execute();
        }

        // PDO::FETCH_ASSOC
        // PDO::FETCH_NUM
        public function resultset($fetch=PDO::FETCH_ASSOC){
            $this->execute();
            return $this->stmt->fetchAll($fetch);
        }

        public function single($fetch=PDO::FETCH_ASSOC){
            $this->execute();
            return $this->stmt->fetch($fetch);
        }

        public function beginTransaction(){
            return $this->db->beginTransaction();
        }

        public function endTransaction(){
            return $this->db->commit();
        }

        public function cancelTransaction(){
            return $this->db->rollBack();
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }

        public function lastInsertId(){
            return $this->db->lastInsertId();
        }

        public function close(){
            $this->stmt = null;
            $this->db   = null;
        }

        public function isConnected(){
            return $this->connected;
        }

        public function errorMessage(){
            return $this->error;
        }
        
    }

?>