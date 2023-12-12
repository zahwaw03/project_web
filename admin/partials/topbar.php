<?php
require '../views/extends/topbar.php';

if(!isset($_SESSION['user-id'])){
  header('location:' . ROOT_URL . 'signin.php');
  die();
}
?>
