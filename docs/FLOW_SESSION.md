# Flow Operasional Sesi Main (Skor 21)

## 1) Buat sesi

- Admin buat `session`: tanggal, lokasi, jumlah lapangan, aturan skor = **21**.

## 2) Check-in pemain

- Admin menandai pemain yang hadir (buat record `session_attendance`).
- Untuk semua pemain yang hadir: `played_count = 0`.

## 3) Pembayaran (di sesi)

Jika komunitas pakai bayar per datang:

- per pemain: status **unpaid/paid/waived**
- jika dibayar: buat `financial_transaction` category `per_visit_fee` dan link ke `session_id` & `player_id`.

Jika pemain member:

- status iuran bulanan dicek di `membership_payments` (unpaid/paid).

## 4) Mulai match

Saat lapangan kosong:

- Sistem menampilkan daftar antrian fairness:
  - tab **0x**, lalu 1x, dst.
- Admin memilih 4 pemain (manual) atau klik “rekomendasi pairing”.
- Sistem membuat `match` + 4 baris `match_players` (team 1 = 2 orang, team 2 = 2 orang).

## 5) Selesai match (input skor 21)

- Admin input `team1_score` dan `team2_score`.
- Sistem set `winner_team`.
- Untuk 4 pemain di match:
  - `played_count += 1`
  - `last_played_at = now()`

## 6) Tutup sesi

Opsional MVP:

- Ringkasan: total hadir, total match, yang masih 0x (jika ada), pemasukan/pengeluaran terkait sesi.


