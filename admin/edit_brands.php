<?php
include './config/db_connection.php';

$img_path = './assets/img/' . $_SESSION['username'] . '/brands/';
$success_message = "";
$errors = [];

// Kiểm tra ID brand từ URL
if (isset($_GET['id'])) {
    $brand_id = intval($_GET['id']);

    $sql = "SELECT * FROM brands WHERE brandID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $brand = $result->fetch_assoc();
    $stmt->close();

    if (!$brand) {
        $errors[] = "Không tìm thấy thương hiệu.";
    }
} else {
    $errors[] = "ID thương hiệu không hợp lệ.";
}

// Xử lý form submit cập nhật brand
if (isset($_POST['update_brand'])) {
    $brand_name = trim($_POST['brand_name']);
    $brand_description = trim($_POST['brand_description']);

    if (empty($brand_name)) {
        $errors[] = "Tên thương hiệu không được để trống.";
    }

    $brand_img = $brand['brandImg'];

    if (!empty($_FILES['brand_img']['name'])) {
        $tmp_name = $_FILES['brand_img']['tmp_name'];
        $size = $_FILES['brand_img']['size'];
        $error = $_FILES['brand_img']['error'];
        $name = $_FILES['brand_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= 3 * 1024 * 1024) {
                $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowed_exts = ['jpg','jpeg','png','gif'];
                if (in_array($file_ext, $allowed_exts)) {
                    $file_name = uniqid() . '.' . $file_ext;
                    $file_dest = $img_path . $file_name;

                    if (!is_dir($img_path)) {
                        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
                            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
                        }
                    }

                    if (move_uploaded_file($tmp_name, $file_dest)) {
                        if (!empty($brand['brandImg']) && file_exists($img_path . $brand['brandImg'])) {
                            unlink($img_path . $brand['brandImg']);
                        }
                        $brand_img = $file_name;
                    } else {
                        $errors[] = "Không thể tải lên hình ảnh.";
                    }
                } else {
                    $errors[] = "Định dạng file không hợp lệ (jpg, jpeg, png, gif).";
                }
            } else {
                $errors[] = "Hình ảnh vượt quá 3MB.";
            }
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh.";
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE brands SET brandName = ?, brandDescription = ?, brandImg = ? WHERE brandID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $brand_name, $brand_description, $brand_img, $brand_id);
        if ($stmt->execute()) {
            $success_message = "Thương hiệu đã được cập nhật thành công!";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: '$success_message',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'brands.php';
                        }
                    });
                });
            </script>";
        } else {
            $errors[] = "Không thể cập nhật thương hiệu. Vui lòng thử lại.";
        }
        $stmt->close();
    }
}

// Hiển thị lỗi nếu có
if (!empty($errors)) {
    $error_message = implode('<br>', $errors);
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Cập nhật thương hiệu thất bại',
                html: '$error_message',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Thương Hiệu</title>
    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>
<body class="crm_body_bg">
    <?php include 'includes/sidebar.php'; ?>
    <section class="main_content dashboard_part">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Chỉnh Sửa Thương Hiệu</h2>
            <?php if ($brand): ?>
                <form action="" method="POST" class="p-4 border rounded shadow" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="brand_name" class="form-label">Tên Thương Hiệu:</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" value="<?php echo htmlspecialchars($brand['brandName']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand_description" class="form-label">Mô Tả:</label>
                        <textarea class="form-control" id="brand_description" name="brand_description" rows="6"><?php echo htmlspecialchars($brand['brandDescription']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="brand_img" class="form-label">Hình Ảnh Thương Hiệu:</label>
                        <input type="file" class="form-control" id="brand_img" name="brand_img" accept="image/*">
                        <?php if (!empty($brand['brandImg'])): ?>
                            <img src="<?php echo htmlspecialchars($img_path . $brand['brandImg']); ?>" alt="Hình ảnh thương hiệu" style="width:150px;height:150px;margin-top:10px;">
                        <?php endif; ?>
                        <small class="text-muted">Nếu không chọn ảnh mới, ảnh cũ sẽ được giữ nguyên.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_brand">Cập Nhật</button>
                    <a href="./brands.php" class="btn btn-secondary">Danh Sách Thương Hiệu</a>
                </form>
                <script>
                    ClassicEditor.create(document.querySelector('#brand_description'), {
                        toolbar: ['heading', '|','bold','italic','link','bulletedList','numberedList','blockQuote','insertTable','undo','redo']
                    }).catch(error => { console.error(error); });
                </script>
            <?php endif; ?>
        </div>
    </section>
    <script src="js/jquery1-3.4.1.min.js"></script>
    <script src="js/bootstrap1.min.js"></script>
</body>
</html>
