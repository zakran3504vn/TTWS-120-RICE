<?php
include '../config/db_connection.php';

// Number of records per page
$records_per_page = 5;

// Determine the current page (default to page 1 if not set)
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the OFFSET value
$offset = ($current_page - 1) * $records_per_page;

// Check for search keyword
$search_keyword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search_keyword'])) {
    $search_keyword = trim($_POST['search_keyword']);
}

// Get the total number of records for pending bills
if (!empty($search_keyword)) {
    $total_records_sql = "SELECT COUNT(*) AS total FROM billing WHERE bill_des LIKE ? OR user_bank_number LIKE ? AND status = 0";
    $stmt = $conn->prepare($total_records_sql);
    $search_param = '%' . $search_keyword . '%';
    $stmt->bind_param('ss', $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_records = $result->fetch_assoc()['total'];
    $stmt->close();

    $sql = "SELECT b.*, u.username FROM billing b LEFT JOIN users u ON b.user_id = u.id WHERE b.bill_des LIKE ? OR b.user_bank_number LIKE ? AND b.status = 0 LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssii', $search_param, $search_param, $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $total_records_sql = "SELECT COUNT(*) AS total FROM billing WHERE status = 0";
    $result = $conn->query($total_records_sql);
    $total_records = $result->fetch_assoc()['total'];

    $sql = "SELECT b.*, u.username FROM billing b LEFT JOIN users u ON b.user_id = u.id WHERE b.status = 0 LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
}

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Xử lý duyệt/từ chối đơn
if (isset($_GET['action']) && isset($_GET['id']) && in_array($_GET['action'], ['approve', 'reject'])) {
    $bill_id = $_GET['id'];
    $action = $_GET['action'];

    $conn->begin_transaction();

    try {
        $sql = "SELECT user_id, bill_amount, bill_des FROM billing WHERE bill_id = ? AND status = 0 FOR UPDATE";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bill_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bill = $result->fetch_assoc();
        $stmt->close();

        if ($bill) {
            $user_id = $bill['user_id'];
            $amount = $bill['bill_amount'];
            $is_deposit = strpos($bill['bill_des'], 'NapTien') === 0;

            if ($action === 'approve' && $is_deposit) {
                $sql = "UPDATE wallet SET balance = balance + ? WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $amount, $user_id);
                $stmt->execute();
                $affected_rows = $stmt->affected_rows;
                $stmt->close();
            } elseif ($action === 'approve' && !$is_deposit) {
                $sql = "UPDATE wallet SET balance = balance - ? WHERE user_id = ? AND balance >= ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $amount, $user_id, $amount);
                $stmt->execute();
                $affected_rows = $stmt->affected_rows;
                $stmt->close();

                if ($affected_rows == 0) {
                    $conn->rollback();
                    header("Location: index.php?msg=error&reason=insufficient_balance");
                    exit();
                }
            }

            $new_status = ($action === 'approve') ? 1 : 2;
            $sql = "UPDATE billing SET status = ? WHERE bill_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $new_status, $bill_id);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            header("Location: index.php?msg=" . ($action === 'approve' ? 'approved' : 'rejected'));
            exit();
        } else {
            $conn->rollback();
            header("Location: index.php?msg=error&reason=already_processed");
            exit();
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: index.php?msg=error&reason=transaction_failed");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quản Lý Đơn Nạp/Rút Tiền</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style1.css" />
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
            max-width: 1600px;
            margin: 0 auto;
        }

        .QA_table {
            margin-bottom: 30px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .pagination {
            margin-top: 20px;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-link {
            color: #007bff;
        }

        .page-link:hover {
            color: #0056b3;
        }

        .table thead th {
            background-color: #1162fd;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        .status-pending {
            color: #ff9800;
            font-weight: 500;
            padding: 2px 8px;
            background-color: #fff3e0;
            border-radius: 10px;
            display: inline-block;
        }

        .status-approved {
            color: #27ae60;
            font-weight: 500;
            padding: 2px 8px;
            background-color: #e8f5e9;
            border-radius: 10px;
            display: inline-block;
        }

        .status-rejected {
            color: #e74c3c;
            font-weight: 500;
            padding: 2px 8px;
            background-color: #f9ebea;
            border-radius: 10px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .QA_section {
                max-width: 90%;
            }

            .table th,
            .table td {
                font-size: 12px;
                padding: 8px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body class="crm_body_bg">
    <!-- Sidebar -->
    <?php
    $currentPage = 'billing';
    include '../src/include/sidebar.php';
    ?>
    <section class="main_content dashboard_part">
        <!-- Menu -->
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
                                        <a href="../logout">Đăng Xuất</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Menu -->
        <div class="main_content_iner">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3>Quản Lý Đơn Nạp/Rút Tiền</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="../index.php">Dashboard</a> <i class="fas fa-caret-right"></i> Đơn Nạp/Rút</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="QA_section" style="margin-top:100px">
                            <div class="white_box_tittle list_header">
                                <div class="box_right d-flex lms_block">
                                    <div class="serach_field_2">
                                        <div class="search_inner">
                                            <form action="" method="POST">
                                                <div class="search_field">
                                                    <input type="text" name="search_keyword" placeholder="Tìm kiếm nội dung hoặc số tài khoản..." value="<?php echo isset($_POST['search_keyword']) ? $_POST['search_keyword'] : ''; ?>">
                                                </div>
                                                <button type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Nút hiển thị popup đơn đã duyệt -->
                                    <div class="add_button ms-2">
                                        <button type="button" class="btn_1" id="viewApprovedBills">Xem Đơn Đã Duyệt</button>
                                        <button type="button" class="btn_1 ms-2" id="viewRejectedBills">Xem Đơn Đã Từ Chối</button>
                                    </div>
                                </div>
                            </div>
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên Người Dùng</th>
                                                <th scope="col">Loại Giao Dịch</th>
                                                <th scope="col">Số Tiền</th>
                                                <th scope="col">Trạng Thái</th>
                                                <th scope="col">Ngày Tạo</th>
                                                <th scope="col">Ngân Hàng Người Dùng</th>
                                                <th scope="col">Số Tài Khoản</th>
                                                <th scope="col">Chủ Tài Khoản</th>
                                                <th scope="col">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pendingBillsTable">
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $stt = $offset + 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $transaction_type = strpos($row['bill_des'], 'NapTien') === 0 ? 'Nạp Tiền' : 'Rút Tiền';
                                                    echo "<tr>";
                                                    echo "<td>" . $stt . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['username'] ?? 'N/A') . "</td>";
                                                    echo "<td>" . $transaction_type . "</td>";
                                                    echo "<td>" . number_format($row['bill_amount'], 0, ',', '.') . " VND</td>";
                                                    echo "<td><span class='" . ($row['status'] ? 'status-approved' : 'status-pending') . "'>";
                                                    echo $row['status'] ? 'Đã duyệt' : 'Chờ duyệt';
                                                    echo "</span></td>";
                                                    echo "<td>" . date('d/m/Y H:i', strtotime($row['create_at'])) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['user_bank_name'] ?? 'N/A') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['user_bank_number'] ?? 'N/A') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['user_account_holder'] ?? 'N/A') . "</td>";
                                                    echo "<td>";
                                                    if (!$row['status']) {
                                                        echo "<a href='?action=approve&id=" . urlencode($row['bill_id']) . "' class='btn btn-primary btn-sm me-1'>";
                                                        echo "<i class='fa-solid fa-square-check'></i> Duyệt</a>";
                                                        echo "<a href='?action=reject&id=" . urlencode($row['bill_id']) . "' class='btn btn-danger btn-sm ms-1'>";
                                                        echo "<i class='fa-solid fa-ban'></i> Từ Chối</a>";
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='10' class='text-center'>Không có đơn nào.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Phân Trang -->
                            <div class="pagination">
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <?php if ($current_page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&search_keyword=<?php echo urlencode($search_keyword); ?>">« Trước</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                                            <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $page; ?>&search_keyword=<?php echo urlencode($search_keyword); ?>"><?php echo $page; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($current_page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&search_keyword=<?php echo urlencode($search_keyword); ?>">Sau »</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popup cho đơn đã duyệt -->
    <div class="modal fade" id="approvedBillsModal" tabindex="-1" aria-labelledby="approvedBillsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvedBillsModalLabel">Danh Sách Đơn Đã Duyệt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên Người Dùng</th>
                                    <th scope="col">Loại Giao Dịch</th>
                                    <th scope="col">Số Tiền</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Ngày Tạo</th>
                                    <th scope="col">Ngân Hàng Người Dùng</th>
                                    <th scope="col">Số Tài Khoản</th>
                                    <th scope="col">Chủ Tài Khoản</th>
                                </tr>
                            </thead>
                            <tbody id="approvedBillsTable">
                                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup cho đơn đã từ chối -->
    <div class="modal fade" id="rejectedBillsModal" tabindex="-1" aria-labelledby="rejectedBillsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectedBillsModalLabel">Danh Sách Đơn Đã Từ Chối</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên Người Dùng</th>
                                    <th scope="col">Loại Giao Dịch</th>
                                    <th scope="col">Số Tiền</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Ngày Tạo</th>
                                    <th scope="col">Ngân Hàng Người Dùng</th>
                                    <th scope="col">Số Tài Khoản</th>
                                    <th scope="col">Chủ Tài Khoản</th>
                                </tr>
                            </thead>
                            <tbody id="rejectedBillsTable">
                                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- footer  -->
    <!-- jquery slim -->
    <script src="../js/jquery1-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="../js/popper1.min.js"></script>
    <!-- bootstarp js -->
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
    <!-- sweet alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Lấy tham số từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const msg = urlParams.get('msg');
        const reason = urlParams.get('reason');

        // Hiển thị SweetAlert2 dựa trên giá trị của msg
        if (msg) {
            switch (msg) {
                case 'approved':
                    Swal.fire({
                        icon: 'success',
                        title: 'Duyệt thành công!',
                        text: 'Đơn đã được duyệt và số dư đã cập nhật.',
                        confirmButtonText: 'OK'
                    });
                    break;
                case 'rejected':
                    Swal.fire({
                        icon: 'success',
                        title: 'Từ chối thành công!',
                        text: 'Đơn đã bị từ chối.',
                        confirmButtonText: 'OK'
                    });
                    break;
                case 'error':
                    if (reason === 'insufficient_balance') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Số dư không đủ để thực hiện giao dịch rút tiền.',
                            confirmButtonText: 'Đóng'
                        });
                    } else if (reason === 'already_processed') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Đơn này đã được xử lý.',
                            confirmButtonText: 'Đóng'
                        });
                    } else if (reason === 'transaction_failed') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Giao dịch thất bại. Vui lòng thử lại.',
                            confirmButtonText: 'Đóng'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra.',
                            confirmButtonText: 'Đóng'
                        });
                    }
                    break;
                default:
                    console.error('Tham số msg không hợp lệ:', msg);
            }

            // Xóa tham số khỏi URL sau khi hiển thị thông báo
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        }

        // Xử lý hiển thị popup đơn đã duyệt
        document.addEventListener('DOMContentLoaded', () => {
            const viewApprovedBillsBtn = document.getElementById('viewApprovedBills');
            const approvedBillsModal = new bootstrap.Modal(document.getElementById('approvedBillsModal'));
            const approvedBillsTable = document.getElementById('approvedBillsTable');

            viewApprovedBillsBtn.addEventListener('click', () => {
                fetch('get_approved_bills.php')
                    .then(response => response.json())
                    .then(data => {
                        approvedBillsTable.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach((row, index) => {
                                const transaction_type = row.bill_des.startsWith('NapTien') ? 'Nạp Tiền' : 'Rút Tiền';
                                const rowHtml = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${row.username ?? 'N/A'}</td>
                                        <td>${transaction_type}</td>
                                        <td>${parseFloat(row.bill_amount).toLocaleString('vi-VN')} VND</td>
                                        <td><span class="status-approved">Đã duyệt</span></td>
                                        <td>${new Date(row.create_at).toLocaleString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                                        <td>${row.user_bank_name ?? 'N/A'}</td>
                                        <td>${row.user_bank_number ?? 'N/A'}</td>
                                        <td>${row.user_account_holder ?? 'N/A'}</td>
                                    </tr>
                                `;
                                approvedBillsTable.innerHTML += rowHtml;
                            });
                        } else {
                            approvedBillsTable.innerHTML = '<tr><td colspan="9" class="text-center">Không có đơn nào đã duyệt.</td></tr>';
                        }
                        approvedBillsModal.show();
                    })
                    .catch(error => console.error('Error fetching approved bills:', error));
            });

            // Xử lý hiển thị popup đơn đã từ chối
            const viewRejectedBillsBtn = document.getElementById('viewRejectedBills');
            const rejectedBillsModal = new bootstrap.Modal(document.getElementById('rejectedBillsModal'));
            const rejectedBillsTable = document.getElementById('rejectedBillsTable');

            viewRejectedBillsBtn.addEventListener('click', () => {
                fetch('get_rejected_bills.php')
                    .then(response => response.json())
                    .then(data => {
                        rejectedBillsTable.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach((row, index) => {
                                const transaction_type = row.bill_des.startsWith('NapTien') ? 'Nạp Tiền' : 'Rút Tiền';
                                const rowHtml = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${row.username ?? 'N/A'}</td>
                                        <td>${transaction_type}</td>
                                        <td>${parseFloat(row.bill_amount).toLocaleString('vi-VN')} VND</td>
                                        <td><span class="status-rejected">Đã từ chối</span></td>
                                        <td>${new Date(row.create_at).toLocaleString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</td>
                                        <td>${row.user_bank_name ?? 'N/A'}</td>
                                        <td>${row.user_bank_number ?? 'N/A'}</td>
                                        <td>${row.user_account_holder ?? 'N/A'}</td>
                                    </tr>
                                `;
                                rejectedBillsTable.innerHTML += rowHtml;
                            });
                        } else {
                            rejectedBillsTable.innerHTML = '<tr><td colspan="9" class="text-center">Không có đơn nào đã từ chối.</td></tr>';
                        }
                        rejectedBillsModal.show();
                    })
                    .catch(error => console.error('Error fetching rejected bills:', error));
            });
        });
    </script>
</body>

</html>