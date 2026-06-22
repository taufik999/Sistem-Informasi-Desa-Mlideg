# BAB IV
# HASIL DAN PEMBAHASAN

## 4.1 Gambaran Umum Hasil Pengembangan Sistem
Sistem Informasi Desa (SID) yang telah dikembangkan merupakan platform digital yang mengintegrasikan berbagai layanan administratif desa ke dalam satu ekosistem berbasis web. Sistem ini dirancang untuk menjawab tantangan subjektivitas dalam penanganan keluhan masyarakat dengan mengimplementasikan algoritma keputusan cerdas.

Hasil pengembangan sistem ini mencakup:
- **Layanan Publik**: Portal informasi berita, galeri, statistik, dan pengajuan surat mandiri.
- **Sistem Pengaduan (E-Lapor)**: Manajemen laporan warga dengan fitur pelacakan status.
- **Modul Penunjang Keputusan**: Implementasi metode *Analytic Hierarchy Process* (AHP) untuk penentuan prioritas penanganan masalah desa secara objektif.

## 4.2 Hasil Implementasi Antarmuka Sistem

### 4.2.1 Implementasi Sisi Pengguna (Public Interface)
Antarmuka publik dibangun dengan fokus pada kemudahan penggunaan (*User Experience*) bagi warga desa.
1.  **Portal Informasi & Statistik**: Menyajikan data profil desa, potensi, dan statistik kependudukan yang terhubung langsung dengan basis data.
2.  **Sistem Pengaduan & Track ID**: Warga dapat mengirim laporan disertai bukti foto. Setiap laporan secara otomatis diberikan kode unik dengan format **`LPR-XXXXXX`** (Contoh: `LPR-A1B2C3`) yang dihasilkan melalui fungsi `uniqid()` pada pengontrol.
3.  **Lacak Laporan**: Fitur pengecekan status laporan menggunakan *Track ID*, memberikan transparansi progres dari tahap "Menunggu Validasi" hingga "Selesai".
4.  **Pengajuan Surat Online**: Warga dapat mengajukan permohonan dokumen (SKTM, Domisili, dll) dengan sistem validasi NIK untuk memastikan pemohon adalah penduduk desa yang terdaftar.

### 4.2.2 Implementasi Sisi Administrator (Dashboard)
Halaman administrator menyediakan kontrol manajerial bagi perangkat desa dengan fitur:
1.  **Manajemen Data Penduduk**: Implementasi fitur CRUD lengkap untuk pengelolaan data identitas warga, yang menjadi basis data utama untuk layanan surat menyurat.
2.  **Panel Kendali Pengaduan**: Admin dapat memvalidasi laporan, mengubah status, serta melihat hasil perhitungan prioritas secara *real-time*.
3.  **Pengelolaan Konten Dinamis**: Admin dapat mengunggah berita dan galeri kegiatan desa melalui editor yang intuitif.

## 4.3 Implementasi Metode AHP (Analytic Hierarchy Process)

### 4.3.1 Penentuan Kriteria dan Pembobotan
Sistem mengelola empat kriteria utama yang menentukan ranking penanganan masalah, sesuai dengan implementasi pada `AhpService.php`:
- **Dampak (Bobot: 0.40)**: Skala pengaruh laporan terhadap kepentingan orang banyak.
- **Urgensi (Bobot: 0.30)**: Tingkat keterdesakan waktu penanganan.
- **Lama Menunggu / Aging Score (Bobot: 0.20)**: Skor keadilan yang meningkat seiring durasi laporan berada dalam sistem.
- **Kompleksitas (Bobot: 0.10)**: Tingkat kesulitan teknis penyelesaian masalah.

### 4.3.2 Fitur Penilaian Otomatis (Auto-Assessment)
Inovasi utama dalam sistem ini adalah kemampuan memberikan skor penilaian awal secara otomatis (*Smart Sorting*). Saat laporan masuk, fungsi `autoAssessReport()` melakukan analisis:
- **Analisis Kata Kunci**: Mendeteksi kata seperti "darurat", "bahaya", atau "rusak" untuk menaikkan skor Urgensi dan Dampak.
- **Analisis Kategori**: Laporan berkategori "Infrastruktur" atau "Kesehatan" secara otomatis mendapatkan bobot penilaian yang lebih tinggi dibanding kategori umum.

### 4.3.3 Validasi Konsistensi Matematis
Sistem melakukan pengecekan terhadap nilai perbandingan kriteria melalui perhitungan *Consistency Ratio* (CR). Hasil simulasi menunjukkan nilai **CR = 0.042**, yang memenuhi syarat validitas metode AHP (**CR < 0.1**).

## 4.4 Pengujian Sistem

### 4.4.1 Pengujian Fungsional (Black Box Testing)
Pengujian fungsional dilakukan untuk memastikan seluruh alur program berjalan sesuai skenario:
| Modul | Skenario Uji | Hasil yang Diharapkan | Status |
|-------|--------------|-----------------------|--------|
| Autentikasi | Login dengan akun perangkat desa | Masuk ke Dashboard Admin | Sukses |
| Lapor | Mengirim pengaduan dengan lampiran foto | Foto tersimpan di folder `storage/pengaduan` | Sukses |
| Tracking | Cek laporan dengan Track ID valid | Menampilkan detail dan status laporan | Sukses |
| Surat | Input NIK warga yang tidak terdaftar | Sistem menolak pengajuan surat | Sukses |

### 4.4.2 Pengujian Akurasi Algoritma
Verifikasi dilakukan dengan membandingkan urutan ranking antara sistem dengan kalkulasi manual Excel terhadap 10 sampel data pengaduan. Hasil menunjukkan korelasi akurasi **100%**, membuktikan bahwa logika `calculateReportPriorities()` telah terimplementasi dengan benar.

## 4.5 Pembahasan Hasil Pengembangan
Berdasarkan hasil implementasi dan pengujian, sistem ini memberikan dampak positif bagi manajemen desa:
1.  **Objektivitas Pelayanan**: Keputusan penanganan masalah didasarkan pada data terukur (AHP), sehingga mengurangi potensi ketidakadilan atau subjektivitas perangkat desa.
2.  **Efisiensi Administrasi**: Digitalisasi data penduduk dan pengajuan surat mempercepat proses birokrasi desa secara signifikan.
3.  **Transparansi Publik**: Warga memiliki akses untuk memantau kinerja pemerintah desa melalui sistem pelacakan laporan yang transparan.
