<?php
include '../config/db_connection.php';

$img_path = '../../assets/img/';
$success_message = ""; // Biến để hiển thị thông báo thành công
$errors = []; // Biến lưu lỗi

// Kiểm tra nếu ID tài khoản được truyền qua URL và ID là một số hợp lệ
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bank_id = $_GET['id'];

    // Lấy thông tin tài khoản từ database
    $sql = "SELECT bank_id, bankName, bankNumber, accountHolder, status, create_at FROM banking WHERE bank_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bank = $result->fetch_assoc();
    } else {
        echo "Tài khoản ngân hàng không tồn tại!";
        exit();
    }
} else {
    echo "ID tài khoản không hợp lệ!";
    exit();
}

// Xử lý khi người dùng nhấn nút cập nhật
if (isset($_POST['update_bank'])) {
    // Nhận giá trị từ form
    $bank_name = $_POST['bank_name'];
    $bank_number = $_POST['bank_number'];
    $account_holder = $_POST['account_holder'];
    $status = isset($_POST['status']) ? 1 : 0;

    // Kiểm tra dữ liệu
    if (empty($bank_name) || empty($bank_number) || empty($account_holder)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin!";
    }

    if (empty($errors)) {
        $sql = "UPDATE banking SET bankName = ?, bankNumber = ?, accountHolder = ?, status = ? WHERE bank_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $bank_name, $bank_number, $account_holder, $status, $bank_id);

        if ($stmt->execute()) {
            $success_message = "Tài khoản ngân hàng đã được cập nhật thành công!";
        } else {
            $errors[] = "Cập nhật thất bại. Vui lòng thử lại!";
        }
        $stmt->close();
    }
}

// Hiển thị thông báo lỗi nếu có
if (!empty($errors)) {
    $error_message = implode('<br>', $errors);
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Cập nhật thất bại',
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
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Chỉnh Sửa Tài Khoản Ngân Hàng</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style1.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 28px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .main_content_iner {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 20px;
        }

        .container-fluid {
            width: 100%;
            padding: 0 15px;
        }

        .QA_section {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .QA_table {
            margin-bottom: 30px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .small {
            color: #666;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 5px;
            border: 1px solid #ddd;
            height: 38px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }

        .select2-results__option img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            vertical-align: middle;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            .btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body class="crm_body_bg">
    <!-- Sidebar -->
    <?php
    $currentPage = 'banking';
    include '../src/include/sidebar.php';
    ?>
    <section class="main_content dashboard_part">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area">
                            <div class="search_inner"></div>
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
                                        <a href="../logout">Đăng Xuất</a>
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
                                        <h2 class="text-center mb-4">Cập nhật tài khoản ngân hàng</h2>
                                        <div class="form-container">
                                            <form action="" method="POST" class="p-4 border rounded shadow">
                                                <input type="hidden" name="bank_id" value="<?php echo $bank['bank_id']; ?>">

                                                <div class="mb-3">
                                                    <label for="bank_name" class="form-label">Tên Ngân Hàng:</label>
                                                    <select id="bank_name" name="bank_name" class="form-control" required>
                                                        <option value="">Chọn ngân hàng</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="bank_number" class="form-label">Số Tài Khoản:</label>
                                                    <input type="text" id="bank_number" name="bank_number" class="form-control" value="<?php echo htmlspecialchars($bank['bankNumber']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="account_holder" class="form-label">Chủ Tài Khoản:</label>
                                                    <input type="text" id="account_holder" name="account_holder" class="form-control" value="<?php echo htmlspecialchars($bank['accountHolder']); ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Trạng Thái:</label>
                                                    <label class="switch">
                                                        <input type="checkbox" id="status" name="status" <?php echo $bank['status'] ? 'checked' : ''; ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <small class="text-muted">Bật để kích hoạt tài khoản.</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="create_at" class="form-label">Ngày Tạo:</label>
                                                    <input type="text" id="create_at" name="create_at" class="form-control" value="<?php echo htmlspecialchars($bank['create_at']); ?>" readonly>
                                                </div>

                                                <button type="submit" class="btn btn-primary" name="update_bank">Cập nhật tài khoản</button>
                                                <a href="index.php" class="btn btn-secondary">Danh Sách Tài Khoản</a>
                                            </form>
                                        </div>
                                    </div>
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
    <!-- popper js -->
    <script src="../js/popper1.min.js"></script>
    <!-- bootstrap js -->
    <script src="../js/bootstrap1.min.js"></script>
    <!-- sidebar menu  -->
    <script src="../js/metisMenu.js"></script>
    <!-- waypoints js -->
    <script src="../vendors/count_up/jquery.waypoints.min.js"></script>
    <!-- waypoints js -->
    <script src="../vendors/chartlist/Chart.min.js"></script>
    <!-- counterup js -->
    <script src="../vendors/count_up/jquery.counterup.min.js"></script>
    <!-- swiper slider js -->
    <script src="../vendors/swiper_slider/js/swiper.min.js"></script>
    <!-- nice select -->
    <script src="../vendors/niceselect/js/jquery.nice-select.min.js"></script>
    <!-- owl carousel -->
    <script src="../vendors/owl_carousel/js/owl.carousel.min.js"></script>
    <!-- gijgo css -->
    <script src="../vendors/gijgo/gijgo.min.js"></script>
    <!-- responsive table -->
    <script src="../vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatable/js/jszip.min.js"></script>
    <script src="../vendors/datatable/js/pdfmake.min.js"></script>
    <script src="../vendors/datatable/js/vfs_fonts.js"></script>
    <script src="../vendors/datatable/js/buttons.html5.min.js"></script>
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#bank_name').select2({
                placeholder: "Chọn ngân hàng",
                allowClear: true,
                templateResult: formatBank,
                templateSelection: formatBank,
                ajax: {
                    url: 'https://api.vietqr.io/v2/banks',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        if (data.code === "00" && data.data) {
                            return {
                                results: data.data.map(function(bank) {
                                    return {
                                        id: bank.code, // Use bank code as value
                                        text: bank.shortName,
                                        logo: bank.logo,
                                        name: bank.name
                                    };
                                })
                            };
                        }
                        return {
                            results: []
                        };
                    },
                    cache: true
                }
            });

            // Format the dropdown items
            function formatBank(bank) {
                if (!bank.id) {
                    return bank.text;
                }
                var $bank = $(
                    '<span><img src="' + bank.logo + '" class="img-flag" style="width: 24px; height: 24px; margin-right: 10px; vertical-align: middle;" /> ' + bank.name + '</span>'
                );
                return $bank;
            }

            // Pre-select the current bank
            var currentBankCode = '<?php echo htmlspecialchars($bank['bankName']); ?>';
            if (currentBankCode) {
                $.ajax({
                    url: 'https://api.vietqr.io/v2/banks',
                    dataType: 'json',
                    success: function(data) {
                        if (data.code === "00" && data.data) {
                            var selectedBank = data.data.find(function(bank) {
                                return bank.code === currentBankCode;
                            });
                            if (selectedBank) {
                                var option = new Option(
                                    selectedBank.name,
                                    selectedBank.code,
                                    true,
                                    true
                                );
                                $('#bank_name').append(option).trigger('change');

                                // Manually set the display with logo
                                $('#bank_name').select2('trigger', 'select', {
                                    data: {
                                        id: selectedBank.code,
                                        text: selectedBank.shortName,
                                        logo: selectedBank.logo,
                                        name: selectedBank.name
                                    }
                                });
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>