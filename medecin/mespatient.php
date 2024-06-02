<?php
include("../util/connection.php");
session_start();
$doctor_data = $_SESSION["medecin_data"];

$docid = $doctor_data["id"];
$docnom = $doctor_data["nom"];
$docprenom = $doctor_data["prenom"];
$docspecialite = $doctor_data["specialite"];
$docemail = $doctor_data["email"];
$image = $doctor_data["image"];
?>
<!DOCTYPE html>
<html lang="en">
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
        
    <title>Patients</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
<div class="icon-rectangle">
    <a href="dashboard-medecin.php" class="tooltip">
        <i class="fa-solid fa-stethoscope" style="margin-left:5px"></i>
        <span class="tooltiptext">rendez-vous</span>
    </a>
    <a href="mesrdv.php" class="tooltip">
        <i class="fa-regular fa-calendar-check" style="margin-left:6px"></i>
        <span class="tooltiptext">consultaions</span>
    </a>
    <a href="mespatient.php" class="tooltip">
        <i class="fa-solid fa-bed" style="margin-left:6px"></i>
        <span class="tooltiptext">Mes Patients</span>
    </a>
    <a href="agenda.php" class="tooltip">
        <i class="fa-solid fa-calendar-days" style="margin-left:6px"></i>
        <span class="tooltiptext">agenda</span>
    </a>
    <a href="parametres.php" class="tooltip">
        <i class="fa-solid fa-gear" style="margin-left:6px"></i>
        <span class="tooltiptext">Parametres</span>
    </a>
</div>
<div class="fixed-div" style="width:250px;,height:270px;">
    <img src="<?php echo $image ?>" id="profileimg">
    <div class="profile-info">
        <h1>Dr. <?php echo "$docnom" ?></h1>
        <p>Spécialité: <?php echo "$docspecialite" ?></p>
    </div>
</div>
<aside style="margin-top:230px;">
    <a href="dashboard-medecin.php">
        <i class="fa-solid fa-stethoscope"></i>
        gestionaire de rendez vous
    </a>
    <a href="mesrdv.php">
        <i class="fa-regular fa-calendar-check"></i>
        gestionaire de consultations
    </a>
    <a href="mespatient.php">
        <i class="fa-solid fa-bed"></i>
        Mes patients
    </a>
    <a href="agenda.php">
        <i class="fa-solid fa-calendar-days"></i>
        agenda
    </a>
    <a href="parametres.php">
        <i class="fa-solid fa-gear"></i>
        Paramètres
    </a>
</aside>
<a href="../util/logout.php"><button class="logout-button">Déconnexion</button></a>
<span class="logo">logo</span>
<span class="time" id="clock"></span>
<div class="calendar-container" id="calendarContainer">
    <div class="calendar-header">
        <button class="calendar-prev" id="prevMonth">&lt;</button>
        <span class="month-year" id="currentMonth">May 2024</span>
        <button class="calendar-next" id="nextMonth">&gt;</button>
    </div>
    <div class="calendar-days" id="calendar">
        <!-- Calendar days will be dynamically generated here -->
    </div>
</div>
<button id="transformButton" class="edit-button"><img style="position:center;" src="../photo/icons8-calendar-30.png"></button>
<div class="dash-body">
    <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
        <tr>
            <td width="13%">
                <a><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
            </td>
            <td>
                <form action="" method="post" class="header-search">
                    <?php echo "<input type='hidden' id='id_med' value='$docid'>" ?>
                    <input type="search" id="search" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;
                </form>
            </td>
        </tr>
        <tr>
            <?php 
                $list110 = mysqli_query($conn, "SELECT distinct patient.id FROM patient inner join rendez_vouz on patient.id=patient_id WHERE $docid=medecin_id;");
            ?>
            <td colspan="4" style="padding-top:10px;">
                <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo "  Patients (" . $list110->num_rows . ")"; ?></p>
            </td>
        </tr>
    </table>
    <center>
        <div class="abc scroll">
            <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                <thead>
                    <tr style="justify-content: left;">
                        <th class="table-headin" style="width:100px;">Nom</th>
                        <th class="table-headin" style="width:100px;">Prenom</th>
                        <th class="table-headin">Telephone</th>
                        <th class="table-headin">Date de Naissance</th>
                        <th class="table-headin">email</th>
                        <th class="table-headin">Event</th>
                    </tr>
                </thead>
                <tbody id="all_patient">
                    <?php 
                        $query = "SELECT distinct patient.* FROM patient INNER JOIN rendez_vouz ON rendez_vouz.patient_id = patient.id
                        WHERE (rendez_vouz.status='confirmer' or rendez_vouz.status='terminer') and medecin_id = $docid";
                        $result = mysqli_query($conn, $query);
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $nom = $row['nom'];
                                $prenom = $row['prenom'];
                                $tele = $row['tele'];
                                $daten = $row['date_naissance'];
                                $idp = $row['id'];
                                $email = $row['email'];
                                echo "
                                <tr style='justify-content: left;'>
                                    <td>$nom</td>
                                    <td>$prenom</td>
                                    <td>$tele</td>
                                    <td>$daten</td>
                                    <td>$email</td>
                                    <td>
                                        <div style='display:flex;justify-content: center;'>
                                            <a href='historique_rdv.php?idp=$idp&nom=$nom&prenom=$prenom' class='non-style-link'>
                                                <button class='btn-primary-soft btn button-icon btn-view' style='padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;'>
                                                    <font class='tn-in-text'>Historique</font>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='7'>
                                        <br><br><br><br>
                                        <center>
                                        <img src='../photo/notfound.jpg' width='35%'>
                                            <br>
                                            <p class='heading-main12' style='margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)'>you don't have any patients yet!</p>
                                            <a class='non-style-link' href='.php'>
                                                <button class='login-btn btn-primary-soft btn' style='display: flex;justify-content: center;align-items: center;margin-left:20px;'>
                                                    &nbsp; Take me Back to dashboard &nbsp;
                                                </button>
                                            </a>
                                        </center>
                                        <br><br><br><br>
                                    </td>
                                </tr>";
                        }
                    ?>
                </tbody>
                <tbody id="search_result">
                    <!-- Les résultats de la recherche seront injectés ici -->
                </tbody>
            </table>
        </div>
    </center>
</div>
<script>
    $(document).ready(function() {
        $('#search').keyup(function() {
            let input = $(this).val();
            let id = $("#id_med").val();

            if (input !== "") {
                $("#all_patient").hide();
                $.ajax({
                    url: "search_config_patient.php",
                    method: "POST",
                    data: { input: input, id: id },
                    success: function(data) {
                        $("#search_result").html(data).show();
                    }
                });
            } else {
                $("#search_result").hide();
                $("#all_patient").show();
            }
        });
    });
</script>
</body>
</html>
