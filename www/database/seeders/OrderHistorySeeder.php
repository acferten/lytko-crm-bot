<?php

namespace Database\Seeders;

use Domain\Order\Models\OrderHistory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrderHistorySeeder extends Seeder
{
    public function run(): void
    {
        OrderHistory::factory()
            ->count(4)
            ->state(new Sequence(
                ['name' => 'Брак', 'slug' => 'defective'],
                ['name' => 'Замена', 'slug' => 'replacement'],
                ['name' => 'Возврат', 'slug' => 'refund'],
                ['name' => 'Ошибка', 'slug' => 'error'],
            ))
            ->create();
    }
}
