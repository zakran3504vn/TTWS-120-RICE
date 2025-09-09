<?php
include '../config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['state'])) {
    $bank_id = $_POST['id'];
    $status = (int)$_POST['state'];

    $stmt = $conn->prepare("UPDATE banking SET status = ? WHERE bank_id = ?");
    $stmt->bind_param("ii", $status, $bank_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}

$conn->close();
