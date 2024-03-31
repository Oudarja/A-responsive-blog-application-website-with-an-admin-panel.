<?php

require 'config/database.php';


if (isset($_POST['submit'])) {

    //get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);



    if (!$title) {
        $_SESSION['add-category'] = "Enter title";
    } else if (!$description) {
        $_SESSION['add-category'] = "Enter description";
    }

    //redirect back to add category page with form data if there 
    //was in valid inpit 

    if (isset($_SESSION['add-category'])) {

        // here $_POST is a super global which is accessible in any page
        //if there is any problem then the data is reserved back by this
        $_SESSION['add-category-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        //insert category into database

        $query = "INSERT INTO categories (title,description) VALUES ('$title','$description')";

        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Could not add category";
            header('location:' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "Category $title added successfully";
            header('location:' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }
}
