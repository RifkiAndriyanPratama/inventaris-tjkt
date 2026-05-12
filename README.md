# 📦 Aplikasi Inventaris TJKT

Aplikasi manajemen inventaris dan peminjaman barang berbasis web untuk lab/bengkel **Teknik Jaringan Komputer dan Telekomunikasi (TJKT)** di SMK N 1 Pundong. Dibangun dengan arsitektur *Object-Oriented Programming* (OOP) murni menggunakan PHP dan PDO MySQL.

---

## 🚀 Fitur Utama

Aplikasi dilengkapi sistem autentikasi dengan dua peran pengguna (*Role-Based Access Control*).

### 👨‍💻 Admin (Guru / Pengelola)

| Fitur | Deskripsi |
|---|---|
| Dashboard | Ringkasan total user, barang, status stok, dan statistik peminjaman |
| Manajemen Barang | CRUD barang lab/bengkel dengan pengecekan stok *real-time* |
| Manajemen User | Kelola data pengguna (siswa) dan hak akses (Admin/User) |
| Manajemen Peminjaman | Setujui, tolak, atau konfirmasi pengembalian barang |
| Laporan | Filter laporan per bulan/tahun dan ekspor data untuk administrasi |

### 🧑‍🎓 User (Siswa)

| Fitur | Deskripsi |
|---|---|
| Katalog Barang | Lihat daftar barang, stok, dan kondisinya |
| Pengajuan Peminjaman | Pinjam barang dengan validasi stok otomatis |
| Riwayat Peminjaman | Pantau status: Menunggu, Dipinjam, Ditolak, atau Dikembalikan |

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|---|---|
| Backend | PHP 8.x |
| Database | MySQL dengan PDO (*PHP Data Objects*) |
| Frontend | HTML5, Tailwind CSS, JavaScript |
| Environment | Docker & Docker Compose *(opsional)* |

---

## ⚙️ Persyaratan Sistem

Jika menjalankan **tanpa Docker**:

- Web server terintegrasi: XAMPP, MAMP, atau Laragon
- PHP >= 8.0
- MySQL >= 5.7

---

## 💻 Instalasi

### Opsi 1: Docker *(Direkomendasikan)*

```bash
# 1. Clone repository
git clone https://github.com/RifkiAndriyanPratama/inventaris-tjkt.git
cd inventaris-tjkt

# 2. Buat file .env
cp .env.example .env

# 3. Jalankan Docker Compose
docker-compose up -d --build
```

Akses aplikasi di: `http://localhost:8080`

---

### Opsi 2: Manual (XAMPP / Laragon)

```bash
# 1. Clone repository ke folder htdocs / www
git clone https://github.com/RifkiAndriyanPratama/inventaris-tjkt.git
```

2. Buat database baru di MySQL, contoh: `inventaris_tjkt`
3. Import file `inventaris.sql` ke database tersebut
4. Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi:

```env
DB_HOST=localhost
DB_NAME=inventaris_tjkt
DB_USER=root
DB_PASS=
```

```bash
# 5. Jalankan built-in server PHP
php -S localhost:8080 -t public
```

Akses aplikasi di: `http://localhost:8080`

---

## 🔐 Akun Default (Testing)

| Peran | Nama | Password |
|---|---|---|
| Admin | Rifki Atmin | `11111111` |
| User | Rifki User | `11111111` |

---

## 📂 Struktur Direktori

```
📦 inventaris-tjkt
 ┣ 📂 public/           # Root direktori web (index, assets CSS/JS, pages)
 ┣ 📂 src/
 ┃ ┗ 📂 classes/        # Logika utama OOP (Database.php, Auth.php, Barang.php, dll.)
 ┣ 📂 views/            # Template layout admin, user, dan komponen UI
 ┣ 📜 .env.example      # Contoh konfigurasi environment
 ┣ 📜 docker-compose.yml
 ┣ 📜 Dockerfile
 ┗ 📜 inventaris.sql    # Ekspor struktur dan seeder database
```

---

## ✒️ Author

Dikembangkan oleh **Rifki Andriyan Pratama** sebagai pemenuhan Proyek Ujian Akhir Semester mata kuliah Konsep Bahasa Pemrograman.
