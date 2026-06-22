# 📊 Sistem AHP untuk Prioritas Laporan Warga

Implementasi **Analytic Hierarchy Process (AHP)** untuk menentukan urgensi dan memprioritaskan laporan warga secara objektif dan terukur.

---

## 🎯 Tujuan

Memberikan sistem yang membantu admin desa untuk:
1. ✅ Menentukan kriteria urgensi laporan (Dampak, Urgensi, Kompleksitas)
2. ✅ Membandingkan tingkat kepentingan antar kriteria
3. ✅ Menilai setiap laporan berdasarkan kriteria
4. ✅ Menghitung skor prioritas secara objektif
5. ✅ Melihat urutan laporan yang harus ditangani terlebih dahulu

---

## 🚀 Quick Start

### 1. Setup Database
```bash
php artisan migrate
```

### 2. Test dengan Sample Data
```bash
php artisan db:seed --class=AhpSeeder
```

### 3. Akses Sistem
Login sebagai admin, kemudian kunjungi:
- **Dashboard**: `/admin/ahp`
- **Manajemen Kriteria**: `/admin/ahp/criteria`
- **Perbandingan Kriteria**: `/admin/ahp/pairwise`
- **Penilaian Laporan**: `/admin/ahp/assessment`
- **Ranking Laporan**: `/admin/ahp/ranking`

**Untuk detail lengkap**, baca `QUICK_START.md`

---

## 📁 Struktur File

```
├── app/
│   ├── Console/
│   ├── Examples/
│   │   └── AhpUsageExample.php          ← Contoh penggunaan API
│   ├── Http/
│   │   └── Controllers/
│   │       └── AhpController.php        ← Controller utama (11 methods)
│   ├── Models/
│   │   ├── AhpCriteria.php             ← Model kriteria
│   │   ├── AhpPairwiseComparison.php   ← Model perbandingan
│   │   ├── AhpReportAssessment.php     ← Model penilaian
│   │   └── ReportPriority.php          ← Model ranking
│   └── Services/
│       └── AhpService.php               ← Service logic (13 methods)
│
├── database/
│   ├── migrations/
│   │   ├── 2026_04_27_000001_create_ahp_criteria_table.php
│   │   ├── 2026_04_27_000002_create_ahp_pairwise_comparisons_table.php
│   │   ├── 2026_04_27_000003_create_ahp_report_assessments_table.php
│   │   └── 2026_04_27_000004_create_report_priorities_table.php
│   └── seeders/
│       └── AhpSeeder.php                ← Test data seeder
│
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── ahp-dashboard.blade.php      ← Dashboard overview
│       │   ├── ahp-criteria.blade.php       ← Manajemen kriteria
│       │   ├── ahp-pairwise.blade.php       ← Perbandingan berpasangan
│       │   ├── ahp-assessment.blade.php     ← Penilaian laporan
│       │   └── ahp-ranking.blade.php        ← Ranking hasil
│       └── layouts/
│           └── app.blade.php            ← Main layout
│
├── routes/
│   └── web.php                          ← AHP routes (updated)
│
├── QUICK_START.md                       ← Panduan cepat 5 menit
├── AHP_IMPLEMENTATION.md                ← Dokumentasi lengkap
└── AHP_IMPLEMENTATION_SUMMARY.md        ← Ringkasan implementasi
```

---

## 🎓 Cara Kerja AHP

### 1. Inisialisasi Kriteria
Tentukan kriteria apa yang akan dievaluasi:
- **Dampak** - Seberapa besar dampak laporan
- **Urgensi** - Seberapa cepat perlu ditangani
- **Kompleksitas** - Seberapa sulit penyelesaiannya

### 2. Perbandingan Berpasangan
Bandingkan tingkat kepentingan antar kriteria (1-9 scale):
- 1 = Sama penting
- 3 = Sedikit lebih penting
- 5 = Lebih penting
- 7 = Jauh lebih penting
- 9 = Sangat jauh lebih penting

### 3. Hitung Bobot
Sistem menghitung:
- Normalisasi matriks perbandingan
- Eigenvalue (lambda)
- Bobot setiap kriteria
- Consistency Ratio (CR) untuk validasi

### 4. Penilaian Laporan
Untuk setiap laporan, beri skor 1-9 per kriteria:
- 1 = Sangat rendah
- 5 = Sedang
- 9 = Sangat tinggi

### 5. Hitung Prioritas
$$\text{Skor AHP} = \sum_{i=1}^{n} (\text{Score}_i \times \text{Weight}_i)$$

### 6. Ranking
Laporan diurutkan berdasarkan skor (tertinggi = paling urgent).

---

## 🔧 API Service

### AhpService Methods

```php
// Setup
$ahpService->initializeDefaultCriteria();
$ahpService->savePairwiseComparison($c1, $c2, $value);
$result = $ahpService->calculateCriteriaWeights();

// Assessment
$ahpService->saveReportAssessment($reportId, $criteriaId, $score);
$ahpService->calculateReportPriorities();

// Retrieve
$ranking = $ahpService->getReportRanking();
$topReports = $ahpService->getTopPriorityReports(5);
$weights = $ahpService->getCriteriaWeights();

// Reset
$ahpService->resetAllAhpData();
```

