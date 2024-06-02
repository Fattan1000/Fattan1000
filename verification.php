<?php 
// Inclusion des fichiers nécessaires
include("util/connection.php");
include("util/navbar.php");

// Récupération des paramètres de l'URL avec des valeurs par défaut si non définis
$creneau_id = isset($_GET['creneau_id']) ? $_GET['creneau_id'] : 'inconnu';
$id_medecin = isset($_GET['id_medecin']) ? $_GET['id_medecin'] : 'inconnu';
$patient_id = $_GET['patient_id']; 
$motif = isset($_GET['motif']) ? $_GET['motif'] : 'inconnu';
$date = isset($_GET['date']) ? $_GET['date'] : 'inconnue';
$hour = isset($_GET['hour']) ? $_GET['hour'] : 'inconnue';

// Inclure la bibliothèque Twilio
require_once __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

// Informations d'identification Twilio
$account_sid = 'AC3a5a7139dd2c3fb4bfd925f7ed9b27f1';
$auth_token = '5c30525d99d271eb0e805a9a9f2a0515';
$twilio_number = '+13395005936';

// Vérifie si le formulaire de vérification a été soumis
if(isset($_POST['verify'])) {
    // Vérifie si le code de vérification est correct
    if(isset($_SESSION['verification_code'])) {
        $user_code = $_POST['verification_code'];
        $correct_code = $_SESSION['verification_code'];

        // Si le code est correct, redirige vers la page finalisation.php
        if($user_code == $correct_code) {
            header("Location: finalisation.php?id_medecin=$id_medecin&patient_id=$patient_id&date=$date&hour=$hour&motif=$motif&creneau_id=$creneau_id");
            exit();
        } else {
            // Affiche un message d'erreur si le code est incorrect
            echo "Code incorrect.";
        }
    } else {
        // Affiche un message d'erreur si aucun code de vérification n'est défini dans la session
        echo "Aucun code de vérification trouvé.";
    }
}

// Génère un code de vérification et l'enregistre dans la session
$code = rand(100000, 999999); // Génère un code de 6 chiffres aléatoires
$_SESSION['verification_code'] = $code;

// Vérifie si l'ID du patient est défini
if(isset($patient_id)) {
    $patient_id = mysqli_real_escape_string($conn, $patient_id);
    $query = "SELECT * FROM patient WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $patient_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Si un patient est trouvé, envoie un SMS avec le code de vérification
    if($row = mysqli_fetch_assoc($result)) {
        $phone_number = $row['tele'];

        // Initialise le client Twilio
        $client = new Client($account_sid, $auth_token);

        // Envoie du SMS
        $client->messages->create(
            $phone_number,
            [
                'from' => $twilio_number,
                'body' => "Votre code de vérification est : $code"
            ]
        );
?>

        <!-- Style de la page de vérification -->
        <style>
            body {
                background-color: #E3FEF7;
            }
            .verification {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 400px;
                padding: 20px;
                text-align: center;
                margin-top: 180px;
                margin-left: 550px;
            }
            .verification label {
                display: block;
                margin-bottom: 10px;
                font-size: 18px;
                color: #333;
            }
            .code {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 20px;
                border: 2px solid #083344;
                border-radius: 6px;
                font-size: 16px;
            }
            .verifier {
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
            .verifier:hover {
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
                margin-right: 150px;
            }
            .precedent:hover {
                background-color: #0a465a;
            }
        </style>

        <!-- Affichage du message et du formulaire de vérification -->
        <div class="verification">
            <?php
            echo "<p>Le code de vérification a été envoyé à : " . $row['tele'] . "</p>";

            // Affiche le formulaire de vérification
            echo '
            <form action="" method="POST">
                <label for="verification_code">Code de vérification :</label>
                <input class="code" type="text" id="verification_code" name="verification_code" required>
                <button type="button" class="precedent" onclick="window.location.href = \'confirmer.php?id_medecin=' . $id_medecin . '&patient_id=' . $patient_id . '&date=' . $date . '&hour=' . $hour . '&creneau_id=' . $creneau_id . '&motif=' . $motif . '\';">Précédent</button>
                <button type="submit" name="verify" class="verifier">Vérifier</button>
            </form>
            ';
            ?>
        </div>

        <?php
    } else {
        // Affiche un message d'erreur si aucun patient n'est trouvé
        echo "<p>Aucun patient trouvé.</p>";
    }
} else {
    // Affiche un message d'erreur si aucun ID patient n'est fourni
    echo "<p>Aucun ID patient fourni.</p>";
}
?>
