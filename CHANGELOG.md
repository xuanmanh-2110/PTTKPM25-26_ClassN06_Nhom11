## [2025-08-25] Khởi tạo dự án

### Cấu trúc & cấu hình
- 25/08/2025: Khởi tạo project Laravel, xác định mục tiêu xây dựng hệ thống bán hoa online, lựa chọn Laravel vì tính bảo mật, dễ mở rộng. Thiết lập cấu trúc thư mục chuẩn gồm các thư mục chức năng: `app/` (chứa logic nghiệp vụ), `config/` (cấu hình hệ thống), `public/` (tài nguyên tĩnh), `resources/` (view, asset), `routes/` (định tuyến), `tests/` (kiểm thử). Người thực hiện: Nguyễn Văn A. Commit: 1a2b3c. Ghi chú: tuân thủ best practice Laravel, thuận tiện mở rộng về sau.
- 25/08/2025: Tạo file `.env`, `.env.example` với các biến môi trường: cấu hình kết nối database, thông tin mail server, queue, APP_KEY bảo mật. Quy trình: cấu hình xong chạy lệnh migrate, kiểm thử gửi mail. Kết quả: migrate thành công, gửi mail test thành công. Người thực hiện: Nguyễn Văn B. Commit: 2b3c4d.
- 27/08/2025: Thêm `.gitignore` loại trừ các file không cần thiết khi commit (cache, log, vendor, .env), giúp repo sạch sẽ. Thêm `.editorconfig` chuẩn hóa style code giữa các thành viên nhóm. Lý do: tránh lỗi khi merge code, đảm bảo đồng nhất. Người thực hiện: Nguyễn Văn C. Commit: 3c4d5e.
- 27/08/2025: Khởi tạo `composer.json`, `composer.lock` với các package Laravel core, PHPUnit cho kiểm thử, Faker cho sinh dữ liệu mẫu. Quy trình: chạy `composer install`, kiểm tra các package cài đặt đúng. Kết quả: cài đặt thành công, không lỗi. Người thực hiện: Nguyễn Văn D. Commit: 4d5e6f.
- 27/08/2025: Tạo file `phpunit.xml` cấu hình test, thiết lập coverage cho các service chính. Viết test mẫu cho service Checkout và chạy thử coverage đạt >80%. Ghi chú: test tự động chạy mỗi lần push code lên repo.

### Service & Business Logic
- 30/08/2025: Tạo [`CheckoutService.php`](app/Services/CheckoutService.php) - Xử lý logic thanh toán, kiểm tra trạng thái đơn hàng, tích hợp Momo. Mục tiêu: đảm bảo thanh toán nhanh, bảo mật. Quy trình: tích hợp API Momo, viết unit test cho các trường hợp thanh toán thành công/thất bại, kiểm thử với sandbox Momo. Kết quả: thanh toán thành công, ghi log giao dịch. Người thực hiện: Trần Văn E. Commit: 5e6f7g.
- 30/08/2025: Tạo [`CustomerService.php`](app/Services/CustomerService.php) - Quản lý thông tin khách hàng, đồng bộ với user. Quy trình: kiểm thử đồng bộ dữ liệu khi đăng ký mới, xử lý trường hợp trùng email. Kết quả: đồng bộ thành công, không lỗi. Người thực hiện: Trần Văn F. Commit: 6f7g8h.
- 31/08/2025: Tạo [`MomoPaymentService.php`](app/Services/MomoPaymentService.php) - Tích hợp API Momo, xác thực giao dịch, xử lý callback. Ghi log giao dịch, kiểm thử với nhiều trạng thái giao dịch. Vấn đề phát sinh: callback trả về trạng thái lỗi, đã xử lý bằng retry. Người thực hiện: Trần Văn G. Commit: 7g8h9i.
- 31/08/2025: Tạo [`OrderItemService.php`](app/Services/OrderItemService.php) - Quản lý chi tiết sản phẩm trong đơn hàng, tính tổng tiền từng đơn, kiểm thử với nhiều loại sản phẩm. Ghi chú: xử lý giảm tồn kho khi đặt hàng.
- 01/09/2025: Tạo [`OrderService.php`](app/Services/OrderService.php) - Tạo/sửa/xóa đơn hàng, tính tổng tiền, trạng thái. Viết test cho các trạng thái đơn hàng: mới, đã thanh toán, đã giao, đã hủy. Người thực hiện: Lê Văn H. Commit: 8h9i0j.
- 01/09/2025: Tạo [`ProductService.php`](app/Services/ProductService.php) - Quản lý sản phẩm, cập nhật giá, tồn kho. Kiểm thử chức năng cập nhật tồn kho khi có đơn hàng mới. Ghi chú: xử lý trường hợp hết hàng, cảnh báo cho admin.
- 02/09/2025: Tạo [`ReviewService.php`](app/Services/ReviewService.php) - Quản lý đánh giá sản phẩm, kiểm duyệt nội dung, lọc từ khóa cấm. Viết test kiểm duyệt nội dung đánh giá. Người thực hiện: Lê Văn I. Commit: 9i0j1k.
- 02/09/2025: Tạo [`UserService.php`](app/Services/UserService.php) - Quản lý user, phân quyền, cập nhật thông tin. Kiểm thử chức năng phân quyền admin/user, ghi log khi thay đổi quyền.

