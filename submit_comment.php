<?php
session_start();
include("util/connection.php");

if (!isset($_SESSION['patient_data'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers login.php
    header("Location: login2.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['commentaire']) && isset($_POST['note']) && isset($_POST['id_medecin'])) {
        $commentaire = mysqli_real_escape_string($conn, $_POST['commentaire']);
        $note = mysqli_real_escape_string($conn, $_POST['note']);
        $doctorId = mysqli_real_escape_string($conn, $_POST['id_medecin']);
        
        $patient_data = $_SESSION['patient_data'];
        $patient_id = $patient_data['id'];

        $dateEvaluation = date("Y-m-d H:i:s");

        $query = "INSERT INTO evaluation (medecin_id, patient_id, note, commentaire, date_evaluation) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiiss', $doctorId, $patient_id, $note, $commentaire, $dateEvaluation);
        mysqli_stmt_execute($stmt);

        // Fetch updated comments
        $query = "
            SELECT e.commentaire, e.note, e.date_evaluation, p.nom AS patient_nom, p.prenom AS patient_prenom
            FROM evaluation e
            JOIN patient p ON e.patient_id = p.id
            WHERE e.medecin_id = ?
        ";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $doctorId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p><strong>" . $row['patient_prenom'] . " " . $row['patient_nom'] . "</strong> " . $row['date_evaluation'] . " / ";
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $row['note']) {
                    echo "<i class='fas fa-star' style='color: gold;'></i>";
                } else {
                    echo "<i class='far fa-star' style='color: gold;'></i>";
                }
            }
            echo "<br> " . $row['commentaire'] . "</p>";
        }
    }
}
?>