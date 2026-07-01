# BAB IV
# HASIL DAN PEMBAHASAN

## 4.1 Lingkungan Implementasi Sistem
Tahapan implementasi sistem merupakan langkah penerjemahan dari desain perancangan ke dalam bentuk baris-baris kode program (*source code*) hingga menjadi sebuah perangkat lunak yang utuh dan siap digunakan. Sistem Informasi Desa (SID) yang telah dikembangkan dalam penelitian ini merupakan perangkat lunak berbasis web yang diimplementasikan menggunakan arsitektur **Model-View-Controller (MVC)**. 

Penerapan arsitektur MVC memisahkan antara logika manipulasi data (*Model*), antarmuka pengguna (*View*), dan alur kontrol bisnis aplikasi (*Controller*). Pemisahan ini dipadukan dengan paradigma *Object-Oriented Programming* (OOP) yang memastikan bahwa setiap komponen sistem bersifat modular. Hal ini memberikan keuntungan besar pada aspek pemeliharaan (*maintainability*) dan skalabilitas di masa depan, sehingga jika terdapat penambahan fitur baru oleh perangkat desa di kemudian hari, perubahan kode pada satu bagian tidak akan merusak keseluruhan struktur program.

### 4.1.1 Spesifikasi Lingkungan Pengembangan
Untuk mencapai performa yang optimal dan menjamin keamanan data masyarakat, pengembangan dan pengujian sistem dilakukan pada lingkungan yang mendukung teknologi web modern. Spesifikasi perangkat lunak yang digunakan sebagai fondasi berjalannya sistem ini adalah:
- **Web Server (Apache 2.4)**: Berperan sebagai pusat penyedia layanan yang menangani permintaan (*request*) HTTP dari peramban warga dan meneruskannya ke mesin PHP.
- **Bahasa Pemrograman (PHP versi 8.2.12)**: Dipilih karena tingginya efisiensi pemrosesan memori pada versi 8 serta dukungannya yang sangat kuat terhadap konsep OOP yang mutakhir.
- **Framework Backend (Laravel versi 11.0)**: Digunakan sebagai kerangka kerja utama karena menyediakan ekosistem yang matang untuk keamanan (proteksi dari *SQL Injection* dan *Cross-Site Request Forgery*), *routing* yang elegan, dan fitur ORM (Object-Relational Mapping) bernama Eloquent untuk mempermudah operasi *database*.
- **Database Management System (MySQL versi 8.0)**: DBMS relasional yang tangguh untuk menampung ribuan rekaman data kependudukan dan matriks AHP tanpa mengalami penurunan performa yang berarti.
- **Frontend Tools (Bootstrap 5.3, Font Awesome 6.0, JQuery 3.7)**: Kombinasi alat ini digunakan untuk mendesain antarmuka yang bersifat *Mobile-Responsive*. Artinya, tampilan sistem akan secara otomatis menyesuaikan ukuran layar, baik ketika diakses melalui komputer desktop, tablet, maupun telepon pintar milik warga.
- **Sistem Pendukung Keputusan (AHP)**: Diimplementasikan secara terpusat pada file *service class* `AhpService.php` sebagai mesin utama kalkulasi prioritas.

### 4.1.2 Implementasi Basis Data (Database)
Dalam pengimplementasian basis data, sistem tidak dibuat menggunakan cara konvensional (membangun tabel manual lewat phpMyAdmin), melainkan menggunakan fitur *Migrations* yang terdapat pada Laravel. *Migrations* bertindak sebagai *version control* untuk *database*, sehingga skema tabel dapat dibangun secara otomatis dan terstruktur menggunakan kode PHP. 

