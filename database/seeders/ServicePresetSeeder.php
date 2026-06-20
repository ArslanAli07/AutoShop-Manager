<?php

namespace Database\Seeders;

use App\Models\ServicePreset;
use Illuminate\Database\Seeder;

class ServicePresetSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Maintenance Services
            ['name' => 'Oil Change', 'name_urdu' => 'تیل کی تبدیلی', 'category' => 'Maintenance', 'default_labor_cost' => 500],
            ['name' => 'Filter Replacement', 'name_urdu' => 'فلٹر کی تبدیلی', 'category' => 'Maintenance', 'default_labor_cost' => 300],
            ['name' => 'Air Filter', 'name_urdu' => 'ہوا کا فلٹر', 'category' => 'Maintenance', 'default_labor_cost' => 200],
            ['name' => 'Cabin Filter', 'name_urdu' => 'کیبن فلٹر', 'category' => 'Maintenance', 'default_labor_cost' => 250],
            ['name' => 'Coolant Flush', 'name_urdu' => 'کولنٹ صفائی', 'category' => 'Maintenance', 'default_labor_cost' => 600],

            // Tire & Suspension
            ['name' => 'Tire Rotation', 'name_urdu' => 'ٹائر گھومنا', 'category' => 'Tires', 'default_labor_cost' => 400],
            ['name' => 'Tire Balance', 'name_urdu' => 'ٹائر توازن', 'category' => 'Tires', 'default_labor_cost' => 300],
            ['name' => 'Wheel Alignment', 'name_urdu' => 'پہیے کی سیدھائی', 'category' => 'Suspension', 'default_labor_cost' => 1000],
            ['name' => 'Brake Inspection', 'name_urdu' => 'بریک چیک', 'category' => 'Brakes', 'default_labor_cost' => 300],

            // General Checkup
            ['name' => 'General Checkup', 'name_urdu' => 'عام چیک اپ', 'category' => 'Inspection', 'default_labor_cost' => 800],
            ['name' => 'Battery Check', 'name_urdu' => 'بیٹری چیک', 'category' => 'Electrical', 'default_labor_cost' => 200],
            ['name' => 'Wiper Blade Replace', 'name_urdu' => 'وپر بلیڈ تبدیل', 'category' => 'Maintenance', 'default_labor_cost' => 250],

            // Repairs
            ['name' => 'Brake Pad Replacement', 'name_urdu' => 'بریک پیڈ تبدیلی', 'category' => 'Brakes', 'default_labor_cost' => 1200],
            ['name' => 'Spark Plug Replacement', 'name_urdu' => 'سپارک پلگ تبدیلی', 'category' => 'Engine', 'default_labor_cost' => 400],
            ['name' => 'Belt Replacement', 'name_urdu' => 'بیلٹ تبدیلی', 'category' => 'Engine', 'default_labor_cost' => 800],
        ];

        foreach ($services as $service) {
            ServicePreset::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
