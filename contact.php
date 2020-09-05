<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>
<?php 
$message = "";
if(isset($_POST['submit'])){
    $to = "insert mail";
    $from = $_POST['email'];
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    if(!empty($from) && !empty($subject) && !empty($body) ){
        if(mail()){
            $message = "Your Message has been submitted";
        }else{
            $message = "";
        }
    }else{
        $message = "Fields cannot be empty";
    }
}
?>
    <!-- Navigation -->   
    <?php  include "includes/navigation.php"; ?>
    <!-- Page Content -->
    <div class="container"> 
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                    <h1>Contact</h1>
                        <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                            <h6 class="text-center"><?= $message ?></h6>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="Subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Your Subject">
                            </div>
                            <div class="form-group">
                                <label for="message" class="sr-only">Message</label>
                                <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>
<?php include "includes/footer.php";?>
