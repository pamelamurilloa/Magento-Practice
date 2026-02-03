<?php
namespace Kalicr\CustomCheckoutProcess\Plugin\Checkout;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Psr\Log\LoggerInterface;

class SaveCedula
{
    protected $customerRepository;
    protected $customerSession;
    protected $logger;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        Session $customerSession,
        LoggerInterface $logger
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Api\ShippingInformationManagementInterface $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $this->logger->info("--- Attempting to save Cédula...");

        // 1. Check Login Status
        if (!$this->customerSession->isLoggedIn()) {
            $this->logger->info("--- Customer not logged in, skipping Cédula save.");
            return [$cartId, $addressInformation];
        }

        $this->logger->info("--- Customer is logged in, proceeding to save Cédula.");
        
        // 2. Extract Data
        $extAttributes = $addressInformation->getShippingAddress()->getExtensionAttributes();
        $cedulaValue = null;

        if ($extAttributes && method_exists($extAttributes, 'getCedula')) {
            $cedulaValue = $extAttributes->getCedula();
        }
        
        $this->logger->info("--- Retrieved Cédula value: " . var_export($cedulaValue, true));

        // 3. Save Logic
        if ($cedulaValue) {
            try {
                $customerId = $this->customerSession->getCustomerId();
                $customer = $this->customerRepository->getById($customerId);
                
                $this->logger->info("--- Loaded Customer ID: " . $customerId);
                
                $customer->setCustomAttribute('cedula', $cedulaValue);
                $this->customerRepository->save($customer);
                
                $this->logger->info("--- SUCCESS! Saved $cedulaValue to Customer ID $customerId");
            } catch (\Exception $e) {
                $this->logger->error("--- ERROR SAVING CEDULA: " . $e->getMessage());
            }
        } else {
            $this->logger->info("--- No Cédula value found in extension attributes.");
        }

        return [$cartId, $addressInformation];
    }
}