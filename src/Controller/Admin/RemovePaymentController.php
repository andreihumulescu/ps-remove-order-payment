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

namespace PrestaShop\Module\RemoveOrderPayment\Controller\Admin;

use PrestaShop\Module\RemoveOrderPayment\Entity\Repository\OrderPaymentRepository;
use PrestaShop\Module\RemoveOrderPayment\Service\DateFormatService;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

if (!defined('_PS_VERSION_')) {
    exit;
}

class RemovePaymentController extends FrameworkBundleAdminController
{
    /**
     * @var OrderPaymentRepository
     */
    private $orderPaymentRepository;

    /**
     * @var DateFormatService
     */
    private $dateFormatService;

    /**
     * @param OrderPaymentRepository $orderPaymentRepository
     */
    public function __construct(
        DateFormatService $dateFormatService,
        OrderPaymentRepository $orderPaymentRepository
    ) {
        $this->dateFormatService = $dateFormatService;
        $this->orderPaymentRepository = $orderPaymentRepository;
    }

    /**
     * The order payment delete action.
     *
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller')) || is_granted('update', 'AdminOrders')")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);
            if (empty($content['date_add']) || empty($content['order_reference'])) {
                $data = [
                    'success' => false,
                    'message' => $this->trans('Please provide a Date and/or an Order Reference', 'Modules.Removeorderpayment.Admin'),
                ];

                return $this->json($data, Response::HTTP_BAD_REQUEST);
            }

            $content['date_add'] = $this->dateFormatService->formatDate($content['date_add']);

            $this->orderPaymentRepository->delete($content);

            $data = [
                'success' => true,
                'message' => $this->trans('Order Payment successfully deleted', 'Modules.Removeorderpayment.Admin'),
            ];

            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(
                ['success' => false, 'message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
