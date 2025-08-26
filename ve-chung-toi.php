<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về chúng tôi - Gạo sạch 3 miền</title>
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

        .wave-section {
            background: #ffffff !important;
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #4CAF50, #8BC34A);
            transform: translateX(-50%);
        }

        @media (max-width: 768px) {
            .timeline-line {
                left: 20px;
            }

            .timeline-dot {
                left: 20px !important;
            }
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            width: 16px;
            height: 16px;
            background: #4CAF50;
            border: 4px solid white;
            border-radius: 50%;
            transform: translateX(-50%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            max-height: 200px;
        }
    </style>
</head>

<body class="bg-white">
    <?php
     $current_page = 'about';
     include ("./includes/header.php");
    ?>
    <main>
        <section class="relative pt-32 pb-16 overflow-hidden"
            style="background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);">
            <div class="absolute inset-0"
                style="background-image: url('./assets/imgs/f44e2c1ef19d23f525dcfa782e6ff402.jpg'); background-size: cover; background-position: center; opacity: 0.3;">
            </div>
            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-5xl font-bold mb-6 pt-6">Câu chuyện thương hiệu</h1>
                    <p class="text-xl max-w-3xl mx-auto leading-relaxed">Khám phá hành trình 20 năm phát triển và những
                        giá trị bền vững mà chúng tôi mang đến cho ngành gạo Việt Nam</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-16"
                style="background: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1200 120\'%3E%3Cpath d=\'M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z\' fill=\'%23ffffff\'%3E%3C/path%3E%3C/svg%3E') no-repeat; background-size: cover; transform: rotate(180deg);">
            </div>
        </section>
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="grid md:grid-cols-2 grid-cols-1 gap-8 md:gap-16 items-center">
                    <div>
                        <img src="https://readdy.ai/api/search-image?query=Beautiful%20Vietnamese%20rice%20terraces%20with%20traditional%20farming%20methods%2C%20farmers%20working%20in%20the%20fields%2C%20lush%20green%20landscape%2C%20mountains%20and%20valleys%2C%20golden%20hour%20lighting%2C%20peaceful%20rural%20scene%2C%20professional%20landscape%20photography&width=600&height=500&seq=22&orientation=landscape"
                            alt="Cánh đồng lúa" class="w-full rounded-2xl shadow-lg">
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold mb-8 text-primary">Giới thiệu công ty</h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">Gạo sạch 3 miền được thành lập từ năm 2003
                            với sứ mệnh mang đến những hạt gạo chất lượng cao nhất từ ba miền Bắc - Trung - Nam của Việt
                            Nam. Chúng tôi tự hào là một trong những thương hiệu gạo uy tín hàng đầu với hơn 20 năm kinh
                            nghiệm trong ngành.</p>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">Với quy trình sản xuất khép kín từ khâu
                            gieo trồng đến chế biến và đóng gói, chúng tôi đảm bảo mỗi hạt gạo đều đạt tiêu chuẩn chất
                            lượng cao nhất. Sản phẩm của chúng tôi không chỉ được tin dùng tại thị trường trong nước mà
                            còn xuất khẩu đến hơn 30 quốc gia trên thế giới.</p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <h3 class="text-3xl font-bold text-primary mb-2">20+</h3>
                                <p class="text-gray-600">Năm kinh nghiệm</p>
                            </div>
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <h3 class="text-3xl font-bold text-primary mb-2">10,000+</h3>
                                <p class="text-gray-600">Nông hộ hợp tác</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 wave-section bg-[#FFFAF0]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">Tầm nhìn & Sứ mệnh</h2>
                </div>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-8 md:gap-16">
                    <div class="bg-white p-6 md:p-12 rounded-2xl shadow-lg">
                        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mb-8">
                            <i class="ri-eye-line text-3xl text-primary"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-6 text-gray-800">Tầm nhìn</h3>
                        <p class="text-lg text-gray-600 leading-relaxed">Trở thành thương hiệu gạo hàng đầu Việt Nam và
                            khu vực Đông Nam Á, được công nhận về chất lượng sản phẩm và trách nhiệm xã hội. Chúng tôi
                            hướng tới việc nâng cao giá trị nông sản Việt Nam trên thị trường quốc tế.</p>
                    </div>
                    <div class="bg-white p-12 rounded-2xl shadow-lg">
                        <div class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center mb-8">
                            <i class="ri-heart-line text-3xl text-secondary"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-6 text-gray-800">Sứ mệnh</h3>
                        <p class="text-lg text-gray-600 leading-relaxed">Cung cấp những sản phẩm gạo chất lượng cao, an
                            toàn và dinh dưỡng cho người tiêu dùng. Đồng thời hỗ trợ nông dân nâng cao thu nhập và áp
                            dụng kỹ thuật canh tác bền vững, góp phần phát triển nông nghiệp Việt Nam.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-[#F0F9FF]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">Lịch sử hình thành</h2>
                </div>
                <div class="relative max-w-4xl mx-auto">
                    <div class="timeline-line"></div>
                    <div class="space-y-16">
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot md:top-1/2 top-0"></div>
                            <div class="md:text-right md:pr-8 pl-8 md:pl-0">
                                <div class="bg-primary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">1990</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Khởi đầu từ những cánh đồng lúa</h3>
                                <p class="text-gray-600">Bắt đầu với việc canh tác lúa tại vùng đồng bằng sông Cửu Long,
                                    tập trung vào chất lượng và an toàn thực phẩm.</p>
                            </div>
                            <div class="hidden md:block"></div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot md:top-1/2 top-0"></div>
                            <div class="hidden md:block"></div>
                            <div class="pl-8">
                                <div class="bg-secondary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">2003</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Thành lập công ty Gạo sạch 3 miền</h3>
                                <p class="text-gray-600">Chính thức thành lập công ty với tầm nhìn mang gạo Việt Nam ra
                                    thế giới.</p>
                            </div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot" style="top: 50%;"></div>
                            <div class="text-right pr-8">
                                <div class="bg-primary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">2010</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Mở rộng quy mô sản xuất</h3>
                                <p class="text-gray-600">Đầu tư nhà máy chế biến hiện đại và mở rộng vùng nguyên liệu ra
                                    cả 3 miền.</p>
                            </div>
                            <div></div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot" style="top: 50%;"></div>
                            <div></div>
                            <div class="pl-8">
                                <div class="bg-secondary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">2015</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Đạt chứng nhận quốc tế</h3>
                                <p class="text-gray-600">Nhận được các chứng nhận HACCP, ISO 22000 và bắt đầu xuất khẩu.
                                </p>
                            </div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot" style="top: 50%;"></div>
                            <div class="text-right pr-8">
                                <div class="bg-primary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">2018</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Phát triển gạo hữu cơ</h3>
                                <p class="text-gray-600">Ra mắt dòng sản phẩm gạo hữu cơ đạt tiêu chuẩn quốc tế.</p>
                            </div>
                            <div></div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot" style="top: 50%;"></div>
                            <div></div>
                            <div class="pl-8">
                                <div class="bg-secondary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">2020</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Ứng dụng công nghệ 4.0</h3>
                                <p class="text-gray-600">Đầu tư hệ thống quản lý chất lượng và truy xuất nguồn gốc hiện
                                    đại.</p>
                            </div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot" style="top: 50%;"></div>
                            <div class="text-right pr-8">
                                <div class="bg-primary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">2023</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Mở rộng thị trường quốc tế</h3>
                                <p class="text-gray-600">Xuất khẩu đến hơn 30 quốc gia và nhận nhiều giải thưởng uy tín.
                                </p>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 wave-section bg-[#F3FFF0]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">Yếu tố tạo nên Gạo sạch 3 miền
                    </h2>
                </div>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-8 md:gap-16 items-center">
                    <div class="space-y-4 md:space-y-6">
                        <div class="accordion-item bg-white rounded-lg shadow-sm">
                            <button
                                class="accordion-header w-full p-6 text-left flex items-center justify-between hover:bg-primary/5 rounded-lg transition-all duration-300"
                                data-target="accordion-1">
                                <span class="text-lg font-semibold text-gray-800">Nguồn gốc xuất xứ rõ ràng</span>
                                <i
                                    class="ri-arrow-down-s-line text-xl text-primary transform transition-transform duration-300"></i>
                            </button>
                            <div id="accordion-1" class="accordion-content px-6 pb-6">
                                <p class="text-gray-600">Gạo được trồng tại những vùng đất màu mỡ nhất của ba miền Bắc -
                                    Trung - Nam, đảm bảo nguồn gốc xuất xứ rõ ràng và có thể truy xuất được.</p>
                            </div>
                        </div>
                        <div class="accordion-item bg-white rounded-lg shadow-sm">
                            <button
                                class="accordion-header w-full p-6 text-left flex items-center justify-between hover:bg-primary/5 rounded-lg transition-all duration-300"
                                data-target="accordion-2">
                                <span class="text-lg font-semibold text-gray-800">Quy trình sản xuất khép kín</span>
                                <i
                                    class="ri-arrow-down-s-line text-xl text-primary transform transition-transform duration-300"></i>
                            </button>
                            <div id="accordion-2" class="accordion-content px-6 pb-6">
                                <p class="text-gray-600">Từ khâu gieo trồng, chăm sóc, thu hoạch đến chế biến và đóng
                                    gói đều được kiểm soát chặt chẽ theo quy trình khép kín.</p>
                            </div>
                        </div>
                        <div class="accordion-item bg-white rounded-lg shadow-sm">
                            <button
                                class="accordion-header w-full p-6 text-left flex items-center justify-between hover:bg-primary/5 rounded-lg transition-all duration-300"
                                data-target="accordion-3">
                                <span class="text-lg font-semibold text-gray-800">Công nghệ chế biến hiện đại</span>
                                <i
                                    class="ri-arrow-down-s-line text-xl text-primary transform transition-transform duration-300"></i>
                            </button>
                            <div id="accordion-3" class="accordion-content px-6 pb-6">
                                <p class="text-gray-600">Sử dụng công nghệ chế biến tiên tiến nhất từ Nhật Bản và Châu
                                    Âu để đảm bảo chất lượng sản phẩm tốt nhất.</p>
                            </div>
                        </div>
                        <div class="accordion-item bg-white rounded-lg shadow-sm">
                            <button
                                class="accordion-header w-full p-6 text-left flex items-center justify-between hover:bg-primary/5 rounded-lg transition-all duration-300"
                                data-target="accordion-4">
                                <span class="text-lg font-semibold text-gray-800">Kiểm tra chất lượng nghiêm ngặt</span>
                                <i
                                    class="ri-arrow-down-s-line text-xl text-primary transform transition-transform duration-300"></i>
                            </button>
                            <div id="accordion-4" class="accordion-content px-6 pb-6">
                                <p class="text-gray-600">Mỗi lô hàng đều được kiểm tra chất lượng tại phòng thí nghiệm
                                    hiện đại với các tiêu chuẩn quốc tế.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="https://readdy.ai/api/search-image?query=Modern%20rice%20processing%20facility%20with%20advanced%20machinery%2C%20clean%20industrial%20environment%2C%20quality%20control%20processes%2C%20workers%20in%20protective%20gear%2C%20stainless%20steel%20equipment%2C%20professional%20food%20processing%20plant&width=600&height=500&seq=23&orientation=landscape"
                            alt="Nhà máy chế biến" class="w-full rounded-2xl shadow-lg">
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-[#FFF5F0]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">Chứng nhận và giải thưởng</h2>
                </div>
                <div class="grid md:grid-cols-3 grid-cols-1 gap-8 max-w-4xl mx-auto">
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-32 h-40 mx-auto mb-6 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="ri-award-line text-5xl text-blue-600"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Chứng nhận HACCP</h3>
                        <p class="text-gray-600 text-sm">Hệ thống phân tích mối nguy và điểm kiểm soát tới hạn</p>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-32 h-40 mx-auto mb-6 bg-green-50 rounded-lg flex items-center justify-center">
                            <i class="ri-shield-check-line text-5xl text-green-600"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-2">ISO 22000</h3>
                        <p class="text-gray-600 text-sm">Hệ thống quản lý an toàn thực phẩm quốc tế</p>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
                        <div class="w-32 h-40 mx-auto mb-6 bg-orange-50 rounded-lg flex items-center justify-center">
                            <i class="ri-medal-line text-5xl text-orange-600"></i>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Top 10 Thương hiệu</h3>
                        <p class="text-gray-600 text-sm">Thương hiệu gạo uy tín nhất Việt Nam 2023</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 wave-section bg-[#F0FFF9]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">Quy trình sản xuất</h2>
                </div>
                <div class="grid grid-cols-2 gap-16 items-center">
                    <div>
                        <img src="https://readdy.ai/api/search-image?query=Step%20by%20step%20rice%20production%20process%20from%20farming%20to%20packaging%2C%20modern%20agricultural%20techniques%2C%20quality%20control%20stages%2C%20clean%20processing%20environment%2C%20professional%20documentation%20style&width=600&height=500&seq=24&orientation=landscape"
                            alt="Quy trình sản xuất" class="w-full rounded-2xl shadow-lg">
                    </div>
                    <div class="text-gray-700 space-y-8">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-lg">1</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Gieo trồng và chăm sóc</h3>
                                <p class="text-white/90">Sử dụng giống lúa chất lượng cao, áp dụng kỹ thuật canh tác
                                    tiên tiến</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-lg">2</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Thu hoạch đúng thời điểm</h3>
                                <p class="text-white/90">Thu hoạch khi lúa đạt độ chín tối ưu để đảm bảo chất lượng</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-lg">3</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Sấy và bảo quản</h3>
                                <p class="text-white/90">Sấy khô đúng tiêu chuẩn và bảo quản trong điều kiện tối ưu</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-lg">4</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Chế biến và đóng gói</h3>
                                <p class="text-white/90">Xay xát bằng công nghệ hiện đại và đóng gói theo tiêu chuẩn
                                    xuất khẩu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-[#F5FFF0]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">Trách nhiệm xã hội</h2>
                </div>
                <div class="grid md:grid-cols-3 grid-cols-1 gap-8">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ri-community-line text-3xl text-primary"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Hỗ trợ nông dân</h3>
                        <p class="text-gray-600">Cung cấp giống lúa chất lượng cao và hướng dẫn kỹ thuật canh tác cho
                            hơn 10,000 nông hộ</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ri-leaf-line text-3xl text-secondary"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Bảo vệ môi trường</h3>
                        <p class="text-gray-600">Áp dụng canh tác hữu cơ và các biện pháp thân thiện với môi trường</p>
                    </div>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="ri-graduation-cap-line text-3xl text-primary"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Giáo dục cộng đồng</h3>
                        <p class="text-gray-600">Tổ chức các chương trình đào tạo và nâng cao nhận thức về an toàn thực
                            phẩm</p>
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