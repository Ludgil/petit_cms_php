<div class="col-md-4">

<!-- <?php

if(ifItIsMethod('post')){
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            login_user($_POST['username'], $_POST['password']);
        }else{
            redirect('index.php');
        }
    }
}
?> -->
     <!-- Blog Search Well -->
     <div class="well">
            <h4>Blog Search</h4>
            <form action="search.php" method="post">
                <div class="input-group">
                    <input name="search" type="text" class="form-control">
                    <span class="input-group-btn">
                        <button name="submit" class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                    </button>
                    </span>
                </div>
            </form>
            <!-- /.input-group -->
        </div>

        <!--Login -->
        <div class="well">

        <?php if(isset($_SESSION['user_role'])): ?>
            <h4>Logged in as <?= $_SESSION['username'] ?></h4>
            <a href="/cms/includes/logout.php" class="btn btn-primary">Log Out</a>
        <?php else: ?>
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
                <div class="form-group">
                <?php // uniqid qui servira de token pour la récup de mdp ?>
                <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password ?</a>
                </div>
            </form>
        <?php endif; ?>
           
            <!-- /.input-group -->
        </div>
                <!-- Blog Categories Well -->
                <div class="well">
                    <?php 
                        $query_category = "SELECT * FROM categories";
                        $select_categories_sidebar = $bdd->prepare($query_category);
                        $select_categories_sidebar->execute();
                    ?>
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                            <?php
                                while($row = $select_categories_sidebar->fetch(PDO::FETCH_ASSOC)){
                                $cat_title = $row['cat_title'];
                                $cat_id = $row['cat_id'];
                                echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                            }
                            ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- Side Widget Well -->
                <?php include "widget.php" ?>
            </div>