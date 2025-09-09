<?php
include 'config/db_connection.php';
if (isset($_GET['current_page'])) {
    switch ($_GET['current_page']) {
        case 'delete_news':
            include 'delete_contacts.php';
            exit; // Trả JSON, không render HTML
    }
}
// Số bản ghi hiển thị mỗi trang
$records_per_page = 5;

// Xác định trang hiện tại (nếu không có, mặc định là trang 1)
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Tính toán giá trị OFFSET
$offset = ($current_page - 1) * $records_per_page;

// Kiểm tra từ khóa tìm kiếm
$search_keyword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search_keyword'])) {
    $search_keyword = trim($_POST['search_keyword']);
}
// Kiểm tra nếu có yêu cầu xóa
if (isset($_GET['current_page']) && $_GET['current_page'] === 'delete_contacts' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $response = ['success' => false, 'message' => 'Lỗi không xác định'];

    if ($id > 0) {
        $sql = "DELETE FROM contact_customer WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Khách hàng đã được xóa thành công.'];
        } else {
            $response['message'] = 'Lỗi khi xóa khách hàng.';
        }
        $stmt->close();
    } else {
        $response['message'] = 'ID khách hàng không hợp lệ.';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Lấy tổng số bản ghi
if (!empty($search_keyword)) {
    // Nếu có tìm kiếm
    $total_records_sql = "SELECT COUNT(*) AS total FROM contact_customer WHERE name LIKE ? OR email LIKE ?";
    $stmt = $conn->prepare($total_records_sql);
    $search_param = '%' . $search_keyword . '%';
    $stmt->bind_param('ss', $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_records = $result->fetch_assoc()['total'];
    $stmt->close();

    // Truy vấn lấy dữ liệu phân trang với tìm kiếm
    $sql = "SELECT * FROM contact_customer WHERE name LIKE ? OR email LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssii', $search_param, $search_param, $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    // Nếu không có tìm kiếm
    $total_records_sql = "SELECT COUNT(*) AS total FROM contact_customer";
    $result = $conn->query($total_records_sql);
    $total_records = $result->fetch_assoc()['total'];

    // Truy vấn lấy dữ liệu phân trang
    $sql = "SELECT * FROM contact_customer ORDER BY created_at DESC LIMIT $records_per_page OFFSET $offset";
    $result = $conn->query($sql);
}

// Tính tổng số trang
$total_pages = ceil($total_records / $records_per_page);

$conn->close();
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quản Lý Khách Hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap1.min.css" />
    <!-- themefy CSS -->
    <link rel="stylesheet" href="./vendors/themefy_icon/themify-icons.css" />
    <!-- swiper slider CSS -->
    <link rel="stylesheet" href="./vendors/swiper_slider/css/swiper.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="./vendors/select2/css/select2.min.css" />
    <!-- select2 CSS -->
    <link rel="stylesheet" href="./vendors/niceselect/css/nice-select.css" />
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="./vendors/owl_carousel/css/owl.carousel.css" />
    <!-- gijgo css -->
    <link rel="stylesheet" href="./vendors/gijgo/gijgo.min.css" />
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="./vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="./vendors/tagsinput/tagsinput.css" />
    <!-- datatable CSS -->
    <link rel="stylesheet" href="./vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="./vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="./vendors/datatable/css/buttons.dataTables.min.css" />
    <!-- text editor css -->
    <link rel="stylesheet" href="./vendors/text_editor/summernote-bs4.css" />
    <!-- morris css -->
    <link rel="stylesheet" href="./vendors/morris/morris.css">
    <!-- metarial icon css -->
    <link rel="stylesheet" href="./vendors/material_icon/material-icons.css" />
    <!-- menu css  -->
    <link rel="stylesheet" href="./css/metisMenu.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="./css/style1.css" />
    <link rel="stylesheet" href="./css/colors/default.css" id="colorSkinCSS">
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="crm_body_bg">
    <!-- sidebar  -->
    <?php
    $currentPage = 'khachhang';
    include './includes/sidebar.php';
    ?>
    <!--/ sidebar  -->
    <section class="main_content dashboard_part">
        <!-- menu  -->
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0 ">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none"><i class="ti-menu"></i></div>
                        <div class="serach_field-area">
                            <div class="search_inner"></div>
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="profile_info">
                                <img src="./img/client_img-1.png" alt="#">
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
        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="dashboard_header mb_50">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="dashboard_header_title">
                                        <h3>Quản Lý Khách Hàng</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="../index.php">Dashboard</a> <i class="fas fa-caret-right"></i> Bảng Khách Hàng</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="QA_section">
                            <div class="white_box_tittle list_header">
                                <div class="box_right d-flex lms_block">
                                    <div class="serach_field_2">
                                        <div class="search_inner">
                                            <form action="" method="POST">
                                                <div class="search_field"><input type="text" name="search_keyword" placeholder="Tìm kiếm theo tên hoặc email..." value="<?php echo isset($_POST['search_keyword']) ? htmlspecialchars($_POST['search_keyword']) : ''; ?>"></div>
                                                <button type="submit"> <i class="ti-search"></i> </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Số Điện Thoại</th>
                                                <th scope="col">Địa Chỉ</th>
                                                <th scope="col">Chủ Đề</th>
                                                <th scope="col">Nội Dung</th>
                                                <th scope="col">Ngày Gửi</th>
                                                <th scope="col">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $stt = $offset + 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr class='text-center'>";
                                                    echo "<th scope='row'>" . $stt . "</th>";
                                                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['content']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                                    echo "<td><button class='btn btn-danger text-white btn-sm delete-btn' data-id='" . htmlspecialchars($row['id']) . "'><i class='fa-solid fa-trash'></i></button></td>";
                                                    echo "</tr>";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='9' class='text-center'>Không có khách hàng nào.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- Hiển thị các nút phân trang -->
                                    <div class="pagination">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <?php if ($current_page > 1): ?>
                                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                                <?php endif; ?>

                                                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                                                    <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                                                <?php endfor; ?>

                                                <?php if ($current_page < $total_pages): ?>
                                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jquery slim -->
        <script src="./js/jquery1-3.4.1.min.js"></script>
        <!-- popper js -->
        <script src="./js/popper1.min.js"></script>
        <!-- bootstrap js -->
        <script src="./js/bootstrap1.min.js"></script>
        <!-- sidebar menu  -->
        <script src="./js/metisMenu.js"></script>
        <!-- waypoints js -->
        <script src="./vendors/count_up/jquery.waypoints.min.js"></script>
        <!-- waypoints js -->
        <script src="./vendors/chartlist/Chart.min.js"></script>
        <!-- counterup js -->
        <script src="./vendors/count_up/jquery.counterup.min.js"></script>
        <!-- swiper slider js -->
        <script src="./vendors/swiper_slider/js/swiper.min.js"></script>
        <!-- nice select -->
        <script src="./vendors/niceselect/js/jquery.nice-select.min.js"></script>
        <!-- owl carousel -->
        <script src="./vendors/owl_carousel/js/owl.carousel.min.js"></script>
        <!-- gijgo css -->
        <script src="./vendors/gijgo/gijgo.min.js"></script>
        <!-- responsive table -->
        <script src="./vendors/datatable/js/jquery.dataTables.min.js"></script>
        <script src="./vendors/datatable/js/dataTables.responsive.min.js"></script>
        <script src="./vendors/datatable/js/dataTables.buttons.min.js"></script>
        <script src="./vendors/datatable/js/buttons.flash.min.js"></script>
        <script src="./vendors/datatable/js/jszip.min.js"></script>
        <script src="./vendors/datatable/js/pdfmake.min.js"></script>
        <script src="./vendors/datatable/js/vfs_fonts.js"></script>
        <script src="./vendors/datatable/js/buttons.php5.min.js"></script>
        <script src="./vendors/datatable/js/buttons.print.min.js"></script>
        <script src="js/chart.min.js"></script>
        <!-- progressbar js -->
        <script src="./vendors/progressbar/jquery.barfiller.js"></script>
        <!-- tag input -->
        <script src="./vendors/tagsinput/tagsinput.js"></script>
        <!-- text editor js -->
        <script src="./vendors/text_editor/summernote-bs4.js"></script>
        <script src="./vendors/apex_chart/apexcharts.js"></script>
        <!-- custom js -->
        <script src="./js/custom.js"></script>
        <!-- Thêm jQuery từ CDN -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- sweet alert 2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Xử lý thông báo từ URL (nếu có)
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');
            const reason = urlParams.get('reason');

            if (msg) {
                switch (msg) {
                    case 'deleted':
                        Swal.fire({
                            icon: 'success',
                            title: 'Xóa thành công!',
                            text: 'Khách hàng đã được xóa.',
                            confirmButtonText: 'OK'
                        });
                        break;
                    case 'error':
                        if (reason === 'failed') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra trong quá trình xóa.',
                                confirmButtonText: 'Đóng'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra. Vui lòng thử lại.',
                                confirmButtonText: 'Đóng'
                            });
                        }
                        break;
                    default:
                        console.error('Tham số msg không hợp lệ:', msg);
                }

                const cleanUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
            }

            // Xử lý xóa khách hàng bằng AJAX
            document.addEventListener("DOMContentLoaded", () => {
                const deleteButtons = document.querySelectorAll(".delete-btn");

                deleteButtons.forEach(button => {
                    button.addEventListener("click", function(e) {
                        e.preventDefault();

                        const customerId = this.getAttribute("data-id");
                        console.log("Customer ID to delete:", customerId);
                        if (!customerId || customerId === 'null') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'ID khách hàng không hợp lệ.',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        Swal.fire({
                            title: 'Bạn có chắc chắn muốn xóa?',
                            text: 'Hành động này không thể hoàn tác!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '?current_page=delete_contacts',
                                    method: 'POST',
                                    data: {
                                        id: customerId
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Xóa thành công!',
                                                text: response.message,
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => {
                                                window.location.href = '?current_page=contacts';
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Lỗi!',
                                                text: response.message,
                                                confirmButtonText: 'OK'
                                            });
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi!',
                                            text: 'Có lỗi xảy ra khi xóa. Vui lòng thử lại.',
                                            confirmButtonText: 'OK'
                                        });
                                        console.error('AJAX Error:', status, error);
                                    }
                                });
                            }
                        });
                    });
                });
            });
        </script>
</body>

</html>