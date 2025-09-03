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
                        <h2 class="text-3xl md:text-4xl font-bold mb-8 text-primary">Giới thiệu GẠO SẠCH 3 MIỀN</h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">GẠO SẠCH 3 MIỀN là đơn vị chuyên cung cấp các loại gạo chất lượng cao cho thị trường trong nước và quốc tế. Với nhiều năm kinh nghiệm trong lĩnh vực kinh doanh nông sản, đặc biệt là gạo, GẠO SẠCH 3 MIỀN tự hào là đối tác tin cậy của các công ty xuất khẩu, các cơ sở chế biến thực phẩm công nghiệp, nhà máy sản xuất cháo ăn liền và nhiều doanh nghiệp sản xuất thực phẩm quy mô lớn.</p>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">Chúng tôi cam kết mang đến nguồn gạo ổn định, đáp ứng các tiêu chuẩn về an toàn vệ sinh thực phẩm, truy xuất nguồn gốc rõ ràng, phù hợp với yêu cầu đa dạng của từng đối tác. Với hệ thống kho bãi và logistic chuyên nghiệp, GẠO SẠCH 3 MIỀN đảm bảo giao hàng đúng tiến độ, giữ vững chất lượng sản phẩm trong suốt quá trình cung ứng.</p>
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
                        <P class="text-lg text-gray-600 leading-relaxed">GẠO SẠCH 3 MIỀN – Đơn vị cung cấp gạo đạt tiêu chuẩn ISO 22000 về an toàn thực phẩm</P>
                        <p class="text-lg text-gray-600 leading-relaxed">Với định hướng phát triển bền vững và cam kết mang đến những sản phẩm chất lượng cao,
                            GẠO SẠCH 3 MIỀN tự hào là đơn vị đạt chứng nhận ISO 22000 – hệ thống quản lý an toàn thực phẩm theo tiêu chuẩn quốc tế.
                            Đây là minh chứng cho năng lực kiểm soát chất lượng nghiêm ngặt của GẠO SẠCH 3 MIỀN trong toàn bộ chuỗi cung ứng, 
                            từ khâu thu mua nguyên liệu, bảo quản, chế biến đến vận chuyển và giao hàng.</p>
                        <P class="text-lg text-gray-600 leading-relaxed">GẠO SẠCH 3 MIỀN – Đồng hành cùng giá trị bền vững từ hạt gạo Việt.</P>
                    </div>
                    <div class="bg-white p-12 rounded-2xl shadow-lg">
                        <div class="w-20 h-20 bg-secondary/10 rounded-full flex items-center justify-center mb-8">
                            <i class="ri-heart-line text-3xl text-secondary"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-6 text-gray-800">Sứ mệnh</h3>
                        <p class="text-lg text-gray-600 leading-relaxed">Việc đạt chuẩn ISO 22000 giúp GẠO SẠCH 3 MIỀN đáp ứng tốt yêu cầu của các đối tác trong nước và quốc tế, 
                            đặc biệt là các doanh nghiệp chế biến thực phẩm, nhà máy sản xuất suất ăn công nghiệp và các công ty xuất khẩu gạo. 
                            Từng hạt gạo GẠO SẠCH 3 MIỀN cung cấp đều đảm bảo an toàn – đồng nhất – truy xuất được nguồn gốc.</p>
                        <p class="text-lg text-gray-600 leading-relaxed">GẠO SẠCH 3 MIỀN – Gạo sạch, quy trình sạch, vì sức khỏe người tiêu dùng.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-20 bg-[#F0F9FF]">
            <div class="container mx-auto px-4 overflow-hidden">
                <div class="text-center mb-8 md:mb-16">
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 text-primary">GẠO SẠCH 3 MIỀN </h2>
                </div>
                <div class="relative max-w-4xl mx-auto">
                    <div class="timeline-line"></div>
                    <div class="space-y-16">
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot md:top-1/2 top-0"></div>
                            <div class="md:text-right md:pr-8 pl-8 md:pl-0">
                                <div class="bg-primary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">Gạo Trắng</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Dòng gạo chuyên dùng cho bếp ăn công nghiệp –
                                     Giải pháp tối ưu cho suất ăn số lượng lớn</h3>
                                <p class="text-gray-600">GẠO SẠCH 3 MIỀN cung cấp dòng gạo chất lượng ổn định, 
                                    được tuyển chọn kỹ lưỡng, đặc biệt phù hợp cho các bếp ăn công nghiệp như nhà máy, 
                                    khu chế xuất, trường học, bệnh viện và doanh nghiệp dịch vụ suất ăn. Gạo có đặc tính nở đều, 
                                    cơm mềm nhưng không nhão, giữ được độ ngon sau thời gian dài bảo quản trong nhiệt độ phòng, 
                                    đáp ứng yêu cầu về khẩu phần lớn và thời gian phục vụ kéo dài.</p>
                                <p class="text-gray-600">Với giá thành cạnh tranh, nguồn cung ổn định và khả năng giao hàng nhanh chóng, 
                                    dòng gạo công nghiệp của GẠO SẠCH 3 MIỀN giúp các đơn vị tối ưu chi phí mà vẫn đảm bảo chất lượng suất ăn.</p>
                            </div>
                            <div class="hidden md:block"></div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot md:top-1/2 top-0"></div>
                            <div class="hidden md:block"></div>
                            <div class="pl-8">
                                <div class="bg-secondary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">Gạo ST25</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Dòng gạo cao cấp cho những bữa ăn chất lượng vượt trội</h3>
                                <p class="text-gray-600">GẠO SẠCH 3 MIỀN tự hào cung cấp gạo ST25 – một trong những giống gạo ngon nhất thế giới, 
                                    được nghiên cứu và phát triển tại Sóc Trăng, Việt Nam. Với hạt gạo dài, 
                                    trắng trong, thơm tự nhiên, cơm dẻo mềm và vị ngọt thanh, ST25 không chỉ đáp ứng nhu cầu ẩm thực 
                                    cao cấp mà còn chinh phục được những khách hàng khó tính nhất.</p>
                                <p class="text-gray-600">Gạo ST25 của GẠO SẠCH 3 MIỀN được tuyển chọn kỹ lưỡng, đảm bảo chất lượng đồng đều, 
                                    không pha trộn, phù hợp cho các nhà hàng, khách sạn, 
                                    chuỗi suất ăn cao cấp và các doanh nghiệp xuất khẩu. Sản phẩm đáp ứng đầy đủ các tiêu chuẩn 
                                    an toàn thực phẩm và truy xuất nguồn gốc rõ ràng.</p>
                                <p class="text-gray-600">ST25 – Tinh hoa gạo Việt, nâng tầm bữa ăn Việt.</p>
                            </div>
                        </div>
                        <div class="relative grid md:grid-cols-2 grid-cols-1 gap-4 md:gap-8 items-center">
                            <div class="timeline-dot" style="top: 50%;"></div>
                            <div class="text-right pr-8">
                                <div class="bg-primary text-white px-4 py-2 rounded-full inline-block mb-4">
                                    <span class="font-bold">Gạo từ thiện</span>
                                </div>
                                <h3 class="text-xl font-bold mb-2 text-gray-800">Chia sẻ yêu thương từ những hạt gạo nghĩa tình</h3>
                                <p class="text-gray-600">GẠO SẠCH 3 MIỀN cung cấp dòng gạo chuyên dùng cho các chương trình từ thiện, 
                                    cứu trợ và hỗ trợ cộng đồng. Với tiêu chí giá thành hợp lý – chất lượng đảm bảo – nguồn cung ổn định,
                                     dòng gạo từ thiện của chúng tôi giúp các tổ chức, đoàn thể, chùa chiền, nhóm thiện nguyện và doanh nghiệp
                                      dễ dàng triển khai các hoạt động phát quà, nấu ăn, hỗ trợ người khó khăn một cách hiệu quả và bền vững.</p>
                                <p class="text-gray-600">Gạo được chọn lựa kỹ lưỡng, hạt đẹp, cơm nở vừa, không khô vụn, đảm bảo an toàn vệ sinh thực phẩm.
                                     GẠO SẠCH 3 MIỀN cam kết đồng hành cùng các hoạt động thiện nguyện bằng chính sự uy tín và trách nhiệm với cộng đồng.</p>
                                <p class="text-gray-600">GẠO SẠCH 3 MIỀN – Lan tỏa giá trị nhân văn qua từng hạt gạo.</p>
                            </div>
                            <div></div>
                        </div>
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