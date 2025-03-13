<?php
namespace CustomerCompany\Extension\Content\Customers;

use Shopware\Core\Checkout\Customer\CustomerDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use CustomerCompany\Custom\CustomerCompanyDefinition;

class CustomerCompanyExtension extends EntityExtension
{
	public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            (new FkField('company_id', 'companyId', CustomerCompanyDefinition::class))
        );
        $collection->add(
            (new ManyToOneAssociationField(
                'company',
                'company_id',
                CustomerCompanyDefinition::class,
                'id'
            ))
        );
    }

    public function getDefinitionClass(): string
    {
        return CustomerDefinition::class;
    }
}