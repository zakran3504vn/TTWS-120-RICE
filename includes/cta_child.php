<?php
  // ====== CẤU HÌNH NHANH (sửa theo của bạn) ======
  $zalo_link = "https://zalo.me/0936055077";       // VD: https://zalo.me/0987654321
  $messenger_link = "https://m.me/truongthanhweb";     // VD: https://m.me/truongthanhweb
  $phone_number = "0936055077";                          // Số gọi điện
  // Ảnh logo (nên là PNG/SVG nền trong suốt)
  $zalo_img = "../assets/imgs/Icon_of_Zalo.svg.webp";
  $messenger_img = "../assets/imgs/Facebook_Messenger_logo_2020.svg.webp";
?>
<!-- Tailwind CDN (nếu dự án của bạn đã có Tailwind thì có thể bỏ dòng này để tránh nạp 2 lần) -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- CTA Floating -->
<div id="cta-floating"
     class="fixed z-[9999] bottom-6 right-6 flex flex-col items-center gap-3">

  <!-- Zalo -->
  <a href="<?= htmlspecialchars($zalo_link) ?>"
     target="_blank" rel="noopener"
     class="group relative block w-14 h-14 rounded-full shadow-lg ring-1 ring-black/5 overflow-hidden bg-white hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
    <img src="<?= htmlspecialchars($zalo_img) ?>"
         alt="Zalo" class="w-full h-full object-contain p-2" loading="lazy">
    <span class="pointer-events-none absolute -left-2 top-1/2 -translate-y-1/2 -translate-x-full whitespace-nowrap opacity-0 group-hover:opacity-100 group-hover:-translate-x-2 transition-all duration-300 bg-black/80 text-white text-xs px-2 py-1 rounded-lg shadow-md">
      Nhắn Zalo
    </span>
  </a>

  <!-- Messenger -->
  <a href="<?= htmlspecialchars($messenger_link) ?>"
     target="_blank" rel="noopener"
     class="group relative block w-14 h-14 rounded-full shadow-lg ring-1 ring-black/5 overflow-hidden bg-white hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
    <img src="<?= htmlspecialchars($messenger_img) ?>"
         alt="Messenger" class="w-full h-full object-contain p-2" loading="lazy">
    <span class="pointer-events-none absolute -left-2 top-1/2 -translate-y-1/2 -translate-x-full whitespace-nowrap opacity-0 group-hover:opacity-100 group-hover:-translate-x-2 transition-all duration-300 bg-black/80 text-white text-xs px-2 py-1 rounded-lg shadow-md">
      Nhắn Messenger
    </span>
  </a>

  <!-- Gọi điện (SVG icon) -->
  <a href="tel:<?= htmlspecialchars($phone_number) ?>"
     class="group relative flex w-14 h-14 items-center justify-center rounded-full bg-green-500 text-white shadow-lg hover:bg-green-600 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
    <!-- Phone Icon (SVG) -->
    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="none">
      <path d="M2.5 5.5c0-1.1.9-2 2-2h2.2c.9 0 1.7.6 1.9 1.5l.7 2.5c.2.8-.1 1.6-.8 2.1l-1.2.9c1 2 2.6 3.6 4.6 4.6l.9-1.2c.5-.7 1.3-1 2.1-.8l2.5.7c.9.2 1.5 1 1.5 1.9V19.5c0 1.1-.9 2-2 2h-1C9.7 21.5 2.5 14.3 2.5 6.5v-1z"
            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="pointer-events-none absolute -left-2 top-1/2 -translate-y-1/2 -translate-x-full whitespace-nowrap opacity-0 group-hover:opacity-100 group-hover:-translate-x-2 transition-all duration-300 bg-black/80 text-white text-xs px-2 py-1 rounded-lg shadow-md">
      Gọi điện
    </span>
  </a>

  <!-- Scroll To Top -->
  <button id="btn-scroll-top" type="button" aria-label="Lên đầu trang"
          class="hidden mt-1 w-11 h-11 rounded-full bg-gray-900 text-white shadow-lg hover:bg-gray-800 hover:shadow-xl transition-all duration-200 outline-none focus:ring-4 focus:ring-gray-300">
    <!-- Up arrow -->
    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-6 h-6" viewBox="0 0 24 24" fill="none">
      <path d="M6 15l6-6 6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>
</div>

<script>
  // Hiện nút scroll-top khi cuộn xuống
  (function () {
    const btn = document.getElementById('btn-scroll-top');
    let ticking = false;

    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          const show = window.scrollY > 200;
          if (btn) {
            btn.classList.toggle('hidden', !show);
          }
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });

    if (btn) {
      btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }
  })();
</script>