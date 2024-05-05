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
$autoloader = dirname(__FILE__) . '/vendor/autoload.php';

if (is_readable($autoloader)) {
    include_once $autoloader;
}

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

if (!defined('_PS_VERSION_')) {
    exit;
}

class RemoveOrderPayment extends Module
{
    private const HOOKS = [
        'actionAdminControllerSetMedia',
    ];

    public function __construct()
    {
        // die('a');

        $this->name = 'removeorderpayment';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Andrei H';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '8.0.0',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Remove Order Payment', [], 'Modules.Removeorderpayment.Admin');
        $this->description = $this->trans('PrestaShop module that enables removing order payments.', [], 'Modules.Removeorderpayment.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Removeorderpayment.Admin');
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install()
            && $this->registerHook(self::HOOKS);
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function hookActionAdminControllerSetMedia()
    {
        if (!Tools::getIsset('controller') || Tools::getValue('controller') !== 'AdminOrders') {
            return;
        }

        Media::addJsDef([
            'removeorderpayment' => [
                'removePaymentController' => $this->getRemovePaymentEndpoint(),
                'removePaymentText' => $this->trans('Are you sure you want to delete this payment?', [], 'Modules.Removeorderpayment.Admin'),
            ],
        ]);

        $this->context->controller->addJS($this->_path . '/views/js/app.bundle.js');
    }

    private function getRemovePaymentEndpoint()
    {
        return SymfonyContainer::getInstance()->get('router')->generate('hmedia_remove_order_payment');
    }
}
