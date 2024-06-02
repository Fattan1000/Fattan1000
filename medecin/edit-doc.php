
    <?php
    
    

    //import database
    include("../util/connection.php");



    if (isset($_POST['submit'])){
        //print_r($_POST);
        
        $nom=$_POST['nom'];
        $oldemail=$_POST['oldemail'];
        $prenom=$_POST['prenom'];
        $specialite2=$_POST['specialite'];
        $specialite = mysqli_real_escape_string($conn, $specialite2);
        $email=$_POST['email'];
        $ville=$_POST['ville'];
        $description2=$_POST['desc'];
        $description_safe = mysqli_real_escape_string($conn, $description2);
        $tarif=$_POST['tarif'];
        $expdip1=$_POST['expdip'];
        $expdip = mysqli_real_escape_string($conn, $expdip1);
        $modpait=$_POST['modpai'];
        $horaire1=$_POST['horaire'];
        $horaire= mysqli_real_escape_string($conn, $horaire1);
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        $modepaiment='les mode de paiement:<br>';
        if (isset($_POST['modpai']) && is_array($_POST['modpai'])) {
            $modpait = $_POST['modpai'];
            
        foreach ($modpait as $m) {
            switch ($m) {
                case 'especes':
                 $modepaiment.=" par especes &nbsp; ";
                    break;
                case 'cheque':
                    $modepaiment.=" par cheque &nbsp; ";
                    break;
                case 'carte':
                    $modepaiment.=" par carte &nbsp; ";
                    break;
                    default:
                    $modepaiment.="indefinie <br>";
                    break;}}}
        if ($password==$cpassword){ 
            $error='3';
            $result=mysqli_query($conn,"select medecin.id from medecin where medecin.email='$email';");
            
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["id"];
            }else{
                $id2=$id;
            }
            
            
            if($id2!=$id){
                $error='1';
                
            }else{

                mysqli_query($conn,"update medecin set email='$email',nom='$nom',password='$password',prenom='$prenom',specialite='$specialite',ville='$ville',experience_diplome= '$expdip',horaires='$horaire',mode_paiement='$modepaiment',presentation='$description',tarif='$tarif' where id=$id ;");
               
                
              

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