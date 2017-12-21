<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');
require_once('src/dateconverter.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $clientid = $_GET['id'];
  $DBManager = new DBManager();
  $DBManager->openConnection();
  $client = mysqli_fetch_array($DBManager->runQuery("SELECT * FROM clients WHERE id='".$clientid."'"));
  $DBManager->closeConnection();

  $convertedBirthday = '';
  if (!isEmptyDate($client['birthday'])) {
    $convertedBirthday = date("d/m/Y", strtotime($client['birthday']));
  }
  $convertedDateFrom = '';
  if (!isEmptyDate($client['datefrom'])) {
    $convertedDateFrom = date("d/m/Y", strtotime($client['datefrom']));
  }
  $convertedDateTo = '';
  if (!isEmptyDate($client['dateto'])) {
    $convertedDateTo = date("d/m/Y", strtotime($client['dateto']));
  }
?>
<html lang = "en">
<head>
  <title>View client</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="css/addclient.css">
</head>

<body>
  <div class="toppanel">
    <a class="logout" href="logout.php">
      <img src="css/img/logout.png"/>
    </a>
  </div>

  <div class="form-content">
    <div class="form">
      <table>
        <tr>
          <td>FIRST:</td><td><?php echo $client['firstname']?></td>
        </tr>
        <tr>
          <td>LAST NAME:</td><td><?php echo $client['lastname']?></td>
        </tr>
        <tr>
          <td>BIRTHDAY:</td><td><?php echo $convertedBirthday?></td>
        </tr>
        <tr>
          <td>DATE FROM:</td><td><?php echo $convertedDateFrom?></td>
        </tr>
        <tr>
          <td>DATE TO:</td><td><?php echo $convertedDateTo?></td>
        </tr>
        <tr>
          <td>VISITS:</td><td><?php echo $client['visits']?></td>
        </tr>
        <tr>
          <td>SECTION:</td><td><?php echo $client['section']?></td>
        </tr>
      </table>
      <br/>
      <button name="Cancel" onclick="location.href='adminroom.php'; return false;">Back</button>
    </div>
  </div>
</body>
</html>

<?php
}
?>
