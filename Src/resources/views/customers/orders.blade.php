@extends('layouts.app')

@section('content')
<button onclick="window.history.back()" class="inline-block bg-rose-100 hover:bg-rose-200 text-rose-600 font-bold py-2 px-4 rounded-md shadow-md transition-colors duration-200 mb-4 ml-4">
  ← Quay lại trang trước
</button>
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-rose-600 mb-6 text-center">Lịch sử mua hàng của khách hàng: {{ $customer->name }}</h2>

    @if ($orders->isEmpty())
        <p class="text-gray-700 text-lg text-center">Khách hàng này chưa có đơn hàng nào.</p>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Mã đơn hàng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tổng tiền</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Ngày đặt</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($order->total_amount) }} đ</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Đang chờ xử lý</span>
                                @elseif($order->status === 'processing')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Đang xử lý</span>
                                @elseif($order->status === 'shipped')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Đã giao hàng</span>
                                @elseif($order->status === 'delivered')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Đã nhận hàng</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Đã hủy</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status === 'processing')
                                    <form action="{{ route('orders.confirmDelivery', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-sm transition-colors duration-200"
                                                onclick="return confirm('Xác nhận bạn đã nhận được hàng?')">
                                            ✓ Nhận hàng
                                        </button>
                                    </form>
                                @elseif($order->status === 'delivered')
                                    <span class="text-green-600 font-semibold text-sm">✓ Đã hoàn thành</span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
