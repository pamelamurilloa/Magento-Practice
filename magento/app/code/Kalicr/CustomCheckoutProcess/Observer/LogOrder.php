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
            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = [
                    'sku'   => $item->getSku(),
                    'price' => strip_tags($order->formatPrice($item->getPrice())), //the logs kept printing with a span because of the price format, but at the same time it didnt make the order without it so this was the solution
                    'qty'   => (int)$item->getQtyOrdered()
                ];
            }

            $logData = [
                $order->getIncrementId() => [
                    'customer_email' => $order->getCustomerEmail(),
                    'total_tax'      => strip_tags($order->formatPrice($order->getTaxAmount())),
                    'items'          => $items
                ]
            ];

            $this->logger->info(json_encode($logData, JSON_PRETTY_PRINT));
        }
    }
}