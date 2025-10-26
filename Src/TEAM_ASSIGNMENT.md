# 🌸 Kế hoạch Phân chia Dự án FlowerShop cho 5 Người

## 📋 Tổng quan Dự án

**Dự án:** FlowerShop - Hệ thống Cửa hàng Hoa Trực tuyến Laravel
**Thành viên:** 5 người
**Tech Stack:** Laravel 12.x, MySQL, TailwindCSS, Blade Templates

## 👥 Phân công Chi tiết

### 🔐 **Nguyễn Xuân Mạnh(A): Authentication & User Management Lead**
**Chuyên môn:** Backend Authentication, Security, User Management

#### Trách nhiệm chính:
- **Authentication System** 
  - Đăng ký, đăng nhập, đăng xuất
  - Reset password, remember token
  - Middleware authentication & authorization
  - Laravel Breeze integration

- **User & Profile Management**
  - [`ProfileController.php`](app/Http/Controllers/ProfileController.php)
  - [`AuthController.php`](app/Http/Controllers/AuthController.php) 
  - [`UserService.php`](app/Services/UserService.php)
  - User avatar upload & management

- **Security Implementation**
  - CSRF protection
  - Input validation & sanitization
  - Rate limiting
  - Security middleware

#### Files chịu trách nhiệm:
```
app/Http/Controllers/AuthController.php
app/Http/Controllers/ProfileController.php
app/Services/UserService.php
app/Repositories/UserRepository.php
app/Models/User.php
resources/views/auth/
resources/views/profile/
database/migrations/*_users_table.php
tests/Feature/AuthTest.php
```

#### Deliverables:
- [ ] Complete authentication flow
- [ ] User profile management
- [ ] Security implementation 
- [ ] Unit tests cho auth functions
- [ ] Documentation cho security best practices

---

### 🛍️ **Đoàn Quang Minh(B): Product Management & Catalog Lead**
**Chuyên môn:** Product CRUD, Search, File Upload, Frontend

#### Trách nhiệm chính:
- **Product Management System**
  - [`ProductController.php`](app/Http/Controllers/ProductController.php)
  - [`ProductService.php`](app/Services/ProductService.php)
  - Product CRUD operations
  - Image upload & management

- **Product Catalog & Search**
  - Product listing, pagination
  - Search & filter functionality
  - Product suggestions
  - Analytics dashboard cho products

- **Frontend Product Views**
  - Product shop interface
  - Product detail pages
  - Image gallery & management
  - Responsive product cards

#### Files chịu trách nhiệm:
```
app/Http/Controllers/ProductController.php
app/Services/ProductService.php
app/Repositories/ProductRepository.php
app/Models/Product.php
resources/views/products/
public/images/products/
database/migrations/*_products_table.php
tests/Feature/ProductTest.php
```

#### Deliverables:
- [ ] Complete product CRUD system
- [ ] Image upload & management
- [ ] Search & filter functionality
- [ ] Product analytics dashboard
- [ ] Responsive product interfaces

---

### 🛒 **Vũ Minh Trung(C): Cart & Checkout System Lead**
**Chuyên môn:** E-commerce Logic, Payment Integration, Session Management

#### Trách nhiệm chính:
- **Shopping Cart System**
  - [`CartController.php`](app/Http/Controllers/CartController.php)
  - Session-based cart management
  - Cart operations (add, update, remove)
  - Buy now functionality

- **Checkout & Payment Processing**
  - [`CheckoutController.php`](app/Http/Controllers/CheckoutController.php)
  - [`CheckoutService.php`](app/Services/CheckoutService.php)
  - [`MomoPaymentService.php`](app/Services/MomoPaymentService.php)
  - Multiple payment methods (COD, Bank Transfer, MoMo)

- **Order Processing Logic**
  - Order creation workflow
  - Payment validation
  - Order confirmation emails
  - Integration với payment gateways

#### Files chịu trách nhiệm:
```
app/Http/Controllers/CartController.php
app/Http/Controllers/CheckoutController.php
app/Services/CheckoutService.php
app/Services/MomoPaymentService.php
resources/views/cart/
resources/views/checkout.blade.php
tests/Feature/CartTest.php
tests/Feature/CheckoutTest.php
```

#### Deliverables:
- [ ] Complete cart functionality
- [ ] Multi-payment checkout system
- [ ] Payment gateway integrations
- [ ] Order processing workflow
- [ ] Cart & checkout testing

---

### 📦 **Nguyễn Tường Hưng(D): Order Management & Customer Service Lead**
**Chuyên môn:** Order Lifecycle, Customer Management, Business Logic

#### Trách nhiệm chính:
- **Order Management System**
  - [`OrderController.php`](app/Http/Controllers/OrderController.php)
  - [`OrderService.php`](app/Services/OrderService.php)
  - [`OrderItemService.php`](app/Services/OrderItemService.php)
  - Order status tracking & updates

- **Customer Management**
  - [`CustomerController.php`](app/Http/Controllers/CustomerController.php)
  - [`CustomerService.php`](app/Services/CustomerService.php)
  - Customer information management
  - Customer order history

- **Order Processing Workflow**
  - Order lifecycle management
  - Status updates (pending, processing, shipped, delivered)
  - Order cancellation logic
  - Delivery confirmation

