### 1. Instalasi & Konfigurasi

Jalankan perintah berikut secara berurutan di terminal Anda.

```bash
# 1. Clone & masuk ke direktori
git clone https://github.com/fairuzulum/backend-test.git
cd backend-test

# 2. Install dependency
composer install

# 3. Buat file .env
cp .env.example .env

# 4. Generate APP_KEY (PENTING: Salin key ini!)
php artisan key:generate

# 5. Atur koneksi database di dalam file .env

# 6. Buat tabel & isi data awal (termasuk akun admin)
php artisan migrate --seed

# 7. Jalankan server lokal
php artisan serve
```

### 2. Setup Postman

Untuk testing API, gunakan file di bawah ini:
- **Collection**: [https://drive.google.com/file/d/11DJMlHSteZTR-7kKirwXOME-Kyzhr_JN/view?usp=sharing](LINK_JSON_COLLECTION)
- **Environment**: [https://drive.google.com/file/d/1H5MUijcPObIF7iisGIEngbNcPY2FX-tn/view?usp=sharing](LINK_JSON_ENVIRONMENT)

**Cara Pakai:**
1.  Impor kedua file di atas ke Postman.
2.  Buka **Environment** yang sudah diimpor.
3.  Cari variabel `APP_KEY`.
4.  Paste **`APP_KEY`** yang sudah Anda salin dari terminal tadi ke kolom `CURRENT VALUE`.
5.  Simpan dan gunakan environment tersebut untuk semua request.

### 3. Akun Admin

-   **Email**: `admin@gmail.com`
-   **Password**: `password`