<?php
namespace Kalicr\CustomCheckoutProcess\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Eav\Api\AttributeRepositoryInterface;

class AddCedulaCustomerAttribute implements DataPatchInterface
{
    private $moduleDataSetup;
    private $customerSetupFactory;
    private $attributeRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }

    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'cedula',
            [
                'type' => 'varchar',
                'label' => 'Cédula',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 100,
                'position' => 100,
                'system' => 0,
                'is_unique' => 0,
                'is_global' => 1,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'cedula');
        $attribute->setData('attribute_set_id', 1);
        $attribute->setData('attribute_group_id', 1);
        $attribute->setData(
            'used_in_forms',
            ['adminhtml_customer', 'customer_account_create', 'customer_account_edit', 'checkout_register']
        );
        $this->attributeRepository->save($attribute);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}