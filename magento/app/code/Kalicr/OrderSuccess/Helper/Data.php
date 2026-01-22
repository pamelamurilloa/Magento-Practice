<?php

namespace Kalicr\OrderSuccess\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    // Correctly declared properties with underscores
    protected $_filterProvider;
    protected $_blockFactory;
    protected $_order;
    protected $_store;
    protected $_currencyInterface;
    protected $_product;
    protected $_country;
    protected $_config;
    protected $_productRepo;
    protected $_serialize;
    protected $_currencyHelper;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Sales\Model\Order $order,
        \Magento\Store\Model\StoreManagerInterface $store,
        \Magento\Framework\Locale\CurrencyInterface $currencyInterface,
        \Magento\Catalog\Model\Product $product,
        \Magento\Directory\Model\Country $country,
        \Magento\Catalog\Model\Product\Media\Config $config,
        \Magento\Catalog\Model\ProductRepository $productRepo,
        \Magento\Framework\Serialize\Serializer\Json $serialize,
        \Magento\Framework\Pricing\Helper\Data $currencyHelper
    ) {
        // Parent construct initializes $this->_scopeConfig automatically
        parent::__construct($context);

        $this->_filterProvider = $filterProvider;
        $this->_blockFactory = $blockFactory;
        $this->_order = $order;
        $this->_store = $store;
        $this->_currencyInterface = $currencyInterface;
        $this->_product = $product;
        $this->_country = $country;
        $this->_config = $config;
        $this->_productRepo = $productRepo;
        $this->_serialize = $serialize;
        $this->_currencyHelper = $currencyHelper;
    }

    public function getConfig($config_path) {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getFilterBlock($content) {
        return $this->_filterProvider->getBlockFilter()->filter($content);
    }

    public function getCMSPageId($cms_bottom_id) {
        return $this->_blockFactory->create()->load($cms_bottom_id);
    }

    // Renamed to match the call in your phtml file
    public function getOrderById($order_id) {
        return $this->_order->loadByIncrementId($order_id);
    }

    public function getCurrencyCode() {
        $currencyCode = $this->_store->getStore()->getBaseCurrencyCode();
        return $this->_currencyInterface->getCurrency($currencyCode)->getSymbol();
    }

    public function getCurrencySymbol($value) {
        return $this->_currencyHelper->currency($value, true, false);
    }

    public function getCountryName($country_id) {
        return $this->_country->loadByCode($country_id)->getName();
    }
    
    // Added helper method for product loading used in phtml
    public function getProductById($id) {
        return $this->_productRepo->getById($id);
    }
}