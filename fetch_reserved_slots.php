<?php
include("util/connection.php");

$reservedSlots = [];
$stmt = $conn->prepare("SELECT creneau_id, date_rdv FROM rendez_vouz");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $reservedSlots[$row['date_rdv']][] = $row['creneau_id'];
}
$stmt->close();

echo json_encode($reservedSlots);
?>