<?php 
    include_once 'partials/topbar.php';

    $current_user_id = $_SESSION['user-id'];
    $query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY id DESC ";
    $posts = mysqli_query($connection, $query);
?>
    <section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])) :?>
          <div class="alert__message success container">
          <p>
            <?= $_SESSION['add-post-success'];
            unset($_SESSION['add-post-success']); ?>
          </p>
        </div>
        <?php endif ?>
      <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left"></i></button>
        <aside>
          <ul>
            <li>
              <a href="add_post.php"
                ><i class="uil uil-pen"></i>
                <h5>Add Post</h5></a
              >
            </li>
            <li>
              <a href="index.php" class="active"
                ><i class="uil uil-postcard"></i>
                <h5 class="active">Manage Post</h5></a
              >
            </li>
            <?php if(isset($_SESSION['user_is_admin'])):?>
            <li>
              <a href="add_user.php"
                ><i class="uil uil-user-plus"></i>
                <h5>Add User</h5></a
              >
            </li>
            <li>
              <a href="manage_users.php" 
                ><i class="uil uil-users-alt"></i>
                <h5>Manage Users</h5></a
              >
            </li>
            <li>
              <a href="add_category.php"
                ><i class="uil uil-edit"></i>
                <h5>Add Category</h5></a
              >
            </li>
            <li>
              <a href="manage_categories.php" 
                ><i class="uil uil-list-ul"></i>
                <h5>Manage Categories</h5></a
              >
            </li>
            <?php endif ?>
          </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if (mysqli_num_rows($posts) > 0 ) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Title </th>
                        <th>Category </th>
                        <th>Delete</th>
                    </tr>
                    <tbody>
                      <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                        <?php
                        $category_id = $post['category_id'];
                        $category_query = "SELECT title FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <tr>
                            <td><?= $post['title'] ?></td>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete_post.php?=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </thead>
            </table>
            <?php else : ?>
              <div class="alert__message error"><?= 'No Posts Found' ?></div>
              <?php endif ?>
        </main>
      </div>
    </section>
<?php 
    include_once '../views/extends/footer.php'
?>