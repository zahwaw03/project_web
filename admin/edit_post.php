<?php 
    include 'partials/topbar.php';

    $category_query = "SELECT * FROM categories";
    $categories = mysqli_query($connection, $category_query);

    if(isset($_GET['title'])){
      $id = filter_var($_GET['title'], FILTER_SANITIZE_NUMBER_INT);
      $query = "SELECT * FROM posts WHERE title=$title";
      $result = mysqli_query($connection, $query);
      $post = mysqli_fetch_array($result);
    }
?>
    <section class="form__section">
      <div class="container form__section-container">
        <h2>Edit Post</h2>
        <div class="alert__message error">
          <p>This is an error message</p>
        </div>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id" value="<?= isset($post['id']) ? $post['id'] : '' ?> ">
        <input type="text" name="firstname" value="<?= $post['title'] ?>"/>

          <select name="category">
            <?php while($category = mysqli_fetch_assoc($categories)) : ?>
              <option value="<?= $category['id'] ?>"> <?= $category['title'] ?> </option>
            <?php endwhile ?>
          </select>
          <textarea rows="10" placeholder="Body" name="body"><?= isset($post['body']) ? $post['body'] : '' ?></textarea>

          <div class="form__control inline">
          <input type="checkbox" id="is_featured" name="is_featured" value="1" <?php if (isset($post['is_featured']) && $post['is_featured'] == 1) echo "checked" ?> />

            <label for="is_featured">Featured</label>
          </div>
          <div class="form__control">
            <label for="thumbnail">Change Thumbnail</label>
            <input type="file" id="thumbnail" name="thumbnail" />
          </div>
          <button type="submit" class="btn">Update Post</button>
        </form>
      </div>
    </section>
<?php 
    include_once '../views/extends/footer.php'
?>