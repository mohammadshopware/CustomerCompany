<?php
namespace CustomerCompany\Custom;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class CustomerCompanyEntity extends Entity
{
    use EntityIdTrait;

    protected string $companyId;
    protected string $companyName;
    protected float $creditLimit;

    public function getCompanyId(): string { 
    	return $this->companyId; 
    }
    
    public function setCompanyId(string $companyId) : void { 
    	$this->companyId = $companyId; 
    }

    public function getCompanyName(): string { 
    	return $this->companyName; 
    }

    public function setCompanyName(string $companyName) : void { 
    	$this->companyName = $companyName; 
    }

    public function getCreditLimit(): float { 
    	return $this->creditLimit; 
    }
    
    public function setCreditLimit(float $creditLimit) : void { 
    	$this->creditLimit = $creditLimit; 
    }
}