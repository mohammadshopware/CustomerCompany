<?php declare(strict_types=1);

namespace CustomerCompany\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1741782187CustomerCompany extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1741782187;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `customer_company` (
                `id` BINARY(16) NOT NULL,
                `company_id` VARCHAR(255) NOT NULL,
                `company_name` VARCHAR(255) NOT NULL,
                `credit_limit` FLOAT NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            SQL;

        $connection->executeStatement($sql);

        $addFrKey = <<<SQL
            ALTER TABLE `customer`
            ADD COLUMN `company_id` BINARY(16) NULL,
            ADD CONSTRAINT `fk_customer_company`
                FOREIGN KEY (`company_id`)
                REFERENCES `customer_company` (`id`)
                ON DELETE SET NULL
                ON UPDATE CASCADE;
            SQL;
            
        $connection->executeStatement($addFrKey);

    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
