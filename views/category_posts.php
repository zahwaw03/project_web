<?php 
    include_once 'extends/topbar.php';
?>
    <header class="category__title">
      <h2>Anime</h2>
    </header>

    <section class="posts">
      <div class="container posts__container">
        <article class="post">
          <div class="post__thumbnail">
            <img src="images/post2.jpg" alt="" />
          </div>
          <div class="post__info">
            <a href="category_posts.html" class="category__button">Anime</a>
            <h3 class="post__title">
              <a href="post.html">Lorem ipsum dolor sit amet.</a>
            </h3>
            <p class="post__body">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident
              natus sit doloribus, sint magni ab deleniti tenetur quos.
            </p>
            <div class="post__author">
              <div class="post__author-avatar">
                <img src="images/icons.jpg" alt="" />
              </div>
              <div class="post__author-info">
                <h5>By. Ahn Yujin</h5>
                <small>June 1, 2045 - 10:45</small>
              </div>
            </div>
          </div>
        </article>
      </div>
    </section>
<?php 
    include_once 'extends/footer.php'
?>