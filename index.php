<?php
include('./config/db_connection.php');
$sql1= "SELECT `CategoryID`, `CategoryName`,`isTop`,`CreatedAt`, `description`,`CategoryImg` FROM `category`";
$categories = $conn->query($sql1);
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        @media (max-width: 1024px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        @media (max-width: 768px) {
            html {
                font-size: 14px;
            }
        }

        @media (max-width: 640px) {
            html {
                font-size: 12px;
            }
        }
    </style>
    <title>Gạo sạch 3 miền - Chất lượng tạo nên thương hiệu</title>
    <link rel="icon" type="image/png" href="./assets/logo/logo-gao-sach-3-mien.png">
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

        .gradient-bg {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
        }
    </style>
</head>

<body class="bg-white">
    <?php
    $current_page = 'home';
    include("./includes/header.php");
    ?>
    <main>
        <section class="relative pt-24 pb-16 overflow-hidden"
            style="background-image: url('./assets/imgs/5fc56152144c192ac4f5e9402ad69ab0.jpg'); background-size: cover; background-position: center;">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center min-h-[600px]">
                    <div>
                        <style>
                            .animated-title {
                                background: linear-gradient(120deg, #4CAF50, #8BC34A);
                                background-clip: text;
                                -webkit-background-clip: text;
                                -webkit-text-fill-color: transparent;
                                position: relative;
                                display: inline-block;
                            }

                            .animated-title::after {
                                content: 'Gạo sạch 3 miền';
                                position: absolute;
                                left: 0;
                                top: 0;
                                width: 0;
                                height: 100%;
                                background: linear-gradient(120deg, #4CAF50, #8BC34A);
                                background-clip: text;
                                -webkit-background-clip: text;
                                -webkit-text-fill-color: transparent;
                                animation: revealText 2s ease-out forwards;
                            }

                            @keyframes revealText {
                                from {
                                    width: 0;
                                }

                                to {
                                    width: 100%;
                                }
                            }

                            .fade-in {
                                opacity: 0;
                                animation: fadeIn 1s ease-out 1s forwards;
                            }

                            @keyframes fadeIn {
                                from {
                                    opacity: 0;
                                    transform: translateY(20px);
                                }

                                to {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }
                        </style>
                        <h1 class="text-5xl font-bold mb-6 animated-title">Gạo sạch 3 miền</h1>
                        <p class="text-xl text-gray-600 mb-8 fade-in">Chất Lượng Tạo Nên Thương Hiệu - Mang đến cho gia đình bạn những hạt gạo thơm ngon, dinh dưỡng nhất từ cánh đồng màu mỡ của Việt Nam.</p>
                        <div class="flex gap-4">
                            <button class="!rounded-button bg-primary text-white px-8 py-3 hover:bg-primary/90">Khám phá ngay</button>
                            <button class="!rounded-button border-2 border-primary text-primary px-8 py-3 hover:bg-primary/10">Tìm hiểu thêm</button>
                        </div>
                    </div>
                    <div class="relative">
                        <div id="hero-slider" class="overflow-hidden rounded-2xl shadow-2xl">
                            <div class="flex transition-transform duration-500">
                                <div class="w-full flex-shrink-0">
                                    <img src="./assets/imgs/17e112aef0194f90969a1f2f16374cf6.jpg"
                                        alt="Gạo ST25 Premium" class="w-full object-cover">
                                </div>
                                <div class="w-full flex-shrink-0">
                                    <img src="./assets/imgs/c48ead5840db5239a629c6076cf29f72.jpg"
                                        alt="Gạo Lứt Hữu Cơ" class="w-full object-cover">
                                </div>
                                <div class="w-full flex-shrink-0">
                                    <img src="./assets/imgs/b059eb272fe52caba7e39f5dd028435d.jpg"
                                        alt="Gạo Japonica" class="w-full object-cover">
                                </div>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                            <button class="w-3 h-3 rounded-full bg-white/50 slider-dot" data-index="0"></button>
                            <button class="w-3 h-3 rounded-full bg-white/50 slider-dot" data-index="1"></button>
                            <button class="w-3 h-3 rounded-full bg-white/50 slider-dot" data-index="2"></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script id="hero-slider-script">
            document.addEventListener('DOMContentLoaded', function () {
                const slider = document.querySelector('#hero-slider .flex');
                const dots = document.querySelectorAll('.slider-dot');
                let currentIndex = 0;
                function updateSlider(index) {
                    slider.style.transform = `translateX(-${index * 100}%)`;
                    dots.forEach((dot, i) => {
                        dot.style.backgroundColor = i === index ? 'rgba(255, 255, 255, 0.9)' : 'rgba(255, 255, 255, 0.5)';
                    });
                }
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        currentIndex = index;
                        updateSlider(currentIndex);
                    });
                });
                function autoSlide() {
                    currentIndex = (currentIndex + 1) % 3;
                    updateSlider(currentIndex);
                }
                setInterval(autoSlide, 5000);
                updateSlider(0);
            });
        </script>
        <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 text-primary">Danh Mục Sản Phẩm</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">

            <?php foreach ($categories as $category): ?>
                <a href="san-pham/detail_product.php?category_id=<?php echo $category['CategoryID']; ?>" class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-white shadow-lg p-4 flex items-center justify-center">
                        <img src="./admin/assets/img/<?php echo $category['CategoryImg']; ?>" 
                             alt="<?php echo $category['CategoryName']; ?>" 
                             class="w-full h-full object-cover rounded-full">
                    </div>
                    <h3 class="font-semibold mb-2 text-2xl"><?php echo $category['CategoryName']; ?></h3>
                    <p class="text-xl text-gray-600"><?php echo $category['description']; ?></p>
                </a>
            <?php endforeach; ?>

        </div>
    </div>
