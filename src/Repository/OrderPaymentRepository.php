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

namespace PrestaShop\Module\RemoveOrderPayment\Repository;

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

        $this->connection->delete(
            $this->orderPaymentTable,
            $orderPaymentData
        );
    }

    /**
     * Get one payment matching the provided data.
     *
     * @param array $orderPaymentData
     * @return array
     */
    public function get(array $orderPaymentData): array
    {
        $orderPaymentData = $this->getAllowedValues($orderPaymentData);

        if (empty($orderPaymentData)) {
            return [];
        }

        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('amount', 'id_currency')
            ->from($this->orderPaymentTable);

        foreach ($orderPaymentData as $key => $value) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq($key, ':' . $key))
                ->setParameter($key, $value);
        }

        $statement = $queryBuilder->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return [];
        }

        return [
            'amount' => (float) $result['amount'],
            'id_currency' => (int) $result['id_currency'],
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
