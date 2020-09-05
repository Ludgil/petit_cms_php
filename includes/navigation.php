<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <?php 
                $query = "SELECT * FROM categories";
                $select_all_category = $bdd->prepare($query);
                $select_all_category->execute();

                while($row = $select_all_category->fetch(PDO::FETCH_ASSOC)){
                    
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $login_class = '';
                    $page_name = basename($_SERVER['PHP_SELF']);
                    $registration = 'registration.php';
                    $contact = 'contact.php';
                    $login = 'login.php';
                    if(isset($_GET['category']) && $_GET['category'] == $cat_id ){
                        $category_class = 'active';
                    }else if($page_name == $registration){
                        $registration_class = 'active';
                    }else if($page_name == $contact){
                        $contact_class = 'active';
                    }else if($page_name == $login){
                        $login_class = 'active';
                    }
                    echo "<li class='$category_class'><a href='/cms/category.php?category={$cat_id}'>{$cat_title}</a></li>";
                }
                ?>
                    <li class="<?= $registration_class ?>">
                        <a href="registration.php">Registration</a>
                    </li>
                  
                    <li class="<?= $contact_class ?>">
                        <a  href="contact.php">Contact</a>
                    </li>

                <?php
                if(isset($_SESSION['user_role'])){
                    if(isset($_GET['p_id'])){
                        $the_post_id = $_GET['p_id'];
                         echo "<li>";
                         echo "<a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a>";
                         echo "</li>";
                    }
                }
                ?>
               <?php if(isLoggedIn()): ?>
                    <li>
                        <a href="/cms/admin">Admin</a>
                    </li> 
               <?php else: ?>
                    <li class="<?= $login_class ?>">
                        <a href="login.php">Login</a>
                    </li>
               <?php endif; ?>  
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
