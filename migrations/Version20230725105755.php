<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725105755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE levels ADD created_by UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE levels ADD updated_by UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE levels ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE levels ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('COMMENT ON COLUMN levels.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN levels.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT FK_9F2A6419DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT FK_9F2A641916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9F2A6419DE12AB56 ON levels (created_by)');
        $this->addSql('CREATE INDEX IDX_9F2A641916FE72E1 ON levels (updated_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT FK_9F2A6419DE12AB56');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT FK_9F2A641916FE72E1');
        $this->addSql('DROP INDEX IDX_9F2A6419DE12AB56');
        $this->addSql('DROP INDEX IDX_9F2A641916FE72E1');
        $this->addSql('ALTER TABLE levels DROP created_by');
        $this->addSql('ALTER TABLE levels DROP updated_by');
        $this->addSql('ALTER TABLE levels DROP created_at');
        $this->addSql('ALTER TABLE levels DROP updated_at');
    }
}
