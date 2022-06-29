<?php

/**
 * Dotsquares
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * Dotsquares
 *
 * @category   Dotsquares
 * @package    Dotsuqares_OneStepCheckout
 * @author     Dotsquares
 * @copyright  Copyright (c) Dotsuqares
 * @license    Dotsquares
 */

namespace Dotsquares\OneStepCheckout\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\GiftMessage\Helper\Message;

/**
 * Class Config
 *
 * @package Dotsquares\OneStepCheckout\Helper
 */
class Data extends AbstractHelper
{
    const ENABLE                      = 'onestepcheckoutdts/general/enable';
    const ENABLE_ORDER_COMMENT        = 'onestepcheckoutdts/general/enable_order_comment';
    const ENABLE_SUBSCRIBE_NEWSLETTER = 'onestepcheckoutdts/general/enable_subscribe_newsletter';
    const ALLOW_GUEST_CHECKOUT        = 'onestepcheckoutdts/general/allow_guest_checkout';
    const DEFAULT_PAYMENT_METHOD      = 'onestepcheckoutdts/general/default_payment_method';
    const DEFAULT_SHIPPING_METHOD     = 'onestepcheckoutdts/general/default_shipping_method';
    const CUSTOM_CSS                  = 'onestepcheckoutdts/display_setting/css_code';
    const STEP_BGR_COLOR              = 'onestepcheckoutdts/display_setting/step_bgr_color';
    const STEP_NUMBER_COLOR           = 'onestepcheckoutdts/display_setting/step_number_color';
    const DISPLAY_TERM_CONDITION      = 'onestepcheckoutdts/display_setting/display_term_condition';
    const SHOW_HEADER_FOOTER          = 'onestepcheckoutdts/display_setting/show_header_footer';
    const ENABLE_DELIVERY_COMMENT     = 'onestepcheckoutdts/display_setting/enable_delivery_comment';
    const GENERAL_GROUP               = 'onestepcheckoutdts/general/';


    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $priceHelper;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\Pricing\Helper\Data $priceHelper
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param ProductMetadataInterface $productMetadata
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct(
            $context
        );
        $this->priceHelper = $priceHelper;
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @param string $field
     * @return bool
     */
    public function isEnabledordercomment($field, $storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }
        return $this->scopeConfig->isSetFlag(
            self::ENABLE_ORDER_COMMENT . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param string $field
     * @param null|int $storeId
     *
     * @return bool
     */
    public function isEnableNewsletter($field, $storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->isSetFlag(
            self::ENABLE_SUBSCRIBE_NEWSLETTER . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $field
     * @param null $storeId
     * 
     * @return bool
     */
    public function isEnableDeleveryComment($field, $storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->isSetFlag(
            self::ENABLE_DELIVERY_COMMENT . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $field
     * @param null $storeId
     * 
     * @return bool
     */
    public function isEnableHeaderFooter($field, $storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->isSetFlag(
            self::SHOW_HEADER_FOOTER . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $field
     * @param null $storeId
     * @return bool
     */
    public function isEnableTermCondition($field, $storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->isSetFlag(
            self::DISPLAY_TERM_CONDITION . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * 
     * @param null $storeId
     * 
     * @return bool
     */
    public function isGuestCheckout($storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->isSetFlag(
            self::ALLOW_GUEST_CHECKOUT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param string $field
     * @param null|int $storeId
     *
     * @return mixed
     */
    public function getCustomCss($field, $storeId = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->getValue(
            self::CUSTOM_CSS . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null|int $storeId
     *
     * @return bool
     */
    public function isMessagesAllowed($store = null)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        return $this->scopeConfig->isSetFlag(
            Message::XPATH_CONFIG_GIFT_MESSAGE_ALLOW_ORDER,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param null $storeId
     *
     * @return mixed
     */
    public function getDefaultCustomerGroupId($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'customer/create_account/default_group',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }


    /**
     * @param $number
     *
     * @return float|string
     */
    public function formatCurrency($number)
    {
        return $this->priceHelper->currency($number, false, false);
    }

    /**
     * @param null|int $storeId
     *
     * @return mixed
     */
    public function isCustomerDobFieldRequired($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            'customer/address/dob_show',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null|int $storeId
     *
     * @return mixed
     */
    public function isCustomerTaxVatFieldRequired($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            'customer/address/taxvat_show',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null|int $storeId
     *
     * @return mixed
     */
    public function isCustomerGenderFieldRequired($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            'customer/address/gender_show',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     *
     * @return mixed
     */
    public function isMultiShipping($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'multishipping/options/checkout_multiple',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     *
     * @return mixed
     */
    public function getMultiMaximumQty($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'multishipping/options/checkout_multiple_maximum_qty',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
