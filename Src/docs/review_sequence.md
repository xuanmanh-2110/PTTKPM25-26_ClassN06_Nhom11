# Sequence Diagram Quy trình Đánh giá Sản phẩm

## 1. Thêm đánh giá
```mermaid
sequenceDiagram
    actor User
    participant View (products/show.blade.php)
    participant ProductController
    participant Review Model
    participant Product Model

    User->>View: Nhập đánh giá (rating, content)
    View->>ProductController: POST /products/{product}/reviews
    ProductController->>ProductController: Validate data
    ProductController->>Review Model: create new review
    Review Model->>Product Model: attach to product
    ProductController-->>User: JSON response/redirect
```

## 2. Cập nhật đánh giá
```mermaid
sequenceDiagram
    actor User
    participant View
    participant ProductController
    participant Review Model

    User->>View: Click "Sửa đánh giá"
    View->>ProductController: PUT /reviews/{review}
    ProductController->>Review Model: findOrFail(review)
    ProductController->>ProductController: Check permission
    ProductController->>Review Model: update review
    ProductController-->>User: JSON response
```

## 3. Xóa đánh giá
```mermaid
sequenceDiagram
    actor User
    participant View
    participant ProductController
    participant Review Model

    User->>View: Click "Xóa đánh giá"
    View->>ProductController: DELETE /reviews/{review}
    ProductController->>Review Model: findOrFail(review)
    ProductController->>ProductController: Check permission
    ProductController->>Review Model: delete review
    ProductController-->>User: JSON response
```

## 4. Hiển thị đánh giá
```mermaid
sequenceDiagram
    actor User
    participant View (products/show.blade.php)
    participant ProductController
    participant Product Model
    participant Review Model

    User->>View: Truy cập trang chi tiết sản phẩm
    View->>ProductController: GET /products/{product}
    ProductController->>Product Model: findOrFail(product)
    ProductController->>Review Model: get reviews for product
    ProductController-->>View: Trả về dữ liệu
    View-->>User: Hiển thị danh sách đánh giá