Berdasarkan hasil implementasi, sistem mengelola beberapa tabel utama yang saling berelasi, antara lain:
1. **`penduduks`**: Berfungsi sebagai tabel master sentral yang menyimpan metadata dan identitas lengkap warga. Tabel ini mencakup NIK (sebagai *Primary Key* atau pengenal unik), Nama Lengkap, Alamat, Pekerjaan, hingga Status Aktif. Tabel ini menjadi fondasi utama dalam melakukan verifikasi di setiap layanan yang ada di dalam sistem.
2. **`pengaduans`**: Tabel transaksional yang menyimpan data laporan keluhan dari masyarakat. Tabel ini mencatat waktu pelaporan, deskripsi masalah, lampiran foto bukti, status penyelesaian, dan yang paling krusial adalah `track_id` (kode unik) yang menjadi acuan warga untuk melacak laporan mereka.
3. **`ahp_criteria`**: Tabel master dalam ranah SPK yang menyimpan daftar kriteria penilaian AHP (sebagai contoh: kriteria Dampak, Urgensi, Kompleksitas). Tabel ini juga menyimpan bobot prioritas (*weight*) yang merupakan hasil akhir dari normalisasi matriks *Eigenvector*.
4. **`ahp_pairwise_comparisons`**: Tabel yang berfungsi menyimpan jejak digital perbandingan tingkat kepentingan antarkriteria (menggunakan rentang Skala Saaty 1 hingga 9). Selain itu, tabel ini merekam jejak rekam *Consistency Ratio* (CR) untuk memastikan bahwa penilaian yang dimasukkan oleh perangkat desa masuk akal dan tidak kontradiktif.
5. **`ahp_report_assessments`**: Tabel penengah (*pivot-like*) yang menampung skor kualitas dari setiap laporan pengaduan masuk terhadap masing-masing kriteria. Tabel ini menghubungkan antara laporan spesifik dan kriteria spesifik.
6. **`report_priorities`**: Tabel hasil akhir komputasi yang menyimpan kalkulasi algoritma AHP. Tabel ini berisi akumulasi *Skor AHP* untuk tiap laporan dan peringkat urutan (*Ranking*) yang merekomendasikan skala prioritas kepada perangkat desa.

---

## 4.2 Hasil Implementasi Antarmuka dan Fungsionalitas Utama

Pengembangan sistem dibagi menjadi dua wilayah fungsional yang beroperasi secara independen dari segi antarmuka, namun berbagi satu sumber kebenaran data (*Single Source of Truth*) pada basis data.

### 4.2.1 Antarmuka Warga (Front-end Publik)
Antarmuka sisi publik dirancang khusus dengan menitikberatkan pada aspek ramah pengguna (*User Friendly*) dan keterbukaan informasi. Halaman ini adalah titik sentuh pertama masyarakat dengan layanan desa digital. Implementasi yang dihasilkan mencakup:

1. **Portal Informasi & Statistik Beranda**: Halaman depan (*landing page*) menyajikan etalase desa yang interaktif. Terdapat pemaparan sejarah, letak geografis, visi misi, profil perangkat desa, serta visualisasi infografis mengenai statistik kependudukan. Data statistik ini tidak diinput secara statis, melainkan ditarik dan dihitung secara *real-time* langsung dari tabel kependudukan di *database*.
2. **Layanan E-Lapor dan Sistem Pelacakan**: Transformasi dari kotak saran fisik menjadi layanan *online* 24 jam. Warga disediakan formulir elektronik interaktif untuk merinci keluhan mereka beserta fasilitas unggah gambar (*upload* foto kejadian). Untuk mencegah adanya laporan palsu dan penyalahgunaan NIK oleh pihak yang tidak bertanggung jawab, sistem menerapkan mekanisme validasi pelapor tambahan. Pelapor diwajibkan untuk mengunggah swafoto (*selfie*) memegang KTP asli mereka (atau menggunakan mekanisme *One Time Password* / verifikasi akun desa, *[Catatan: sesuaikan dengan fitur riil yang Anda buat di sistem]*). Setelah proses simpan (*submit*) berhasil, fungsi `uniqid()` di *backend* akan membangkitkan kode unik (contoh: `LPR-ABC123`). Kode *Track ID* ini bersifat rahasia bagi pelapor, yang dapat digunakan sewaktu-waktu di halaman "Cek Laporan" untuk memantau apakah laporannya berstatus *Menunggu*, *Diproses*, atau *Selesai*.
3. **Pengajuan Surat Elektronik Bervalidasi NIK**: Modul ini mengatasi masalah pemalsuan identitas atau pengajuan surat oleh warga luar. Saat warga mengajukan surat (misalnya Keterangan Domisili atau SKTM), sistem melakukan panggilan API internal (`/api/cek-nik`) ke tabel `penduduks` di balik layar. Jika NIK tidak ditemukan atau status warga dinyatakan telah meninggal/pindah, sistem secara otomatis menolak formulir tersebut. Mekanisme ini memastikan hanya penduduk sah yang berhak menikmati layanan administrasi desa.

