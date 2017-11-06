<?php
session_start();
if(!isset($_SESSION['valid'])) {
  echo 'You are not logged';
} else {
  if (!empty($_POST['clientid']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {
    
  } else {
    echo "Some data is empty";
  }
}
?>