#### Files chịu trách nhiệm:
```
app/Http/Controllers/OrderController.php
app/Http/Controllers/CustomerController.php
app/Services/OrderService.php
app/Services/OrderItemService.php
app/Services/CustomerService.php
app/Repositories/OrderRepository.php
app/Repositories/CustomerRepository.php
app/Models/Order.php
app/Models/OrderItem.php
app/Models/Customer.php
resources/views/orders/
resources/views/customers/
tests/Feature/OrderTest.php
```

#### Deliverables:
- [ ] Complete order management system
- [ ] Customer management interface
- [ ] Order status tracking
- [ ] Order history & reporting
- [ ] Customer service tools

---

### 🎯 **Nguyễn Thị Kiều Trinh(E): Admin Dashboard & Review System Lead**
**Chuyên môn:** Admin Interface, Analytics, Review System, UI/UX

#### Trách nhiệm chính:
- **Admin Dashboard & Analytics**
  - [`AdminController.php`](app/Http/Controllers/AdminController.php)
  - Admin dashboard với statistics
  - Business analytics & reporting
  - System monitoring tools

- **Review & Rating System**
  - [`ReviewService.php`](app/Services/ReviewService.php)
  - Product review functionality
  - Rating system (1-5 stars)
  - Review moderation tools

- **Frontend & UI Coordination**
  - Overall UI/UX consistency
  - Responsive design implementation
  - Component standardization
  - Cross-browser compatibility

- **System Integration & Testing**
  - Integration testing
  - End-to-end testing
  - Performance optimization
  - Deployment preparation

#### Files chịu trách nhiệm:
```
app/Http/Controllers/AdminController.php
app/Services/ReviewService.php
app/Repositories/ReviewRepository.php
app/Models/Review.php
resources/views/admin/
resources/views/layouts/
resources/views/components/
resources/css/app.css
resources/js/
tests/Feature/AdminTest.php
tests/Feature/ReviewTest.php
```

#### Deliverables:
- [ ] Complete admin dashboard
- [ ] Review & rating system
- [ ] UI/UX standardization
- [ ] Integration testing suite
- [ ] Performance optimization

---

## 🔗 Dependencies Matrix

| Người | Phụ thuộc vào | Cung cấp cho |
|-------|---------------|--------------|
| **Người A (Auth)** | - | Tất cả (User authentication) |
| **Người B (Product)** | Người A (User system) | Người C,D,E (Product data) |
| **Người C (Cart)** | Người A,B (User, Product) | Người D (Order creation) |
| **Người D (Order)** | Người A,B,C (User, Product, Cart) | Người E (Order data) |
| **Người E (Admin)** | Người A,B,D (User, Product, Order) | All (UI components) |

## 📅 Timeline & Milestones

### Phase 1: Foundation (Tuần 1-2)
- **Người A:** Authentication system hoàn chỉnh
- **Người B:** Product model và basic CRUD
- **Người E:** Layout templates và UI components

### Phase 2: Core Features (Tuần 3-4)
- **Người B:** Product catalog với search
- **Người C:** Cart system hoàn chỉnh
- **Người D:** Basic order management

### Phase 3: Integration (Tuần 5-6)
- **Người C:** Checkout system với payment
- **Người D:** Complete order workflow
- **Người D:** Admin dashboard

### Phase 4: Testing & Polish (Tuần 7-8)
- Tất cả: Integration testing
- **Người E:** Performance optimization
- Bug fixes và documentation

## 🛠️ Development Guidelines

### Git Workflow
```bash
# Branch naming convention
feature/auth-system          # Người A
feature/product-management   # Người B 
feature/cart-checkout       # Người C
feature/order-management    # Người D
feature/admin-dashboard     # Người E
```

### Testing Standards
- **Unit Tests:** Mỗi service class phải có ≥80% coverage
- **Feature Tests:** Mỗi controller method phải có test
- **Integration Tests:** Người E chịu trách nhiệm end-to-end testing

### Code Review Process
1. Tạo PR từ feature branch
2. Assign reviewer (thường là người phụ thuộc vào code)
3. Required approvals: minimum 2 người
4. Merge sau khi pass all tests

### Communication Channels
- **Daily Standups:** 9:00 AM mỗi ngày
- **Code Review:** Slack/Discord
- **Technical Discussions:** Weekly team meetings
- **Documentation:** Confluence/Notion

## 📚 Resources & References

### Technical Documentation
- [Laravel 12.x Documentation](https://laravel.com/docs)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [PHPUnit Testing Guide](https://phpunit.de/documentation.html)

### Project Specific
- [`README.md`](README.md) - Project setup instructions
- [`AGENTS.md`](AGENTS.md) - Development standards
- `docs/` folder - Sequence diagrams và technical specs

### Coding Standards
- Follow PSR-12 standards
- Use Laravel best practices
- Implement repository pattern
- Service layer cho business logic
- Comprehensive error handling

---

## 🚀 Success Criteria

### Individual Goals
- [ ] Hoàn thành 100% assigned features
- [ ] Code coverage ≥80% cho core functionality  
- [ ] Zero critical security vulnerabilities
- [ ] Documentation đầy đủ cho assigned modules

### Team Goals
- [ ] All user stories completed
- [ ] System performance targets met
- [ ] Successful deployment to production
- [ ] Comprehensive test suite
- [ ] Clean, maintainable codebase

---

*Tài liệu này sẽ được cập nhật định kỳ theo tiến độ dự án và feedback từ team.*