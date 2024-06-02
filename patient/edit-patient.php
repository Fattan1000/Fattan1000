
<?php
    
    

    //import database
    include("../util/connection.php");



    if($_POST){
        //print_r($_POST);
        
        $nom=$_POST['nom'];
        $email=$_POST['oldemail'];
        $prenom=$_POST['prenom'];
        $tele=$_POST['telephone'];
        $sexe=$_POST['sexe'];
        $daten=$_POST['daten'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){ 
            $error='3';
            $result=mysqli_query($conn,"select patient.id from patient where patient.email='$email';");
            
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["id"];
            }else{
                $id2=$id;
            }
            
            
            if($id2!=$id){
                $error='1';
                
            }else{

                mysqli_query($conn,"update patient set email='$email',nom='$nom',password='$password',prenom='$prenom',tele='$tele',sexe='$sexe',date_naissance='$daten' where id=$id ;");
               
                
              

                echo $sql1;
                
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        $error='3';
    }
    

    header("location: parametres.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>