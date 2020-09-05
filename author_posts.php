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
                if(isset($_GET['p_id'])){
                    $the_post_id = $_GET['p_id'];
                    $the_post_author = $_GET['author'];
                }      
                $posts_query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}'"; 
                $select_all_post = $bdd->prepare($posts_query);
                $select_all_post->execute();

                while($row = $select_all_post->fetch(PDO::FETCH_ASSOC)){

                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    
                ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $the_post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                   All posts by <?php echo $post_author ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>              
               <?php }?>  
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sideBar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
      <?php include "includes/footer.php" ?>
