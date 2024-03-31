<?php
include 'partials/header.php';



//fecth posts if id is set


if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY 
   date_time DESC";

    $posts = mysqli_query($connection, $query);
} else {
    header('location:' . ROOT_URL . 'blog.php');
    die();
}

?>

<header class="category__title">

    <h2>
        <?php

        //fetch category from categories table using category_id of post

        $category_id = $id;
        //From category table find the row where  $categorry_id= category table's id
        //and then print that title
        $category_query = "SELECT * FROM categories WHERE id=$category_id";
        $category_result = mysqli_query($connection, $category_query);
        $category = mysqli_fetch_assoc($category_result);
        echo $category['title']
        ?>
    </h2>
</header>
<!-- End of category title -->

<!-- Check if category has any posts otherwise sgow message -->

<?php if (mysqli_num_rows($posts) > 0) : ?>
    <section class="posts">
        <div class="container posts__container">

            <!-- loop through posts table and fetch all and show  -->


            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>

                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $post['thumbnail']  ?>" />
                    </div>
                    <div class="post__info">


                        <?php

                        //fetch category from categories table using category_id of post

                        $category_id = $post['category_id'];
                        //From category table find the row where  $categorry_id= category table's id
                        //and then print that title
                        $category_query = "SELECT * FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);

                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <!-- Here in Category link   id is laso passed as when click on the link 
                     using this id all posts of this category can be shown 
                -->
                        <h3 class="post__title">
                            <a href="post.php">
                                <?=
                                $post['title']
                                ?>
                            </a>
                        </h3>
                        <p class="post__body">
                            <?=
                            substr($post['body'], 0, 300)
                            ?>...
                        </p>
                        <div class="post__author">

                            <?php

                            //fetch author from users table using author_id
                            $author_id = $post['author_id'];

                            $author_query = "SELECT * FROM users WHERE id=$author_id";

                            $author_result = mysqli_query($connection, $author_query);

                            $author = mysqli_fetch_assoc($author_result);

                            ?>
                            <div class="post__author-avatar">
                                <img src="./images/<?= $author['avatar'] ?>" />
                            </div>
                            <div class="post__author-info">
                                <h5>By : <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small>
                                    <?= date("M d,Y -H:i", strtotime($post['date_time']))
                                    ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </article>

            <?php endwhile ?>
        </div>
    </section>

<?php else : ?>

    <div class="alert__message error lg">
        <p>
            No posts found for this category.
        </p>
    </div>
<?php endif ?>
<!------------------------ End of the post section-------------------- -->

<section class="category__buttons">
    <div class="container category__buttons-container">

        <?php

        $all_categories_query = "SELECT * FROM categories";

        $all_categories = mysqli_query($connection, $all_categories_query);

        ?>

        <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>

            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>

        <?php endwhile ?>
    </div>
</section>

<!------------------------ End of the category buttons-------------------- -->

<?php

include 'partials/footer.php';

?>