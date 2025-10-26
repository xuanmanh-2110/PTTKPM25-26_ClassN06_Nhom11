@extends('layouts.app')
<header class="bg-rose-500 text-white text-center py-2 text-xs md:text-sm">Đang mở cửa giao hoa - Phí giao hàng chỉ 0đ</header>
<nav class="bg-white flex justify-between items-center px-4 py-3 border-b border-gray-200">
    <div class="flex items-center">
      <div class="text-gray-800 font-bold ml-0 md:ml-25">Shop Hoa Tươi</div>
                  @auth
                    @if(auth()->user()->is_admin)
                      <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="border-none px-4 py-2 font-bold text-gray-800 hover:text-purple-800 whitespace-normal md:whitespace-nowrap flex items-center">
                            <span>Quản lý</span>
                        </a>
                      </div>
                    @endif
                  @endauth
    </div>
    <div class="flex items-center flex-wrap justify-center md:flex-nowrap md:justify-end w-full md:max-w-3xl gap-x-4 mr-0 md:mr-25">
        <form id="search-form" autocomplete="off" class="relative w-full md:max-w-[250px] flex items-center">
            <input type="text" id="search-input" name="q" placeholder="Tìm sản phẩm..." class="px-3 py-1 border border-gray-300 rounded-md w-full text-xs">
            <div id="search-suggestions" class="absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-md z-50 hidden"></div>
        </form>
        @auth
            <a href="#" class="no-underline text-gray-800 font-bold text-sm whitespace-normal md:whitespace-nowrap hover:text-red-600">Trang chủ</a>
            <a href="{{ route('products.shop') }}" class="no-underline text-gray-800 font-bold text-sm whitespace-normal md:whitespace-nowrap hover:text-red-600">Cửa hàng</a>
            <a href="{{ route('orders.history') }}" class="no-underline text-gray-800 font-bold text-sm whitespace-normal md:whitespace-nowrap hover:text-red-600">Lịch sử mua</a>
            <a href="{{ route('cart.index') }}" class="text-gray-800 font-bold text-sm whitespace-normal md:whitespace-nowrap hover:text-red-600">Giỏ hàng</a>
            <a href="{{ route('profile.show') }}" class="text-sm font-bold whitespace-normal md:whitespace-nowrap text-gray-800 hover:text-red-600 no-underline">Xin chào, {{ Auth::user()->name }}</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-transparent text-red-700 border border-red-700 px-2 py-1 rounded-md text-sm font-bold cursor-pointer whitespace-normal md:whitespace-nowrap hover:bg-red-700 hover:text-white">Đăng xuất</button>
            </form>
        @else
            <div class="flex items-center gap-x-4">
                <a href="{{ route('login') }}" class="no-underline text-gray-800 font-bold text-sm whitespace-normal md:whitespace-nowrap hover:text-red-600">Đăng nhập</a>
                <a href="{{ route('register') }}" class="no-underline text-gray-800 font-bold text-sm whitespace-normal md:whitespace-nowrap hover:text-red-600">Đăng ký</a>
            </div>
        @endauth
    </div>
  </nav>
