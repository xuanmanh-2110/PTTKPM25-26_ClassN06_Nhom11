@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <a href="{{ url('/') }}" class="inline-flex items-center space-x-2 bg-rose-100 hover:bg-rose-200 text-rose-600 font-bold py-2 px-4 rounded-md shadow-md transition-colors duration-200 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span>Quay lại trang chính</span>
    </a>
    
    <h2 class="text-3xl font-bold text-rose-600 mb-6 text-center flex items-center justify-center space-x-3">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <span>Admin Dashboard</span>
    </h2>

    @if(session('success'))
        <div id="success-notification" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="error-notification" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Tổng sản phẩm</h3>
                    <p class="text-3xl font-bold text-rose-600">{{ $stats['total_products'] }}</p>
                </div>
                <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Tổng khách hàng</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_customers'] }}</p>
                </div>
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Tổng đơn hàng</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_orders'] }}</p>
                </div>
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Tổng người dùng</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] }}</p>
                </div>
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Layout với sidebar -->
    <div class="flex gap-6">
        <!-- Sidebar -->
        <div class="w-64 bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Quản lý</span>
            </h3>
            <nav class="space-y-2">
                <button onclick="showSection('products')" class="w-full text-left px-3 py-2 rounded hover:bg-rose-50 hover:text-rose-600 transition-colors sidebar-item flex items-center space-x-2" data-section="products">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Quản lý sản phẩm</span>
                </button>
                <button onclick="showSection('customers')" class="w-full text-left px-3 py-2 rounded hover:bg-rose-50 hover:text-rose-600 transition-colors sidebar-item flex items-center space-x-2" data-section="customers">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>Quản lý khách hàng</span>
                </button>
                <button onclick="showSection('orders')" class="w-full text-left px-3 py-2 rounded hover:bg-rose-50 hover:text-rose-600 transition-colors sidebar-item active flex items-center space-x-2" data-section="orders">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Quản lý đơn hàng</span>
                </button>
                <button onclick="showSection('statistics')" class="w-full text-left px-3 py-2 rounded hover:bg-rose-50 hover:text-rose-600 transition-colors sidebar-item flex items-center space-x-2" data-section="statistics">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Thống kê đơn hàng</span>
                </button>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1">
            <!-- Products Section -->
            <div id="products-section" class="admin-section" style="display:none">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Quản lý sản phẩm</span>
                        </h3>
                        <a href="{{ route('products.create') }}" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-4 rounded transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Thêm sản phẩm mới</span>
                        </a>
                    </div>

                    <!-- Form tìm kiếm sản phẩm -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-6">
                        <input type="hidden" name="section" value="products">
                        <div class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Tìm kiếm sản phẩm..." 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-4 rounded transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>Tìm kiếm</span>
                            </button>
                        </div>
                    </form>

                    <!-- Bảng sản phẩm -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hình ảnh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên sản phẩm</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->image)
                                                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">Không có ảnh</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($product->price) }} VND</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <div class="mb-2 text-xs text-gray-700">
                                                Đã bán: <span class="font-semibold text-rose-600">{{ $product->order_items_sum_quantity ?? 0 }}</span> sản phẩm
                                            </div>
                                            <a href="{{ url('/products/' . $product->id . '/analytics') }}" class="text-green-600 hover:text-green-900 inline-flex items-center space-x-1 mr-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6"></path>
                                                </svg>
                                                <span>Thống kê</span>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                <span>Sửa</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.destroyProduct', $product) }}" class="inline delete-form" data-product-id="{{ $product->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-600 hover:text-red-900 delete-btn inline-flex items-center space-x-1" data-product-id="{{ $product->id }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Xóa</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination cho products -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>

                <!-- Modal xác nhận xóa sản phẩm -->
                <x-confirm-modal id="deleteProductModal"
                    title="Xác nhận xóa sản phẩm"
                    confirmText="Xóa"
                    confirmClass="bg-rose-500 hover:bg-rose-600 text-white"
                    :cancelId="'deleteProductCancel'"
                    :confirmId="'deleteProductConfirm'"
                >
                    <span>Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.</span>
                </x-confirm-modal>

                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let targetForm = null;
                    const modal = document.getElementById('deleteProductModal');
                    // Xóa mọi class hiển thị modal khi load trang
                    if (modal) {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                    }

                    document.querySelectorAll('.delete-btn').forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            targetForm = btn.closest('form');
                            if (modal) {
                                modal.classList.remove('hidden');
                                modal.classList.add('flex');
                            }
                        });
                    });

                    // Xử lý nút xác nhận trong modal
                    const confirmBtn = document.getElementById('deleteProductConfirm');
                    if (confirmBtn) {
                        confirmBtn.addEventListener('click', function() {
                            if (modal) {
                                modal.classList.remove('flex');
                                modal.classList.add('hidden');
                            }
                            if (targetForm) targetForm.submit();
                        });
                    }

                    // Xử lý nút đóng modal
                    const cancelBtn = document.getElementById('deleteProductCancel');
                    if (cancelBtn) {
                        cancelBtn.addEventListener('click', function() {
                            if (modal) {
                                modal.classList.remove('flex');
                                modal.classList.add('hidden');
                            }
                        });
                    }
                });
                </script>
            </div>

            <!-- Customers Section -->
            <div id="customers-section" class="admin-section" style="display:none">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span>Quản lý khách hàng</span>
                        </h3>
                        <a href="{{ route('customers.create') }}" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-4 rounded transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span>Thêm khách hàng mới</span>
                        </a>
                    </div>

                    <!-- Grid khách hàng -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($customers as $customer)
                            <div class="bg-gray-50 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
                                <!-- Thông tin khách hàng -->
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Thông tin khách hàng #{{ $customer->id }}</h4>
                                    
                                    <div class="space-y-3 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-600">Họ và tên:</span>
                                            <p class="text-gray-800">{{ $customer->user ? $customer->user->name : $customer->name }}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-600">Email:</span>
                                            <p class="text-gray-800">{{ $customer->user ? $customer->user->email : $customer->email }}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-600">Số điện thoại:</span>
                                            <p class="text-gray-800">{{ $customer->user ? ($customer->user->phone ?: 'Chưa cập nhật') : ($customer->phone ?: 'Chưa cập nhật') }}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-600">Địa chỉ:</span>
                                            <p class="text-gray-800">{{ $customer->user ? ($customer->user->address ?: 'Chưa cập nhật') : ($customer->address ?: 'Chưa cập nhật') }}</p>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-600">Ngày tham gia:</span>
                                            <p class="text-gray-800">{{ $customer->user ? $customer->user->created_at->format('d/m/Y') : $customer->created_at->format('d/m/Y') }}</p>
                                        </div>
                                        @if($customer->user)
                                            <div class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded">
                                                Đã liên kết với tài khoản user
                                            </div>
                                        @else
                                            <div class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded">
                                                Chưa liên kết với tài khoản user
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Hành động -->
                                <div class="border-t pt-4">
                                    <a href="{{ route('customers.orders', $customer) }}"
                                       class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200 text-center inline-flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>Lịch sử đơn hàng</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination cho customers -->
                    <div class="mt-6">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div id="orders-section" class="admin-section" style="display:none">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Quản lý đơn hàng</span>
                        </h3>
                        <div class="text-sm text-gray-500 flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Tự động cập nhật mỗi 30 giây</span>
                        </div>
                    </div>

                    <!-- Bộ lọc đơn hàng -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-6" id="order-filters">
                        <input type="hidden" name="section" value="orders">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã nhận hàng</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Từ ngày</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Đến ngày</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-rose-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-4 rounded transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    <span>Lọc</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Bảng đơn hàng -->
                    <div id="orders-table-container">
                        @include('admin.partials.orders-table', ['orders' => $orders])
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div id="statistics-section" class="admin-section" style="display:none">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Thống kê đơn hàng</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- Tổng đơn hàng -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-blue-600">Tổng đơn hàng</p>
                                    <p class="text-2xl font-bold text-blue-900">{{ $orderStats['total_orders'] }}</p>
                                </div>
                                <div class="p-3 bg-blue-200 rounded-full">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Đơn hàng hôm nay -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600">Hôm nay</p>
                                    <p class="text-2xl font-bold text-green-900">{{ $orderStats['today_orders'] }}</p>
                                </div>
                                <div class="p-3 bg-green-200 rounded-full">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Đơn hàng tháng này -->
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-purple-600">Tháng này</p>
                                    <p class="text-2xl font-bold text-purple-900">{{ $orderStats['this_month_orders'] }}</p>
                                </div>
                                <div class="p-3 bg-purple-200 rounded-full">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tổng doanh thu -->
                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-4 rounded-lg border border-yellow-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-yellow-600">Tổng doanh thu</p>
                                    <p class="text-2xl font-bold text-yellow-900">{{ number_format($orderStats['total_revenue'], 0, ',', '.') }}đ</p>
                                </div>
                                <div class="p-3 bg-yellow-200 rounded-full">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Thống kê theo trạng thái -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                        <!-- Chờ xử lý -->
                        <div class="bg-gray-50 p-4 rounded-lg border text-center">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-600">Chờ xử lý</p>
                            <p class="text-xl font-bold text-gray-900">{{ $orderStats['pending_orders'] }}</p>
                        </div>
                        
                        <!-- Đang xử lý -->
                        <div class="bg-blue-50 p-4 rounded-lg border text-center">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-blue-600">Đang xử lý</p>
                            <p class="text-xl font-bold text-blue-900">{{ $orderStats['confirmed_orders'] }}</p>
                        </div>
                        
                        <!-- Đã giao hàng -->
                        <div class="bg-green-50 p-4 rounded-lg border text-center">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-green-600">Đã giao</p>
                            <p class="text-xl font-bold text-green-900">{{ $orderStats['shipped_orders'] }}</p>
                        </div>
                        
                        <!-- Đã nhận hàng -->
                        <div class="bg-emerald-50 p-4 rounded-lg border text-center">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-emerald-600">Hoàn thành</p>
                            <p class="text-xl font-bold text-emerald-900">{{ $orderStats['delivered_orders'] }}</p>
                        </div>
                        
                        <!-- Đã hủy -->
                        <div class="bg-red-50 p-4 rounded-lg border text-center">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-red-600">Đã hủy</p>
                            <p class="text-xl font-bold text-red-900">{{ $orderStats['cancelled_orders'] }}</p>
                        </div>
                    </div>
                    
                    <!-- Giá trị trung bình đơn hàng -->
                    <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 p-4 rounded-lg border border-indigo-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-indigo-600">Giá trị trung bình đơn hàng</p>
                                <p class="text-2xl font-bold text-indigo-900">{{ number_format($orderStats['average_order_value'] ?? 0, 0, ',', '.') }}đ</p>
                            </div>
                            <div class="p-3 bg-indigo-200 rounded-full">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa sản phẩm -->
    {{-- Đã xóa modal thừa, chỉ giữ lại modal ở phía trên --}}


    <!-- Modal xác nhận đơn hàng -->
    <div id="confirm-order-modal" class="fixed inset-0 items-center justify-center hidden z-50">
        <div class="bg-white p-6 border rounded-lg shadow-xl w-96">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Xác nhận đơn hàng</h3>
                <p class="text-sm text-gray-500 mb-6">Bạn có chắc chắn muốn xác nhận đơn hàng này?</p>
                <div class="flex justify-center gap-4">
                    <button id="confirm-order-cancel" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Hủy
                    </button>
                    <button id="confirm-order-action" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa đơn hàng -->
    <div id="confirm-delete-order-modal" class="fixed inset-0 hidden items-center justify-center z-50">
        <div class="bg-white p-6 border rounded-lg shadow-xl w-96">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 mb-4">
                    <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Xác nhận xóa</h3>
                <p class="text-sm text-gray-500 mb-6">Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác.</p>
                <div class="flex justify-center gap-4">
                    <button id="confirm-delete-order-cancel" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Hủy
                    </button>
                    <button id="confirm-delete-order-action" class="px-4 py-2 bg-rose-600 text-white text-base font-medium rounded-md hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500">
                        Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar navigation
    function showSection(section) {
        // Hide all sections
        document.querySelectorAll('.section-content').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Remove active class from all sidebar items
        document.querySelectorAll('.sidebar-item').forEach(el => {
            el.classList.remove('active', 'bg-rose-50', 'text-rose-600');
        });
        
        // Show selected section
        document.getElementById(section + '-section').classList.remove('hidden');
        
        // Add active class to selected sidebar item
        const activeItem = document.querySelector(`[data-section="${section}"]`);
        activeItem.classList.add('active', 'bg-rose-50', 'text-rose-600');
        
        // Update URL parameter to track current section
        const url = new URL(window.location);
        url.searchParams.set('section', section);
        window.history.replaceState({}, '', url);
    }
    
    // Make showSection globally available
    window.showSection = showSection;
    
    // Check URL parameter to show correct section on page load
    const urlParams = new URLSearchParams(window.location.search);
    const currentSection = urlParams.get('section') || 'orders';
    showSection(currentSection);
    
    // Product delete functionality
    let currentForm = null;
    
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentForm = this.closest('form');
            showConfirmModal();
        });
    });
    
    function showConfirmModal() {
        const modal = document.getElementById('confirm-modal');
        const confirmBtn = document.getElementById('confirm-delete');
        const cancelBtn = document.getElementById('confirm-cancel');
        
        // Hiển thị modal
        modal.classList.remove('hidden');
        
        // Xử lý khi nhấn Hủy
        const handleCancel = () => {
            modal.classList.add('hidden');
            currentForm = null;
            confirmBtn.removeEventListener('click', handleConfirm);
            cancelBtn.removeEventListener('click', handleCancel);
        };
        
        // Xử lý khi nhấn Xóa
        const handleConfirm = () => {
            modal.classList.add('hidden');
            if (currentForm) {
                currentForm.submit();
            }
            confirmBtn.removeEventListener('click', handleConfirm);
            cancelBtn.removeEventListener('click', handleCancel);
        };
        
        // Thêm event listeners
        confirmBtn.addEventListener('click', handleConfirm);
        cancelBtn.addEventListener('click', handleCancel);
    }
    
    // Order management functionality
    let currentOrderForm = null;
    let currentOrderAction = null;
    
    // Auto-refresh orders every 30 seconds
    setInterval(function() {
        if (document.getElementById('orders-section').classList.contains('hidden')) {
            return; // Don't refresh if orders section is not visible
        }
        
        const formData = new FormData(document.getElementById('order-filters'));
        formData.append('section', 'orders');
        
        fetch('{{ route("admin.dashboard") }}?' + new URLSearchParams(formData).toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.querySelector('#orders-table-container');
            if (newTable) {
                document.getElementById('orders-table-container').innerHTML = newTable.innerHTML;
                attachOrderEventListeners();
            }
        })
        .catch(error => {
            console.error('Error refreshing orders:', error);
        });
    }, 30000);
    
    function attachOrderEventListeners() {
        // Confirm order buttons - hiện modal xác nhận
        document.querySelectorAll('.confirm-order-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                currentOrderForm = this.closest('form');
                currentOrderAction = 'confirm';
                const confirmOrderModal = document.getElementById('confirm-order-modal');
                confirmOrderModal.classList.remove('hidden');
                confirmOrderModal.classList.add('flex');
            });
        });
        
        // Delete order buttons
        document.querySelectorAll('.delete-order-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                currentOrderForm = this.closest('form');
                currentOrderAction = 'delete';
                document.getElementById('confirm-delete-order-modal').classList.remove('hidden');
            });
        });
    }
    
    function showOrderNotification() {
        const notification = document.getElementById('order-notification');
        notification.classList.remove('hidden');
        
        // Tự động ẩn sau 5 giây
        setTimeout(function() {
            notification.classList.add('hidden');
        }, 5000);
    }
    
    // Initial attachment of order event listeners
    attachOrderEventListeners();
    
        const confirmOrderModal = document.getElementById('confirm-order-modal');
        confirmOrderModal.classList.add('hidden');
        confirmOrderModal.classList.remove('flex');
        currentOrderForm = null;
        currentOrderAction = null;
        currentOrderForm = null;
        const confirmOrderModal = document.getElementById('confirm-order-modal');
        confirmOrderModal.classList.add('hidden');
        confirmOrderModal.classList.remove('flex');
        if (currentOrderForm && currentOrderAction === 'confirm') {
            currentOrderForm.submit();
        }
        currentOrderForm = null;
        currentOrderAction = null;
            currentOrderForm.submit();
        }
        currentOrderForm = null;
        currentOrderAction = null;
    });

    // Delete order modal handlers
    document.getElementById('confirm-delete-order-cancel').addEventListener('click', function() {
        document.getElementById('confirm-delete-order-modal').classList.add('hidden');
        currentOrderForm = null;
        currentOrderAction = null;
    });
    
    document.getElementById('confirm-delete-order-action').addEventListener('click', function() {
        document.getElementById('confirm-delete-order-modal').classList.add('hidden');
        if (currentOrderForm && currentOrderAction === 'delete') {
            currentOrderForm.submit();
        }
        currentOrderForm = null;
        currentOrderAction = null;
    });
    
    // Auto-hide notifications after 5 seconds
    setTimeout(function() {
        const successNotification = document.getElementById('success-notification');
        const errorNotification = document.getElementById('error-notification');
        if (successNotification) {
            successNotification.style.display = 'none';
        }
        if (errorNotification) {
            errorNotification.style.display = 'none';
        }
    }, 5000);
});
</script>
@endsection

<!-- <script>
{{-- Đã xóa đoạn xác nhận xóa sản phẩm bằng confirm popup, chỉ dùng modal xác nhận --}}
        });
    });
});
</script> -->
