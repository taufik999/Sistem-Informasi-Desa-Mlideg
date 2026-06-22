# Implementasi AHP (Analytic Hierarchy Process) untuk Prioritas Laporan Warga

## 📋 Daftar Isi
- [Pengantar](#pengantar)
- [Struktur Database](#struktur-database)
- [Instalasi](#instalasi)
- [Penggunaan](#penggunaan)
- [Alur Kerja](#alur-kerja)
- [API Service](#api-service)

---

## Pengantar

Implementasi ini menggunakan **Analytic Hierarchy Process (AHP)** untuk menentukan urgensi dan prioritas laporan dari warga secara objektif dan terukur.

### Fitur Utama
- ✅ Manajemen kriteria AHP yang fleksibel
- ✅ Perbandingan berpasangan (Pairwise Comparison) dengan matriks konsistensi
- ✅ Perhitungan bobot kriteria otomatis
- ✅ Penilaian laporan terhadap setiap kriteria
- ✅ Perhitungan skor AHP dan ranking prioritas
- ✅ Visualisasi hasil dengan dashboard interaktif
- ✅ Support untuk Consistency Ratio checking

---

## Struktur Database

### Tabel 1: `ahp_criteria`
Menyimpan daftar kriteria yang digunakan dalam AHP.

```sql
CREATE TABLE ahp_criteria (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,           -- Nama kriteria (Dampak, Urgensi, dll)
    description TEXT,                     -- Penjelasan kriteria
    weight DECIMAL(5,4) DEFAULT 0,        -- Bobot hasil normalisasi (0-1)
    order INT DEFAULT 0,                  -- Urutan tampil
    is_active BOOLEAN DEFAULT true,       -- Status kriteria
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabel 2: `ahp_pairwise_comparisons`
Menyimpan nilai perbandingan berpasangan antar kriteria.

```sql
CREATE TABLE ahp_pairwise_comparisons (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    criteria_1_id BIGINT NOT NULL,        -- ID kriteria pertama
    criteria_2_id BIGINT NOT NULL,        -- ID kriteria kedua
    comparison_value DECIMAL(5,4),        -- Nilai perbandingan (1-9 atau pecahan)
    consistency_ratio DECIMAL(5,4),       -- Rasio konsistensi
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (criteria_1_id) REFERENCES ahp_criteria(id),
    FOREIGN KEY (criteria_2_id) REFERENCES ahp_criteria(id)
);
```

### Tabel 3: `ahp_report_assessments`
Menyimpan penilaian setiap laporan terhadap setiap kriteria.

```sql
CREATE TABLE ahp_report_assessments (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    report_id VARCHAR(255),               -- Track ID laporan
    criteria_id BIGINT NOT NULL,
    score DECIMAL(4,2),                  -- Skor 1-9
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY (report_id, criteria_id),
    FOREIGN KEY (criteria_id) REFERENCES ahp_criteria(id)
);
```

### Tabel 4: `report_priorities`
Menyimpan skor AHP dan ranking prioritas laporan.

```sql
CREATE TABLE report_priorities (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    report_id VARCHAR(255) UNIQUE,        -- Track ID laporan
    ahp_score DECIMAL(5,4),               -- Skor AHP (0-1)
    priority_rank INT,                    -- Ranking (1, 2, 3, dll)
    last_calculated_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## Instalasi

### 1. Jalankan Migrations
```bash
php artisan migrate
```

Atau jika ingin seed data default:
```bash
php artisan db:seed --class=AhpSeeder
```

### 2. Akses AHP Dashboard
Login sebagai admin, kemudian akses:
- **Dashboard**: `/admin/ahp`
- **Manajemen Kriteria**: `/admin/ahp/criteria`
- **Perbandingan Kriteria**: `/admin/ahp/pairwise`
- **Penilaian Laporan**: `/admin/ahp/assessment`
- **Ranking Laporan**: `/admin/ahp/ranking`

---

## Penggunaan

### Step 1: Inisialisasi Kriteria Default
Klik tombol **"Inisialisasi Kriteria Default"** di halaman Manajemen Kriteria.

Ini akan membuat 3 kriteria default:
1. **Dampak** - Seberapa besar dampak laporan terhadap masyarakat
2. **Urgensi** - Seberapa cepat laporan perlu ditangani
3. **Kompleksitas** - Tingkat kesulitan penyelesaian

Atau buat kriteria custom sesuai kebutuhan desa Anda.

### Step 2: Lakukan Perbandingan Berpasangan
Buka halaman **"Perbandingan Kriteria"** dan isi nilai perbandingan:

| Nilai | Arti |
|-------|------|
| 1 | Kedua kriteria sama penting |
| 3 | Kriteria pertama sedikit lebih penting |
| 5 | Kriteria pertama lebih penting |
| 7 | Kriteria pertama jauh lebih penting |
| 9 | Kriteria pertama sangat jauh lebih penting |

**Contoh:**
- Dampak vs Urgensi = 3 (Dampak sedikit lebih penting)
- Dampak vs Kompleksitas = 5 (Dampak lebih penting)
- Urgensi vs Kompleksitas = 2 (Urgensi lebih penting)

### Step 3: Hitung Bobot Kriteria
Setelah mengisi semua perbandingan, klik **"Hitung Bobot Kriteria"**.

Sistem akan:
- Menghitung eigenvalue dan eigenvector
- Menormalisasi matriks perbandingan
- Menghasilkan bobot untuk setiap kriteria
- Mengecek Consistency Ratio (CR harus ≤ 0.1)

**Contoh hasil:**
- Dampak: 67%
- Urgensi: 17%
- Kompleksitas: 16%

### Step 4: Nilai Laporan Warga
Buka halaman **"Penilaian Laporan"** dan untuk setiap laporan:
- Beri skor 1-9 untuk kriteria Dampak
- Beri skor 1-9 untuk kriteria Urgensi
- Beri skor 1-9 untuk kriteria Kompleksitas

**Panduan Skor:**
- 1 = Sangat Rendah
- 3 = Rendah
- 5 = Sedang
- 7 = Tinggi
- 9 = Sangat Tinggi

### Step 5: Hitung Prioritas
Setelah menilai semua laporan, klik **"Hitung Prioritas Laporan"**.

Sistem akan menghitung:
$$\text{Skor AHP} = \sum_{i=1}^{n} (\text{Skor Kriteria}_i \times \text{Bobot Kriteria}_i)$$

### Step 6: Lihat Ranking
Buka halaman **"Ranking Laporan"** untuk melihat urutan prioritas.

---

## Alur Kerja

```
┌─────────────────────────────────────────┐
│  1. Inisialisasi Kriteria               │
│     (Dampak, Urgensi, Kompleksitas)     │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  2. Perbandingan Berpasangan            │
│     Tentukan tingkat kepentingan        │
│     antar kriteria                      │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  3. Hitung Bobot Kriteria               │
│     Bobot = eigenvalue dari matriks     │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  4. Nilai Laporan                       │
│     Score setiap laporan per kriteria   │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  5. Hitung Skor AHP Laporan             │
│     Skor = Σ(Score × Bobot)             │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  6. Ranking & Prioritas                 │
│     Sort by Skor AHP (Descending)       │
└─────────────────────────────────────────┘
```

---

## API Service

### Class: `App\Services\AhpService`

#### Method: `calculateCriteriaWeights()`
Menghitung bobot kriteria dari matriks perbandingan.

```php
use App\Services\AhpService;

$ahpService = new AhpService();
$result = $ahpService->calculateCriteriaWeights();

// Result:
[
    'weights' => [1 => 0.67, 2 => 0.17, 3 => 0.16],
    'lambda' => 3.05,
    'consistency_index' => 0.025,
    'consistency_ratio' => 0.043,
    'is_consistent' => true
]
```

#### Method: `savePairwiseComparison()`
Menyimpan perbandingan berpasangan antara dua kriteria.

```php
$ahpService->savePairwiseComparison(
    criteria1_id: 1,  // Dampak
    criteria2_id: 2,  // Urgensi
    value: 3          // Dampak 3x lebih penting dari Urgensi
);
```

#### Method: `saveReportAssessment()`
Menyimpan penilaian laporan terhadap kriteria.

```php
$ahpService->saveReportAssessment(
    reportId: 'LPR-ABC123',
    criteriaId: 1,  // Dampak
    score: 7        // Score 1-9
);
```

#### Method: `calculateReportPriorities()`
Menghitung skor AHP dan ranking untuk semua laporan.

```php
$reportPriorities = $ahpService->calculateReportPriorities();

// Result: ['LPR-ABC123' => 0.4231, 'LPR-XYZ789' => 0.3821, ...]
```

#### Method: `getReportRanking()`
Mendapatkan laporan terurut berdasarkan prioritas.

```php
$ranking = $ahpService->getReportRanking();

// Result:
[
    [
        'report_id' => 'LPR-ABC123',
        'ahp_score' => 0.4231,
        'priority_rank' => 1
    ],
    [
        'report_id' => 'LPR-XYZ789',
        'ahp_score' => 0.3821,
        'priority_rank' => 2
    ]
]
```

#### Method: `getTopPriorityReports(limit = 5)`
Mendapatkan N laporan dengan prioritas tertinggi.

```php
$topReports = $ahpService->getTopPriorityReports(5);
```

#### Method: `getCriteriaWeights()`
Mendapatkan bobot kriteria yang sudah dihitung.

```php
$weights = $ahpService->getCriteriaWeights();

// Result: ['Dampak' => 0.67, 'Urgensi' => 0.17, 'Kompleksitas' => 0.16]
```

#### Method: `resetAllAhpData()`
Reset semua data AHP (untuk testing atau reset sistem).

```php
$ahpService->resetAllAhpData();
```

#### Method: `initializeDefaultCriteria()`
Membuat kriteria default (Dampak, Urgensi, Kompleksitas).

```php
$ahpService->initializeDefaultCriteria();
```

---

## Controller: `App\Http\Controllers\AhpController`

Semua method controller sudah terintegrasi dengan routes. Lihat file [routes/web.php](routes/web.php) untuk daftar lengkap routes.

### Routes Tersedia:

| Method | Route | Deskripsi |
|--------|-------|-----------|
| GET | `/admin/ahp` | Dashboard AHP |
| GET | `/admin/ahp/criteria` | Manajemen Kriteria |
| POST | `/admin/ahp/criteria` | Simpan Kriteria |
| GET | `/admin/ahp/criteria/{id}/delete` | Hapus Kriteria |
| GET | `/admin/ahp/criteria/init` | Inisialisasi Default |
| GET | `/admin/ahp/pairwise` | Perbandingan Kriteria |
| POST | `/admin/ahp/pairwise` | Simpan Perbandingan |
| GET | `/admin/ahp/pairwise/calculate` | Hitung Bobot |
| GET | `/admin/ahp/assessment` | Penilaian Laporan |
| POST | `/admin/ahp/assessment` | Simpan Penilaian |
| GET | `/admin/ahp/assessment/calculate` | Hitung Prioritas |
| GET | `/admin/ahp/ranking` | Lihat Ranking |
| GET | `/admin/ahp/reset` | Reset AHP (Super Admin) |

---

## Catatan Penting

### Konsistensi Penilaian
AHP mengharuskan penilaian konsisten. Sistem akan mengecek **Consistency Ratio (CR)**:
- **CR ≤ 0.1**: Penilaian konsisten ✅
- **CR > 0.1**: Penilaian tidak konsisten, perlu direvisi ⚠️

Jika CR > 0.1, silakan revisi perbandingan berpasangan Anda.

### Sebelum Menilai Laporan
Pastikan:
1. ✅ Kriteria sudah dibuat
2. ✅ Perbandingan berpasangan sudah diisi
3. ✅ Bobot kriteria sudah dihitung
4. ✅ Consistency Ratio valid (≤ 0.1)

### Untuk Testing
Akses dengan login:
- **Username**: `superadmin`
- **Password**: `admin123`

---

## Referensi
- Saaty, T. L. (1980). *The Analytic Hierarchy Process*. McGraw-Hill.
- Ramanathan, R. (2001). A note on the use of the analytic hierarchy process for environmental impact assessment.

---

## Support
Untuk pertanyaan atau troubleshooting, hubungi tim pengembang.
