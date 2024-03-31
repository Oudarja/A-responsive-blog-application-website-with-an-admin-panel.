<?php

require 'config/database.php';


//fetch current user from database

if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

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
    <!-- <nav> tag is used to define a section of a webpage that contains navigation links, typically
     leading to other pages within the same website or to different sections of the current page -->
    <nav>
        <!-- <div> tag is a fundamental element used to create divisions or sections in a web page. 
        The <div> tag does not have any inherent semantic meaning; rather, it is a generic container 
        that allows you to group together related elements or content and apply styling or structure to them using CSS. -->

        <!-- two classes container and nav_container. A space between 2 class name -->
        <div class="container nav_container">
            <!-- inside the <div>, there's an <a> (anchor) element, which
                 typically represents a hyperlink. It has an href attribute 
                 set to "index.html", which means it's linking to the "index.html"
                  page. -->
            <a href="<?= ROOT_URL ?>" class="nav__logo">Blog Le Mien</a>

            <ul class="nav__items">
                <!-- Here accesing each page link with root URL 
                     which has been described in constant.php
                 -->
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>

                <?php if (isset($_SESSION['user-id'])) : ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" />
                    </div>
                    <ul>
                        <!-- as dashboard is under admin folder so after 
                              root url admin is to be provided for accessing 
                        -->
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <!-- and log out is in main directory -->
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <?php endif ?>
            </ul>
            <!-- Here 2 button has been created one with bar menu 
           and other is close button with cross or multiply symbol
           this 2 icon is takenm from iconscout cdn -->
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>

            <!-- How to know responsive -->

            <!-- The presence of buttons with icons for opening and closing a 
            navigation menu (<button id="open__nav-btn"> and <button id="close__nav-btn">)
            suggests that the navigation bar may be designed to collapse or toggle into a
            mobile-friendly menu on smaller screens. This is a common pattern in responsive
            web design to accommodate limited screen space on mobile devices. -->

            <!-- The use of an unordered list (<ul>) for the navigation items (<li>) provides a
                 flexible structure that can easily adapt to different screen sizes and orientations.
                 This is a common approach in responsive design to create scalable and accessible navigation menus. 
            -->
        </div>
    </nav>