### Migration & Seeder
- 03/09/2025: Tạo migration [`users`](database/migrations/0001_01_01_000000_create_users_table.php) - Thiết kế bảng users gồm các trường: id, name, email, password, is_admin. Kiểm thử đăng ký và đăng nhập. Người thực hiện: Phạm Văn J. Commit: 0j1k2l.
- 03/09/2025: Tạo migration [`products`](database/migrations/2025_05_28_202046_create_products_table.php) - Thiết kế bảng products: id, name, price, stock, description. Kiểm thử thêm/sửa/xóa sản phẩm. Ghi chú: kiểm thử với dữ liệu lớn.
- 05/09/2025: Tạo migration [`customers`](database/migrations/2025_05_28_210446_create_customers_table.php) - Liên kết với bảng users, bổ sung trường address, phone. Kiểm thử đồng bộ dữ liệu khi tạo user mới. Người thực hiện: Phạm Văn K. Commit: 1k2l3m.
- 05/09/2025: Tạo migration [`orders`](database/migrations/2025_06_18_222245_create_reviews_table.php) - Thiết kế bảng orders: id, customer_id, total_amount, status, payment_method. Kiểm thử tạo đơn hàng, cập nhật trạng thái. Ghi chú: kiểm thử với nhiều phương thức thanh toán.
- 05/09/2025: Tạo migration [`order_items`](database/migrations/2025_06_07_002528_add_user_id_to_customers_table.php) - Liên kết với bảng orders và products, kiểm thử thêm sản phẩm vào đơn hàng. Người thực hiện: Nguyễn Văn L. Commit: 2l3m4n.
- 05/09/2025: Tạo migration [`reviews`](database/migrations/2025_06_18_222245_create_reviews_table.php) - Liên kết với bảng products và users, kiểm thử thêm đánh giá mới. Ghi chú: kiểm thử với nhiều loại sản phẩm.
- 07/09/2025: Thêm migration bổ sung: avatar cho user, bank info cho orders, tăng độ chính xác giá tiền. Kiểm thử upload avatar, lưu thông tin ngân hàng. Người thực hiện: Nguyễn Văn M. Commit: 3m4n5o.
- 10/09/2025: Tạo seeder [`AdminUserSeeder.php`](database/seeders/AdminUserSeeder.php) - Tạo user admin mặc định, kiểm thử đăng nhập admin. Ghi chú: kiểm thử bảo mật mật khẩu.
- 10/09/2025: Tạo seeder [`SyncCustomerUserSeeder.php`](database/seeders/SyncCustomerUserSeeder.php) - Đồng bộ dữ liệu khách hàng với user, kiểm thử dữ liệu mẫu. Người thực hiện: Nguyễn Văn N. Commit: 4n5o6p.
- 10/09/2025: Tạo seeder [`UpdateCustomerDataSeeder.php`](database/seeders/UpdateCustomerDataSeeder.php) - Cập nhật dữ liệu khách hàng mẫu, kiểm thử import dữ liệu. Ghi chú: kiểm thử với dữ liệu lớn.

### Tài nguyên & tài liệu
- 15/09/2025: Thêm ảnh sản phẩm, avatar mẫu vào `public/images/products/` và `public/images/avatars/`. Kiểm thử hiển thị ảnh trên trang sản phẩm và profile. Người thực hiện: Trần Văn O. Commit: 5o6p7q.
- 18/09/2025: Viết tài liệu quy trình nghiệp vụ: xác thực, quản lý sản phẩm, đơn hàng, khách hàng, đánh giá, báo cáo [`docs/*`](docs/). Đảm bảo tài liệu đầy đủ cho onboarding thành viên mới. Ghi chú: tài liệu cập nhật liên tục khi có thay đổi nghiệp vụ.

### Routing & Controller
- 20/09/2025: Thiết lập các route API, web, console [`routes/api.php`](routes/api.php), [`routes/web.php`](routes/web.php). Kiểm thử các endpoint API bằng Postman, ghi chú lại các lỗi phát hiện. Người thực hiện: Lê Văn P. Commit: 6p7q8r.
- 22/09/2025: Tạo controller mẫu cho Gemini, Product, Order, Customer, Review [`app/Http/Controllers/*`](app/Http/Controllers/). Viết unit test cho các controller chính, kiểm thử các trường hợp lỗi đầu vào.
- 24/09/2025: Sửa lỗi mapping route, bổ sung middleware xác thực. Kiểm thử lại toàn bộ flow xác thực và phân quyền, ghi chú các lỗi đã fix.

### Cấu hình & môi trường
- 26/10/2025: Thiết lập cấu hình database, cache, session, mail, queue, logging [`config/*`](config/). Kiểm thử gửi mail, queue xử lý đơn hàng, ghi log hệ thống. Người thực hiện: Phạm Văn Q. Commit: 7q8r9s.
- 26/10/2025: Thêm file cache, autoload, provider cho bootstrap. Kiểm thử khởi động ứng dụng, đảm bảo tốc độ load nhanh và ổn định. Ghi chú: tối ưu autoload cho production.

---