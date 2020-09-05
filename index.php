<?php 
include "includes/db.php";
include "includes/header.php";
include "admin/functions.php";
?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php // pagination ?>
                <?php
                // variable qui gére le nombre d'élément afficher par page
                $per_page = 5;
                // on vérifie qu'il existe un numéro de page 
                // sinon on lui assigne une variable vide
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page ='';
                }
                // si la page est vide ou est égale a la premiere page 
                // lui assigner 0
                if($page == '' || $page == 1){
                    $page_1 = 0;
                }else{
                    // sinon faire un calcul pour la pagination
                    $page_1 = ($page * $per_page) - $per_page;
                }
                
                $query_post_count = "SELECT * FROM posts WHERE post_status = 'published'";
                $get_post_count = $bdd->prepare($query_post_count);
                $get_post_count->execute();
                $count_post = $get_post_count->rowCount();
                // vérifie si il y a des posts a afficher
                // sinon affiche qu'il n'y en a aucun
                if($count_post < 1 ){
                    echo '<h1 class="text-center">No posts available</h1>';
                }else{
                // count_post pour le nombres de pages
                $count_post = ceil($count_post / $per_page);
                $posts_query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, $per_page "; 
                $select_all_post = $bdd->prepare($posts_query);
                $select_all_post->execute();
                while($row = $select_all_post->fetch(PDO::FETCH_ASSOC)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_status = $row['post_status'];
                    $post_content = substr($row['post_content'], 0, 100);
                ?>
                <h1 class="page-header">Page Heading<small>Secondary Text</small></h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <a href='<?php echo $post_id ?>'>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
               <?php }
                }
               ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sideBar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
        <ul class="pager">
        <?php
            // boucle pour créer les boutons de la pagination en fonction du nombres de pages calculé plus haut
            for($i = 1; $i <= $count_post ;$i++){
                if($i == $page){
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                }else{
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
            }
        ?>
        </ul>
        <!-- Footer -->
      <?php include "includes/footer.php" ?>
