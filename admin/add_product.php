<!-- PHP -->
<?php
include 'config/db_connection.php';

$img_path = '../admin/assets/img/';
$success_message = "";
$errors = [];

$sqlTagServices = "SELECT * FROM tag_service";
$resultTag = $conn->query($sqlTagServices);

if (isset($_POST['create_product'])) {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $product_description = $_POST['product_description'];
    $product_price = str_replace([',', '.'], '', $_POST['product_price']);
    $product_pricesales = str_replace([',', '.'], '', $_POST['product_pricesales']);
    $stock_quantity = $_POST['stock_quantity'];
    $isContact = isset($_POST['is_contact']) ? true : false;
    $product_services = $_POST['selectedTags'];
    $product_parameters = $_POST['tskt'];

    if (!is_dir($img_path)) {
        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
        }
    }

    $product_img = "";
    if (!empty($_FILES['product_img']['name'])) {
        $tmp_name = $_FILES['product_img']['tmp_name'];
        $size = $_FILES['product_img']['size'];
        $error = $_FILES['product_img']['error'];
        $name = $_FILES['product_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= 3 * 1024 * 1024) {
                $file_ext = pathinfo($name, PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_ext;
                $file_dest = $img_path . $file_name;

                if (move_uploaded_file($tmp_name, $file_dest)) {
                    $product_img = $file_name;
                } else {
                    $errors[] = "Không thể tải lên hình ảnh sản phẩm.";
                }
            } else {
                $errors[] = "Hình ảnh sản phẩm vượt quá kích thước cho phép (3MB).";
            }
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh sản phẩm.";
        }
    }

    $product_album = "";
    if (!empty($_FILES['product_album']['name'][0])) {
        $uploaded_images = [];
        foreach ($_FILES['product_album']['name'] as $key => $name) {
            $tmp_name = $_FILES['product_album']['tmp_name'][$key];
            $size = $_FILES['product_album']['size'][$key];
            $error = $_FILES['product_album']['error'][$key];

            if ($error === UPLOAD_ERR_OK) {
                if ($size <= 3 * 1024 * 1024) {
                    $file_ext = pathinfo($name, PATHINFO_EXTENSION);
                    $file_name = uniqid() . '.' . $file_ext;
                    $file_dest = $img_path . $file_name;

                    if (move_uploaded_file($tmp_name, $file_dest)) {
                        $uploaded_images[] = $file_name;
                    } else {
                        $errors[] = "Không thể tải lên file $name.";
                    }
                } else {
                    $errors[] = "File $name vượt quá kích thước cho phép (3MB).";
                }
            } else {
                $errors[] = "Lỗi khi tải lên file $name.";
            }
        }

        if (!empty($uploaded_images)) {
            $product_album = implode(',', $uploaded_images);
        }
    }
    
    
    if (empty($errors)) {
        $sql = "INSERT INTO products 
        (product_name, CategoryID, product_description, product_price, product_img, product_album, product_pricesales, product_parameters, product_services, stock_quantity, create_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sissssissi",
            $product_name,
            $category_id,
            $product_description,
            $product_price,
            $product_img,
            $product_album,
            $product_pricesales,
            $product_parameters,
            $product_services,
            $stock_quantity
        );

        if ($stmt->execute()) {
            $success_message = "Sản phẩm mới đã được tạo thành công!";
        } else {
            $errors[] = "Không thể tạo sản phẩm. Vui lòng thử lại.";
        }
    }
}

