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

  function runSelectQuery($query) {
    $result = mysqli_query($this->connection, $query);
    if (!$result) {
      $message  = 'Wrong query: '.mysqli_error($this->connection)."\n";
      $message .= 'Query: '.$query;
      die($message);
    }
    return $result;
  }

  function runInsertQuery($query) {
    $result = mysqli_query($this->connection, $query);
    if (!$result) {
      $message  = 'Wrong query: '.mysqli_error($this->connection)."\n";
      $message .= 'Query: '.$query;
      die($message);
    }
  }

  function closeConnection() {
    mysqli_close($this->connection);
  }
}
?>
