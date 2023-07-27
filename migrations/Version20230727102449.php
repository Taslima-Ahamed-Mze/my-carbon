<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727102449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cooptation_steps ADD created_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cooptation_steps ADD updated_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cooptation_steps ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE cooptation_steps ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE cooptation_steps ADD CONSTRAINT FK_EED79089DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation_steps ADD CONSTRAINT FK_EED7908916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EED79089DE12AB56 ON cooptation_steps (created_by)');
        $this->addSql('CREATE INDEX IDX_EED7908916FE72E1 ON cooptation_steps (updated_by)');
        $this->addSql('ALTER TABLE step_cooptation ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE step_cooptation ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE step_cooptation DROP created_at');
        $this->addSql('ALTER TABLE step_cooptation DROP updated_at');
        $this->addSql('ALTER TABLE cooptation_steps DROP CONSTRAINT FK_EED79089DE12AB56');
        $this->addSql('ALTER TABLE cooptation_steps DROP CONSTRAINT FK_EED7908916FE72E1');
        $this->addSql('DROP INDEX IDX_EED79089DE12AB56');
        $this->addSql('DROP INDEX IDX_EED7908916FE72E1');
        $this->addSql('ALTER TABLE cooptation_steps DROP created_by');
        $this->addSql('ALTER TABLE cooptation_steps DROP updated_by');
        $this->addSql('ALTER TABLE cooptation_steps DROP created_at');
        $this->addSql('ALTER TABLE cooptation_steps DROP updated_at');
    }
}
