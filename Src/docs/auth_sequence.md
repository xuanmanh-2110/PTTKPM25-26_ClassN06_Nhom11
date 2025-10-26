# Sequence Diagram Quản lý Xác thực

## 1. Đăng ký tài khoản
```mermaid
sequenceDiagram
    actor User
    participant View (register.blade.php)
    participant AuthController
    participant User Model
    participant Auth

    User->>View: Truy cập form đăng ký
    View-->>User: Hiển thị form
    User->>View: Nhập thông tin (name, email, password)
    View->>AuthController: POST /register
    AuthController->>AuthController: Validate data
    alt Validation fail
        AuthController-->>View: Hiển thị lỗi
    else Validation pass
        AuthController->>User Model: create()
        User Model-->>AuthController: User created
        AuthController->>Auth: attempt(email, password)
        Auth-->>AuthController: Login success
        AuthController-->>User: Redirect to home
    end
```

## 2. Đăng nhập
```mermaid
sequenceDiagram
    actor User
    participant View (login.blade.php)
    participant AuthController
    participant Auth

    User->>View: Truy cập form đăng nhập
    View-->>User: Hiển thị form
    User->>View: Nhập thông tin (email/name, password)
    View->>AuthController: POST /login
    AuthController->>AuthController: Validate data
    AuthController->>Auth: attempt(credentials)
    alt Authentication success
        Auth-->>AuthController: Login success
        AuthController-->>User: Redirect to home
    else Authentication fail
        Auth-->>AuthController: Login failed
        AuthController-->>View: Hiển thị lỗi
    end
```

## 3. Đăng xuất
```mermaid
sequenceDiagram
    actor User
    participant View
    participant AuthController
    participant Auth
    participant Session

    User->>View: Click nút đăng xuất
    View->>AuthController: POST /logout
    AuthController->>Auth: logout()
    AuthController->>Session: invalidate()
    AuthController->>Session: regenerateToken()
    AuthController-->>User: Redirect to home