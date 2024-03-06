<?php
/*
class DatabaseConnect{
      private $connection = null;
      function __construct() {
            $this->connection = mysqli_connect(DB_host, DB_user, DB_pass, DB_name, DB_port);
            if($this->connection->connect_error)
                  die('Connection error: ['.$this->connection->connect_errno.']'.$this->connection->connect_error);
      }
      function getConnection(){
            return $this->connection;
      }
      function close() {
            mysqli_close($this->connection);
      }
      function __destruct(){
            mysqli_close($this->connection);
      }
}
*/
?>