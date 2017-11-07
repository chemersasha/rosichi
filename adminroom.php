<?php
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
      <th>First name</th>
      <th>Last name</th>
    </tr></thead>
    <tbody class="table-hover">
    <?php
      while ($client = mysqli_fetch_assoc($clients)) {
        echo "<tr>";
        echo "<td>".$client['id']."</td>";
        echo "<td>".$client['firstname']."</td>";
        echo "<td>".$client['lastname']."</td>";
        echo "</tr>";
      }
    ?>
    </tbody>
  </table>

</body>
</html>

<?php
}
?>