if (!empty($errors)) {
    $error_message = implode('<br>', $errors);
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Tạo sản phẩm thất bại',
                html: '$error_message',
                confirmButtonText: 'OK'
            });
        });
    </script>";
}

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
                    window.location.href = '?current_page=product_list';
                }
            });
        });
    </script>";
}
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Tạo Sản Phẩm Mới</title>

    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <link rel="stylesheet" href="css/bootstrap1.min.css" />
    <link rel="stylesheet" href="vendors/themefy_icon/themify-icons.css" />
    <link rel="stylesheet" href="vendors/swiper_slider/css/swiper.min.css" />
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" />
    <link rel="stylesheet" href="vendors/niceselect/css/nice-select.css" />
    <link rel="stylesheet" href="vendors/owl_carousel/css/owl.carousel.css" />
    <link rel="stylesheet" href="vendors/gijgo/gijgo.min.css" />
    <link rel="stylesheet" href="vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="vendors/tagsinput/tagsinput.css" />
    <link rel="stylesheet" href="vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/datatable/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="vendors/text_editor/summernote-bs4.css" />
    <link rel="stylesheet" href="vendors/morris/morris.css">
    <link rel="stylesheet" href="vendors/material_icon/material-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/metisMenu.css">
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" href="css/colors/default.css" id="colorSkinCSS">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .dropdown-container {
        position: relative;
        width: auto;
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 5px;
        border: none;
        border-radius: 5px;
        min-height: 40px;
        cursor: text;
    }

    .tag {
        background-color: rgb(183, 58, 255);
        color: #fff;
        padding: 5px 10px;
        border-radius: 3px;
        display: flex;
        align-items: center;
    }

    .tag .remove-tag {
        margin-left: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: #fff;
        border: none;
        border-radius: 5px;
        display: none;
        max-height: 150px;
        overflow-y: auto;
    }

    .dropdown-item {
        padding: 10px;
        cursor: pointer;
    }

    .dropdown-item.hidden {
        display: none;
    }

    .dropdown-item:hover {
        background-color: #f1f1f1;
    }

    .error {
        color: red;
        margin-top: 10px;
    }
</style>

