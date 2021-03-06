<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');
require_once('src/dateconverter.php');

session_start();
if(!isset($_SESSION['valid'])) {
  echo 'you are not logged';
} else {
  $DBManager = new DBManager();
  $DBManager->openConnection();

  $queryString = "SELECT * FROM clients";
  // $whereKeyWord = '';
  if(isset($_GET['section']) && mb_strtoupper($_GET['section'])!==mb_strtoupper('Все')) {
    $sectionValue = $_GET['section'];
    $querySectionCondition = 'section="'.$_GET['section'].'"';
    $whereKeyWord = ' WHERE ';
  }
  if(isset($_GET['firstname']) && mb_strtoupper($_GET['firstname'])!==mb_strtoupper('')) {
    $queryFirstNameCondition = 'lower(firstname) like "%'.$_GET['firstname'].'%"';
    if(isset($whereKeyWord)) {
      $queryFirstNameCondition = ' AND '.$queryFirstNameCondition;
    }
    $whereKeyWord = ' WHERE ';
  }
  if(isset($_GET['lastname']) && mb_strtoupper($_GET['lastname'])!==mb_strtoupper('')) {
    $queryLastNameCondition = 'lower(lastname) like "%'.$_GET['lastname'].'%"';
    if(isset($whereKeyWord)) {
      $queryLastNameCondition = ' AND '.$queryLastNameCondition;
    }
    $whereKeyWord = ' WHERE ';
  }
  if(isset($whereKeyWord)) {
    $queryString = $queryString.$whereKeyWord;
  }
  if(isset($querySectionCondition)) {
    $queryString = $queryString.$querySectionCondition;
  }
  if(isset($queryFirstNameCondition)) {
    $queryString = $queryString.$queryFirstNameCondition;
  }
  if(isset($queryLastNameCondition)) {
    $queryString = $queryString.$queryLastNameCondition;
  }

  $clients = $DBManager->runQuery($queryString);
  $DBManager->closeConnection();
?>
<html lang="en">
<head>
  <title>Admin room</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/adminroom.css">
  <link rel="stylesheet" href="css/tableList.css">
  <link rel="stylesheet" href="jquery/jquery-ui.min.css">
  <style>
    .ui-widget {
      font-family: "Roboto", sans-serif;
      font-size: 14px;
    }
  </style>
  <script src="jquery/external/jquery/jquery.js"></script>
  <script src="jquery/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $("#removeClientDialog").dialog({
        modal:true,
        width:400,
        height:285,
        autoOpen:false
      });
    });
    function addVisit(clientId) {
      $("#client"+clientId+"Visits").html('<img src="css/img/loader.gif" style="height:16px;width:16px;">');
      $.ajax({
        type: "POST",
        url: "src/model/addvisit.php",
        data: {"clientId":clientId},
        success: function(responseText) {
            var data = JSON.parse(responseText);
            $("#client"+data.clientId+"Visits").html(data.visits+' <button class="plus" onclick="addVisit('+data.clientId+')"><img src="css/img/plus.png"/></button>');
        }
      });
    }
    function removeClient(clientId, name) {
      $("#removeClientDialog").dialog({
        open: function() {
          $('#removeClientDialog').html('<p><b>Name:</b> '+name+'</p><p>Are you sure?</p>');
        },
        buttons: {
          "Yes": function() {
            $(this).dialog("close");
            location.href='removeclient.php?id='+clientId;
            return false;
          },
          "No": function() {
            $(this).dialog("close");
          }
        }
      });
      $("#removeClientDialog").dialog("open");
    }
  </script>
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
  <form role="form" class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get" style="border:black solid 1px;">
    <table><tr>
      <td>
        First name:
        <input value="<?php if(isset($_GET['firstname'])){ echo $_GET['firstname'];}?>" type="text" name="firstname" placeholder="first name">
      </td>
      <td>
        Last name:
        <input value="<?php if(isset($_GET['firstname'])){ echo $_GET['lastname'];}?>" type="text" name="lastname" placeholder="last name">
      </td>
      <td>
        Section:
        <?php
          $sectionId='section';
          $items = array('Все');
          include('src/views/sections.php');
        ?>
      </td>
      <td>
        <button type="submit">Filter</button>
      </td></tr>
    </table>
  </form>
  <table class="table-fill">
    <thead><tr>
      <th>Name</th>
      <th style="width:100px;text-align:center">Section</th>
      <th style="width:100px;text-align:center">From</th>
      <th style="width:100px;text-align:center">To</th>
      <th style="width:70px;text-align:center">Visits</th>
      <th style="width:32px;"></th>
      <th style="width:32px;"></th>
    </tr></thead>
    <tbody class="table-hover">
    <?php
      while ($client = mysqli_fetch_assoc($clients)) {
        echo '<tr>';
        echo '<td onclick="location.href=\'viewclient.php?id='.$client['id'].'\'; return false;">'.$client['firstname'].' '.$client['lastname'].'</td>';
        echo '<td onclick="location.href=\'viewclient.php?id='.$client['id'].'\'; return false;" class="text-center">'.$client['section'].'</td>';
        echo '<td onclick="location.href=\'viewclient.php?id='.$client['id'].'\'; return false;" class="text-center">'.serverDateToClientDate($client['datefrom']).'</td>';
        echo '<td onclick="location.href=\'viewclient.php?id='.$client['id'].'\'; return false;" class="text-center">'.serverDateToClientDate($client['dateto']).'</td>';
        echo '<td class="text-center"><span id="client'.$client['id'].'Visits">'.$client['visits'].' <button class="plus" onclick="addVisit('.$client['id'].')"><img src="css/img/plus.png"/></button></span></td>';
        echo '<td><a class="editclient" href="editclient.php?id='.$client['id'].'"><img src="css/img/edit.png"/></a></td>';
        echo '<td><a class="removeclient" onclick="removeClient('.$client['id'].',\''.$client['firstname'].' '.$client['lastname'].'\')"><img src="css/img/trash.png"/></a></td>';
        echo '</tr>';
      }
    ?>
    </tbody>
  </table>

  <div id="removeClientDialog" title="Remove client"></div>
</body>
</html>

<?php
}
?>
