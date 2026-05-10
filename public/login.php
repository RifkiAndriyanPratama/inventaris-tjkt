<?php
session_start();
require_once __DIR__ . '/../src/classes/Auth.php';

$auth = new Auth();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nama) || empty($password)) {
        $error = 'Nama dan password harus diisi!';
    } else {
        $result = $auth->login($nama, $password);

        if ($result['success']) {
            $_SESSION['notification'] = [
                'type' => 'success',
                'message' => 'Login berhasil! Selamat datang ' . htmlspecialchars($nama),
            ];

            // Redirect berdasarkan role
            if ($result['role'] === 'admin') {
                header('Location: /admin/dashboard.php');
            } else {
                header('Location: /user/dashboard.php');
            }
            exit();
        } else {
            $error = $result['message'];
        }
    }
}

$content = '../views/auth/login.php';
require '../views/layouts/auth.php';
?>