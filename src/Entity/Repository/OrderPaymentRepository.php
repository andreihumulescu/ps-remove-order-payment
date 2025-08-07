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

namespace PrestaShop\Module\RemoveOrderPayment\Entity\Repository;

use Doctrine\DBAL\Connection;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderPaymentRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string database table name with prefix
     */
    private $orderPaymentTable;

    /**
     * @param Connection $connection
     * @param string $tablePrefix
     */
    public function __construct(Connection $connection, string $tablePrefix)
    {
        $this->connection = $connection;
        $this->orderPaymentTable = $tablePrefix . 'order_payment';
    }

    /**
     * Delete one payment matching the provided data.
     *
     * @param array $orderPaymentData
     */
    public function delete(array $orderPaymentData)
    {
        $orderPaymentData = $this->getAllowedValues($orderPaymentData);
        $deletedRows = $this->connection->delete(
            $this->orderPaymentTable,
            $orderPaymentData
        );

        return [
            'deleted_rows' => $deletedRows,
            'table' => $this->orderPaymentTable,
        ];
    }

    /**
     * Get the allowed values for the delete query.
     *
     * @param array $orderPaymentData
     */
    private function getAllowedValues(array $orderPaymentData)
    {
        $allowedKeys = ['date_add', 'order_reference', 'transaction_id'];

        return array_intersect_key($orderPaymentData, array_flip($allowedKeys));
    }
}
