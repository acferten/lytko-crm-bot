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
            ->count(16)
            ->state(new Sequence(
            // Default WooCommerce statuses
                ['name' => 'Новый', 'slug' => 'new', 'wordpress_slug' => 'pending'],
                ['name' => 'Отменен', 'slug' => 'cancelled', 'wordpress_slug' => 'cancelled'],
                ['name' => 'Выполнен', 'slug' => 'completed', 'wordpress_slug' => 'completed'],
                ['name' => 'Обрабатывается', 'slug' => 'processing', 'wordpress_slug' => 'processing'],
                ['name' => 'На удержании', 'slug' => 'onHold', 'wordpress_slug' => 'on-hold'],
                ['name' => 'Возврат', 'slug' => 'refunded', 'wordpress_slug' => 'refunded'],
                ['name' => 'В пути', 'slug' => 'delivering', 'wordpress_slug' => 'delivering'],
                ['name' => 'Ошибка', 'slug' => 'failed', 'wordpress_slug' => 'failed'],

                // Custom
                ['name' => 'Подтвержден', 'slug' => 'approved', 'wordpress_slug' => 'seaxbumb3e'],
                ['name' => 'Ожидает сборки', 'slug' => 'awaitingAssembly', 'wordpress_slug' => 'xybbcm2838'],
                ['name' => 'Ожидает отгрузки', 'slug' => 'awaitingShipment', 'wordpress_slug' => 'ojidaet-otgruzki'],
                ['name' => 'Передача в службу доставки', 'slug' => 'transferToDelivery', 'wordpress_slug' => 'n-a'],
                ['name' => 'Доставляется', 'slug' => 'sent', 'wordpress_slug' => 'm3woh0t1wn'],
                ['name' => 'На удержании (предзаказ)', 'slug' => 'preorder', 'wordpress_slug' => 'u8um1phhjs'],
                ['name' => 'На удержании (юр.лицо)', 'slug' => 'legalEntity', 'wordpress_slug' => 'heceq'],
                ['name' => 'Получен', 'slug' => 'received', 'wordpress_slug' => 'poluchen'],
            ))
            ->create();
    }
}
