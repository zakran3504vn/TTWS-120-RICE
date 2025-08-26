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
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Modern%20rice%20processing%20factory%20with%20advanced%20technology%20equipment%20and%20workers%20in%20protective%20gear%2C%20showcasing%20quality%20control%20and%20food%20safety%20standards%20in%20Vietnamese%20rice%20industry&width=400&height=250&seq=21&orientation=landscape"
                            alt="Công nghệ chế biến gạo hiện đại" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">Tin
                                    Công Ty</span>
                                <span class="text-gray-500 text-sm">15 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Gạo sạch 3 miền đầu tư dây
                                chuyền sản xuất hiện đại trị giá 50 tỷ đồng</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Công ty vừa khánh thành nhà máy chế biến gạo tự
                                động hoàn toàn với công nghệ Nhật Bản, nâng cao chất lượng sản phẩm và đáp ứng nhu cầu
                                xuất khẩu ngày càng tăng.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Premium%20ST25%20rice%20variety%20in%20elegant%20packaging%20displayed%20at%20international%20food%20exhibition%20with%20awards%20and%20certificates%2C%20highlighting%20Vietnamese%20rice%20quality%20recognition&width=400&height=250&seq=22&orientation=landscape"
                            alt="Gạo ST25 đạt giải thưởng quốc tế" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-gray-500 text-sm">12 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Gạo ST25 Harmony giành giải
                                vàng tại triển lãm thực phẩm quốc tế</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Sản phẩm gạo ST25 Harmony của công ty đã được Ban
                                giám khảo đánh giá cao về chất lượng và hương vị, khẳng định vị thế gạo Việt trên thị
                                trường thế giới.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Vietnamese%20rice%20export%20containers%20at%20modern%20port%20facility%20with%20ships%20and%20cranes%2C%20showing%20the%20scale%20of%20rice%20export%20industry%20and%20international%20trade&width=400&height=250&seq=23&orientation=landscape"
                            alt="Xuất khẩu gạo Việt Nam" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-medium">Thị
                                    Trường Gạo</span>
                                <span class="text-gray-500 text-sm">10 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Xuất khẩu gạo Việt Nam tăng
                                15% trong năm 2023</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Theo báo cáo của Hiệp hội Lương thực Việt Nam,
                                kim ngạch xuất khẩu gạo năm 2023 đạt kỷ lục mới với 4.2 tỷ USD, trong đó gạo chất lượng
                                cao chiếm tỷ trọng ngày càng lớn.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Organic%20rice%20farming%20in%20Vietnam%20with%20farmers%20using%20sustainable%20methods%2C%20green%20rice%20fields%20and%20eco-friendly%20practices%2C%20showing%20environmental%20responsibility&width=400&height=250&seq=24&orientation=landscape"
                            alt="Canh tác gạo hữu cơ" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-gray-500 text-sm">8 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Ra mắt dòng gạo hữu cơ được
                                chứng nhận quốc tế</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Gạo sạch 3 miền chính thức giới thiệu dòng sản
                                phẩm gạo hữu cơ đạt chứng nhận USDA Organic và EU Organic, đáp ứng nhu cầu tiêu dùng
                                xanh ngày càng tăng.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Vietnamese%20rice%20company%20executives%20signing%20partnership%20agreement%20with%20international%20distributors%20in%20modern%20office%20setting%2C%20representing%20business%20expansion&width=400&height=250&seq=25&orientation=landscape"
                            alt="Hợp tác quốc tế" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">Tin
                                    Công Ty</span>
                                <span class="text-gray-500 text-sm">5 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Ký kết hợp tác chiến lược với
                                5 nhà phân phối tại châu Âu</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Công ty vừa hoàn tất việc ký kết các thỏa thuận
                                hợp tác dài hạn với các đối tác phân phối hàng đầu tại Đức, Pháp, Hà Lan, Bỉ và Áo.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Rice%20price%20analysis%20chart%20and%20market%20data%20displayed%20on%20computer%20screens%20in%20trading%20room%2C%20showing%20agricultural%20commodity%20market%20trends&width=400&height=250&seq=26&orientation=landscape"
                            alt="Phân tích thị trường gạo" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-medium">Thị
                                    Trường Gạo</span>
                                <span class="text-gray-500 text-sm">3 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Giá gạo xuất khẩu Việt Nam duy
                                trì ổn định trong quý IV</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Theo khảo sát thị trường, giá gạo xuất khẩu Việt
                                Nam tiếp tục duy trì mức ổn định nhờ chất lượng được cải thiện và nhu cầu nhập khẩu từ
                                các thị trường truyền thống.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Vietnamese%20farmers%20participating%20in%20agricultural%20training%20program%20with%20modern%20farming%20techniques%2C%20showing%20knowledge%20transfer%20and%20capacity%20building&width=400&height=250&seq=27&orientation=landscape"
                            alt="Chương trình đào tạo nông dân" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">Tin
                                    Công Ty</span>
                                <span class="text-gray-500 text-sm">1 Tháng 12, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Khởi động chương trình đào tạo
                                kỹ thuật canh tác cho 2000 nông hộ</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Chương trình đào tạo miễn phí về kỹ thuật canh
                                tác hiện đại, sử dụng phân bón hữu cơ và quản lý dịch hại tổng hợp nhằm nâng cao năng
                                suất và chất lượng lúa gạo.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Research%20laboratory%20with%20scientists%20developing%20new%20rice%20varieties%2C%20modern%20equipment%20and%20rice%20samples%2C%20showing%20agricultural%20innovation%20and%20development&width=400&height=250&seq=28&orientation=landscape"
                            alt="Nghiên cứu giống gạo mới" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-gray-500 text-sm">28 Tháng 11, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Thành công trong nghiên cứu
                                giống gạo chống chịu hạn</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Sau 3 năm nghiên cứu, đội ngũ khoa học của công
                                ty đã phát triển thành công giống gạo mới có khả năng chống chịu hạn tốt, duy trì năng
                                suất cao trong điều kiện thiếu nước.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
                    <article
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="https://readdy.ai/api/search-image?query=Global%20rice%20market%20analysis%20with%20world%20map%20showing%20trade%20routes%20and%20statistical%20data%2C%20representing%20international%20rice%20trade%20and%20market%20dynamics&width=400&height=250&seq=29&orientation=landscape"
                            alt="Thị trường gạo thế giới" class="w-full h-48 object-cover object-top">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-medium">Thị
                                    Trường Gạo</span>
                                <span class="text-gray-500 text-sm">25 Tháng 11, 2023</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">Thị trường gạo thế giới dự báo
                                tăng trưởng mạnh trong năm 2024</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">Các chuyên gia dự báo nhu cầu gạo toàn cầu sẽ
                                tăng 3.5% trong năm 2024, tạo cơ hội lớn cho các nhà sản xuất gạo chất lượng cao như
                                Việt Nam.</p>
                            <a href="./detail_new.php"
                                data-readdy="true" class="inline-block">
                                <button
                                    class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
                                    Đọc thêm
                                </button>
                            </a>
                        </div>
                    </article>
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