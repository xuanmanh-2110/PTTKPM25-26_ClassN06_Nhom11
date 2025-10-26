# Sequence Diagram Quy trình Đặt hàng

## 1. Thêm sản phẩm vào giỏ hàng
```mermaid
sequenceDiagram
    actor User
    participant View (shop.blade.php)
    participant CartController
    participant Product Model
    participant Session

    User->>View: Click "Thêm vào giỏ"
    View->>CartController: POST /cart/add/{id}
    CartController->>Product Model: findOrFail(id)
    CartController->>Session: get('cart')
    alt Sản phẩm đã có trong giỏ
        CartController->>CartController: Cập nhật số lượng
    else Sản phẩm mới
        CartController->>CartController: Thêm sản phẩm mới
    end
    CartController->>Session: put('cart', updatedCart)
    CartController-->>User: Redirect/JSON response
```

## 2. Thanh toán
```mermaid
sequenceDiagram
    actor User
    participant View (cart/index.blade.php)
    participant CheckoutController
    participant Session
    participant User Model
    participant Order Model

    User->>View: Click "Thanh toán"
    View->>CheckoutController: GET /checkout
    CheckoutController->>Session: get('cart')
    CheckoutController->>User Model: get current user
    CheckoutController->>Order Model: get last order (nếu có)
    CheckoutController-->>View: Trả về trang thanh toán
    User->>View: Nhập thông tin giao hàng
    View->>CheckoutController: POST /checkout
    CheckoutController->>CheckoutController: Validate data
    CheckoutController->>Order Model: create new order
    CheckoutController->>Session: forget('cart')
    CheckoutController-->>User: Redirect đến trang đơn hàng
```

## 3. Xử lý đơn hàng
```mermaid
sequenceDiagram
    actor Admin
    participant View (orders/index.blade.php)
    participant OrderController
    participant Order Model

    Admin->>View: Truy cập trang quản lý đơn hàng
    View->>OrderController: GET /orders
    OrderController->>Order Model: with('customer', 'items.product')
    OrderController-->>View: Trả về danh sách đơn hàng
    Admin->>View: Click "Cập nhật trạng thái"
    View->>OrderController: POST /orders/{id}/update-status
    OrderController->>Order Model: findOrFail(id)
    OrderController->>Order Model: update status
    OrderController-->>Admin: Redirect với thông báo