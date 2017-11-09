<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $DBManager = new DBManager();
  $DBManager->openConnection();
  $clients = $DBManager->runSelectQuery("SELECT * FROM clients");
  $DBManager->closeConnection();
?>
<html lang = "en">
<head>
  <title>Admin room</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/adminroom.css">
  <link rel="stylesheet" href="css/tableList.css">
</head>

<body>
  <div class="toppanel">
    <a class="addclient" href="addclient.php">
      <img src="css/img/addclient.png"/>
    </a>
    <a class="logout" href="logout.php">
      <img src="css/img/logout.png"/>
    </a>
  </div>
  <br/>
  <table class="table-fill">
    <thead><tr>
      <th>Client id</th>
      <th>Name</th>
      <th style="width:32px;"></th>
      <th style="width:32px;"></th>
    </tr></thead>
    <tbody class="table-hover">
    <?php
      while ($client = mysqli_fetch_assoc($clients)) {
        echo '<tr>';
        echo '<td onclick="location.href=\'viewclient.php?id='.$client['id'].'\'; return false;">'.$client['id'].'</td>';
        echo '<td onclick="location.href=\'viewclient.php?id='.$client['id'].'\'; return false;">'.$client['firstname'].' '.$client['lastname'].'</td>';
        echo '<td><a class="editclient" href="editclient.php?id='.$client['id'].'"><img src="css/img/edit.png"/></td>';
        echo '<td>remove</td>';
        echo '</tr>';
      }
    ?>
    </tbody>
  </table>

</body>
</html>

<?php
}
?>
