<?php
session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
?>
<html lang = "en">
<head>
  <title>Admin room</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/adminroom.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
  <div style="display:block; margin:5px;">
    <a class="addclient" href="addclient.php">+</a>
    <a style="float:right;" href="logout.php">
      <span class="glyphicon glyphicon-log-out"></span>
    </a>
  </div>
  Client list:
</body>
</html>

<?php
}
?>
