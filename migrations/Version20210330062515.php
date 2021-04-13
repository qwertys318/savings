<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330062515 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asset (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, rate NUMERIC(16, 8) NOT NULL, created_ts DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, created_ts DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE saving (id BIGINT AUTO_INCREMENT NOT NULL, asset_id BIGINT DEFAULT NULL, place_id BIGINT DEFAULT NULL, amount NUMERIC(16, 8) NOT NULL, created_ts DATETIME NOT NULL, INDEX IDX_B9DC3D0C5DA1941 (asset_id), INDEX IDX_B9DC3D0CDA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE saving ADD CONSTRAINT FK_B9DC3D0C5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id)');
        $this->addSql('ALTER TABLE saving ADD CONSTRAINT FK_B9DC3D0CDA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saving DROP FOREIGN KEY FK_B9DC3D0C5DA1941');
        $this->addSql('ALTER TABLE saving DROP FOREIGN KEY FK_B9DC3D0CDA6A219');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE saving');
    }
}
