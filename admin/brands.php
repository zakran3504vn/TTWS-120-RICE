<?php
session_start();
include './config/db_connection.php';

// Xử lý các trang con
if (isset($_GET['current_page'])) {
    switch ($_GET['current_page']) {
        case 'delete_brands':
            include 'delete_brands.php';
            exit;
        case 'add_brands':
            include 'add_brands.php';
            exit;
        case 'edit_brands':
            include 'edit_brands.php';
            exit;
    }
}

// Số bản ghi hiển thị mỗi trang
$records_per_page = 10;

// Trang hiện tại
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $records_per_page;

// Tìm kiếm
$search_keyword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search_keyword'])) {
    $search_keyword = trim($_POST['search_keyword']);
}

// Lấy tổng số bản ghi
if (!empty($search_keyword)) {
    $total_sql = "SELECT COUNT(*) AS total FROM brands WHERE brandName LIKE ?";
    $stmt = $conn->prepare($total_sql);
    $param = '%' . $search_keyword . '%';
    $stmt->bind_param('s', $param);
    $stmt->execute();
    $total_records = $stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();

    $sql = "SELECT * FROM brands WHERE brandName LIKE ? LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $param, $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $total_records = $conn->query("SELECT COUNT(*) AS total FROM brands")->fetch_assoc()['total'];
    $sql = "SELECT * FROM brands LIMIT $records_per_page OFFSET $offset";
    $result = $conn->query($sql);
}

$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Thương Hiệu</title>
    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include 'includes/sidebar.php'; ?>

<div class="container mt-4">
    <h3>Quản Lý Thương Hiệu</h3>
    <form action="" method="POST" class="mb-3">
        <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($search_keyword) ?>">
        <button type="submit">Tìm</button>
    </form>
    <a href="?current_page=add_brands" class="btn btn-success mb-3">Thêm Thương Hiệu</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Thương Hiệu</th>
                <th>Ảnh</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $stt = $offset + 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$stt}</td>";
                    echo "<td>" . htmlspecialchars($row['brandName']) . "</td>";
                    echo "<td>";
                    if (!empty($row['brandImg'])) {
                        $img_path = 'assets/img/'. $_SESSION['username'] . '/' . htmlspecialchars($row['brandImg']);
                        echo "<img src='$img_path' alt='Brand Image' style='width:100px;height:100px;object-fit:fill;'>";
                    } else {
                        echo "Không có ảnh";
                    }
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row['brandDescription']) . "</td>";
                    echo "<td>
                            <a href='?current_page=edit_brands&id={$row['brandID']}' class='btn btn-primary btn-sm'>Sửa</a>
                            <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['brandID']}'>Xóa</button>
                          </td>";
                    echo "</tr>";
                    $stt++;
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Không có thương hiệu nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <nav>
        <ul class="pagination">
            <?php if ($current_page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $current_page-1 ?>">&laquo;</a></li>
            <?php endif; ?>
            <?php for ($p=1;$p<=$total_pages;$p++): ?>
                <li class="page-item <?= ($p==$current_page)?'active':'' ?>"><a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a></li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $current_page+1 ?>">&raquo;</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script src="js/jquery1-3.4.1.min.js"></script>
<script src="js/bootstrap1.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-id");

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gọi AJAX xóa
                    fetch(`delete_brands.php?id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload(); // reload bảng sau khi xóa
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: data.message
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi gửi yêu cầu.'
                            });
                            console.error(err);
                        });
                }
            });
        });
    });
});
</script>

</body>
</html>
