<?php include "includes/admin_header.php"; ?>
<?php include "functions.php"; ?>

<?php 

if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  $query = "SELECT * FROM users WHERE username = '{$username}' ";

  $select_user_profile_query = $bdd->prepare($query);
  $select_user_profile_query->execute();

  while($row = $select_user_profile_query->fetch(PDO::FETCH_ASSOC)){

    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
  }
}

?>

<?php

if(isset($_POST['update_profile'])){

  $user_lastname = $_POST['user_lastname'];
  $user_firstname = $_POST['user_firstname'];
  $user_email = $_POST['user_email'];
  $username = $_POST['username'];
  $user_password = $_POST['user_password'];

  $query_update_user = "UPDATE users SET ";
  $query_update_user .="user_lastname = '{$user_lastname}', ";
  $query_update_user .="user_firstname = '{$user_firstname}', ";
  $query_update_user .="user_email = '{$user_email}', ";
  $query_update_user .="username = '{$username}', ";
  $query_update_user .="user_password = '{$user_password}' ";
  $query_update_user .="WHERE username = '{$username}' ";

    if($_POST['user_role'] === 0){
      $error_role = "choose a role";
    }else{
      ConfirmQuery($query_update_user);
    }

}

?>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the admin page
                            <small>Author</small>
                        </h1>

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
  <label for="user_email">Email</label>
  <input value="<?php echo $user_email ?>" type="text" class="form-control" name="user_email">
</div>


<div class="form-group">
  <label for="username">Username</label>
  <input value="<?php echo $username ?>" type="text" class="form-control" name="username">
</div>

<div class="form-group">
  <label for="user_password">Password</label>
  <input autocomplete="off" type="text" class="form-control" name="user_password">
  </div>



<button type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">Submit</button>
</form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>