@section('content')
  <section class="relative bg-pink-100 p-[5%] flex flex-col md:flex-row items-center justify-between gap-5 md:gap-8 overflow-hidden">
    <!-- Static background blur effect -->
    <div class="absolute inset-0 z-0">
      @if(isset($products[0]) && $products[0]->image)
        <img
          src="{{ asset('images/products/' . $products[0]->image) }}"
          alt="Background"
          class="w-full h-full object-cover blur-sm scale-105">
      @else
        <img
          src="https://via.placeholder.com/800x600/FFB6C1/FFFFFF?text=Background"
          alt="Background"
          class="w-full h-full object-cover blur-sm scale-105">
      @endif
      <div class="absolute inset-0 bg-pink-100/40"></div>
    </div>

    <!-- Content overlay -->
    <div class="relative z-10 flex-1 max-w-full md:max-w-[50%]">
      <p><strong>Gửi hoa</strong></p>
      <h1 class="text-[clamp(24px,5vw,36px)] mb-2.5">Thay lời trái tim muốn nói.</h1>
      <button id="order-now-btn" class="px-5 py-2.5 border-none bg-rose-500 text-white cursor-pointer rounded-md text-[clamp(16px,2.5vw,18px)] font-semibold shadow-md shadow-rose-200 transition-all duration-200 ease-in-out outline-none active:scale-96 active:shadow-sm hover:bg-rose-600 hover:shadow-lg hover:scale-104">Đặt hoa ngay</button>
    </div>

    <div id="hero-slideshow" class="relative z-10 w-full md:max-w-[400px] h-auto aspect-square">
      @for($i = 0; $i < 5; $i++)
        @php
          $img = isset($products[$i]) && $products[$i]->image
            ? asset('images/products/' . $products[$i]->image)
            : 'https://via.placeholder.com/400x400?text=Hoa+tươi';
          $alt = isset($products[$i]) ? $products[$i]->name : 'Hoa tươi';
        @endphp
        <img
          src="{{ $img }}"
          alt="{{ $alt }}"
          class="w-full h-full object-cover rounded-md absolute top-0 left-0 transition-transform duration-700 ease-[cubic-bezier(.7,0,.3,1)] shadow-lg"
          style="opacity:{{ $i === 0 ? '1' : '0' }}; transform: translateX({{ $i === 0 ? '0' : '100%' }}); z-index:{{ 10 - $i }};">
        @endfor
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const slideshow = document.getElementById('hero-slideshow');
        const images = slideshow.querySelectorAll('img');
        let currentSlide = 0;

        function showSlide(index) {
          images.forEach((img, i) => {
            img.style.transition = 'opacity 1s ease-in-out, transform 1s ease-in-out';
            if (i === index) {
              img.style.opacity = '1';
              img.style.transform = 'translateX(0)';
            } else {
              img.style.opacity = '0';
              img.style.transform = 'translateX(100%)'; // Đẩy ảnh ra ngoài bên phải
            }
          });
        }

        function nextSlide() {
          // Ẩn ảnh hiện tại bằng cách dịch chuyển sang phải
          images[currentSlide].style.opacity = '0';
          images[currentSlide].style.transform = 'translateX(100%)';

          currentSlide = (currentSlide + 1) % images.length;

          // Đặt ảnh tiếp theo ở vị trí ban đầu bên trái trước khi hiển thị
          images[currentSlide].style.transition = 'none'; // Tắt transition tạm thời
          images[currentSlide].style.transform = 'translateX(-100%)';
          images[currentSlide].style.opacity = '0'; // Đảm bảo ảnh ẩn trước khi dịch chuyển

          // Buộc trình duyệt render lại để transition hoạt động
          void images[currentSlide].offsetWidth;

          // Hiển thị ảnh tiếp theo bằng cách dịch chuyển vào
          images[currentSlide].style.transition = 'opacity 1s ease-in-out, transform 1s ease-in-out';
          images[currentSlide].style.opacity = '1';
          images[currentSlide].style.transform = 'translateX(0)';
        }

        // Hiển thị ảnh đầu tiên khi tải trang
        showSlide(currentSlide);

        // Tự động chuyển đổi ảnh sau mỗi 3 giây
        setInterval(nextSlide, 3000);
      });
    </script>

  <section class="p-[5%]">
    <h2 class="text-center mb-5 text-[clamp(20px,4vw,28px)] text-rose-600">Sản phẩm mới nhất</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 justify-center">
      @foreach($products as $idx => $p)
        <a href="{{ route('products.show', $p->id) }}" class="no-underline text-inherit group">
          <div class="bg-white rounded-xl shadow-md py-6 px-2 text-center transition-all duration-300 ease-in-out relative overflow-hidden border border-gray-200 flex flex-col h-full hover:translate-y-[-5px] hover:shadow-lg">
            <div class="flex justify-center items-center mb-6 overflow-hidden rounded-md mx-2">
              @if($p->image)
                <img src="{{ asset('images/products/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-[240px] object-cover transition-transform duration-300 group-hover:scale-105">
              @else
                <img src="https://via.placeholder.com/240x240" alt="No Image" class="w-full h-[240px] object-cover transition-transform duration-300 group-hover:scale-105">
              @endif
            </div>
            <p class="text-lg font-bold text-rose-600 px-2 pb-2">{{ $p->name }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  @if($latestProducts->count() > 0)
  <section class="bg-pink-50 p-[5%]">
    <div class="flex flex-col md:flex-row items-center justify-between gap-8">
      <!-- Chữ bên trái -->
      <div class="flex-1 text-left">
        <h2 class="text-rose-600 text-[clamp(20px,4vw,26px)] mb-4">Khuyến mãi HOT! Giảm giá đến <span class="text-rose-500">20%</span></h2>
        <p class="mb-6 text-lg">Sản phẩm mới nhất - Giảm giá xả kho lên đến 20%</p>
        <p class="text-gray-600 mb-6">Đừng bỏ lỡ cơ hội sở hữu sản phẩm mới nhất với mức giá ưu đãi nhất!</p>
      </div>

      <!-- Carousel sản phẩm bên phải -->
      <div class="flex-1 max-w-4xl">
        <div class="relative overflow-hidden" style="width: 100%; height: 400px;">
          <div id="carousel-container" class="flex transition-transform duration-1000 ease-in-out" style="gap: 20px; width: {{ $latestProducts->count() * 3 * 280 }}px;">
            @foreach(range(0, 2) as $clone)
            @foreach($latestProducts as $index => $product)
            <div class="carousel-item flex-shrink-0 transition-all duration-1000 ease-in-out"
                 data-index="{{ $index }}"
                 data-clone="{{ $clone }}"
                 data-product-id="{{ $product->id }}"
                 data-product-name="{{ $product->name }}"
                 data-product-price="{{ $product->price }}"
                 style="width: 260px; display: flex; align-items: center; justify-content: center;">
              <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 text-center transition-all duration-1000 ease-in-out">
                <a href="{{ route('products.show', $product->id) }}" class="block no-underline text-inherit hover:opacity-80 transition-opacity duration-200">
                  <img src="{{ $product->image ? asset('images/products/' . $product->image) : 'https://via.placeholder.com/200x200' }}"
                       alt="{{ $product->name }}"
                       class="w-[200px] h-[200px] object-cover rounded-md border border-gray-300 mb-3 mx-auto transition-transform duration-1000 ease-in-out">

                  <h3 class="text-base font-semibold mb-2 text-rose-600 min-h-[3rem] flex items-center justify-center leading-tight transition-all duration-1000 ease-in-out">{{ $product->name }}</h3>

                  <div class="mb-3 transition-all duration-1000 ease-in-out">
                    <span class="text-sm text-gray-500 line-through mr-2">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                    <br>
                    <span class="text-rose-600 text-lg font-bold">{{ number_format($product->price * 0.8, 0, ',', '.') }} VND</span>
                    <span class="bg-red-500 text-white px-2 py-1 rounded text-xs ml-2">-20%</span>
                  </div>
                </a>
              </div>
            </div>
            @endforeach
            @endforeach
          </div>
        </div>

        <!-- Indicators -->
        <div class="flex justify-center mt-12 space-x-4">
          @foreach($latestProducts as $index => $product)
          <button class="carousel-indicator w-4 h-4 rounded-full transition-all duration-200"
                  data-index="{{ $index }}"
                  style="background-color: {{ $index === 0 ? '#f43f5e' : '#d1d5db' }}"></button>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endif
       <footer class="bg-gray-100 px-6 py-10 mt-10 text-gray-700 border-t border-gray-300">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Logo & Giới thiệu -->
        <div>
            <h2 class="text-2xl font-bold text-rose-600 mb-3">🌸 FlowerShop Hà Đông</h2>
            <p class="text-sm leading-relaxed">
                FlowerShop Hà Đông chuyên cung cấp hoa tươi, hoa bó, hoa chúc mừng và dịch vụ giao hoa tận nơi.
                Chúng tôi cam kết hoa tươi 100%, phục vụ nhanh chóng và tận tâm.
            </p>
        </div>

        <!-- Hỗ trợ -->
        <div>
            <h4 class="font-bold text-lg mb-3">Hỗ trợ khách hàng</h4>
            <ul class="space-y-2">
                <li>
                    <span class="font-semibold">Tư vấn dịch vụ:</span>
                    <a href="tel:18006750" class="text-blue-600 hover:text-blue-800">1800 6750</a>
                </li>
                <li>
                    <span class="font-semibold">Hỗ trợ đơn hàng:</span>
                    <a href="tel:19006750" class="text-blue-600 hover:text-blue-800">1900 6750</a>
                </li>
                <li>
                    <span class="font-semibold">Email:</span>
                    <a href="mailto:support@flowerstore.vn" class="text-blue-600 hover:text-blue-800">support@flowerstore.vn</a>
                </li>
                <li class="italic text-gray-600">Hỗ trợ từ 7h00 – 22h00, tất cả các ngày trong tuần</li>
            </ul>
        </div>

        <!-- Thông tin & Liên hệ -->
        <div>
            <h4 class="font-bold text-lg mb-3">Thông tin & Liên hệ</h4>
            <ul class="space-y-2">
                <li>
                    <a href="https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+%C4%90%E1%BA%A1i+H%E1%BB%8Dc+Phenikaa/@20.9626112,105.7461115,1041m/data=!3m2!1e3!4b1!4m6!3m5!1s0x313452efff394ce3:0x391a39d4325be464!8m2!3d20.9626112!4d105.7486864!16s%2Fg%2F1220whsz?entry=ttu&g_ep=EgoyMDI1MTAyMi4wIKXMDSoASAFQAw%3D%3D"
                       target="_blank"
                       class="flex items-center text-blue-600 hover:text-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM12 11.5
                            c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5
                            2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        Gần Trường Đại học Phenikaa, Yên Nghĩa, Hà Đông, Hà Nội
                    </a>
                </li>
                <li>
                    <span class="font-semibold">Hotline:</span>
                    <a href="tel:0965123456" class="text-blue-600 hover:text-blue-800">0935 XXX XXX</a>
                </li>
                <li>
                    <span class="font-semibold">Email:</span>
                    <a href="mailto:flowershop.hadong@gmail.com" class="text-blue-600 hover:text-blue-800">flowershop.hadong@gmail.com</a>
                </li>
            </ul>
        </div>

        <!-- KẾT NỐI VỚI CHÚNG TÔI -->
<div class="min-w-full sm:min-w-[150px]">
    <h4 class="font-bold text-lg mb-3">Kết nối với chúng tôi</h4>
    <p class="text-sm text-gray-600 mb-3">
        Theo dõi chúng tôi trên mạng xã hội để nhận thông tin ưu đãi và cập nhật mẫu hoa mới nhất!
    </p>

    <div class="flex space-x-4">
        <!-- Facebook -->
        <a href="https://www.facebook.com/share/g/19gntsFrbn/"
           target="_blank"
           class="w-10 h-10 flex items-center justify-center bg-blue-600 rounded-full text-white shadow-md hover:bg-blue-700 transition transform hover:scale-110"
           title="Theo dõi Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path d="M22.675 0h-21.35C.597 0 0 .597 0 1.325v21.351C0 23.403.597 24 1.325
                24h11.49v-9.294H9.691V11.29h3.124V8.413c0-3.1 1.891-4.789 4.658-4.789
                1.325 0 2.462.099 2.792.143v3.24l-1.917.001c-1.503 0-1.792.715-1.792
                1.763v2.312h3.584l-.466 3.416h-3.118V24h6.114C23.403 24 24
                23.403 24 22.676V1.325C24 .597 23.403 0 22.675 0z"/>
            </svg>
        </a>

        <!-- Instagram -->
        <a href="https://www.instagram.com/flowerbythawmiu_?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
           target="_blank"
           class="w-10 h-10 flex items-center justify-center bg-pink-500 rounded-full text-white shadow-md hover:bg-pink-600 transition transform hover:scale-110"
           title="Theo dõi Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.33
                3.608 1.305.975.975 1.243 2.242 1.305 3.608.058 1.266.07
                1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.33
                2.633-1.305 3.608-.975.975-2.242 1.243-3.608
                1.305-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.33-3.608-1.305-.975-.975-1.243-2.242-1.305-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.33-2.633
                1.305-3.608.975-.975 2.242-1.243 3.608-1.305C8.416
                2.175 8.796 2.163 12 2.163zm0 1.838c-3.16 0-3.507.012-4.737.07-1.186.054-1.828.24-2.254.405-.569.221-.975.485-1.405.915s-.694.836-.915
                1.405c-.165.426-.351 1.068-.405
                2.254-.058 1.23-.07 1.577-.07 4.737s.012 3.507.07
                4.737c.054 1.186.24 1.828.405
                2.254.221.569.485.975.915
                1.405s.836.694 1.405.915c.426.165 1.068.351
                2.254.405 1.23.058 1.577.07
                4.737.07s3.507-.012 4.737-.07c1.186-.054
                1.828-.24 2.254-.405.569-.221.975-.485
                1.405-.915s.694-.836.915-1.405c.165-.426.351-1.068.405-2.254.058-1.23.07-1.577.07-4.737s-.012-3.507-.07-4.737c-.054-1.186-.24-1.828-.405-2.254-.221-.569-.485-.975-.915-1.405s-.836-.694-1.405-.915c-.426-.165-1.068-.351-2.254-.405-1.23-.058-1.577-.07-4.737-.07zm0
                3.905a5.935 5.935 0 110 11.87 5.935 5.935 0 010-11.87zm0
                1.838a4.097 4.097 0 100 8.194 4.097 4.097 0 000-8.194zm6.406-3.437a1.44 1.44 0 110 2.88 1.44 1.44 0 010-2.88z"/>
            </svg>
        </a>

        <!-- TikTok -->
        <a href="https://www.tiktok.com/@byh.floral/video/7539062285877136648?is_from_webapp=1&sender_device=pc&web_id=7547573063563544071"
           target="_blank"
           class="w-10 h-10 flex items-center justify-center bg-black rounded-full text-white shadow-md hover:bg-gray-800 transition transform hover:scale-110"
           title="Theo dõi TikTok">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path d="M12 2c5.523 0 10 4.477 10
                10s-4.477 10-10 10S2 17.523 2
                12 6.477 2 12 2zm1.715 5.514v7.228a3.27 3.27 0 11-1.74-2.872v-1.78a5.06
                5.06 0 102.542 4.392V9.887a5.32 5.32 0 003.256
                1.132V8.973c-.543-.021-1.092-.115-1.609-.288a3.64
                3.64 0 01-2.45-3.171z"/>
            </svg>
        </a>

        <!-- Zalo -->
        <a href="https://zalo.me/"
           target="_blank"
           class="w-10 h-10 flex items-center justify-center bg-cyan-500 rounded-full text-white shadow-md hover:bg-cyan-600 transition transform hover:scale-110"
           title="Kết nối Zalo">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                <path d="M12 2C6.477 2 2 6.306 2 11.5c0 3.087
                1.505 5.872 3.875 7.725L4.8 22l3.67-1.983c1.112.3
                2.314.465 3.53.465 5.523 0 10-4.306 10-9.5S17.523
                2 12 2z"/>
            </svg>
        </a>
    </div>
</div>



    <!-- Bản quyền -->
    <div class="border-t border-gray-300 mt-8 pt-4 text-center text-sm text-gray-600">
                                 © 2025 FlowerShop Hà Đông
    </div>
</footer>

@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Infinite scrolling carousel with scale effects
    const carouselContainer = document.getElementById('carousel-container');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const indicators = document.querySelectorAll('.carousel-indicator');
    const totalItems = {{ $latestProducts->count() }};
    let currentIndex = totalItems; // Start from middle set
    let isTransitioning = false;

    if (carouselContainer && carouselItems.length > 0) {
      // Set initial position (centered)
      const containerWidth = carouselContainer.parentElement.offsetWidth;
      const itemOffset = (containerWidth / 2) - (260 / 2);
      const initialTranslateX = -(currentIndex * 280) + itemOffset;
      carouselContainer.style.transform = `translateX(${initialTranslateX}px)`;

      function updateCarousel(smooth = true) {
        if (smooth) {
          carouselContainer.style.transition = 'transform 1000ms ease-in-out';
        } else {
          carouselContainer.style.transition = 'none';
        }

        // Center the current item (offset by half container width minus half item width)
        const containerWidth = carouselContainer.parentElement.offsetWidth;
        const itemOffset = (containerWidth / 2) - (260 / 2); // 260px is item width
        const translateX = -(currentIndex * 280) + itemOffset;
        carouselContainer.style.transform = `translateX(${translateX}px)`;

        // Update scale effects for all items
        carouselItems.forEach((item, index) => {
          const card = item.querySelector('div');
          const title = card.querySelector('h3');
          const price = card.querySelector('div:last-child');

          if (index === currentIndex) {
            // Center item - active (scale up but not too much)
            card.style.transform = 'scale(1.05)';
            card.style.opacity = '1';
            card.style.filter = 'grayscale(0)';
            title.classList.remove('text-sm');
            title.classList.add('text-xl');
            price.classList.remove('text-xs');
            price.classList.add('text-base');
          } else {
            // Other items (scale down)
            card.style.transform = 'scale(0.9)';
            card.style.opacity = '0.7';
            card.style.filter = 'grayscale(100%)';
            title.classList.remove('text-xl');
            title.classList.add('text-sm');
            price.classList.remove('text-base');
            price.classList.add('text-xs');
          }
        });

        // Update indicators based on actual product index
        const indicatorIndex = currentIndex % totalItems;
        indicators.forEach((indicator, index) => {
          indicator.style.backgroundColor = index === indicatorIndex ? '#f43f5e' : '#d1d5db';
        });
      }

      function nextSlide() {
        if (isTransitioning) return;
        isTransitioning = true;

        currentIndex++;
        updateCarousel();

        setTimeout(() => {
          if (currentIndex >= totalItems * 2) {
            currentIndex = totalItems;
            updateCarousel(false);
          }
          isTransitioning = false;
        }, 1000);
      }

      function prevSlide() {
        if (isTransitioning) return;
        isTransitioning = true;

        currentIndex--;
        updateCarousel();

        setTimeout(() => {
          if (currentIndex <= 0) {
            currentIndex = totalItems;
            updateCarousel(false);
          }
          isTransitioning = false;
        }, 1000);
      }

      function goToSlide(index) {
        if (isTransitioning) return;
        currentIndex = totalItems + index;
        updateCarousel();
      }

      // Event listeners
      indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => goToSlide(index));
      });

      // Auto-play every 5 seconds
      setInterval(nextSlide, 5000);
      updateCarousel();
    }
  });
</script>
