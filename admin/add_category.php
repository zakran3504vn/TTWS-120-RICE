<?php
include './config/db_connection.php';

// Kiểm tra xem session có tồn tại không
if (isset($_SESSION['username'])) {
    $img_path = '../admin/assets/img/' . $_SESSION['username'];
} else {
    // Nếu chưa đăng nhập, gán mặc định hoặc chuyển hướng về login
    $img_path = '../admin/assets/img/';
    // header("Location: login.php");
    // exit();
}

$success_message = ""; // Biến để hiển thị thông báo thành công
$errors = []; // Mảng để lưu trữ lỗi


// Xử lý form khi người dùng gửi yêu cầu thêm danh mục
if (isset($_POST['create_category'])) {
    // Lấy giá trị từ form
    $category_name = trim($_POST['category_name']);
    $category_description = trim($_POST['category_description']);

    // Kiểm tra dữ liệu đầu vào
    if (empty($category_name)) {
        $errors[] = "Tên danh mục không được để trống.";
    }

    // Kiểm tra xem danh mục đã tồn tại chưa
    $checkCategory = "SELECT COUNT(*) AS count FROM category WHERE CategoryName = ?";
    $stmt = $conn->prepare($checkCategory);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $errors[] = "Danh mục này đã tồn tại.";
    }

    // Xử lý upload hình ảnh
    $category_img = "";
    if (!empty($_FILES['category_img']['name'])) {
        $tmp_name = $_FILES['category_img']['tmp_name'];
        $size = $_FILES['category_img']['size'];
        $error = $_FILES['category_img']['error'];
        $name = $_FILES['category_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= 3 * 1024 * 1024) { // Kiểm tra kích thước <= 3MB
                $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($file_ext, $allowed_exts)) {
                    $file_name = uniqid() . '.' . $file_ext; // Tạo tên file duy nhất
                    $file_dest = $img_path . $file_name;

                    // Tạo thư mục nếu chưa tồn tại
                    if (!is_dir($img_path)) {
                        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
                            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
                        }
                    }

                    // Di chuyển file vào thư mục đích
                    if (move_uploaded_file($tmp_name, $file_dest)) {
                        $category_img = $file_name; // Gán tên file để lưu vào cơ sở dữ liệu
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

    // Nếu không có lỗi, tiến hành thêm danh mục vào cơ sở dữ liệu
    if (empty($errors)) {
        $sql = "INSERT INTO category (CategoryName, description, CategoryImg) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $category_name, $category_description, $category_img);

        if ($stmt->execute()) {
            $success_message = "Danh mục mới đã được thêm thành công!";
        } else {
            $errors[] = "Không thể thêm danh mục. Vui lòng thử lại.";
        }

        $stmt->close();
    }
}

// Hiển thị thông báo lỗi nếu có
if (!empty($errors)) {
    $error_message = implode('<br>', $errors); // Gộp tất cả lỗi thành một chuỗi
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Thêm danh mục thất bại',
                html: '$error_message',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

// Hiển thị thông báo thành công nếu có
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
                    window.location.href = 'index.php';
                }
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
    <title>Thêm Nhóm Sản Phẩm</title>

    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap1.min.css" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css" />
    <!-- swiper slider CSS -->
    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css" />
    <!-- text editor css -->
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css" />
    <!-- morris css -->
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css" />

    <!-- menu css  -->
    <link rel="stylesheet" href="css/metisMenu.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <!-- font-awesome -->
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
    include 'includes/sidebar.php';
    ?>
    <!-- sidebar part end -->

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
                                        <h2 class="text-center mb-4">Thêm Nhóm Sản Phẩm</h2>
                                        <form method="POST" class="p-4 border rounded shadow" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="category_name" class="form-label">Tên Nhóm Sản Phẩm:</label>
                                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_description" class="form-label">Mô Tả:</label>
                                                <textarea class="form-control" id="category_description" name="category_description" rows="6">Nhập mô tả</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_img" class="form-label">Hình Ảnh:</label>
                                                <input type="file" class="form-control" id="category_img" name="category_img" accept="image/*">
                                                <small class="text-muted">Hình ảnh danh mục (không bắt buộc).</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="create_category">Thêm</button>
                                            <a href="./index.php?current_page=category" class="btn btn-secondary">Danh Sách Nhóm Sản Phẩm</a>
                                        </form>
                                    </div>
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#category_description'), {
                                                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
                                            })
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


    <!-- Scripts -->
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
    <script src="vendors/progressbar/jquery.barfiller.js"></script>
    <script src="vendors/tagsinput/tagsinput.js"></script>
    <script src="vendors/text_editor/summernote-bs4.js"></script>
    <script src="vendors/apex_chart/apexcharts.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>