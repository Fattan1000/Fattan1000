<?php
include("../util/connection.php");
include('middleware.php');

$doctor_data=$_SESSION["medecin_data"];

   $docid= $doctor_data["id"];
   $docnom=$doctor_data["nom"];
   $docprenom=$doctor_data["prenom"];
   $docspecialite=$doctor_data["specialite"];
   $docemail=$doctor_data["email"];
   $image =$doctor_data["image"];
   
   

   ;?>
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
        <i class="fa-regular fa-calendar-check"style="margin-left:6px"></i>
        <span class="tooltiptext">consultaions</span>
    </a>
    <a href="mespatient.php" class="tooltip">
        <i class="fa-solid fa-bed"style="margin-left:6px"></i>
        <span class="tooltiptext">Mes Patients</span>
    </a>
    <a href="agenda.php" class="tooltip">
        <i class="fa-solid fa-calendar-days"style="margin-left:6px"></i>
        <span class="tooltiptext">agenda</span>
    </a>
    <a href="parametres.php" class="tooltip">
        <i class="fa-solid fa-gear"style="margin-left:6px"></i>
        <span class="tooltiptext">Parametres</span>
    </a>
</div>
    <div class="fixed-div" style="width:250px;,height:270px;">
        <img src="<?php  echo $image?>" id="profileimg">
        <div class="profile-info">
            <h1>Dr. <?php echo "$docnom"?></h1>
            <p>Spécialité: <?php echo "$docspecialite"?></p>
        </div>
        <!--<button class="edit-button">Modifier</button>-->
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
<button id="transformButton" class="edit-button"><img style="position:center;"src="../photo/icons8-calendar-30.png"></button>

<div class="bonjour">
  
    <span id="bonjou">Bonjour&nbsp;</span>
    <span id="docname">Dr.<?php echo "$docnom"?></span>
</div>
<div class="RDVrecus">
    <h3>Les rendez-vous reçus:</h3>
    
        <!--for demo wrap-->
       
            <table class="recus"cellpadding="0" cellspacing="0" border="0">
                <thead >
                <tr >
                    <th style="font-size: 19px;">nom</th>
                    <th style="font-size: 19px;">prenom</th>
                    <th style="font-size: 19px;">date</th>
                    <th  style="font-size: 19px;">status</th>
                    <th   style="width: 250px;font-size: 19px;">   </th>
                </tr>
                </thead>
            
                <tbody >
                <tr >
                   
                    
                    
                   <!-- <td class="recus"><a href="?action=view&id='.$idRDV.'" class="non-style-link"><button class="view-button"><i class="fa-solid fa-eye"></i>voir</button></a>
                      </td></tr>-->
                   <?php   
                   
                   $sqlmai = "SELECT rendez_vouz.id,date_rdv,rendez_vouz.status FROM patient INNER JOIN rendez_vouz ON rendez_vouz.patient_id = patient.id WHERE  rendez_vouz.medecin_id = $docid  ORDER BY date_rdv ASC";
                   $test = mysqli_query($conn, $sqlmai);

                   // Check for query execution success
                   if ($test) {
                       // Current date without time
                       $today = new DateTime();
                       $todayFormatted = $today->format('Y-m-d');
                   
                       // Loop through each row in the result set
                       while ($roww = $test->fetch_assoc()) {
                           $date_rdv = new DateTime($roww["date_rdv"]);
                           $date_rdvFormatted = $date_rdv->format('Y-m-d');
                           $idr = $roww['id'];
                   
                           // Compare the appointment date with today's date
                           if ($date_rdvFormatted == $todayFormatted) {
                               
                   
                               if ($roww["status"] == "confirmer") {
                                   // Update status to 'terminer' if confirmed
                                   $updateResult = mysqli_query($conn, "UPDATE rendez_vouz SET status = 'terminer' WHERE id = $idr");
                                   echo "<script>alert('Vous avez un Rendez-vous aujourd\'hui.')</script>";
                               } elseif ($roww["status"] == "en attent") {
                                
                                   $updateResult = mysqli_query($conn, "UPDATE rendez_vouz SET status = 'annuler' WHERE id = $idr");
                                   
                               }
                           }
                       }
                   } else {
                       echo "Error executing query: " . mysqli_error($conn);
                   }
                  
                   
                     
                   
                   $sqlmain = "SELECT rendez_vouz.id,rendez_vouz.description,date_rdv,rendez_vouz.status, patient.nom,heure_debut_rdv, patient.prenom, patient.tele, patient.email FROM patient INNER JOIN rendez_vouz ON rendez_vouz.patient_id = patient.id WHERE  date_rdv > CURDATE() and rendez_vouz.status='en attent'and rendez_vouz.medecin_id = $docid  ORDER BY date_rdv ASC";
   $result=mysqli_query($conn,$sqlmain); 

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../photo/notfound.jpg" width="35%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Vous n\'avez reçus  aucun Rendez-Vous pour le moment  !</p>
                                    <a class="non-style-link" href="mesrdv.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Afficher tous les Rendez-Vous &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $patientnom=$row["nom"];
                                    $patientprenom=$row["prenom"];
                                    $patienttele=$row["tele"];
                                    $dateRDV=$row["date_rdv"];
                                    $tempRDV=$row["heure_debut_rdv"];
                                    $idRDV=$row["id"];
                                    $RDVstatus=$row["status"];
                                    $RDVdescription=$row["description"];
                                      $patientemail=$row["email"];
                                    
                                   
                                    echo '<tr class="active-row">
                                    <td style="font-weight:300;font-size:17px;">'. substr($patientnom,0,25)
                                       
                                        .'</td style="text-align:center;font-size:17px;font-weight:300;  var(--btnnicetext);">
                                        <td style="font-size: 17px;font-weight:300;">'. substr($patientprenom,0,25)
                                       
                                        .'</td >
                                        <td style="font-size: 17px;font-weight:300;">
                                            '.substr($dateRDV,0,10).'
                                        </td>
                                     
                                        <td  style="width=100px;font-size: 17px;font-weight:300;">
                                        '.substr($RDVstatus,0,10).'
                                    </td>
                                
                                        <td style="display:flex;width: 250px;font-size: 17px;font-weight:300;">
                                        
                                        <a href="?action=view&id='.$idRDV.'" ><button class="edit-button"><i class="fa-solid fa-eye"></i>Voir</button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=drop&id='.$idRDV.'&name='.$patientnom.'" ><button class="edit-button">Annuler</button></a>
                                       &nbsp;&nbsp;&nbsp;</div>
                                        </td>
                                    </tr>';
                                    
                                }}?>
                                
                </tbody>
            </table>
        
