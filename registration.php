<?php 
    include "includes/db.php"; 
    include "includes/header.php";
    include "admin/functions.php";
?>
<?php 

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // création d'un tableau pouvant contenir les erreurs
    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];

    // vérification des inputs
    if(strlen($username) < 4){
        $error['username'] = 'Username needs to be longer';
    }
    if($username == ''){
      $error['username'] = 'Username cannot be empty';
    }
    if(username_exist($username)){
        $error['username'] = 'Username already exist';
    }
    if($email == ''){
        $error['email'] = 'Email cannot be empty';
    }
    if(email_exist($email)){
        $error['email'] = 'email already exist, <a href="index.php">Please login</a>';
    }
    if($password == ''){
        $error['password'] = 'Password cannot be empty';
    }

    // si le tableau d'erreur est vide alors on unset la variable 
    foreach($error as $key => $value){
        if(empty($value)){
            unset($error['key']);
        }
    } // foreach
    // si il n'y aucune erreur dans le tableau alors on crée le compte et on log le compte
    if(!array_filter($error)){
        register_user($username, $email, $password);
        login_user($username, $password);
    }
}
?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    <!-- Page Content -->
    <div class="container">
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                            <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($username) ? $username : '' ?>" placeholder="Enter Desired Username">
                                    <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($email) ? $email : '' ?>" placeholder="somebody@example.com">
                                    <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                </div>
                                <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <hr>
<?php include "includes/footer.php";?>
