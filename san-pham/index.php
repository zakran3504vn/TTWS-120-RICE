<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm Gạo | Gạo Sạch 3 Miền</title>
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

        .range-slider::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #4CAF50;
            border-radius: 50%;
            cursor: pointer;
        }

        .range-slider::-webkit-slider-runnable-track {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
        }

        input[type="checkbox"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]:checked {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>

<body class="bg-white">
    <?php
     $current_page = 'products';
     include ("../includes/header_child.php");
    ?>
    <main class="pt-32 pb-16 min-h-screen">
        <div class="relative bg-[#F8F9FA] mb-12">
            <div class="container mx-auto px-4 py-16">
                <h1 class="text-5xl font-bold mb-4 text-primary md:text-center">Sản Phẩm Gạo</h1>
                <p class="text-xl text-primary md:text-center">Khám phá bộ sưu tập gạo chất lượng cao từ Vĩnh Hiền</p>
            </div>
        </div>
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Nút lọc cho mobile/iPad -->
                <div class="lg:hidden mb-4">
                    <button id="filter-toggle"
                        class="w-full bg-primary text-white px-6 py-3 rounded-button hover:bg-primary/90 flex items-center justify-center gap-2">
                        <i class="ri-filter-line"></i>
                        Bộ lọc sản phẩm
                    </button>
                </div>
                <div id="filter-sidebar"
                    class="w-full lg:w-1/4 bg-white rounded-lg shadow-lg p-6 h-fit hidden lg:block">
                    <h2 class="text-xl font-bold mb-6">Bộ lọc sản phẩm</h2>
                    <div class="mb-8">
                        <h3 class="font-semibold mb-4">Loại gạo</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="type" value="gao-trang">
                                <span class="text-gray-700">Gạo trắng</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="type" value="gao-lut">
                                <span class="text-gray-700">Gạo lứt</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="type" value="gao-nep">
                                <span class="text-gray-700">Gạo nếp</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="type" value="gao-nhat">
                                <span class="text-gray-700">Gạo Nhật</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="type" value="gao-huu-co">
                                <span class="text-gray-700">Gạo hữu cơ</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-8">
                        <h3 class="font-semibold mb-4">Xuất xứ</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="origin" value="viet-nam">
                                <span class="text-gray-700">Việt Nam</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="origin" value="nhat-ban">
                                <span class="text-gray-700">Nhật Bản</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="accent-primary" data-filter="origin" value="thai-lan">
                                <span class="text-gray-700">Thái Lan</span>
                            </label>
                        </div>
                    </div>
                    <a href="#" id="reset-filters"
                        class="!rounded-button bg-primary text-white px-6 py-2 w-full hover:bg-primary/90">Xóa bộ
                        lọc</a>
                </div>
                <div class="w-full lg:w-3/4">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4">
                        <div class="flex items-center gap-4">
                            <span class="text-gray-600">Sắp xếp theo:</span>
                            <div class="relative">
                                <button id="sort-button"
                                    class="w-48 text-left !rounded-button border border-gray-200 px-4 py-2 flex items-center justify-between">
                                    <span id="sort-label" class="text-gray-700">Phổ biến nhất</span>
                                    <i class="ri-arrow-down-s-line"></i>
                                </button>
                                <div id="sort-dropdown"
                                    class="absolute z-10 mt-2 w-48 bg-white rounded-lg shadow-lg hidden">
                                    <button class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                                        data-sort="popular">Phổ biến nhất</button>
                                    <button class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                                        data-sort="oldest">Cũ nhất</button>
                                    <button class="block w-full px-4 py-2 text-left hover:bg-gray-100"
                                        data-sort="newest">Mới nhất</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-gray-600">Hiển thị:</span>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-primary border border-primary !rounded-button">
                                <i class="ri-grid-line text-xl"></i>
                            </button>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-400 border border-gray-200 !rounded-button hover:text-primary hover:border-primary">
                                <i class="ri-list-check-2 text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden group product-item"
                            data-type="gao-trang" data-origin="viet-nam" data-popularity="100" data-date="2023-01-01">
                            <div class="relative">
                                <img src="../assets/uploads/551c9a480c1dbb9366c93e5678c4eb36.jpg"
                                    alt="Gạo ST25" class="w-full h-48 object-cover">
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2">Gạo ST25 Đặc Sản</h3>
                                <p class="text-gray-600 mb-4">Gạo ST25 là giống gạo nổi tiếng của Việt Nam, được công
                                    nhận là gạo ngon nhất thế giới năm 2019 tại cuộc thi World's Best Rice. Hạt gạo dài,
                                    trắng trong, khi nấu chín dẻo thơm, giàu dinh dưỡng với hàm lượng protein cao, phù
                                    hợp cho bữa ăn hàng ngày và các món ăn đặc sản. Sản phẩm được trồng theo quy trình
                                    hữu cơ, đảm bảo an toàn và chất lượng cao nhất.</p>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-primary font-bold text-xl">Liên hệ</div>
                                </div>
                                <a href="./detail_product.php"
                                    data-readdy="true" class="block">
                                    <button
                                        class="!rounded-button bg-primary text-white px-6 py-2 w-full hover:bg-primary/90">Xem
                                        chi tiết</button>
                                </a>
                            </div>
                        </div>
                        <!-- Thêm nhiều sản phẩm khác để demo, với data-type, data-origin, data-popularity (số cao hơn = phổ biến hơn), data-date (YYYY-MM-DD) -->
                    </div>
                    <div class="flex items-center justify-between mt-8 flex-col lg:flex-row gap-4">
                        <div class="text-xl text-gray-600">Hiển thị 1-6 trong số 24 sản phẩm</div>
                        <div class="flex items-center gap-2">
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-400 border border-gray-200 !rounded-button hover:text-primary hover:border-primary disabled:opacity-50 disabled:hover:border-gray-200 disabled:hover:text-gray-400"
                                disabled>
                                <i class="ri-arrow-left-s-line text-xl"></i>
                            </button>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-white bg-primary border border-primary !rounded-button">1</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-700 border border-gray-200 !rounded-button hover:text-primary hover:border-primary">2</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-700 border border-gray-200 !rounded-button hover:text-primary hover:border-primary">3</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-700 border border-gray-200 !rounded-button hover:text-primary hover:border-primary">4</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center text-gray-400 border border-gray-200 !rounded-button hover:text-primary hover:border-primary">
                                <i class="ri-arrow-right-s-line text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="compare-bar"
        class="fixed bottom-0 left-0 right-0 bg-white shadow-lg transform translate-y-full transition-transform duration-300 z-40">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between flex-col lg:flex-row gap-4">
                <div class="flex items-center gap-4">
                    <h3 class="font-semibold">So sánh sản phẩm</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="ri-add-line text-2xl text-gray-400"></i>
                        </div>
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="ri-add-line text-2xl text-gray-400"></i>
                        </div>
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="ri-add-line text-2xl text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="text-gray-600 hover:text-primary">
                        <i class="ri-close-line text-xl"></i>
                        Xóa tất cả
                    </button>
                    <button
                        class="!rounded-button bg-primary text-white px-6 py-2 hover:bg-primary/90 disabled:opacity-50"
                        disabled>
                        So sánh ngay
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include ('../includes/footer_child.php');
    include ('../includes/cta_child.php');
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const compareButtons = document.querySelectorAll('.ri-scales-3-line');
            const compareBar = document.getElementById('compare-bar');
            const filterToggle = document.getElementById('filter-toggle');
            const filterSidebar = document.getElementById('filter-sidebar');
            const sortButton = document.getElementById('sort-button');
            const sortLabel = document.getElementById('sort-label');
            const sortDropdown = document.getElementById('sort-dropdown');
            const resetFilters = document.getElementById('reset-filters');
            const productGrid = document.getElementById('product-grid');
            const productItems = Array.from(document.querySelectorAll('.product-item'));
            let currentSort = 'popular';

            // Toggle compare bar
            compareButtons.forEach(button => {
                button.parentElement.addEventListener('click', function () {
                    button.parentElement.classList.toggle('text-primary');
                    compareBar.classList.toggle('translate-y-full');
                });
            });

            // Toggle filter sidebar on mobile/iPad
            filterToggle.addEventListener('click', function () {
                filterSidebar.classList.toggle('hidden');
            });

            // Sort dropdown toggle
            sortButton.addEventListener('click', function () {
                sortDropdown.classList.toggle('hidden');
            });

            // Sort selection
            sortDropdown.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', function () {
                    currentSort = this.dataset.sort;
                    sortLabel.textContent = this.textContent;
                    sortDropdown.classList.add('hidden');
                    applyFiltersAndSort();
                });
            });

            // Filter checkboxes
            const checkboxes = filterSidebar.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', applyFiltersAndSort);
            });

            // Reset filters
            resetFilters.addEventListener('click', function (e) {
                e.preventDefault();
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                applyFiltersAndSort();
            });

            // Function to apply filters and sort
            function applyFiltersAndSort() {
                const selectedTypes = Array.from(filterSidebar.querySelectorAll('[data-filter="type"]:checked')).map(cb => cb.value);
                const selectedOrigins = Array.from(filterSidebar.querySelectorAll('[data-filter="origin"]:checked')).map(cb => cb.value);

                let filteredItems = productItems.filter(item => {
                    const type = item.dataset.type;
                    const origin = item.dataset.origin;
                    const typeMatch = selectedTypes.length === 0 || selectedTypes.includes(type);
                    const originMatch = selectedOrigins.length === 0 || selectedOrigins.includes(origin);
                    return typeMatch && originMatch;
                });

                // Sort the filtered items
                filteredItems.sort((a, b) => {
                    if (currentSort === 'popular') {
                        return b.dataset.popularity - a.dataset.popularity;
                    } else if (currentSort === 'oldest') {
                        return new Date(a.dataset.date) - new Date(b.dataset.date);
                    } else if (currentSort === 'newest') {
                        return new Date(b.dataset.date) - new Date(a.dataset.date);
                    }
                    return 0;
                });

                // Clear and append sorted/filtered items
                productGrid.innerHTML = '';
                filteredItems.forEach(item => productGrid.appendChild(item));
            }
        });
    </script>
</body>

</html>