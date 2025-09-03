<?php
include 'config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: in ra dữ liệu nhận được
    file_put_contents("debug_log.txt", print_r($_POST, true));

    $id = intval($_POST['id'] ?? 0);
    $stateRaw = $_POST['state'] ?? 'null';

    $state = ($stateRaw === 'true') ? 1 : 0;

    if ($id > 0) {
        $sql = "UPDATE products SET product_features = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $state, $id);

        if ($stmt->execute()) {
            echo "OK - Product $id updated to $state";
        } else {
            echo "SQL error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: invalid product_id or missing state (got id=$id, state=$stateRaw)";
    }
}
