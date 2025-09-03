<?php
include('../config/db_connection.php');
$sql1= "SELECT `news_id`, `news_name`,`new_summary`,`news_img`, `outstanding`,`news_author`,`create_time`,`slug`,`news_content` FROM `news`";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$sql = "SELECT * FROM news WHERE news_id = $id";
$result = $conn->query($sql);
$result_list = $conn->query($sql1);


if ($result->num_rows > 0) {
    $news = $result->fetch_assoc();
} else {
    echo "Bài viết không tồn tại!";
    exit;
}
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
    <title>Ký kết hợp tác chiến lược với 5 nhà phân phối tại châu Âu - Gạo sạch 3 miền</title>
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
        <article class="max-w-4xl mx-auto px-4 py-12">
            <header class="mb-12">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium"><?php echo $news['news_id'];?></span>
                    <span class="text-gray-500"><?php echo $news['create_time']; ?></span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 leading-tight"><?php echo $news['news_name']; ?></h1>
                <div class="flex items-center gap-6 text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="ri-user-line text-lg"></i>
                        <span><?php echo $news['news_author']; ?></span>
                    </div>
                    
                </div>
            </header>
            <div class="mb-12">
                <img src="..<?php echo $news['news_img']; ?>"
                    alt="Hinh ảnh bài viết"
                    class="w-full h-96 object-cover object-top rounded-xl shadow-lg">
            </div>
            <div class="prose prose-lg max-w-none">
                <p class="text-2xl text-gray-700 mb-8 leading-relaxed"><?php echo $news['news_content']; ?></p>
               
            <div class="flex items-center justify-between py-8 border-t border-gray-200 mt-12">
                
            </div>
        </article>
        <section class="bg-gray-50 py-16">
    <<div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Bài viết liên quan</h2>

    <?php
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $related_posts = [];
    if ($result_list && $result_list->num_rows > 0) {
        $related_posts = $result_list->fetch_all(MYSQLI_ASSOC);
    }

    if (!empty($related_posts)) {
        echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">';
        foreach ($related_posts as $news_item) {
            if ($news_item['news_id'] == $id) {
                continue; 
            }
    ?>
            <article
                class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 h-full flex flex-col">
                <img src="..<?php echo htmlspecialchars($news_item['news_img']); ?>"
                    alt="Hình ảnh bài viết" class="w-full h-48 object-cover object-top">
                <div class="p-6 flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo htmlspecialchars($news_item['news_id']); ?>
                        </span>
                        <span class="text-gray-500 text-sm">
                            <?php echo htmlspecialchars($news_item['create_time']); ?>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                        <?php echo htmlspecialchars($news_item['news_name']); ?>
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 flex-1">
                        <?php echo htmlspecialchars($news_item['new_summary']); ?>
                    </p>
                    <div class="mt-auto">
                        <a href="detail_new.php?id=<?php echo htmlspecialchars($news_item['news_id']); ?>"
                           class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors text-center">
                            Đọc thêm
                        </a>
                    </div>
                </div>
            </article>
    <?php
        }
        echo '</div>';
    } else {
        echo "<p class='text-gray-600 text-center'>Không có bài viết liên quan.</p>";
    }
    ?>
</div>

</section>
    </main>
    <?php
    include ('../includes/footer_child.php');
    include ('../includes/cta_child.php');
    ?>
</body>

</html>