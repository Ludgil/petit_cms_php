<form action="" method="post">
        <div class="form-group">
            <label for="cat-title">Edit Category</label>

            <?php

            if(isset($_GET['edit'])){
                $cat_id = $_GET['edit'];

                $query_category_update = "SELECT * FROM categories WHERE cat_id = $cat_id";
                $select_categories_update = $bdd->prepare($query_category_update);
                $select_categories_update->execute();
                while($row = $select_categories_update->fetch(PDO::FETCH_ASSOC)){
                    
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
            }
            
            
            ?>

            <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control" type="text" name="cat_title">
        <?php }?>

        <?php  

            if(isset($_POST["update_category"])){
            $update_cat_title = $_POST['cat_title'];
            $update_cat_query = "UPDATE categories SET cat_title = '{$update_cat_title}' WHERE cat_id = '{$cat_id}'";
            $for_cat_update = $bdd->prepare($update_cat_query);
            $for_cat_update->execute();

            }
        
        
        ?>
                
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">      
        </div>
    </form>