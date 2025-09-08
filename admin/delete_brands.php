<?php
header('Content-Type: application/json; charset=utf-8');
include './config/db_connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_GET['id'])) {
    $brandId = intval($_GET['id']);

    // Kiểm tra có sản phẩm nào liên kết với thương hiệu không
    $checkSql = "SELECT COUNT(*) AS count FROM products WHERE brandID = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $response['success'] = false;
        $response['message'] = "Không thể xóa! Thương hiệu này có sản phẩm liên kết.";
    } else {
        $deleteSql = "DELETE FROM brands WHERE brandID = ?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $brandId);
        if ($stmt->execute()) {
            $response['success'] = $stmt->affected_rows > 0;
            $response['message'] = $stmt->affected_rows > 0
                ? "Thương hiệu đã được xóa thành công."
                : "Không tìm thấy thương hiệu để xóa.";
        } else {
            $response['message'] = "Lỗi khi xóa thương hiệu: " . $conn->error;
        }
        $stmt->close();
    }
} else {
    $response['message'] = "Thiếu ID.";
}

$conn->close();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
