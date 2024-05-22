<?php

declare(strict_types=1);

namespace App\Core\Domain\Order\Enum;

enum OrderStatusType: string
{
    case STATUS_SHOPPING_CART = 'shopping_cart';

    case STATUS_DELIVERY_ADDRESS = 'delivery_address';

    case STATUS_SUMMARY_FOR_PURCHASE = 'summary_for_purchase';

    case STATUS_ORDERED = 'ordered';
}