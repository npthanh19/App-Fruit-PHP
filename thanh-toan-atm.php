<?php
header('Content-type: text/html; charset=utf-8');
session_start();

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

// Các biến có sẵn
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderId = time() . "";
$orderInfo = "Thanh toán đơn hàng"." ".$orderId;
$amount = $_SESSION["hidden_tong_tien"] . "000";
$redirectUrl = "http://localhost:2222/shoptraicay/handler/xac-nhan-dat-hang.php";
$ipnUrl = "http://localhost:2222/shoptraicay/handler/xac-nhan-dat-hang.php";
$extraData = "";

// Tạo dữ liệu yêu cầu
$requestId = time() . "";
$requestType = "payWithATM";
$extraData = ""; // Đặt giá trị extraData theo nhu cầu của bạn

// Tính toán chữ ký
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);

// Dữ liệu yêu cầu
$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
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
);


$result = execPostRequest("https://test-payment.momo.vn/v2/gateway/api/create", json_encode($data));

if ($result === false) {
    // Xử lý lỗi khi gửi yêu cầu
    echo "Lỗi khi gửi yêu cầu POST đến MoMo API.";
} else {
    $jsonResult = json_decode($result, true);  // decode json

    if (isset($jsonResult['payUrl'])) {
        // Chuyển hướng đến trang thanh toán MoMo
        header('Location: ' . $jsonResult['payUrl']);
    } else {
        // Xử lý lỗi khi không có payUrl trong kết quả
        echo "Lỗi: Không có payUrl trong kết quả từ MoMo API.";
    }
}


//Chuyển hướng đến trang thanh toán MoMo
header('Location: ' . $jsonResult['payUrl']);
?>