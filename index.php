<?php
session_start();
if(!isset($_SESSION['valid'])) {
  header("Location: login.php");
  exit();
} else {
  header("Location: adminroom.php");
  exit();
}
?>
