<?php
require '../config/db_connection.php';

// Set the content type to JSON
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $brand_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($brand_id === false || $brand_id <= 0) {
        $response['message'] = 'ID không hợp lệ.';
        echo json_encode($response);
        exit();
    }

    // Kiểm tra xem có sản phẩm nào tham chiếu đến brandID này không
    $checkProducts = "SELECT COUNT(*) AS count FROM products WHERE brandID = ?";
    $stmt = $conn->prepare($checkProducts);
    if (!$stmt) {
        $response['message'] = 'Lỗi cơ sở dữ liệu khi kiểm tra sản phẩm liên kết.';
        echo json_encode($response);
        exit();
    }
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $response['message'] = 'Không thể xóa thương hiệu vì có sản phẩm liên kết.';
        echo json_encode($response);
        exit();
    }

    // Xóa thương hiệu nếu không có sản phẩm liên kết
    $deleteBrand = "DELETE FROM brands WHERE brandID = ?";
    $stmt = $conn->prepare($deleteBrand);
    if (!$stmt) {
        $response['message'] = 'Lỗi cơ sở dữ liệu khi chuẩn bị xóa.';
        echo json_encode($response);
        exit();
    }
    $stmt->bind_param("i", $brand_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Xóa thương hiệu thành công.';
    } else {
        $response['message'] = 'Lỗi khi xóa thương hiệu.';
    }
    $stmt->close();
} else {
    $response['message'] = 'Yêu cầu không hợp lệ.';
}

$conn->close();
echo json_encode($response);
?>