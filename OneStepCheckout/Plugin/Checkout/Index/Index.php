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

namespace Dotsquares\OneStepCheckout\Plugin\Checkout\Index;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Checkout\Controller\Index\Index as CheckoutIndex;
use Dotsquares\OneStepCheckout\Helper\Data;
use Magento\Framework\UrlInterface;

/**
 * Class Index
 *
 * @package Dotsquares\OneStepCheckout\Plugin\Checkout\Index
 */
class Index
{
    /**
     * @var RedirectFactory
     */
    private $resultRedirectFactory;

    /**
     *
     * @var Data
     */
    private $configHelper;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param RedirectFactory $resultRedirectFactory
     * @param Data $configHelper
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        RedirectFactory $resultRedirectFactory,
        Data $configHelper,
        UrlInterface $urlBuilder
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->configHelper = $configHelper;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param CheckoutIndex $subject
     * @param callable $proceed
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(
        CheckoutIndex $subject,
        $proceed
    ) {
        if ($this->configHelper->isEnabled()) {
            $url = trim($this->urlBuilder->getUrl('onestepcheckout'), '/');
            return $this->resultRedirectFactory->create()->setUrl($url);
        } else {
            return $proceed();
        }
    }
}
