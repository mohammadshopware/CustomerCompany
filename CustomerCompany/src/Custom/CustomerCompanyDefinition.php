<?php 
namespace CustomerCompany\Custom;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FloatField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Checkout\Customer\CustomerDefinition;

class CustomerCompanyDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'customer_company';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return CustomerCompanyEntity::class;
    }

    public function getCollectionClass(): string
    {
        return CustomerCompanyCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new StringField('company_id', 'companyId'))->addFlags(new Required()),
            (new StringField('company_name', 'companyName'))->addFlags(new Required()),
            (new FloatField('credit_limit', 'creditLimit'))->addFlags(new Required()),
            (new OneToManyAssociationField('customers', CustomerDefinition::class, 'company_id', 'id')),
        ]);
    }
}