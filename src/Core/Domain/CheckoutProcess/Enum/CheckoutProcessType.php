<?php

declare(strict_types=1);

namespace App\Core\Domain\CheckoutProcess\Enum;

enum CheckoutProcessType: string
{
    case TO_SHOPPING_CART = 'to_shopping_cart';
    case TO_DELIVERY_ADDRESS = 'to_delivery_address';
    case TO_SUMMARY_FOR_PURCHASE = 'to_summary_for_purchase';
    case TO_ORDERED = 'to_ordered';
}