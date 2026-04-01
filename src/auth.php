<?php

function login(PDO $pdo, $nama, $password): array
{
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE nama = :nama');
        $stmt->execute([':nama' => $nama]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return [
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'nis' => $user['nis'],
                    'nama' => $user['nama'],
                    'kelas' => $user['kelas'],
                    'role' => $user['role'],
                ],
                'message' => 'Login berhasil!',
            ];
        }

        return [
            'success' => false,
            'message' => 'Nama atau password salah!',
        ];
    } catch (PDOException $e) {
        error_log('Error login: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Terjadi kesalahan, silakan coba lagi!',
        ];
    }
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function is_admin(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function is_user(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user';
}

function require_login(): void
{
    if (! is_logged_in()) {
        header('Location: /login.php');
        exit();
    }
}

function require_admin(): void
{
    require_login();
    if (! is_admin()) {
        header('Location: /user/dashboard.php');
        exit();
    }
}

function require_user(): void
{
    require_login();
    if (! is_user()) {
        header('Location: /admin/dashboard.php');
        exit();
    }
}

function logout(): void
{
    session_destroy();
    header('Location: /login.php');
    exit();
}

