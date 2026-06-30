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
     * Seed demo data for testing.
     */
    public function run(): void
    {
        // ===== 1. Create Ustadz =====
        $ustadzList = [];
        $namaUstadz = ['Ahmad', 'Budi', 'Fadil', 'Hasan', 'Imran'];
        foreach ($namaUstadz as $idx => $nama) {
            $u = User::firstOrCreate(
                ['email' => 'ustadz' . ($idx + 1) . '@pptq.test'],
                ['name' => 'Ustadz ' . $nama, 'password' => Hash::make('password')]
            );
            if (!$u->hasRole('ustadz')) {
                $u->assignRole('ustadz');
            }
            $ustadzList[] = $u;
        }

        // ===== 2. Create Wali Murid =====
        $waliList = [];
        $namaWali = ['Rudi', 'Andi', 'Siti', 'Fatimah', 'Lukman', 'Bambang', 'Wati', 'Tari'];
        foreach ($namaWali as $idx => $nama) {
            $w = User::firstOrCreate(
                ['email' => 'wali' . ($idx + 1) . '@pptq.test'],
                ['name' => 'Wali ' . $nama, 'password' => Hash::make('password')]
            );
            if (!$w->hasRole('wali_murid')) {
                $w->assignRole('wali_murid');
            }
            $waliList[] = $w;
        }

        // ===== 3. Create Kegiatan Pondok =====
        $kegiatanData = [
            ['nama' => 'Tahfidz Ba\'da Subuh (Ts)', 'tingkat' => 'tsanawiyah'],
            ['nama' => 'Tahsin Sore (Ts)', 'tingkat' => 'tsanawiyah'],
            ['nama' => 'Murojaah Malam (Ts)', 'tingkat' => 'tsanawiyah'],
            ['nama' => 'Kajian Fiqih (Al)', 'tingkat' => 'aliyah'],
            ['nama' => 'Hafalan Intensif (Al)', 'tingkat' => 'aliyah'],
            ['nama' => 'Kajian Tauhid (Tk)', 'tingkat' => 'takhassus'],
            ['nama' => 'Hafalan Qiraat (Tk)', 'tingkat' => 'takhassus'],
            ['nama' => 'Halaqah Kubro (Semua)', 'tingkat' => 'semua'],
        ];
        $kegiatanList = [];
        foreach ($kegiatanData as $k) {
            $kegiatanList[] = KegiatanPondok::firstOrCreate(
                ['nama_kegiatan' => $k['nama']],
                ['deskripsi' => 'Deskripsi untuk ' . $k['nama'], 'tingkatan' => $k['tingkat']]
            );
        }

        // Assign Ustadz to Kegiatan (each ustadz handles 2-3 kegiatan)
        foreach ($ustadzList as $u) {
            $u->kegiatanPondok()->syncWithoutDetaching(collect($kegiatanList)->random(3)->pluck('id')->toArray());
        }

        // ===== 4. Create Santri =====
        $santriTsanawiyah = [];
        $santriAliyah = [];
        $santriTakhassus = [];
        
        $kelasTs = ['7', '8', '9'];
        $kelasAl = ['10', '11', '12'];

        for ($i = 1; $i <= 30; $i++) {
            $tingkatan = $i <= 10 ? 'tsanawiyah' : ($i <= 20 ? 'aliyah' : 'takhassus');
            $kelas = $tingkatan === 'tsanawiyah' ? $kelasTs[array_rand($kelasTs)] : ($tingkatan === 'aliyah' ? $kelasAl[array_rand($kelasAl)] : 'Takhassus');
            
            $s = Santri::firstOrCreate(
                ['nis' => '2026' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'nama' => 'Santri Dummy ' . $i,
                    'tanggal_lahir' => \Carbon\Carbon::now()->subYears(15)->format('Y-m-d'),
                    'wali_murid_id' => collect($waliList)->random()->id,
                    'tingkatan' => $tingkatan,
                    'kelas' => $kelas,
                ]
            );

            if ($tingkatan === 'tsanawiyah') $santriTsanawiyah[] = $s;
            elseif ($tingkatan === 'aliyah') $santriAliyah[] = $s;
            else $santriTakhassus[] = $s;
        }
        $semuaSantri = array_merge($santriTsanawiyah, $santriAliyah, $santriTakhassus);

        // Assign Santri to Ustadz (Santri Binaan) - ensure tier matching where possible, but random is fine for dummy
        foreach ($ustadzList as $u) {
            $binaanIds = collect($semuaSantri)->random(6)->pluck('id')->toArray();
            $u->santriBinaan()->syncWithoutDetaching($binaanIds);
        }

        // ===== 5. Generate Past Data (Last 45 Days) =====
        $startDate = \Carbon\Carbon::now()->subDays(45);
        $endDate = \Carbon\Carbon::now();
        $statuses = ['hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit', 'alpha'];

        // Loop per day
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            
            // Generate Presensi Kegiatan for 3 random activities each day
            $dailyKegiatan = collect($kegiatanList)->random(3);
            
            foreach ($dailyKegiatan as $kegiatan) {
                // Get one of the ustadz who teaches this kegiatan
                $pengampu = $kegiatan->ustadz()->first() ?? collect($ustadzList)->random();
                
                $presensiKeg = \App\Models\PresensiKegiatan::create([
                    'kegiatan_pondok_id' => $kegiatan->id,
                    'ustadz_id' => $pengampu->id,
                    'tanggal' => $date->format('Y-m-d'),
                    'hari' => ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek],
                    'jam_mulai' => '16:00',
                    'jam_selesai' => '17:30',
                    'materi' => 'Materi rutin ' . $kegiatan->nama_kegiatan,
                    'latitude' => config('pptq.pesantren_latitude'),
                    'longitude' => config('pptq.pesantren_longitude'),
                    'status' => 'valid'
                ]);

                // Determine which santri attend (based on tingkatan)
                $eligibleSantri = [];
                if ($kegiatan->tingkatan === 'semua') $eligibleSantri = collect($semuaSantri);
                elseif ($kegiatan->tingkatan === 'tsanawiyah') $eligibleSantri = collect($santriTsanawiyah);
                elseif ($kegiatan->tingkatan === 'aliyah') $eligibleSantri = collect($santriAliyah);
                else $eligibleSantri = collect($santriTakhassus);

                // Give them presensi
                foreach ($eligibleSantri->random(min(8, $eligibleSantri->count())) as $s) {
                    \App\Models\PresensiSantri::create([
                        'presensi_kegiatan_id' => $presensiKeg->id,
                        'santri_id' => $s->id,
                        'status' => $statuses[array_rand($statuses)]
                    ]);
                }
            }

            // Generate Hafalan & Murojaah records
            if ($date->isWeekday()) {
                foreach ($ustadzList as $u) {
                    $binaan = $u->santriBinaan()->get();
                    if ($binaan->count() > 0) {
                        $s = $binaan->random();
                        // Setoran Hafalan
                        SetoranHafalan::create([
                            'santri_id' => $s->id,
                            'ustadz_id' => $u->id,
                            'tanggal' => $date->format('Y-m-d'),
                            'juz' => rand(1, 30),
                            'surat' => 'Surat Dummy',
                            'ayat' => rand(1, 10) . '-' . rand(11, 20),
                            'nilai' => rand(70, 95),
                            'status_selesai' => rand(0, 1)
                        ]);
                        // Murojaah
                        $s2 = $binaan->random();
                        Murojaah::create([
                            'santri_id' => $s2->id,
                            'ustadz_id' => $u->id,
                            'tanggal' => $date->format('Y-m-d'),
                            'juz' => rand(1, 30),
                            'surat' => 'Surat Dummy',
                            'ayat' => rand(1, 10) . '-' . rand(11, 20),
                            'nilai' => rand(75, 98),
                            'status_selesai' => rand(0, 1)
                        ]);
                    }
                }
            }
        }
    }
}
