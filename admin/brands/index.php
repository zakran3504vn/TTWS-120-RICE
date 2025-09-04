<?php
include '../config/db_connection.php';
$img_path = '../../assets/img/';

// Number of records per page
$records_per_page = 10;

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
    $total_records_sql = "SELECT COUNT(*) AS total FROM brands WHERE brandName LIKE ?";
    $stmt = $conn->prepare($total_records_sql);
    $search_param = '%' . $search_keyword . '%';
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_records = $result->fetch_assoc()['total'];
    $stmt->close();

    // Query to fetch paginated data with search
    $sql = "SELECT * FROM brands WHERE brandName LIKE ? LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $search_param, $records_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    // If there is no search keyword
    $total_records_sql = "SELECT COUNT(*) AS total FROM brands";
    $result = $conn->query($total_records_sql);
    $total_records = $result->fetch_assoc()['total'];

    // Query to fetch paginated data
    $sql = "SELECT * FROM brands LIMIT $records_per_page OFFSET $offset";
    $result = $conn->query($sql);
}

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quản Lý Thương Hiệu</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap1.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style1.css">
    <style>
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

        /* Modal styling */
        .modal-xl {
            max-width: 80%;
        }

        .modal-content iframe {
            width: 100%;
            height: 600px;
            border: none;
        }
    </style>
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>

<body class="crm_body_bg">
    <!-- sidebar  -->
    <?php
    $currentPage = 'thuonghieu';
    include('../src/include/sidebar.php');
    ?>
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
                                        <a href="../logout">Đăng Xuất</a>
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
                                        <h3> Quản Lý Thương Hiệu</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="dashboard_breadcam text-end">
                                        <p><a href="../index.php">Dashboard</a> <i class="fas fa-caret-right"></i> Bảng Thương Hiệu</p>
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
                                                    <input type="text" name="search_keyword" placeholder="Tìm kiếm thương hiệu..." value="<?php echo isset($_POST['search_keyword']) ? $_POST['search_keyword'] : ''; ?>">
                                                </div>
                                                <button type="submit"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Add Brand Button -->
                                    <div class="add_button ms-2">
                                        <a href="add_brand.php" class="btn_1">THÊM THƯƠNG HIỆU</a>
                                    </div>
                                </div>
                            </div>
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th>STT</th>
                                                <th>Tên Thương Hiệu</th>
                                                <th>Hình Ảnh</th>
                                                <th>Ngày Tạo</th>
                                                <th>Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $stt = $offset + 1; // Serial number based on the page
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr class='text-center' data-brand-id='" . urlencode($row['brandID']) . "'>";
                                                    echo "<th scope='row'>" . $stt . "</th>";
                                                    echo "<td>" . htmlspecialchars($row['brandName']) . "</td>";
                                                    echo "<td>";
                                                    if (!empty($row['brandImg'])) {
                                                        echo "<img src='" . htmlspecialchars($img_path . '/' . $row['brandImg']) . "' alt='Ảnh thương hiệu' style='width: 150px; height: 150px; border-radius: 0%;'>";
                                                    } else {
                                                        echo "Không có ảnh";
                                                    }
                                                    echo "</td>";
                                                    echo "<td>" . htmlspecialchars($row['createdAt']) . "</td>";
                                                    echo "<td>
                                                        <a href='#' class='btn btn-info text-white btn-sm view-brand' data-brand-id='" . urlencode($row['brandID']) . "' data-toggle='modal' data-target='#viewBrandModal'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </a>
                                                        <a href='edit_brand.php?id=" . urlencode($row['brandID']) . "' class='btn btn-primary text-white btn-sm'>
                                                            <i class='fa-solid fa-pen-to-square'></i>
                                                        </a>
                                                        <button class='btn btn-danger text-white btn-sm delete-brand' data-brand-id='" . urlencode($row['brandID']) . "'>
                                                            <i class='fa-solid fa-trash'></i>
                                                        </button>
                                                    </td>";
                                                    echo "</tr>";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>Không có thương hiệu nào.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <!-- Pagination buttons -->
                                    <div class="pagination">
                                        <nav aria-label="Page navigation">
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
            </div>
        </div>

        <!-- Modal for viewing brand details -->
        <div class="modal fade" id="viewBrandModal" tabindex="-1" role="dialog" aria-labelledby="viewBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewBrandModalLabel">Xem trước thương hiệu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="brandPreviewIframe" src="" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <!-- jQuery and Bootstrap JS (required for modal functionality) -->
        <script src="../js/jquery1-3.4.1.min.js"></script>
        <script src="../js/popper1.min.js"></script>
        <script src="../js/bootstrap1.min.js"></script>
        <!-- Other scripts -->
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
        <script src="../vendors/progressbar/jquery.barfiller.js"></script>
        <script src="../vendors/tagsinput/tagsinput.js"></script>
        <script src="../vendors/text_editor/summernote-bs4.js"></script>
        <script src="../vendors/apex_chart/apexcharts.js"></script>
        <script src="../js/custom.js"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- CKEditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

        <!-- Script to handle modal iframe src and delete functionality -->
        <script>
            $(document).ready(function() {
                // Handle modal for viewing brand details
                $('.view-brand').on('click', function(e) {
                    e.preventDefault(); // Prevent default link behavior
                    var brandId = $(this).data('brand-id');
                    var iframeSrc = '../../brands/detail_brand.php?brand_id=' + brandId;
                    $('#brandPreviewIframe').attr('src', iframeSrc);
                    $('#viewBrandModal').modal('show'); // Show the modal
                });

                // Clear iframe src when modal is closed to prevent reloading issues
                $('#viewBrandModal').on('hidden.bs.modal', function() {
                    $('#brandPreviewIframe').attr('src', '');
                });

                // Handle delete brand with AJAX and SweetAlert2
                $('.delete-brand').on('click', function(e) {
                    e.preventDefault();
                    const brandId = $(this).data('brand-id');
                    const row = $(this).closest('tr'); // Get the table row for removal

                    // Show SweetAlert2 confirmation dialog
                    Swal.fire({
                        title: 'Bạn có chắc không?',
                        text: 'Bạn có chắc muốn xóa thương hiệu này không?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa!',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Make AJAX request to delete the brand
                            $.ajax({
                                url: 'delete_brand.php',
                                type: 'GET',
                                data: {
                                    action: 'delete',
                                    id: brandId
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        // Show success message
                                        Swal.fire({
                                            title: 'Thành công!',
                                            text: response.message,
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            // Remove the row from the table
                                            row.remove();
                                            // Check if the table is empty
                                            if ($('tbody tr').length === 0) {
                                                $('tbody').html("<tr><td colspan='5' class='text-center'>Không có thương hiệu nào.</td></tr>");
                                            }
                                        });
                                    } else {
                                        // Show error message
                                        Swal.fire({
                                            title: 'Lỗi!',
                                            text: response.message,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                },
                                error: function() {
                                    // Show error message if AJAX fails
                                    Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Có lỗi xảy ra khi kết nối đến server.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>

</body>

</html>