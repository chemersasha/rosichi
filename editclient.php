<?php
require_once('DBManager.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $DBManager = new DBManager();
  $DBManager->openConnection();

  if(isset($_POST['Save'])) {
    $newclientid = $_POST['clientid'];
    $newfirstname = $_POST['firstname'];
    $newlastname = $_POST['lastname'];
    $newdatefrom = date("Y-m-d", strtotime($_POST['datefrom']));
    $newdateto = date("Y-m-d", strtotime($_POST['dateto']));
    $newvisits = $_POST['visits'];
    $newsection = $_POST['section'];

    $query = "UPDATE Clients SET = 'Alfred Schmidt', City= 'Frankfurt' WHERE id=1";
    $DBManager->runInsertQuery(
      "UPDATE Clients SET firstname='$newfirstname', lastname='$newlastname', datefrom='$newdatefrom', dateto='$newdateto', visits='$newvisits', section='$newsection' WHERE id=$newclientid;"
    );
    header("Location: viewclient.php?id=".$_POST['clientid']);
    exit();
  }
  $clientid = $_GET['id'];
  $client = mysqli_fetch_array($DBManager->runSelectQuery("SELECT * FROM clients WHERE id='".$clientid."'"));
  $DBManager->closeConnection();

  $convertedDateFrom = date("d/m/Y", strtotime($client['datefrom']));
  $convertedDateTo = date("d/m/Y", strtotime($client['dateto']));
?>
<html lang = "en">
<head>
  <title>Edit client</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="css/addclient.css">
  <link rel="stylesheet" href="jquery/jquery-ui.min.css">

  <script src="jquery/external/jquery/jquery.js"></script>
  <script src="jquery/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $("#datefrom").datepicker();
      $("#dateto").datepicker();
    });
  </script>
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
        <input value="<?php echo $client['id']?>" type="text" disabled>
        <input type="hidden" name="clientid" value="<?php echo $client['id']?>">

        <div>First name:</div>
        <input value="<?php echo $client['firstname']?>" type="text" name="firstname" placeholder="first name" required></br>

        <div>Last name:</div>
        <input value="<?php echo $client['lastname']?>" type="text" name="lastname" placeholder="last name" required></br>

        <div style="text-align:left;">
            <input value="<?php echo $convertedDateFrom?>" class="date" type="text" name="datefrom" id="datefrom"> -
            <input value="<?php echo $convertedDateTo?>" class="date" type="text" name="dateto" id="dateto">
            Visits:
            <input value="<?php echo $client['visits']?>" style="width:45px;text-align:center;" type="text" name="visits">
            Section:
            <input value="<?php echo $client['section']?>" style="width:79px;text-align:center;" type="text" name="section">
        </div>

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
