<?php

namespace Kalicr\CustomCheckoutProcess\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Kalicr\CustomCheckoutProcess\Logger\Logger;

class LogOrder implements ObserverInterface
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        if ($order) {
            $logMessage = sprintf(
                "--- NEW ORDER ---\nIncrement ID: %s - Customer Email: %s - Total Tax: %s\n",
                $order->getIncrementId(),
                $order->getCustomerEmail(),
                $order->formatPrice($order->getTaxAmount())
            );

            $logMessage .= "Order items:\n";
            foreach ($order->getAllVisibleItems() as $item) {
                $logMessage .= sprintf(
                    " - SKU: %s - Price: %s - Qty: %s\n",
                    $item->getSku(),
                    $order->formatPrice($item->getPrice()),
                    $item->getQtyOrdered()
                );
            }

            $logMessage .= "-----------------";

            $this->logger->info($logMessage);
        }
    }
}