<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');
require_once('src/dateconverter.php');

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
    $newbirthday = '';
    if($_POST['birthday'] != '') {
      $newbirthday = clientDateToServerDate($_POST['birthday']);
    }
    $newdatefrom = '';
    if($_POST['datefrom'] != '') {
      $newdatefrom = clientDateToServerDate($_POST['datefrom']);
    }
    $newdateto = '';
    if($_POST['dateto'] != '') {
      $newdateto = clientDateToServerDate($_POST['dateto']);
    }
    $newvisits = $_POST['visits'];
    $newsection = $_POST['section'];

    $DBManager->runQuery(
      "UPDATE clients SET firstname='$newfirstname', lastname='$newlastname', birthday='$newbirthday', datefrom='$newdatefrom', dateto='$newdateto', visits='$newvisits', section='$newsection' WHERE id=$newclientid;"
    );
    header("Location: viewclient.php?id=".$_POST['clientid']);
    exit();
  }
  $clientid = $_GET['id'];
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
  <title>Edit client</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="jquery/jquery-ui.min.css">
  <link rel="stylesheet" href="css/addclient.css">
  <link rel="stylesheet" href="css/editclient.css">

  <script src="jquery/external/jquery/jquery.js"></script>
  <script src="jquery/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $("#datefrom").datepicker({dateFormat: 'dd/mm/yy'});
      $("#dateto").datepicker({dateFormat: 'dd/mm/yy'});
      $("#birthday").datepicker({changeYear:true, yearRange:"1920:+nn", dateFormat:'dd/mm/yy'});

      var section = $("#section");
      section.selectmenu({
        width: 137
      });
      section.val('<?php echo $client['section']?>');
      section.selectmenu("refresh");
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
        <!-- <div>Client id:</div>
        <input value="<?php echo $client['id']?>" type="text" disabled> -->
        <input type="hidden" name="clientid" value="<?php echo $client['id']?>">

        <div>First name:</div>
        <input value="<?php echo $client['firstname']?>" type="text" name="firstname" placeholder="first name" required></br>

        <div>Last name:</div>
        <input value="<?php echo $client['lastname']?>" type="text" name="lastname" placeholder="last name" required></br>

        <div style="text-align:left;">
            Birthday:
            <input value="<?php echo $convertedBirthday?>" class="date" type="text" name="birthday" id="birthday">
        </div>
        <div style="text-align:left;">
            Training range:
            <input value="<?php echo $convertedDateFrom?>" class="date" type="text" name="datefrom" id="datefrom"> -
            <input value="<?php echo $convertedDateTo?>" class="date" type="text" name="dateto" id="dateto">
        </div>
        <div style="text-align:left;">
          Visits:
          <input value="<?php echo $client['visits']?>" style="width:45px;text-align:center;" type="text" name="visits">
        </div>
        <div style="text-align:left;">
          <select name="section" id="section">
              <option value="Нет">Нет</option>
              <option value="Бокс">Бокс</option>
              <option value="Тренажеры">Тренажеры</option>
          </select></br>
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
