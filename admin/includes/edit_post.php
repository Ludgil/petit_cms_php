<?php


if(isset($_GET['p_id'])){

  $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_posts_by_id = $bdd->prepare($query);
$select_posts_by_id->execute();
while($row = $select_posts_by_id->fetch(PDO::FETCH_ASSOC)){

    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_content = $row['post_content'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tag = $row['post_tag'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    
}

if(isset($_POST['update_post'])){

    $post_title = $_POST['title'];
    $post_user = $_POST['post_user'];
    $post_category_id = $_POST['post_category'];
    $post_status= $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)){

      $query_image = "SELECT * FROM posts WHERE post_id = {$the_post_id}";

      $select_image = $bdd->prepare($query_image);
      $select_image->execute();

      while($row = $select_image->fetch(PDO::FETCH_ASSOC)){
          $post_image = $row['post_image'];
      }
    }

    $query_update_post = "UPDATE posts SET ";
    $query_update_post .="post_title = '{$post_title}', ";
    $query_update_post .="post_category_id = '{$post_category_id}', ";
    $query_update_post .="post_date = now(), ";
    $query_update_post .="post_user = '{$post_user}', ";
    $query_update_post .="post_status = '{$post_status}', ";
    $query_update_post .="post_tag = '{$post_tags}', ";
    $query_update_post .="post_content = '{$post_content}', ";
    $query_update_post .="post_image = '{$post_image}' ";
    $query_update_post .="WHERE post_id = '{$the_post_id}' ";

    if($_POST['post_category'] === 0){

      $error = "choose a category pls";
     
    }else{

      ConfirmQuery($query_update_post);

      echo "<p class='bg-success'>Your post Has been Updated <a href='../post.php?p_id={$the_post_id}'>View Posts</a> or
       <a href='posts.php'> Edit More Posts</a></p>";

    }
}



?>
<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
  <label for="title">Post Title</label>
  <input value="<?php echo $post_title ?>" type="text" class="form-control" name="title">
</div>

<div class="form-group">

  <label for="users">Users</label>

  <?php if(isset($error)){
    echo $error;
  } ?>

  <select name="post_user" id="users">
    
 
    <?php 
      echo "<option value='{$post_user}'>{$post_user}</option>";
         $users_query= "SELECT * FROM users";

         $select_users = $bdd->prepare($users_query);
         $select_users->execute();

         while($row = $select_users->fetch(PDO::FETCH_ASSOC)){
             
          $user_id = $row['user_id'];
          $post_user = $row['username'];
          
          echo "<option value='{$post_user}'>{$post_user}</option>";
         
        }
     
    ?>
  
  
  </select>
</div>



<div class="form-group">
  <label for="post_category">Post Category</label>

  <?php if(isset($error)){
    echo $error;
  } ?>

  <select name="post_category" id="post_category">
    
    <?php 
         $query= "SELECT * FROM categories";

         $select_categories = $bdd->prepare($query);
         $select_categories->execute();

         while($row = $select_categories->fetch(PDO::FETCH_ASSOC)){
             
          $cat_id = $row['cat_id'];
          $cat_title = $row['cat_title'];

          if($cat_id === $post_category_id){
           
            echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
          }else{
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
          }
         
        }
    
    ?>
  
  
  </select>
</div>

<!-- <div class="form-group">
  <label for="author">Post Author</label>
  <input value="<?php // echo $post_user ?>" type="text" class="form-control" name="author">
</div> -->

<div class="form-group">
  <select name="post_status" id="">
          <option value="<?php $post_status ?>"><?php echo $post_status; ?></option>
          <?php
          if($post_status === 'published'){

            echo "<option value='draft'>Draft</option>";

          }else{
            echo "<option value='published'>Publish</option>";

          }
          ?>
  </select>
</div>

<div class="form-group">
  <label for="post_image">Post Image</label>
  <input type="file" class="form-control" name="image">
  <img width="200" src="../images/<?php echo $post_image?>" alt="">
</div>

<div class="form-group">
  <label for="post_tags">Posts Tags</label>
  <input value="<?php echo $post_tag ?>" type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
  <label for="post_content">Posts Content</label>
  <textarea class="form-control" name="post_content" cols="30" rows="10"><?php echo $post_content ?></textarea>
</div>


<button type="submit" class="btn btn-primary" name="update_post" value="Update Post">Submit</button>
</form>