<body class="crm_body_bg">
    <?php
    $currentPage = 'product_list';
    include './includes/sidebar.php';
    ?>
    <section class="main_content dashboard_part">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0 ">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area">
                            <div class="search_inner"></div>
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
                                        <a href="?current_page=profile">Thông Tin Cá Nhân</a>
                                        <a href="#">Cài Đặt</a>
                                        <a href="logout">Đăng Xuất</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_content_iner ">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="QA_section">
                            <div class="QA_table mb_30">
                                <div class="table-responsive">
                                    <div class="container mt-5">
                                        <h2 class="text-center mb-4">Tạo sản phẩm mới</h2>
                                        <form action="" method="POST" class="p-4 border rounded shadow" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Tên Sản Phẩm:</label>
                                                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="CategoryID" class="form-label">Danh Mục:</label>
                                                <select name="category_id" id="CategoryID" class="form-control" required>
                                                    <option value="">Chọn danh mục</option>
                                                    <?php
                                                    $categorySql = "SELECT CategoryID, CategoryName FROM category";
                                                    $categoryResult = $conn->query($categorySql);
                                                    if ($categoryResult->num_rows > 0) {
                                                        while ($row = $categoryResult->fetch_assoc()) {
                                                            echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
                                                        }
                                                    } else {
                                                        echo '<option value="">Không có danh mục</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_description" class="form-label">Mô Tả:</label>
                                                <textarea id="product_description" name="product_description" class="form-control" rows="4" required><?php echo "Nhập Mô Tả"; ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_price" class="form-label">Giá Sản Phẩm:</label>
                                                <input type="text" id="product_price" name="product_price" class="form-control" placeholder="Nhập giá sản phẩm" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_pricesales" class="form-label">Giá Sản Phẩm Khuyến Mãi:</label>
                                                <input type="text" id="product_pricesales" name="product_pricesales" class="form-control" placeholder="Nhập giá khuyến mãi" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="stock_quantity" class="form-label">Số Lượng Tồn Kho:</label>
                                                <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" placeholder="Nhập số lượng" min="0" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="flexCheckDefault" class="form-label">Giá Liên Hệ:</label>
                                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="is_contact">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tagsInput" class="form-label">Thêm dịch vụ (tối đa 4 dịch vụ):</label>
                                                <div class="form-control dropdown-container" style="position: relative;">
                                                    <div id="tagsContainer" class="tags-container" tabindex="0"></div>
                                                    <div id="dropdown" class="dropdown" style="display: none;">
                                                        <?php
                                                        if ($resultTag->num_rows > 0) {
                                                            while ($rowTag = $resultTag->fetch_assoc()) {
                                                        ?>
                                                                <div class="dropdown-item" data-value="<?php echo $rowTag['tag_name'] ?>"><?php echo $rowTag['tag_name'] ?></div>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo '<a href = "tag_service/" style = "text-decoration: none; color: red;"><div class="dropdown-item" data-value="">Không có dữ liệu vui lòng thêm mới!</div></a>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <i class="bi bi-plus-circle-fill" id="addTagService" style="position: absolute; right: 40px; top: 50%; transform: translateY(-50%); cursor: pointer;font-size: 20px;" onclick="addTagService"></i>
                                                    <i class="fas fa-chevron-down" id="dropdownToggle" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                                    <p id="errorMessage" class="error text-danger mt-2"></p>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_img" class="form-label">Hình Ảnh Sản Phẩm:</label>
                                                <input type="file" id="product_img" name="product_img" class="form-control" accept="image/*" required>
                                                <small class="text-muted">Hình ảnh sản phẩm chính (bắt buộc).</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_album" class="form-label">Album Hình Ảnh:</label>
                                                <input type="file" id="product_album" name="product_album[]" class="form-control" accept="image/*" multiple>
                                                <small class="text-muted">Bạn có thể chọn nhiều ảnh. Mỗi ảnh không quá 3MB.</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tskt" class="form-label">Thông Số Kỹ Thuật:</label>
                                                <textarea id="tskt" name="tskt" class="form-control" rows="4" required><?php echo "Nhập Thông Số Kỹ Thuật"; ?></textarea>
                                            </div>
                                            <input type="hidden" id="hidden_price" name="hidden_price" value="">
                                            <input type="hidden" id="hidden_sales_price" name="hidden_sales_price" value="">
                                            <input type="hidden" id="selectedTags" name="selectedTags">
                                            <button type="submit" class="btn btn-primary" name="create_product">Tạo sản phẩm</button>
                                            <a href="?current_page=product_list" class="btn btn-secondary">Danh Sách Sản Phẩm</a>
                                        </form>
                                    </div>
                                    <script>
                                        const dropdown = document.getElementById('dropdown');
                                        const dropdownToggle = document.getElementById('dropdownToggle');
                                        const tagsContainer = document.getElementById('tagsContainer');
                                        const errorMessage = document.getElementById('errorMessage');
                                        const selectedTagsInput = document.getElementById('selectedTags');

                                        const MAX_SELECTION = 4;
                                        let selectedTags = [];

                                        dropdownToggle.addEventListener('click', toggleDropdown);
                                        tagsContainer.addEventListener('click', toggleDropdown);

                                        function toggleDropdown() {
                                            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                                                dropdown.style.display = 'block';
                                            } else {
                                                dropdown.style.display = 'none';
                                            }
                                        }

                                        document.addEventListener('click', (e) => {
                                            if (!e.target.closest('.dropdown-container')) {
                                                dropdown.style.display = 'none';
                                            }
                                        });

                                        dropdown.addEventListener('click', (e) => {
                                            const item = e.target;
                                            if (item.classList.contains('dropdown-item')) {
                                                const value = item.getAttribute('data-value');
                                                if (selectedTags.length >= MAX_SELECTION) {
                                                    errorMessage.textContent = `Bạn chỉ được chọn tối đa ${MAX_SELECTION} mục.`;
                                                    return;
                                                }
                                                if (!selectedTags.includes(value)) {
                                                    selectedTags.push(value);
                                                    renderTags();
                                                    updateDropdown();
                                                    errorMessage.textContent = '';
                                                }
                                                dropdown.style.display = 'none';
                                            }
                                        });

                                        tagsContainer.addEventListener('click', (e) => {
                                            if (e.target.classList.contains('remove-tag')) {
                                                const value = e.target.getAttribute('data-value');
                                                selectedTags = selectedTags.filter(tag => tag !== value);
                                                renderTags();
                                                updateDropdown();
                                                errorMessage.textContent = '';
                                            }
                                        });

                                        function renderTags() {
                                            tagsContainer.innerHTML = '';
                                            selectedTags.forEach(tag => {
                                                const tagElement = document.createElement('div');
                                                tagElement.classList.add('tag');
                                                tagElement.innerHTML = `${tag} <span class="remove-tag" data-value="${tag}">×</span>`;
                                                tagsContainer.appendChild(tagElement);
                                            });
                                            selectedTagsInput.value = selectedTags.join(',');
                                        }

                                        function updateDropdown() {
                                            const items = dropdown.querySelectorAll('.dropdown-item');
                                            items.forEach(item => {
                                                const value = item.getAttribute('data-value');
                                                if (selectedTags.includes(value)) {
                                                    item.classList.add('hidden');
                                                } else {
                                                    item.classList.remove('hidden');
                                                }
                                            });
                                        }

                                        document.getElementById("addTagService").addEventListener("click", function() {
                                            window.location.href = "?current_pgae=tag_service";
                                        });

                                        ClassicEditor
                                            .create(document.querySelector('#product_description'), {
                                                toolbar: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'fontFamily', 'fontSize', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo', 'link', 'imageUpload'],
                                                fontFamily: {
                                                    options: ['default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace', 'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif', 'Verdana, Geneva, sans-serif']
                                                },
                                                fontSize: {
                                                    options: [10, 12, 14, 16, 18, 20, 22, 24, 28, 32],
                                                    supportAllValues: true
                                                }
                                            })
                                            .catch(error => {
                                                console.error(error);
                                            });

                                        ClassicEditor
                                            .create(document.querySelector('#tskt'), {
                                                toolbar: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'fontFamily', 'fontSize', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo', 'link', 'imageUpload'],
                                                fontFamily: {
                                                    options: ['default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace', 'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif', 'Verdana, Geneva, sans-serif']
                                                },
                                                fontSize: {
                                                    options: [10, 12, 14, 16, 18, 20, 22, 24, 28, 32],
                                                    supportAllValues: true
                                                }
                                            })
                                            .catch(error => {
                                                console.error(error);
                                            });

                                        const checkbox = document.getElementById('flexCheckDefault');
                                        const priceInput = document.getElementById('product_price');
                                        const salesPriceInput = document.getElementById('product_pricesales');
                                        const hiddenPrice = document.getElementById('hidden_price');
                                        const hiddenSalesPrice = document.getElementById('hidden_sales_price');

                                        checkbox.addEventListener('change', function() {
                                            if (checkbox.checked) {
                                                priceInput.value = '0';
                                                salesPriceInput.value = '0';
                                                priceInput.readOnly = true;
                                                salesPriceInput.readOnly = true;
                                                hiddenPrice.value = '0';
                                                hiddenSalesPrice.value = '0';
                                            } else {
                                                priceInput.value = '';
                                                salesPriceInput.value = '';
                                                priceInput.readOnly = false;
                                                salesPriceInput.readOnly = false;
                                                hiddenPrice.value = '';
                                                hiddenSalesPrice.value = '';
                                            }
                                        });

                                        document.querySelectorAll('#product_price, #product_pricesales').forEach(input => {
                                            input.addEventListener('input', function(e) {
                                                let value = e.target.value.replace(/[^0-9]/g, '');
                                                if (value) {
                                                    value = Number(value).toLocaleString('vi-VN');
                                                    e.target.value = value;
                                                }
                                            });
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
    <script src="vendors/datatable/js/buttons.html5.min.js"></script>
    <script src="vendors/datatable/js/buttons.print.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="vendors/progressbar/jquery.barfiller.js"></script>
    <script src="vendors/tagsinput/tagsinput.js"></script>
    <script src="vendors/text_editor/summernote-bs4.js"></script>
    <script src="vendors/apex_chart/apexcharts.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>