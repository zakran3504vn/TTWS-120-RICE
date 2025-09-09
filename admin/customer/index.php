<?php
include '../config/db_connection.php';

$records_per_page = 10;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $records_per_page;

$search_keyword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search_keyword'])) {
    $search_keyword = trim($_POST['search_keyword']);
}

if (!empty($search_keyword)) {
    $total_records_sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'Customer' AND username LIKE ?";
    $stmt = $conn->prepare($total_records_sql);
    $search_param = '%' . $search_keyword . '%';
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_records = $result->fetch_assoc()['total'];
    $stmt->close();

    $sql = "SELECT u.id, u.username, u.email, u.full_name, w.balance FROM users u LEFT JOIN wallet w ON u.id = w.user_id WHERE u.role = 'Customer' AND u.username LIKE ? LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $search_param, $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $total_records_sql = "SELECT COUNT(*) AS total FROM users WHERE role = 'Customer'";
    $result = $conn->query($total_records_sql);
    $total_records = $result->fetch_assoc()['total'];

    $sql = "SELECT u.id, u.username, u.email, u.full_name, w.balance FROM users u LEFT JOIN wallet w ON u.id = w.user_id WHERE u.role = 'Customer' LIMIT $records_per_page OFFSET $offset";
    $result = $conn->query($sql);
}
$total_pages = ceil($total_records / $records_per_page);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_balance']) && isset($_POST['user_id']) && isset($_POST['amount'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];

    $sql = "UPDATE wallet SET balance = balance + ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('di', $amount, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?msg=added");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $checkWallet = "SELECT COUNT(*) AS count FROM wallet WHERE user_id = ?";
    $stmt = $conn->prepare($checkWallet);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        header("Location: index.php?msg=error&reason=linked");
        exit();
    } else {
        $deleteUser = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($deleteUser);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            header("Location: index.php?msg=deleted");
            exit();
        } else {
            header("Location: index.php?msg=error&reason=failed");
            exit();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quản Lý User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="../css/bootstrap1.min.css" />
    <link rel="stylesheet" href="../vendors/themefy_icon/themify-icons.css" />
    <link rel="stylesheet" href="../vendors/swiper_slider/css/swiper.min.css" />
    <link rel="stylesheet" href="../vendors/select2/css/select2.min.css" />
    <link rel="stylesheet" href="../vendors/niceselect/css/nice-select.css" />
    <link rel="stylesheet" href="../vendors/owl_carousel/css/owl.carousel.css" />
    <link rel="stylesheet" href="../vendors/gijgo/gijgo.min.css" />
    <link rel="stylesheet" href="../vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="../vendors/tagsinput/tagsinput.css" />
    <link rel="stylesheet" href="../vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="../vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="../vendors/datatable/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../vendors/text_editor/summernote-bs4.css" />
    <link rel="stylesheet" href="../vendors/morris/morris.css" />
    <link rel="stylesheet" href="../vendors/material_icon/material-icons.css" />
    <link rel="stylesheet" href="../css/metisMenu.css" />
    <link rel="stylesheet" href="../css/style1.css" />
    <link rel="stylesheet" href="../css/colors/default.css" id="colorSkinCSS" />
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="crm_body_bg">
    <?php
    $currentPage = "user";
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
                                        <h3>Quản Lý User</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="../index.php">Dashboard</a> <i class="fas fa-caret-right"></i> Bảng User</p>
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
                                                <div class="search_field">
                                                    <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?php echo isset($_POST['search_keyword']) ? $_POST['search_keyword'] : ''; ?>">
                                                </div>
                                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="add_button ms-2">
                                    <a href="../employee/index.php" class="btn_1">DANH SÁCH NHÂN VIÊN</a>
                                </div>
                            </div>
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th scope="col">STT</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Balance</th>
                                                <th scope="col">Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $stt = $offset + 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr class='text-center'>";
                                                    echo "<th scope='row'>$stt</th>";
                                                    echo "<td>{$row['username']}</td>";
                                                    echo "<td>{$row['email']}</td>";
                                                    echo "<td>{$row['full_name']}</td>";
                                                    echo "<td>" . number_format($row['balance'] ?? 0, 0, ',', '.') . " VNĐ" . "</td>";
                                                    echo "<td>";
                                                    echo "<a href='edit_customer.php?id={$row['id']}' class='btn btn-primary text-white btn-sm' title='Sửa'><i class='fa-solid fa-pen-to-square'></i></a> ";
                                                    echo "<button class='btn btn-danger text-white btn-sm delete-btn' data-id='{$row['id']}' title='Xóa'><i class='fa-solid fa-trash'></i></button> ";
                                                    if ($row['balance'] !== null) {
                                                        echo "<button class='btn btn-primary text-white btn-sm' data-bs-toggle='modal' data-bs-target='#addBalanceModal' data-id='{$row['id']}' title='Cộng Tiền'><i class='fa-solid fa-plus'></i></button>";
                                                    }
                                                    echo "</td></tr>";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='6' class='text-center'>Không có user nào.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <?php if ($current_page > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                                                    <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <?php if ($current_page < $total_pages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                                            <span aria-hidden="true">»</span>
                                                        </a>
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
            </div>
        </div>
    </section>
    <div class="modal fade" id="addBalanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Cộng Tiền Vào Ví</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="mb-3">
                            <label>Số Tiền:</label>
                            <input type="number" class="form-control" name="amount" required>
                        </div>
                        <button type="submit" name="add_balance" class="btn btn-primary">Cộng Tiền</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <script src="../vendors/datatable/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatable/js/buttons.print.min.js"></script>
    <script src="../vendors/progressbar/jquery.barfiller.js"></script>
    <script src="../vendors/tagsinput/tagsinput.js"></script>
    <script src="../vendors/text_editor/summernote-bs4.js"></script>
    <script src="../vendors/apex_chart/apexcharts.js"></script>
    <script src="../js/custom.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addBalanceModal = document.getElementById('addBalanceModal');
            addBalanceModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-id');
                document.getElementById('user_id').value = userId;
            });

            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
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
                            window.location.href = `index.php?action=delete&id=${userId}`;
                        }
                    });
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');
            const reason = urlParams.get('reason');
            if (msg) {
                switch (msg) {
                    case 'added':
                        Swal.fire('Thành công!', 'Tiền đã được cộng.', 'success');
                        break;
                    case 'deleted':
                        Swal.fire('Thành công!', 'Người dùng đã được xóa.', 'success');
                        break;
                    case 'error':
                        if (reason === 'linked') {
                            Swal.fire('Lỗi!', 'Người dùng có ví liên kết, không thể xóa.', 'error');
                        } else if (reason === 'failed') {
                            Swal.fire('Lỗi!', 'Xóa người dùng thất bại.', 'error');
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