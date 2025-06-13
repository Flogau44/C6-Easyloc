<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613155600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, INDEX IDX_EC224CAA2576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, sign_datetime DATETIME NOT NULL, loc_begin_datetime DATETIME NOT NULL, loc_end_datetime DATETIME NOT NULL, returning_datetime DATETIME NOT NULL, price VARCHAR(255) NOT NULL, vehicle_uid VARCHAR(255) NOT NULL, customer_uid VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE billing ADD CONSTRAINT FK_EC224CAA2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAA2576E0FD
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE billing
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE contract
        SQL);
    }
}
