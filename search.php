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
                // query pour la recherche
                if(isset($_POST['submit'])){
                    $search = $_POST['search'];
                    $research_query = "SELECT * FROM posts WHERE post_tag LIKE '%$search%' ";
                    $search_query = $bdd->prepare($research_query);
                    $search_query->execute();
                    if(!$search_query){
                        die("failed");
                        echo $bdd->errorInfo();
                    }
                    // si rowCount = 0 alors afficher qu'il n'y aucun résultat
                    $count = $search_query->rowCount();
                    if($count == 0){
                        echo "<h1>NO RESULT</h1>";
                    }else{
                        while($row = $search_query->fetch(PDO::FETCH_ASSOC)){
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
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
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <?php }
                    }  
                } 
                ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sideBar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
<?php include "includes/footer.php" ?>
