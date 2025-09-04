<!-- PHP -->
<?php
include './config/db_connection.php';

$img_path = './assets/img/' . $_SESSION['username'] . '/';
$success_message = "";
$errors = [];

// Check if category ID is provided in the URL
if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);

    // Retrieve category information from the database
    $sql = "SELECT * FROM category WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    if (!$category) {
        $errors[] = "Không tìm thấy danh mục.";
    }
} else {
    $errors[] = "ID danh mục không hợp lệ.";
}

// Handle form submission to update the category
if (isset($_POST['update_category'])) {
    $category_name = trim($_POST['category_name']);
    $category_description = trim($_POST['category_description']);

    // Validate input
    if (empty($category_name)) {
        $errors[] = "Tên danh mục không được để trống.";
    }

    // Handle category image upload
    $category_img = $category['categoryImg'];
    if (!empty($_FILES['category_img']['name'])) {
        $tmp_name = $_FILES['category_img']['tmp_name'];
        $size = $_FILES['category_img']['size'];
        $error = $_FILES['category_img']['error'];
        $name = $_FILES['category_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= 3 * 1024 * 1024) { // Check size <= 3MB
                $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($file_ext, $allowed_exts)) {
                    $file_name = uniqid() . '.' . $file_ext; // Generate unique file name
                    $file_dest = $img_path . $file_name;

                    // Create directory if it doesn't exist
                    if (!is_dir($img_path)) {
                        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
                            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
                        }
                    }

                    // Move file to destination folder
                    if (move_uploaded_file($tmp_name, $file_dest)) {
                        // Delete old image if it exists
                        if (!empty($category['categoryImg']) && file_exists($img_path . $category['categoryImg'])) {
                            unlink($img_path . $category['categoryImg']);
                        }
                        $category_img = $file_name; // Assign new file name for database storage
                    } else {
                        $errors[] = "Không thể tải lên hình ảnh.";
                    }
                } else {
                    $errors[] = "Định dạng file không được phép. Chỉ hỗ trợ jpg, jpeg, png, gif.";
                }
            } else {
                $errors[] = "Hình ảnh vượt quá kích thước cho phép (3MB).";
            }
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh.";
        }
    }

    // Update category information in the database
    if (empty($errors)) {
        $sql = "UPDATE category SET CategoryName = ?, description = ?, categoryImg = ? WHERE CategoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $category_name, $category_description, $category_img, $category_id);

        if ($stmt->execute()) {
            $success_message = "Danh mục đã được cập nhật thành công!";
            // Hiển thị thông báo thành công bằng SweetAlert2
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: '$success_message',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'category.php';
                        }
                    });
                });
            </script>";
        } else {
            $errors[] = "Không thể cập nhật danh mục. Vui lòng thử lại.";
        }

        $stmt->close();
    }
}

// Hiển thị thông báo lỗi bằng SweetAlert2 nếu có
if (!empty($errors)) {
    $error_message = implode('<br>', $errors);
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Cập nhật danh mục thất bại',
                html: '$error_message',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

$conn->close();
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Chỉnh Sửa Nhóm Sản Phẩm</title>

    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap1.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Sử dụng CKEditor 5 với plugin chèn ảnh -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .modal-dialog {
            max-width: 800px;
        }
    </style>
</head>

<body class="crm_body_bg">
    <!-- sidebar  -->
    <?php
    include 'includes/sidebar.php';
    ?>
    <!-- sidebar part end -->
    <!--/ sidebar  -->

    <section class="main_content dashboard_part">
        <!-- menu  -->
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area">
                            <div class="search_inner">
                            </div>
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="profile_info">
                                <img src="img/client_img-1.png" alt="#">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name">
                                        <p>Xin Chào </p>
                                        <h5><?php echo $_SESSION['fullname']; ?></h5>
                                    </div>
                                    <div class="profile_info_details">
                                        <a href="profile/index.php">Thông Tin Cá Nhân</a>
                                        <a href="#">Cài Đặt</a>
                                        <a href="logout.php">Đăng Xuất</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ menu  -->
        <div class="main_content_iner">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="QA_section">
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <div class="container mt-5">
                                        <h2 class="text-center mb-4">Chỉnh Sửa Nhóm Sản Phẩm</h2>
                                        <?php if ($category): ?>
                                            <form action="" method="POST" class="p-4 border rounded shadow" enctype="multipart/form-data">
                                                <div class="mb-3">
                                                    <label for="category_name" class="form-label">Nhóm Sản Phẩm:</label>
                                                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['CategoryName']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="category_description" class="form-label">Mô Tả:</label>
                                                    <textarea class="form-control" id="category_description" name="category_description" rows="6"><?php echo htmlspecialchars($category['description']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="category_img" class="form-label">Hình ảnh nhóm sản phẩm:</label>
                                                    <input type="file" class="form-control" id="category_img" name="category_img" accept="image/*">
                                                    <?php if (!empty($category['categoryImg'])): ?>
                                                        <img src="<?php echo htmlspecialchars($img_path . $category['categoryImg']); ?>" alt="Hình ảnh danh mục" style="width: 150px; height: 150px; margin-top: 10px;">
                                                    <?php endif; ?>
                                                    <small class="text-muted">Hình ảnh danh mục (nếu không chọn ảnh mới thì giữ nguyên ảnh cũ).</small>
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="update_category">Cập Nhật</button>
                                                <a href="./index.php?current_page=category" class="btn btn-secondary">Danh Sách Danh Mục</a>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#category_description'), {
                                                toolbar: [
                                                    'heading', '|',
                                                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|',
                                                    'imageUpload', 'mediaEmbed', '|',
                                                    'undo', 'redo'
                                                ],
                                                image: {
                                                    toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
                                                },
                                                ckfinder: {
                                                    uploadUrl: 'upload_image.php' // Đường dẫn đến file xử lý upload ảnh
                                                }
                                            })
                                            .then(editor => {
                                                console.log('Editor was initialized', editor);
                                            })
                                            .catch(error => {
                                                console.error('Error initializing editor:', error);
                                            });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- main content part end -->

    <!-- footer  -->
    <!-- jquery slim -->
    <script src="js/jquery1-3.4.1.min.js"></script>
    <script src="js/popper1.min.js"></script>
    <script src="js/bootstrap1.min.js"></script>
    <script src="js/metisMenu.js"></script>
    <script src="vendors/count_up/jquery.waypoints.min.js"></script>
    <script src="vendors/chartlist/Chart.min.js"></script>
    <script src="vendors/count_up/jquery.counterup.min.js"></script>
    <script src="vendors/swiper_slider/js/swiper.min.js"></script>
    <script src="vendors/niceselect/js/jquery.nice-select.min.js"></script>
    <script src="vendors/owl_carousel/js/owl.carousel.min.js"></script>
    <script src="vendors/gijgo/gijgo.min.js"></script>
    <script src="vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="vendors/datatable/js/jszip.min.js"></script>
    <script src="vendors/datatable/js/pdfmake.min.js"></script>
    <script src="vendors/datatable/js/vfs_fonts.js"></script>
    <script src="vendors/datatable/js/buttons.php5.min.js"></script>
    <script src="vendors/datatable/js/buttons.print.min.js"></script>
    <script src="js/chart.min.js"></script>
    <!-- progressbar js -->
    <script src="vendors/progressbar/jquery.barfiller.js"></script>
    <!-- tag input -->
    <script src="vendors/tagsinput/tagsinput.js"></script>
    <!-- text editor js -->
    <script src="vendors/text_editor/summernote-bs4.js"></script>
    <script src="vendors/apex_chart/apexcharts.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
</body>

</html>