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

namespace Dotsquares\OneStepCheckout\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\ResultFactory;
use Dotsquares\OneStepCheckout\Helper\Data;
use Magento\Checkout\Model\Session as SessionModel;
use Magento\Framework\View\Result\PageFactory;
use Magento\Checkout\Controller\Onepage;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Registry;
use Magento\Framework\Translate\InlineInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\View\Result\LayoutFactory as ResultLayout;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Index extends Onepage
{
    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @var ManagerInterface
     */
    protected $_messageManager;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * One step checkout helper
     *
     * @var Data
     */
    private $configHelper;

    /**
     * @param SessionModel $checkoutSession
     * @param PageFactory $resultPageFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $accountManagement
     * @param Registry $coreRegistry
     * @param InlineInterface $translateInline
     */

    public function __construct(
        SessionModel $checkoutSession,
        Session $session,
        ManagerInterface $messageManager,
        ResultFactory $resultFactory,
        Data $configHelper,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $accountManagement,
        Registry $coreRegistry,
        InlineInterface $translateInline,
        Validator $formKeyValidator,
        ScopeConfigInterface $scopeConfig,
        LayoutFactory $layoutFactory,
        CartRepositoryInterface $quoteRepository,
        PageFactory $resultPageFactory,
        ResultLayout $resultLayoutFactory,
        RawFactory $resultRawFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Action\Context $context

    ) {
        $this->checkoutSession = $checkoutSession;
        $this->_customerSession = $session;
        $customerSession = $session;
        $this->_messageManager = $messageManager;
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct(
            $context,
            $customerSession,
            $customerRepository,
            $accountManagement,
            $coreRegistry,
            $translateInline,
            $formKeyValidator,
            $scopeConfig,
            $layoutFactory,
            $quoteRepository,
            $resultPageFactory,
            $resultLayoutFactory,
            $resultRawFactory,
            $resultJsonFactory
        );
    }


    public function execute()
    {
        if (!$this->configHelper->isEnabled()) {
            return $this->resultRedirectFactory->create()->setPath('checkout');
        }
        if (!$this->_customerSession->isLoggedIn() && !$this->configHelper->isGuestCheckout()) {
            $this->_messageManager->addErrorMessage(__('Guest checkout is disabled.'));
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
        $quote = $this->getOnepage()->getQuote();
        if (!$quote->hasItems() || $quote->getHasError() || !$quote->validateMinimumAmount()) {
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
        $currentUrl = $this->_url->getUrl('*/*/*', ['_secure' => true]);
        $this->_customerSession->setBeforeAuthUrl($currentUrl);
        $this->_customerSession->regenerateId();

        $this->checkoutSession->setCartWasUpdated(false);
        //$this->getOnepage()->initCheckout();
        $resultPage = $this->resultPageFactory->create();
        //$title = trim($this->configHelper->getGeneral('title'));
        $title = __('One Step Checkout');
        // if (!$title || $title == '') {
        // }
        $resultPage->getConfig()->getTitle()->set($title);
        return $resultPage;
    }
}
