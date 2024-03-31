<?php
//all header element comes from partial header
require '../partials/header.php';

//check login status
if (!isset($_SESSION['user-id'])) {
    header('location:' . ROOT_URL . 'signin.php');
    die();
}