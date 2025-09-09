<?php
include '../config/db_connection.php';

$success_message = "";
$errors = [];

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $sql = "SELECT id, username, email, full_name, password, user_bank_name, user_bank_number, user_account_holder FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $errors[] = "Không tìm thấy người dùng.";
    }
} else {
    $errors[] = "ID người dùng không hợp lệ.";
}

if (isset($_POST['update_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $user_bank_name = trim($_POST['user_bank_name']);
    $user_bank_number = trim($_POST['user_bank_number']);
    $user_account_holder = trim($_POST['user_account_holder']);

    if (empty($username) || empty($email) || empty($full_name)) {
        $errors[] = "Vui lòng điền đầy đủ các trường bắt buộc.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    } else {
        $sql = "UPDATE users SET username = ?, email = ?, full_name = ?, user_bank_name = ?, user_bank_number = ?, user_account_holder = ?";
        $params = [$username, $email, $full_name, $user_bank_name, $user_bank_number, $user_account_holder];
        $types = "ssiss";

        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }

        $sql .= " WHERE id = ?";
        $params[] = $user_id;
        $types .= "i";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $success_message = "Thông tin người dùng đã được cập nhật thành công!";
        } else {
            $errors[] = "Không thể cập nhật thông tin. Vui lòng thử lại. Lỗi: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Chỉnh Sửa Người Dùng</title>
    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="../css/style1.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .modal-dialog {
            max-width: 800px;
        }
    </style>
</head>

<body class="crm_body_bg">
    <?php
    $currentPage = 'user';
    include('../src/include/sidebar.php');
    ?>
    <section class="main_content dashboard_part">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="profile_info">
                                <img src="../img/client_img-1.png" alt="#">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name">
                                        <p>Xin Chào</p>
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
        <div class="main_content_iner">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="QA_section">
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <div class="container mt-5">
                                        <h2 class="text-center mb-4">Chỉnh Sửa Người Dùng</h2>
                                        <?php if (!empty($errors)): ?>
                                            <div class="alert alert-danger">
                                                <?php echo implode('<br>', $errors); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($success_message)): ?>
                                            <div class="alert alert-success">
                                                <?php echo $success_message; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($user): ?>
                                            <form action="" method="POST" class="p-4 border rounded shadow">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username:</label>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="full_name" class="form-label">Họ Tên:</label>
                                                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Mật khẩu (để trống nếu không đổi):</label>
                                                    <input type="password" class="form-control" id="password" name="password">
                                                    <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="user_bank_name" class="form-label">Tên Ngân Hàng:</label>
                                                    <input type="text" class="form-control" id="user_bank_name" name="user_bank_name" value="<?php echo htmlspecialchars($user['user_bank_name'] ?? ''); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="user_bank_number" class="form-label">Số Tài Khoản Ngân Hàng:</label>
                                                    <input type="text" class="form-control" id="user_bank_number" name="user_bank_number" value="<?php echo htmlspecialchars($user['user_bank_number'] ?? ''); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="user_account_holder" class="form-label">Chủ Tài Khoản:</label>
                                                    <input type="text" class="form-control" id="user_account_holder" name="user_account_holder" value="<?php echo htmlspecialchars($user['user_account_holder'] ?? ''); ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="update_user">Cập Nhật</button>
                                                <a href="index.php" class="btn btn-secondary">Danh Sách Người Dùng</a>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/jquery1-3.4.1.min.js"></script>
    <script src="../js/popper1.min.js"></script>
    <script src="../js/bootstrap1.min.js"></script>
    <script src="../js/metisMenu.js"></script>
    <script src="../vendors/count_up/jquery.waypoints.min.js"></script>
    <script src="../vendors/chartlist/Chart.min.js"></script>
    <script src="../vendors/count_up/jquery.counterup.min.js"></script>
    <script src="../vendors/swiper_slider/js/swiper.min.js"></script>
    <script src="../vendors/niceselect/js/jquery.nice-select.min.js"></script>
    <script src="../vendors/owl_carousel/js/owl.carousel.js"></script>
    <script src="../vendors/gijgo/gijgo.min.js"></script>
    <script src="../vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatable/js/jszip.min.js"></script>
    <script src="../vendors/datatable/js/pdfmake.min.js"></script>
    <script src="../vendors/datatable/js/vfs_fonts.js"></script>
    <script src="../vendors/datatable/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatable/js/buttons.print.min.js"></script>
    <script src="../vendors/progressbar/jquery.barfiller.js"></script>
    <script src="../vendors/tagsinput/tagsinput.js"></script>
    <script src="../vendors/text_editor/summernote-bs4.js"></script>
    <script src="../vendors/apex_chart/apexcharts.js"></script>
    <script src="../js/custom.js"></script>
</body>

</html>