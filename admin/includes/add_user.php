<?php

if(isset($_POST['create_user'])){

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role= $_POST['user_role'];

  
    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    
    // $post_date = date('d-m-y');

    // move_uploaded_file($post_image_temp, "../images/$post_image");
    // $querySalt = $bdd->prepare("SELECT randSalt FROM users");
    // if(!$querySalt){
    //     die("Query Failed ".$bdd->errorInfo());
    // }else{
    //     $querySalt->execute();
    // }
    // $row = $querySalt->fetch();
    // $salt = $row['randSalt'];
    // $hashed_password = crypt($user_password, $salt);

    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

  
      $create_user_query = "INSERT INTO users(user_firstname, user_lastname, 
      user_role, username, user_email, user_password) ";
      $create_user_query .="VALUE('{$user_firstname}', '{$user_lastname}',
     '{$user_role}', '{$username}', '{$user_email}', '{$hashed_password}')";

      
     
      ConfirmQuery($create_user_query);

      echo "User Created: " . " " . "<a href='users.php'>View Users</a>";

      
   

}

?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="user_firstname">FirstName</label>
    <input type="text" class="form-control" name="user_firstname">
  </div>


  <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>

  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="text" class="form-control" name="user_email">
  </div>


  <div class="form-group">
    <label for="user_role">User Role</label>
    <select name="user_role" id="user_role">
      <option value="0">Select an option</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>

  </select>
</div>


<div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username">
</div>



  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="text" class="form-control" name="user_password">
</div>


  <button type="submit" class="btn btn-primary" name="create_user" value="Add User">Submit</button>
</form>