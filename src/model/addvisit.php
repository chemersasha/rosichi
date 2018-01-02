<?php header('Content-type: text/html; charset=utf-8');
require_once('../../DBManager.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $DBManager = new DBManager();
  $DBManager->openConnection();

  $clientid = $_POST['clientId'];
  $DBManager->runQuery(
    "UPDATE clients SET visits=visits+1 WHERE id=$clientid"
  );
  $clients = $DBManager->runQuery("SELECT visits FROM clients WHERE id=$clientid");
  $client = mysqli_fetch_assoc($clients);
  $result = array(
     'clientId' => $clientid,
     'visits'   => $client['visits']
 );
 echo json_encode($result);
}
?>
