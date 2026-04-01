<?php

session_start();

require_once '../config/connection.php';
require_once '../src/core.php';
require_once '../src/auth.php';

$pdo = get_db();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nama) || empty($password)) {
        $error = 'Nama dan password harus diisi!';
    } else {
        $result = login($pdo, $nama, $password);

        if ($result['success']) {
            $_SESSION['user'] = $result['user'];
            $_SESSION['notification'] = [
                'type' => 'success',
                'message' => 'Login berhasil! Selamat datang '.$result['user']['nama'],
            ];

            // Redirect berdasarkan role
            if ($result['user']['role'] === 'admin') {
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
