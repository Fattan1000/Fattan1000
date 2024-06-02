<?php
// Inclusion de la connexion à la base de données
include("../util/connection.php");
// Démarrage de la session
session_start();
// Récupération des données du médecin à partir de la session
$doctor_data = $_SESSION["medecin_data"];

$docid = $doctor_data["id"];
$docnom = $doctor_data["nom"];
$docprenom = $doctor_data["prenom"];
$docspecialite = $doctor_data["specialite"];
$docemail = $doctor_data["email"];
$image = $doctor_data["image"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c2d3a7aff6.js" crossorigin="anonymous"></script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/dashboard-medecin.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/dashboard-medecin.css">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Emploi du Temps</title>
    <style>
        /* Styles pour la popup */
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }

        /* Variables CSS */
        :root {
            --numDays: 6;
            --numHours: 17; /* De 7h à 23h, total 17 heures */
            --timeHeight: 60px;
            --calBgColor: #fff1f8;
            --eventBorderColor: #f2d3d8;
            --eventColor1: #ffd6d1;
            --eventColor2: #fafaa3;
            --eventColor3: #e2f8ff;
            --eventColor4: #d1ffe6;
        }

        /* Styles pour le calendrier */
        .calendar {
            display: grid;
            gap: 10px;
            grid-template-columns: auto 1fr;
            margin: 2rem;
        }

        .timeline {
            display: grid;
            grid-template-rows: repeat(var(--numHours), var(--timeHeight));
        }

        .days {
            display: grid;
            grid-column: 2;
            gap: 5px;
            grid-template-columns: repeat(var(--numDays), minmax(150px, 1fr));
        }

        .events {
            display: grid;
            grid-template-rows: repeat(var(--numHours), var(--timeHeight));
            border-radius: 5px;
            background: var(--eventColor3)
        }

        /* Positionnement sur la timeline */
        .start-7 { grid-row-start: 1; }
        .start-8 { grid-row-start: 2; }
        .start-9 { grid-row-start: 3; }
        .start-10 { grid-row-start: 4; }
        .start-11 { grid-row-start: 5; }
        .start-12 { grid-row-start: 6; }
        .start-13 { grid-row-start: 7; }
        .start-14 { grid-row-start: 8; }
        .start-15 { grid-row-start: 9; }
        .start-16 { grid-row-start: 10; }
        .start-17 { grid-row-start: 11; }
        .start-18 { grid-row-start: 12; }
        .start-19 { grid-row-start: 13; }
        .start-20 { grid-row-start: 14; }
        .start-21 { grid-row-start: 15; }
        .start-22 { grid-row-start: 16; }
        .start-23 { grid-row-start: 17; }

        .end-8 { grid-row-end: 2; }
        .end-9 { grid-row-end: 3; }
        .end-10 { grid-row-end: 4; }
        .end-11 { grid-row-end: 5; }
        .end-12 { grid-row-end: 6; }
        .end-13 { grid-row-end: 7; }
        .end-14 { grid-row-end: 8; }
        .end-15 { grid-row-end: 9; }
        .end-16 { grid-row-end: 10; }
        .end-17 { grid-row-end: 11; }
        .end-18 { grid-row-end: 12; }
        .end-19 { grid-row-end: 13; }
        .end-20 { grid-row-end: 14; }
        .end-21 { grid-row-end: 15; }
        .end-22 { grid-row-end: 16; }
        .end-23 { grid-row-end: 17; }
        .end-24 { grid-row-end: 18; }

        /* Styles pour les événements */
        .title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .event {
            border: 1px solid var(--eventBorderColor);
            border-radius: 5px;
            padding: 0.5rem;
            margin: 0 0.5rem;
            background: var(--eventColor2);
            word-wrap: break-word; /* S'assurer que le texte reste dans l'événement */
        }

        .space,
        .date {
            height: 60px;
            margin-bottom: 20px;
        }

        /* Styles globaux */
        body {
            font-family: system-ui, sans-serif;
        }

        .corp-fi {
            background: var(--eventColor1);
        }

        .ent-law {
            background: var(--eventColor2);
        }

        .writing {
            background: var(--eventColor3);
        }

        .securities {
            background: var(--eventColor4);
        }

        .date {
            margin-top: -10px;
            display: flex;
            gap: 1em;
        }

        .date-num {
            margin-top: 1px;
            font-size: 3rem;
            font-weight: 600;
            display: inline;
        }

        .date-day {
            margin-top: -5px;
            display: inline;
            font-size: 3rem;
            font-weight: 100;
        }

        .popup1 {
            position: fixed; /* Changement de absolute à fixed */
            z-index: 1000; /* Assurer qu'il est au-dessus des autres éléments */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: none; /* Initialement caché */
        }

        .popup1 ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .popup1 ul li {
            padding: 12px 15px;
            cursor: pointer;
        }

        .popup1 ul li:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- Menu des icônes -->
    <div class="icon-rectangle">
        <a href="../home.php" class="tooltip">
            <i class="fa-solid fa-house" style="margin-left:6px"></i>
            <span class="tooltiptext">Home</span>
        </a>
        <a href="dashboard-medecin.php" class="tooltip">
            <i class="fa-solid fa-stethoscope" style="margin-left:5px"></i>
            <span class="tooltiptext">Dashboard</span>
        </a>
        <a href="mesrdv.php" class="tooltip">
            <i class="fa-regular fa-calendar-check" style="margin-left:6px"></i>
            <span class="tooltiptext">My Appointments</span>
        </a>
        <a href="mespatient.php" class="tooltip">
            <i class="fa-solid fa-bed" style="margin-left:6px"></i>
            <span class="tooltiptext">My Patients</span>
        </a>
        <a href="agenda.php" class="tooltip">
            <i class="fa-solid fa-calendar-days" style="margin-left:6px"></i>
            <span class="tooltiptext">agenda</span>
        </a>
        <a href="parametres.php" class="tooltip">
            <i class="fa-solid fa-gear" style="margin-left:6px"></i>
            <span class="tooltiptext">Settings</span>
        </a>
    </div>

    <!-- Section fixe avec l'image de profil -->
    <div class="fixed-div" style="width:250px;,height:270px;">
        <img src="<?php echo $image ?>" id="profileimg">
        <div class="profile-info">
            <h1>Dr. <?php echo "$docnom" ?></h1>
            <p>Spécialité: <?php echo "$docspecialite" ?></p>
            <p>Email: <?php echo "$docemail" ?></p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <!-- Grille du calendrier -->
        <div class="calendar">
            <!-- Ligne des heures -->
            <div class="timeline">
                <?php
                // Affichage des heures de 7h à 23h
                for ($hour = 7; $hour <= 23; $hour++) {
                    echo '<div class="time">' . $hour . ':00</div>';
                }
                ?>
            </div>

            <!-- Jours de la semaine -->
            <div class="days">
                <?php
                // Affichage des jours de la semaine (lundi à samedi)
                $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
                foreach ($jours as $jour) {
                    echo '<div class="date"><div class="date-num">' . $jour . '</div></div>';
                }
                ?>
                <?php
                // Événements à afficher
                $events = [
                    ["day" => "Lundi", "start" => 9, "end" => 12, "title" => "Consultation générale"],
                    ["day" => "Mardi", "start" => 10, "end" => 13, "title" => "Consultation spécialisée"],
                    ["day" => "Mercredi", "start" => 14, "end" => 17, "title" => "Consultation d'urgence"],
                ];

                // Affichage des événements dans le calendrier
                foreach ($events as $event) {
                    echo '<div class="events start-' . $event["start"] . ' end-' . $event["end"] . '">';
                    echo '<div class="event">';
                    echo '<div class="title">' . $event["title"] . '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
