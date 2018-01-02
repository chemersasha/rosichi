<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');
require_once('src/dateconverter.php');

$sectionId='section';

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $msg = '';
  if (isset($_POST['Add'])) {
    $DBManager = new DBManager();
    $DBManager->openConnection();
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthday = '';
    if($_POST['birthday'] != '') {
      $birthday = clientDateToServerDate($_POST['birthday']);
    }
    $datefrom = '';
    if($_POST['datefrom'] != '') {
      $datefrom = clientDateToServerDate($_POST['datefrom']);
    }
    $dateto = '';
    if($_POST['dateto'] != '') {
      $dateto = clientDateToServerDate($_POST['dateto']);
    }
    $section = $_POST[$sectionId];
    $DBManager->runQuery(
      "INSERT INTO clients (firstname, lastname, birthday, datefrom, dateto, section) VALUES ('$firstname', '$lastname', '$birthday', '$datefrom', '$dateto', '$section');"
    );
    //@TODO go to the edit client page
    $DBManager->closeConnection();
    header("Location: index.php");
    exit();
  }
?>

<html lang = "en">
<head>
  <title>Add client</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="jquery/jquery-ui.min.css">
  <link rel="stylesheet" href="css/addclient.css">

  <script src="jquery/external/jquery/jquery.js"></script>
  <script src="jquery/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $("#birthday").datepicker({changeYear: true, yearRange: "1920:+nn", dateFormat: 'dd/mm/yy'});
      $("#datefrom").datepicker({dateFormat: 'dd/mm/yy'});
      $("#dateto").datepicker({dateFormat: 'dd/mm/yy'});
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
      <form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
        <p class="message"><?php echo $msg; ?></p>
        <div style="display:inline-block;">First name:</div>
        <input type="text" name="firstname" placeholder="first name" required></br>
        <div style="display:inline-block;">Last name:</div>
        <input type="text" name="lastname" placeholder="last name" required></br>
        <div style="text-align:left;">
          <div style="display:inline-block;">Birthday:</div>
          <input style="display:inline-block;" class="date" type="text" name="birthday" id="birthday"></br>
        </div>
        <div style="text-align:left;">
            Training range:
            <input class="date" type="text" name="datefrom" id="datefrom"> -
            <input class="date" type="text" name="dateto" id="dateto">
        </div>
        <div style="text-align:left;">
          Section:
          <?php include('src/views/sections.php'); ?>
        </div><br/>
        <button type="submit" name="Add">Add</button>
        <button name="Cancel" onclick="location.href='adminroom.php'; return false;">Cancel</button>
      </form>
    </div>
  </div>

</body>
</html>

<?php
}
?>
