<?php
include __DIR__ . '/../config/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $content = $_POST['message'] ?? '';
    $address = $_POST['address'] ?? null; 
// var_dump($name, $email, $phone, $content, $address, $subject);
// die;
    $sql = "INSERT INTO contact_customer (name, address, email, phone, content)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $address, $email, $phone, $content);

    if ($stmt->execute()) {
        header("Location: ../lien-he/index.php?status=success");
    } else {
        echo "ERROR";
    }

    $stmt->close();
    $conn->close();
}
