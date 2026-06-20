<?php

namespace Database\Seeders;

use App\Models\PartReference;
use Illuminate\Database\Seeder;

class PartReferenceSeeder extends Seeder
{
    public function run(): void
    {
        $parts = [
            // Filters
            ['name' => 'Engine Oil Filter', 'part_number' => 'FILTER-OIL-001', 'default_price' => 150, 'needs_reorder' => false],
            ['name' => 'Air Filter', 'part_number' => 'FILTER-AIR-001', 'default_price' => 200, 'needs_reorder' => false],
            ['name' => 'Cabin Air Filter', 'part_number' => 'FILTER-CABIN-001', 'default_price' => 300, 'needs_reorder' => false],
            ['name' => 'Fuel Filter', 'part_number' => 'FILTER-FUEL-001', 'default_price' => 250, 'needs_reorder' => false],

            // Brake Components
            ['name' => 'Brake Pad Set (Front)', 'part_number' => 'BRAKE-PAD-F-001', 'default_price' => 1500, 'needs_reorder' => false],
            ['name' => 'Brake Pad Set (Rear)', 'part_number' => 'BRAKE-PAD-R-001', 'default_price' => 1200, 'needs_reorder' => false],
            ['name' => 'Brake Fluid', 'part_number' => 'BRAKE-FLUID-001', 'default_price' => 400, 'needs_reorder' => false],
            ['name' => 'Brake Disc (Front)', 'part_number' => 'BRAKE-DISC-F-001', 'default_price' => 2000, 'needs_reorder' => false],
            ['name' => 'Brake Disc (Rear)', 'part_number' => 'BRAKE-DISC-R-001', 'default_price' => 1800, 'needs_reorder' => false],

            // Engine Parts
            ['name' => 'Spark Plugs (Set of 4)', 'part_number' => 'SPARK-PLUG-004', 'default_price' => 600, 'needs_reorder' => false],
            ['name' => 'Spark Plugs (Set of 6)', 'part_number' => 'SPARK-PLUG-006', 'default_price' => 900, 'needs_reorder' => false],
            ['name' => 'Serpentine Belt', 'part_number' => 'BELT-SERP-001', 'default_price' => 800, 'needs_reorder' => false],
            ['name' => 'Engine Oil (5L)', 'part_number' => 'OIL-5L-001', 'default_price' => 1200, 'needs_reorder' => false],
            ['name' => 'Coolant (5L)', 'part_number' => 'COOLANT-5L-001', 'default_price' => 800, 'needs_reorder' => false],

            // Electrical
            ['name' => 'Battery (12V)', 'part_number' => 'BATTERY-12V-001', 'default_price' => 3000, 'needs_reorder' => false],
            ['name' => 'Alternator', 'part_number' => 'ALTERNATOR-001', 'default_price' => 4000, 'needs_reorder' => false],
            ['name' => 'Starter Motor', 'part_number' => 'STARTER-001', 'default_price' => 3500, 'needs_reorder' => false],
            ['name' => 'Headlight Bulb (H7)', 'part_number' => 'BULB-H7-001', 'default_price' => 300, 'needs_reorder' => false],
            ['name' => 'Taillight Bulb', 'part_number' => 'BULB-TAIL-001', 'default_price' => 150, 'needs_reorder' => false],

            // Wipers & Glass
            ['name' => 'Wiper Blade (Front Left)', 'part_number' => 'WIPER-F-L-001', 'default_price' => 400, 'needs_reorder' => false],
            ['name' => 'Wiper Blade (Front Right)', 'part_number' => 'WIPER-F-R-001', 'default_price' => 400, 'needs_reorder' => false],
            ['name' => 'Wiper Blade (Rear)', 'part_number' => 'WIPER-R-001', 'default_price' => 350, 'needs_reorder' => false],
            ['name' => 'Windshield Washer Fluid', 'part_number' => 'WASHER-001', 'default_price' => 200, 'needs_reorder' => false],
        ];

        foreach ($parts as $part) {
            PartReference::updateOrCreate(
                ['name' => $part['name']],
                $part
            );
        }
    }
}
