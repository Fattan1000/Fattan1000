
<?php
include("../util/connection.php");
  session_start();
$doctor_data=$_SESSION["medecin_data"];

   $docid= $doctor_data["id"];
   $docnom=$doctor_data["nom"];
   $docprenom=$doctor_data["prenom"];
   $docspecialite=$doctor_data["specialite"];
   $docemail=$doctor_data["email"];
   $image =$doctor_data["image"];

?><!DOCTYPE html>
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
    <script src="https://cdn.tiny.cloud/1/18cx3orgvc052xa0xqp7soafpy6p9wm472cl92p592ic5pyu/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>

        // Initialisation de TinyMCE
        tinymce.init({
            selector: 'textarea',
            plugins: 'lists link image imagetools media',
            toolbar: false,  menubar: false,
            statusbar: true, // Désactive la barre d'état
            height: 150,
        });

        // Fonction de gestion de la soumission du formulaire
        function handleSubmit(event) {
            // Sauvegarder le contenu de TinyMCE dans le textarea
            tinymce.triggerSave();

            // Rendre les textarea focusables
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.style.display = 'block';
                textarea.required = false; // Désactiver le required temporairement
            });

            // Soumettre le formulaire manuellement
            event.target.submit();
        }
    </script>

    <title>parametres</title>
    <style>
        
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-X  0.5s;
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

        
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                        <td width="13%" >
                    <a ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">paramétres</p>
                                           
                    </td>
                    
                        
                                    <?php 
                              
                              $today = date('Y-m-d');
                            
                                $patientrow =   mysqli_query($conn,"select  * from  patient;"); 
                                $medecinrow= mysqli_query($conn,"select  * from  medecin");
                                $revdezvousrow =   mysqli_query($conn,"select  * from  rendez_vouz where date_rdv>='$today';"); ;
                               


                                ?>
                                </p>
                            </td>
                            
        
        
                        </tr>
                <tr>
                    <td colspan="4">
                        
                        <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">
                                    <a href="?action=edit&id=<?php echo $docid ?>&error=0" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../photo/doctors-hover.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard">
                                                   Parametres du compte  &nbsp;

                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px;">
                                                modifie votre compte details et changer votre mot de passe    
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                                
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=view&id=<?php echo $docid ?>" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting " style="background-image: url('../photo/view-iceblue.svg');"></div>
                                        <div>
                                                <div class="h1-dashboard" >
                                                    voir les Details du compte
                                                    
                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                   voir les informations de votre compte 
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 5px">&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                            <td style="width: 25%;">
                                    <a href="?action=drop&id=<?php echo $docid.'&name='.$docnom ?>" class="non-style-link">
                                    <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../photo/icons_supprimer.png');"></div>
                                        <div>
                                                <div class="h1-dashboard" style="color: #ff5050;">
                                                   Supprimer compte
                                                    
                                                </div><br>
                                                <div class="h3-dashboard"  style="font-size: 15px;">
                                                    supprimer votre compte pour toujours 
                                                </div>
                                        </div>
                                                
                                    </div>
                                    </a>
                                </td>
                                
                            </tr>
                        </table>
                    </center>
                    </td>
                </tr>
            
            </table>
        </div>
    
    <?php 
    if($_GET){
        
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='drop'){
            $nameget=$_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="parametres.php">&times;</a>
                        <div class="content">
                            voulez vous supprimer le compte<br>('.substr($docnom,0,40).').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-doctor.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Oui&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="parametres.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Non&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='view'){
            $sqlmain= "select * from medecin where id='$id'";
            $result=mysqli_query($conn,$sqlmain); 
            $row=$result->fetch_assoc();
            $nom=$row["nom"];
            $prenom=$row["prenom"];
            $email=$row["email"];
            $specialite=$row["specialite"];
            $ville=$row["ville"];
            $presentation=$row["presentation"];
            $expdip=$row["experience_diplome"];
            $horaire=$row["horaires"];
            $modpai=$row["mode_paiement"];
            $tarif=$row["tarif"]; 
             
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2></h2>
                        <a class="close" href="parametres.php">&times;</a>
                        <div class="content">
                          
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">medecin details:</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Nom et Prenom: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$nom.'&nbsp;'.$prenom.'<br><br>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"> Email: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            à&nbsp;'.$email.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">Specialite: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$specialite.'<br><br>
                                </td>
                            </tr>
                            <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">ville: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$ville.'<br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Presentasion: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$presentation.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">experience et diplome </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$expdip.'<br><br>
                            </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label">Mode paiement: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            '.$modpai.'<br><br>
                            </td>
                        </tr>
                        <tr>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Tarif: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                        '.$tarif.'<br><br>
                        </td>
                    </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Horaires: </label>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$horaire.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="parametres.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                                
                                    
                                </td>
                
                            </tr>
                           

                        </table>
                        </div></div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';  
        }elseif($action=='edit'){
            $sqlmain= "select * from medecin where id='$id'";
            $result=mysqli_query($conn,$sqlmain); 
            $row=$result->fetch_assoc();
            $nom=$row["nom"];
            $prenom=$row["prenom"];
            $email=$row["email"];
            $specialite=$row["specialite"];
            $ville=$row["ville"];
            $presentation=$row["presentation"];
            $expdip=$row["experience_diplome"];
            $horaire=$row["horaires"];
            $modpai=$row["mode_paiement"];
            $tarif=$row["tarif"]; 
    
            $nic=0;
            $tele=0;

            $error_1=$_GET["error"];
                $errorlist= array(
                    '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">cette adresse email exist deja dans un autre compte Email .</label>',
                    '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"> Erreur de  Confirmation du Mot de Passe ! Reconfirmer votre Mot de passe</label>',
                    '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                    '4'=>"",
                    '0'=>'',

                );

            if($error_1!='4'){
                    echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                           
                                <a class="close" href="parametres.php">&times;</a> 
                                <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                        <td class="label-td" colspan="2">'.
                                            $errorlist[$error_1]
                                        .'</td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="edit-doc.php" method="POST" onsubmit="return handleSubmit(event)" class="add-new-form">
                                            
                                            <input type="hidden" value="'.$id.'" name="id00">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Nom: </label>
                                        <input type="hidden" name="oldemail" value="'.$email.'" >
                                        <input type="text" name="nom" class="input-text" placeholder="nom" value="'.$nom.'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Prenom: </label>
                                        <input type="hidden" name="prenom" value="'.$prenom.'" >
                                        <input type="text" name="prenom" class="input-text" placeholder="prenom" value="'.$prenom.'" required><br>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Email: </label>
                                        <input type="hidden" name="oldemail" value="'.$email.'" >
                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="'.$email.'" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">specialite: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="specialite" class="input-text" placeholder="specialite" value="'.$specialite.'" required><br>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                    <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">ville: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="ville" class="input-text" placeholder="ville" value="'.$ville.'" required><br>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">Description: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <textarea type="text" name="desc" class="input-text" placeholder="écriver une bref description sur vous et votre cabinet"  ></textarea><br>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">tarif: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="tarif" class="input-text" placeholder="tarif" value="'.$tarif.'" ><br>
                                </td>
                                
                            </tr>
                            <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">experiences et Diplômes: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <textarea type="text" name="expdip" class="input-text" placeholder="écriver un bref paragraphe où vous décrivez votre parcours académique et professionnel"  ></textarea><br>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Mode de paiement: </label>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                     <input type="checkbox" name="modpai[]" value="especes"  >par espèces<br>
                                     <input type="checkbox" name="modpai[]" value="cheque"  >par cheque <br>
                                     <input type="checkbox" name="modpai[]" value="carte"   >par carte  <br>
                           
                                            
      <br>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Horaires: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <textarea  name="horaire" class="input-text" placeholder="essayez d\'écrire votre horaires sous cette forme: Lundi:09h00-13h00,14h00-19h00"
                                                                        
     value="'.htmlspecialchars(nl2br($horaire)).'" ></textarea><br>
                                    </td>
                                </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="password" class="form-label">Password: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="password" name="password" class="input-text" placeholder="Definir un Mot de Passe" ><br>
                                        </td>
                                    </tr><tr>
                                        <td class="label-td" colspan="2">
                                            <label for="cpassword" class="form-label">Confirmer Mot de Passe: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="password" name="cpassword" class="input-text" placeholder="Confirmer Mot de Passe" required><br>
                                        </td>
                                    </tr>
                                    
                        
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Renisialliser" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                            <input type="submit" value="Enregistrer" name="submit"class="login-btn btn-primary btn">
                                        </td>
                        
                                    </tr>
                                
                                    </form>
                                    </tr>
                                </table>
                                </div>
                                </div>
                            </center>
                            <br><br>
                    </div>
                    </div>
                    ';
        }else{
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                        <br><br><br><br>
                            <h2>changement effectuer!</h2>
                            <a class="close" href="parametres.php">&times;</a>
                            <div class="content">
                                 si vous changer votre email déconnecter vous et refaite le login avec votre nouveau email
                            </div>
                            <div style="display: flex;justify-content: center;">
                            
                            <a href="parametres.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                            <a href="../util/logout.php" class="non-style-link"><button  class="btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Log out&nbsp;&nbsp;</font></button></a>

                            </div>
                            <br><br>
                        </center>
                </div>
                </div>
    ';



        }; }

    }
        ?>

</body>
</html>