</section>



        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl text-primary font-bold text-center mb-12">Sản Phẩm Nổi Bật</h2>
                <?php
                // Truy vấn sản phẩm nổi bật cho phần đầu tiên
                $resultproducts = $conn->query("SELECT product_id, product_img AS image, product_name AS name, product_description AS description, product_price AS price FROM products WHERE product_features = 1");
                if ($resultproducts === false) {
                    echo "<p class='text-red-500 text-center'>Lỗi truy vấn: " . htmlspecialchars($conn->error) . "</p>";
                } else if ($resultproducts->num_rows === 0) {
                    echo "<p class='text-gray-600 text-center'>Không có sản phẩm nổi bật.</p>";
                } else {
                ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($row = $resultproducts->fetch_assoc()): ?>
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                <img src="./admin/assets/img/<?= $row['image']; ?>"
                                     alt="<?php echo htmlspecialchars($row['name']); ?>"
                                     class="w-full h-auto object-cover">
                                <div class="p-6">
                                    <h3 class="text-2xl font-semibold mb-2"><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <p class="text-gray-600 mb-4 text-xl">
                                        <?= nl2br(strip_tags($row['description'])); ?>
                                    </p>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex flex-col">
                                            <span class="text-primary font-bold text-2xl">
                                                <?php echo number_format($row['price'], 0, ',', '.') . '₫'; ?>
                                            </span>
                                        </div>
                                        <a href="./san-pham/detail_product.php?id=<?php echo $row['product_id']; ?>"
                                           class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 text-2xl">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
        <!-- <section class="py-24 wave-bg text-white">
            <div class="container mx-auto px-4">
                <style>
                    .wave-bg::before {
                        content: '';
                        position: absolute;
                        width: 200%;
                        height: 200%;
                        top: -50%;
                        left: -50%;
                        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 60%);
                        animation: rotate 20s linear infinite;
                    }

                    @keyframes rotate {
                        from {
                            transform: rotate(0deg);
                        }

                        to {
                            transform: rotate(360deg);
                        }
                    }

                    .story-card {
                        backdrop-filter: blur(8px);
                        background: rgba(255, 255, 255, 0.1);
                        border: 1px solid rgba(255, 255, 255, 0.2);
                    }
                </style>
                <div class="relative z-10">
          <div class="container mx-auto px-4">
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold text-center mb-4">Câu Chuyện Thương Hiệu</h2>
                    <p class="text-lg text-center mb-16 max-w-3xl mx-auto text-white/90">Khám phá hành trình 20 năm phát
                        triển và những giá trị bền vững mà chúng tôi mang đến cho ngành gạo Việt Nam</p>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="space-y-8">
                            <div class="story-card p-8 rounded-lg">
                                <h3 class="text-2xl font-bold mb-6 flex items-center">
                                    <i class="ri-award-line text-3xl mr-3"></i>
                                    Gạo Sạch 3 Miền, Hành Trình 20 Năm Phát Triển
                                </h3>
                                <p class="text-2xl font-semibold mb-6 leading-relaxed">Từ những cánh đồng lúa màu mỡ của
                                    ba miền Bắc - Trung - Nam, Gạo sạch 3 miền tự hào mang đến cho người tiêu dùng những
                                    hạt gạo thơm ngon nhất, được chọn lọc kỹ càng và đảm bảo vệ sinh an toàn thực phẩm.
                                </p>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="story-card p-4 rounded-lg text-center">
                                        <i class="ri-timer-line text-3xl mb-2"></i>
                                        <h4 class="font-bold mb-1">20 Năm</h4>
                                        <p class="text-sm text-white/80">Kinh nghiệm</p>
                                    </div>
                                    <div class="story-card p-4 rounded-lg text-center">
                                        <i class="ri-team-line text-3xl mb-2"></i>
                                        <h4 class="font-bold mb-1">10,000+</h4>
                                        <p class="text-sm text-white/80">Nông hộ hợp tác</p>
                                    </div>
                                    <div class="story-card p-4 rounded-lg text-center">
                                        <i class="ri-global-line text-3xl mb-2"></i>
                                        <h4 class="font-bold mb-1">30+</h4>
                                        <p class="text-sm text-white/80">Quốc gia xuất khẩu</p>
                                    </div>
                                    <div class="story-card p-4 rounded-lg text-center">
                                        <i class="ri-medal-line text-3xl mb-2"></i>
                                        <h4 class="font-bold mb-1">15+</h4>
                                        <p class="text-sm text-white/80">Giải thưởng quốc tế</p>
                                    </div>
                                </div>
                                <div class="mt-8">
                                    <a href="#"
                                        class="!rounded-button bg-white text-primary px-8 py-3 hover:bg-white/90 shadow-lg transition-transform hover:scale-105">
                                        <i class="ri-arrow-right-line mr-2"></i>
                                        Tìm hiểu thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="w-full aspect-video">
                                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen
                                    class="w-full h-full rounded-xl shadow-lg"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl text-primary font-bold text-center mb-12">Đối Tác Của Chúng Tôi</h2>
                <div class="flex flex-col items-center">
                    <div class="flex justify-center gap-12 mb-16 flex-wrap">
                        <div
                            class="partner-logo w-32 h-32 bg-white shadow-lg rounded-lg flex items-center justify-center">
                            <i class="ri-shopping-cart-2-fill text-4xl text-gray-600"></i>
                            <span class="ml-2 font-semibold">BigC</span>
                        </div>
                        <div
                            class="partner-logo w-32 h-32 bg-white shadow-lg rounded-lg flex items-center justify-center">
                            <i class="ri-store-2-fill text-4xl text-gray-600"></i>
                            <span class="ml-2 font-semibold">VinMart</span>
                        </div>
                        <div
                            class="partner-logo w-32 h-32 bg-white shadow-lg rounded-lg flex items-center justify-center">
                            <i class="ri-shop-fill text-4xl text-gray-600"></i>
                            <span class="ml-2 font-semibold">CoopMart</span>
                        </div>
                        <div
                            class="partner-logo w-32 h-32 bg-white shadow-lg rounded-lg flex items-center justify-center">
                            <i class="ri-shopping-bag-fill text-4xl text-gray-600"></i>
                            <span class="ml-2 font-semibold">Aeon</span>
                        </div>
                    </div>
                    <h2 class="text-4xl text-primary font-bold text-center mb-12">Báo Chí Nói Về Chúng Tôi</h2>
                    <div class="grid grid-cols-3 gap-8 max-w-4xl">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center mb-4">
                                <i class="ri-newspaper-fill text-3xl text-primary mr-3"></i>
                                <span class="font-semibold">VnExpress</span>
                            </div>
                            <p class="text-gray-600">"Gạo sạch 3 miền - Thương hiệu gạo Việt Nam được tin dùng tại thị
                                trường Châu Âu"</p>
                            <p class="text-sm text-gray-500 mt-4">Tháng 8, 2023</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center mb-4">
                                <i class="ri-article-fill text-3xl text-primary mr-3"></i>
                                <span class="font-semibold">Tuổi Trẻ</span>
                            </div>
                            <p class="text-gray-600">"Công nghệ hiện đại trong sản xuất gạo sạch - Mô hình kiểu mẫu từ
                                Gạo sạch 3 miền"</p>
                            <p class="text-sm text-gray-500 mt-4">Tháng 6, 2023</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center mb-4">
                                <i class="ri-file-paper-2-fill text-3xl text-primary mr-3"></i>
                                <span class="font-semibold">Thanh Niên</span>
                            </div>
                            <p class="text-gray-600">"Gạo sạch 3 miền được vinh danh Top 10 thương hiệu gạo uy tín năm
                                2023"</p>
                            <p class="text-sm text-gray-500 mt-4">Tháng 7, 2023</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include ('./includes/footer.php');
    include ('./includes/cta.php');
    ?>
</body>

</html>