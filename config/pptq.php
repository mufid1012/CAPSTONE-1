<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Koordinat Lokasi Pesantren
    |--------------------------------------------------------------------------
    |
    | Titik koordinat (latitude/longitude) lokasi PPTQ Muhammadiyah Ibnu Juraimi
    | yang digunakan sebagai acuan validasi presensi ustadz via geolocation.
    |
    */

    'pesantren_latitude'  => env('PESANTREN_LAT', -3.316694),
    'pesantren_longitude' => env('PESANTREN_LNG', 114.590111),

    /*
    |--------------------------------------------------------------------------
    | Radius Validasi (dalam meter)
    |--------------------------------------------------------------------------
    |
    | Radius toleransi jarak antara posisi ustadz dengan lokasi pesantren
    | agar presensi dianggap sah. Default: 150 meter.
    |
    */

    'radius_meter' => env('PESANTREN_RADIUS', 150),

    /*
    |--------------------------------------------------------------------------
    | Status Presensi Santri
    |--------------------------------------------------------------------------
    */

    'status_presensi' => ['hadir', 'izin', 'sakit', 'alpha'],

];
