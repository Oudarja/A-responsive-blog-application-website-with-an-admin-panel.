<?php
include 'partials/header.php';

//fetch categories from database

$category_query = "SELECT * FROM categories";

$categories = mysqli_query($connection, $category_query);
//fetch post datatbase from datatset if id is set
if (isset($_GET['id'])) {

  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id=$id";
  $result = mysqli_query($connection, $query);
  $post = mysqli_fetch_assoc($result);
} else {
  header('location:' . ROOT_URL . 'admin/');
  die();
}



?>
<!--This section contains the sign-up form.
It likely has some specific styling or functionality
associated with it.  -->
<section class="form__section">
  <div class="container form__section-container">
    <h2>Edit Post</h2>

    <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
      <input type="hidden" name="id" value="<?= $post['id'] ?>" />
      <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>" />
      <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title" />
      <!-- This is for select option -->
      <select name="category">
        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
          <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile ?>
      </select>
      <textarea rows="10" name="body" placeholder="Description"><?= $post['body'] ?></textarea>
      <div class="form__control inline">
        <input type="checkbox" id="is_featured" name="is_featured" value="1" checked />
        <label for="is_featured">Featured</label>
      </div>
      <div class="form__control">
        <label for="is_featured">Change Thumbnail</label>
        <!-- 

    This is an <input> element of type "file". 
    It allows users to choose and upload files
    from their device.
     -->
        <input type="file" id="thumbnail" name="thumbnail" />
      </div>
      <button type="submit" name="submit" class="btn">Update Post</button>
    </form>
  </div>
</section>

<?php
// Here .. means out from current directory and 
// goes into partials directory to aces footer
include '../partials/footer.php';
?>