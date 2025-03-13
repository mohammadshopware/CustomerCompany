<?php

namespace CustomerCompany\Custom;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class CustomerCompanyCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return CustomerCompanyEntity::class;
    }
}