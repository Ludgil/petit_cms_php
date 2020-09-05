<?php


if(isset($_GET['u_id'])){

  $the_user_id = $_GET['u_id'];


$query = "SELECT * FROM users WHERE user_id = $the_user_id";
$select_user_by_id = $bdd->prepare($query);
$select_user_by_id->execute();
while($row = $select_user_by_id->fetch(PDO::FETCH_ASSOC)){

    $user_id = $row['user_id'];
    $user_lastname = $row['user_lastname'];
    $user_firstname = $row['user_firstname'];
    $user_role = $row['user_role'];
    $user_email = $row['user_email'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    
}

if(isset($_POST['update_user'])){


  $user_lastname = $_POST['user_lastname'];
  $user_firstname = $_POST['user_firstname'];
  $user_role = $_POST['user_role'];
  $user_email = $_POST['user_email'];
  $username = $_POST['username'];
  $user_password = $_POST['user_password'];

  

    // move_uploaded_file($post_image_temp, "../images/$post_image");

    // if(empty($post_image)){

    //   $query_image = "SELECT * FROM posts WHERE post_id = {$the_post_id}";

    //   $select_image = $bdd->prepare($query_image);
    //   $select_image->execute();

    //   while($row = $select_image->fetch(PDO::FETCH_ASSOC)){
    //       $post_image = $row['post_image'];
    //   }
    // }

    // $querySalt = $bdd->prepare("SELECT randSalt FROM users");
    // if(!$querySalt){
    //     die("Query Failed ".$bdd->errorInfo());
    // }else{
    //     $querySalt->execute();
    // }
    // $row = $querySalt->fetch();
    // $salt = $row['randSalt'];
    // $hashed_password = crypt($user_password, $salt);

    if(!empty($user_password)){
      $query_password = "SELECT * FROM users WHERE user_id = '$the_user_id'";
      $get_password = $bdd->prepare($query_password);
      $get_password->execute();

      $row = $get_password->fetch();

      $db_user_password = $row['user_password'];

      if($db_user_password != $user_password){
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12)); 
      }

      $query_update_user = "UPDATE users SET ";
      $query_update_user .="user_lastname = '{$user_lastname}', ";
      $query_update_user .="user_firstname = '{$user_firstname}', ";
      $query_update_user .="user_email = '{$user_email}', ";
      $query_update_user .="user_role = '{$user_role}', ";
      $query_update_user .="username = '{$username}', ";
      $query_update_user .="user_password = '{$hashed_password}' ";
      $query_update_user .="WHERE user_id = '{$the_user_id}' ";

      if($_POST['user_role'] === 0){
        $error_role = "choose a role";
      }else{
        ConfirmQuery($query_update_user);
      }

    }

      
  }

}else{
  header("Location: index.php");
}


?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
  <label for="user_firstname">Firstname</label>
  <input value="<?php echo $user_firstname ?>" type="text" class="form-control" name="user_firstname">
</div>

<div class="form-group">
  <label for="user_lastname">Lastname</label>
  <input value="<?php echo $user_lastname ?>" type="text" class="form-control" name="user_lastname">
</div>

<div class="form-group">
    <label for="user_role">User Role</label>
    <select name="user_role" id="user_role">
      <option value="0">Select an option</option>
      <option value="admin" <?php if($user_role == "admin"){ echo "selected";}?>>Admin</option>
      <option value="subscriber" <?php if($user_role == "subscriber"){ echo "selected";}?>>Subscriber</option>
    </select>
</div>
<?php if(isset($error_role)){
  echo $error_role;
}
?>

<div class="form-group">
  <label for="user_email">Email</label>
  <input value="<?php echo $user_email ?>" type="text" class="form-control" name="user_email">
</div>


<div class="form-group">
  <label for="username">Username</label>
  <input value="<?php echo $username ?>" type="text" class="form-control" name="username">
</div>

<div class="form-group">
  <label for="user_password">Password</label>
  <input autocomplete="off" type="password" class="form-control" name="user_password">
  </div>



<button type="submit" class="btn btn-primary" name="update_user" value="Update User">Submit</button>
</form>