<?php
include("../util/connection.php");

  session_start();

 $soumissionReussie = false;
   
 $patient_data=$_SESSION["patient_data"];

 $patid= $patient_data["id"];
 $patnom=$patient_data["nom"];
 $patprenom=$patient_data["prenom"];
 $patemail=$patient_data["email"];

   if (isset($_GET["id"]) ){
    $rdvtid=$_GET["id"];
     
    
   
}
   
   
 
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
        
    <title>Appointments</title>
    <style>
        .rapport.scrollable {
    max-height: 500px; /* Ajustez la hauteur maximale selon vos besoins */
    overflow-y: auto;
}  
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
    <a href="../home.php" class="tooltip">
        <i class="fa-solid fa-house"style="margin-left:6px"></i>
        <span class="tooltiptext">Home</span>
    </a>
    
    <a href="dashboard-patient.php" class="tooltip">
        <i class="fa-regular fa-calendar-check"style="margin-left:6px"></i>
        <span class="tooltiptext">Mes Rendez-Vous</span>
    </a>
    <a href="historiquerdv.php" class="tooltip">
        <i class="fa-solid fa-bed"style="margin-left:6px"></i>
        <span class="tooltiptext">Hisrorique des   Rendez-Vous</span>
    </a>
    
    <a href="parametres.php" class="tooltip">
        <i class="fa-solid fa-gear"style="margin-left:6px"></i>
        <span class="tooltiptext">Paramétres</span>
    </a>
</div>
    <div class="fixed-div" style="width:250px;,height:270px;">
        
        <div class="profile-info">
            <h1  style="margin-top:120px;"><?php echo "$patnom $patprenom"?></h1>
            
        </div>
       <!-- <button class="edit-button">Modifier</button>-->
    </div>
    <aside style="margin-top:250px;">
        <a href="../home.php">
            <i class="fa-solid fa-house"></i>
            Home
        </a>
       
        <a href="dashboard-patient.php">
            <i class="fa-regular fa-calendar-check"></i>
            Mes rendez-vous
        </a>
        <a href="historiquerdv.php.php">
            <i class="fa-solid fa-bed"></i>
            Hisrorique des Rendez-Vous
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
<button id="transformButton" class="edit-button"><img style="position:center;"src="../photo/icons8-calendar-30.png"></button>

<div class="dash-body">
    <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">
    
        <tr style="display:flex;">
            <td width="13%">
                <a >
                    <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                        <font class="tn-in-text">Back</font>
                    </button>
                </a>
            </td>
            <td>
                <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Fiche Medicale</p>
            </td>
        </tr>
        <form method="post">
        <tr>
           
        </tr>
        <tr id="rapport_existant">
            <td colspan="4">
                <p style="font-size: 19px; padding-left: 12px; font-weight: 600;">Rapport Medicale :</p>
                <div class="rapport scrollable" style="font-size: 18px; font-weight: bold; color: #333; background-color: #f2f2f2; padding: 20px; border-radius: 10px; margin-top: 20px; margin-left: 250px; width: 700px; height: 800px;">
                    <?php
                        $sqlmain = "SELECT id,rapport, medicament FROM ficheconsultation  WHERE id_rdv =  $rdvtid";
                        $result = mysqli_query($conn, $sqlmain);
                        if($result->num_rows>0) {
                        $row = $result->fetch_assoc();
                        $rapport = $row["rapport"];
                        $medicament = $row["medicament"]; }
                        else{
                            $rapport = '';
                            $medicament = ''; 
                        }
                    ?>
                    <p placeholder="mama"><?php
                    if($rapport!='') echo  $rapport;
                    else echo"  aucun rapport n'est ajouter " ?></p>
                   
                </div>
                <p style="font-size: 19px; padding-left: 12px; font-weight: 600;">Medicament :</p>
                <div class="rapport" style="font-size: 18px; font-weight: bold; color: #333; background-color: #f2f2f2; padding: 20px; border-radius: 10px; margin-top: 20px; margin-left: 250px; width: 500px; height: 250px;">
                    <p> <?php   if($medicament!='') echo $medicament;
                    else echo"  aucun medicament n'est ajouter " ?></p>
                </div>
            </td>
        </tr>
        
        
    </form>
    </table>
</div>

                                               
</body>
</html>