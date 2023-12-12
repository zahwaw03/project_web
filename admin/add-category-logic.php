<?php

require 'config/database.php';

if(isset($_POST['submit'])){
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title){
        $_SESSION['add-category'] = "Enter title";
    }elseif(!$description){
        $_SESSION['add-category'] = "Enter description";
    }

    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add_category.php');
        die();
    }else{
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Couldn't add category";
            header('location:' .  ROOT_URL . 'admin/add_category.php');
            die();
        }else{
            $_SESSION['add-category-success'] = "Category $title Added";
            header('location:' . ROOT_URL . 'admin/manage_categories.php');
            die();
        }
    }
}


?>