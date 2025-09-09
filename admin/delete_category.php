<?php
header('Content-Type: application/json');
include './config/db_connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);
    $sql = "DELETE FROM category WHERE CategoryID  = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);

    if ($stmt->execute()) {
        $response['success'] = $stmt->affected_rows > 0;
        $response['message'] = $stmt->affected_rows > 0 
            ? "Danh mục đã được xóa thành công."
            : "Không tìm thấy danh mục để xóa.";
    } else {
        $response['message'] = "Lỗi khi xóa danh mục: " . $conn->error;
    }
    $stmt->close();
} else {
    $response['message'] = "Thiếu ID.";
}

$conn->close();
echo json_encode($response);
