<?php
include("../../config/database.php");

$conn->set_charset("utf8");

function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

$fileName = "order-data_" . date('Y-m-d') . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$fileName\"");

echo "\xEF\xBB\xBF";

echo "<html xmlns:x=\"urn:schemas-microsoft-com:office:excel\">";
echo "<head>";
echo "<!--[if gte mso 9]>";
echo "<xml>";
echo "<x:ExcelWorkbook>";
echo "<x:ExcelWorksheets>";
echo "<x:ExcelWorksheet>";
echo "<x:Name>Sheet1</x:Name>";
echo "<x:WorksheetOptions>";
echo "<x:Print>";
echo "<x:ValidPrinterInfo/>";
echo "</x:Print>";
echo "</x:WorksheetOptions>";
echo "</x:ExcelWorksheet>";
echo "</x:ExcelWorksheets>";
echo "</x:ExcelWorkbook>";
echo "</xml>";
echo "<![endif]-->";
echo "</head>";
echo "<body>";

// Column names
$fields = array(
    'Mã Đơn Hàng',
    'Tên Khách Hàng',
    'Địa Chỉ',
    'ID Tài Khoản',
    'Số Điện Thoại',
    'Ngày Đặt Hàng',
    'Trạng Thái',
    'Sản Phẩm',
    'Giá Đơn Hàng',
);

echo "<table border='1'>";
echo "<tr>";
foreach ($fields as $field) {
    echo "<th>$field</th>";
}
echo "</tr>";

$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';

$querySQL = "SELECT
    don_dat_hang.ma_don_hang,
    don_dat_hang.ten_khach_hang,
    don_dat_hang.dia_chi,
    don_dat_hang.id_tai_khoan,
    don_dat_hang.so_dien_thoai,
    don_dat_hang.ngay_dat_hang,
    don_dat_hang.trang_thai,
    GROUP_CONCAT(CONCAT(san_pham.ten_san_pham, ' x ', chi_tiet_don_hang.so_luong) SEPARATOR ', ') AS san_pham,
    chi_tiet_don_hang.gia_don_hang
FROM chi_tiet_don_hang
INNER JOIN don_dat_hang ON chi_tiet_don_hang.ma_don_hang = don_dat_hang.ma_don_hang
INNER JOIN san_pham ON chi_tiet_don_hang.ma_san_pham = san_pham.ma_san_pham";


$conditions = array();
$params = array();

if (!empty($fromDate)) {
    $conditions[] = "don_dat_hang.ngay_dat_hang BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
}

if (!empty($status)) {
    $conditions[] = "don_dat_hang.trang_thai = ?";
    $params[] = $status;
}

if (!empty($paymentMethod)) {
    $conditions[] = "san_pham.phuong_thuc_thanh_toan = ?";
    $params[] = $paymentMethod;
}

if (!empty($conditions)) {
    $querySQL .= " WHERE " . implode(" AND ", $conditions);
}

$querySQL .= " GROUP BY chi_tiet_don_hang.ma_don_hang";

$query = $conn->prepare($querySQL);

if (!empty($params)) {
    $paramTypes = str_repeat('s', count($params));
    $query->bind_param($paramTypes, ...$params);
}

$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>{$value}</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No records found...</td></tr>";
}

echo "</table>";

echo "</body>";
echo "</html>";

exit;
?>