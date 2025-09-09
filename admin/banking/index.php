<?php
include '../config/db_connection.php';
$img_path = '../../assets/img/';

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

// Get the total number of records
if (!empty($search_keyword)) {
    // If there is a search keyword
    $total_records_sql = "SELECT COUNT(*) AS total FROM banking WHERE bankName LIKE ? OR bankNumber LIKE ?";
    $stmt = $conn->prepare($total_records_sql);
    $search_param = '%' . $search_keyword . '%';
    $stmt->bind_param('ss', $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_records = $result->fetch_assoc()['total'];
    $stmt->close();

    // Query to fetch paginated data with search
    $sql = "SELECT bank_id, bankName, bankNumber, accountHolder, status, create_at FROM banking WHERE bankName LIKE ? OR bankNumber LIKE ? LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssii', $search_param, $search_param, $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    // If there is no search keyword
    $total_records_sql = "SELECT COUNT(*) AS total FROM banking";
    $result = $conn->query($total_records_sql);
    $total_records = $result->fetch_assoc()['total'];

    // Query to fetch paginated data
    $sql = "SELECT bank_id, bankName, bankNumber, accountHolder, status, create_at FROM banking LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
}

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Xử lý xóa tài khoản ngân hàng
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $bank_id = $_GET['id'];

    // Kiểm tra xem tài khoản có tồn tại không
    $checkBank = "SELECT COUNT(*) AS count FROM banking WHERE bank_id = ?";
    $stmt = $conn->prepare($checkBank);
    $stmt->bind_param("i", $bank_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Bắt đầu transaction để đảm bảo toàn vẹn dữ liệu
        $conn->begin_transaction();

        try {
            // Xóa các bản ghi liên quan trong bảng billing
            $deleteBilling = "DELETE FROM billing WHERE bank_id = ?";
            $stmtBilling = $conn->prepare($deleteBilling);
            $stmtBilling->bind_param("i", $bank_id);
            $stmtBilling->execute();
            $stmtBilling->close();

            // Xóa tài khoản trong bảng banking
            $deleteBank = "DELETE FROM banking WHERE bank_id = ?";
            $stmtBank = $conn->prepare($deleteBank);
            $stmtBank->bind_param("i", $bank_id);
            $stmtBank->execute();
            $stmtBank->close();

            // Commit transaction
            $conn->commit();
            header("Location: index.php?msg=deleted");
            exit();
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            header("Location: index.php?msg=error&reason=failed&error_message=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header("Location: index.php?msg=error&reason=not_found");
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
    <title>Quản Lý Tài Khoản Ngân Hàng</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style1.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
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
            transition: .4s;
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
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+..slider:before {
            transform: translateX(22px);
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

        .modal-xl {
            max-width: 80%;
        }

        .modal-content iframe {
            width: 100%;
            height: 600px;
            border: none;
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

        .status-active {
            color: #27ae60;
            font-weight: 500;
            padding: 2px 8px;
            background-color: #e8f5e9;
            border-radius: 10px;
            display: inline-block;
        }

        .status-inactive {
            color: #e74c3c;
            font-weight: 500;
            padding: 2px 8px;
            background-color: #fdecea;
            border-radius: 10px;
            display: inline-block;
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
        <!-- Menu -->
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0 ">
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
        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3>Quản Lý Tài Khoản Ngân Hàng</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="../index.php">Dashboard</a> <i class="fas fa-caret-right"></i> Tài Khoản Ngân Hàng</p>
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
                                                    <input type="text" name="search_keyword" placeholder="Tìm kiếm tên ngân hàng hoặc số tài khoản..." value="<?php echo isset($_POST['search_keyword']) ? $_POST['search_keyword'] : ''; ?>">
                                                </div>
                                                <button type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="add_button ms-2">
                                        <a href="add_bank.php" class="btn_1">THÊM TÀI KHOẢN NGÂN HÀNG</a>
                                    </div>
                                </div>
                            </div>
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên Ngân Hàng</th>
                                                <th scope="col">Số Tài Khoản</th>
                                                <th scope="col">Chủ Tài Khoản</th>
                                                <th scope="col">Trạng Thái</th>
                                                <th scope="col">Ngày Tạo</th>
                                                <th scope="col">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $stt = $offset + 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $stt . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['bankName']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['bankNumber']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['accountHolder']) . "</td>";
                                                    echo "<td>
                                                        <label class='switch'>
                                                            <input type='checkbox' class='toggleSwitch' data-id='" . $row['bank_id'] . "' " . ($row['status'] ? 'checked' : '') . ">
                                                            <span class='slider'></span>
                                                        </label>
                                                    </td>";
                                                    echo "<td>" . htmlspecialchars($row['create_at']) . "</td>";
                                                    echo "<td>
                                                        <a href='edit_bank.php?id=" . urlencode($row['bank_id']) . "' class='btn btn-primary text-white btn-sm'>
                                                            <i class='fa-solid fa-pen-to-square'></i>
                                                        </a>
                                                        <button class='btn btn-danger text-white btn-sm delete-btn' data-id='" . $row['bank_id'] . "'>
                                                            <i class='fa-solid fa-trash'></i>
                                                        </button>
                                                    </td>";
                                                    echo "</tr>";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Không có tài khoản ngân hàng nào.</td></tr>";
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
    <!-- main content part end -->

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
        const errorMessage = urlParams.get('error_message');

        // Hiển thị SweetAlert2 dựa trên giá trị của msg
        if (msg) {
            switch (msg) {
                case 'deleted':
                    Swal.fire({
                        icon: 'success',
                        title: 'Xóa thành công!',
                        text: 'Tài khoản ngân hàng đã được xóa.',
                        confirmButtonText: 'OK'
                    });
                    break;
                case 'error':
                    if (reason === 'failed') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage ? decodeURIComponent(errorMessage) : 'Có lỗi xảy ra trong quá trình xóa.',
                            confirmButtonText: 'Đóng'
                        });
                    } else if (reason === 'not_found') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Tài khoản ngân hàng không tồn tại.',
                            confirmButtonText: 'Đóng'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Xóa không thành công. Vui lòng thử lại.',
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
    </script>

    <!-- Xác nhận xóa tài khoản ngân hàng -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const deleteButtons = document.querySelectorAll(".delete-btn");

            deleteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const bankId = this.getAttribute("data-id");

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa?',
                        text: 'Hành động này sẽ xóa tài khoản ngân hàng và các giao dịch liên quan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `index.php?action=delete&id=${bankId}`;
                        }
                    });
                });
            });
        });
    </script>

    <!-- Nút switch cho trạng thái với ràng buộc chỉ bật 1 tài khoản -->
    <script>
        document.querySelectorAll(".toggleSwitch").forEach(function(switchElement) {
            switchElement.addEventListener("change", function() {
                let bankId = this.dataset.id;
                let newState = this.checked ? 1 : 0;

                // Kiểm tra số lượng tài khoản đang bật
                fetch("check_active_banks.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: ""
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.active_count > 0 && newState === 1 && data.current_active_id !== bankId) {
                            // Nếu có tài khoản khác đang bật và không phải tài khoản hiện tại
                            Swal.fire({
                                icon: 'warning',
                                title: 'Cảnh báo!',
                                text: 'Bạn chỉ được bật 1 tài khoản đồng thời.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                this.checked = false; // Đặt lại trạng thái checkbox
                            });
                        } else {
                            // Cập nhật trạng thái
                            fetch("update_bank_status.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: `id=${bankId}&state=${newState}`
                                })
                                .then(response => response.text())
                                .then(data => {
                                    console.log(data);
                                    if (data === "success") {
                                        if (newState === 1) {
                                            // Tắt tất cả các tài khoản khác
                                            fetch("disable_other_banks.php", {
                                                    method: "POST",
                                                    headers: {
                                                        "Content-Type": "application/x-www-form-urlencoded"
                                                    },
                                                    body: `id=${bankId}`
                                                })
                                                .then(response => response.text())
                                                .then(data => console.log("Other banks disabled:", data))
                                                .catch(error => console.error("Error disabling other banks:", error));
                                        }
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Cập nhật thành công!',
                                            text: 'Trạng thái tài khoản đã được cập nhật.',
                                            confirmButtonText: 'OK'
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi!',
                                            text: 'Cập nhật trạng thái không thành công.',
                                            confirmButtonText: 'OK'
                                        });
                                        this.checked = !this.checked; // Đảo ngược trạng thái nếu thất bại
                                    }
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi!',
                                        text: 'Có lỗi xảy ra khi kết nối đến server.',
                                        confirmButtonText: 'OK'
                                    });
                                    this.checked = !this.checked; // Đảo ngược lại nếu lỗi
                                });
                        }
                    })
                    .catch(error => console.error("Error checking active banks:", error));
            });
        });
    </script>
</body>

</html>