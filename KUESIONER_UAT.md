# Kuesioner User Acceptance Testing (UAT)
## Sistem Informasi Desa (SID) Terintegrasi SPK-AHP

Kuesioner Uji Penerimaan Pengguna (UAT) ini dirancang untuk memvalidasi fungsionalitas sistem langsung kepada pengguna nyata. Pengujian dibagi menjadi dua kelompok responden utama, yaitu **Masyarakat (Warga)** dan **Perangkat Desa (Administrator)**.

Pengujian ini menggunakan metode evaluasi kesesuaian skenario. Responden diminta untuk memberikan tanda centang pada opsi "Diterima" apabila fitur berfungsi dengan baik, atau "Ditolak" apabila terjadi kendala/error.

---

### Bagian 1: Form UAT untuk Aktor Masyarakat (Warga)

**Nama Responden:** _______________________  
**NIK / Usia:** _______________________  
**Tanggal Pengujian:** _______________________  

*Silakan berikan tanda centang (✓) pada kolom yang sesuai dengan hasil pengujian Anda terhadap sistem (website publik).*

| No | Skenario Pengujian / Fitur yang Diuji | Diterima (Berhasil) | Ditolak (Gagal) | Catatan / Masukan |
|:---:|:---|:---:|:---:|:---|
| 1 | **Mengakses Halaman Beranda**: Berhasil melihat profil desa, berita, dan grafik statistik penduduk dengan tampilan yang rapi. | [ ] | [ ] | |
| 2 | **Membuat Laporan (E-Lapor)**: Mengisi form pengaduan/keluhan dengan lengkap beserta lampiran foto tanpa adanya error. | [ ] | [ ] | |
| 3 | **Penerimaan Track ID Laporan**: Mendapatkan kode unik (Track ID) dari sistem setelah sukses menekan tombol kirim laporan. | [ ] | [ ] | |
| 4 | **Melacak Laporan (Cek Status)**: Memasukkan Track ID pada form pelacakan dan berhasil melihat riwayat/status laporan terkini. | [ ] | [ ] | |
| 5 | **Pengajuan E-Surat (Valid)**: Mengajukan permohonan surat administrasi dengan memasukkan NIK yang benar/terdaftar. | [ ] | [ ] | |
| 6 | **Validasi NIK (Tidak Valid)**: Mencoba mengisi form surat menggunakan NIK acak/fiktif dan sistem langsung menolaknya. | [ ] | [ ] | |
| 7 | **Pengalaman *Mobile-Responsive***: Mencoba membuka web menggunakan layar *smartphone*, navigasi mudah digunakan dan tidak terpotong. | [ ] | [ ] | |

**Kesan & Pesan dari Warga terhadap Sistem:**  
_________________________________________________________________________________  
_________________________________________________________________________________  

---

### Bagian 2: Form UAT untuk Aktor Perangkat Desa (Administrator)

**Nama Responden:** _______________________  
**Jabatan di Desa:** _______________________  
**Tanggal Pengujian:** _______________________  

*Silakan berikan tanda centang (✓) pada kolom yang sesuai dengan hasil pengujian Anda pada halaman *dashboard* admin.*

| No | Skenario Pengujian / Fitur yang Diuji | Diterima (Berhasil) | Ditolak (Gagal) | Catatan / Masukan |
|:---:|:---|:---:|:---:|:---|
| 1 | **Akses Otentikasi (Login)**: Berhasil masuk ke dalam *dashboard* admin menggunakan kombinasi kredensial (username/password) yang benar. | [ ] | [ ] | |
| 2 | **Manajemen Data Penduduk**: Berhasil menambah penduduk baru, mengedit data eksisting, dan fungsi pencarian warga berjalan lancar. | [ ] | [ ] | |
| 3 | **Verifikasi Pengajuan Surat**: Melihat permohonan masuk, memberikan catatan balasan, serta mengubah status persetujuan surat. | [ ] | [ ] | |
| 4 | **Verifikasi Laporan E-Lapor**: Menerima laporan dari warga, mengecek validasi bukti foto, dan memperbarui status pelacakan laporan. | [ ] | [ ] | |
| 5 | **Input Matriks Perbandingan AHP**: Mengisi nilai tingkat kepentingan antar kriteria keluhan menggunakan rentang skala 1-9 (Saaty). | [ ] | [ ] | |
| 6 | **Keamanan Logika (Consistency Ratio)**: Memastikan sistem menolak pembobotan matriks saat Anda sengaja memasukkan angka perbandingan yang asal/tidak logis (CR > 10%). | [ ] | [ ] | |
| 7 | **Skoring Kualitas Laporan (*Assessment*)**: Memberikan nilai terhadap sebuah keluhan (misal: skor Dampak, skor Urgensi) melalui sistem. | [ ] | [ ] | |
| 8 | **Rekomendasi SPK (Prioritas)**: Melihat sistem mengurutkan ranking laporan secara otomatis mana yang harus dikerjakan perangkat desa hari ini. | [ ] | [ ] | |
| 9 | **Manajemen Konten (CMS)**: Berhasil menambahkan tulisan berita, aktivitas kegiatan, atau mengelola galeri foto di halaman beranda. | [ ] | [ ] | |

**Kesan & Pesan dari Aparatur Desa terhadap Sistem:**  
_________________________________________________________________________________  
_________________________________________________________________________________  

---
**Pernyataan Validasi,**  
Dengan ini saya menyatakan bahwa telah menguji fitur-fitur di atas sesuai dengan kondisi sebenarnya.

*(Tanda Tangan)*  


**___________________________**  
*(Nama Terang Responden)*
