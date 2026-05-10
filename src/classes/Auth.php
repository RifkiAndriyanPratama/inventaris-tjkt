<?php

require_once __DIR__ . '/Database.php';

class Auth extends Database
{
    public function login(string $nama, string $password): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE nama = :nama');
            $stmt->execute([':nama' => $nama]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nis' => $user['nis'],
                    'nama' => $user['nama'],
                    'kelas' => $user['kelas'],
                    'role' => $user['role'],
                ];
                return ['success' => true, 'message' => 'Login berhasil!', 'role' => $user['role']];
            }

            return ['success' => false, 'message' => 'Nama atau password salah!'];
        } catch (PDOException $e) {
            error_log('Error Auth::login: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan, silakan coba lagi!'];
        }
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public function isAdmin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

    public function isUser(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user';
    }

    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            header('Location: /login.php');
            exit();
        }
    }

    public function requireAdmin(): void
    {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            header('Location: /user/dashboard.php');
            exit();
        }
    }

    public function requireUser(): void
    {
        $this->requireLogin();
        if (!$this->isUser()) {
            header('Location: /admin/dashboard.php');
            exit();
        }
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login.php');
        exit();
    }
}