<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Barang.php';

class Peminjaman extends Database
{
    // Cek user sedang meminjam barang yang sama
    public function userSedangMeminjam(int $idUser, int $idBarang): bool
    {
        try {
            $stmt = $this->pdo->prepare('
                SELECT COUNT(*) FROM peminjaman 
                WHERE id_user = :id_user 
                AND id_barang = :id_barang 
                AND status IN ("pending", "dipinjam")
            ');
            $stmt->execute([':id_user' => $idUser, ':id_barang' => $idBarang]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error Peminjaman::userSedangMeminjam: ' . $e->getMessage());
            return false;
        }
    }

    // Ambil semua peminjaman
    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->prepare('
                SELECT 
                    p.id as id_peminjaman, 
                    u.id as id_user, 
                    u.nama, 
                    u.kelas, 
                    b.id as id_barang,
                    b.nama_barang, 
                    b.stok, 
                    b.status as status_barang, 
                    p.jumlah, 
                    p.tanggal_pinjam, 
                    p.tanggal_kembali, 
                    p.status as status_pinjam
                FROM peminjaman p 
                JOIN users u ON p.id_user = u.id 
                JOIN barang b ON p.id_barang = b.id
                ORDER BY p.id DESC
            ');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error Peminjaman::getAll: ' . $e->getMessage());
            return [];
        }
    }

    // Ambil peminjaman by user
    public function getByUser(int $idUser): array
    {
        try {
            $stmt = $this->pdo->prepare('
                SELECT 
                    p.id as id_peminjaman,
                    b.nama_barang,
                    p.jumlah,
                    p.tanggal_pinjam,
                    p.tanggal_kembali,
                    p.status as status_pinjam
                FROM peminjaman p 
                JOIN barang b ON p.id_barang = b.id 
                WHERE p.id_user = :id_user
                ORDER BY p.tanggal_pinjam DESC
            ');
            $stmt->execute([':id_user' => $idUser]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error Peminjaman::getByUser: ' . $e->getMessage());
            return [];
        }
    }

    // Ambil satu peminjaman by ID (tambahan untuk action kembali)
    public function getById(int $id): array|false
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM peminjaman WHERE id = :id');
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error Peminjaman::getById: ' . $e->getMessage());
            return false;
        }
    }

