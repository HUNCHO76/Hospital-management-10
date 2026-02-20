<?php

namespace Database\Seeders;

use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\LabTest;
use App\Models\User;
use Illuminate\Database\Seeder;

class LabOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $tests = LabTest::where('is_active', true)->get();

        if ($tests->isEmpty()) {
            return;
        }

        $labUsers = User::whereIn('Role', ['Lab Technician', 'lab technician', 'lab_technician'])->pluck('id');

        LabOrder::with('items')->chunk(100, function ($orders) use ($tests, $labUsers) {
            foreach ($orders as $order) {
                if ($order->items->isNotEmpty()) {
                    continue;
                }

                $selectedTests = $tests->random(min(fake()->numberBetween(1, 4), $tests->count()));
                if (!($selectedTests instanceof \Illuminate\Support\Collection)) {
                    $selectedTests = collect([$selectedTests]);
                }

                foreach ($selectedTests as $test) {
                    $isCompleted = $order->status === 'completed';
                    [$resultValue, $resultText] = $isCompleted
                        ? $this->generateResultForTest($test->reference_range)
                        : [null, null];

                    LabOrderItem::create([
                        'lab_order_id' => $order->id,
                        'lab_test_id' => $test->id,
                        'result_value' => $resultValue,
                        'result_text' => $resultText,
                        'status' => $isCompleted ? 'completed' : 'pending',
                        'entered_by' => $isCompleted && $labUsers->isNotEmpty() ? $labUsers->random() : null,
                        'entered_at' => $isCompleted
                            ? fake()->dateTimeBetween($order->order_date ?? '-30 days', 'now')
                            : null,
                        'notes' => fake()->boolean(25) ? fake()->sentence() : null,
                    ]);
                }
            }
        });
    }

    private function generateResultForTest(?string $referenceRange): array
    {
        $cleanRange = trim((string) $referenceRange);

        if (preg_match('/^(-?\d+(?:\.\d+)?)\s*[-–]\s*(-?\d+(?:\.\d+)?)$/', $cleanRange, $matches)) {
            $min = (float) $matches[1];
            $max = (float) $matches[2];
            $normal = fake()->boolean(75);

            if ($normal) {
                $value = fake()->randomFloat(1, $min, $max);
            } else {
                $value = fake()->boolean()
                    ? fake()->randomFloat(1, max(0, $min - 25), $min - 0.1)
                    : fake()->randomFloat(1, $max + 0.1, $max + 25);
            }

            return [(string) $value, fake()->boolean(35) ? fake()->sentence() : null];
        }

        if (preg_match('/^<\s*(-?\d+(?:\.\d+)?)$/', $cleanRange, $matches)) {
            $limit = (float) $matches[1];
            $normal = fake()->boolean(75);
            $value = $normal
                ? fake()->randomFloat(1, max(0, $limit - 30), max(0.1, $limit - 0.1))
                : fake()->randomFloat(1, $limit + 0.1, $limit + 25);

            return [(string) $value, fake()->boolean(35) ? fake()->sentence() : null];
        }

        if (preg_match('/^>\s*(-?\d+(?:\.\d+)?)$/', $cleanRange, $matches)) {
            $limit = (float) $matches[1];
            $normal = fake()->boolean(75);
            $value = $normal
                ? fake()->randomFloat(1, $limit + 0.1, $limit + 30)
                : fake()->randomFloat(1, max(0, $limit - 30), max(0.1, $limit - 0.1));

            return [(string) $value, fake()->boolean(35) ? fake()->sentence() : null];
        }

        return [fake()->randomElement(['Normal', 'Reactive', 'Non-reactive', 'Trace']), fake()->sentence()];
    }
}
