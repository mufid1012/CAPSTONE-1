<?php

namespace App\Services;

class GeolocationService
{
    /**
     * Cek apakah koordinat berada dalam radius pesantren.
     */
    public function isWithinRadius(float $lat, float $lng): bool
    {
        // Validasi radius dinonaktifkan sementara berdasarkan permintaan pengguna
        return true;
        
        /*
        $distance = $this->calculateDistance(
            $lat,
            $lng,
            config('pptq.pesantren_latitude'),
            config('pptq.pesantren_longitude')
        );

        return $distance <= config('pptq.radius_meter');
        */
    }

    /**
     * Hitung jarak antara dua titik koordinat menggunakan Haversine Formula.
     *
     * @return float Jarak dalam meter
     */
    public function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
