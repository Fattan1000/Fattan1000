<?php
include("../util/connection.php");

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['title']) && isset($data['day']) && isset($data['startHour']) && isset($data['endHour'])) {
    $title = $conn->real_escape_string($data['title']);
    $day = $conn->real_escape_string($data['day']);
    $startHour = $conn->real_escape_string($data['startHour']);
    $endHour = $conn->real_escape_string($data['endHour']);

    $sql = "DELETE FROM creneau WHERE titre='$title' AND jour='$day' AND heure_debut='$startHour:00' AND heure_fin='$endHour:00'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}

$conn->close();
?>