    // Tambah peminjaman
    public function save(int $idUser, int $idBarang, int $jumlah): array
    {
        $barang = new Barang();

        try {
            if (!$barang->cekStokCukup($idBarang, $jumlah)) {
                $stok = $barang->getStok($idBarang);
                return ['success' => false, 'message' => "Stok tidak mencukupi! Stok tersedia: $stok"];
            }

            if ($this->userSedangMeminjam($idUser, $idBarang)) {
                return ['success' => false, 'message' => 'User sedang meminjam barang ini dan belum dikembalikan!'];
            }

            $stmt = $this->pdo->prepare('
                INSERT INTO peminjaman (id_user, id_barang, jumlah, tanggal_pinjam, status) 
                VALUES (:id_user, :id_barang, :jumlah, :tanggal_pinjam, :status)
            ');
            $stmt->execute([
                ':id_user' => $idUser,
                ':id_barang' => $idBarang,
                ':jumlah' => $jumlah,
                ':tanggal_pinjam' => date('Y-m-d'),
                ':status' => 'pending',
            ]);

            return ['success' => true, 'message' => 'Peminjaman berhasil diajukan!', 'id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log('Error Peminjaman::save: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menambahkan peminjaman: ' . $e->getMessage()];
        }
    }

    // Update peminjaman
    public function update(int $idPeminjaman, int $jumlah): array
    {
        $barang = new Barang();

        try {
            $stmt = $this->pdo->prepare('SELECT id_barang, jumlah FROM peminjaman WHERE id = :id');
            $stmt->execute([':id' => $idPeminjaman]);
            $old = $stmt->fetch();

            if (!$old) {
                return ['success' => false, 'message' => 'Data peminjaman tidak ditemukan!'];
            }

            $idBarang = $old['id_barang'];
            $oldJumlah = $old['jumlah'];
            $selisih = $jumlah - $oldJumlah;

            if ($selisih > 0) {
                if (!$barang->cekStokCukup($idBarang, $selisih)) {
                    return ['success' => false, 'message' => 'Stok tidak mencukupi!'];
                }
                $barang->kurangiStok($idBarang, $selisih);
            } elseif ($selisih < 0) {
                $barang->tambahStok($idBarang, abs($selisih));
            }

            $stmt = $this->pdo->prepare('UPDATE peminjaman SET jumlah = :jumlah WHERE id = :id');
            $stmt->execute([':jumlah' => $jumlah, ':id' => $idPeminjaman]);

            return ['success' => true, 'message' => 'Peminjaman berhasil diperbarui!'];
        } catch (PDOException $e) {
            error_log('Error Peminjaman::update: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal memperbarui peminjaman: ' . $e->getMessage()];
        }
    }

    // Hapus peminjaman
    public function delete(int $idPeminjaman): array
    {
        $barang = new Barang();

        try {
            $stmt = $this->pdo->prepare('SELECT id_barang, jumlah, status FROM peminjaman WHERE id = :id');
            $stmt->execute([':id' => $idPeminjaman]);
            $data = $stmt->fetch();

            if (!$data) {
                return ['success' => false, 'message' => 'Data peminjaman tidak ditemukan!'];
            }

            if ($data['status'] === 'dipinjam') {
                $barang->tambahStok($data['id_barang'], $data['jumlah']);
            }

            $stmt = $this->pdo->prepare('DELETE FROM peminjaman WHERE id = :id');
            $stmt->execute([':id' => $idPeminjaman]);

            return ['success' => true, 'message' => 'Peminjaman berhasil dihapus!'];
        } catch (PDOException $e) {
            error_log('Error Peminjaman::delete: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menghapus peminjaman: ' . $e->getMessage()];
        }
    }

    // Update status peminjaman
    public function updateStatus(int $idPeminjaman, string $status): array
    {
        $barang = new Barang();

        try {
            if ($status === 'dipinjam') {
                $stmt = $this->pdo->prepare('SELECT jumlah, id_barang FROM peminjaman WHERE id = :id');
                $stmt->execute([':id' => $idPeminjaman]);
                $data = $stmt->fetch();

                if ($data) {
                    $barang->kurangiStok($data['id_barang'], $data['jumlah']);
                }

                $stmt = $this->pdo->prepare('UPDATE peminjaman SET status = :status WHERE id = :id');
            } else {
                $stmt = $this->pdo->prepare('UPDATE peminjaman SET status = :status WHERE id = :id');
            }

            $stmt->execute([':status' => $status, ':id' => $idPeminjaman]);

            $message = $status === 'dipinjam' ? 'Peminjaman disetujui!' : 'Status peminjaman berhasil diperbarui!';
            return ['success' => true, 'message' => $message];
        } catch (PDOException $e) {
            error_log('Error Peminjaman::updateStatus: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal memperbarui status: ' . $e->getMessage()];
        }
    }

    // Kembalikan barang
    public function kembalikan(int $idPeminjaman, int $jumlah): array
    {
        $barang = new Barang();

        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('SELECT id_barang FROM peminjaman WHERE id = :id');
            $stmt->execute([':id' => $idPeminjaman]);
            $data = $stmt->fetch();

            if ($data) {
                $barang->tambahStok($data['id_barang'], $jumlah);
            }

            $stmt = $this->pdo->prepare('
                UPDATE peminjaman 
                SET status = :status, tanggal_kembali = :tanggal_kembali 
                WHERE id = :id
            ');
            $stmt->execute([
                ':status' => 'dikembalikan',
                ':tanggal_kembali' => date('Y-m-d'),
                ':id' => $idPeminjaman,
            ]);

            $this->pdo->commit();
            return ['success' => true, 'message' => 'Barang berhasil dikembalikan!'];
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('Error Peminjaman::kembalikan: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal mengembalikan barang: ' . $e->getMessage()];
        }
    }
}