<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Single', 'Double', 'Triple', 'ICU', 'VIP'];

        for ($floor = 1; $floor <= 5; $floor++) {
            for ($room_num = 1; $room_num <= 10; $room_num++) {
                Room::create([
                    'room_number' => $floor . '0' . $room_num,
                    'room_type' => fake()->randomElement($types),
                    'status' => fake()->randomElement(['available', 'occupied']),
                ]);
            }
        }
    }
}
