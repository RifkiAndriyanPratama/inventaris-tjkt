<?php

require_once __DIR__.'/../config/connection.php';

function cek_user_exists(PDO $pdo, $nama, $exclude_id = null): bool
{
    try {
        if ($exclude_id) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE nama = :nama AND id != :id');
            $stmt->execute([
                ':nama' => $nama,
                ':id' => $exclude_id,
            ]);
        } else {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE nama = :nama');
            $stmt->execute([':nama' => $nama]);
        }

        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log('Error cek_user_exists: '.$e->getMessage());

        return false;
    }
}

function cek_barang_exists(PDO $pdo, $nama_barang, $exclude_id = null): bool
{
    try {
        if ($exclude_id) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM barang WHERE nama_barang = :nama_barang AND id != :id');
            $stmt->execute([
                ':nama_barang' => $nama_barang,
                ':id' => $exclude_id,
            ]);
        } else {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM barang WHERE nama_barang = :nama_barang');
            $stmt->execute([':nama_barang' => $nama_barang]);
        }

        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log('Error cek_barang_exists: '.$e->getMessage());

        return false;
    }
}

function cek_stok_cukup(PDO $pdo, $id_barang, $jumlah_dipinjam): bool
{
    try {
        $stmt = $pdo->prepare('SELECT stok FROM barang WHERE id = :id');
        $stmt->execute([':id' => $id_barang]);
        $stok = $stmt->fetchColumn();

        return $stok >= $jumlah_dipinjam;
    } catch (PDOException $e) {
        error_log('Error cek_stok_cukup: '.$e->getMessage());

        return false;
    }
}

