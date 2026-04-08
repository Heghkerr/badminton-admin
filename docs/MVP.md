# MVP — Badminton Admin (Skor 21)

Target MVP: admin bisa **mengelola pemain**, **mencatat pembayaran**, menjalankan **sesi main**, sistem menampilkan **0x/1x/2x** dengan jelas, dan membantu **rekomendasi pairing**.

## 1) Modul Pemain

- Data pemain: nama, no HP (opsional), **grade** (A/B/C/D), status **member/tamu**, aktif/nonaktif.
- Aksi: tambah/edit/nonaktifkan.

## 2) Modul Pembayaran

### Jenis pembayaran

- **Per datang**: dibayar per sesi hadir.
- **Member bulanan**: dibayar per bulan (atau periode).

### Status yang wajib ada

- **Belum bayar** / **Sudah bayar** untuk sesi/periode terkait.
- Riwayat transaksi: tanggal, nominal, metode (cash/transfer), catatan.

## 3) Modul Kas (pemasukan/pengeluaran)

- Pemasukan: dari pembayaran (per datang/member) dan pemasukan lain.
- Pengeluaran: shuttlecock/kock, sewa lapangan, dll.
- Laporan sederhana: filter per tanggal/periode, total masuk/keluar, saldo berjalan (opsional).

## 4) Modul Sesi Main (inti operasional)

### Setup sesi

- Tanggal, lokasi, jumlah lapangan, aturan skor: **21**.
- Daftar hadir (check-in): pemain yang datang dimasukkan ke sesi.

### Fairness tracker

Untuk setiap pemain dalam sesi:

- **played_count**: berapa kali sudah main (awal 0).
- **last_played_at**: terakhir main kapan (untuk antrian).

UI yang disarankan:

- Tab “Belum main (0x)” otomatis diurutkan duluan.
- Indikator “baru main” vs “lama menunggu”.

### Pairing

- Admin bisa **manual** susun 4 orang untuk 1 lapangan.
- Sistem bisa kasih **rekomendasi pairing** (lihat `PAIRING.md`).

### Hasil pertandingan

- Input cepat: pasangan 1 vs pasangan 2, **skor 0–21**, pemenang otomatis dari skor, catatan.
- Setelah submit hasil: semua pemain di game tersebut `played_count += 1`.

## 5) MVP Admin Screen (urutan implementasi)

1. CRUD pemain + grade
2. Sesi: buat sesi + check-in list
3. Tampilan antrian fairness (0x/1x/2x…)
4. Buat match (manual) + input skor 21 + increment played_count
5. Pembayaran per datang (link ke sesi) + status sudah/belum
6. Pembayaran member (link ke periode) + status sudah/belum
7. Kas masuk/keluar + laporan

## Yang sengaja ditunda (Post-MVP)

- Notifikasi WA otomatis
- Statistik advanced (winrate, partner history)
- Auto-pairing full otomatis tanpa admin (bisa menyusul setelah aturan pairing stabil)


