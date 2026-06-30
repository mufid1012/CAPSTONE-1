<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Santri;
use App\Models\KegiatanPondok;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PptqSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'ustadz']);
        Role::create(['name' => 'wali_murid']);

        // Set standard coordinates for testing (-7.795580, 110.369490)
        Config::set('pptq.pesantren_latitude', -7.795580);
        Config::set('pptq.pesantren_longitude', 110.369490);
        Config::set('pptq.radius_meter', 150);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_ustadz_cannot_access_admin_dashboard()
    {
        $ustadz = User::factory()->create();
        $ustadz->assignRole('ustadz');

        $response = $this->actingAs($ustadz)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_ustadz_can_store_presensi_kegiatan_within_radius()
    {
        $ustadz = User::factory()->create();
        $ustadz->assignRole('ustadz');

        $kegiatan = KegiatanPondok::create([
            'nama_kegiatan' => 'Tahfidz Pagi',
            'deskripsi' => 'Hafalan pagi',
        ]);
        $ustadz->kegiatanPondok()->attach($kegiatan->id);

        $response = $this->actingAs($ustadz)->post('/ustadz/presensi-kegiatan', [
            'kegiatan_pondok_id' => $kegiatan->id,
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'materi' => 'Surat Al-Baqarah',
            'latitude' => -7.795580,
            'longitude' => 110.369490,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('presensi_kegiatan', [
            'ustadz_id' => $ustadz->id,
            'kegiatan_pondok_id' => $kegiatan->id,
            'status' => 'valid',
        ]);
    }

    public function test_ustadz_storing_presensi_outside_radius_succeeds_temporarily()
    {
        $ustadz = User::factory()->create();
        $ustadz->assignRole('ustadz');

        $kegiatan = KegiatanPondok::create([
            'nama_kegiatan' => 'Tahsin Sore',
            'tingkatan' => 'semua'
        ]);
        $ustadz->kegiatanPondok()->attach($kegiatan->id);

        // Far coordinates (Jakarta: -6.200000, 106.816666)
        $response = $this->actingAs($ustadz)->post('/ustadz/presensi-kegiatan', [
            'kegiatan_pondok_id' => $kegiatan->id,
            'jam_mulai' => '16:00',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('presensi_kegiatan', [
            'ustadz_id' => $ustadz->id,
            'kegiatan_pondok_id' => $kegiatan->id,
        ]);
        
        $presensi = \App\Models\PresensiKegiatan::first();
        $response->assertRedirect('/ustadz/presensi-kegiatan/' . $presensi->id);
    }

    public function test_ustadz_can_record_setoran_hafalan_for_binaan()
    {
        $ustadz = User::factory()->create();
        $ustadz->assignRole('ustadz');

        $santri = Santri::create([
            'nis' => '2024999',
            'nama' => 'Santri Test',
        ]);
        $ustadz->santriBinaan()->attach($santri->id);

        $response = $this->actingAs($ustadz)->post('/ustadz/setoran-hafalan', [
            'santri_id' => $santri->id,
            'tanggal' => '2026-06-30',
            'juz' => 30,
            'surat' => 'An-Naba',
            'ayat' => '1-10',
            'nilai' => 90,
            'status_selesai' => 1,
            'catatan' => 'Lancar',
        ]);

        $response->assertRedirect('/ustadz/setoran-hafalan?santri_id=' . $santri->id);
        $this->assertDatabaseHas('setoran_hafalan', [
            'santri_id' => $santri->id,
            'ustadz_id' => $ustadz->id,
            'surat' => 'An-Naba',
            'nilai' => 90,
        ]);
    }

    public function test_admin_can_access_laporan_pages()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->get('/admin/laporan/presensi-ustadz')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/laporan/presensi-santri')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/laporan/hafalan')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/laporan/murojaah')
            ->assertStatus(200);
    }

    public function test_wali_murid_can_access_dashboard_and_reports()
    {
        $wali = User::factory()->create();
        $wali->assignRole('wali_murid');

        $santri = Santri::create([
            'nis' => '2024888',
            'nama' => 'Anak Wali',
            'wali_murid_id' => $wali->id,
        ]);

        $response = $this->actingAs($wali)->get('/wali-murid/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Anak Wali');

        $responseLaporan = $this->actingAs($wali)->get('/wali-murid/laporan-mingguan');
        $responseLaporan->assertStatus(200);
    }
}
