<?php
include 'partials/header.php';

//fetch categories from database

$query = "SELECT * FROM categories ORDER BY title";

$categories = mysqli_query($connection, $query);

?>
<!-- -------------------------End of Nav------------------ -->

<section class="dashboard">

    <?php if (isset($_SESSION['add-category-success'])) : //show if add category was succesfull

    ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
        </p>
    </div>


    <?php elseif (isset($_SESSION['add-category'])) :  //show if add category was not succesfull

    ?>
    <div class="alert__message error container">
        <p>
            <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
        </p>
    </div>

    <?php elseif (isset($_SESSION['edit-category'])) :  //show if edit category was not succesfull

    ?>
    <div class="alert__message error container">
        <p>
            <?= $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
        </p>
    </div>


    <?php elseif (isset($_SESSION['edit-category-success'])) : //show if edit category was succesfull

    ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
        </p>
    </div>


    <?php elseif (isset($_SESSION['delete-category-success'])) : //show if delete category was succesfull

    ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
                ?>
        </p>
    </div>


    <?php endif ?>


    <div class="container dashboard__container">
        <!-- 
<aside> tag is used to define content aside from the content it is placed in.
The content inside the <aside> tag is typically related to the main content 
but can be considered separate from it
-->

        <button id="show__sidebar-btn" class="sidebar__toggle">
            <i class="uil uil-angle-right-b"></i>
        </button>
        <button id="hide__sidebar-btn" class="sidebar__toggle">
            <i class="uil uil-angle-left-b"></i>
        </button>

        <aside>
            <ul>
                <li>
                    <a href="add-post.php">
                        <i class="uil uil-edit-alt"></i>
                        <h5>Add post</h5>
                    </a>
                </li>

                <li>
                    <a href="index.php">
                        <i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_is_admin'])) : ?>

                <li>
                    <a href="add-user.php">
                        <i class="uil uil-user-plus"></i>
                        <h5>Add Users</h5>
                    </a>
                </li>

                <li>
                    <a href="manage-user.php">
                        <i class="uil uil-users-alt"></i>
                        <h5>Manage Users</h5>
                    </a>
                </li>

                <li>
                    <a href="add-category.php">
                        <i class="uil uil-edit"></i>
                        <h5>Add Category</h5>
                    </a>
                </li>

                <li>
                    <a href="manage-categories.php" class="active">
                        <i class="uil uil-list-ul"></i>
                        <h5>Manage Category</h5>
                    </a>
                </li>

                <?php endif ?>

            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>

            <?php if (mysqli_num_rows($categories) > 0) : ?>

            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Here loop through to fetch data from database -->

                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <tr>
                        <td><?= $category['title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>"
                                class="btn sm">Edit</a></td>
                        <td>
                            <a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>" class=" btn sm
                                danger">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
            <div class="alert__message error">
                <?= "No categories found" ?>
            </div>
            <?php endif ?>
        </main>
    </div>
</section>




<?php
// Here .. means out from current directory and 
// goes into partials directory to aces footer
include '../partials/footer.php';
?>