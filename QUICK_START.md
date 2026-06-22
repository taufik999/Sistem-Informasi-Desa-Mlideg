# 🚀 QUICK START - Implementasi AHP

Panduan cepat untuk memulai menggunakan sistem AHP dalam 5 menit.

---

## 📋 Prerequisites

- Laravel 11+ sudah terinstall
- Database sudah dikonfigurasi
- Command line access

---

## ⚡ Step 1: Jalankan Migrations

```bash
php artisan migrate
```

**Output yang diharapkan:**
```
Migrating: 2026_04_27_000001_create_ahp_criteria_table
Migrated:  2026_04_27_000001_create_ahp_criteria_table (...)
Migrating: 2026_04_27_000002_create_ahp_pairwise_comparisons_table
Migrated:  2026_04_27_000002_create_ahp_pairwise_comparisons_table (...)
...
```

---

## ⚡ Step 2: Akses Dashboard AHP

Setelah login sebagai admin, klik menu **AHP**:

1. Buka browser: `http://localhost:8000/admin/ahp`
2. Atau navigasi dari dashboard admin

---

## ⚡ Step 3: Inisialisasi Kriteria Default

**Lokasi**: `/admin/ahp/criteria`

1. Klik tombol **"Inisialisasi Kriteria Default"**
2. Sistem akan membuat 3 kriteria:
   - ✅ Dampak
   - ✅ Urgensi
   - ✅ Kompleksitas

---

## ⚡ Step 4: Atur Perbandingan Kriteria

**Lokasi**: `/admin/ahp/pairwise`

Isi perbandingan berpasangan (gunakan skala 1-9):

| Perbandingan | Nilai | Arti |
|--------------|-------|------|
| Dampak vs Urgensi | 3 | Dampak sedikit lebih penting |
| Dampak vs Kompleksitas | 5 | Dampak lebih penting |
| Urgensi vs Kompleksitas | 2 | Urgensi lebih penting |

Kemudian klik **"Hitung Bobot Kriteria"**

**Output yang diharapkan:**
```
Bobot Kriteria:
- Dampak: 67%
- Urgensi: 17%
- Kompleksitas: 16%
Consistency Ratio: 0.0432 ✓ Konsisten
```

---

## ⚡ Step 5: Nilai Laporan Warga

**Lokasi**: `/admin/ahp/assessment`

Untuk setiap laporan yang masuk:

1. Klik tombol **"Nilai"**
2. Beri skor 1-9 untuk setiap kriteria:
   - **Dampak**: Seberapa besar dampaknya? (1=rendah, 9=tinggi)
   - **Urgensi**: Seberapa mendesak? (1=tidak urgent, 9=sangat urgent)
   - **Kompleksitas**: Seberapa sulit? (1=mudah, 9=sangat sulit)
3. Klik **"Simpan Penilaian"**

**Contoh:**
```
Laporan: Jalan Rusak Parah
- Dampak: 8 (banyak warga terdampak)
- Urgensi: 9 (harus diperbaiki segera)
- Kompleksitas: 6 (memerlukan perbaikan besar)
```

---

## ⚡ Step 6: Hitung Prioritas

**Lokasi**: `/admin/ahp/assessment`

Setelah menilai semua laporan, klik **"Hitung Prioritas Laporan"**

Sistem akan menghitung skor AHP untuk setiap laporan.

---

## ⚡ Step 7: Lihat Ranking

**Lokasi**: `/admin/ahp/ranking`

Lihat hasil ranking laporan berdasarkan prioritas:

```
🥇 Rank 1: LPR-ABC123 (Skor: 0.4321)
   Jalan Rusak Parah - Tangani Terlebih Dahulu

🥈 Rank 2: LPR-DEF456 (Skor: 0.3891)
   Drainase Buntu - Prioritas Kedua

🥉 Rank 3: LPR-XYZ789 (Skor: 0.2134)
   Lampu Jalan Mati - Prioritas Ketiga
```

---

## ✅ Testing dengan Sample Data

Jalankan seeder untuk membuat data sample:

```bash
php artisan db:seed --class=AhpSeeder
```

Ini akan:
- ✅ Membuat kriteria default
- ✅ Mengatur perbandingan berpasangan
- ✅ Menghitung bobot kriteria
- ✅ Membuat 3 laporan sample
- ✅ Menghitung prioritas

---

## 🔍 Verifikasi Instalasi

### Cek Database Tables

```bash
php artisan tinker
```

```php
> DB::table('ahp_criteria')->count()
> DB::table('ahp_pairwise_comparisons')->count()
> DB::table('report_priorities')->count()
```

### Cek Routes

```bash
php artisan route:list | grep ahp
```

Seharusnya menampilkan:
```
GET|POST     /admin/ahp
GET|POST     /admin/ahp/criteria
GET|POST     /admin/ahp/pairwise
GET|POST     /admin/ahp/assessment
GET          /admin/ahp/ranking
```

---

## 📚 File-file Penting

| File | Deskripsi |
|------|-----------|
| `app/Services/AhpService.php` | Service untuk kalkulasi AHP |
| `app/Http/Controllers/AhpController.php` | Controller untuk routes AHP |
| `app/Models/AhpCriteria.php` | Model untuk kriteria |
| `app/Models/AhpPairwiseComparison.php` | Model untuk perbandingan |
| `app/Models/AhpReportAssessment.php` | Model untuk penilaian laporan |
| `app/Models/ReportPriority.php` | Model untuk hasil ranking |
| `resources/views/admin/ahp-*.blade.php` | View files untuk UI |
| `AHP_IMPLEMENTATION.md` | Dokumentasi lengkap |

---

## 🐛 Troubleshooting

### Error: "Class 'AhpService' not found"
```bash
composer dump-autoload
```

### Error: "Table doesn't exist"
```bash
php artisan migrate:fresh
```

### Error: "Inconsistent pairwise comparison"
- CR > 0.1 berarti penilaian Anda tidak konsisten
- Revisi nilai perbandingan berpasangan di halaman Pairwise Comparison

### Reset Semua Data AHP
```bash
# Dari halaman dashboard
/admin/ahp/reset

# Atau via database
php artisan tinker
> DB::table('ahp_criteria')->truncate();
> DB::table('ahp_pairwise_comparisons')->truncate();
> DB::table('ahp_report_assessments')->truncate();
> DB::table('report_priorities')->truncate();
```

---

## 💡 Tips & Tricks

### Tip 1: Konsistensi Penilaian
Jika Consistency Ratio > 0.1:
1. Periksa perbandingan berpasangan Anda
2. Pastikan logika penilaian konsisten (jika A > B dan B > C, maka A > C)
3. Revisi nilai yang tidak konsisten

### Tip 2: Skor Laporan
Saat menilai laporan, gunakan skala yang konsisten:
- **1-3**: Rendah (tidak urgent, dampak kecil, mudah dikerjakan)
- **4-6**: Sedang (cukup urgent, dampak sedang, kompleksitas sedang)
- **7-9**: Tinggi (sangat urgent, dampak besar, kompleks)

### Tip 3: Perubahan Kriteria
Jika ingin mengubah kriteria:
1. Reset semua data: `/admin/ahp/reset`
2. Buat kriteria baru
3. Lakukan perbandingan berpasangan lagi
4. Nilai ulang laporan

---

## 📞 Support

Untuk dokumentasi lengkap, lihat: `AHP_IMPLEMENTATION.md`

Untuk contoh penggunaan API, lihat: `app/Examples/AhpUsageExample.php`

---

**Happy Prioritizing! 🎯**
