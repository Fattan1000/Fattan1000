<?php

   
    if($_GET){
        //import database
        include("../util/connection.php");
        $id=$_GET["id"];
        $result001= mysqli_query($conn,"select email from medecin where id=$id;");
        $email=($result001->fetch_assoc())["email"];
       
        mysqli_query($conn,"delete from medecin where email='$email';");
        echo"<script>alert('votre compte a été supprimer')</script>";
       include("../util/logout.php");
       
    }
    
    

?>