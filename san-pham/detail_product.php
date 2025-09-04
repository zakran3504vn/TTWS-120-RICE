<?php
include '../config/db_connection.php';

$id_product = isset($_GET['id']) ? intval($_GET['id']) : 0;
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$product = null;

// Nếu có id → lấy sản phẩm theo id
if ($id_product > 0) {
    $sql = "SELECT `product_id`,`product_name`,`product_description`,`product_img`,`create_at`,
                   `product_price`,`product_album`,`CategoryID` 
            FROM `products` 
            WHERE `product_id` = $id_product";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

// Nếu không có id nhưng có category_id → lấy 1 sản phẩm bất kỳ trong category đó
if (!$product && $category_id > 0) {
    $sql = "SELECT `product_id`,`product_name`,`product_description`,`product_img`,`create_at`,
                   `product_price`,`product_album`,`CategoryID` 
            FROM `products` 
            WHERE `CategoryID` = $category_id 
            LIMIT 1";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
    $id_product = $product['product_id'] ?? 0;
}

// Nếu vẫn không có sản phẩm → thoát
if (!$product) {
    die("<h2 style='color:red; text-align:center;'>❌ Không tìm thấy sản phẩm</h2>");
}

// Lấy category_id của sản phẩm chính
$category_id = $product['CategoryID'] ?? null;

// Lấy sản phẩm tương tự
$same_products = [];
if ($category_id) {
    $sql1 = "SELECT `product_id`,`product_name`,`product_description`,`product_img`,`create_at`,`product_price`,`product_album` 
             FROM `products` 
             WHERE `CategoryID` = $category_id AND `product_id` != $id_product 
             LIMIT 4";
    $same_products = $conn->query($sql1);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết <?php echo $product['product_name']; ?> Đặc Sản | Gạo Sạch 3 Miền</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4CAF50',
                        secondary: '#8BC34A'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }
        input[type="radio"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
        }
        input[type="radio"]:checked {
            border-color: #4CAF50;
        }
        input[type="radio"]:checked::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background-color: #4CAF50;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-white">
     <?php
     $current_page = 'products';
     include ("../includes/header_child.php");
    ?>
    <main class="pt-32 pb-16 min-h-screen">
        <div class="container mx-auto px-4">
            <nav class="flex items-center gap-2 text-sm mb-8 bg-white px-4 py-3 rounded-lg shadow-sm">
                <a href="../index.php" class="text-gray-500 hover:text-primary flex items-center gap-1">
                    <i class="ri-home-line"></i>
                    <span>Trang chủ</span>
                </a>
                <i class="ri-arrow-right-s-line text-gray-400"></i>
                <a href="./index.php" class="text-gray-500 hover:text-primary">Sản phẩm</a>
                <i class="ri-arrow-right-s-line text-gray-400"></i>
                <span class="text-primary font-medium"><?php echo $product['product_name']; ?></span>
            </nav>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                <div class="space-y-4">
                    <div class="relative">
                        <img id="main-image"
                            src="../admin/assets/img/<?php echo $product['product_img']; ?>"
                            alt="Gạo ST25 Đặc Sản" class="w-full h-auto object-cover rounded-lg cursor-zoom-in">
                        <button id="zoom-btn"
                            class="absolute top-4 right-4 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center text-gray-600 hover:text-primary">
                            <i class="ri-zoom-in-line text-xl"></i>
                        </button>
                    </div>
                    <div class="flex gap-4">
                        <button
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary"
                            id="prev-btn">
                            <i class="ri-arrow-left-s-line text-xl"></i>
                        </button>
                        <div class="flex gap-2 overflow-x-auto flex-1">
                            <?php
                                $images = explode(",", $product['product_album']); 
                                array_unshift($images, $product['product_img']);
                                foreach ($images as $index => $img) {
                                    $img = trim($img); 
                                    ?>
                                    <img src="../admin/assets/img/<?= $img ?>"
                                        data-large-src="../admin/assets/img/<?= $img ?>"
                                        alt="Thumbnail <?= $index + 1 ?>"
                                        class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 border-primary thumbnail <?= $index === 0 ? 'active' : '' ?>">
                                    <?php
                                }
                                ?>
                        </div>
                        <button
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary"
                            id="next-btn">
                            <i class="ri-arrow-right-s-line text-xl"></i>
                        </button>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo $product['product_name']; ?></h1>
                        <div class="text-3xl font-bold text-primary mb-6" id="product-price"><?php echo number_format($product['product_price'], 0, ',', '.') . ' ₫'; ?></div>
                    </div>
                    <button id="contact-btn"
                        class="!rounded-button bg-primary text-white px-8 py-3 w-full hover:bg-primary/90 text-lg font-semibold whitespace-nowrap">
                        <i class="ri-phone-line mr-2"></i>
                        Liên hệ đặt hàng
                    </button>
                </div>
            </div>
            <div class="mb-16">
                <div class="border-b border-gray-200 mb-8">
                    <nav class="flex gap-8">
                        <button class="tab-btn py-4 px-2 border-b-2 border-primary text-primary font-semibold"
                            data-tab="description">Mô tả sản phẩm</button>
                    </nav>
                </div>
                <div id="description" class="tab-content">
                    <div class="prose max-w-none">
                        <h3 class="text-2xl font-bold mb-4"><?php echo $product['product_name']; ?> - Hạng nhất thế giới</h3>
                        <p class="text-lg text-gray-700 mb-6"><?php echo $product['product_description']; ?></p>

                    </div>
                </div>
               
            </div>
            <div class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold">Sản phẩm tương tự</h2>
                    <div class="flex gap-2">
                        <button
                            class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary"
                            id="related-prev">
                            <i class="ri-arrow-left-s-line text-xl"></i>
                        </button>
                        <button
                            class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600 hover:text-primary"
                            id="related-next">
                            <i class="ri-arrow-right-s-line text-xl"></i>
                        </button>
                    </div>
                </div>
                 <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="related-products">
    <?php foreach ($same_products as $product) { ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="../admin/assets/img/<?= $product['product_img']; ?>" alt="<?= $product['product_name']; ?>" class="w-full h-auto object-cover">
            <div class="p-4">
                <h3 class="font-semibold mb-2"><?= $product['product_name']; ?></h3>
                <p class="text-gray-600 mb-4 text-sm"><?= $product['product_description']; ?></p>
                <div class="flex items-center justify-between">
                    <div class="text-primary font-bold text-lg">
                        <?= number_format($product['product_price'], 0, ',', '.') . ' ₫'; ?>
                    </div>
                    <button onclick="window.location.href='./detail_product.php?id=<?= $product['product_id']; ?>'"
                            class="!rounded-button bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">
                        Xem chi tiết
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

            </div>
        </div>
    </main>

    <div id="contact-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl text-primary font-bold">Đặt hàng  <?php echo $product['product_name']; ?></h2>
                <button id="close-modal"
                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>
            <form  action="../modules/save_orders.php" method="POST" id="contact-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="fullname" id="fullname" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Số điện thoại <span
                            class="text-red-500">*</span></label>
                    <input type="tel" name="phone" id="phone" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Ghi chú</label>
                    <textarea name="note" id="note" rows="3" maxlength="500"
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary resize-none"></textarea>
                    <div class="text-right text-sm text-gray-500 mt-1">
                        <span id="note-length">0</span>/500
                    </div>
                </div>
                <button type="submit"
                    class="!rounded-button bg-primary text-white px-6 py-3 w-full hover:bg-primary/90 font-semibold whitespace-nowrap">
                    Gửi yêu cầu
                </button>
            </form>
        </div>
    </div>

    
    <div id="image-modal" class="fixed inset-0 bg-black/80 z-50 hidden flex items-center justify-center">
        <div class="relative max-w-4xl max-h-[90vh] w-full h-full flex items-center justify-center">
            <img id="zoomed-image" src="" alt="" class="max-w-full max-h-full object-contain" style="transform: scale(1);">
            <button id="close-image-modal" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
            <div class="absolute bottom-4 right-4 flex gap-2">
                <button id="zoom-in" class="bg-white/50 p-2 rounded text-black">+</button>
                <button id="zoom-out" class="bg-white/50 p-2 rounded text-black">-</button>
            </div>
        </div>
    </div>
    <?php
    include ('../includes/footer_child.php');
    include ('../includes/cta_child.php');
    ?>
    <script id="main-script">
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            menuToggle.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });

            // Image gallery
            const mainImage = document.getElementById('main-image');
            const thumbnails = document.querySelectorAll('.thumbnail');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            let currentIndex = 0;
            function updateMainImage(index) {
                mainImage.src = thumbnails[index].dataset.largeSrc;
                thumbnails.forEach((thumb, i) => {
                    if (i === index) {
                        thumb.classList.add('border-primary');
                        thumb.classList.remove('border-gray-200');
                    } else {
                        thumb.classList.add('border-gray-200');
                        thumb.classList.remove('border-primary');
                    }
                });
                currentIndex = index;
            }
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', () => updateMainImage(index));
            });
            prevBtn.addEventListener('click', () => {
                const newIndex = currentIndex > 0 ? currentIndex - 1 : thumbnails.length - 1;
                updateMainImage(newIndex);
            });
            nextBtn.addEventListener('click', () => {
                const newIndex = currentIndex < thumbnails.length - 1 ? currentIndex + 1 : 0;
                updateMainImage(newIndex);
            });

            // Image zoom modal
            const imageModal = document.getElementById('image-modal');
            const zoomedImage = document.getElementById('zoomed-image');
            const closeImageModal = document.getElementById('close-image-modal');
            const zoomInBtn = document.getElementById('zoom-in');
            const zoomOutBtn = document.getElementById('zoom-out');
            let zoomLevel = 1;
            const zoomStep = 0.5;
            const maxZoom = 3;
            const minZoom = 1;
            function openImageModal() {
                zoomedImage.src = mainImage.src;
                zoomedImage.style.transform = `scale(${zoomLevel})`;
                imageModal.classList.remove('hidden');
            }
            function closeImageModalFunc() {
                imageModal.classList.add('hidden');
                zoomLevel = 1;
                zoomedImage.style.transform = `scale(${zoomLevel})`;
            }
            document.getElementById('zoom-btn').addEventListener('click', openImageModal);
            mainImage.addEventListener('click', openImageModal);
            closeImageModal.addEventListener('click', closeImageModalFunc);
            imageModal.addEventListener('click', (e) => {
                if (e.target === imageModal) {
                    closeImageModalFunc();
                }
            });
            zoomInBtn.addEventListener('click', () => {
                if (zoomLevel < maxZoom) {
                    zoomLevel += zoomStep;
                    zoomedImage.style.transform = `scale(${zoomLevel})`;
                }
            });
            zoomOutBtn.addEventListener('click', () => {
                if (zoomLevel > minZoom) {
                    zoomLevel -= zoomStep;
                    zoomedImage.style.transform = `scale(${zoomLevel})`;
                }
            });

            // Tab control
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetTab = this.getAttribute('data-tab');
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-primary', 'text-primary');
                        btn.classList.add('border-transparent', 'text-gray-600');
                    });
                    this.classList.add('border-primary', 'text-primary');
                    this.classList.remove('border-transparent', 'text-gray-600');
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(targetTab).classList.remove('hidden');
                });
            });

            // Contact modal
            const contactBtn = document.getElementById('contact-btn');
            const modal = document.getElementById('contact-modal');
            const closeBtn = document.getElementById('close-modal');
            const contactForm = document.getElementById('contact-form');
            const noteTextarea = contactForm.querySelector('textarea[name="note"]');
            const noteLengthDisplay = document.getElementById('note-length');
            const productName = document.querySelector('h1.text-3xl.font-bold').textContent;
            const sizeInputs = contactForm.querySelectorAll('input[name="size"]');
            contactBtn.addEventListener('click', function () {
                modal.classList.remove('hidden');
            });
            closeBtn.addEventListener('click', function () {
                modal.classList.add('hidden');
                contactForm.reset();
            });
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    contactForm.reset();
                }
            });
            noteTextarea.addEventListener('input', function () {
                const length = this.value.length;
                noteLengthDisplay.textContent = length;
                if (length > 500) {
                    this.value = this.value.substring(0, 500);
                }
            });
            // contactForm.addEventListener('submit', function (e) {
            //     e.preventDefault();
            //     const selectedSize = contactForm.querySelector('input[name="size"]:checked').value;
            //     const formData = new FormData(this);
            //     formData.append('product', `${productName} (${selectedSize})`);
            //     const data = Object.fromEntries(formData.entries());
            //     console.log('Form data:', data);
            //     const successMessage = document.createElement('div');
            //     successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
            //     successMessage.textContent = 'Yêu cầu của bạn đã được gửi thành công!';
            //     document.body.appendChild(successMessage);
            //     modal.classList.add('hidden');
            //     contactForm.reset();
            //     setTimeout(() => {
            //         successMessage.remove();
            //     }, 3000);
            // });
        });
    </script>
</body>
</html>