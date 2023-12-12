<?php
require '../config/database.php';

if(isset($_SESSION['user-id'])){
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT avatar FROM users WHERE id='$id'";
  $result = mysqli_query($connection, $query);
  $avatar = mysqli_fetch_assoc($result);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Arvci</title>
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.8/css/line.css"
    />
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/styles.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <nav>
      <div class="container nav__container">
        <a href="<?= ROOT_URL ?>/views/home.php" class="nav__logo">Arvci</a>
        <ul class="nav__items">
          <li><a href="<?= ROOT_URL ?>/views/blog.php">Blog</a></li>
          <li><a href="<?= ROOT_URL ?>/views/about.php">About</a></li>
          <li><a href="<?= ROOT_URL ?>/views/services.php">Services</a></li>
          <li><a href="<?= ROOT_URL ?>/views/contact.php">Contact</a></li>
          <?php if(isset($_SESSION['user-id'])):?>
          <li class="nav__profile">
            <div class="avatar">
              <img src="<?= ROOT_URL . '/assets/images/' . $avatar['avatar'] ?>"/>
            </div>
            <ul>
              <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
              <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
            </ul>
          </li>
          <?php else : ?>
            <li><a href="<?= ROOT_URL ?>signin.php">Sign In</a></li>
            <?php endif ?>
        </ul>
        <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
      </div>
    </nav>