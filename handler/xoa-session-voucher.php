<?php
session_start();

unset($_SESSION['applied_vouchers']);
echo json_encode(['message' => 'Session về voucher đã được xóa.']);
?>