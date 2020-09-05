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
                <?php 

                if(isset($_GET['category'])){
                    $post_category_id = $_GET['category'];
                    // si on est log en admin on affiche tout les posts de la catégorie
                    // sinon on affiche que les posts publié 
                    if(is_admin()){
                        $posts_query = "SELECT * FROM posts WHERE post_category_id = '$post_category_id'"; 
                    }else{
                        $posts_query = "SELECT * FROM posts WHERE post_category_id = '$post_category_id' AND post_status = 'published'";
                    }
                    $select_all_post = $bdd->prepare($posts_query);
                    $select_all_post->execute();
                if($select_all_post->rowCount() < 1){
                    echo "<h1 class='text-center'>No posts available</h1>";
                }else{

                while($row = $select_all_post->fetch(PDO::FETCH_ASSOC)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                ?>
                <h1 class="page-header">
                  Posts
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> 
               <?php } }
                }else{
                    header("Location:index.php");
                }?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sideBar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
      <?php include "includes/footer.php" ?>
