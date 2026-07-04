# BoreHouse

Sistem manajemen stok barang berbasis web untuk membantu warung/toko mencatat inventaris secara digital, menggantikan pencatatan manual.

## Latar Belakang

Masih banyak warung yang mencatat stok barang secara manual, sehingga rawan human error dan sulit dipantau secara real-time. BoreHouse hadir sebagai solusi digital untuk mengelola data stok barang dengan lebih cepat dan efisien.

## Fitur

- Input barang baru (nama & jumlah stok)
- Edit dan hapus data barang
- Tabel daftar stok barang (ID, nama, stok, aksi)
- Autentikasi login/logout
- Akses aplikasi dari desktop maupun smartphone

## Arsitektur

Aplikasi menggunakan arsitektur **client-server**:

- **Server**: Ubuntu Server
- **Backend**: Native PHP
- **Database**: MySQL
- **Cloud/Tunneling**: Ngrok
## Proses Pengerjaan

1. Perancangan sistem dan arsitektur client-server
2. Instalasi dan konfigurasi Ubuntu Server
3. Konfigurasi jaringan
4. Pembuatan aplikasi web (Native PHP + MySQL)
5. Integrasi cloud menggunakan Ngrok

## Cara Menjalankan

```bash
# Clone repository
git clone <repo-url>
cd borehouse

# Import database
mysql -u root -p < database/borehouse.sql

# Jalankan server PHP (development)
php -S localhost:8000

# Expose ke internet menggunakan Ngrok
ngrok http 80
```

## Konfigurasi Database

Sesuaikan kredensial database pada file konfigurasi (`config.php` atau sejenisnya):

```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "borehouse";
```

## Struktur Tabel Barang

| Kolom       | Tipe    | Keterangan            |
|-------------|---------|------------------------|
| id          | INT     | Primary key, auto increment |
| nama_barang | VARCHAR | Nama barang            |
| stok        | INT     | Jumlah stok             |

## Hasil

Aplikasi manajemen inventaris yang dapat diakses melalui desktop maupun smartphone, sehingga memudahkan user dalam mengelola stok barang secara lebih cepat dan efisien.
