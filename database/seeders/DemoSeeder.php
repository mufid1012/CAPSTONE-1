<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Santri;
use App\Models\KegiatanPondok;
use App\Models\SetoranHafalan;
use App\Models\Murojaah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Data surat Al-Qur'an untuk setoran & murojaah.
     */
    private array $suratData = [
        1 => ['Al-Fatihah','Al-Baqarah'],
        2 => ['Al-Baqarah'],
        3 => ['Ali Imran'],
        4 => ['An-Nisa'],
        5 => ['Al-Maidah'],
        6 => ['Al-An\'am'],
        7 => ['Al-A\'raf'],
        8 => ['Al-Anfal','At-Taubah'],
        9 => ['At-Taubah','Yunus'],
        10 => ['Yunus','Hud'],
        11 => ['Hud','Yusuf'],
        12 => ['Yusuf','Ar-Ra\'d'],
        13 => ['Ar-Ra\'d','Ibrahim','Al-Hijr'],
        14 => ['Al-Hijr','An-Nahl'],
        15 => ['An-Nahl','Al-Isra'],
        16 => ['Al-Isra','Al-Kahf'],
        17 => ['Al-Kahf','Maryam','Taha'],
        18 => ['Taha','Al-Anbiya'],
        19 => ['Al-Anbiya','Al-Hajj'],
        20 => ['Al-Hajj','Al-Mu\'minun','An-Nur'],
        21 => ['An-Nur','Al-Furqan','Asy-Syu\'ara'],
        22 => ['Asy-Syu\'ara','An-Naml','Al-Qasas'],
        23 => ['Al-Qasas','Al-Ankabut','Ar-Rum'],
        24 => ['Ar-Rum','Luqman','As-Sajdah','Al-Ahzab'],
        25 => ['Al-Ahzab','Saba\'','Fatir','Ya-Sin'],
        26 => ['Ya-Sin','As-Saffat','Sad','Az-Zumar'],
        27 => ['Az-Zumar','Ghafir','Fussilat'],
        28 => ['Fussilat','Asy-Syura','Az-Zukhruf','Ad-Dukhan','Al-Jasiyah'],
        29 => ['Al-Jasiyah','Al-Ahqaf','Muhammad','Al-Fath','Al-Hujurat'],
        30 => ['An-Naba','An-Nazi\'at','Abasa','At-Takwir','Al-Infitar','Al-Mutaffifin','Al-Insyiqaq','Al-Buruj','At-Tariq','Al-A\'la','Al-Ghasyiyah','Al-Fajr','Al-Balad','Asy-Syams','Al-Lail','Ad-Duha','Asy-Syarh','At-Tin','Al-Alaq','Al-Qadr','Al-Bayyinah','Az-Zalzalah','Al-Adiyat','Al-Qari\'ah','At-Takasur','Al-Asr','Al-Humazah','Al-Fil','Quraisy','Al-Ma\'un','Al-Kausar','Al-Kafirun','An-Nasr','Al-Lahab','Al-Ikhlas','Al-Falaq','An-Nas'],
    ];

    public function run(): void
    {
        // ===== 1. Create Ustadz =====
        $ustadzData = [
            ['name' => 'Ustadz Abdullah Faqih', 'email' => 'ustadz1@pptq.test'],
            ['name' => 'Ustadz Muhammad Ridwan', 'email' => 'ustadz2@pptq.test'],
            ['name' => 'Ustadz Hasan Al-Basri', 'email' => 'ustadz3@pptq.test'],
            ['name' => 'Ustadz Imam Syafi\'i', 'email' => 'ustadz4@pptq.test'],
            ['name' => 'Ustadz Zainul Arifin', 'email' => 'ustadz5@pptq.test'],
        ];
        $ustadzList = [];
        foreach ($ustadzData as $data) {
            $u = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password')]
            );
            if (!$u->hasRole('ustadz')) $u->assignRole('ustadz');
            $ustadzList[] = $u;
        }

        // ===== 2. Create Wali Murid =====
        $waliData = [
            ['name' => 'Bapak Ahmad Sulaiman', 'email' => 'wali1@pptq.test'],
            ['name' => 'Ibu Siti Aminah', 'email' => 'wali2@pptq.test'],
            ['name' => 'Bapak Mahmud Hasan', 'email' => 'wali3@pptq.test'],
            ['name' => 'Ibu Fatimah Az-Zahra', 'email' => 'wali4@pptq.test'],
            ['name' => 'Bapak Lukman Hakim', 'email' => 'wali5@pptq.test'],
            ['name' => 'Ibu Khadijah Nur', 'email' => 'wali6@pptq.test'],
            ['name' => 'Bapak Ridwan Kamil', 'email' => 'wali7@pptq.test'],
            ['name' => 'Ibu Aisyah Rahma', 'email' => 'wali8@pptq.test'],
        ];
        $waliList = [];
        foreach ($waliData as $data) {
            $w = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password')]
            );
            if (!$w->hasRole('wali_murid')) $w->assignRole('wali_murid');
            $waliList[] = $w;
        }

        // ===== 3. Create Kegiatan Pondok =====
        $kegiatanData = [
            ['nama' => 'Tahfidz Ba\'da Subuh', 'tingkatan' => 'tsanawiyah', 'kelas' => '7', 'deskripsi' => 'Hafalan Al-Quran setelah sholat Subuh untuk kelas 7'],
            ['nama' => 'Tahfidz Ba\'da Subuh', 'tingkatan' => 'tsanawiyah', 'kelas' => '8', 'deskripsi' => 'Hafalan Al-Quran setelah sholat Subuh untuk kelas 8'],
            ['nama' => 'Tahfidz Ba\'da Subuh', 'tingkatan' => 'tsanawiyah', 'kelas' => '9', 'deskripsi' => 'Hafalan Al-Quran setelah sholat Subuh untuk kelas 9'],
            ['nama' => 'Tahsin Sore', 'tingkatan' => 'tsanawiyah', 'kelas' => null, 'deskripsi' => 'Perbaikan bacaan Al-Quran untuk seluruh santri Tsanawiyah'],
            ['nama' => 'Tahfidz Pagi', 'tingkatan' => 'aliyah', 'kelas' => '10', 'deskripsi' => 'Hafalan Al-Quran pagi hari untuk kelas 10'],
            ['nama' => 'Tahfidz Pagi', 'tingkatan' => 'aliyah', 'kelas' => '11', 'deskripsi' => 'Hafalan Al-Quran pagi hari untuk kelas 11'],
            ['nama' => 'Tahfidz Pagi', 'tingkatan' => 'aliyah', 'kelas' => '12', 'deskripsi' => 'Hafalan Al-Quran pagi hari untuk kelas 12'],
            ['nama' => 'Kajian Kitab Kuning', 'tingkatan' => 'aliyah', 'kelas' => null, 'deskripsi' => 'Kajian kitab kuning untuk seluruh santri Aliyah'],
            ['nama' => 'Tahfidz Intensif', 'tingkatan' => 'takhassus', 'kelas' => 'Takhassus', 'deskripsi' => 'Program hafalan intensif 30 juz'],
            ['nama' => 'Murojaah Malam', 'tingkatan' => 'semua', 'kelas' => null, 'deskripsi' => 'Pengulangan hafalan bersama setelah Isya'],
            ['nama' => 'Halaqah Tahsin', 'tingkatan' => 'semua', 'kelas' => null, 'deskripsi' => 'Halaqah perbaikan tajwid dan makhorijul huruf'],
        ];
        $kegiatanList = [];
        foreach ($kegiatanData as $k) {
            $kegiatanList[] = KegiatanPondok::firstOrCreate(
                ['nama_kegiatan' => $k['nama'], 'tingkatan' => $k['tingkatan'], 'kelas' => $k['kelas']],
                ['deskripsi' => $k['deskripsi']]
            );
        }

        // Assign Ustadz to Kegiatan
        $ustadzList[0]->kegiatanPondok()->syncWithoutDetaching([$kegiatanList[0]->id, $kegiatanList[3]->id, $kegiatanList[9]->id]);
        $ustadzList[1]->kegiatanPondok()->syncWithoutDetaching([$kegiatanList[1]->id, $kegiatanList[4]->id, $kegiatanList[10]->id]);
        $ustadzList[2]->kegiatanPondok()->syncWithoutDetaching([$kegiatanList[2]->id, $kegiatanList[5]->id, $kegiatanList[7]->id]);
        $ustadzList[3]->kegiatanPondok()->syncWithoutDetaching([$kegiatanList[6]->id, $kegiatanList[8]->id, $kegiatanList[9]->id]);
        $ustadzList[4]->kegiatanPondok()->syncWithoutDetaching([$kegiatanList[3]->id, $kegiatanList[7]->id, $kegiatanList[10]->id]);

        // ===== 4. Create Santri =====
        $santriNames = [
            // Tsanawiyah - Kelas 7
            ['nama' => 'Muhammad Farhan', 'nis' => '2026001', 'tingkatan' => 'tsanawiyah', 'kelas' => '7', 'wali' => 0],
            ['nama' => 'Ahmad Zaki', 'nis' => '2026002', 'tingkatan' => 'tsanawiyah', 'kelas' => '7', 'wali' => 0],
            ['nama' => 'Bilal Ibrahim', 'nis' => '2026003', 'tingkatan' => 'tsanawiyah', 'kelas' => '7', 'wali' => 1],
            ['nama' => 'Umar Faruq', 'nis' => '2026004', 'tingkatan' => 'tsanawiyah', 'kelas' => '7', 'wali' => 1],
            // Tsanawiyah - Kelas 8
            ['nama' => 'Yusuf Habibi', 'nis' => '2026005', 'tingkatan' => 'tsanawiyah', 'kelas' => '8', 'wali' => 2],
            ['nama' => 'Hamzah Ridho', 'nis' => '2026006', 'tingkatan' => 'tsanawiyah', 'kelas' => '8', 'wali' => 2],
            ['nama' => 'Khalid Anwar', 'nis' => '2026007', 'tingkatan' => 'tsanawiyah', 'kelas' => '8', 'wali' => 3],
            // Tsanawiyah - Kelas 9
            ['nama' => 'Salman Al-Farisi', 'nis' => '2026008', 'tingkatan' => 'tsanawiyah', 'kelas' => '9', 'wali' => 3],
            ['nama' => 'Raihan Maulana', 'nis' => '2026009', 'tingkatan' => 'tsanawiyah', 'kelas' => '9', 'wali' => 0],
            ['nama' => 'Dzaki Firmansyah', 'nis' => '2026010', 'tingkatan' => 'tsanawiyah', 'kelas' => '9', 'wali' => 1],
            // Aliyah - Kelas 10
            ['nama' => 'Faris Abdullah', 'nis' => '2026011', 'tingkatan' => 'aliyah', 'kelas' => '10', 'wali' => 4],
            ['nama' => 'Naufal Hidayat', 'nis' => '2026012', 'tingkatan' => 'aliyah', 'kelas' => '10', 'wali' => 4],
            ['nama' => 'Aqil Mubarak', 'nis' => '2026013', 'tingkatan' => 'aliyah', 'kelas' => '10', 'wali' => 5],
            // Aliyah - Kelas 11
            ['nama' => 'Husain Syahid', 'nis' => '2026014', 'tingkatan' => 'aliyah', 'kelas' => '11', 'wali' => 5],
            ['nama' => 'Rafli Muazzam', 'nis' => '2026015', 'tingkatan' => 'aliyah', 'kelas' => '11', 'wali' => 6],
            ['nama' => 'Thoriq Aziz', 'nis' => '2026016', 'tingkatan' => 'aliyah', 'kelas' => '11', 'wali' => 6],
            // Aliyah - Kelas 12
            ['nama' => 'Rasyid Ismail', 'nis' => '2026017', 'tingkatan' => 'aliyah', 'kelas' => '12', 'wali' => 7],
            ['nama' => 'Sulthan Malik', 'nis' => '2026018', 'tingkatan' => 'aliyah', 'kelas' => '12', 'wali' => 7],
            ['nama' => 'Haikal Ramadhan', 'nis' => '2026019', 'tingkatan' => 'aliyah', 'kelas' => '12', 'wali' => 4],
            // Takhassus
            ['nama' => 'Muadz bin Jabal', 'nis' => '2026020', 'tingkatan' => 'takhassus', 'kelas' => 'Takhassus', 'wali' => 5],
            ['nama' => 'Ubay bin Ka\'ab', 'nis' => '2026021', 'tingkatan' => 'takhassus', 'kelas' => 'Takhassus', 'wali' => 6],
            ['nama' => 'Zaid bin Tsabit', 'nis' => '2026022', 'tingkatan' => 'takhassus', 'kelas' => 'Takhassus', 'wali' => 7],
            ['nama' => 'Abdullah bin Mas\'ud', 'nis' => '2026023', 'tingkatan' => 'takhassus', 'kelas' => 'Takhassus', 'wali' => 0],
            ['nama' => 'Saad bin Abi Waqqas', 'nis' => '2026024', 'tingkatan' => 'takhassus', 'kelas' => 'Takhassus', 'wali' => 2],
        ];

        $santriByTingkatan = ['tsanawiyah' => [], 'aliyah' => [], 'takhassus' => []];
        $allSantri = [];

        foreach ($santriNames as $sData) {
            $s = Santri::firstOrCreate(
                ['nis' => $sData['nis']],
                [
                    'nama' => $sData['nama'],
                    'tanggal_lahir' => \Carbon\Carbon::now()->subYears(rand(13, 22))->subDays(rand(0, 364))->format('Y-m-d'),
                    'wali_murid_id' => $waliList[$sData['wali']]->id,
                    'tingkatan' => $sData['tingkatan'],
                    'kelas' => $sData['kelas'],
                ]
            );
            $santriByTingkatan[$sData['tingkatan']][] = $s;
            $allSantri[] = $s;
        }

        // Assign Santri Binaan ke Ustadz
        $ustadzList[0]->santriBinaan()->syncWithoutDetaching(collect($santriByTingkatan['tsanawiyah'])->take(5)->pluck('id')->toArray());
        $ustadzList[1]->santriBinaan()->syncWithoutDetaching(collect($santriByTingkatan['tsanawiyah'])->slice(3, 4)->pluck('id')->toArray());
        $ustadzList[2]->santriBinaan()->syncWithoutDetaching(collect($santriByTingkatan['aliyah'])->take(5)->pluck('id')->toArray());
        $ustadzList[3]->santriBinaan()->syncWithoutDetaching(collect($santriByTingkatan['aliyah'])->slice(3)->pluck('id')->toArray());
        $ustadzList[4]->santriBinaan()->syncWithoutDetaching(collect($santriByTingkatan['takhassus'])->pluck('id')->toArray());

        // ===== 5. Generate Riwayat 45 Hari Terakhir =====
        $startDate = \Carbon\Carbon::now()->subDays(45);
        $endDate = \Carbon\Carbon::now();
        $statusOptions = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit', 'alpha'];
        $hariMap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Skip hari Jumat (libur kegiatan)
            if ($date->dayOfWeek === 5) continue;

            // 3-4 kegiatan berjalan per hari
            $dailyKegiatan = collect($kegiatanList)->random(min(4, count($kegiatanList)));

            foreach ($dailyKegiatan as $kegiatan) {
                $pengampu = $kegiatan->ustadz()->first() ?? collect($ustadzList)->random();

                $jamMulai = collect(['05:00','06:30','14:00','16:00','19:30'])->random();

                $presensiKeg = \App\Models\PresensiKegiatan::create([
                    'kegiatan_pondok_id' => $kegiatan->id,
                    'ustadz_id' => $pengampu->id,
                    'tanggal' => $date->format('Y-m-d'),
                    'hari' => $hariMap[$date->dayOfWeek],
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => \Carbon\Carbon::parse($jamMulai)->addMinutes(90)->format('H:i'),
                    'materi' => collect([
                        'Hafalan surat baru juz ' . rand(1, 30),
                        'Murojaah juz ' . rand(1, 30),
                        'Tahsin makhorijul huruf',
                        'Tajwid hukum nun mati dan tanwin',
                        'Kajian tafsir surat Al-Baqarah',
                        'Setoran hafalan harian',
                        'Latihan tartil dan tahsin',
                        'Kajian fiqih ibadah',
                        'Tadarus bersama',
                        'Pembahasan kitab Riyadhus Shalihin',
                    ])->random(),
                    'latitude' => config('pptq.pesantren_latitude'),
                    'longitude' => config('pptq.pesantren_longitude'),
                    'status' => 'valid',
                ]);

                // Presensi santri sesuai tingkatan & kelas kegiatan
                $eligibleSantri = collect($allSantri);
                if ($kegiatan->tingkatan !== 'semua') {
                    $eligibleSantri = $eligibleSantri->filter(fn($s) => $s->tingkatan === $kegiatan->tingkatan);
                }
                if (!empty($kegiatan->kelas)) {
                    $eligibleSantri = $eligibleSantri->filter(fn($s) => $s->kelas === $kegiatan->kelas);
                }

                if ($eligibleSantri->isNotEmpty()) {
                    foreach ($eligibleSantri->random(min(max(3, $eligibleSantri->count() - 1), $eligibleSantri->count())) as $s) {
                        \App\Models\PresensiSantri::create([
                            'presensi_kegiatan_id' => $presensiKeg->id,
                            'santri_id' => $s->id,
                            'status' => $statusOptions[array_rand($statusOptions)],
                        ]);
                    }
                }
            }

            // Setoran Hafalan & Murojaah (hari kerja saja)
            if ($date->isWeekday()) {
                foreach ($ustadzList as $u) {
                    $binaan = $u->santriBinaan()->get();
                    if ($binaan->isEmpty()) continue;

                    $s = $binaan->random();
                    $juz = rand(1, 30);
                    $suratList = $this->suratData[$juz] ?? ['Al-Fatihah'];
                    $surat = $suratList[array_rand($suratList)];
                    $ayatStart = rand(1, 15);
                    $ayatEnd = $ayatStart + rand(3, 15);

                    SetoranHafalan::create([
                        'santri_id' => $s->id,
                        'ustadz_id' => $u->id,
                        'tanggal' => $date->format('Y-m-d'),
                        'juz' => $juz,
                        'surat' => $surat,
                        'ayat' => $ayatStart . '-' . $ayatEnd,
                        'nilai' => rand(70, 98),
                        'status_selesai' => rand(0, 1),
                    ]);

                    // Murojaah (santri berbeda jika memungkinkan)
                    $s2 = $binaan->count() > 1 ? $binaan->where('id', '!=', $s->id)->random() : $s;
                    $juz2 = rand(1, 30);
                    $suratList2 = $this->suratData[$juz2] ?? ['Al-Fatihah'];
                    $surat2 = $suratList2[array_rand($suratList2)];
                    $ayatStart2 = rand(1, 20);
                    $ayatEnd2 = $ayatStart2 + rand(5, 20);

                    Murojaah::create([
                        'santri_id' => $s2->id,
                        'ustadz_id' => $u->id,
                        'tanggal' => $date->format('Y-m-d'),
                        'juz' => $juz2,
                        'surat' => $surat2,
                        'ayat' => $ayatStart2 . '-' . $ayatEnd2,
                        'nilai' => rand(75, 100),
                        'status_selesai' => rand(0, 1),
                    ]);
                }
            }
        }
    }
}
