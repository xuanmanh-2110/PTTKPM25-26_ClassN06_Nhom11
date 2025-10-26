<div class="overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100 text-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Khách hàng</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tổng tiền</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Trạng thái</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Ngày tạo</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Hành động</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 text-gray-800">
            @foreach($orders as $order)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ number_format($order->total_amount ?? $order->items->sum(function($i){ return $i->price * $i->quantity; }), 0, ',', '.') }}đ
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_color }}">
                            {{ $order->status_name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">{{ $order->formatted_created_at }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200 text-center flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>Xem</span>
                            </a>
                            
                            <!-- Nút xác nhận đơn hàng -->
                            @if($order->status === 'pending')
                            <form action="{{ route('orders.update', $order) }}" method="POST" class="inline-block w-full sm:w-auto confirm-order-form">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200 w-full confirm-order-btn flex items-center justify-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Xác nhận đơn hàng</span>
                                        </button>
                                    </form>
                                    @include('components.confirm-modal', [
                                        'id' => 'confirm-order-modal-' . $order->id,
                                        'title' => 'Xác nhận đơn hàng',
                                        'description' => 'Bạn có chắc chắn muốn xác nhận đơn hàng này? Hành động này không thể hoàn tác.',
                                        'confirmText' => 'Xác nhận',
                                        'cancelText' => 'Hủy',
                                        'confirmId' => 'confirm-order-confirm-' . $order->id,
                                        'cancelId' => 'confirm-order-cancel-' . $order->id,
                                        'icon' => '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
                                        'iconBg' => 'bg-green-100'
                                    ])
                            @endif
                            
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline-block w-full sm:w-auto delete-order-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200 w-full delete-order-btn flex items-center justify-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Xóa</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->appends(request()->query())->links() }}
</div>
{{-- Modal xác nhận xóa đơn hàng dùng chung --}}
@include('components.confirm-modal', [
    'id' => 'confirm-modal-order',
    'title' => 'Xác nhận xóa đơn hàng',
    'description' => 'Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác.',
    'cancelId' => 'confirm-cancel-order',
    'confirmId' => 'confirm-delete-order',
    'cancelText' => 'Hủy',
    'confirmText' => 'Xóa'
])
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentForm = null;
    const modal = document.getElementById('confirm-modal-order');
    const cancelBtn = document.getElementById('confirm-cancel-order');
    const confirmBtn = document.getElementById('confirm-delete-order');

    document.querySelectorAll('.delete-order-btn').forEach(btn => {
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
    // Xử lý xác nhận đơn hàng
    document.querySelectorAll('.confirm-order-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = btn.closest('form');
            const orderId = form.querySelector('input[name="status"]').value + '-' + form.action.split('/').pop();
            const modal = document.getElementById('confirm-order-modal-' + form.action.split('/').pop());
            let confirmBtn = document.getElementById('confirm-order-confirm-' + form.action.split('/').pop());
            let cancelBtn = document.getElementById('confirm-order-cancel-' + form.action.split('/').pop());
            modal.classList.remove('hidden');
            cancelBtn.onclick = function() {
                modal.classList.add('hidden');
            };
            confirmBtn.onclick = function() {
                form.submit();
                modal.classList.add('hidden');
            };
        });
    });
</script>
{{-- Modal xác nhận xóa sản phẩm --}}
@include('components.confirm-modal', [
    'id' => 'confirm-delete-modal',
    'title' => 'Xác nhận xóa sản phẩm',
    'description' => 'Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.',
    'confirmText' => 'Xóa',
    'cancelText' => 'Hủy',
    'confirmId' => 'confirm-delete-confirm',
    'cancelId' => 'confirm-delete-cancel',
    'iconBg' => 'bg-red-100',
    'icon' => '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>',
])