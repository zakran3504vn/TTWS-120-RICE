<?php
include '../config/db_connection.php';

header('Content-Type: application/json');

$sql = "SELECT b.*, u.username FROM billing b LEFT JOIN users u ON b.user_id = u.id WHERE b.status = 1";
$result = $conn->query($sql);

$approved_bills = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $approved_bills[] = $row;
    }
}

echo json_encode($approved_bills);
$conn->close();
