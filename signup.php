<?php

require 'config/constant.php';

//get back form data if there is a registration 
//if there is no error then variable will be initialized with null
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
//delete the sessiom

unset($_SESSION['signup-data']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multi-page Blog Website with Responsive Design</title>

    <!--Custom stylesheet-->
    <!-- The rel attribute specifies the relationship between 
        the current HTML document and the linked CSS stylesheet -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <!--This section contains the sign-up form.
It likely has some specific styling or functionality
associated with it.  -->
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Sign Up</h2>

            <?php if (isset($_SESSION['signup'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signup'];
                        unset($_SESSION['signup']);
                        ?>
                </p>
            </div>

            <?php endif ?>
            <!-- When click on the submit the action performed in  signup-logic.php 
             and to access the signup-logic root url has been used

            In HTML forms, the method attribute specifies the HTTP method used
            to submit the form data to the server. When method is set to "post", 
            it means that the form data will be sent to the server using the HTTP POST method.
            In the context of HTTP:
            
            GET: Requests data from a specified resource.
            POST: Submits data to be processed to a specified resource.
            -->
            <!-- <?  //variable
                    ?> This is php mode -->

            <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" />
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" />
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username" />
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email" />
                <input type="password" name="createpassword" value="<?= $createpassword ?>"
                    placeholder="Create Password" />
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>"
                    placeholder="Confirm Password" />
                <div class="form__control">
                    <label for="avatar">User avatar</label>
                    <input type="file" name="avatar" id="avatar" />
                </div>

                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account?<a href="signin.php"> Sign In </a></small>
            </form>
        </div>
    </section>
</body>

</html>