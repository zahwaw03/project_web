<?php
require 'config/constants.php';
session_destroy();
header('location:' .  ROOT_URL . 'signin.php');
die();
?>