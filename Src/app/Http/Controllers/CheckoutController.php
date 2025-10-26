<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function show(Request $request)
    {
        // Kiểm tra nếu đây là "Mua ngay"
        $isBuyNow = $request->query('buy_now', false);

        if ($isBuyNow) {
            // Sử dụng cart riêng biệt cho "Mua ngay"
            $cart = session()->get('buy_now_cart', []);
        } else {
            // Sử dụng cart thông thường
            $cart = session()->get('cart', []);
            $selected = $request->query('selected');
            if ($selected) {
                $ids = explode(',', $selected);
                $cart = array_filter($cart, function ($v, $k) use ($ids) {
                    return in_array($k, $ids);
                }, ARRAY_FILTER_USE_BOTH);
            }
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }
        $total = 0;
        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $user = Auth::user();

        // Ưu tiên sử dụng thông tin từ User profile
        $userAddress = null;
        $userPhone = null;
        if ($user->address) {
            $userAddress = $user->address;
        }
        if ($user->phone) {
            $userPhone = $user->phone;
        }

         // Trường hợp dự phòng: Lấy thông tin giao hàng từ đơn hàng gần nhất nếu user chưa có thông tin
        $customer = \App\Models\Customer::where('email', $user->email)->first();
        $lastOrder = null;
        if ($customer && (!$userAddress || !$userPhone)) {
            $lastOrder = Order::where('customer_id', $customer->id)
                            ->join('customers', 'orders.customer_id', '=', 'customers.id')
                            ->whereNotNull('customers.address')
                            ->whereNotNull('customers.phone')
                            ->orderBy('orders.created_at', 'desc')
                            ->select('orders.*')
                            ->first();
        }

        return view('checkout', compact('cart', 'total', 'user', 'lastOrder', 'userAddress', 'userPhone', 'isBuyNow'));
    }

    // Xử lý đặt hàng
    public function process(Request $request)
    {
        $validationRules = [
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer',
        ];

        // Thêm validation cho thông tin ngân hàng nếu chọn chuyển khoản
        if ($request->payment_method === 'bank_transfer') {
            $validationRules['customer_bank_name'] = 'required|string|max:100';
            $validationRules['customer_account_number'] = 'required|string|max:50';
        }

        $request->validate($validationRules);

        // Kiểm tra nếu đây là "Mua ngay"
        $isBuyNow = $request->input('is_buy_now', false);

        if ($isBuyNow) {
            $cart = session()->get('buy_now_cart', []);
        } else {
            $cart = session()->get('cart', []);
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tìm hoặc tạo khách hàng tương ứng với user hiện tại
        $user = \Auth::user();
        $customer = \App\Models\Customer::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->name, 'phone' => $request->phone]
        );

        // Cập nhật thông tin số điện thoại mới nhất
        $customer->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $orderData = [
            'customer_id' => $customer->id,
            'total_amount' => 0,
            'payment_method' => $request->payment_method,
        ];

        // Thêm thông tin ngân hàng nếu chọn chuyển khoản
        if ($request->payment_method === 'bank_transfer') {
            $orderData['customer_bank_name'] = $request->customer_bank_name;
            $orderData['customer_account_number'] = $request->customer_account_number;
        }

        $order = Order::create($orderData);

         // Ghi log phục vụ debug
                \Log::info('Order created with phone: ' . $request->phone);

        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $qty = $item['quantity'];
            $price = $item['price']; // Sử dụng giá từ cart (đã tính giảm giá)
            $total += $price * $qty;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $qty,
                'price' => $price,
            ]);
        }

        $order->update(['total_amount' => $total]);

        // Xóa session cart tương ứng
        if ($isBuyNow) {
            session()->forget('buy_now_cart');
        } else {
            session()->forget('cart');
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Đặt hàng thành công!');
    }


    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);


        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        if ($result === false) {
            $error = curl_error($ch);
            curl_close($ch);
            dd("cURL error: " . $error);
        }
        curl_close($ch);

        return $result;
    }
    public function momo_payment(Request $request)
    {
        // Kiểm tra nếu đây là "Mua ngay"
        $isBuyNow = $request->input('is_buy_now', false);
        
        // Lấy cart từ request hoặc session
        $cart = $request->input('cart', []);
        if (empty($cart)) {
            if ($isBuyNow) {
                $cart = session()->get('buy_now_cart', []);
            } else {
                $cart = session()->get('cart', []);
            }
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tạo hoặc lấy customer
        $user = \Auth::user();
        $customer = \App\Models\Customer::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->name]
        );

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $order = Order::create([
            'customer_id' => $customer->id,
            'total_amount' => (int) $request->input('total_momo'),
            'status' => 'pending',
            'payment_method' => 'momo',
        ]);

        // Tạo OrderItem từ cart
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $qty = $item['quantity'];
            $price = $item['price']; // Sử dụng giá từ cart
            $total += $price * $qty;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $qty,
                'price' => $price,
            ]);
        }

        // Cập nhật lại tổng tiền của order
        $order->update(['total_amount' => $total]);

        $partnerCode = "MOMOBKUN20180529";
        $accessKey = "klm05TvNBzhg7h7j";
        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

        $orderInfo = "Thanh toán qua MoMo";
        $amount = (int) $total;
        $orderId = $order->id . "_" . time();
        $redirectUrl = "http://127.0.0.1:8000/checkout";
        $ipnUrl = "http://127.0.0.1:8000/momo/ipn";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "captureWallet";

        $rawHash = "accessKey=" . $accessKey .
        "&amount=" . $amount .
        "&extraData=" . $extraData .
        "&ipnUrl=" . $ipnUrl .
        "&orderId=" . $orderId .
        "&orderInfo=" . $orderInfo .
        "&partnerCode=" . $partnerCode .
        "&redirectUrl=" . $redirectUrl .
        "&requestId=" . $requestId .
        "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "MoMoTest",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        if (!$jsonResult) {
            dd("Raw response MoMo:", $result);
        }

        if (!isset($jsonResult['payUrl'])) {
            dd("MoMo trả về lỗi:", $jsonResult);
        }

        // Xóa session cart tương ứng sau khi tạo đơn hàng thành công
        if ($isBuyNow) {
            session()->forget('buy_now_cart');
        } else {
            session()->forget('cart');
        }

        return redirect()->to($jsonResult['payUrl']);
    }

    public function momoIpn(Request $request)
    {
        $data = $request->all();
        Log::info("MoMo IPN payload:", $data);

        if (isset($data['resultCode']) && $data['resultCode'] == 0) {
            $orderIdParts = explode("_", $data['orderId']);
            $orderId = $orderIdParts[0] ?? null;

            Log::info("Extracted orderId: " . $orderId);

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order && $order->status == 'pending') {
                    $order->status = 'paid';
                    $order->transaction_id = $data['transId'] ?? null;
                    $order->total_amount = $data['amount'] ?? $order->total_amount;
                    $order->save();
                    Log::info("Order updated successfully: " . $orderId);
                }
            }

            return response()->json(['message' => 'success'], 200);
        }

        return response()->json(['message' => 'fail'], 400);
    }
}
