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
      <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        <div>Client id:</div>
        <input value="<?php echo $client['id']?>" type="text" name="clientid" placeholder="client id" disabled required></br>

        <div>First name:</div>
        <input value="<?php echo $client['firstname']?>" type="text" name="firstname" placeholder="first name" required></br>

        <div>Last name:</div>
        <input value="<?php echo $client['lastname']?>" type="text" name="lastname" placeholder="last name" required></br>

        <div>Date from:</div>
        <input value="<?php echo $client['datefrom']?>" type="text" name="datefrom" placeholder="01-01-2001"></br>
        <div>Date to:</div>
        <input value="<?php echo $client['dateto']?>" type="text" name="dateto" placeholder="01-01-2001"></br>

        <div>Visits:</div>
        <input value="<?php echo $client['visits']?>" type="text" name="visits" placeholder="0"></br>

        <div>Section:</div>
        <input value="<?php echo $client['section']?>" type="text" name="section" placeholder="box"></br>

        <button type="submit" name="Save">Save</button>
        <button name="Cancel" onclick="location.href='adminroom.php'; return false;">Cancel</button>
      </form>
    </div>
  </div>
</body>
</html>

<?php
}
?>
