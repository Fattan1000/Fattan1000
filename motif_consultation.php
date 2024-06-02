<?php 
include("util/connection.php"); 
include("util/navbar.php");
$patient_data=$_SESSION['patient_data'];
$doctorId = isset($_GET['id_medecin']) ? $_GET['id_medecin'] : 'inconnu';
$creneau_id = isset($_GET['creneau_id']) ? $_GET['creneau_id'] : 'inconnu';
if(isset($patient_data)) {
   $patient_id=$patient_data['id'];
} else {
    header("Location: login2.php");
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
    .motif_consultation {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 700px;
        height:350px;
        padding: 20px;
        text-align: center;
        margin-top:180px;
        margin-left:375px;
    }

    .motif_consultation label {
        display: block;
        margin-bottom: 10px;
        font-size: 18px;
        color: #333;
    }

    .motif {
        height:200px;
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 20px;
        border: 2px solid #083344;
        border-radius: 6px;
        font-size: 16px;
        resize: none;
    }

    .continuer {
        background-color: #083344;
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
        margin-right:250px;
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
  
    <div class="motif_consultation">
        <label for="motif">quelle est votre motif de consultation ?</label>
        <textarea class="motif" id="motif" name="motif" placeholder="Entrez le motif de consultation"></textarea>
        <button class="precedent" onclick="redirectTorendezvous()">Précédent</button>
        <button class="continuer" onclick="redirectToConfirmation()">Continuer</button>
    </div>
  
     <script>
        function redirectTorendezvous() {
            const doctorId = '<?php echo $doctorId; ?>';
            window.location.href = `rendezvous.php?id_medecin=${doctorId}}`;
        }
        function redirectToConfirmation() {
            const motif = document.getElementById('motif').value;
            const doctorId = '<?php echo $doctorId; ?>';
            const patientId = '<?php echo $patient_id; ?>';
            const date = '<?php echo $date; ?>';
            const hour = '<?php echo $hour; ?>';
            const creneauId = '<?php echo $creneau_id; ?>';
            window.location.href = `confirmer.php?id_medecin=${doctorId}&patient_id=${patientId}&date=${date}&hour=${hour}&creneau_id=${creneauId}&motif=${encodeURIComponent(motif)}`;
        }
    </script>

</body>
</html>
