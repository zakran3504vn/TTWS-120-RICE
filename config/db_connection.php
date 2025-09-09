<?php
$server = "localhost"; // IP hoặc domain kết nối để CSDL
$username = "root"; // Người dùng sử dụng để kết nối đến CSDL với PHP
$password = ""; // Mật khẩu sử dụng để kết nối đến CSDL với PHP
$database = "120-cn-ho-nguyen-ngoc-bao"; // Tên database

// Kết nối đến MySQL với PHP sử dụng MySQLi
$conn = new mysqli($server, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

