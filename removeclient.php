<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $clientid = $_GET['id'];
  $DBManager = new DBManager();
  $DBManager->openConnection();
  $client = $DBManager->runQuery("DELETE FROM clients WHERE id='".$clientid."'");
  $DBManager->closeConnection();

  header("Location: index.php");
  exit();
}
?>
