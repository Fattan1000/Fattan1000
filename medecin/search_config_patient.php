<?php
include("../util/connection.php");

if (isset($_POST['input']) && isset($_POST['id'])) {
    $input = mysqli_real_escape_string($conn, $_POST['input']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    $query = "SELECT patient.* FROM patient INNER JOIN rendez_vouz ON rendez_vouz.patient_id = patient.id
    WHERE rendez_vouz.status='confirmer'and (patient.nom LIKE '{$input}%' OR patient.prenom LIKE '{$input}%')AND medecin_id = $id
    "; $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $tele = $row['tele'];
            $daten = $row['date_naissance'];
           
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
                    <a href='historique_rdv.php?idp={$row['id']}&nom={$row['nom']}&prenom={$row['prenom']}' class='non-style-link'>
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
                        <p class='heading-main12' style='margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)'>We couldn't find anything related to your keywords!</p>
                        <a class='non-style-link' href='mespatient.php'>
                            <button class='login-btn btn-primary-soft btn' style='display: flex;justify-content: center;align-items: center;margin-left:20px;'>
                                &nbsp; Show all Patients &nbsp;
                            </button>
                        </a>
                    </center>
                    <br><br><br><br>
                </td>
            </tr>";
    }
}
?>
