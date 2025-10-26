<!-- Modal xác nhận dùng chung -->
<div id="{{ $id ?? 'confirm-modal' }}" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 border border-gray-200">
        <div class="p-6">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 {{ isset($iconBg) ? $iconBg : 'bg-rose-100' }} rounded-full">
                @isset($icon)
                    {!! $icon !!}
                @else
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                @endisset
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">{{ $title ?? 'Xác nhận hành động' }}</h3>
            <p class="text-gray-600 text-center mb-6">{{ $description ?? 'Bạn có chắc chắn muốn thực hiện hành động này?' }}</p>
            <div class="flex space-x-3">
                <button id="{{ $cancelId ?? 'confirm-cancel' }}" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    {{ $cancelText ?? 'Hủy' }}
                </button>
                <button id="{{ $confirmId ?? 'confirm-delete' }}" class="flex-1 px-4 py-2 {{ ($confirmText ?? '') === 'Xóa' ? 'bg-red-600 hover:bg-red-700' : 'bg-rose-600 hover:bg-rose-700' }} text-white font-semibold rounded-lg transition-colors duration-200">
                    {{ $confirmText ?? 'Xác nhận' }}
                </button>
            </div>
        </div>
    </div>
</div>