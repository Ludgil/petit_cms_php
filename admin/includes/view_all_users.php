<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Change to admin</th>
                                    <th>Change to subscriber</th>
                                    <th>Delete</th>
                                    <th>Edit</th>

                                    <!-- <th>Date</th> -->
                                </tr>
                            </thead>
                            <tbody>


                            <?php 
                                  
                                $query_users_admin = "SELECT * FROM users";
                                $select_users_admin = $bdd->prepare($query_users_admin);
                                $select_users_admin->execute();
                                while($row = $select_users_admin->fetch(PDO::FETCH_ASSOC)){
        
                                    $user_id = $row['user_id'];
                                    $username = $row['username'];
                                    $password = $row['user_password'];
                                    $firstname = $row['user_firstname'];
                                    $lastname = $row['user_lastname'];
                                    $user_email = $row['user_email'];
                                    $user_image = $row['user_image'];

                                    $user_role = $row['user_role'];

                                    


                                    echo "<tr>";

                                        echo "<td>$user_id</td>";
                                        echo "<td>$username</td>";
                                        echo "<td>$firstname</td>";
                                        echo "<td>$lastname</td>";
                                    
                                        echo "<td>$user_email</td>";
                                        echo "<td>$user_role</td>";
                                        echo "<td><a href='users.php?change_to_admin={$user_id}'>Change to admin</a></td>";
                                        echo "<td><a href='users.php?change_to_sub={$user_id}'>Change to subscriber</a></td>";
                                        echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                                        echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";

                                    echo "</tr>";
                                }                         
                                
                            ?>
                                
                            </tbody>
                        </table>

                        <?php 

                        if(isset($_GET['change_to_admin'])){

                            $the_user_id = $_GET['change_to_admin'];

                            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";
                            ConfirmQuery($query);
                            header("Location: users.php");
                                
                            }


                        if(isset($_GET['change_to_sub'])){

                            $the_user_id = $_GET['change_to_sub'];

                            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id";
                            ConfirmQuery($query);
                            header("Location: users.php");
                                
                            }

                        if(isset($_GET['delete'])){

                        if(isset($_SESSION['user_role'])){
                            if($_SESSION['user_role'] == 'admin'){
                                $the_user_id = $_GET['delete'];
        
                                $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
                                ConfirmQuery($query);
                                header("Location: users.php");
                            }

                        }

                            
                        }

                        ?>

