# Sequence Diagram Quy trình Thống kê Báo cáo

## 1. Thống kê sản phẩm
```mermaid
sequenceDiagram
    actor Admin
    participant View (products/analytics.blade.php)
    participant ProductController
    participant Product Model
    participant OrderItem Model

    Admin->>View: Truy cập trang thống kê
    View->>ProductController: GET /products/{product}/analytics
    ProductController->>Product Model: findOrFail(product)
    ProductController->>OrderItem Model: get sales data
    ProductController->>Product Model: get reviews data
    ProductController-->>View: Trả về dữ liệu thống kê
    View-->>Admin: Hiển thị biểu đồ và số liệu
```

## 2. Thống kê đơn hàng
```mermaid
sequenceDiagram
    actor Admin
    participant View (orders/index.blade.php)
    participant OrderController
    participant Order Model

    Admin->>View: Truy cập trang đơn hàng
    View->>OrderController: GET /orders
    OrderController->>Order Model: filter by date/status
    OrderController->>Order Model: calculate totals
    OrderController-->>View: Trả về dữ liệu
    View-->>Admin: Hiển thị báo cáo
```

## 3. Thống kê doanh thu
```mermaid
sequenceDiagram
    actor Admin
    participant View
    participant OrderController
    participant Order Model

    Admin->>View: Chọn khoảng thời gian
    View->>OrderController: GET /orders?from=...&to=...
    OrderController->>Order Model: sum total_amount
    OrderController->>Order Model: group by period
    OrderController-->>View: Trả về doanh thu
    View-->>Admin: Hiển thị biểu đồ
```

## 4. Thống kê đánh giá
```mermaid
sequenceDiagram
    actor Admin
    participant View
    participant ProductController
    participant Review Model

    Admin->>View: Truy cập trang đánh giá
    View->>ProductController: GET /products/{product}/analytics
    ProductController->>Review Model: get rating distribution
    ProductController->>Review Model: calculate average
    ProductController-->>View: Trả về dữ liệu
    View-->>Admin: Hiển thị phân bố đánh giá