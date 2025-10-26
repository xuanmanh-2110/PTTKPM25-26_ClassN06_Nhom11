@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <a href="{{ url('/') }}" class="inline-block bg-rose-100 hover:bg-rose-200 text-rose-600 font-bold py-2 px-4 rounded-md shadow-md transition-colors duration-200 mb-4 ml-4">
        ← Quay về trang chính
    </a>
    <h1 class="text-3xl font-bold text-rose-600 mb-6 text-center">Danh sách sản phẩm</h1>
    <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tìm kiếm sản phẩm..." class="px-3 py-2 border border-gray-300 rounded-md w-full sm:w-60 focus:outline-none focus:ring-2 focus:ring-rose-500">
        <button type="submit" class="px-6 py-2 bg-rose-500 text-white rounded-md border-none hover:bg-rose-600 transition-colors duration-200 w-full sm:w-auto">Tìm kiếm</button>
        @if(!empty($search))
            <span class="ml-0 sm:ml-3 text-rose-500 w-full text-center sm:text-left">Kết quả cho: <strong class="font-semibold">{{ $search }}</strong></span>
        @endif
    </form>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="inline-block bg-rose-500 text-white hover:bg-rose-600 font-bold py-2 px-4 rounded-md shadow-md transition-colors duration-200 mb-4">Thêm sản phẩm mới</a>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Ảnh</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tên</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Giá</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
            @foreach($products as $p)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($p->image)
                            <img src="{{ asset('images/products/' . $p->image) }}" class="w-24 h-24 object-cover rounded-md" alt="{{ $p->name }}">
                        @else
                            <span class="text-gray-500">Không có ảnh</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $p->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($p->price, 0, ',', '.') }} VND</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('products.analytics', $p) }}" class="text-blue-500 hover:text-blue-600 text-center font-medium">📊 Thống kê</a>
                            <a href="{{ route('products.edit', $p) }}" class="text-rose-500 hover:text-rose-600 text-center">Sửa</a>
                            <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline-block w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent border-none text-red-500 cursor-pointer hover:text-red-600 w-full delete-product-btn" data-id="{{ $p->id }}">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

{{-- Modal xác nhận xóa sản phẩm dùng chung --}}
@include('components.confirm-modal', [
    'id' => 'confirm-modal',
    'title' => 'Xác nhận xóa sản phẩm',
    'description' => 'Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.',
    'cancelId' => 'confirm-cancel',
    'confirmId' => 'confirm-delete',
    'cancelText' => 'Hủy',
    'confirmText' => 'Xóa',
    'icon' => '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>',
    'iconBg' => 'bg-red-100'
])


<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentForm = null;
    const modal = document.getElementById('confirm-modal');
    const cancelBtn = document.getElementById('confirm-cancel');
    const confirmBtn = document.getElementById('confirm-delete');

    document.querySelectorAll('.delete-product-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            currentForm = btn.closest('form');
            modal.classList.remove('hidden');
        });
    });

    cancelBtn.addEventListener('click', function() {
        modal.classList.add('hidden');
        currentForm = null;
    });

    confirmBtn.addEventListener('click', function() {
        if (currentForm) currentForm.submit();
        modal.classList.add('hidden');
        currentForm = null;
    });
});
</script>
