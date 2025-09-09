<!-- PHP -->
<?php
include './config/db_connection.php';

// Xử lý upload ảnh từ CKEditor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['upload_image'])) {
    header('Content-Type: application/json');
    $img_path = './assets/img/' . $_SESSION['username'] . '/'; // Đường dẫn lưu trữ cục bộ
    $img_url_base = '/admin/assets/img/' . $_SESSION['username'] . '/'; // Đường dẫn đầy đủ cho URL
    $max_file_size = 3 * 1024 * 1024;

    if (!is_dir($img_path)) {
        mkdir($img_path, 0777, true);
    }

    if (!empty($_FILES['upload']['name'])) {
        $tmp_name = $_FILES['upload']['tmp_name'];
        $name = $_FILES['upload']['name'];
        $error = $_FILES['upload']['error'];
        $size = $_FILES['upload']['size'];

        if ($error === UPLOAD_ERR_OK && $size <= $max_file_size) {
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff'];

            if (in_array($ext, $allowed_types)) {
                $file_name = uniqid() . '.' . $ext;
                $dest = $img_path . $file_name;
                $full_url = $img_url_base . $file_name;

                if (move_uploaded_file($tmp_name, $dest)) {
                    echo json_encode([
                        "uploaded" => 1,
                        "fileName" => $file_name,
                        "url" => $full_url
                    ]);
                } else {
                    echo json_encode([
                        "uploaded" => 0,
                        "error" => ["message" => "Không thể di chuyển file đến thư mục đích."]
                    ]);
                }
                exit;
            }
        }
    }

    echo json_encode([
        "uploaded" => 0,
        "error" => ["message" => "Upload thất bại. Vui lòng kiểm tra lại kích thước và định dạng file."]
    ]);
    exit;
}

// Xử lý lưu tin tức
$success_message = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['upload_image'])) {
    $news_name = trim($_POST['news_name'] ?? '');
    $news_content = trim($_POST['news_content'] ?? '');
    $news_summary = trim($_POST['new_summary'] ?? '');
    $news_author = trim($_POST['news_author'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $img_path = './assets/img/' . $_SESSION['username'] . '/';
    $img_url_base = '/admin/assets/img/' . $_SESSION['username'] . '/';
    $max_file_size = 3 * 1024 * 1024;

    // Validate tóm tắt
    if (strlen($news_summary) > 200) {
        $errors[] = "Tóm tắt không được vượt quá 200 ký tự.";
    }

    // Validate các trường bắt buộc
    if (empty($news_name)) {
        $errors[] = "Tên bài viết là bắt buộc.";
    }
    if (empty($news_content)) {
        $errors[] = "Nội dung là bắt buộc.";
    }
    if (empty($news_summary)) {
        $errors[] = "Tóm tắt là bắt buộc.";
    }
    if (empty($news_author)) {
        $errors[] = "Tác giả là bắt buộc.";
    }
    if (empty($slug)) {
        $errors[] = "Slug là bắt buộc.";
    }

    // Tạo thư mục lưu ảnh nếu chưa tồn tại
    if (!is_dir($img_path)) {
        if (!mkdir($img_path, 0777, true) && !is_dir($img_path)) {
            $errors[] = "Không thể tạo thư mục lưu trữ hình ảnh.";
        }
    }

    // Xử lý ảnh đại diện
    $news_img = "";
    if (!empty($_FILES['news_img']['name'])) {
        $tmp_name = $_FILES['news_img']['tmp_name'];
        $size = $_FILES['news_img']['size'];
        $error = $_FILES['news_img']['error'];
        $name = $_FILES['news_img']['name'];

        if ($error === UPLOAD_ERR_OK) {
            if ($size <= $max_file_size) {
                $file_ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff'];
                if (in_array($file_ext, $allowed_types)) {
                    $file_name = uniqid() . '.' . $file_ext;
                    $file_dest = $img_path . $file_name;
                    $news_img = $img_url_base . $file_name;

                    if (!move_uploaded_file($tmp_name, $file_dest)) {
                        $errors[] = "Không thể tải lên hình ảnh đại diện.";
                    }
                } else {
                    $errors[] = "Định dạng ảnh không được hỗ trợ. Chỉ chấp nhận: jpg, jpeg, png, gif, bmp, webp, tiff.";
                }
            } else {
                $errors[] = "Hình ảnh đại diện vượt quá kích thước cho phép (3MB).";
            }
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh đại diện: " . $error;
        }
    } else {
        $errors[] = "Hình ảnh đại diện là bắt buộc.";
    }

    // Lưu vào cơ sở dữ liệu nếu không có lỗi
    if (empty($errors)) {
        $sql = "INSERT INTO news (news_name, news_content, new_summary, news_author, slug, news_img, create_time) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssss", $news_name, $news_content, $news_summary, $news_author, $slug, $news_img);
            if ($stmt->execute()) {
                $success_message = "Tin tức mới đã được tạo thành công!";
            } else {
                $errors[] = "Lỗi khi thực thi truy vấn: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Lỗi chuẩn bị truy vấn: " . $conn->error;
        }
    }

    // Hiển thị thông báo lỗi nếu có
    if (!empty($errors)) {
        $error_message = implode('<br>', $errors);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Tạo tin tức thất bại',
                    html: '" . addslashes($error_message) . "',
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
                    text: '" . addslashes($success_message) . "',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '?current_page=news';
                    }
                });
            });
        </script>";
    }
}
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Thêm Tin Tức</title>

    <link rel="icon" type="image/ico" href="https://truongthanhweb.com/wp-content/uploads/sites/208/2020/06/favicon.ico">
    <link rel="stylesheet" href="./css/bootstrap1.min.css" />
    <link rel="stylesheet" href="./vendors/themefy_icon/themify-icons.css" />
    <link rel="stylesheet" href="./vendors/swiper_slider/css/swiper.min.css" />
    <link rel="stylesheet" href="./vendors/select2/css/select2.min.css" />
    <link rel="stylesheet" href="./vendors/niceselect/css/nice-select.css" />
    <link rel="stylesheet" href="./vendors/owl_carousel/css/owl.carousel.css" />
    <link rel="stylesheet" href="./vendors/gijgo/gijgo.min.css" />
    <link rel="stylesheet" href="./vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="./vendors/tagsinput/tagsinput.css" />
    <link rel="stylesheet" href="./vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="./vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="./vendors/datatable/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="./vendors/text_editor/summernote-bs4.css" />
    <link rel="stylesheet" href="./vendors/morris/morris.css">
    <link rel="stylesheet" href="./vendors/material_icon/material-icons.css" />
    <link rel="stylesheet" href="./css/metisMenu.css">
    <link rel="stylesheet" href="./css/style1.css" />
    <link rel="stylesheet" href="./css/colors/default.css" id="colorSkinCSS">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/decoupled-document/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .modal-dialog {
            max-width: 800px;
        }

        #toolbar-container {
            border: 1px solid #ccc;
            border-bottom: none;
            padding: 10px;
        }

        #editor-container {
            height: 400px;
            border: 1px solid #ccc;
            padding: 20px;
        }
    </style>
