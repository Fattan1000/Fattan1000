<?php
include("connection.php");
$patient_data = isset($_SESSION['patient_data']) ? $_SESSION['patient_data'] : null;
$doctorId = isset($_GET['id_medecin']) ? $_GET['id_medecin'] : null;
$patient_id = null;
if ($patient_data !== null && isset($patient_data['id'])) {
    $patient_id = $patient_data['id'];
} 


// Vérifier si un ID de médecin a été fourni
if ($doctorId !== null) {
    // Préparer la requête pour sélectionner les créneaux du médecin spécifié
    $stmt = $conn->prepare("SELECT * FROM creneau WHERE medecin_id = ?");
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier s'il y a des erreurs dans la requête SQL
    if (!$result) {
        die("Erreur dans la requête SQL : " . $stmt->error);
    }

    // Créer un tableau pour stocker les créneaux récupérés
    $doctorSlots = [];
    while ($row = $result->fetch_assoc()) {
        // Regrouper les créneaux par jour et stocker l'ID du créneau
        $doctorSlots[$row['jour']][] = [
            'id' => $row['id'],
            'heure_debut' => $row['heure_debut']
        ];
    }

    $stmt->close();
}

// Récupérer les créneaux réservés
$reservedSlots = [];
$stmt = $conn->prepare("SELECT creneau_id, date_rdv FROM rendez_vouz");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $reservedSlots[$row['date_rdv']][] = $row['creneau_id'];
}
$stmt->close();

// Essayez différentes locales si 'fr_FR.utf8' ne fonctionne pas
$locales = ['fr_FR.utf8', 'fr_FR', 'fr_FR@euro', 'french'];
foreach ($locales as $locale) {
    if (setlocale(LC_TIME, $locale)) {
        break;
    }
}

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$base_time = strtotime("+$offset days");

function formatDate($time) {
    return strftime('%A<br>%e %B', $time);  // Formate la date en français
}

function formatHour($hour) {
    return date('H:i', strtotime($hour));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calendrier des rendez-vous</title>
    <style>
         body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container, .scrollable-hours {
            display: flex;
            width: 100%;
            align-items: flex-start;
        }
        .day-column {
            flex: 1;
            text-align: center;
            border: none;  
            padding: 5px;
            box-sizing: border-box;
        }
        .hour-button {
            display: block; 
            width: 80%;
            padding: 5px;
            margin: 2px auto;
            background-color: #003C43;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .hour-button.reserved {
            background-color: grey;
            cursor: not-allowed;
        }
        .scrollable-hours {
            overflow-y: auto;
            flex-grow: 1;
            height: 240px;
        }
        .navigation a {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: white;
            color: #083344;
            border-radius: 50%;
            text-decoration: none;
            margin: 0px;
            margin-top: 5px;
        }
        .navigation a:hover {
            background-color: grey;
        }
        .calendrier {
            color: black;
            margin-top: -245px;
            margin-left: 890px;
            background-color: white;
            height: 250px;
            width: 610px;
            right: 25px;
            border-width: 1px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ajoute une ombre subtile */
            border-radius: 20px;
        }
        
    </style>
</head>
<body>
    
<div class="calendrier" id="calendrier">
    <div class="container">
        <div class="scrollable-hours">
            <div class="day-column navigation"><a href="?offset=<?php echo max($offset - 1, 0); ?>&id_medecin=<?php echo $doctorId; ?>">&lt;</a></div>
            
            <?php for ($i = 0; $i < 6; $i++): ?>
                <?php $day = strtotime("+$i days", $base_time); ?>
                <?php if ($day >= strtotime('today')): ?>
                    <div class="day-column">
                        <?php echo formatDate($day); ?>
                        <?php if(isset($doctorSlots[strtolower(strftime('%A', $day))])): ?>
                            <?php foreach ($doctorSlots[strtolower(strftime('%A', $day))] as $slot): ?>
    <?php
        $date = date('Y-m-d', $day);
        $isReserved = isset($reservedSlots[$date]) && in_array($slot['id'], $reservedSlots[$date]);
    ?>
    <a href="motif_consultation.php?date=<?php echo urlencode($date); ?>&hour=<?php echo urlencode($slot['heure_debut']); ?>&creneau_id=<?php echo $slot['id']; ?>&id_medecin=<?php echo $doctorId; ?>" style="text-decoration: none;">
        <button class="hour-button <?php echo $isReserved ? 'reserved' : ''; ?>" data-date="<?php echo $date; ?>" data-creneau-id="<?php echo $slot['id']; ?>" <?php echo $isReserved ? 'disabled' : ''; ?>><?php echo formatHour($slot['heure_debut']); ?></button>
    </a>
<?php endforeach; ?>
                        <?php else: ?>
                            <p>-</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
             
            <div class="day-column navigation"><a href="?offset=<?php echo $offset + 1; ?>&id_medecin=<?php echo $doctorId; ?>">&gt;</a></div> 
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const doctorId = "<?php echo $doctorId; ?>";
    const offset = "<?php echo $offset; ?>";

    function fetchReservedSlots() {
        fetch('fetch_reserved_slots.php')
            .then(response => response.json())
            .then(data => {
                updateCalendar(data);
            });
    }

    function updateCalendar(reservedSlots) {
        document.querySelectorAll('.hour-button').forEach(button => {
            const date = button.getAttribute('data-date');
            const creneauId = button.getAttribute('data-creneau-id');
            if (reservedSlots[date] && reservedSlots[date].includes(parseInt(creneauId))) {
                button.classList.add('reserved');
                button.disabled = true;
            } else {
                button.classList.remove('reserved');
                button.disabled = false;
            }
        });
    }

    // Fetch reserved slots every 5 seconds
    setInterval(fetchReservedSlots, 5000);
    fetchReservedSlots();
});
</script>


</body>
</html>