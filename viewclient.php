<?php
require_once('DBManager.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $clientid = $_GET['id'];
  $DBManager = new DBManager();
  $DBManager->openConnection();
  $client = mysqli_fetch_array($DBManager->runSelectQuery("SELECT * FROM clients WHERE id='".$clientid."'"));
  $DBManager->closeConnection();
?>
<html lang = "en">
<head>
  <title>Add client</title>
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
          <td>CLIENT ID:</td><td><?php echo $client['id']?></td>
        </tr>
        <tr>
          <td>FIRST:</td><td><?php echo $client['firstname']?></td>
        </tr>
        <tr>
          <td>LAST NAME:</td><td><?php echo $client['lastname']?></td>
        </tr>
        <tr>
          <td>DATE FROM:</td><td><?php echo $client['datefrom']?></td>
        </tr>
        <tr>
          <td>DATE TO:</td><td><?php echo $client['dateto']?></td>
        </tr>
        <tr>
          <td>VISITS:</td><td><?php echo $client['visits']?></td>
        </tr>
        <tr>
          <td>SECTION:</td><td><?php echo $client['section']?></td>
        </tr>
      </table>
        <button name="Cancel" onclick="location.href='adminroom.php'; return false;">Back</button>
    </div>
  </div>
</body>
</html>

<?php
}
?>
