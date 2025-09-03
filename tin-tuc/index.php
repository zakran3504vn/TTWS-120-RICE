<?php
include '../config/db_connection.php';
$sql= "SELECT `news_id`,`news_name`,`new_summary`,`news_img`,`news_author`,`create_time` FROM `news`";
$result = $conn->query($sql);
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
    <title>Tin Tức - Gạo sạch 3 miền</title>
    <link rel="icon" type="image/png" href="../assets/logo/logo-gao-sach-3-mien.png">
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
     $current_page = 'news';
     include ("../includes/header_child.php");
    ?>
    <main class="pt-24">
        <section class="py-16 bg-gradient-to-br from-green-50 to-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h1 class="text-5xl font-bold text-gray-800 mb-6">Tin Tức</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Cập nhật những thông tin mới nhất về công ty, sản
                        phẩm và thị trường gạo Việt Nam</p>
                </div>
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" id="news-search" placeholder="Tìm kiếm tin tức..."
                            class="w-full px-6 py-4 pr-16 text-lg border-2 border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 shadow-lg">
                        <button
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            <i class="ri-search-line text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="<?php echo "..". $row['news_img']; ?>" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">Admin</span>
                                <span class="text-gray-500 text-sm"><?php echo date("d M, Y", strtotime($row['create_time'])); ?></span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2"><?php echo $row['news_name'];?></h3>
                            <p class="text-gray-600 mb-4 line-clamp-3"><?php echo $row['new_summary'];?></p>
                            <a href="./detail_new.php?id=<?php echo $row['news_id']; ?>"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <?php
                    endwhile;
                    ?>

                    
                </div>
                <div class="flex justify-center mt-12">
                    <div class="flex items-center gap-2">
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                            <i class="ri-arrow-left-line"></i>
                        </button>
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white">1</button>
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">2</button>
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">3</button>
                        <span class="px-2">...</span>
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">10</button>
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                            <i class="ri-arrow-right-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include ('../includes/footer_child.php');
    include ('../includes/cta_child.php');
    ?>
    <script id="search-functionality">
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('news-search');
            const articles = document.querySelectorAll('article');
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                articles.forEach(article => {
                    const title = article.querySelector('h3').textContent.toLowerCase();
                    const content = article.querySelector('p').textContent.toLowerCase();
                    if (title.includes(searchTerm) || content.includes(searchTerm)) {
                        article.style.display = 'block';
                    } else {
                        article.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>