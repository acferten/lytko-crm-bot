<?php

namespace Domain\Order\Enums;

enum OrderStatusEnum: string
{
    case new = 'Новый';
    case underAssembly = 'На сборке';
    case assembled = 'Собран';
    case sent = 'Отправлен';
    case delay = 'Задержка';
    case completed = 'Выполнен';
}
