<?php
session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
?>

<html lang = "en">
<head>
  <title>Add client</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="css/addclient.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
  <div style="display:block; margin:5px;">
    <!-- <a style="float:left;" href="adminroom.php">Go back</a> -->
    <a style="float:right;" href="logout.php">
      <span class="glyphicon glyphicon-log-out"></span>
    </a>
  </div>

  <div class="form-content">
    <div class="form">
      <form role="form" action="createclient.php" method = "post">
        <div style="display:inline-block;">Client id:</div>
        <input type="text" name="clientid" placeholder="client id" required autofocus></br>
        <div style="display:inline-block;">First name:</div>
        <input type="text" name="firstname" placeholder="first name" required autofocus></br>
        <div style="display:inline-block;">Last name:</div>
        <input type="text" name="lastname" placeholder="last name" required autofocus></br>
        <button type="submit" name="Add">Add</button>
        <button name="Cencel" onclick="location.href='adminroom.php';">Cancel</button>
      </form>
    </div>
  </div>

</body>
</html>

<?php
}
?>
