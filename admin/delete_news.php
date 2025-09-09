<?php
header('Content-Type: application/json');
include 'config/db_connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['id'])) {
    $news_id = $_POST['id'];

    // Chuẩn bị và thực thi câu lệnh xóa
    $sql = "DELETE FROM news WHERE news_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $news_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Tin tức đã được xóa thành công.';
    } else {
        $response['message'] = 'Không thể xóa tin tức.';
    }

    $stmt->close();
} else {
    $response['message'] = 'ID không hợp lệ.';
}

$conn->close();
echo json_encode($response);
?>

