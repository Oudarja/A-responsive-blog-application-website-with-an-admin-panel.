<?php
include 'partials/header.php';

//fetch featured post from database


$featured_query = "SELECT * FROM posts WHERE is_featured=1";

$featured_result = mysqli_query($connection, $featured_query);

$featured = mysqli_fetch_assoc($featured_result);

//fetch all recent  posts from posts table ordering by date and time
// If there are fewer than 10 posts in the posts table, the SQL query 
//will still execute without any error. It will simply return all the
//available posts, ordered by date_time in descending order.
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 10";

$posts = mysqli_query($connection, $query);

?>


<?php if (mysqli_num_rows($featured_result) == 1) : ?>
<section class="featured">
    <div class="container featured__container">
        <div class="post__thumbnail">
            <img src="./images/<?= $featured['thumbnail'] ?>" />
        </div>

        <div class="post__info">

            <?php

                //fetch category from categories table using category_id of post

                $category_id = $featured['category_id'];

                $category_query = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($connection, $category_query);

                $category = mysqli_fetch_assoc($category_result);
                ?>

            <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
                class="category__button"><?= $category['title'] ?></a>
            <h2 class="post__title">
                <a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>">
                    <?= $featured['title'] ?>
                </a>
            </h2>
            <p class="post__body">
                <?=
                    // here full post is not showed rather just upto 300 characters only
                    substr($featured['body'], 0, 300)
                    ?>...
            </p>
            <div class="post__author">
                <?php

                    //fetch author from users table using author_id
                    $author_id = $featured['author_id'];

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
                        <?= date("M d,Y -H:i", strtotime($featured['date_time']))
                            ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>
<!-------------- End of featured ------------------------>


<!-- If there is no featured posts then add extra margin otherwise everything hides 
under navbars
 -->
<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
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
                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $post['category_id'] ?>"
                    class="category__button"><?= $category['title'] ?></a>
                <h3 class="post__title">
                    <a href="<?= ROOT_URL ?>post.php?id=<?= $post['category_id'] ?>">
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

<!------------------------ End of the post section-------------------- -->

<section class="category__buttons">
    <div class="container category__buttons-container">

        <?php

        $all_categories_query = "SELECT * FROM categories";

        $all_categories = mysqli_query($connection, $all_categories_query);

        ?>

        <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>

        <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category['id'] ?>"
            class="category__button"><?= $category['title'] ?></a>

        <?php endwhile ?>
    </div>
</section>

<!------------------------ End of the category buttons-------------------- -->
<!-- Adding footer -->

<?php

include 'partials/footer.php';

?>