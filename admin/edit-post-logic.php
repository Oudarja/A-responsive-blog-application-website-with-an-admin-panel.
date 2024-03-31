<?php

require 'config/database.php';

//make sure edit post button was clicked

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if it was unchecked

    $is_featured = $is_featured == 1 ?: 0;


    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Tnvalid form data on edit post page. Title missing";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Tnvalid form data on edit post page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Tnvalid form data on edit post page. Body missing";
    } else {

        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images' . $previous_thumbnail_name;

            //as new thumbnail is available so unlink the previous one
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }


            //WORK ON NEW THUMBNAIL
            //REname image

            $time = time();

            $thumbnail_name = $time . $thumbnail['name'];

            $thumbnail_tmp_name = $thumbnail['tmp_name'];

            $thumbnail_destination_path = '../images/' . $thumbnail_name;




            //make sure file is an image

            $allowed_files = ['png', 'jpg', 'jpeg'];

            $extension = explode('.', $thumbnail_name);

            $extension = end($extension);


            if (in_array($extension, $allowed_files)) {
                //make sure avavtr is not too large

                if ($thumbnail['size'] < 5000000) {

                    //upload avatar

                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Could not update post thumbnail size is too big.Should
                    be less than 5 mb";
                }
            } else {
                $_SESSION['edit-post'] = "Could not update post. Thumbnail should be png, jpg or jpeg";
            }
        }
    }

    //If there is any issue in the form hen redirect to form manage page
    if ($_SESSION['edit-post']) {
        //

        header('location:' . ROOT_URL . 'admin/');
        die();
    } else {
        //set is_featured of all posts to 0 if is_featured for this post is 1
        //as now this new updated post will be featured post so previous featured
        // post should be out of featured post so make 0

        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }


        //set thumbnail name if a new one was uploaded, else keep old 
        //thumbnail name

        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;


        $query = "UPDATE posts SET title='$title',body='$body',thumbnail='$thumbnail_to_insert',category_id='$category_id',
                 is_featured='$is_featured' WHERE id=$id LIMIT 1";

        $result = mysqli_query($connection, $query);
    }


    if (!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
}



header('location:' . ROOT_URL . 'admin/');

//If this die() is commented out then updation can be done as many times as i want 
//but with this just once i can update 
die();