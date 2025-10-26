<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use App\Repositories\OrderRepository;

class MomoPaymentService
{
    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode = "MOMOBKUN20180529";
    private $accessKey = "klm05TvNBzhg7h7j";
    private $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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
        curl_close($ch);

        return $result;
    }

    public function createPayment($amount)
    {
        $order = $this->orderRepository->createOrder([
            'customer_id' => auth()->id(),
            'total_amount' => $amount,
            'status' => 'pending',
        ]);

        $orderId = $order->id . "_" . time();
        $requestId = time() . "";

        $rawHash = "accessKey={$this->accessKey}&amount={$amount}&extraData=&ipnUrl=http://127.0.0.1:8000/momo/ipn&orderId={$orderId}&orderInfo=Thanh toán qua MoMo&partnerCode={$this->partnerCode}&redirectUrl=http://127.0.0.1:8000/checkout&requestId={$requestId}&requestType=captureWallet";

        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => "MoMoTest",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => "Thanh toán qua MoMo",
            'redirectUrl' => "http://127.0.0.1:8000/checkout",
            'ipnUrl' => "http://127.0.0.1:8000/momo/ipn",
            'lang' => 'vi',
            'extraData' => "",
            'requestType' => "captureWallet",
            'signature' => $signature
        ];

        $result = $this->execPostRequest($this->endpoint, json_encode($data));
        return json_decode($result, true);
    }

    public function handleIpn($data)
    {
        Log::info("MoMo IPN payload:", $data);

        if (isset($data['resultCode']) && $data['resultCode'] == 0) {
            $orderIdParts = explode("_", $data['orderId']);
            $orderId = $orderIdParts[0] ?? null;

            if ($orderId) {
                $order = $this->orderRepository->find($orderId);
                if ($order && $order->status == 'pending') {
                    $this->orderRepository->updateStatus($order, 'paid', $data['transId'] ?? null);
                    $order->update([
                        'total_amount' => $data['amount'] ?? $order->total_amount,
                    ]);
                }
            }
            return true;
        }
        return false;
    }
}