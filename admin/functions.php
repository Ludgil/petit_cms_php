<?php


function ConfirmQuery($query){
    global $bdd;
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $connection = $bdd->prepare($query);
        $connection ->execute();
    }
    catch (PDOException $e) {
        //error
        $return = "Your fail message: " . $e->getMessage();
        echo $return;
    }
}

function insert_categories(){
    global $bdd;
    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)){
            echo "this fiels should not be empty";
        }else{
            $query = "INSERT INTO categories(cat_title) ";
            $query .="VALUE('{$cat_title}')";
            $create_category_query = $bdd->prepare($query);
            $create_category_query->execute();
            if(!$create_category_query){
                die("failed");
                echo $bdd->errorInfo();
            }
        }
    }
}

function findAllCategories(){
    global $bdd;
    $query_category_admin = "SELECT * FROM categories";
    $select_categories_admin = $bdd->prepare($query_category_admin);
    $select_categories_admin->execute();
    while($row = $select_categories_admin->fetch(PDO::FETCH_ASSOC)){
  
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo  "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories(){
    global $bdd;
    if(isset($_GET["delete"])){
        $delete_cat_id = $_GET['delete'];
        $delete_cat_query = "DELETE FROM categories WHERE cat_id = '{$delete_cat_id}'";
        $for_car_delete = $bdd->prepare($delete_cat_query);
        $for_car_delete->execute();
        header("Location: categories.php");
    }
}

function onlineUsers(){
    if(isset($_GET['onlineusers'])){
        global $bdd;
        if(!$bdd){
            session_start();
            include("../includes/db.php");
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $query_session = $bdd->prepare($query);
            $query_session->execute();
            $count_session = $query_session->rowCount();
            if($count_session == NULL){  
                $query_insert_session = "INSERT INTO users_online (session, time) VALUES ('$session', '$time')";
                $insert_session = $bdd->prepare($query_insert_session);
                $insert_session->execute();
            }else{   
                $query_update_session = "UPDATE users_online SET time = '$time' WHERE session = '$session'";
                $update_session = $bdd->prepare($query_update_session);
                $update_session->execute();
            }
            $users_online_query = "SELECT * FROM users_online WHERE time > '$time_out'";
            $get_users_online = $bdd->prepare($users_online_query);
            $get_users_online->execute();
            $count_users = $get_users_online->rowCount();
            echo $count_users;
        }
    }
}

onlineUsers();

function recordCount($table){
    global $bdd;
    $query = "SELECT * FROM $table";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;
}

function checkStatus($table, $column, $status){
    global $bdd;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $select_all = $bdd->prepare($query);
    $select_all->execute();
    $result = $select_all->rowCount();
    return $result;
}

function checkUserRole($table, $column, $role){
    global $bdd;
    $query = "SELECT * FROM $table WHERE $column = '$role'";
    $select_all = $bdd->prepare($query);
    $select_all->execute();
    $result = $select_all->rowCount();
    return $result;
}


function is_admin(){
    global $bdd;
    if(isLoggedIn()){
        $query = "SELECT user_role FROM users WHERE user_id = '".$_SESSION['user_id']."'";
        $select_username = $bdd->prepare($query);
        $select_username->execute();
        $row = $select_username->fetch();
        if($row['user_role'] == 'admin'){
            return true;
        }else{
            return false;
        }
    }
    return false;
}

function username_exist($username){
    global $bdd;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $select_username = $bdd->prepare($query);
    $select_username->execute();
    if($select_username->rowCount() > 0){
        return true;
    }else{
        return false;
    }
}

function email_exist($email){
    global $bdd;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $select_email = $bdd->prepare($query);
    $select_email->execute();
    if($select_email->rowCount() > 0){
        return true;
    }else{
        return false;
    }
}

function redirect($location){
    header('Location:'.$location);
    exit;
}

function ifItIsMethod($method = null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }

}

function register_user($username, $email, $password){
    global $bdd;
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES (:username, :user_email, :user_password, :user_role)";
    $insertRegister = $bdd->prepare($query);
    if(!$insertRegister){
        die("Query Failed ".$bdd->errorInfo());
    }else{
        $insertRegister->execute([
            ':username' => $username,
            ':user_email' => $email,
            ':user_password' => $password,
            ':user_role' => 'subscriber'
        ]);
    }
}
     

function login_user($username, $password){
   
    global $bdd;

    $username = trim($username);
    $password = trim($password);
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = $bdd->prepare($query);
    $select_user_query->execute();
 
    while($row = $select_user_query->fetch(PDO::FETCH_ASSOC)){
 
         $db_id = $row['user_id'];
         $db_user_password = $row['user_password'];
         $db_username = $row['username'];
         $db_user_firstname = $row['user_firstname'];
         $db_user_lastname = $row['user_lastname'];
         $db_user_role = $row['user_role'];
         if(password_verify($password, $db_user_password)){
            $_SESSION['user_id'] = $db_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
         
         
            redirect('/cms/admin');
      
         }else{
            return false;
         }
    }
 
  return true;
}


function loggedInUserId(){
    global $bdd;
    if(isLoggedIn()){
        $query = "SELECT * FROM users WHERE username ='".$_SESSION['username']."'";
        $result = $bdd->prepare($query);
        $result->execute();
        $user_id = $result->fetch();
        return $user_id['user_id'];
    }
    return false;
}

function userLikedPost($post_id = ''){
    global $bdd;
    $query = "SELECT * FROM likes WHERE user_id ='".loggedInUserId()."' AND post_id = '$post_id'";
    $result = $bdd->prepare($query);
    $result->execute();
    $result->fetch();

    if($result->rowCount() >=1){
        return true;
    }else{
        return false;
    }
   
}

function getPostLikes($post_id){
    global $bdd;
    
    $query = "SELECT * FROM likes WHERE post_id = $post_id";
    $result = $bdd->prepare($query);
    $result->execute();
    $result->fetch();

    return $result->rowCount();
}

function get_username(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null ;
}


function get_all_user_post(){

    global $bdd;

    $query = "SELECT * FROM posts WHERE user_id ='".loggedInUserId()."'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}


function get_all_post_user_comments(){

    global $bdd;

    $query = "SELECT * FROM posts INNER JOIN comments ON 
    posts.post_id = comments.comment_post_id WHERE posts.user_id ='".loggedInUserId()."'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}

function get_all_post_user_unapproved_comments(){

    global $bdd;

    $query = "SELECT * FROM posts INNER JOIN comments ON 
    posts.post_id = comments.comment_post_id WHERE posts.user_id ='".loggedInUserId()."' AND comments.comment_status = 'unapproved'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}
function get_all_post_user_approved_comments(){

    global $bdd;

    $query = "SELECT * FROM posts INNER JOIN comments ON 
    posts.post_id = comments.comment_post_id WHERE posts.user_id ='".loggedInUserId()."' AND comments.comment_status = 'approved'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}

function get_all_user_categories(){

    global $bdd;

    $query = "SELECT * FROM categories WHERE user_id ='".loggedInUserId()."'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}

function get_all_user_published_post(){

    global $bdd;

    $query = "SELECT * FROM posts WHERE user_id ='".loggedInUserId()."' AND post_status = 'published'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}

function get_all_user_draft_post(){

    global $bdd;

    $query = "SELECT * FROM posts WHERE user_id ='".loggedInUserId()."' AND post_status = 'draft'";
    $select_all_post = $bdd->prepare($query);
    $select_all_post->execute();
    $result = $select_all_post->rowCount();
    return $result;

}