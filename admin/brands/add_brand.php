<?php
include '../config/db_connection.php';

$img_path = '../../assets/img/';
$success_message = ""; // Variable to display success message
$errors = []; // Array to store errors

// Handle form submission to create a new brand
if (isset($_POST['create_brand'])) {
    // Retrieve form values
    $brand_name = $_POST['brand_name'];
    $brand_description = $_POST['brand_description'];

    // Create directory for image storage if it doesn't exist
    if (!is_dir($img_path)) {
        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
        }
    }

    // Handle brand image upload
    $brand_img = "";
    if (!empty($_FILES['brand_img']['name'])) {
        $tmp_name = $_FILES['brand_img']['tmp_name'];
        $size = $_FILES['brand_img']['size'];
        $error = $_FILES['brand_img']['error'];
        $name = $_FILES['brand_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= 3 * 1024 * 1024) { // Check size <= 3MB
                $file_ext = pathinfo($name, PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_ext; // Generate unique file name
                $file_dest = $img_path . $file_name;

                // Move file to destination folder
                if (move_uploaded_file($tmp_name, $file_dest)) {
                    $brand_img = $file_name; // Assign file name for database storage
                } else {
                    $errors[] = "Không thể tải lên hình ảnh.";
                }
            } else {
                $errors[] = "Hình ảnh vượt quá kích thước cho phép (3MB).";
            }
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh.";
        }
    }

    // Insert brand information into the database
    if (empty($errors)) {
        $sql = "INSERT INTO brands (brandName, brandDescription, brandImg, createdAt) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);

        // Bind parameters to the SQL statement
        $stmt->bind_param(
            "sss",
            $brand_name,          // string
            $brand_description,   // string
            $brand_img            // string
        );

        if ($stmt->execute()) {
            $success_message = "Thương hiệu mới đã được tạo thành công!";
        } else {
            $errors[] = "Không thể tạo thương hiệu. Vui lòng thử lại.";
        }

        $stmt->close();
    }
}

// Display error messages if any
if (!empty($errors)) {
    $error_message = implode('<br>', $errors); // Join all errors into a string
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Tạo thương hiệu thất bại',
                html: '$error_message',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

// Display success message if any
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
                    // Redirect to the brand list page or refresh the page
                    window.location.href = 'index.php'; // Replace with appropriate URL
                }
            });
        });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Thêm Thương Hiệu</title>

    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="../vendors/themefy_icon/themify-icons.css" />
    <!-- swiper slider CSS -->
    <link rel="stylesheet" href="../vendors/swiper_slider/css/swiper.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="../vendors/select2/css/select2.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="../vendors/niceselect/css/nice-select.css" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="../vendors/owl_carousel/css/owl.carousel.css" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="../vendors/gijgo/gijgo.min.css" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="../vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="../vendors/tagsinput/tagsinput.css" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="../vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="../vendors/datatable/css/buttons.dataTables.min.css" />
    <!-- text editor css -->
    <link rel="stylesheet" href="../vendors/text_editor/summernote-bs4.css" />
    <!-- morris css -->
    <link rel="stylesheet" href="../vendors/morris/morris.css">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="../vendors/material_icon/material-icons.css" />

    <!-- menu css  -->
    <link rel="stylesheet" href="../css/metisMenu.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="../css/style1.css" />
    <link rel="stylesheet" href="../css/colors/default.css" id="colorSkinCSS">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CKEDITOR -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <!-- font-awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .modal-dialog {
            max-width: 800px;
        }
    </style>
</head>
<body class="crm_body_bg">
 <!-- sidebar  -->
 <?php
 $currentPage = 'thuonghieu';
 include('../src/include/sidebar.php');
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
                            <img src="../img/client_img-1.png" alt="#">
                            <div class="profile_info_iner">
                                <div class="profile_author_name">
                                    <p>Xin Chào </p>
                                    <h5><?php echo $_SESSION['fullname']; ?></h5>
                                </div>
                                <div class="profile_info_details">
                                        <a href="../profile/index.php">Thông Tin Cá Nhân</a>
                                        <a href="#">Cài Đặt</a>
                                        <a href="../logout.php">Đăng Xuất</a>
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
                                    <h2 class="text-center mb-4">Thêm Thương Hiệu</h2>
                                    <form method="POST" class="p-4 border rounded shadow" enctype="multipart/form-data">
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
                                        <a href="index.php" class="btn btn-secondary">Danh Sách Thương Hiệu</a>
                                    </form>
                                </div>
                                <script>
                                    ClassicEditor
                                        .create(document.querySelector('#brand_description'))
                                        .catch(error => {
                                            console.error(error);
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
<script src="../js/jquery1-3.4.1.min.js"></script>
<script src="../js/popper1.min.js"></script>
<script src="../js/bootstrap1.min.js"></script>
<script src="../js/metisMenu.js"></script>
<script src="../vendors/count_up/jquery.waypoints.min.js"></script>
<script src="../vendors/chartlist/Chart.min.js"></script>
<script src="../vendors/count_up/jquery.counterup.min.js"></script>
<script src="../vendors/swiper_slider/js/swiper.min.js"></script>
<script src="../vendors/niceselect/js/jquery.nice-select.min.js"></script>
<script src="../vendors/owl_carousel/js/owl.carousel.min.js"></script>
<script src="../vendors/gijgo/gijgo.min.js"></script>
<script src="../vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatable/js/buttons.flash.min.js"></script>
<script src="../vendors/datatable/js/jszip.min.js"></script>
<script src="../vendors/datatable/js/pdfmake.min.js"></script>
<script src="../vendors/datatable/js/vfs_fonts.js"></script>
<script src="../vendors/datatable/js/buttons.php5.min.js"></script>
<script src="../vendors/datatable/js/buttons.print.min.js"></script>

<script src="../js/chart.min.js"></script>
<!-- progressbar js -->
<script src="../vendors/progressbar/jquery.barfiller.js"></script>
<!-- tag input -->
<script src="../vendors/tagsinput/tagsinput.js"></script>
<!-- text editor js -->
<script src="../vendors/text_editor/summernote-bs4.js"></script>

<script src="../vendors/apex_chart/apexcharts.js"></script>

<!-- custom js -->
<script src="../js/custom.js"></script>

</body>
</html>