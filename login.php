<?php
require_once './config/db_connection.php';

// Xử lý khi người dùng gửi form đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Loại bỏ khoảng trắng thừa
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // Kiểm tra tùy chọn "Ghi nhớ thiết bị này"

    // Kiểm tra thông tin đăng nhập trong bảng users
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu trực tiếp
        if ($password === $user['password']) {
            // Đăng nhập thành công, lưu thông tin vào session
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['fullname'] = $user['full_name'];
            // Xử lý tùy chọn "Ghi nhớ thiết bị này"
            if ($remember) {
                setcookie("username", $username, time() + (30 * 24 * 60 * 60), "/"); // Cookie lưu 30 ngày
            }

            // Chuyển hướng dựa trên vai trò
            if ($user['role'] == 'Admin') {
                header("Location: admin/index.php");
            } else {
                // Nếu vai trò là Employee hoặc khác, có thể xử lý thêm
                $error = "Vai trò người dùng không được hỗ trợ để truy cập!";
                header("Location: login.php");
            }
            exit();
        } else {
            $error = "Tên đăng nhập hoặc mật khẩu không chính xác. Vui lòng kiểm tra lại!";
        }
    } else {
        $error = "Tên đăng nhập không tồn tại. Vui lòng kiểm tra lại!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Shop Walmart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #e6f0fa;
        }

        .illustration {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row items-center justify-center w-full max-w-4xl">
        <!-- Hình minh họa bên trái -->
        <div class="md:w-1/2 mb-8 md:mb-0">
            <img src="assets/images/login-security.svg" alt="Illustration" class="illustration">
        </div>

        <!-- Form đăng nhập bên phải -->
        <div class="md:w-1/2 bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-2 text-center">Welcome to Back</h1>
            <p class="text-gray-500 text-center mb-6">Powerd By Trường Thành Web</p>

            <!-- Hiển thị thông báo lỗi bằng SweetAlert2 -->
            <?php if (isset($error)): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi đăng nhập',
                            text: '<?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>',
                            confirmButtonText: 'Thử lại',
                            confirmButtonColor: '#3B82F6',
                            allowOutsideClick: false
                        });
                    });
                </script>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Tên đăng nhập</label>
                    <input type="text" name="username" value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" required class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Mật khẩu</label>
                    <input type="password" name="password" required class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="flex justify-between items-center mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="form-checkbox text-blue-500" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                        <span class="ml-2 text-gray-700">Ghi nhớ thiết bị này</span>
                    </label>
                    <a href="#" class="text-blue-500 hover:underline">Quên mật khẩu?</a>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Đăng nhập</button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-gray-700">Chưa có tài khoản? <a href="register.php" class="text-blue-500 hover:underline">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</body>

</html>