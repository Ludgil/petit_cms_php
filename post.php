<?php 
include "includes/db.php";
include "includes/header.php";
include "admin/functions.php";
?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
<?php
    // update table posts et update table likes si le post est like
    if(isset($_POST['liked'])){
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $like = $_POST['liked'];
       
        $updatePostQuery = "UPDATE posts SET likes = $like+1 WHERE post_id = '$post_id'";
        $updatePost = $bdd->prepare($updatePostQuery);
        $updatePost->execute();
        $insertLikeQuery = "INSERT INTO likes (user_id, post_id) VALUES('$user_id', '$post_id')";
        $insertLike = $bdd->prepare($insertLikeQuery);
        $insertLike->execute();
    }
// update table posts et delete dans la table likes si le post est dislike
    if(isset($_POST['unliked'])){
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $like = $_POST['unliked'];
       
        $updatePostQuery = "UPDATE posts SET likes = $like-1 WHERE post_id = '$post_id'";
        $updatePost = $bdd->prepare($updatePostQuery);
        $updatePost->execute();
        $insertLikeQuery = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
        $insertLike = $bdd->prepare($insertLikeQuery);
        $insertLike->execute();
    }

?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 
                if(isset($_GET['p_id'])){
                    $the_post_id = $_GET['p_id'];
                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$the_post_id}'";
                    $update_view = $bdd->prepare($view_query);
                    $update_view->execute();
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ){
                        $posts_query = "SELECT * FROM posts WHERE post_id = $the_post_id"; 

                    }else{
                        $posts_query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published"; 
                    }

                    $select_all_post = $bdd->prepare($posts_query);
                    $select_all_post->execute();

                    if($select_all_post->rowCount() < 1 ){
                        echo '<h1 class="text-center">No posts available</h1>';
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
                            <a href="post.php?p_id=<?php echo $the_post_id ?>"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                            <hr>
                        <?php // si on est log on peut like ?>
                        <?php if(isLoggedIn()): ?>
                        <div class="row">
                            <p><a class="<?php echo userLikedPost($the_post_id) ? 'unlike' : 'like' ?>" href=""><span class="glyphicon glyphicon-thumbs-<?php echo userLikedPost($the_post_id) ? 'down' : 'up' ?>"></span><?php echo userLikedPost($the_post_id) ? 'Unlike' : 'Like' ?></a></p>
                        </div>
                        <?php else: ?>
                            <div class="row">
                                <p>You need to log in for like the post <a href="login.php">Log In</a></p>
                            </div>

                        <?php endif; ?>
                        <div class="row">
                            <p>Like : <?= getPostLikes($the_post_id) ?></p>
                        </div>
                    <?php }  ?>
                    <?php
                    if(isset($_POST["create_comment"])){
                        $the_post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                            $query = "INSERT INTO comments (comment_post_id, comment_author, 
                            comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES ($the_post_id , '{$comment_author}', 
                            '{$comment_email}', '{$comment_content}', 'unapproved', now() )";
                            $create_comment_query = $bdd->prepare($query);
                            $create_comment_query->execute();
                        }else{
                            echo "<script>alert('Fileds cannot be empty')</script>";
                        }
                    }
               ?>
                  <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <label for="Author">Author</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <label for="email">Email</label>
                        <div class="form-group">
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <label for="comment">Your Commment</label>
                        <div class="form-group">
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>
                <!-- Posted Comments -->
                    <?php
                    $query_show_comment = "SELECT * FROM comments WHERE comment_post_id = $the_post_id "; 
                    $query_show_comment .= "AND comment_status = 'Approved' ";
                    $query_show_comment .= "ORDER BY comment_id DESC";
                    $show_comments = $bdd->prepare($query_show_comment);
                    $show_comments->execute();

                    while($row = $show_comments->fetch(PDO::FETCH_ASSOC)){
                        $comment_author = $row['comment_author'];
                        $comment_email = $row['comment_email'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];
                    ?>
                        <div class='media'>
                            <a class='pull-left' href='#'>
                                <img class='media-object' src='http://placehold.it/64x64' alt=''>
                            </a>
                            <div class='media-body'>
                                <h4 class='media-heading'><?php echo $comment_author ?>
                                <small><?php echo $comment_date ?></small>
                                </h4>
                                <?php echo $comment_content ?>
                            </div>
                        </div>
                      <?php }}  }else {
                   header("Location: index.php");
               }?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sideBar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
      <?php include "includes/footer.php" ?>
      <script>
        $(document).ready(function(){   
            let post_id = <?php echo $the_post_id ?>;
            let user_id = <?php echo loggedInUserId() ?>;
            let count_likes = <?php echo getPostLikes($the_post_id)  ?>;
            
            // envoi en post si le post a été like
            $('.like').on('click', function(){
                $.ajax({
                    url: "/cms/post.php?p_id"+post_id,
                    type: 'post',
                    data: {
                        'liked' : count_likes,
                        'post_id' : post_id,
                        'user_id' : user_id
                    }
                })
            });
            // envoi en post si le post a été dislike
            $('.unlike').on('click', function(){
                $.ajax({
                    url: "/cms/post.php?p_id="+post_id,
                    type: 'post',
                    data: {
                        'unliked' : count_likes,
                        'post_id' : post_id,
                        'user_id' : user_id
                    }
                })
            });
        });   
      </script>