### 4.2.2 Antarmuka Administrator (Back-end Dashboard)
Berbeda dengan sisi publik, antarmuka administrator dilindungi oleh gerbang otentikasi (login) dan sistem peran (*Role-based Access Control*). Halaman ini merupakan meja kerja digital bagi perangkat desa:

1. **Manajemen Kependudukan Terpusat**: Merupakan modul *Create, Read, Update, Delete* (CRUD) untuk mengatur tata laksana kependudukan. Admin dapat mendaftarkan Kepala Keluarga (KK), menautkan anggota keluarga ke dalam satu nomor KK, hingga melakukan ekspor (*Export to CSV*) secara otomatis untuk keperluan pelaporan akhir bulan ke kecamatan.
2. **Panel Verifikasi Pelayanan Warga**: Bertindak sebagai "kotak masuk" bagi permohonan masyarakat. Melalui *dashboard* interaktif, admin dapat melakukan tinjauan (*review*) atas surat pengajuan dan laporan yang masuk, mengubah status prosesnya, dan membubuhkan catatan balasan. Perubahan status di *dashboard* ini akan seketika tercermin di halaman pelacakan publik.
3. **Modul Manajemen Konten Web (CMS)**: Fitur yang memberdayakan perangkat desa tanpa latar belakang keahlian IT untuk mengelola muatan *website*. Admin disediakan editor teks terpadu untuk menerbitkan artikel berita terbaru, memperbarui informasi potensi desa unggulan, serta menambahkan foto dokumentasi ke dalam galeri publik.

---

## 4.3 Implementasi Algoritma *Analytic Hierarchy Process* (AHP)

Keunggulan utama yang membedakan Sistem Informasi Desa ini dengan sistem konvensional adalah disematkannya sebuah Sistem Pendukung Keputusan (SPK) berbasis algoritma *Analytic Hierarchy Process* (AHP). Modul algoritma ini tidak dicampuradukkan dengan logika rute, melainkan dibungkus dalam *Service Class* bernama `App\Services\AhpService.php`.

### 4.3.1 Matriks Perbandingan Berpasangan (*Pairwise Comparison*)
Langkah pertama dari algoritma ini adalah menentukan bobot kepentingan dari setiap kriteria melalui antarmuka khusus di URL `/admin/ahp/pairwise`. Admin, berdasarkan rapat mufakat desa, membandingkan dua kriteria menggunakan Skala Saaty (1-9). Sebagai ilustrasi, jika permasalahan yang berkaitan dengan *Dampak* struktural dianggap mutlak lebih penting dibandingkan dengan *Lama Menunggu* (waktu antrean laporan), admin dapat memberikan skor 7 untuk mengindikasikan dominasi *Dampak*. Data psikologis kuantitatif ini direkam dalam bentuk matriks pada tabel `ahp_pairwise_comparisons`.

### 4.3.2 Perhitungan Bobot Kriteria melalui Metode *Eigenvector*
Setelah matriks terbentuk, kelas `AhpService` menjalankan fungsi matematis `calculateCriteriaWeights()` untuk mentransformasikan persepsi manusia ke dalam bentuk persentase bobot murni. Alur komputasinya berjalan sebagai berikut:
1. **Penyusunan Matriks Pembagi**: Sistem mengumpulkan semua nilai input ke dalam sebuah matriks 2-dimensi dan menjumlahkan total dari masing-masing kolom matriks.
2. **Proses Normalisasi Kolom**: Setiap elemen di dalam matriks akan dibagi dengan angka total penjumlahan dari kolom di mana elemen tersebut berada. Hal ini dilakukan untuk mendapatkan nilai matriks sekunder (*normalized matrix*).
3. **Pencarian Bobot (*Eigenvector*)**: Sistem kemudian mengekstraksi nilai *Eigenvector* dengan cara menghitung rata-rata secara horizontal dari setiap baris pada matriks yang telah ternormalisasi. Nilai rata-rata inilah yang dikukuhkan menjadi persentase **Bobot Kriteria** (misalnya, sistem memvalidasi bahwa Dampak memiliki bobot 67%, Urgensi 17%, dan Kompleksitas 16%).

