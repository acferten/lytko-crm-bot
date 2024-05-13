<?php

namespace Domain\Order\Enums;

enum OrderStatusEnum: string
{
    case new = 'Новый';
    case approved = 'Подтвержден';
    case preorder = 'На удержании (предзаказ)';
    case legalEntity = 'На удержании (юридическое лицо)';

    case pending = 'Ожидает сборки';
    case delivery = 'Передача в службу доставки';
    case underAssembly = 'На сборке';
    case assembled = 'Собран';
    case sent = 'Отправлен';
    case delay = 'Задержка';
    case completed = 'Выполнен';
}
