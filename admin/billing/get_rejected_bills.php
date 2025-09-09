<?php
include '../config/db_connection.php';

$sql = "SELECT b.*, u.username FROM billing b LEFT JOIN users u ON b.user_id = u.id WHERE b.status = 2";
$result = $conn->query($sql);

$rejected_bills = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rejected_bills[] = $row;
    }
}

echo json_encode($rejected_bills);

$conn->close();
