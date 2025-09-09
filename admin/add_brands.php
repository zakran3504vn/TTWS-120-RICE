<?php
include './config/db_connection.php';

// Kiểm tra session user
if (isset($_SESSION['username'])) {
    $img_path = '../admin/assets/img/' . $_SESSION['username'] . '/brands/';
} else {
    $img_path = '../admin/assets/img/brands/';
}

$success_message = "";
$errors = [];

// Xử lý form khi người dùng submit
if (isset($_POST['create_brand'])) {
    $brand_name = trim($_POST['brand_name']);
    $brand_description = trim($_POST['brand_description']);

    // Kiểm tra dữ liệu
    if (empty($brand_name)) {
        $errors[] = "Tên thương hiệu không được để trống.";
    }

    // Kiểm tra trùng tên
    $checkBrand = "SELECT COUNT(*) AS count FROM brands WHERE brandName = ?";
    $stmt = $conn->prepare($checkBrand);
    $stmt->bind_param("s", $brand_name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $errors[] = "Thương hiệu này đã tồn tại.";
    }

    // Upload hình ảnh brand
    $brand_img = "";
    if (!empty($_FILES['brand_img']['name'])) {
        $tmp_name = $_FILES['brand_img']['tmp_name'];
        $size = $_FILES['brand_img']['size'];
        $error = $_FILES['brand_img']['error'];
        $name = $_FILES['brand_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= 3 * 1024 * 1024) {
                $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($file_ext, $allowed_exts)) {
                    $file_name = uniqid() . '.' . $file_ext;
                    $file_dest = $img_path . $file_name;

                    if (!is_dir($img_path)) {
                        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
                            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
                        }
                    }

                    if (move_uploaded_file($tmp_name, $file_dest)) {
                        $brand_img = $file_name;
                    } else {
                        $errors[] = "Không thể tải lên hình ảnh.";
                    }
                } else {
                    $errors[] = "Định dạng file không hợp lệ. Chỉ hỗ trợ jpg, jpeg, png, gif.";
                }
            } else {
                $errors[] = "Hình ảnh vượt quá 3MB.";
            }
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh.";
        }
    }

    // Thêm brand vào DB nếu không có lỗi
    if (empty($errors)) {
        $sql = "INSERT INTO brands (brandName, brandDescription, brandImg) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $brand_name, $brand_description, $brand_img);

        if ($stmt->execute()) {
            $success_message = "Thương hiệu mới đã được thêm thành công!";
        } else {
            $errors[] = "Không thể thêm thương hiệu. Vui lòng thử lại.";
        }
        $stmt->close();
    }
}

// Hiển thị lỗi bằng SweetAlert2
if (!empty($errors)) {
    $error_message = implode('<br>', $errors);
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Thêm thương hiệu thất bại',
                html: '$error_message',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

// Hiển thị thành công
if (!empty($success_message)) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '$success_message',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?current_page=brands';
                }
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
    <title>Thêm Thương Hiệu</title>
    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>

<body class="crm_body_bg">
    <?php include 'includes/sidebar.php'; ?>

    <section class="main_content dashboard_part">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Thêm Thương Hiệu</h2>
            <form method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow">
                <div class="mb-3">
                    <label for="brand_name" class="form-label">Tên Thương Hiệu:</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name" required>
                </div>
                <div class="mb-3">
                    <label for="brand_description" class="form-label">Mô Tả:</label>
                    <textarea class="form-control" id="brand_description" name="brand_description" rows="6">Nhập mô tả</textarea>
                </div>
                <div class="mb-3">
                    <label for="brand_img" class="form-label">Hình Ảnh:</label>
                    <input type="file" class="form-control" id="brand_img" name="brand_img" accept="image/*">
                    <small class="text-muted">Hình ảnh thương hiệu (không bắt buộc).</small>
                </div>
                <button type="submit" class="btn btn-primary" name="create_brand">Thêm</button>
                <a href="index.php?current_page=brands" class="btn btn-secondary">Danh Sách Thương Hiệu</a>
            </form>

            <script>
                ClassicEditor
                    .create(document.querySelector('#brand_description'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script>
        </div>
    </section>

    <script src="js/jquery1-3.4.1.min.js"></script>
    <script src="js/bootstrap1.min.js"></script>
</body>

</html>