function cek_user_sedang_meminjam(PDO $pdo, $id_user, $id_barang): bool
{
    try {
        $stmt = $pdo->prepare('
            SELECT COUNT(*) FROM peminjaman 
            WHERE id_user = :id_user 
            AND id_barang = :id_barang 
            AND status IN ("pending", "dipinjam")
        ');
        $stmt->execute([
            ':id_user' => $id_user,
            ':id_barang' => $id_barang,
        ]);

        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log('Error cek_user_sedang_meminjam: '.$e->getMessage());

        return false;
    }
}

function get_stok_barang(PDO $pdo, $id_barang)
{
    try {
        $stmt = $pdo->prepare('SELECT stok FROM barang WHERE id = :id');
        $stmt->execute([':id' => $id_barang]);

        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Error get_stok_barang: '.$e->getMessage());

        return 0;
    }
}

// user
function get_all_users(PDO $pdo): array
{
    try {
        $stmt = $pdo->prepare('SELECT * FROM users');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error get_all_users: '.$e->getMessage());

        return [];
    }
}

function save_user(PDO $pdo, $nis, $nama, $kelas, $password, $role = 'user')
{
    try {
        // Cek duplikat NIS
        if (cek_nis_exists($pdo, $nis)) {
            return [
                'success' => false,
                'message' => 'NIS '.$nis.' sudah terdaftar!',
            ];
        }

        // Cek duplikat nama
        if (cek_user_exists($pdo, $nama)) {
            return [
                'success' => false,
                'message' => 'Nama user "'.$nama.'" sudah terdaftar!',
            ];
        }

        $stmt = $pdo->prepare('INSERT INTO users (nis, nama, kelas, password, role) VALUES (:nis, :nama, :kelas, :password, :role)');
        $stmt->execute([
            ':nis' => $nis,
            ':nama' => $nama,
            ':kelas' => $kelas,
            ':password' => $password,
            ':role' => $role,
        ]);

        return [
            'success' => true,
            'message' => 'User berhasil ditambahkan!',
            'id' => $pdo->lastInsertId(),
        ];
    } catch (PDOException $e) {
        error_log('Error save_user: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menambahkan user: '.$e->getMessage(),
        ];
    }
}

function update_user(PDO $pdo, $id, $nis, $nama, $kelas, $password, $role)
{
    try {
        // Cek duplikat NIS
        if (cek_nis_exists($pdo, $nis, $id)) {
            return [
                'success' => false,
                'message' => 'NIS '.$nis.' sudah digunakan oleh user lain!',
            ];
        }

        // Cek duplikat nama
        if (cek_user_exists($pdo, $nama, $id)) {
            return [
                'success' => false,
                'message' => 'Nama user "'.$nama.'" sudah digunakan oleh user lain!',
            ];
        }

        if (! empty($password)) {
            $stmt = $pdo->prepare('UPDATE users SET nis = :nis, nama = :nama, kelas = :kelas, password = :password, role = :role WHERE id = :id');
            $stmt->execute([
                ':nis' => $nis,
                ':nama' => $nama,
                ':kelas' => $kelas,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':role' => $role,
                ':id' => $id,
            ]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET nis = :nis, nama = :nama, kelas = :kelas, role = :role WHERE id = :id');
            $stmt->execute([
                ':nis' => $nis,
                ':nama' => $nama,
                ':kelas' => $kelas,
                ':role' => $role,
                ':id' => $id,
            ]);
        }

        return [
            'success' => true,
            'message' => 'User berhasil diperbarui!',
        ];
    } catch (PDOException $e) {
        error_log('Error update_user: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal memperbarui user: '.$e->getMessage(),
        ];
    }
}

function cek_nis_exists(PDO $pdo, $nis, $exclude_id = null): bool
{
    try {
        if ($exclude_id) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE nis = :nis AND id != :id');
            $stmt->execute([
                ':nis' => $nis,
                ':id' => $exclude_id,
            ]);
        } else {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE nis = :nis');
            $stmt->execute([':nis' => $nis]);
        }

        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log('Error cek_nis_exists: '.$e->getMessage());

        return false;
    }
}

function delete_user(PDO $pdo, $id)
{
    try {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return [
            'success' => true,
            'message' => 'User berhasil dihapus!',
        ];
    } catch (PDOException $e) {
        error_log('Error delete_user: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menghapus user: '.$e->getMessage(),
        ];
    }
}

function get_user_by_nama(PDO $pdo, $nama): array|false
{
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE nama = :nama');
        $stmt->execute([':nama' => $nama]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error get_user_by_nama: '.$e->getMessage());

        return false;
    }
}

// barang
function get_all_barang(PDO $pdo): array
{
    try {
        $stmt = $pdo->prepare('SELECT * FROM barang');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error get_all_barang: '.$e->getMessage());

        return [];
    }
}

function save_barang(PDO $pdo, $nama_barang, $stok, $status)
{
    try {
        // Cek duplikat
        if (cek_barang_exists($pdo, $nama_barang)) {
            return [
                'success' => false,
                'message' => 'Barang "'.$nama_barang.'" sudah ada di database!',
            ];
        }

        $stmt = $pdo->prepare('INSERT INTO barang(nama_barang, stok, status) VALUES (:nama_barang, :stok, :status)');
        $stmt->execute([
            ':nama_barang' => $nama_barang,
            ':stok' => $stok,
            ':status' => $status,
        ]);

        return [
            'success' => true,
            'message' => 'Barang berhasil ditambahkan!',
            'id' => $pdo->lastInsertId(),
        ];
    } catch (PDOException $e) {
        error_log('Error save_barang: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menambahkan barang: '.$e->getMessage(),
        ];
    }
}

function update_barang(PDO $pdo, $id, $nama_barang, $stok, $status)
{
    try {
        // Cek duplikat
        if (cek_barang_exists($pdo, $nama_barang, $id)) {
            return [
                'success' => false,
                'message' => 'Barang "'.$nama_barang.'" sudah ada di database!',
            ];
        }

        $stmt = $pdo->prepare('UPDATE barang SET nama_barang = :nama_barang, stok = :stok, status = :status WHERE id = :id');
        $stmt->execute([
            ':nama_barang' => $nama_barang,
            ':stok' => $stok,
            ':status' => $status,
            ':id' => $id,
        ]);

        return [
            'success' => true,
            'message' => 'Barang berhasil diperbarui!',
        ];
    } catch (PDOException $e) {
        error_log('Error update_barang: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal memperbarui barang: '.$e->getMessage(),
        ];
    }
}

function delete_barang(PDO $pdo, $id)
{
    try {
        $stmt = $pdo->prepare('DELETE FROM barang WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return [
            'success' => true,
            'message' => 'Barang berhasil dihapus!',
        ];
    } catch (PDOException $e) {
        error_log('Error delete_barang: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menghapus barang: '.$e->getMessage(),
        ];
    }
}

// Peminjaman
function get_all_peminjaman(PDO $pdo): array
{
    try {
        $stmt = $pdo->prepare('
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
                p.tanggal_pinjam,  -- ← ganti dari tanggal_pinjam jadi tanggal_pinjam
                p.tanggal_kembali, 
                p.status as status_pinjam
            FROM peminjaman p 
            JOIN users u ON p.id_user = u.id 
            JOIN barang b ON p.id_barang = b.id
            ORDER BY p.id DESC
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error get_all_peminjaman: '.$e->getMessage());

        return [];
    }
}

function get_peminjaman_by_user(PDO $pdo, $id_user): array
{
    try {
        $stmt = $pdo->prepare('
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
        $stmt->execute([':id_user' => $id_user]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error get_peminjaman_by_user: '.$e->getMessage());

        return [];
    }
}

function save_peminjaman(PDO $pdo, $id_user, $id_barang, $jumlah)
{
    try {
        // Cek stok
        if (! cek_stok_cukup($pdo, $id_barang, $jumlah)) {
            $stok = get_stok_barang($pdo, $id_barang);

            return [
                'success' => false,
                'message' => "Stok tidak mencukupi! Stok tersedia: $stok",
            ];
        }

        // Cek apakah user sedang meminjam barang yang sama
        if (cek_user_sedang_meminjam($pdo, $id_user, $id_barang)) {
            return [
                'success' => false,
                'message' => 'User sedang meminjam barang ini dan belum dikembalikan!',
            ];
        }

        $stmt = $pdo->prepare('
            INSERT INTO peminjaman (id_user, id_barang, jumlah, tanggal_pinjam, status) 
            VALUES (:id_user, :id_barang, :jumlah, :tanggal_pinjam, :status)
        ');
        $stmt->execute([
            ':id_user' => $id_user,
            ':id_barang' => $id_barang,
            ':jumlah' => $jumlah,
            ':tanggal_pinjam' => date('Y-m-d'),
            ':status' => 'pending',
        ]);

        return [
            'success' => true,
            'message' => 'Peminjaman berhasil diajukan!',
            'id' => $pdo->lastInsertId(),
        ];
    } catch (PDOException $e) {
        error_log('Error save_peminjaman: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menambahkan peminjaman: '.$e->getMessage(),
        ];
    }
}

function update_peminjaman(PDO $pdo, $id_peminjaman, $jumlah)
{
    try {
        // Ambil data peminjaman lama
        $stmt = $pdo->prepare('SELECT id_barang, jumlah FROM peminjaman WHERE id = :id');
        $stmt->execute([':id' => $id_peminjaman]);
        $old = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $old) {
            return [
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan!',
            ];
        }

        $id_barang = $old['id_barang'];
        $old_jumlah = $old['jumlah'];

        // Hitung selisih
        $selisih = $jumlah - $old_jumlah;

        // Cek stok cukup jika ada penambahan
        if ($selisih > 0) {
            $stmt = $pdo->prepare('SELECT stok FROM barang WHERE id = :id');
            $stmt->execute([':id' => $id_barang]);
            $stok = $stmt->fetchColumn();

            if ($stok < $selisih) {
                return [
                    'success' => false,
                    'message' => "Stok tidak mencukupi! Stok tersedia: $stok",
                ];
            }

            // Kurangi stok
            $stmt = $pdo->prepare('UPDATE barang SET stok = stok - :selisih WHERE id = :id');
            $stmt->execute([
                ':selisih' => $selisih,
                ':id' => $id_barang,
            ]);
        } elseif ($selisih < 0) {
            // Tambah stok
            $stmt = $pdo->prepare('UPDATE barang SET stok = stok + :selisih WHERE id = :id');
            $stmt->execute([
                ':selisih' => abs($selisih),
                ':id' => $id_barang,
            ]);
        }

        // Update jumlah peminjaman
        $stmt = $pdo->prepare('UPDATE peminjaman SET jumlah = :jumlah WHERE id = :id');
        $stmt->execute([
            ':jumlah' => $jumlah,
            ':id' => $id_peminjaman,
        ]);

        return [
            'success' => true,
            'message' => 'Peminjaman berhasil diperbarui!',
        ];

    } catch (PDOException $e) {
        error_log('Error update_peminjaman: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal memperbarui peminjaman: '.$e->getMessage(),
        ];
    }
}

function delete_peminjaman(PDO $pdo, $id_peminjaman)
{
    try {
        // Ambil data peminjaman
        $stmt = $pdo->prepare('SELECT id_barang, jumlah, status FROM peminjaman WHERE id = :id');
        $stmt->execute([':id' => $id_peminjaman]);
        $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $peminjaman) {
            return [
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan!',
            ];
        }

        // kembalikan stok
        if ($peminjaman['status'] === 'dipinjam') {
            $stmt = $pdo->prepare('UPDATE barang SET stok = stok + :jumlah WHERE id = :id');
            $stmt->execute([
                ':jumlah' => $peminjaman['jumlah'],
                ':id' => $peminjaman['id_barang'],
            ]);
        }

        // Hapus peminjaman
        $stmt = $pdo->prepare('DELETE FROM peminjaman WHERE id = :id');
        $stmt->execute([':id' => $id_peminjaman]);

        return [
            'success' => true,
            'message' => 'Peminjaman berhasil dihapus!',
        ];

    } catch (PDOException $e) {
        error_log('Error delete_peminjaman: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menghapus peminjaman: '.$e->getMessage(),
        ];
    }
}

function update_status_peminjaman(PDO $pdo, $id_peminjaman, $status)
{
    try {
        if ($status === 'dipinjam') {
            // Approve dan kurangi stok
            $stmt = $pdo->prepare('
                UPDATE peminjaman p 
                JOIN barang b ON p.id_barang = b.id 
                SET p.status = :status, b.stok = b.stok - p.jumlah 
                WHERE p.id = :id
            ');
        } else {
            $stmt = $pdo->prepare('UPDATE peminjaman SET status = :status WHERE id = :id');
        }

        $stmt->execute([
            ':status' => $status,
            ':id' => $id_peminjaman,
        ]);

        return [
            'success' => true,
            'message' => $status === 'dipinjam' ? 'Peminjaman disetujui!' : 'Status peminjaman berhasil diperbarui!',
        ];
    } catch (PDOException $e) {
        error_log('Error update_status_peminjaman: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal memperbarui status: '.$e->getMessage(),
        ];
    }
}

function tolak_peminjaman(PDO $pdo, $id_peminjaman)
{
    try {
        $stmt = $pdo->prepare('UPDATE peminjaman SET status = "ditolak" WHERE id = :id');
        $stmt->execute([':id' => $id_peminjaman]);

        return [
            'success' => true,
            'message' => 'Peminjaman berhasil ditolak!',
        ];
    } catch (PDOException $e) {
        error_log('Error tolak_peminjaman: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal menolak peminjaman: '.$e->getMessage(),
        ];
    }
}

function kembalikan_barang(PDO $pdo, $id_peminjaman, $jumlah)
{
    try {
        $pdo->beginTransaction();

        // Update status peminjaman dan tambah stok
        $stmt = $pdo->prepare('
            UPDATE peminjaman p 
            JOIN barang b ON p.id_barang = b.id 
            SET p.status = :status, 
                b.stok = b.stok + :jumlah, 
                p.tanggal_kembali = :tanggal_kembali 
            WHERE p.id = :id
        ');
        $stmt->execute([
            ':status' => 'dikembalikan',
            ':jumlah' => $jumlah,
            ':tanggal_kembali' => date('Y-m-d'),
            ':id' => $id_peminjaman,
        ]);

        $pdo->commit();

        return [
            'success' => true,
            'message' => 'Barang berhasil dikembalikan!',
        ];
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log('Error kembalikan_barang: '.$e->getMessage());

        return [
            'success' => false,
            'message' => 'Gagal mengembalikan barang: '.$e->getMessage(),
        ];
    }
}
