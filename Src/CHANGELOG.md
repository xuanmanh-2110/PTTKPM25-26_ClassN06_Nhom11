## [2025-08-25] Khởi tạo dự án

### Cấu trúc & cấu hình
- feat: Tạo project Laravel, cấu trúc thư mục chuẩn: `app/`, `config/`, `public/`, `resources/`, `routes/`, `tests/`
- chore: Thêm `.env`, `.env.example` với các biến môi trường cơ bản (DB, MAIL, QUEUE, APP_KEY)
- chore: Thêm `.gitignore`, `.editorconfig` để chuẩn hóa môi trường phát triển
- chore: Thêm `composer.json`, `composer.lock` với các package Laravel core, PHPUnit, Faker, v.v.
- chore: Thêm `phpunit.xml` cấu hình test, thiết lập coverage cho các service chính

### Service & Business Logic
- feat: Tạo các service:
    - [`CheckoutService.php`](app/Services/CheckoutService.php): Xử lý logic thanh toán, kiểm tra trạng thái đơn hàng, tích hợp Momo
    - [`CustomerService.php`](app/Services/CustomerService.php): Quản lý thông tin khách hàng, đồng bộ với user
    - [`MomoPaymentService.php`](app/Services/MomoPaymentService.php): Tích hợp API Momo, xác thực giao dịch
    - [`OrderItemService.php`](app/Services/OrderItemService.php): Quản lý chi tiết sản phẩm trong đơn hàng
    - [`OrderService.php`](app/Services/OrderService.php): Tạo/sửa/xóa đơn hàng, tính tổng tiền, trạng thái
    - [`ProductService.php`](app/Services/ProductService.php): Quản lý sản phẩm, cập nhật giá, tồn kho
    - [`ReviewService.php`](app/Services/ReviewService.php): Quản lý đánh giá sản phẩm, kiểm duyệt nội dung
    - [`UserService.php`](app/Services/UserService.php): Quản lý user, phân quyền, cập nhật thông tin

### Migration & Seeder
- feat: Tạo migration cho các bảng:
    - [`users`](database/migrations/0001_01_01_000000_create_users_table.php): Thông tin user, quyền admin
    - [`products`](database/migrations/2025_05_28_202046_create_products_table.php): Sản phẩm, giá, tồn kho, mô tả
    - [`customers`](database/migrations/2025_05_28_210446_create_customers_table.php): Thông tin khách hàng, liên kết user
    - [`orders`](database/migrations/2025_06_18_222245_create_reviews_table.php): Đơn hàng, trạng thái, tổng tiền, phương thức thanh toán
    - [`order_items`](database/migrations/2025_06_07_002528_add_user_id_to_customers_table.php): Chi tiết sản phẩm trong đơn hàng
    - [`reviews`](database/migrations/2025_06_18_222245_create_reviews_table.php): Đánh giá sản phẩm, liên kết user
- feat: Thêm các migration bổ sung: avatar cho user, bank info cho orders, tăng độ chính xác giá tiền, v.v.
- feat: Tạo seeder mẫu:
    - [`AdminUserSeeder.php`](database/seeders/AdminUserSeeder.php): Tạo user admin mặc định
    - [`SyncCustomerUserSeeder.php`](database/seeders/SyncCustomerUserSeeder.php): Đồng bộ dữ liệu khách hàng với user
    - [`UpdateCustomerDataSeeder.php`](database/seeders/UpdateCustomerDataSeeder.php): Cập nhật dữ liệu khách hàng mẫu

### Tài nguyên & tài liệu
- feat: Thêm ảnh sản phẩm, avatar mẫu vào `public/images/products/` và `public/images/avatars/`
- docs: Viết tài liệu quy trình nghiệp vụ: xác thực, quản lý sản phẩm, đơn hàng, khách hàng, đánh giá, báo cáo [`docs/*`](docs/)

### Routing & Controller
- feat: Thiết lập các route API, web, console [`routes/api.php`](routes/api.php), [`routes/web.php`](routes/web.php)
- feat: Tạo controller mẫu cho Gemini, Product, Order, Customer, Review [`app/Http/Controllers/*`](app/Http/Controllers/)
- fix: Sửa lỗi mapping route, bổ sung middleware xác thực

### Cấu hình & môi trường
- chore: Thiết lập cấu hình database, cache, session, mail, queue, logging [`config/*`](config/)
- chore: Thêm Dockerfile, script entrypoint hỗ trợ phát triển và deploy
- chore: Thêm file cache, autoload, provider cho bootstrap

---