
<?php 
include("util/connection.php"); 
include("util/navbar.php");
$creneau_id = isset($_GET['creneau_id']) ? $_GET['creneau_id'] : 'inconnu';
$doctorId = isset($_GET['id_medecin']) ? $_GET['id_medecin'] : 'inconnu';
$patient_data=$_SESSION['patient_data'];
if(isset($patient_data)) {
   $patient_id=$patient_data['id'];
}
    $motif = isset($_GET['motif']) ? $_GET['motif'] : 'inconnu';
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
    .confirmation {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 550px;
        padding: 20px;
        text-align: center;
        margin-top:200px;
        margin-left:459px;
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
        margin-right: 10px;
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
    <div class="confirmation">
       
        <h2>confirmez l'heure du rendz-vous:</h2>
        <p> ✓ Vous avez sélectionné le <?php echo $formattedDate; ?> à <?php echo $formattedHour; ?>.</p>
        <p> ✓ comme motif de consultation :  <?php echo $motif; ?> </p><br>
        <button class="precedent" onclick="window.location.href = 'motif_consultation.php?id_medecin=<?php echo $doctorId; ?>&patient_id=<?php echo $patient_id; ?>&date=<?php echo $date; ?>&hour=<?php echo $hour; ?>&creneau_id=<?php echo $creneau_id; ?>&motif=<?php echo $motif; ?>';">precedent</button>
        <button class="continuer" onclick="window.location.href = 'verification.php?id_medecin=<?php echo $doctorId; ?>&patient_id=<?php echo $patient_id; ?>&date=<?php echo $date; ?>&hour=<?php echo $hour; ?>&creneau_id=<?php echo $creneau_id; ?>&motif=<?php echo $motif; ?>';">continuer</button>
    </div>
  
</body>
</html> 