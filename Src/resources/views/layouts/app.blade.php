<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'FlowerShop')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- Vite managed assets: app.css (with Tailwind) and app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-rose-800 m-0 p-0">
    @yield('content')
    <script>
        var btn = document.querySelector('.dropdown > .btn');
        var menu = document.querySelector('.dropdown-menu');

        if(btn && menu) {
            function toggleDropdown() {
                if (menu.style.display === 'block') {
                    menu.style.display = 'none';
                } else {
                    menu.style.display = 'block';
                }
            }

            btn.addEventListener('click', function(event) {
                event.stopPropagation();
                toggleDropdown();
            });

            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.style.display = 'none';
                }
            });

            menu.addEventListener('click', function(e) {
                if (e.target.classList.contains('dropdown-item')) {
                    menu.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('search-input');
            const suggestions = document.getElementById('search-suggestions');
            const form = document.getElementById('search-form');
            if (input) {
                input.addEventListener('input', function() {
                    const q = input.value.trim();
                    if (q.length < 2) {
                        suggestions.style.display = 'none';
                        suggestions.innerHTML = '';
                        return;
                    }
                    fetch('/products/suggest?q=' + encodeURIComponent(q))
                        .then(res => res.json())
                        .then(data => {
                            if (data.length === 0) {
                                suggestions.style.display = 'none';
                                suggestions.innerHTML = '';
                                return;
                            }
                            suggestions.innerHTML = data.map(item =>
                                `<div class="p-2 cursor-pointer hover:bg-rose-500 hover:text-white text-rose-700" onclick="window.location='/shop?search=${encodeURIComponent(item.name)}'">${item.name}</div>`
                            ).join('');
                            suggestions.style.display = 'block';
                        });
                });
                document.addEventListener('click', function(e) {
                    if (!suggestions.contains(e.target) && e.target !== input) {
                        suggestions.style.display = 'none';
                    }
                });
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const q = input.value.trim();
                    if (q.length > 0) {
                        window.location = '/shop?search=' + encodeURIComponent(q);
                    }
                });
            }

            var btnHero = document.getElementById('order-now-btn');
            if (btnHero) {
                btnHero.addEventListener('click', function() {
                    window.location.href = 'http://127.0.0.1:8000/shop';
                });
            }
            var btnPromo = document.getElementById('order-now-btn-promo');
            if (btnPromo) {
                btnPromo.addEventListener('click', function() {
                    window.location.href = 'http://127.0.0.1:8000/shop';
                });
            }

            var slides = document.querySelectorAll('.hero-slide-img');
            var total = slides.length;
            var idx = 0;
            if (total > 1) {
                setInterval(function() {
                    slides[idx].style.transform = 'translateX(100%)';
                    slides[idx].style.opacity = '0';
                    var nextIdx = (idx + 1) % total;
                    slides[nextIdx].style.transform = 'translateX(0)';
                    slides[nextIdx].style.opacity = '1';
                    for (var i = 0; i < total; i++) {
                        if (i !== idx && i !== nextIdx) {
                            slides[i].style.transform = 'translateX(-100%)';
                            slides[i].style.opacity = '0';
                        }
                    }
                    idx = nextIdx;
                }, 5000);
            }
        });
    </script>
    <style>
        #gemini-chat-bubble {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            background-color: #f43f5e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9998;
            transition: transform 0.2s ease;
        }
        #gemini-chat-bubble:hover {
            transform: scale(1.1);
        }

        #gemini-chat-widget {
            position: fixed;
            bottom: 100px;
            right: 25px;
            width: 350px;
            max-width: 90vw;
            height: 450px;
            max-height: 70vh;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 9999;
        }


        #gemini-chat-header {

            background-color: #f43f5e;
            color: white;
            padding: 12px 15px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #gemini-chat-close {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }


        #gemini-chat-log {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #f9fafb;
        }
        #gemini-chat-log .gemini-message {
            margin-bottom: 12px;
            max-width: 85%;
            padding: 8px 12px;
            border-radius: 10px;
            line-height: 1.4;
        }
        #gemini-chat-log .gemini-user {
            background-color: #d1d5db;
            color: #1f2937;
            margin-left: auto;
            border-bottom-right-radius: 2px;
        }
        #gemini-chat-log .gemini-bot {
            background-color: #fee2e2;
            color: #1f2937;
            margin-right: auto;
            border-bottom-left-radius: 2px;
        }

        .gemini-bot.loading::after {
            content: '...';
            display: inline-block;
            animation: loadingDots 1s infinite steps(3, end);
        }
        @keyframes loadingDots {
            0% { content: '.'; }
            33% { content: '..'; }
            66% { content: '...'; }
        }


        #gemini-chat-input-area {
            display: flex;
            border-top: 1px solid #e5e7eb;
            padding: 10px;
        }
        #gemini-message-input {
            flex-grow: 1;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 12px;
            outline: none;
        }
        #gemini-send-button {
            border: none;
            background-color: #f43f5e;
            color: white;
            border-radius: 8px;
            padding: 0 15px;
            margin-left: 8px;
            cursor: pointer;
        }
        #gemini-send-button:hover {
            background-color: #e11d48;
        }
    </style>

    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <div id="gemini-chat-bubble">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 32px; height: 32px;">
    @endif
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
        </svg>
    </div>

    <div id="gemini-chat-widget">
        <div id="gemini-chat-header">
            <span>FlowerBot AI 🌸</span>
            <span id="gemini-chat-close">&times;</span>
        </div>

        <div id="gemini-chat-log">
            <div class="gemini-message gemini-bot">Chào bạn! Tôi có thể tư vấn về hoa giúp bạn.</div>
        </div>

        <div id="gemini-chat-input-area">
            <input type="text" id="gemini-message-input" placeholder="Nhập câu hỏi...">
            <button id="gemini-send-button">Gửi</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lấy các phần tử DOM
            const bubble = document.getElementById('gemini-chat-bubble');
            const widget = document.getElementById('gemini-chat-widget');
            const closeButton = document.getElementById('gemini-chat-close');
            const chatLog = document.getElementById('gemini-chat-log');
            const messageInput = document.getElementById('gemini-message-input');
            const sendButton = document.getElementById('gemini-send-button');

            // Lấy CSRF token từ thẻ meta
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Hàm bật/tắt widget
            function toggleChat() {
                if (widget.style.display === 'flex') {
                    widget.style.display = 'none';
                } else {
                    widget.style.display = 'flex';
                }
            }

            // Gán sự kiện click
            bubble.addEventListener('click', toggleChat);
            closeButton.addEventListener('click', toggleChat);

            // Gửi tin nhắn khi nhấn Enter
            messageInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            // Gửi tin nhắn khi nhấn nút Gửi
            sendButton.addEventListener('click', sendMessage);

            // Hàm Gửi tin nhắn
            async function sendMessage() {
                const message = messageInput.value.trim();
                if (message === '') return;

                // Hiển thị tin nhắn của người dùng
                appendMessage(message, 'user');
                messageInput.value = '';

                const loadingElement = appendMessage('...', 'bot');
                loadingElement.classList.add('loading');

                try {
                    // Gọi API backend /api/chat-gemini
                    const response = await fetch('/api/chat-gemini', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ message: message })
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error('API Error:', errorData);
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    // Xóa trạng thái loading và cập nhật tin nhắn thật của bot
                    loadingElement.classList.remove('loading');
                    // Kiểm tra xem 'reply' có tồn tại không
                    loadingElement.textContent = data.reply ? data.reply : 'Xin lỗi, tôi không thể xử lý yêu cầu này.';


                } catch (error) {
                    console.error('Error:', error);
                    // Xóa trạng thái loading và báo lỗi
                    loadingElement.classList.remove('loading');
                    loadingElement.textContent = 'Đã có lỗi xảy ra. Vui lòng thử lại.';
                }

                // Cuộn xuống tin nhắn mới nhất
                chatLog.scrollTop = chatLog.scrollHeight;
            }

            // Hàm thêm tin nhắn vào khung chat
            function appendMessage(text, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('gemini-message', `gemini-${sender}`);
                messageElement.textContent = text;
                chatLog.appendChild(messageElement);
                chatLog.scrollTop = chatLog.scrollHeight; // Tự động cuộn
                return messageElement; // Trả về phần tử để xử lý loading
            }
        });
    </script>
</body>
</html>
