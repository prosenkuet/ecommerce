<?php
class DbConn {

  public $conn;
  public $result;
  public $sql;


  public function __construct() {

    try {
      $this->conn = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  // encapsulate the query function of mysqli
  public function query($sql) {
    // error_log($sql);
    $this->sql    = $this->real_escape_string($sql);
    $this->result = $this->conn->query($sql);
    return $this->result;
  }

  public function real_escape_string($string){
    $resString = $this->conn->real_escape_string($string);
    return $resString;
  }
}
?>