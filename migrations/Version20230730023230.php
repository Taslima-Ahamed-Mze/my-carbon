<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730023230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reward ADD created_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD updated_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reward ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE reward ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED1725316FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4ED17253DE12AB56 ON reward (created_by)');
        $this->addSql('CREATE INDEX IDX_4ED1725316FE72E1 ON reward (updated_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED17253DE12AB56');
        $this->addSql('ALTER TABLE reward DROP CONSTRAINT FK_4ED1725316FE72E1');
        $this->addSql('DROP INDEX IDX_4ED17253DE12AB56');
        $this->addSql('DROP INDEX IDX_4ED1725316FE72E1');
        $this->addSql('ALTER TABLE reward DROP created_by');
        $this->addSql('ALTER TABLE reward DROP updated_by');
        $this->addSql('ALTER TABLE reward DROP created_at');
        $this->addSql('ALTER TABLE reward DROP updated_at');
    }
}