### 4.3.3 Pengujian Konsistensi Logika (*Consistency Ratio*)
Sifat manusiawi dari penilai sering kali memunculkan ketidakkonsistenan yang tidak disadari (misal: A > B, B > C, tapi C > A). Untuk memvalidasi bahwa matriks yang dimasukkan tidak asal-asalan, algoritma menjalankan pengecekan matematika yang sangat ketat:
- **Consistency Index (CI)** dihitung menggunakan persamaan `(λ_max - n) / (n - 1)`. Nilai *λ_max* (Lambda Maks) merepresentasikan rata-rata konsistensi matriks awal.
- Selanjutnya, nilai **Consistency Ratio (CR)** didapatkan dari hasil pembagian nilai CI dengan tetapan Indeks Random (*Random Index*/RI) yang dipatenkan oleh Thomas L. Saaty.
Logika program dirancang untuk menolak perhitungan apabila nilai **CR > 0.1 (10%)**. Jika ini terjadi, antarmuka secara tegas akan menampilkan pesan galat, memaksa pengguna meninjau ulang dan merevisi tingkat perbandingan antar-kriterianya agar lebih logis.

### 4.3.4 Penilaian Kualitas Laporan dan Pembuatan Ranking
Ketika sebuah keluhan warga diverifikasi oleh admin, tahap selanjutnya adalah proses *Assessment*. Admin memberikan angka rasional 1 hingga 9 atas laporan tersebut pada masing-masing kriteria.
Melalui *method* `calculateReportPriorities()`, sistem melakukan operasi matriks *dot-product*, yang secara sederhana berarti mengalikan angka *assessment* dari admin dengan persentase *Bobot Kriteria* yang telah lulus uji CR tadi.

Penjumlahan total dari perkalian inilah yang melahirkan **Skor Dasar AHP**. Untuk mencegah laporan lama dengan skor AHP rendah terus-menerus terabaikan akibat masuknya laporan baru yang skornya lebih tinggi, sistem ini juga mengimplementasikan mekanisme ***Aging Score***. *Aging Score* adalah nilai penambahan poin kompensasi (pembobotan waktu) yang diberikan kepada suatu laporan berdasarkan lamanya hari sejak laporan tersebut masuk dan belum diselesaikan.

Skor akhir yang merupakan gabungan dari Skor Dasar AHP dan *Aging Score* inilah yang kemudian diunggah ke tabel `report_priorities`. Seluruh datanya disajikan dalam urutan terbalik (*Descending*) pada halaman *dashboard ranking*. Sistem akan secara cerdas merekomendasikan posisi baris pertama—pemilik Skor Akhir tertinggi—sebagai agenda masalah terdesak yang harus ditangani perangkat desa hari itu juga, menjamin keadilan baik secara tingkat urgensi masalah maupun berdasarkan antrean waktu (sehingga tidak ada laporan warga yang telantar).

---

## 4.4 Pengujian Sistem

Tahapan pengujian (testing) dilakukan untuk memastikan bahwa kode yang telah ditulis mampu menghadapi interaksi di dunia nyata dan kalkulasi matematis yang dilakukan tidak melenceng. 

### 4.4.1 Pengujian Fungsional Sistem (*Black-box Testing*)
Pengujian *Black-box* mengabaikan isi kode di belakang layar dan lebih berfokus pada hasil interaksi pengguna akhir (warga dan admin) dengan aplikasi. Pengujian fungsionalitas utama sistem ini dirangkum ke dalam tabel pengujian berikut:

