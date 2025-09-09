<?php
header('Content-Type: application/json');
include './config/db_connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['id'])) {
    $customer_id = intval($_POST['id']);

    $sql = "DELETE FROM contact_customer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $customer_id);

    if ($stmt->execute()) {
        $response['success'] = ($stmt->affected_rows > 0);
        $response['message'] = $stmt->affected_rows > 0 
            ? 'Khách hàng đã được xóa thành công.' 
            : 'Không tìm thấy khách hàng để xóa.';
    } else {
        $response['message'] = 'Lỗi khi xóa khách hàng: ' . $conn->error;
    }

    $stmt->close();
} else {
    $response['message'] = 'ID không hợp lệ.';
}

$conn->close();

echo json_encode($response);
