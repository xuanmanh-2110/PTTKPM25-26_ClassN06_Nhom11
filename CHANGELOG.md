## [2025-08-25] Khởi tạo dự án

### Cấu trúc & cấu hình
- 25/08/2025: Tạo project Laravel, cấu trúc thư mục chuẩn: `app/`, `config/`, `public/`, `resources/`, `routes/`, `tests/`
- 25/08/2025: Thêm `.env`, `.env.example` với các biến môi trường cơ bản (DB, MAIL, QUEUE, APP_KEY)
- 27/08/2025: Thêm `.gitignore`, `.editorconfig` để chuẩn hóa môi trường phát triển
- 27/08/2025: Thêm `composer.json`, `composer.lock` với các package Laravel core, PHPUnit, Faker, v.v.
- 27/08/2025: Thêm `phpunit.xml` cấu hình test, thiết lập coverage cho các service chính

### Service & Business Logic
- 30/08/2025: Tạo [`CheckoutService.php`](app/Services/CheckoutService.php) - Xử lý logic thanh toán, kiểm tra trạng thái đơn hàng, tích hợp Momo
- 30/08/2025: Tạo [`CustomerService.php`](app/Services/CustomerService.php) - Quản lý thông tin khách hàng, đồng bộ với user
- 31/08/2025: Tạo [`MomoPaymentService.php`](app/Services/MomoPaymentService.php) - Tích hợp API Momo, xác thực giao dịch
- 31/08/2025: Tạo [`OrderItemService.php`](app/Services/OrderItemService.php) - Quản lý chi tiết sản phẩm trong đơn hàng
- 01/09/2025: Tạo [`OrderService.php`](app/Services/OrderService.php) - Tạo/sửa/xóa đơn hàng, tính tổng tiền, trạng thái
- 01/09/2025: Tạo [`ProductService.php`](app/Services/ProductService.php) - Quản lý sản phẩm, cập nhật giá, tồn kho
- 02/09/2025: Tạo [`ReviewService.php`](app/Services/ReviewService.php) - Quản lý đánh giá sản phẩm, kiểm duyệt nội dung
- 02/09/2025: Tạo [`UserService.php`](app/Services/UserService.php) - Quản lý user, phân quyền, cập nhật thông tin

### Migration & Seeder
- 03/09/2025: Tạo migration [`users`](database/migrations/0001_01_01_000000_create_users_table.php) - Thông tin user, quyền admin
- 03/09/2025: Tạo migration [`products`](database/migrations/2025_05_28_202046_create_products_table.php) - Sản phẩm, giá, tồn kho, mô tả
- 05/09/2025: Tạo migration [`customers`](database/migrations/2025_05_28_210446_create_customers_table.php) - Thông tin khách hàng, liên kết user
- 05/09/2025: Tạo migration [`orders`](database/migrations/2025_06_18_222245_create_reviews_table.php) - Đơn hàng, trạng thái, tổng tiền, phương thức thanh toán
- 05/09/2025: Tạo migration [`order_items`](database/migrations/2025_06_07_002528_add_user_id_to_customers_table.php) - Chi tiết sản phẩm trong đơn hàng
- 05/09/2025: Tạo migration [`reviews`](database/migrations/2025_06_18_222245_create_reviews_table.php) - Đánh giá sản phẩm, liên kết user
- 07/09/2025: Thêm migration bổ sung: avatar cho user, bank info cho orders, tăng độ chính xác giá tiền, v.v.
- 10/09/2025: Tạo seeder [`AdminUserSeeder.php`](database/seeders/AdminUserSeeder.php) - Tạo user admin mặc định
- 10/09/2025: Tạo seeder [`SyncCustomerUserSeeder.php`](database/seeders/SyncCustomerUserSeeder.php) - Đồng bộ dữ liệu khách hàng với user
- 10/09/2025: Tạo seeder [`UpdateCustomerDataSeeder.php`](database/seeders/UpdateCustomerDataSeeder.php) - Cập nhật dữ liệu khách hàng mẫu

### Tài nguyên & tài liệu
- 15/09/2025: Thêm ảnh sản phẩm, avatar mẫu vào `public/images/products/` và `public/images/avatars/`
- 18/09/2025: Viết tài liệu quy trình nghiệp vụ: xác thực, quản lý sản phẩm, đơn hàng, khách hàng, đánh giá, báo cáo [`docs/*`](docs/)

### Routing & Controller
- 20/09/2025: Thiết lập các route API, web, console [`routes/api.php`](routes/api.php), [`routes/web.php`](routes/web.php)
- 22/09/2025: Tạo controller mẫu cho Gemini, Product, Order, Customer, Review [`app/Http/Controllers/*`](app/Http/Controllers/)
- 24/09/2025: Sửa lỗi mapping route, bổ sung middleware xác thực

### Cấu hình & môi trường
- 26/10/2025: Thiết lập cấu hình database, cache, session, mail, queue, logging [`config/*`](config/)
- 26/10/2025: Thêm file cache, autoload, provider cho bootstrap

---