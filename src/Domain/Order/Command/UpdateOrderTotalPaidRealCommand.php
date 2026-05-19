<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT Free License
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/license/mit
 *
 * @author    Andrei H
 * @copyright Since 2024 Andrei H
 * @license   MIT
 */

declare(strict_types=1);

namespace PrestaShop\Module\RemoveOrderPayment\Domain\Order\Command;

use PrestaShop\PrestaShop\Core\Domain\Order\ValueObject\OrderId;

if (!defined('_PS_VERSION_')) {
    exit;
}

class UpdateOrderTotalPaidRealCommand
{
    /**
     * @var OrderId
     */
    private $orderId;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var int
     */
    private $currencyId;

    /**
     * @param int $orderId
     * @param float $amount
     * @param int $currencyId
     */
    public function __construct(int $orderId, float $amount, int $currencyId)
    {
        $this->orderId = new OrderId($orderId);
        $this->amount = $amount;
        $this->currencyId = $currencyId;
    }

    /**
     * @return OrderId
     */
    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }
}
