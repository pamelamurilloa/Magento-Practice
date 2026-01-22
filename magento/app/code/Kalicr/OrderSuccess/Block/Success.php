<?php

namespace Kalicr\OrderSuccess\Block;

class Success extends \Magento\Checkout\Block\Onepage\Success
{
    public function _prepareLayout()
    {
        $this->getLayout()->getBlock('checkout.success')->unsetChild('order.success.additional.info');
        $this->getLayout()->getBlock('checkout.success')->unsetChild('downloadable.checkout.success');
        $this->getLayout()->unsetElement('checkout.success');
        $this->getLayout()->unsetElement('checkout.registration');
    }
}