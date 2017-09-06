<?php

    class Database{
        //http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/
        //https://github.com/lincanbin/PHP-PDO-MySQL-Class
        private $host   = DB_HOST;
        private $user   = DB_USER;
        private $pass   = DB_PASS;
        private $dbname = DB_NAME;
        
        private $dbh;
        private $stmt;

        public function __construct(){

            $dsn = "mysql:host=". $this->host .";dbname=". $this->dbname;
            $option = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
            );

            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
                //echo "connect OK";
            }
            catch(PDOException $e){
                $this->error = $e->getMessage();
                //echo "connect Fail";
            }
        }

        public function query($query){
            $this->stmt = $this->dbh->prepare($query);
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

        public function execute(){
            return $this->stmt->execute();
        }

        public function resultset(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_NUM);
        }

        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_NUM);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }

        public function lastInsertId(){
            return $this->dbh->lastInsertId();
        }

        public function close(){
            
        }
        
    }

?>