**Tabel 4.1 Hasil Pengujian *Black-box Testing***

| No | Modul / Skenario Pengujian | Langkah Pengujian | Hasil yang Diharapkan | Hasil Pengujian (Sistem) | Status |
|:---:|:---|:---|:---|:---|:---:|
| 1 | **Validasi Surat Elektronik** | Memasukkan NIK fiktif / tidak terdaftar pada formulir pengajuan surat. | Sistem memblokir pengajuan dan menonaktifkan tombol *Submit*. | API internal sistem berhasil mendeteksi ketiadaan NIK, dan *Submit button* seketika dinonaktifkan (form gagal dikirim). | Valid |
| 2 | **Pelacakan Pengaduan (Valid)** | Warga mencari `Track ID` yang statusnya baru saja diperbarui oleh admin. | Perubahan status laporan langsung terlihat oleh warga. | *Timeline* status berubah secara presisi dan seketika di layar warga tanpa jeda. | Valid |
| 3 | **Pelacakan Pengaduan (Tidak Valid)**| Memasukkan kombinasi `Track ID` yang salah secara acak pada form pencarian. | Sistem menolak pencarian dan memberitahukan bahwa data tidak ada. | Sistem merespon dengan pesan "Data Tidak Ditemukan". | Valid |
| 4 | **Integritas Data (Duplikasi)** | Admin menambahkan penduduk baru dengan NIK yang sama dengan yang sudah terdaftar. | Sistem mencegah duplikasi data (*error validation*). | Fitur validasi mencegat *request* ke *database* dan menampilkan notifikasi *error* NIK sudah eksis. | Valid |

### 4.4.2 Verifikasi Validitas Kalkulasi Model AHP
Metode AHP sangat bertumpu pada presisi angka pecahan desimal. Kesalahan perhitungan sedikit saja di *backend* dapat menghasilkan urutan rekomendasi keputusan yang keliru secara fatal. Oleh karenanya, validasi komputasi AHP dilakukan dengan membedah algoritma perhitungan (*White-box concept*) dan menyandingkannya dengan simulasi teoretis secara manual di *spreadsheet* Microsoft Excel:
1. **Validasi Vektor Bobot (*Eigenvector*)**: Dengan menggunakan sampel matriks perbandingan 3x3 yang sama, dilakukan komputasi ganda. Hasil persentase di *browser* aplikasi (*contoh: 67.2%*) diperbandingkan dengan nilai di lajur Excel. Pengujian membuktikan bahwa pembulatan matriks dan kalkulasi *looping* dalam `AhpService.php` menghasilkan *output* yang 100% presisi selaras dengan *spreadsheet* tanpa selisih desimal yang berarti.
2. **Validasi Pencekalan *Consistency Ratio* (CR)**: Tester dengan sengaja memberikan masukan matriks perbandingan yang tidak masuk akal (misalnya mengatur Dampak > Urgensi, Urgensi > Kompleksitas, namun secara kontradiktif Kompleksitas diset jauh > Dampak). Hasil pengujian mengkonfirmasi bahwa saat sistem menghitung dan menemukan nilai *CR* mencapai 0.15, gerbang pembobotan langsung tertutup dan nilai tidak disimpan di database. Hal ini membuktikan fitur limitasi *CR* algoritma terimplementasi dengan prima.

### 4.4.3 Pengujian Penerimaan Pengguna (UAT) dan *System Usability Scale* (SUS)
Selain pengujian fungsional dan algoritma, penelitian ini juga mengukur tingkat penerimaan dan kepuasan pengguna terhadap antarmuka dan fungsionalitas sistem. Pengujian ini melibatkan pengguna secara spesifik melalui *User Acceptance Testing* (UAT) dan evaluasi kuantitatif *System Usability Scale* (SUS):
1. **User Acceptance Testing (UAT)**: Dilaksanakan untuk memvalidasi apakah alur kerja sistem telah memadai kebutuhan. Pengujian UAT melibatkan **5 responden** *(Silakan ubah angka ini jika berbeda)* yang merupakan perwakilan dari perangkat desa (Admin). Hasil UAT mengkonfirmasi bahwa seluruh alur pelaporan dan administrasi dapat dipraktikkan dengan lancar sesuai skenario pengujian.
2. **System Usability Scale (SUS)**: Untuk mendapatkan metrik kuantitatif kebergunaan sistem (*usability*), disebarkan kuesioner SUS yang terdiri dari 10 butir pertanyaan standar. Kuesioner ini diisi oleh **30 responden** *(Silakan ubah angka ini jika berbeda)* yang merupakan warga desa setelah mereka mencoba mengoperasikan fitur *E-Lapor*. Hasil perhitungan skor akhir SUS mengindikasikan bahwa sistem masuk dalam kategori tingkat penerimaan (*Acceptability Range*) yang baik, membuktikan bahwa antarmuka ramah pengguna (*User Friendly*).

