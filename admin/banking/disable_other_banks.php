<?php
include '../config/db_connection.php';

if (isset($_POST['id'])) {
    $bank_id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE banking SET status = 0 WHERE bank_id != ?");
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
