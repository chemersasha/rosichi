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
    if (!mysqli_set_charset($this->connection, "utf8")) {
      $message = "Error for setup charset utf8: ".mysqli_error($this->connection);
      die($message);
    }
    mysqli_select_db($this->connection, $dbname);
  }

  function runQuery($query) {
    $result = mysqli_query($this->connection, $query);
    if (!$result) {
      $message  = 'Wrong query: '.mysqli_error($this->connection)."\n";
      $message .= 'Query: '.$query;
      die($message);
    }
    return $result;
  }

  function closeConnection() {
    mysqli_close($this->connection);
  }
}
?>
