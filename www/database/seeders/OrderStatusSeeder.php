<?php

namespace Database\Seeders;

use Domain\Order\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        OrderStatus::factory()
            ->count(17)
            ->state(new Sequence(
                ['name' => 'Новый', 'slug' => 'new'],
                ['name' => 'Подтвержден', 'slug' => 'approved'],
                ['name' => 'На удержании (предзаказ)', 'slug' => 'preorder'],
                ['name' => 'На удержании (юридическое лицо)', 'slug' => 'legalEntity'],
                ['name' => 'Ожидает сборки', 'slug' => 'pending'],
                ['name' => 'Передача в службу доставки', 'slug' => 'delivery'],
                ['name' => 'На сборке', 'slug' => 'underAssembly'],
                ['name' => 'Собран', 'slug' => 'assembled'],
                ['name' => 'Отправлен', 'slug' => 'sent'],
                ['name' => 'Задержка', 'slug' => 'delay'],
                ['name' => 'Выполнен', 'slug' => 'completed'],
                ['name' => 'Обрабатывается', 'slug' => 'processing'],
                ['name' => 'На удержании', 'slug' => 'onHold'],
                ['name' => 'Ожидает отгрузки', 'slug' => 'awaiting'],
                ['name' => 'Отменен', 'slug' => 'cancelled'],
                ['name' => 'Доставляется', 'slug' => 'delivering'],
                ['name' => 'Возвращен', 'slug' => 'refunded'],
            ))
            ->create();
    }
}
