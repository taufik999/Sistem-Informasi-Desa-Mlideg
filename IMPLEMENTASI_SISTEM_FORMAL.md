# IMPLEMENTASI SISTEM DAN PEMBAHASAN (FORMAL)

## 4.1 Implementasi Arsitektur Sistem
Sistem dibangun menggunakan paradigma **Object-Oriented Programming (OOP)** dengan framework Laravel 11. Arsitektur yang digunakan adalah **Model-View-Controller (MVC)** untuk memastikan modularitas dan kemudahan pemeliharaan kode.

### 4.1.1 Lingkungan Pengembangan
Pengembangan sistem dilakukan pada lingkungan dengan spesifikasi berikut:
- **Web Server**: Apache 2.4
- **Bahasa Pemrograman**: PHP 8.2.12
- **Database Management System**: MySQL 8.0
- **Framework**: Laravel 11.0
- **Frontend Tools**: Bootstrap 5.3, Font Awesome 6.0, JQuery 3.7

### 4.1.2 Struktur Data (Database)
Implementasi basis data dilakukan melalui fitur *Migrations* pada Laravel. Berikut adalah tabel-tabel utama yang berhasil diimplementasikan:
1.  **Tabel `penduduks`**: Menyimpan metadata warga (NIK, Nama, Alamat, dll).
2.  **Tabel `pengaduans`**: Menyimpan data laporan masuk beserta `track_id` dan `status`.
3.  **Tabel `ahp_criteria`**: Menyimpan kriteria penilaian (Dampak, Urgensi, Kompleksitas).
4.  **Tabel `ahp_pairwise_comparisons`**: Menyimpan nilai perbandingan antar kriteria.
5.  **Tabel `report_priorities`**: Menyimpan hasil akhir perhitungan skor dan ranking.

---

## 4.2 Implementasi Algoritma AHP
Algoritma AHP diimplementasikan dalam sebuah *Service Class* bernama `AhpService.php`. Hal ini bertujuan agar logika perhitungan terpisah dari logika navigasi (Controller).

### 4.2.1 Perhitungan Bobot Kriteria
Langkah-langkah yang diimplementasikan dalam kode program meliputi:
1.  **Penyusunan Matriks**: Data diambil dari tabel `ahp_pairwise_comparisons` dan disusun ke dalam array 2D.
2.  **Normalisasi**: Setiap elemen matriks dibagi dengan total kolomnya.
3.  **Eigenvector**: Menghitung rata-rata baris dari matriks ternormalisasi untuk mendapatkan bobot kriteria.

### 4.2.2 Uji Konsistensi (Consistency Ratio)
Sistem melakukan pengecekan otomatis dengan rumus:
- **CI (Consistency Index)**: $(\lambda_{max} - n) / (n - 1)$
- **CR (Consistency Ratio)**: $CI / RI$ (Random Index)
Jika nilai **CR > 0.1**, sistem akan menampilkan peringatan kepada admin untuk meninjau kembali nilai perbandingan karena dianggap tidak konsisten.

---

## 4.3 Implementasi Fungsi Utama

### 4.3.1 Alur Layanan Pengaduan dan Prioritas
1.  **Submit Laporan**: Warga mengisi data pada `lapor.blade.php`. Sistem memvalidasi input dan menyimpan file foto jika ada.
2.  **Penilaian (Assessment)**: Admin memberikan skor 1-9 pada laporan tersebut terhadap kriteria AHP melalui antarmuka admin.
3.  **Kalkulasi**: Saat admin menekan tombol "Hitung Prioritas", sistem menjalankan `calculatePriorities()` yang mengalikan skor penilaian dengan bobot kriteria yang telah divalidasi konsistensinya.
4.  **Output Ranking**: Hasil diurutkan berdasarkan skor tertinggi ke terendah secara otomatis.

### 4.3.2 Alur Layanan Surat Online
1.  **Validasi NIK**: Sistem mencocokkan NIK yang diinput warga dengan tabel `penduduks`.
2.  **Verifikasi Status**: Hanya warga dengan status "Aktif" yang dapat mengajukan surat.
3.  **Manajemen Admin**: Admin menerima notifikasi pada dashboard mengenai adanya permohonan surat baru yang perlu dicetak atau divalidasi.

---

## 4.4 Pembahasan dan Analisis Hasil
Berdasarkan hasil implementasi, sistem telah memenuhi kebutuhan fungsional desa dengan keunggulan sebagai berikut:

1.  **Keakuratan Data**: Penggunaan database relasional mencegah adanya redundansi data penduduk, terutama pada validasi NIK.
2.  **Objektivitas Pelayanan**: Metode AHP berhasil menghilangkan faktor subjektivitas perangkat desa. Sebagai contoh, laporan mengenai kerusakan jembatan desa secara otomatis mendapat skor lebih tinggi daripada laporan masalah individu karena bobot kriteria "Dampak" yang besar.
3.  **Transparansi Publik**: Fitur tracking laporan memberikan kepastian hukum dan waktu kepada warga mengenai proses pengaduan mereka.

---

## 4.5 Hasil Pengujian (Summary)
Pengujian dilakukan dengan dua metode:
- **Fungsional**: Menggunakan metode *Black Box* untuk memastikan seluruh alur (flow) program berjalan dari awal hingga akhir.
- **Validasi Algoritma**: Memastikan output sistem `0.539` untuk bobot kriteria Dampak (misalnya) sama persis dengan perhitungan manual di kertas kerja.
