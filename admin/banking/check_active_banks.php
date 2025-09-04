<?php
include '../config/db_connection.php';

$active_count = 0;
$current_active_id = null;
$stmt = $conn->prepare("SELECT COUNT(*) AS count, bank_id FROM banking WHERE status = 1 LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $active_count = $row['count'];
    $current_active_id = $row['bank_id'];
}
$stmt->close();

echo json_encode(['active_count' => $active_count, 'current_active_id' => $current_active_id]);
$conn->close();
