<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product; // <-- THÊM DÒNG NÀY (Rất quan trọng)

class GeminiController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        if (!$userMessage) {
            return response()->json(['error' => 'No message provided'], 400);
        }

        $apiKey = env('GEMINI_API_KEY');

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-pro:generateContent?key=" . $apiKey;

        // Lấy tất cả sản phẩm, chỉ lấy tên và giá
        $products = Product::orderBy('created_at', 'desc')->get(['name', 'price']);

        // Chuyển dữ liệu thành một chuỗi (string) để Gemini "đọc"
        $productDetails = $products->map(function($product) {
            return " - " . $product->name . ": " . number_format($product->price, 0, ',', '.') . " VND";
        })->join("\n");

        $systemInstruction = "
        Bạn là FlowerBot AI, trợ lý ảo thân thiện của FlowerShop Hà Đông.
        Nhiệm vụ của bạn là trả lời câu hỏi của khách hàng DỰA TRÊN thông tin nội bộ của cửa hàng được cung cấp dưới đây.

        QUY TẮC:
        1. Chỉ trả lời dựa trên 'DỮ LIỆU CỬA HÀNG'. Không được bịa thêm thông tin.
        2. Nếu người dùng hỏi về một loại hoa không có trong danh sách, hãy trả lời là 'Xin lỗi, hiện tại cửa hàng không có [tên hoa] ạ.'
        3. Hãy trả lời thân thiện, lịch sự bằng tiếng Việt.

        ---
        DỮ LIỆU CỬA HÀNG (Cập nhật ngày " . date('Y-m-d') . "):
        Tổng số sản phẩm đang có: " . $products->count() . "

        Danh sách các loại hoa và giá cả:
        " . $productDetails . "
        ---
        ";

        $data = [
            'contents' => [

                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemInstruction]
                    ]
                ],

                [
                    'role' => 'model',
                    'parts' => [
                        ['text' => "Đã hiểu! Tôi là FlowerBot AI. Tôi sẽ giúp bạn dựa trên dữ liệu sản phẩm của cửa hàng."]
                    ]
                ],

                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userMessage]
                    ]
                ]
            ]
        ];

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])->post($url, $data);

            if ($response->failed()) {
                return response()->json(['error' => 'API request failed', 'details' => $response->json()], $response->status());
            }

            $responseText = $response->json('candidates.0.content.parts.0.text', 'Xin lỗi, tôi không thể xử lý yêu cầu này.');

            
            return response()->json(['reply' => $responseText]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
