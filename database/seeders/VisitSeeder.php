<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36';

        $cities = [
            ['ip' => '255.255.255.1', 'city' => 'Frankfurt am Main', 'country' => 'Germany'],
            ['ip' => '255.255.255.2', 'city' => 'Moscow',            'country' => 'Russia'],
        ];

        $records = [];
        $now = Carbon::now();

        for ($i = 0; $i < 1000; $i++) {
            // соотношение 3:7 — Frankfurt реже
            $location = rand(1, 10) <= 3 ? $cities[0] : $cities[1];

            $records[] = [
                'ip'         => $location['ip'],
                'city'       => $location['city'],
                'country'    => $location['country'],
                'user_agent' => $userAgent,
                'created_at' => $now->copy()->subSeconds(rand(0, 30 * 24 * 3600)),
                'updated_at' => $now,
            ];
        }

        // чанками, чтобы не грузить бд одним огромным инсертом
        foreach (array_chunk($records, 100) as $chunk) {
            Visit::insert($chunk);
        }
    }
}
