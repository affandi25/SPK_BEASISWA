# Sistem Pendukung Keputusan Penerimaan Beasiswa

Aplikasi web untuk membantu proses seleksi penerima beasiswa menggunakan metode **Simple Additive Weighting (SAW)**.

## 🎯 Fitur

- ✅ Login & Autentikasi (Admin & Staff)
- ✅ Manajemen Data Siswa (CRUD)
- ✅ Perhitungan Ranking dengan Metode SAW
- ✅ Pengaturan Kuota Beasiswa
- ✅ Pengaturan Bobot Kriteria
- ✅ Filter Berdasarkan Jenis Beasiswa
- ✅ Lupa Password
- ✅ Role-Based Access Control

## 🛠️ Teknologi

- **Frontend:** HTML, CSS, JavaScript (Vanilla)
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Server:** Apache (XAMPP/WAMP)

## 📋 Kriteria Penilaian

### Beasiswa Prestasi
- Nilai Raport: **0.80** (bobot tertinggi)
- Penghasilan Orang Tua: **0.60**
- Tanggungan Orang Tua: **0.40**

### Beasiswa Kurang Mampu
- Nilai Raport: **0.60**
- Penghasilan Orang Tua: **0.80** (bobot tertinggi)
- Tanggungan Orang Tua: **0.40**

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/projekdss.git
cd projekdss
```

### 2. Setup Database
- Buka **phpMyAdmin** (`http://localhost/phpmyadmin`)
- Buat database baru: `projekdss`
- Import file `database/schema.sql`

### 3. Konfigurasi Database
- Copy file `config/database.example.php` menjadi `config/database.php`
- Edit `config/database.php` sesuai konfigurasi MySQL kamu:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');           // Password MySQL
define('DB_NAME', 'projekdss');
```

### 4. Setup BASE_URL
Edit `config/database.php`, sesuaikan BASE_URL:
```php
define('BASE_URL', '/projekdss/');  // Sesuaikan dengan folder kamu
```

### 5. Akses Aplikasi
Buka browser: `http://localhost/projekdss`

## 🔐 Login Default

Setelah import `schema.sql`, gunakan akun ini untuk login:

**Username:** `admin`  
**Password:** Gunakan fitur **"Lupa Password"** di halaman login untuk set password pertama kali

## 📁 Struktur Folder

```
projekdss/
├── config/              # Konfigurasi database
├── controllers/         # Business logic
├── models/              # Data models
├── views/               # UI/Templates
├── assets/              # CSS, JS, Images
├── includes/            # Helper files
├── database/            # SQL schema
└── index.php            # Landing page
```

## 📖 Cara Penggunaan

1. **Login** sebagai admin
2. **Tambah data siswa** via menu "Data Siswa"
3. **Set kuota** di menu "Pengaturan" (admin only)
4. **Hitung ranking** di menu "Ranking"
5. Sistem otomatis menentukan status **diterima/ditolak** berdasarkan kuota

## 🔒 Keamanan

- Password di-hash menggunakan **bcrypt**
- Prepared statements untuk mencegah **SQL Injection**
- Session management untuk autentikasi
- Role-based access control (RBAC)

## 📝 Lisensi

MIT License

## 👨‍💻 Author

[Nama Kamu]

## 🤝 Kontribusi

Pull requests are welcome! Untuk perubahan besar, silakan buka issue terlebih dahulu.
