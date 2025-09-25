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
 * @copyright Since 2025 Andrei H
 * @license   MIT
 */

namespace PrestaShop\Module\RemoveOrderPayment\Service;

use PrestaShop\PrestaShop\Adapter\LegacyContext;

if (!defined('_PS_VERSION_')) {
    exit;
}

class DateFormatService
{
    private string $dateFormatFull;

    /**
     * @param string $dateFormatFull
     */
    public function __construct(string $dateFormatFull)
    {
        $this->dateFormatFull = $dateFormatFull;
    }

    /**
     * Get the formatted date based on the admin's current date format.
     *
     * @param string $date
     *
     * @return string
     */
    public function formatDate(string $date): string
    {
        $dateTime = \DateTime::createFromFormat($this->dateFormatFull, $date);

        if ($dateTime === false) {
            $dateTime = new \DateTime($date);
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
