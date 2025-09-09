<?php
include '../config/db_connection.php';

$success_message = "";
$errors = [];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?msg=error&reason=invalid_id");
    exit();
}

$user_id = $_GET['id'];

// Lấy thông tin nhân viên
$sql = "SELECT id, username, email, full_name FROM users WHERE id = ? AND role = 'Employee'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?msg=error&reason=not_found");
    exit();
}

$employee = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_employee'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);

    // Validate input
    if (empty($username) || empty($email) || empty($full_name)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    } else {
        // Kiểm tra username đã tồn tại chưa (khác với bản thân nhân viên)
        $check_sql = "SELECT id FROM users WHERE username = ? AND id != ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param('si', $username, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Tên đăng nhập đã tồn tại.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $update_fields = "email = ?, full_name = ?, updated_at = CURRENT_TIMESTAMP";
        $params = array($email, $full_name, $user_id);
        $types = 'ssi';

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_fields .= ", password = ?";
            $params[] = $hashed_password;
            $types .= 's';
        } else {
            $update_fields .= ", password = (SELECT password FROM users WHERE id = ?)";
            $params[] = $user_id;
            $types .= 'i';
        }

        $sql = "UPDATE users SET $update_fields WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $success_message = "Cập nhật thông tin nhân viên thành công!";
        } else {
            $errors[] = "Lỗi khi cập nhật: " . $conn->error;
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
    <title>Chỉnh Sửa Nhân Viên</title>
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="../css/style1.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="crm_body_bg">
    <?php
    $currentPage = "employee";
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
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3>Chỉnh Sửa Nhân Viên</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="../index.php">Dashboard</a> <i class="fas fa-caret-right"></i> Chỉnh Sửa Nhân Viên</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="QA_section">
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
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <form method="POST" class="p-4 border rounded shadow">
                                        <input type="hidden" name="user_id" value="<?php echo $employee['id']; ?>">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Tên Đăng Nhập</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($employee['username']); ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Mật Khẩu (Để trống nếu không thay đổi)</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="full_name" class="form-label">Họ và Tên</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
                                        </div>
                                        <button type="submit" name="update_employee" class="btn btn-primary">Cập Nhật</button>
                                        <a href="index.php" class="btn btn-secondary">Quay Lại</a>
                                    </form>
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
    <script src="../js/custom.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');
            const reason = urlParams.get('reason');
            if (msg) {
                switch (msg) {
                    case 'updated':
                        Swal.fire('Thành công!', 'Thông tin nhân viên đã được cập nhật.', 'success');
                        break;
                    case 'error':
                        if (reason === 'invalid_id') {
                            Swal.fire('Lỗi!', 'ID không hợp lệ.', 'error');
                        } else if (reason === 'not_found') {
                            Swal.fire('Lỗi!', 'Nhân viên không tồn tại.', 'error');
                        } else {
                            Swal.fire('Lỗi!', 'Đã xảy ra lỗi. Vui lòng thử lại.', 'error');
                        }
                        break;
                }
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>

</html>