</div><?php
if($_GET){
    $id=$_GET["id"];

        $action=$_GET["action"];
      if($action=='drop'){
                                        $nameget=$_GET["name"];
                                        $session=$_GET["session"];
                                        $apponum=$_GET["apponum"];
                                        echo '
                                        <div id="popup1" class="overlay">
                                                <div class="popup">
                                                <center>
                                                    <h2>ATTENTION!etes vous sur?</h2>
                                                    <a class="close" href="dashboard-medecin.php">&times;</a>
                                                    <div class="content">
                                                       etes vous sure de supprimer ce rendez-vous<br><br>
                                                        Patient nom: &nbsp;<b>'.substr($nameget,0,40).'</b><br>
                                                       nombre rendez-vous &nbsp; : <b>'.substr($apponum,0,40).'</b><br><br>
                                                        
                                                    </div>
                                                    
                                                    <div style="display: flex;justify-content: center;">
                                                    <form method="post" > 
                                                    <a  class="non-style-link" href="mesrdv.php"><button name="annuler" type="submit" class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;OUI&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                                                    </form>
                                                     <a href="dashboard-medecin.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;NON&nbsp;&nbsp;</font></button></a>
                                                   
                                                    </div>
                                                </center>
                                        </div>
                                        </div>
                                        '; if(isset($_POST["annuler"])){
                                            mysqli_query($conn,"UPDATE rendez_vouz
                                            SET status = 'annuler'
                                            WHERE id=$id;");  echo"<script>alert('ce rendez vous a été annuler')</script>"; }
                                
                                    }elseif($action=='view'){
                                      //$sqlmain= "select * from medecin where id='$id'";
            $sqlmain = "SELECT rendez_vouz.id,date_rdv, patient.nom, patient.email, rendez_vouz.description,rendez_vouz.status,rendez_vouz.heure_debut_rdv, patient.prenom, patient.tele FROM patient INNER JOIN rendez_vouz ON rendez_vouz.patient_id = patient.id WHERE rendez_vouz.medecin_id = $docid";
           
            $result=mysqli_query($conn,$sqlmain); 
            $row=$result->fetch_assoc();
          
            $patientnom=$row["nom"];
          $patientprenom=$row["prenom"];
                $patienttele=$row["tele"];
                $dateRDV=$row["date_rdv"];
                $tempRDV=$row["heure_debut_rdv"];
               
                $RDVstatus=$row["status"];
                $RDVdescription=$row["description"];
                  $patientemail=$row["email"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="dashboard-medecin.php">&times;</a>
                        <div class="content">
                          
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">rendez-vous detail</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Nom et Prenom: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$patientnom.'&nbsp;'.$patientprenom.'<br><br>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"> date et heure Rendez-Vous: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            à&nbsp;'.$tempRDV.'&nbsp;le '.$dateRDV.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">Description: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$RDVdescription.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$patienttele.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Email: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$patientemail.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Status: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$RDVstatus.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <form method="post">
                                    <a href="dashboard-medecin.php"><button  name="confirmer" type="submit"  class="login-btn btn-primary-soft btn" >confirmer</button></a>
                                </form>
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';  if(isset($_POST["confirmer"])){
                mysqli_query($conn,"UPDATE rendez_vouz
                SET status = 'confirmer'
                WHERE id=$id;");  echo"<script>alert('ce rendez vous a été confirmer')</script>"; }
    
                                }
                            }
                            ?>

</body>
</html>

