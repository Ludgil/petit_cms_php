<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>
<?php

// si il n'y a pas de mail ni de token, on redirige vers l'index
if(!isset($_GET['email']) && !isset($_GET['token'])){
    redirect('index');
}

// si on trouve les info de l'user avec le token pour le "forgot password"
// on récup les info de l'user 
if($stmt = $bdd->prepare("SELECT username, user_email, token FROM users WHERE token='$_GET[token]'")){
    $stmt->execute();
    $row = $stmt->fetch();
    $username = $row['username'];
    $email = $row['user_email'];
    $token = $row['token'];

    if(isset($_POST['password']) && isset($_POST['confirmPassword'])){

        // on vérifie que les mots de passe sont les mêmes
        if($_POST['password'] === $_POST['confirmPassword']){


            $password = $_POST['password'];
            // on hash le nouveau password 
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
            // et on update la bdd
            if($stmt = $bdd->prepare("UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email = '$_GET[email]'")){
                $stmt->execute();
                // si le mdp à bien été modifié alors on redirige vers la page de login
                if($stmt->rowCount() >= 1){
                  redirect('/cms/login.php');
                }
            }
        }
    }
}
?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<hr>
<?php include "includes/footer.php";?>
</div> <!-- /.container -->



