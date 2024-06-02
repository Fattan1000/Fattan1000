
<?php


include("../util/connection.php");


  
if (isset($_POST['submit'])) {
    $titre = mysqli_real_escape_string($conn, $_POST['titre']);
    $jour = $_POST['jour']; 
    $duree = $_POST['duree']; 
    $temps = $_POST['start']; 
    $tempsf = $_POST['end']; 
    $doc = $_POST['doc']; 
    mysqli_query($conn,"INSERT INTO creneau (titre, jour, heure_debut,heure_fin, medecin_id) VALUES ('$titre','$jour', '$temps','$tempsf','$doc');");
   
    
    }else {
        echo "Formulaire non soumis correctement.";
    }
   header("Location: agenda.php?action=creneau-added&temps=" . urlencode($temps) . "&jour=" . urlencode($jour));
    
    ?>
    
    
   

</body>
</html>