</head>

<body class="crm_body_bg">
    <?php
    $currentPage = 'tintuc';
    include('./includes/sidebar.php');
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
                                <img src="./img/client_img-1.png" alt="#">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name">
                                        <p>Xin Chào </p>
                                        <h5><?php echo $_SESSION['fullname']; ?></h5>
                                    </div>
                                    <div class="profile_info_details">
                                        <a href="../profile/index.php">Thông Tin Cá Nhân</a>
                                        <a href="#">Thêm Tin Tức</a>
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
                                        <h2 class="text-center mb-4">Thêm Tin Tức</h2>
                                        <form method="POST" class="p-4 border rounded shadow" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="news_name" class="form-label">Tên Bài Viết:</label>
                                                <input type="text" class="form-control" id="news_name" name="news_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="slug" class="form-label">Slug:</label>
                                                <input type="text" class="form-control" id="slug" name="slug" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_summary" class="form-label">Tóm Tắt (tối đa 200 ký tự):</label>
                                                <textarea class="form-control" id="new_summary" name="new_summary" rows="3" maxlength="200" required placeholder="Nhập tóm tắt tin tức (tối đa 200 ký tự)"></textarea>
                                                <small class="text-muted">Còn lại: <span id="char_count">200</span> ký tự</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="news_content" class="form-label">Nội Dung:</label>
                                                <div id="toolbar-container"></div>
                                                <div id="editor-container"></div>
                                                <textarea id="news_content" name="news_content" style="display: none;"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="news_author" class="form-label">Tác Giả:</label>
                                                <input type="text" class="form-control" id="news_author" name="news_author" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="news_img" class="form-label">Hình Ảnh Đại Diện:</label>
                                                <input type="file" class="form-control" id="news_img" name="news_img" accept="image/*" required>
                                                <small class="text-muted">Hình ảnh bài viết (bắt buộc).</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="create_news">Thêm</button>
                                            <a href="?current_page=news" class="btn btn-secondary">Danh Sách Tin Tức</a>
                                        </form>
                                    </div>
                                    <script>
                                        DecoupledEditor
                                            .create(document.querySelector('#editor-container'), {
                                                toolbar: [
                                                    'heading', '|',
                                                    'fontSize', 'fontFamily', '|',
                                                    'fontColor', 'fontBackgroundColor', '|',
                                                    'bold', 'italic', 'underline', 'strikethrough', '|',
                                                    'alignment', '|',
                                                    'numberedList', 'bulletedList', '|',
                                                    'indent', 'outdent', '|',
                                                    'link', 'blockQuote', 'insertTable', '|',
                                                    'imageUpload', '|',
                                                    'undo', 'redo'
                                                ],
                                                language: 'vi',
                                                image: {
                                                    toolbar: [
                                                        'imageTextAlternative',
                                                        'imageStyle:inline',
                                                        'imageStyle:block',
                                                        'imageStyle:side'
                                                    ]
                                                },
                                                table: {
                                                    contentToolbar: [
                                                        'tableColumn',
                                                        'tableRow',
                                                        'mergeTableCells'
                                                    ]
                                                }
                                            })
                                            .then(editor => {
                                                const toolbarContainer = document.querySelector('#toolbar-container');
                                                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                                                // Cập nhật giá trị textarea khi nội dung thay đổi
                                                editor.model.document.on('change:data', () => {
                                                    const content = editor.getData(); // Lấy nội dung HTML từ CKEditor
                                                    const textarea = document.querySelector('#news_content');
                                                    if (textarea) {
                                                        textarea.value = content; // Gán nội dung vào textarea ẩn
                                                    } else {
                                                        console.error('Textarea #news_content not found');
                                                    }
                                                });

                                                // Xử lý upload hình ảnh
                                                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                                                    return {
                                                        upload: () => {
                                                            return new Promise((resolve, reject) => {
                                                                const data = new FormData();
                                                                loader.file.then(file => {
                                                                    data.append('upload', file);
                                                                    fetch('?current_page=add_news&upload_image=1', {
                                                                            method: 'POST',
                                                                            body: data
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(response => {
                                                                            if (response.uploaded) {
                                                                                resolve({
                                                                                    default: response.url
                                                                                });
                                                                            } else {
                                                                                reject(response.error.message || 'Lỗi không xác định');
                                                                            }
                                                                        })
                                                                        .catch(error => {
                                                                            console.error('Upload error:', error);
                                                                            reject('Lỗi khi upload ảnh!');
                                                                        });
                                                                });
                                                            });
                                                        }
                                                    };
                                                };
                                            })
                                            .catch(error => {
                                                console.error(error);
                                            });

                                        document.getElementById('new_summary').addEventListener('input', function() {
                                            const maxLength = 200;
                                            const remaining = maxLength - this.value.length;
                                            document.getElementById('char_count').textContent = remaining;
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
    <script src="./js/jquery1-3.4.1.min.js"></script>
    <script src="./js/popper1.min.js"></script>
    <script src="./js/bootstrap1.min.js"></script>
    <script src="./js/metisMenu.js"></script>
    <script src="./vendors/count_up/jquery.waypoints.min.js"></script>
    <script src="./vendors/chartlist/Chart.min.js"></script>
    <script src="./vendors/count_up/jquery.counterup.min.js"></script>
    <script src="./vendors/swiper_slider/js/swiper.min.js"></script>
    <script src="./vendors/niceselect/js/jquery.nice-select.min.js"></script>
    <script src="./vendors/owl_carousel/js/owl.carousel.min.js"></script>
    <script src="./vendors/gijgo/gijgo.min.js"></script>
    <script src="./vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="./vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="./vendors/datatable/js/dataTables.buttons.min.js"></script>
    <script src="./vendors/datatable/js/buttons.flash.min.js"></script>
    <script src="./vendors/datatable/js/jszip.min.js"></script>
    <script src="./vendors/datatable/js/pdfmake.min.js"></script>
    <script src="./vendors/datatable/js/vfs_fonts.js"></script>
    <script src="./vendors/datatable/js/buttons.php5.min.js"></script>
    <script src="./vendors/datatable/js/buttons.print.min.js"></script>
    <script src="../js/chart.min.js"></script>
    <script src="../vendors/progressbar/jquery.barfiller.js"></script>
    <script src="../vendors/tagsinput/tagsinput.js"></script>
    <script src="../vendors/text_editor/summernote-bs4.js"></script>
    <script src="../vendors/apex_chart/apexcharts.js"></script>
    <script src="../js/custom.js"></script>
</body>

</html>