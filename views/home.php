<?php 
    include_once 'extends/topbar.php';

    $featured_query = "SELECT * FROM posts WHERE is_featured=1";
    $featured_result = mysqli_query($connection, $featured_query);
    $featured = mysqli_fetch_assoc($featured_result);

    $query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
    $posts = mysqli_query($connection, $query);
?>

<?php if (mysqli_num_rows($featured_result) == 1) : ?>
<section class="featured">
      <div class="container featured__container">
        <div class="post__thumbnail">
          <img src="../assets/images/<?= $featured['thumbnail'] ?>" alt="" />
        </div>
        <div class="post__info">
          <?php
          $category_id = $featured['category_id'];
          $category_query = "SELECT * FROM categories WHERE id=$category_id";
          $category_result = mysqli_query($connection, $category_query);
          $category = mysqli_fetch_assoc($category_result);
          ?>
          <a href="home.php" class="category__button"><?= $category['title'] ?></a>
          <h2 class="post_title">
            <a href="home.php"><?= $featured['title'] ?></a>
          </h2>
          <p class="post__body">
          <?= substr($featured['body'], 0, 300) ?>...
          </p>
            <?php
            $author_id = $featured['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
          ?>
          <div class="post__author">
            <div class="post__author-avatar">
              <img src="../assets/images/<?=$author['avatar']?>" alt="" />
            </div>
            <div class="post__author-info">
              <h5>By.<?= "{$author['firstname']} {$author['lastname']}" ?> </h5>
              <small><?= date("M d, Y - H:i", strtotime($featured['date_time']))  ?></small>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="posts">
      <div class="container posts__container">
        <?php while($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
          <div class="post__thumbnail">
            <img src="../assets/images/<?=$post['thumbnail']?>" alt="" />
          </div>
          <div class="post__info">
            <a href="home.php" class="category__button">Anime</a>
            <h3 class="post__title">
              <a href="home.php"><?=$post['title']?></a>
            </h3>
            <p class="post__body">
            <?= substr($post['body'], 0, 100) ?>...
            </p>
            <?php
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post__author">
              <div class="post__author-avatar">
                <img src="../assets/images/<?=$author['avatar']?>" alt="" />
              </div>
              <div class="post__author-info">
                <h5>By. <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($featured['date_time']))  ?></small>
              </div>
            </div>
          </div>
        </article>
        <?php endwhile ?>
      </div>
    </section>

    <section class="category__buttons">
      <div class="container category__buttons-container">
        <a href="home.php" class="category__button">Anime</a>
        <a href="home.php" class="category__button">Travel</a>
        <a href="home.php" class="category__button">Art</a>
        <a href="home.php" class="category__button">Education</a>
        <a href="home.php" class="category__button">Food</a>
        <a href="home.php" class="category__button">Music</a>
      </div>
    </section>

    <?php endif ?>

<?php 
    include_once 'extends/footer.php'
?>