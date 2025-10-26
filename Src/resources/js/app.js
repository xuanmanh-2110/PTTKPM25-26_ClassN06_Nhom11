// Thêm hàm xử lý chuyển section cho admin dashboard
function showSection(section) {
    // Lưu section vào localStorage
    localStorage.setItem('adminSection', section);
    // Ẩn tất cả các section
    document.querySelectorAll('.admin-section').forEach(el => {
        el.style.display = 'none';
    });
    // Hiện đúng section được chọn
    var target = document.getElementById(section + '-section');
    if (target) {
        target.style.display = 'block';
    }
}
window.showSection = showSection;
import './bootstrap';

// Tự động hiện section theo query param ?section=...
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const section = params.get('section');
    if (section) {
        showSection(section);
    } else {
        // Nếu không có query param, lấy section từ localStorage
        const lastSection = localStorage.getItem('adminSection');
        if (lastSection) {
            showSection(lastSection);
        }
    }
});

