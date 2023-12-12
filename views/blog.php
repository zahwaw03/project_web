<?php 
    include_once 'extends/topbar.php';

    $featured_query = "SELECT * FROM posts WHERE is_featured=1";
    $featured_result = mysqli_query($connection, $featured_query);
    $featured = mysqli_fetch_assoc($featured_result);

    $query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
    $posts = mysqli_query($connection, $query);
?>
    <section class="search__bar">
      <form class="container search__bar-container">
        <div>
          <i class="uil uil-search"></i>
          <input type="search" name="" placeholder="Search" />
        </div>
        <button type="submit" class="btn">Go</button>
      </form>
    </section>

    <section class="posts">
      <div class="container posts__container">
        <?php while($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
          <div class="post__thumbnail">
            <img src="../assets/images/<?=$post['thumbnail']?>" alt="" />
          </div>
          <div class="post__info">
            <a href="blog.php" class="category__button">Anime</a>
            <h3 class="post__title">
              <a href="blog.php"><?=$post['title']?></a>
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
    
<?php 
    include_once 'extends/footer.php'
?>