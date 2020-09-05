<?php 
ob_start();


    $localhost= 'localhost';
    $user = 'root';
    $pass ='';
    $db = 'cms';


    // On se connecte à MySQL
    $bdd = new PDO("mysql:host=".$localhost.";dbname=".$db,$user,$pass);
   