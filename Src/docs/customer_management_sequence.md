# Sequence Diagram Quản lý Khách hàng

## 1. Tạo mới khách hàng
```mermaid
sequenceDiagram
    actor Admin
    participant View (customers/create.blade.php)
    participant CustomerController
    participant Customer Model

    Admin->>View: Truy cập form tạo khách hàng
    View-->>Admin: Hiển thị form
    Admin->>View: Nhập thông tin (name, email, phone)
    View->>CustomerController: POST /customers
    CustomerController->>CustomerController: Validate data
    CustomerController->>Customer Model: create()
    Customer Model-->>CustomerController: Customer created
    CustomerController-->>Admin: Redirect với thông báo
```

## 2. Cập nhật thông tin khách hàng
```mermaid
sequenceDiagram
    actor Admin
    participant View (customers/edit.blade.php)
    participant CustomerController
    participant Customer Model

    Admin->>View: Truy cập form sửa khách hàng
    View-->>Admin: Hiển thị form với data hiện tại
    Admin->>View: Cập nhật thông tin
    View->>CustomerController: PUT /customers/{customer}
    CustomerController->>Customer Model: findOrFail(customer)
    CustomerController->>CustomerController: Validate data
    CustomerController->>Customer Model: update()
    Customer Model-->>CustomerController: Customer updated
    CustomerController-->>Admin: Redirect với thông báo
```

## 3. Xem danh sách khách hàng
```mermaid
sequenceDiagram
    actor Admin
    participant View (customers/index.blade.php)
    participant CustomerController
    participant Customer Model

    Admin->>View: Truy cập trang danh sách
    View->>CustomerController: GET /customers
    CustomerController->>Customer Model: with('user')->paginate()
    Customer Model-->>CustomerController: Danh sách khách hàng
    CustomerController-->>View: Trả về dữ liệu
    View-->>Admin: Hiển thị danh sách
```

## 4. Xem lịch sử đơn hàng của khách hàng
```mermaid
sequenceDiagram
    actor Admin
    participant View (customers/orders.blade.php)
    participant CustomerController
    participant Customer Model
    participant Order Model

    Admin->>View: Click "Xem đơn hàng"
    View->>CustomerController: GET /customers/{customer}/orders
    CustomerController->>Customer Model: findOrFail(customer)
    CustomerController->>Order Model: get orders with items
    Order Model-->>CustomerController: Danh sách đơn hàng
    CustomerController-->>View: Trả về dữ liệu
    View-->>Admin: Hiển thị lịch sử đơn hàng