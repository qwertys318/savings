<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412152035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rate_provider (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, class VARCHAR(128) NOT NULL, created_ts DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asset ADD rate_provider_id BIGINT DEFAULT NULL, ADD rate_provider_params LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE asset ADD CONSTRAINT FK_2AF5A5C809CCA0C FOREIGN KEY (rate_provider_id) REFERENCES rate_provider (id)');
        $this->addSql('CREATE INDEX IDX_2AF5A5C809CCA0C ON asset (rate_provider_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset DROP FOREIGN KEY FK_2AF5A5C809CCA0C');
        $this->addSql('DROP TABLE rate_provider');
        $this->addSql('DROP INDEX IDX_2AF5A5C809CCA0C ON asset');
        $this->addSql('ALTER TABLE asset DROP rate_provider_id, DROP rate_provider_params');
    }
}
