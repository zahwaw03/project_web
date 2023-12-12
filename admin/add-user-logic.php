<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    if(!$firstname){
        $_SESSION['add-user'] = "Please enter your First Name!";
    }elseif (!$lastname){
        $_SESSION['add-user'] = "Please enter your Last Name!";
    }elseif (!$username){
        $_SESSION['add-user'] = "Please enter your Username!";
    }elseif (!$email){
        $_SESSION['add-user'] = "Please enter your a valid email!";
    }elseif (strlen($createpassword) < 8 || strlen ($confirmpassword) < 8) {
        $_SESSION['add-user'] = "Password should be 8+ characters!";
    }elseif (!$avatar['name']){
        $_SESSION['add-user'] = "Please add avatar!";
    }else{
        // check if password doesnt match
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = "Passwords do not match";
        } else {
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            //check if username or email is already exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'" ;
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result)> 0){
                $_SESSION['add-user'] = "Username or Email already exist";

            }else {
                //work on avatar
                //rename avatar
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../assets/images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name );
                $extention= end($extention); 
                if(in_array($extention, $allowed_files)){
                    //make sure image not too large (1mb+)
                    if($avatar['size'] < 1000000){
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else {
                        $_SESSION['add-user'] = 'file size is too big';
                    }
                }else{
                    $_SESSION['add-user'] = "file should be png, jpg, or jpeg";
                }
            }
        }   
    }

    // redirect back to sign up page if there was any problem
    if(isset($_SESSION['add-user'])){
        //pass form data back to sign up page
        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add_user.php');
        die(); 
    }else {
        //insert new user into user table
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=$is_admin";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            $_SESSION['add-user-success'] = "New User $firstname $lastname added successfully.";
            header('location:' . ROOT_URL . 'admin/manage_users.php');
        }
    }
}else{
    //if button wasnt clicked, bounce back to sign up page
    header('location:' . ROOT_URL . 'admin/add_user.php');
    die();
}
?>