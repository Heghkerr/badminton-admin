# Pairing (Fairness + Grade) — Skor 21

Tujuan pairing:

- **Adil**: yang masih **0x** didahulukan main.
- **Seimbang**: total kekuatan 2 vs 2 relatif mirip.
- **Variatif**: meminimalkan partner yang sama berulang (post-MVP opsional).

## 1) Konsep dasar

### 1.1 Fairness queue

Untuk tiap sesi, setiap pemain punya:

- `played_count` (0, 1, 2, ...)
- `last_played_at`

Prioritas pemilihan pemain untuk match berikutnya:

1. `played_count` terkecil dulu (0x duluan)
2. jika sama, yang `last_played_at` paling lama (paling lama menunggu)
3. jika masih sama, random kecil (atau urutan check-in)

### 1.2 Nilai grade

Untuk perhitungan seimbang, grade dikonversi ke skor:

- A = 4
- B = 3
- C = 2
- D = 1

(Bisa kamu ubah kalau komunitasmu punya definisi berbeda.)

## 2) Aturan balancing (2 vs 2)

Misal ada 4 pemain terpilih: p1,p2,p3,p4 dengan nilai grade g1..g4.

Ada 3 cara membagi 2 vs 2:

- (p1+p2) vs (p3+p4)
- (p1+p3) vs (p2+p4)
- (p1+p4) vs (p2+p3)

Hitung selisih:

\[
\Delta = |(g_a + g_b) - (g_c + g_d)|
\]

Pilih pembagian dengan \(\Delta\) terkecil.

## 3) Mode “menggendong”

Istilah “menggendong” biasanya artinya:

- pemain kuat (A/B tinggi) dipasangkan dengan pemain lebih rendah (C/D),
- supaya total kekuatan tetap seimbang.

Contoh yang kamu sebut:

- **B + B** (3+3=6) vs **A + C** (4+2=6) → sangat seimbang.

Rule praktis:

- jika ada 1 pemain A, usahakan partner-nya C/D (kecuali minim pemain)
- hindari A+A vs C+D (terlalu timpang)

## 4) Rekomendasi pairing (algoritma MVP)

MVP tidak perlu “auto-pilih semua pemain”, cukup:

1. Sistem ambil kandidat dari antrian fairness (lihat 1.1) sebanyak **4** pemain (atau 8 jika 2 lapangan).
2. Untuk setiap grup 4 pemain:
   - sistem cari pembagian team dengan \(\Delta\) terkecil (lihat 2)
3. Tampilkan rekomendasi + tombol “acak ulang” (jika admin tidak setuju)
4. Admin bisa override manual.

Catatan: jika jumlah lapangan > 1, ambil 4*N pemain dari fairness queue.

## 5) Validasi skor 21

Untuk MVP cukup:

- `0 <= score <= 21`
- `winner_team` = team dengan skor lebih besar

Opsional (kalau ingin ketat):

- score pemenang = 21 (kecuali “win by 2” tidak dipakai di komunitasmu)


