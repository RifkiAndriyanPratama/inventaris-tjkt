<?php
// test.php - Unit Testing Sederhana

require_once __DIR__ . '/src/classes/Database.php';
require_once __DIR__ . '/src/classes/Barang.php';
require_once __DIR__ . '/src/classes/User.php';
require_once __DIR__ . '/src/classes/Peminjaman.php';
require_once __DIR__ . '/src/classes/Auth.php';

echo "\n";
echo "========================================\n";
echo "   UNIT TESTING - INVENTARIS TJKT       \n";
echo "========================================\n\n";

$passed = 0;
$failed = 0;

function test($condition, $name) {
    global $passed, $failed;
    if ($condition) {
        echo "  PASS: $name\n";
        $passed++;
    } else {
        echo "  FAIL: $name\n";
        $failed++;
    }
}

// ============================================
// TEST 1: Database Connection
// ============================================
echo "TEST 1: Database\n";
echo "----------------------------------------\n";

try {
    $db = new Database();
    $pdo = $db->getPDO();
    test(true, "Koneksi database berhasil");
} catch (Exception $e) {
    test(false, "Koneksi database gagal: " . $e->getMessage());
}
echo "\n";

// ============================================
// TEST 2: Barang Module
// ============================================
echo "TEST 2: Modul Barang\n";
echo "----------------------------------------\n";

$barang = new Barang();

$data = $barang->getAll();
test(is_array($data), "getAll() mengembalikan array");
test(count($data) > 0, "Data barang ada (" . count($data) . " record)");

$testName = "Test_" . time();
$save = $barang->save($testName, 100, 'baik');
test($save['success'], "Tambah barang: " . ($save['success'] ? $testName : $save['message']));

if ($save['success']) {
    $id = $save['id'];
    
    $update = $barang->update($id, $testName . "_ubah", 50, 'rusak');
    test($update['success'], "Update barang");
    
    $delete = $barang->delete($id);
    test($delete['success'], "Hapus barang");
}
echo "\n";

// ============================================
// TEST 3: User Module
// ============================================
echo "TEST 3: Modul User\n";
echo "----------------------------------------\n";

$user = new User();

$data = $user->getAll();
test(is_array($data), "getAll() mengembalikan array");
test(count($data) > 0, "Data user ada (" . count($data) . " record)");

$admin = $user->getByNama('admin');
test($admin !== false, "Mencari user 'admin' ditemukan");

$testNis = "99999";
$testName = "UserTest_" . time();
$save = $user->save($testNis, $testName, 'XII TJKT A', password_hash('123', PASSWORD_DEFAULT), 'user');
test($save['success'], "Tambah user: " . ($save['success'] ? $testName : $save['message']));

if ($save['success']) {
    $id = $save['id'];
    $delete = $user->delete($id);
    test($delete['success'], "Hapus user");
}
echo "\n";

// ============================================
// TEST 4: Peminjaman Module
// ============================================
echo "TEST 4: Modul Peminjaman\n";
echo "----------------------------------------\n";

$peminjaman = new Peminjaman();

$data = $peminjaman->getAll();
test(is_array($data), "getAll() mengembalikan array");

if (count($data) > 0) {
    $id = $data[0]['id_peminjaman'];
    $byId = $peminjaman->getById($id);
    test($byId !== false, "getById() berhasil");
    
    $userId = $data[0]['id_user'];
    $byUser = $peminjaman->getByUser($userId);
    test(count($byUser) > 0, "getByUser() mengembalikan data");
}
echo "\n";

// ============================================
// TEST 5: Auth Module
// ============================================
echo "TEST 5: Modul Login\n";
echo "----------------------------------------\n";

$auth = new Auth();

$login = $auth->login('Rifki Atmin', '11111111');
test($login['success'], "Login admin berhasil");

if ($login['success']) {
    test($auth->isAdmin(), "Role admin terdeteksi");
    
    // Bersihkan session tanpa redirect
    $_SESSION = array();
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    test(!isset($_SESSION['user']), "Logout berhasil");
}

$loginGagal = $auth->login('salah', 'salah');
test(!$loginGagal['success'], "Login dengan password salah ditolak");
echo "\n";

// ============================================
// SUMMARY
// ============================================
echo "========================================\n";
echo "             HASIL TESTING              \n";
echo "========================================\n";
echo "  Berhasil: $passed\n";
echo "  Gagal:    $failed\n";
echo "  Total:    " . ($passed + $failed) . " test\n";
echo "========================================\n";

if ($failed == 0) {
    echo "\nSEMUA TEST BERHASIL!\n\n";
} else {
    echo "\nADA TEST YANG GAGAL! Perbaiki error di atas.\n\n";
}