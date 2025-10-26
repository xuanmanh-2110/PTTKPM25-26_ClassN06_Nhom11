# Sequence Diagram Quản lý Sản phẩm

## 1. Thêm sản phẩm mới
```mermaid
sequenceDiagram
    actor User
    participant View (create.blade.php)
    participant ProductController
    participant Product Model
    participant Storage

    User->>View: Truy cập form thêm sản phẩm
    View-->>User: Hiển thị form
    User->>View: Nhập thông tin + ảnh
    View->>ProductController: POST /products (store)
    ProductController->>ProductController: Validate data
    alt Validation fail
        ProductController-->>View: Hiển thị lỗi
    else Validation pass
        ProductController->>Storage: Lưu ảnh
        Storage-->>ProductController: Trả về path ảnh
        ProductController->>Product Model: create()
        Product Model-->>ProductController: Product created
        ProductController-->>User: Redirect to list with success
    end
```

## 2. Cập nhật sản phẩm
```mermaid
sequenceDiagram
    actor User
    participant View (edit.blade.php)
    participant ProductController
    participant Product Model
    participant Storage

    User->>View: Truy cập form sửa sản phẩm
    View-->>User: Hiển thị form với data hiện tại
    User->>View: Cập nhật thông tin + ảnh (nếu có)
    View->>ProductController: PUT /products/{product} (update)
    ProductController->>ProductController: Validate data
    alt Validation fail
        ProductController-->>View: Hiển thị lỗi
    else Validation pass
        alt Có upload ảnh mới
            ProductController->>Storage: Xóa ảnh cũ
            ProductController->>Storage: Lưu ảnh mới
            Storage-->>ProductController: Trả về path ảnh mới
        end
        ProductController->>Product Model: update()
        Product Model-->>ProductController: Product updated
        ProductController-->>User: Redirect to list with success
    end
```

## 3. Xóa sản phẩm
```mermaid
sequenceDiagram
    actor User
    participant View (index.blade.php)
    participant ProductController
    participant Product Model
    participant Storage

    User->>View: Click nút xóa
    View->>ProductController: DELETE /products/{product} (destroy)
    ProductController->>Storage: Xóa ảnh (nếu có)
    ProductController->>Product Model: delete()
    Product Model-->>ProductController: Product deleted
    ProductController-->>User: Redirect to list with success
```

## 4. Xem chi tiết sản phẩm
```mermaid
sequenceDiagram
    actor User
    participant View (show.blade.php)
    participant ProductController
    participant Product Model
    participant Review Model

    User->>View: Truy cập trang chi tiết
    View->>ProductController: GET /products/{product} (show)
    ProductController->>Product Model: Find product
    ProductController->>Review Model: Get reviews
    ProductController->>Product Model: Get related products
    Product Model-->>ProductController: Product data
    Review Model-->>ProductController: Reviews data
    ProductController-->>View: Render view with data
    View-->>User: Hiển thị chi tiết sản phẩm