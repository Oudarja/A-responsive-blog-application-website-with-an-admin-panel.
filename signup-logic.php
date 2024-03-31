<?php

require 'config/database.php';

//get signup form data if signup button is clicked

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    //validate input values

    if (!$firstname) {
        $_SESSION['signup'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['signup'] = "Please enter your Username Name";
    } elseif (!$email) {
        $_SESSION['signup'] = "Please enter your valid email";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Password should be of minimum eight characters";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Please add avatar";
    } else {
        //check if password don't match
        if ($createpassword !== $confirmpassword) {

            $_SESSION['signup'] = "passwords do not match";
        } else {
            //hash password
            //The default algorithm to use for hashing if no algorithm is provided. 
            //This may change in newer PHP releases when newer, stronger hashing algorithms are supported.
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // echo $createpassword . '<br/>';
            // echo $hashed_password;

            //Check is the username or email alrady exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username'OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);


            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exist";
            } else {

                //Work on avatar
                //number of seconds from january 1st 1970
                $time = time(); //making each avatar unique using timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;


                //make sure file is an image

                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                if (in_array($extension, $allowed_files)) {
                    //make sure image is not too large
                    if ($avatar['size'] < 2000000) {
                        //upload avatar

                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = "File size is too big. Should be less than 1 mb";
                    }
                } else {
                    $_SESSION['signup'] = "File should be png,jpg or jpeg";
                }
            }
        }
    }

    //redirect back to signup page if there is any problem

    if (isset($_SESSION['signup'])) {
        //pass form data back to sign up page
        //An associative array of variables passed to the current script via the HTTP POST method.
        $_SESSION['signup-data'] = $_POST;
        header('location:' . ROOT_URL . 'signup.php');
        die();
    } else {
        $insert_user_query = "INSERT INTO users(firstname,lastname,username,email,password,avatar,is_admin)VALUES('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name',0)";
        $insert_user_query = mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)) {

            //redirect to sign in page with sucess message 
            $_SESSION['signup-success'] = "Registration successful. Please log in";
            header('location:' . ROOT_URL . 'signin.php');
            die();
        }
    }
} else {
    header('location' . ROOT_URL . 'signup.php');
    die();
}
