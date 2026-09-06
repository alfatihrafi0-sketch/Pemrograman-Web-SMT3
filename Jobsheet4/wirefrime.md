/* Registrasi Anggota Baru */

+-----------------------------------------------------------------------+
| X | SIMPUS-Mini - Registrasi   |                            _ | [] | X|
+-----------------------------------------------------------------------+

| Address: simpus-mini.test/register                                    |
+-----------------------------------------------------------------------+

|                                                                       |
|  [Logo] SIMPUS-Mini                                   [Kembali/Login] |
|                                                                       |
|-----------------------------------------------------------------------|
|                                                                       |
|             FORMULIR REGISTRASI ANGOTA BARU (AKTOR: TAMU)             |
|             Please fill out this form to join library.                |
|                                                                       |
|             +-------------------------------------------+             |
|             |  Nama Lengkap     : [                    ]|             |
|             |                                           |             |
|             |  Nomor Identitas  : [                    ]|             |
|             |  (NIK / NISN)                             |             |
|             |                                           |             |
|             |  Email Aktif      : [                    ]|             |
|             |                                           |             |
|             |  Nomor Telepon    : [                    ]|             |
|             |                                           |             |
|             |  Password Baru    : [                    ]|             |
|             |                                           |             |
|             |  Ulangi Password  : [                    ]|             |
|             |                                           |             |
|             |               +---------------+           |             |
|             |               |DAFTAR SEKARANG|           |             |
|             |               +---------------+           |             |
|             +-------------------------------------------+             |
|                                                                       |
+-----------------------------------------------------------------------+

|                 @ 2026 SIMPUS-Mini Development Team                   |
+-----------------------------------------------------------------------+


/* Buat User Flow */

[ Mulai ]
    |
    v
[ Petugas Login ke Sistem ]
    |
    v
[ Masuk ke Dashboard Petugas ]
    |
    v
[ Klik Menu "Transaksi" / "Peminjaman" ]
    |
    v
[ Masuk ke Halaman Daftar Transaksi ]
    |
    v
[ Pilih Filter / Tombol: "Lewat Jatuh Tempo" atau "Tunggakan" ]
    |
    v
+-------------------------------------------------------+
| Sistem Memfilter dan Menampilkan Daftar Anggota yang: |
| 1. Batas waktu pengembaliannya sudah terlewati        |
| 2. Memiliki status "Belum Kembali"                    |
+-------------------------------------------------------+
    |
    v
[ Petugas Melihat Detail Anggota & Jumlah Hari Keterlambatan ]
    |
    v
[ Petugas Klik Tombol "Kirim Peringatan" atau Catat Denda ]
    |
    v
[ Selesai ]