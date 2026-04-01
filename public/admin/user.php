<?php

session_start();
require_once __DIR__.'/../../config/connection.php';
require_once __DIR__.'/../../src/actions.php';
require_once __DIR__.'/../../src/core.php';
require_once __DIR__.'/../../src/auth.php';

if (! is_logged_in() || ! is_admin()) {
    header('Location: /login.php');
    exit();
}

$pdo = get_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'tambah') {
        $nis = trim($_POST['nis']);
        $nama = trim($_POST['nama']);
        $kelas = trim($_POST['kelas']);
        $role = $_POST['role'];
        $plainPassword = $_POST['password'];

        // Validasi input
        $errors = [];
        if (empty($nis)) {
            $errors[] = 'NIS harus diisi';
        }
        if (empty($nama)) {
            $errors[] = 'Nama harus diisi';
        }
        if (empty($kelas)) {
            $errors[] = 'Kelas harus diisi';
        }
        if (empty($plainPassword)) {
            $errors[] = 'Password harus diisi';
        }
        if (strlen($plainPassword) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }

        if (! empty($errors)) {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => implode('<br>', $errors),
            ];
            header('Location: /admin/user.php');
            exit();
        }

        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Panggil fungsi dengan cek duplikat
        $result = save_user($pdo, $nis, $nama, $kelas, $hashedPassword, $role);

        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
        ];

        header('Location: /admin/user.php');
        exit();

    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $nama = trim($_POST['nama']);
        $nis = trim($_POST['nis']);
        $kelas = trim($_POST['kelas']);
        $role = $_POST['role'];
        $password = $_POST['password'] ?? '';

        // Validasi input
        $errors = [];
        if (empty($nama)) {
            $errors[] = 'Nama harus diisi';
        }
        if (empty($nis)) {
            $errors[] = 'NIS harus diisi';
        }
        if (empty($kelas)) {
            $errors[] = 'Kelas harus diisi';
        }

        if (! empty($errors)) {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => implode('<br>', $errors),
            ];
            header('Location: /admin/user.php');
            exit();
        }

        $result = update_user($pdo, $id, $nama, $nis, $kelas, $password, $role);

        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
        ];

        header('Location: /admin/user.php');
        exit();

    } elseif ($action === 'hapus') {
        $id = $_POST['id'];
        $nama = $_POST['nama'] ?? 'user';

        $result = delete_user($pdo, $id);

        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'warning' : 'error',
            'message' => $result['success']
                ? 'User "'.htmlspecialchars($nama).'" berhasil dihapus!'
                : $result['message'],
        ];

        header('Location: /admin/user.php');
        exit();
    }
}

$users = get_all_users($pdo);

$content = __DIR__.'/../../views/admin/user/user_content.php';
require __DIR__.'/../../views/layouts/main.php';

