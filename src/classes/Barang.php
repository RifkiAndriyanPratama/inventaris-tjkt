<?php

require_once __DIR__ . '/Database.php';

class Barang extends Database
{
    // Cek apakah barang sudah ada
    public function exists(string $namaBarang, ?int $excludeId = null): bool
    {
        try {
            if ($excludeId) {
                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM barang WHERE nama_barang = :nama_barang AND id != :id');
                $stmt->execute([':nama_barang' => $namaBarang, ':id' => $excludeId]);
            } else {
                $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM barang WHERE nama_barang = :nama_barang');
                $stmt->execute([':nama_barang' => $namaBarang]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error Barang::exists: ' . $e->getMessage());
            return false;
        }
    }

    // Ambil semua barang
    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM barang ORDER BY id DESC');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error Barang::getAll: ' . $e->getMessage());
            return [];
        }
    }

    // Ambil satu barang by ID
    public function getById(int $id): array|false
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM barang WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error Barang::getById: ' . $e->getMessage());
            return false;
        }
    }

    // Tambah barang
    public function save(string $namaBarang, int $stok, string $status): array
    {
        try {
            if ($this->exists($namaBarang)) {
                return ['success' => false, 'message' => 'Barang "' . $namaBarang . '" sudah ada!'];
            }

            $stmt = $this->pdo->prepare('INSERT INTO barang (nama_barang, stok, status) VALUES (:nama_barang, :stok, :status)');
            $stmt->execute([
                ':nama_barang' => $namaBarang,
                ':stok' => $stok,
                ':status' => $status,
            ]);

            return ['success' => true, 'message' => 'Barang berhasil ditambahkan!', 'id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log('Error Barang::save: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menambahkan barang: ' . $e->getMessage()];
        }
    }

    // Update barang
    public function update(int $id, string $namaBarang, int $stok, string $status): array
    {
        try {
            if ($this->exists($namaBarang, $id)) {
                return ['success' => false, 'message' => 'Barang "' . $namaBarang . '" sudah ada!'];
            }

            $stmt = $this->pdo->prepare('UPDATE barang SET nama_barang = :nama_barang, stok = :stok, status = :status WHERE id = :id');
            $stmt->execute([
                ':nama_barang' => $namaBarang,
                ':stok' => $stok,
                ':status' => $status,
                ':id' => $id,
            ]);

            return ['success' => true, 'message' => 'Barang berhasil diperbarui!'];
        } catch (PDOException $e) {
            error_log('Error Barang::update: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal memperbarui barang: ' . $e->getMessage()];
        }
    }

    // Hapus barang
    public function delete(int $id): array
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM barang WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return ['success' => true, 'message' => 'Barang berhasil dihapus!'];
        } catch (PDOException $e) {
            error_log('Error Barang::delete: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menghapus barang: ' . $e->getMessage()];
        }
    }

    // Cek stok
    public function cekStokCukup(int $idBarang, int $jumlah): bool
    {
        try {
            $stmt = $this->pdo->prepare('SELECT stok FROM barang WHERE id = :id');
            $stmt->execute([':id' => $idBarang]);
            $stok = $stmt->fetchColumn();
            return $stok >= $jumlah;
        } catch (PDOException $e) {
            error_log('Error Barang::cekStokCukup: ' . $e->getMessage());
            return false;
        }
    }

    // Kurangi stok
    public function kurangiStok(int $idBarang, int $jumlah): bool
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE barang SET stok = stok - :jumlah WHERE id = :id');
            $stmt->execute([':jumlah' => $jumlah, ':id' => $idBarang]);
            return true;
        } catch (PDOException $e) {
            error_log('Error Barang::kurangiStok: ' . $e->getMessage());
            return false;
        }
    }

    // Tambah stok
    public function tambahStok(int $idBarang, int $jumlah): bool
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE barang SET stok = stok + :jumlah WHERE id = :id');
            $stmt->execute([':jumlah' => $jumlah, ':id' => $idBarang]);
            return true;
        } catch (PDOException $e) {
            error_log('Error Barang::tambahStok: ' . $e->getMessage());
            return false;
        }
    }

    // Get stok
    public function getStok(int $idBarang): int
    {
        try {
            $stmt = $this->pdo->prepare('SELECT stok FROM barang WHERE id = :id');
            $stmt->execute([':id' => $idBarang]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error Barang::getStok: ' . $e->getMessage());
            return 0;
        }
    }
}