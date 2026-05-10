<?php
session_start();
require_once __DIR__ . '/../../src/classes/User.php';
require_once __DIR__ . '/../../src/classes/Auth.php';

$auth = new Auth();
$auth->requireAdmin();

$user = new User();

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

        if (!empty($errors)) {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => implode('<br>', $errors),
            ];
            header('Location: /admin/user.php');
            exit();
        }

        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Panggil method dengan cek duplikat
        $result = $user->save($nis, $nama, $kelas, $hashedPassword, $role);

        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
        ];

        header('Location: /admin/user.php');
        exit();

    } elseif ($action === 'edit') {
        $id = (int) $_POST['id'];
        $nis = trim($_POST['nis']);
        $nama = trim($_POST['nama']);
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

        if (!empty($errors)) {
            $_SESSION['notification'] = [
                'type' => 'error',
                'message' => implode('<br>', $errors),
            ];
            header('Location: /admin/user.php');
            exit();
        }

        $result = $user->update($id, $nis, $nama, $kelas, $password, $role);

        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
        ];

        header('Location: /admin/user.php');
        exit();

    } elseif ($action === 'hapus') {
        $id = (int) $_POST['id'];
        $nama = $_POST['nama'] ?? 'user';

        $result = $user->delete($id);

        $_SESSION['notification'] = [
            'type' => $result['success'] ? 'warning' : 'error',
            'message' => $result['success']
                ? 'User "' . htmlspecialchars($nama) . '" berhasil dihapus!'
                : $result['message'],
        ];

        header('Location: /admin/user.php');
        exit();
    }
}

$users = $user->getAll();

$content = __DIR__ . '/../../views/admin/user/user_content.php';
require __DIR__ . '/../../views/layouts/main.php';
?>