<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('Role', 'local')->get();

        $types = ['appointment', 'prescription', 'lab_result', 'bill', 'admission', 'system'];
        $channels = ['email', 'sms'];
        $statuses = ['sent', 'pending', 'failed'];

        foreach ($users->take(20) as $user) {
            // Create 2-4 notifications per user
            for ($i = 0; $i < fake()->numberBetween(2, 4); $i++) {
                Notification::create([
                    'recipient_id' => $user->id,
                    'type' => fake()->randomElement($types),
                    'channel' => fake()->randomElement($channels),
                    'title' => fake()->sentence(),
                    'message' => fake()->paragraph(),
                    'data' => [
                        'id' => fake()->numerify('####'),
                        'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
                    ],
                    'sent_at' => fake()->optional(80)->dateTimeBetween('-30 days', 'now'),
                    'status' => fake()->randomElement($statuses),
                    'retry_count' => fake()->numberBetween(0, 3),
                    'read_at' => fake()->optional(60)->dateTimeBetween('-30 days', 'now'),
                ]);
            }
        }
    }
}
