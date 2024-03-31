<?php
include 'partials/header.php';

if (isset($_GET['id'])) {

  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  //fetch category from database

  $query = "SELECT * FROM categories WHERE id='$id'";
  $result = mysqli_query($connection, $query);
  if (mysqli_num_rows($result) == 1) {
    // Fetch the next row of a result set as an associative array
    $category = mysqli_fetch_assoc($result);
  }
} else {
  header('location:' . ROOT_URL . 'admin/manage-categories.php');
  die();
}

?>
<!--This section contains the sign-up form.
     It likely has some specific styling or functionality
     associated with it.-->
<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Category</h2>
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">

            <!-- Here id should also have to be passed and type will be hidden 
            for security purpose it is needed for the updation of database
         -->

            <!-- 
            The name attribute in HTML is used to identify form controls when the form is submitted to the server.
            When a form is submitted, the data from form controls (like input fields, select elements, etc.) is 
            sent to the server as key-value pairs, where the name attribute specifies the key.
          -->

            <input type="hidden" name="id" value="<?= $category['id'] ?>" />
            <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title" />
            <textarea name="description" rows="4" placeholder="Description"><?= $category['description'] ?></textarea>
            <button type="submit" name="submit" class="btn">Update Category</button>
        </form>
    </div>
</section>



<?php
// Here .. means out from current directory and 
// goes into partials directory to aces footer
include '../partials/footer.php';
?>