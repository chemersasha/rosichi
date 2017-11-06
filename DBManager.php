<?php
class DBManager {
  private $connection = NULL;

  function openConnection() {
    $dbini = parse_ini_file("db.ini");
    $dbhost = $dbini['dbhost'];
    $dbuser = $dbini['dbuser'];
    $dbpass = $dbini['dbpass'];
    $dbname = $dbini['dbname'];
    $this->connection = mysqli_connect($dbhost, $dbuser, $dbpass);
    mysqli_select_db($this->connection, $dbname);
  }

  function runQuery($query) {
    $qry_result = mysqli_query($this->connection, $query);
    return mysqli_fetch_array($qry_result);
  }

  function closeConnection() {
    mysqli_close($this->connection);
  }
}
?>