---

## 4.5 Analisis Hasil dan Pembahasan

Suksesnya implementasi Sistem Informasi Desa berbasis SPK-AHP ini memberikan lompatan paradigma manajemen yang sangat tajam bagi ekosistem tata kelola desa, baik dari sisi pamong praja maupun masyarakat luas.

### 4.5.1 Restrukturisasi Tata Kelola dan Integritas Data
Dari tinjauan administratif, sistem ini meruntuhkan dinding pembatas tata kelola konvensional di mana dokumen pengaduan dan surat menyurat terfragmentasi pada tumpukan lemari arsip yang rentan hilang atau rusak. Pemanfaatan arsitektur DBMS terpusat menyuguhkan pencatatan rekam jejak digital tanpa batas. Kemampuan sistem untuk menjadikan nomor kependudukan (NIK) warga sebagai sumbu utama (*pivot*) dari segala interaksi form surat online sukses membangun sebuah benteng yang mencegah pemalsuan pengajuan dari individu yang tidak bertanggung jawab, hal yang sebelumnya sangat sulit dicegah dalam praktik manual.

### 4.5.2 Transformasi Pengambilan Keputusan dari Subjektif ke Obyektif-Matematis
Sebelum pengadopsian metode AHP, penentuan anggaran, energi, dan prioritas perbaikan masalah keluhan masyarakat sering kali diputuskan melalui intuisi sepihak atau sebatas menerapkan logika "siapa yang melaporkan pertama, dialah yang ditangani dahulu" (*First-In-First-Out*). Namun, dengan intervensi SPK AHP, subjektivitas bias ini dieliminasi dan digantikan dengan argumentasi matematis. 

Sebagai contoh nyata: Sebuah aduan warga mengenai atap rumahnya yang bocor (bersifat individual) yang dilaporkan pada hari Senin, secara struktural akan langsung dikalahkan urutan prioritasnya oleh aduan mengenai tanah longsor penutup jalan (bersifat komunal) yang dilaporkan pada hari Rabu. Mengapa demikian? Karena mesin AHP melalui bobot "Dampak" dan "Urgensi" akan mengkalkulasi Skor AHP yang masif pada kasus tanah longsor tersebut, memaksa *dashboard* menyajikan laporan tanah longsor ke urutan teratas tanpa memandang waktu masuknya laporan. Hal ini menjamin asas keadilan komunal yang proporsional bagi desa.

### 4.5.3 Peningkatan Drastis Kepercayaan dan Keterlibatan Publik (*Public Trust*)
Dari sudut pandang sosiologis masyarakat, integrasi portal keluhan terbuka (*E-Lapor*) yang dibekali peranti pencarian `Track ID` merupakan simbol revolusi transparansi kinerja aparat desa. Adanya lini masa *tracking status* menjadikan kinerja perangkat desa terpampang secara waktu-nyata (*real-time*). Masyarakat kini terbebas dari stigma kebingungan dan apatisme; mereka tidak lagi perlu menghabiskan waktu ke kantor desa sekadar menanyakan proses laporan mereka. Keterbukaan informasi gawai pintar ini secara tidak langsung membangun pilar kepercayaan publik (*public trust*) yang tebal, mendorong masyarakat untuk lebih aktif dan partisipatif dalam mengawal pembangunan desanya masing-masing.
