# Sequence Diagram Quy trình Thanh toán Chi tiết

```mermaid
sequenceDiagram
    actor User
    participant View (checkout.blade.php)
    participant CheckoutController
    participant Session
    participant User Model
    participant Customer Model
    participant Order Model
    participant OrderItem Model
    participant Product Model

    User->>View: Truy cập trang thanh toán
    View->>CheckoutController: GET /checkout
    CheckoutController->>Session: get('cart')
    CheckoutController->>User Model: get current user
    CheckoutController->>Customer Model: findOrCreate by email
    CheckoutController->>Order Model: get last order (nếu có)
    CheckoutController-->>View: Trả về trang thanh toán với dữ liệu

    User->>View: Nhập thông tin (địa chỉ, phone, payment)
    View->>CheckoutController: POST /checkout
    CheckoutController->>CheckoutController: Validate data
    CheckoutController->>Order Model: create new order
    loop Cho từng sản phẩm trong giỏ
        CheckoutController->>Product Model: findOrFail(product_id)
        CheckoutController->>OrderItem Model: create order item
    end
    CheckoutController->>Order Model: update total_amount
    CheckoutController->>Session: forget('cart')
    CheckoutController-->>User: Redirect đến trang chi tiết đơn hàng