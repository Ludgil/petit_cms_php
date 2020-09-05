<?php 

include('delete_modal.php');

if(isset($_POST['checkBoxArray'])){


    foreach($_POST['checkBoxArray'] as $postValueId){

        $bulk_options = $_POST['bulk_options'];


        switch($bulk_options){

            case 'published':

                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}' ";
                    $update_to_publish_status = $bdd->prepare($query);
                    $update_to_publish_status->execute();
            
            break;

            
            case 'draft':

                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}' ";
                $update_to_draft_status = $bdd->prepare($query);
                $update_to_draft_status->execute();
        
            break;

            case 'delete':

                $query = "DELETE FROM posts WHERE post_id = '{$postValueId}' ";
                $update_to_delete_status = $bdd->prepare($query);
                $update_to_delete_status->execute();
        
            break;

            case 'clone':

                $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}'";
                $query_clone = $bdd->prepare($query);
                $query_clone->execute();

                while($row = $query_clone->fetch()){
            
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_title = $row['post_title'];
                    $post_content = $row['post_content'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tag'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                }
                $query = "INSERT INTO posts(post_category_id, post_title, post_author,post_user, post_date,
                post_image, post_content, post_tag, post_status) ";
                $query .="VALUE('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_user}', now(),
                '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
            
                ConfirmQuery($query);
        
            break;
            

        }



    }

}



?>




<form action="" method='post'>

<table class="table table-bordered table-hover">

    <div id="bulkOptionContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">

        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>

    </div>
                            <thead>
                                <tr>
                                    <th><input id='selectAllBoxes' type="checkbox"></th>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Number of views</th>
                                    <th>Date</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>


                            <?php 
                                  
                                $query_posts_admin = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
                                $query_posts_admin .= "posts.post_tag, posts.post_comment_count,posts.post_content , posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
                                $query_posts_admin .=  "FROM posts ";
                                $query_posts_admin .=  "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
                                $select_posts_admin = $bdd->prepare($query_posts_admin);
                                $select_posts_admin->execute();
                                while($row = $select_posts_admin->fetch(PDO::FETCH_ASSOC)){
        
                                    $post_id = $row['post_id'];
                                    $post_author = $row['post_author'];
                                    $post_user = $row['post_user'];
                                    $post_title = $row['post_title'];
                                    $post_content = $row['post_content'];
                                    $post__category_id = $row['post_category_id'];
                                    $post_status = $row['post_status'];
                                    $post_image = $row['post_image'];
                                    $post_tag = $row['post_tag'];
                                    $post_comment_count = checkStatus('comments','comment_post_id', $post_id);
                                    $post_date = $row['post_date'];
                                    $post_views_count = $row['post_views_count'];
                                    $category_id = $row['cat_id'];
                                    $category_title = $row['cat_title'];

                                    echo "<tr>";

                                    ?>

                                       <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
                                    <?php
                                        echo "<td>$post_id</td>";
                                        if(!empty($post_author)){
                                            echo "<td>$post_author</td>";
                                        }elseif(!empty($post_user)){
                                            echo "<td>$post_user</td>";
                                        }
                                        
                                        echo "<td> <a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
                                        echo "<td>$post_content</td>";
                                        echo"<td>{$category_title}</td>";
                                        echo "<td>$post_status</td>";
                                        echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                                        echo "<td>$post_tag</td>";
                                        echo "<td><a href='post_comments.php?id=$post_id'>$post_comment_count</a></td>";
                                        echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
                                        echo "<td>$post_date</td>";
                                        echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                                        ?>
                                        <form method="post">
                                            <input type='hidden' name='post_id' value="<?php echo $post_id ?>">
                                            <td><input type="submit" class="btn btn-danger" name="delete" value="Delete"></td>
                                        </form>
                                        <?php
                                        // echo "<td><a rel='{$post_id}' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                                    echo "</tr>";
                                }                         
                            ?>
                            </tbody>
                        </table>

                        </form>

                        <?php 

                        if(isset($_POST['delete'])){

                        $the_post_id = $_POST['post_id'];

                        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
                        ConfirmQuery($query);
                        header("Location: posts.php");
                        }

                        if(isset($_GET['reset'])){
                            $the_post_id = $_GET['reset'];
                            $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$the_post_id}'";
                            ConfirmQuery($query);
                            header("Location: posts.php");   
                            }
                        ?>
