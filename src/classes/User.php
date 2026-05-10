<?php

require_once __DIR__ . '/Database.php';

class User extends Database
{
    // Cek user by nama
    public function exists(string $nama, ?int $excludeId = null): bool
    {
        try {
            if ($excludeId) {
                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE nama = :nama AND id != :id');
                $stmt->execute([':nama' => $nama, ':id' => $excludeId]);
            } else {
                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE nama = :nama');
                $stmt->execute([':nama' => $nama]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error User::exists: ' . $e->getMessage());
            return false;
        }
    }

    // Cek NIS
    public function nisExists(string $nis, ?int $excludeId = null): bool
    {
        try {
            if ($excludeId) {
                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE nis = :nis AND id != :id');
                $stmt->execute([':nis' => $nis, ':id' => $excludeId]);
            } else {
                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE nis = :nis');
                $stmt->execute([':nis' => $nis]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error User::nisExists: ' . $e->getMessage());
            return false;
        }
    }

    // Ambil semua user
    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users ORDER BY id DESC');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error User::getAll: ' . $e->getMessage());
            return [];
        }
    }

    // Ambil user by ID
    public function getById(int $id): array|false
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error User::getById: ' . $e->getMessage());
            return false;
        }
    }

    // Ambil user by nama
    public function getByNama(string $nama): array|false
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE nama = :nama');
            $stmt->execute([':nama' => $nama]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error User::getByNama: ' . $e->getMessage());
            return false;
        }
    }

    // Tambah user
    public function save(string $nis, string $nama, string $kelas, string $password, string $role = 'user'): array
    {
        try {
            if ($this->nisExists($nis)) {
                return ['success' => false, 'message' => 'NIS ' . $nis . ' sudah terdaftar!'];
            }
            if ($this->exists($nama)) {
                return ['success' => false, 'message' => 'Nama "' . $nama . '" sudah terdaftar!'];
            }

            $stmt = $this->pdo->prepare('INSERT INTO users (nis, nama, kelas, password, role) VALUES (:nis, :nama, :kelas, :password, :role)');
            $stmt->execute([
                ':nis' => $nis,
                ':nama' => $nama,
                ':kelas' => $kelas,
                ':password' => $password,
                ':role' => $role,
            ]);

            return ['success' => true, 'message' => 'User berhasil ditambahkan!', 'id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log('Error User::save: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menambahkan user: ' . $e->getMessage()];
        }
    }

    // Update user
    public function update(int $id, string $nis, string $nama, string $kelas, string $password, string $role): array
    {
        try {
            if ($this->nisExists($nis, $id)) {
                return ['success' => false, 'message' => 'NIS ' . $nis . ' sudah digunakan!'];
            }
            if ($this->exists($nama, $id)) {
                return ['success' => false, 'message' => 'Nama "' . $nama . '" sudah digunakan!'];
            }

            if (!empty($password)) {
                $stmt = $this->pdo->prepare('UPDATE users SET nis = :nis, nama = :nama, kelas = :kelas, password = :password, role = :role WHERE id = :id');
                $stmt->execute([
                    ':nis' => $nis,
                    ':nama' => $nama,
                    ':kelas' => $kelas,
                    ':password' => password_hash($password, PASSWORD_DEFAULT),
                    ':role' => $role,
                    ':id' => $id,
                ]);
            } else {
                $stmt = $this->pdo->prepare('UPDATE users SET nis = :nis, nama = :nama, kelas = :kelas, role = :role WHERE id = :id');
                $stmt->execute([
                    ':nis' => $nis,
                    ':nama' => $nama,
                    ':kelas' => $kelas,
                    ':role' => $role,
                    ':id' => $id,
                ]);
            }

            return ['success' => true, 'message' => 'User berhasil diperbarui!'];
        } catch (PDOException $e) {
            error_log('Error User::update: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal memperbarui user: ' . $e->getMessage()];
        }
    }

    // Hapus user
    public function delete(int $id): array
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return ['success' => true, 'message' => 'User berhasil dihapus!'];
        } catch (PDOException $e) {
            error_log('Error User::delete: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menghapus user: ' . $e->getMessage()];
        }
    }
}