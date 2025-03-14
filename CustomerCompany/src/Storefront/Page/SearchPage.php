<?php declare(strict_types=1);
namespace CustomerCompany\Storefront\Page;

use Shopware\Storefront\Page\Page;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

class SearchPage extends Page
{
    protected $customersResult;

    protected $responseData = [];

    public function getCustomersResult() : EntityCollection
    {
        return $this->customersResult;
    }

    public function setCustomersResult(EntityCollection $customersResultSet): void
    {
        $this->customersResult = $customersResultSet;
    }

    public function getResponseData() : array
    {
        return $this->responseData;
    }

    public function setResponseData(array $responseData) : void
    {
        $this->responseData = $responseData;
    }
}