<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        @media (max-width: 1024px) {
            .container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 768px) {
            html {
                font-size: 14px;
            }

            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .py-16 {
                padding-top: 3rem;
                padding-bottom: 3rem;
            }

            .gap-12 {
                gap: 1.5rem;
            }

            .p-8 {
                padding: 1.25rem;
            }

            .text-4xl {
                font-size: 2rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            html {
                font-size: 12px;
            }

            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .grid-cols-1 {
                grid-template-columns: 1fr !important;
            }

            .py-16 {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }

            .gap-12 {
                gap: 1rem;
            }

            .p-8 {
                padding: 1rem;
            }

            .text-4xl {
                font-size: 1.75rem;
            }

            .text-2xl {
                font-size: 1.25rem;
            }
        }
    </style>
    <title>Liên hệ - Gạo sạch 3 miền</title>
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
     $current_page = 'contact';
     include ("../includes/header_child.php");
    ?>
    <main class="pt-24">
        <section class="py-16 bg-gradient-to-br from-primary/5 to-secondary/5">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Liên Hệ Với Chúng Tôi</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn.
                        Hãy liên hệ với chúng tôi để được tư vấn về sản phẩm gạo sạch chất lượng cao.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 md:gap-8 sm:gap-6 mb-16">
                    <div class="bg-white rounded-2xl shadow-lg p-8 md:p-6 sm:p-4">
                        <h2 class="text-2xl md:text-xl sm:text-lg font-bold text-gray-800 mb-6 md:mb-4">Gửi Tin Nhắn Cho
                            Chúng Tôi</h2>
                        <form id="contact-form" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-4">
                                <div>
                                    <label for="fullname"
                                        class="block text-sm font-medium text-gray-700 mb-2 sm:mb-1.5">Họ và tên
                                        *</label>
                                    <input type="text" id="fullname" name="fullname" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        *</label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện
                                        thoại</label>
                                    <input type="tel" id="phone" name="phone"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm">
                                </div>
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Chủ
                                        đề</label>
                                    <div class="relative">
                                        <button type="button" id="subject-dropdown"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm text-left bg-white flex items-center justify-between">
                                            <span id="subject-text">Chọn chủ đề</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </button>
                                        <div id="subject-options"
                                            class="hidden absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-lg shadow-lg z-10 mt-1">
                                            <div class="subject-option px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm"
                                                data-value="product">Tư vấn sản phẩm</div>
                                            <div class="subject-option px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm"
                                                data-value="order">Đặt hàng</div>
                                            <div class="subject-option px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm"
                                                data-value="partnership">Hợp tác kinh doanh</div>
                                            <div class="subject-option px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm"
                                                data-value="complaint">Khiếu nại</div>
                                            <div class="subject-option px-4 py-3 hover:bg-gray-50 cursor-pointer text-sm"
                                                data-value="other">Khác</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Nội dung tin
                                    nhắn</label>
                                <textarea id="message" name="message" rows="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm resize-none"
                                    placeholder="Nhập nội dung tin nhắn của bạn..."></textarea>
                            </div>
                            <button type="submit"
                                class="!rounded-button bg-primary text-white px-8 py-3 hover:bg-primary/90 transition-colors w-full md:w-auto whitespace-nowrap">
                                <i class="ri-send-plane-line mr-2"></i>
                                Gửi tin nhắn
                            </button>
                        </form>
                    </div>
                    <div class="space-y-8">
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Thông Tin Liên Hệ</h2>
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="ri-map-pin-line text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 mb-1">Địa chỉ </h3>
                                        <p class="text-gray-600">Địa chỉ kho HCM: 591 ĐẶNG CÔNG BỈNH, XÃ BÀ ĐIỂM , TP.HCM</p>
                                        <p class="text-gray-600">Địa chỉ nhà máy gia công sản xuất: Khu vực 5, Phường Long Mỹ, TP. Cần Thơ</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="ri-phone-line text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 mb-1">Số điện thoại</h3>
                                        <p class="text-gray-600">Hotline: 0936055077</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="ri-mail-line text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                                        <p class="text-gray-600">tranduyenduyen244@gmail.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="ri-time-line text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 mb-1">Giờ làm việc</h3>
                                        <p class="text-gray-600">Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                                        <p class="text-gray-600">Thứ 7: 8:00 - 12:00</p>
                                        <p class="text-gray-600">Chủ nhật: Nghỉ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kết Nối Với Chúng Tôi</h2>
                            <div class="flex gap-4">
                                <a href="#"
                                    class="w-12 h-12 bg-blue-500 text-white rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                                    <i class="ri-facebook-fill text-xl"></i>
                                </a>
                                <a href="#"
                                    class="w-12 h-12 bg-pink-500 text-white rounded-lg flex items-center justify-center hover:bg-pink-600 transition-colors">
                                    <i class="ri-instagram-fill text-xl"></i>
                                </a>
                                <a href="#"
                                    class="w-12 h-12 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600 transition-colors">
                                    <i class="ri-youtube-fill text-xl"></i>
                                </a>
                                <a href="#"
                                    class="w-12 h-12 bg-green-500 text-white rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors">
                                    <i class="ri-whatsapp-fill text-xl"></i>
                                </a>
                            </div>
                            <div class="mt-6">
                                <p class="text-gray-600 text-sm">Theo dõi chúng tôi trên các mạng xã hội để cập nhật
                                    thông tin mới nhất về sản phẩm và chương trình khuyến mãi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Vị Trí Của Chúng Tôi</h2>
                    <p class="text-xl text-gray-600">Tìm chúng tôi trên bản đồ và ghé thăm showroom để trải nghiệm sản
                        phẩm trực tiếp</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="relative h-64 sm:h-80 md:h-[500px]"
                        style="background-image: url('https://public.readdy.ai/gen_page/map_placeholder_1280x720.png'); background-size: cover; background-position: center;">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute top-4 left-4 bg-white rounded-lg p-4 shadow-lg max-w-sm">
                            <h3 class="font-bold text-gray-800 mb-2">Gạo sạch 3 miền</h3>
                            <p class="text-sm text-gray-600 mb-2">123 Đường Nguyễn Văn Linh, Quận 7</p>
                            <p class="text-sm text-gray-600">TP. Hồ Chí Minh</p>
                            <button
                                class="!rounded-button bg-primary text-white px-4 py-2 text-sm mt-3 hover:bg-primary/90 whitespace-nowrap">
                                <i class="ri-navigation-line mr-1"></i>
                                Chỉ đường
                            </button>
                        </div>
                    </div>
                </div>
        </section>
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Câu Hỏi Thường Gặp</h2>
                    <p class="text-xl text-gray-600">Những thắc mắc phổ biến của khách hàng về sản phẩm và dịch vụ</p>
                </div>
                <div class="max-w-4xl mx-auto space-y-4">
                    <div class="bg-white rounded-lg shadow-sm">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-gray-800">Sản phẩm gạo của công ty có nguồn gốc từ
                                đâu?</span>
                            <i class="ri-arrow-down-s-line text-gray-400 transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Gạo sạch 3 miền được sản xuất từ những cánh đồng lúa chất lượng cao
                                tại ba miền Bắc - Trung - Nam, được chọn lọc kỹ càng và tuân thủ quy trình sản xuất
                                nghiêm ngặt để đảm bảo chất lượng tốt nhất.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-gray-800">Làm thế nào để đặt hàng số lượng lớn?</span>
                            <i class="ri-arrow-down-s-line text-gray-400 transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Để đặt hàng số lượng lớn, quý khách vui lòng liên hệ trực tiếp với
                                phòng kinh doanh qua hotline 1900 1234 567 hoặc email sales@gaosach3mien.com để được tư
                                vấn và báo giá chi tiết.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-gray-800">Công ty có chính sách giao hàng như thế
                                nào?</span>
                            <i class="ri-arrow-down-s-line text-gray-400 transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Chúng tôi hỗ trợ giao hàng toàn quốc với thời gian giao hàng từ 1-3
                                ngày tùy theo khu vực. Miễn phí giao hàng cho đơn hàng từ 500.000đ trong nội thành
                                TP.HCM và Hà Nội.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm">
                        <button
                            class="faq-toggle w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-gray-800">Sản phẩm có được chứng nhận an toàn thực phẩm
                                không?</span>
                            <i class="ri-arrow-down-s-line text-gray-400 transition-transform"></i>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-600">Tất cả sản phẩm của chúng tôi đều được chứng nhận HACCP, ISO 22000
                                và các tiêu chuẩn an toàn thực phẩm quốc tế. Sản phẩm hữu cơ được chứng nhận bởi USDA
                                Organic và EU Organic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include ('../includes/footer_child.php');
    include ('../includes/cta_child.php');
    ?>
    <script id="contact-form-script">
        document.addEventListener('DOMContentLoaded', function () {
            const subjectDropdown = document.getElementById('subject-dropdown');
            const subjectOptions = document.getElementById('subject-options');
            const subjectText = document.getElementById('subject-text');
            const subjectOptionElements = document.querySelectorAll('.subject-option');
            subjectDropdown.addEventListener('click', function () {
                subjectOptions.classList.toggle('hidden');
            });
            subjectOptionElements.forEach(option => {
                option.addEventListener('click', function () {
                    const value = this.getAttribute('data-value');
                    const text = this.textContent;
                    subjectText.textContent = text;
                    subjectOptions.classList.add('hidden');
                });
            });
            document.addEventListener('click', function (e) {
                if (!subjectDropdown.contains(e.target) && !subjectOptions.contains(e.target)) {
                    subjectOptions.classList.add('hidden');
                }
            });
            const contactForm = document.getElementById('contact-form');
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();
                alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
                contactForm.reset();
                subjectText.textContent = 'Chọn chủ đề';
            });
        });
    </script>
    <script id="faq-script">
        document.addEventListener('DOMContentLoaded', function () {
            const faqToggles = document.querySelectorAll('.faq-toggle');
            faqToggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    if (content.classList.contains('hidden')) {
                        content.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        content.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    }
                });
            });
        });
    </script>
</body>

</html>