Lihat `app/Examples/AhpUsageExample.php` untuk contoh lengkap.

---

## 🌐 Routes

| Method | Route | Deskripsi |
|--------|-------|-----------|
| GET | `/admin/ahp` | Dashboard |
| GET | `/admin/ahp/criteria` | Manajemen kriteria |
| POST | `/admin/ahp/criteria` | Simpan kriteria |
| GET | `/admin/ahp/pairwise` | Perbandingan |
| POST | `/admin/ahp/pairwise` | Simpan perbandingan |
| GET | `/admin/ahp/pairwise/calculate` | Hitung bobot |
| GET | `/admin/ahp/assessment` | Penilaian laporan |
| POST | `/admin/ahp/assessment` | Simpan penilaian |
| GET | `/admin/ahp/assessment/calculate` | Hitung prioritas |
| GET | `/admin/ahp/ranking` | Lihat ranking |
| GET | `/admin/ahp/reset` | Reset AHP |

---

## 💾 Database Schema

### ahp_criteria
```sql
id, name, description, weight, order, is_active, created_at, updated_at
```

### ahp_pairwise_comparisons
```sql
id, criteria_1_id, criteria_2_id, comparison_value, consistency_ratio, created_at, updated_at
```

### ahp_report_assessments
```sql
id, report_id, criteria_id, score, created_at, updated_at
```

### report_priorities
```sql
id, report_id, ahp_score, priority_rank, last_calculated_at, created_at, updated_at
```

---

## ✨ Features

- ✅ **Manajemen Kriteria** - CRUD dengan default initialization
- ✅ **Perbandingan Berpasangan** - Matrix input dengan auto reciprocal
- ✅ **Perhitungan Bobot** - Eigenvalue, eigenvector, consistency checking
- ✅ **Penilaian Laporan** - Modal form dengan validation
- ✅ **Ranking Otomatis** - Sorting berdasarkan skor AHP
- ✅ **Dashboard** - Overview dengan visualisasi
- ✅ **Responsive UI** - Bootstrap 5 dengan mobile support
- ✅ **Validation** - Form validation + business logic validation
- ✅ **Error Handling** - Proper error messages
- ✅ **Documentation** - Lengkap dengan contoh

---

## 🐛 Troubleshooting

### Error: Table doesn't exist
```bash
php artisan migrate
```

### Error: Class not found
```bash
composer dump-autoload
```

### Consistency Ratio > 0.1
Revisi perbandingan berpasangan Anda di `/admin/ahp/pairwise`

### Reset semua data
```bash
/admin/ahp/reset  # atau
php artisan tinker
> DB::table('ahp_criteria')->truncate();
> DB::table('report_priorities')->truncate();
```

---

## 📚 Dokumentasi

| Dokumen | Deskripsi |
|---------|-----------|
| `QUICK_START.md` | Panduan cepat 5 menit |
| `AHP_IMPLEMENTATION.md` | Dokumentasi teknis lengkap |
| `AHP_IMPLEMENTATION_SUMMARY.md` | Ringkasan implementasi |
| `app/Examples/AhpUsageExample.php` | Contoh penggunaan API |

---

## 🎯 Use Cases

### 1. Desa dengan Banyak Laporan
Admin dapat secara objektif menentukan laporan mana yang paling urgent ditangani.

### 2. Sumber Daya Terbatas
Prioritisasi membantu mengalokasikan sumber daya ke laporan yang paling penting.

### 3. Transparansi
Sistem berbasis rumus matematika lebih transparan dan dapat dijelaskan kepada warga.

### 4. Konsistensi
Setiap admin akan menghasilkan keputusan yang sama dengan kriteria yang sama.

---

## 🔒 Security

- ✅ Authentication middleware
- ✅ Role-based access control
- ✅ CSRF protection
- ✅ Input validation
- ✅ SQL injection prevention (Eloquent)

---

## 🚀 Deployment

1. Push code ke production server
2. Run migrations: `php artisan migrate`
3. (Optional) Seed data: `php artisan db:seed --class=AhpSeeder`
4. Set correct file permissions
5. Update `.env` untuk production

---

## 📞 Support

Untuk pertanyaan atau masalah:
1. Check `QUICK_START.md` untuk basic setup
2. Check `AHP_IMPLEMENTATION.md` untuk detailed docs
3. Check `AhpUsageExample.php` untuk API usage

---

## 📄 License

Dikembangkan untuk Aplikasi Desa Mlideg 2026

---

## ✅ Checklist Implementasi

- ✅ Database migrations (4 tabel)
- ✅ Eloquent models (4 model dengan relationships)
- ✅ Service layer (AhpService dengan 13 methods)
- ✅ Controller (AhpController dengan 11 methods)
- ✅ Views (5 halaman + 1 layout)
- ✅ Routes (11 AHP routes)
- ✅ Seeder (untuk test data)
- ✅ Documentation (3 docs + 1 example)
- ✅ Error handling & validation
- ✅ Responsive UI design

---

**Status**: ✅ COMPLETE & READY TO USE

**Last Updated**: 27 April 2026
