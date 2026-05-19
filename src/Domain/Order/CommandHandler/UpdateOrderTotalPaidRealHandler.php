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

namespace PrestaShop\Module\RemoveOrderPayment\Domain\Order\CommandHandler;

use PrestaShop\Module\RemoveOrderPayment\Domain\Order\Command\UpdateOrderTotalPaidRealCommand;
use PrestaShop\Module\RemoveOrderPayment\Domain\Order\Exception\CannotUpdateOrderTotalPaidRealException;

if (!defined('_PS_VERSION_')) {
    exit;
}

class UpdateOrderTotalPaidRealHandler
{
    /**
     * @param UpdateOrderTotalPaidRealCommand $command
     *
     * @throws CannotUpdateOrderTotalPaidRealException
     */
    public function handle(UpdateOrderTotalPaidRealCommand $command): void
    {
        try {
            $orderId = $command->getOrderId()->getValue();

            $order = new \Order($orderId);

            if (!\Validate::isLoadedObject($order)) {
                throw new CannotUpdateOrderTotalPaidRealException(sprintf('Order with id "%d" could not be loaded.', $orderId));
            }

            $amount = $command->getAmount();
            $paymentCurrencyId = $command->getCurrencyId();
            $orderCurrencyId = (int) $order->id_currency;

            $amountToSubtract = $this->computeAmount(
                $amount,
                $paymentCurrencyId,
                $orderCurrencyId
            );

            $order->total_paid_real -= $amountToSubtract;

            if (!$order->update()) {
                throw new CannotUpdateOrderTotalPaidRealException(sprintf('Could not update total_paid_real for order "%d".', $order->id));
            }
        } catch (\Throwable $e) {
            if ($e instanceof CannotUpdateOrderTotalPaidRealException) {
                throw $e;
            }

            throw new CannotUpdateOrderTotalPaidRealException(sprintf('Failed to update total_paid_real for order "%d".', $command->getOrderId()->getValue()), 0, $e);
        }
    }

    /**
     * Compute the amount to subtract from order's total_paid_real, based on payment and order currencies.
     *
     * @param float $amount
     * @param int $paymentCurrencyId
     * @param int $orderCurrencyId
     *
     * @return float
     */
    private function computeAmount(float $amount, int $paymentCurrencyId, int $orderCurrencyId): float
    {
        $orderCurrency = new \Currency($orderCurrencyId);

        if (!\Validate::isLoadedObject($orderCurrency)) {
            throw new CannotUpdateOrderTotalPaidRealException(sprintf('Order currency "%d" not found.', $orderCurrencyId));
        }

        if ($paymentCurrencyId === $orderCurrencyId) {
            return $this->round($amount, $orderCurrency);
        }

        $defaultCurrencyId = (int) \Currency::getDefaultCurrencyId();

        if ($paymentCurrencyId === $defaultCurrencyId) {
            return $this->round(
                \Tools::convertPrice($amount, $orderCurrency, false),
                $orderCurrency
            );
        }

        $paymentCurrency = new \Currency($paymentCurrencyId);

        if (!\Validate::isLoadedObject($paymentCurrency)) {
            throw new CannotUpdateOrderTotalPaidRealException(sprintf('Payment currency "%d" not found.', $paymentCurrencyId));
        }

        $amountInDefault = \Tools::convertPrice($amount, $paymentCurrency, false);

        return $this->round(
            \Tools::convertPrice($amountInDefault, $orderCurrency, true),
            $orderCurrency
        );
    }

    /**
     * Round the value based on the currency's precision.
     *
     * @param float $value
     * @param \Currency $currency
     *
     * @return float
     */
    private function round(float $value, \Currency $currency): float
    {
        return round($value, (int) $currency->precision);
    }
}
