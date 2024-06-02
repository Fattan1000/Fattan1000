<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    
</body>
</html>
<?php
include("util/connection.php");
if (isset($_POST['input']))
{
    $input=$_POST["input"];
    $specialite_select=$_POST["specialite_select"];
    $ville_select=$_POST["ville_select"];
    $query="SELECT id,nom,prenom,specialite,ville,image FROM medecin WHERE nom LIKE '{$input}%' OR prenom LIKE '{$input}%'and (specialite = '$specialite_select' OR ville ='$ville_select')";
    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0){?>
      <table class="table table-bordered table -striped mt-4">
     <?php  while($row =mysqli_fetch_assoc($result)){
       
        $nom=$row['nom'];
        $prenom=$row['prenom'];
        $specialite=$row['specialite'];
        $ville=$row['ville'];
        $image=$row['image'];
       
         // Récupération des évaluations du médecin
    $medecin_id = $row['id'];
    $evaluation_query = "SELECT AVG(note) AS moyenne FROM evaluation WHERE medecin_id = $medecin_id";
    $evaluation_result = mysqli_query($conn, $evaluation_query);
    $evaluation_row = mysqli_fetch_assoc($evaluation_result);
    $moyenne_note = $evaluation_row['moyenne'];
        ?>
        <tr>
        <div class="doctor-card">
    <img src="<?php echo $image?>"alt="Doctor Image" class="doctor-image">
    <div class="doctor-info">
        <h2 class="doctor-name"><?php echo"DR.$nom $prenom"?></h2><div class="plusreviews">
            <div class="note">
            <?php
                        // Convertir la moyenne des notes en étoiles
                        $moyenne_arrondie = round($moyenne_note);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $moyenne_arrondie) {
                                echo '<i class="star fas fa-star" style="color: gold;"></i>';
                            } else {
                                echo '<i class="star far fa-star" style="color: gold;"></i>';
                            }
                        }
                        ?>
            </div> 
    </div>
        <p class="doctor-specialty"> <?php echo $specialite?></p>
        <p class="doctor-city"><?php echo $ville?></p>
    </div>

    <a href="rendezvous.php?id_medecin=<?php echo $row['id'] ?>" class="button">RDV</a>
</div>

        </tr>



        <?php
    }?>
 
     
    </table>




<?php
}else
    echo"<h6 class='text-danger text-center mt-3'>no data found</h6>";

}

?>