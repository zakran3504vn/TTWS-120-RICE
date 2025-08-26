<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur shadow-sm">
  <nav class="container mx-auto px-4 py-4">
    <div class="flex items-center justify-between flex-wrap lg:flex-nowrap gap-4">
      <a href="../index.php" class="h-16 md:h-20 lg:h-24 shrink-0">
        <img src="../assets/logo/logo-gao-sach-3-mien.png" alt="Logo" class="h-full">
      </a>
      <button id="menu-toggle" class="lg:hidden text-2xl">
        <i class="ri-menu-line"></i>
      </button>
      <div id="mobile-menu" class="hidden w-full lg:flex lg:w-auto lg:items-center gap-6 lg:gap-12">
        <a href="../" class="<?php echo ($current_page === 'home') ? 'text-primary' : 'text-gray-700'; ?> text-xl font-medium hover:text-primary/80 transition-colors">Trang chủ</a>
        <a href="../ve-chung-toi.php" data-readdy="true" class="<?php echo ($current_page === 'about') ? 'text-primary' : 'text-gray-700'; ?> text-xl font-medium hover:text-primary transition-colors">Về chúng tôi</a>
        <a href="../san-pham/index.php" data-readdy="true" class="<?php echo ($current_page === 'products') ? 'text-primary' : 'text-gray-700'; ?> text-xl font-medium hover:text-primary transition-colors">Sản phẩm</a>
        <a href="../tin-tuc/index.php" data-readdy="true" class="<?php echo ($current_page === 'news') ? 'text-primary' : 'text-gray-700'; ?> text-xl font-medium hover:text-primary transition-colors">Tin tức</a>
        <a href="../lien-he/index.php" data-readdy="true" class="<?php echo ($current_page === 'contact') ? 'text-primary' : 'text-gray-700'; ?> text-xl font-medium hover:text-primary transition-colors">Liên hệ</a>
        <div class="relative flex items-center">
          <input type="text" placeholder="Tìm kiếm sản phẩm..." class="w-64 px-4 py-2 pr-10 text-sm border rounded-lg border-gray-200 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
          <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary">
            <i class="ri-search-line text-lg"></i>
          </button>
        </div>
      </div>
    </div>
  </nav>
</header>

    <script id="mobile-menu-script">
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            menuToggle.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
                mobileMenu.classList.toggle('flex-col');
                if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.style.position = 'absolute';
                    mobileMenu.style.top = '100%';
                    mobileMenu.style.left = '0';
                    mobileMenu.style.right = '0';
                    mobileMenu.style.backgroundColor = 'white';
                    mobileMenu.style.padding = '1rem';
                    mobileMenu.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                    mobileMenu.style.zIndex = '40';
                } else {
                    mobileMenu.style.position = '';
                    mobileMenu.style.top = '';
                    mobileMenu.style.left = '';
                    mobileMenu.style.right = '';
                    mobileMenu.style.backgroundColor = '';
                    mobileMenu.style.padding = '';
                    mobileMenu.style.boxShadow = '';
                    mobileMenu.style.zIndex = '';
                }
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    mobileMenu.classList.remove('hidden', 'flex', 'flex-col');
                    mobileMenu.style.position = '';
                    mobileMenu.style.top = '';
                    mobileMenu.style.left = '';
                    mobileMenu.style.right = '';
                    mobileMenu.style.backgroundColor = '';
                    mobileMenu.style.padding = '';
                    mobileMenu.style.boxShadow = '';
                    mobileMenu.style.zIndex = '';
                } else if (!mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>