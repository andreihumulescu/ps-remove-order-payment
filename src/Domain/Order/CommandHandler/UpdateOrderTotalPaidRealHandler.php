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
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class UpdateOrderTotalPaidRealHandler
{
    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

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
        if ($paymentCurrencyId === $orderCurrencyId) {
            return $this->round($amount);
        }

        $orderCurrency = new \Currency($orderCurrencyId);

        if (!\Validate::isLoadedObject($orderCurrency)) {
            throw new CannotUpdateOrderTotalPaidRealException(sprintf('Order currency "%d" not found.', $orderCurrencyId));
        }

        $defaultCurrencyId = (int) \Currency::getDefaultCurrencyId();

        if ($paymentCurrencyId === $defaultCurrencyId) {
            return $this->round(
                \Tools::convertPrice($amount, $orderCurrency, false)
            );
        }

        $paymentCurrency = new \Currency($paymentCurrencyId);

        if (!\Validate::isLoadedObject($paymentCurrency)) {
            throw new CannotUpdateOrderTotalPaidRealException(sprintf('Payment currency "%d" not found.', $paymentCurrencyId));
        }

        $amountInDefault = \Tools::convertPrice($amount, $paymentCurrency, false);

        return $this->round(
            \Tools::convertPrice($amountInDefault, $orderCurrency, true)
        );
    }

    /**
     * Round the value based on PS_PRICE_DISPLAY_PRECISION configuration.
     *
     * @param float $value
     *
     * @return float
     */
    private function round(float $value): float
    {
        $precision = (int) $this->configuration->get('PS_PRICE_DISPLAY_PRECISION');

        return round($value, $precision);
    }
}
