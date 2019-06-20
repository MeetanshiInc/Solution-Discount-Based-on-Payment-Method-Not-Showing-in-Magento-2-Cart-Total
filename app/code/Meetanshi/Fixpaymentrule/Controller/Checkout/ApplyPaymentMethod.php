<?php

namespace Meetanshi\Fixpaymentrule\Controller\Checkout;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;

class ApplyPaymentMethod extends Action
{
    protected $resultForwardFactory;
    protected $layoutFactory;
    protected $cart;

    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        LayoutFactory $layoutFactory,
        Cart $cart
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        $this->layoutFactory = $layoutFactory;
        $this->cart = $cart;

        parent::__construct($context);
    }

    public function execute()
    {
        $pMethod = $this->getRequest()->getParam('payment_method');
        $quote = $this->cart->getQuote();
        $quote->getPayment()->setMethod($pMethod['method']);
        $quote->setTotalsCollectedFlag(false);
        $quote->collectTotals();
        $quote->save();
    }
}