<?php 
include("util/connection.php"); 
include("util/navbar.php");
$creneau_id = isset($_GET['creneau_id']) ? $_GET['creneau_id'] : 'inconnu';
$motif = isset($_GET['motif']) ? $_GET['motif'] : 'inconnu';
if(isset($_SESSION['patient_data'])) {
    $patient_id = $_GET['patient_id']; 
} else {
    echo "pas id user";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Rendez-Vous</title>
    <style>
   body {
      background-color: #E3FEF7;
      }
    .rendezvous-info {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 550px;
        padding: 20px;
        text-align: center;
        margin-top:170px;
        margin-left:459px;
    }
    .doctor-image{
            height:70px;
            width: 70px;
            border-radius:450px;
            margin-top:-50px;
            margin-left:100px;
        }   
        

    .continuer {
        background-color: #083344;
        margin-top:25px;
        color: white;
        height: 40px;
        width: 100px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .continuer:hover {
        background-color: #0a465a;
    }
        
    .precedent {
        background-color: #083344;
        color: white;
        height: 40px;
        width: 100px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-right:150px;
       
    }

    .precedent:hover {
        background-color: #0a465a;
    }
    
        
    </style>
</head>
<body>
   <?php
     setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR', 'fr_FR@euro', 'french');
     $date = isset($_GET['date']) ? $_GET['date'] : 'inconnue';
     $hour = isset($_GET['hour']) ? $_GET['hour'] : 'inconnue';
     $formattedDate = strftime('%A %d %B %Y', strtotime($date));
     $formattedHour = date('H:i', strtotime($hour));
    ?>
    
    <?php
    // Check if the doctor's ID is passed as a query parameter
    if(isset($_GET['id_medecin'])) {
        $doctorId = mysqli_real_escape_string($conn, $_GET['id_medecin']);
        
        // Fetch doctor's data from the database
        $query = "SELECT * FROM medecin WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $doctorId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result)) {
            ?> <div class="rendezvous-info">
            <?php
            echo "<br>";
            echo "<p>Dr. " . $row['nom'] . " " . $row['prenom'] . "</p>";
            echo "<img src='" . $row['image'] . "' alt='Doctor Image' class='doctor-image'>";
            echo " <p> ✓ " . $row['localisation'] . "</p>";
            echo "<p>  ✓  le " . $formattedDate . " à " . $formattedHour . "</p>";
            echo "<p>  ✓  comme motif de consultation : " . $motif . " </p>";
            ?>
            <form method="post">
                <input type="hidden" name="medecin_id" value="<?php echo $doctorId; ?>">
                <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
                <input type="hidden" name="creneau_id" value="<?php echo $creneau_id; ?>">
                <input type="hidden" name="date" value="<?php echo $date; ?>">
                <input type="hidden" name="hour" value="<?php echo $hour; ?>">
                <input type="hidden" name="motif" value="<?php echo $motif; ?>">
               
                <button type="submit" class="continuer" name="confirm">Confirmer</button>
            </form>
            </div>
        <?php
        } else {
            echo "<p>No doctor found.</p>";
        }
    } else {
        echo "<p>No doctor ID provided.</p>";
    }
    ?>

    <?php
    if(isset($_POST['confirm'])) {
        $medecin_id = $_POST['medecin_id'];
        $patient_id = $_POST['patient_id'];
        $creneau_id = $_POST['creneau_id'];
        $date = isset($_POST['date']) ? $_POST['date'] : 'inconnue';
        $hour = isset($_POST['hour']) ? $_POST['hour'] : 'inconnue';
        $motif = isset($_POST['motif']) ? $_POST['motif'] : 'inconnu';

        // Insertion des données dans la base de données
        $query = "INSERT INTO rendez_vouz (medecin_id, patient_id, creneau_id, date_rdv, heure_debut_rdv, description, status) VALUES (?, ?, ?, ?, ?, ?, 'en attente')";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiisss', $medecin_id, $patient_id, $creneau_id, $date, $hour, $motif);
        mysqli_stmt_execute($stmt);

        // Redirection vers home.php
        header("Location: home.php");
        exit();
    }
    ?>
  
</body>
</html>
