<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail =  $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ?: 0;

    if(!$title){
        $_SESSION['add-post'] = "Enter post title!";
    }elseif (!$category_id){
        $_SESSION['add-post'] = "Enter post category!";
    }elseif (!$body){
        $_SESSION['add-post'] = "Enter post body!";
    }elseif (!$thumbnail['name']){ 
        $_SESSION['add-post'] = "Enter choose thumbnail!";
    }else{
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../assets/images/' . $thumbnail_name;
        
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extention = explode('.', $thumbnail_name);
        $extention = end($extention);
        if(in_array($extention, $allowed_files)){
            if($thumbnail['size'] < 2000000 ){
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            }else{
                $_SESSION['add-post'] = "File size too big";
            }
        }else{
            $_SESSION['add-post'] = "File should be png, jpg, or jpeg";
        }
    }
    if(isset($_SESSION['add-post'])){
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add_post.php');
        die();
    }else{
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)){
            $_SESSION['add-post-success'] = "New post added successfully";
            header('location:' . ROOT_URL . 'admin/index.php');
            die();
        }
    }

}

header('location:' . ROOT_URL . 'admin/add_post.php');
die();


?>