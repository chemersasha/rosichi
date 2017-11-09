<?php header('Content-type: text/html; charset=utf-8');
require_once('DBManager.php');

session_start();
$msg = '';
if (!empty($_POST['username']) && !empty($_POST['password'])) {
  $DBManager = new DBManager();
  $DBManager->openConnection();
  $username = $_POST['username'];
  $user = mysqli_fetch_array($DBManager->runQuery("SELECT * FROM users WHERE name='$username'"));
  $DBManager->closeConnection();

  if (md5($_POST['password']) == $user['pass']) {
    $_SESSION['valid'] = true;
    $_SESSION['username'] = $username;
  }else {
    $msg = 'Wrong username or password';
  }
}
if(!isset($_SESSION['valid'])) {
?>
<html lang = "en">
<head>
  <title>Login</title>
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/form.css">
</head>

<body>
<div class="form-content">
  <div class="form">
    <form role="form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <p class="message"><?php echo $msg; ?></p>
      <div style="width:70px;display:inline-block;">Username:</div>
      <input type="text" name="username" placeholder="username" required autofocus></br>
      <div style="width:70px;display:inline-block;">Password:</div>
      <input type="password" name="password" placeholder="password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</div>
</body>
</html>

<?php
} else {
  header("Location: adminroom.php");
  exit();
  // require_once('adminroom.php');
}
?>
