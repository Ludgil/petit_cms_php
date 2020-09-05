<?php

if(isset($_POST['create_post'])){

    $post_title = $_POST['title'];
    $post_user = $_POST['post_user'];
    $post_category_id = $_POST['post_category'];
    $post_status= $_POST['post_status'];

  
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

  
    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date,
    post_image, post_content, post_tag, post_status) ";
    $query .="VALUE('{$post_category_id}', '{$post_title}', '{$post_user}', now(),
    '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

    ConfirmQuery($query);
    $the_post_id = $bdd->lastInsertId();

    echo "<p class='bg-success'>Post created. <a href='../post.php?p_id={$the_post_id}'>View Posts</a> or
       <a href='posts.php'> Edit Posts</a></p>";

}

?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>

  <div class="form-group">

  <label for="post_category">Post Category</label>

  <?php if(isset($error)){
    echo $error;
  } ?>

  <select name="post_category" id="post_category">
    
    <option value="0">Select an option</option>
    <?php 

         $query= "SELECT * FROM categories";

         $select_categories = $bdd->prepare($query);
         $select_categories->execute();

         while($row = $select_categories->fetch(PDO::FETCH_ASSOC)){
             
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];
          
          echo "<option value='{$cat_id}'>{$cat_title}</option>";
         
        }
     
    ?>
  
  
  </select>
</div>

<div class="form-group">

  <label for="users">Users</label>

  <?php if(isset($error)){
    echo $error;
  } ?>

  <select name="users" id="users">
    
    <option value="0">Select an option</option>
    <?php 

         $users_query= "SELECT * FROM users";

         $select_users = $bdd->prepare($users_query);
         $select_users->execute();

         while($row = $select_users->fetch(PDO::FETCH_ASSOC)){
             
          $user_id = $row['user_id'];
          $username = $row['username'];
          
          echo "<option value='{$username}'>{$username}</option>";
         
        }
     
    ?>
  
  
  </select>
</div>

  <!-- <div class="form-group">
    <label for="author">Post Author</label>
    <input type="text" class="form-control" name="author">
  </div> -->

  <div class="form-group">
    <label for="post_status">Post Status</label>
    <select name="post_status" id="">
        <option value="draft">Select Options</option>
        <option value="published">Published</option>
        <option value="draft">Draft</option>
    </select>
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" class="form-control" name="image">
  </div>

  <div class="form-group">
    <label for="post_tags">Posts Tags</label>
    <input type="text" class="form-control" name="post_tags">
  </div>

  <div class="form-group">
    <label for="post_content">Posts Content</label>
    <textarea class="form-control" name="post_content" cols="30" rows="10" id="body"></textarea>
  </div>


  <button type="submit" class="btn btn-primary" name="create_post" value="Publish Post">Submit</button>
</form>