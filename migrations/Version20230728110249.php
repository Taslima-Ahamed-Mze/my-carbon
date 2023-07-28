<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230728110249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE formation_register_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE cooptation_steps_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE step_cooptation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cooptation_steps (id INT NOT NULL, cooptation_id INT NOT NULL, step_cooptation_id INT NOT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EED79089CA700D5 ON cooptation_steps (cooptation_id)');
        $this->addSql('CREATE INDEX IDX_EED790896441DCDA ON cooptation_steps (step_cooptation_id)');
        $this->addSql('CREATE INDEX IDX_EED79089DE12AB56 ON cooptation_steps (created_by)');
        $this->addSql('CREATE INDEX IDX_EED7908916FE72E1 ON cooptation_steps (updated_by)');
        $this->addSql('CREATE TABLE step_cooptation (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE cooptation_steps ADD CONSTRAINT FK_EED79089CA700D5 FOREIGN KEY (cooptation_id) REFERENCES cooptation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation_steps ADD CONSTRAINT FK_EED790896441DCDA FOREIGN KEY (step_cooptation_id) REFERENCES step_cooptation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation_steps ADD CONSTRAINT FK_EED79089DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation_steps ADD CONSTRAINT FK_EED7908916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation ALTER status DROP NOT NULL');
        $this->addSql('ALTER TABLE event RENAME COLUMN image_url TO image_name');
        $this->addSql('ALTER TABLE formation ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE formation DROP image_url');
        $this->addSql('ALTER TABLE formation_register DROP CONSTRAINT formation_register_pkey');
        $this->addSql('ALTER TABLE formation_register DROP id');
        $this->addSql('ALTER TABLE formation_register ALTER collaborator_id SET NOT NULL');
        $this->addSql('ALTER TABLE formation_register ALTER formation_id SET NOT NULL');
        $this->addSql('ALTER TABLE formation_register ADD PRIMARY KEY (collaborator_id, formation_id)');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT fk_9f2a6419de12ab56');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT fk_9f2a641916fe72e1');
        $this->addSql('DROP INDEX idx_9f2a641916fe72e1');
        $this->addSql('DROP INDEX idx_9f2a6419de12ab56');
        $this->addSql('ALTER TABLE levels DROP created_by');
        $this->addSql('ALTER TABLE levels DROP updated_by');
        $this->addSql('ALTER TABLE levels DROP created_at');
        $this->addSql('ALTER TABLE levels DROP updated_at');
        $this->addSql('ALTER TABLE "user" ADD points INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cooptation_steps_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE step_cooptation_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE formation_register_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE cooptation_steps DROP CONSTRAINT FK_EED79089CA700D5');
        $this->addSql('ALTER TABLE cooptation_steps DROP CONSTRAINT FK_EED790896441DCDA');
        $this->addSql('ALTER TABLE cooptation_steps DROP CONSTRAINT FK_EED79089DE12AB56');
        $this->addSql('ALTER TABLE cooptation_steps DROP CONSTRAINT FK_EED7908916FE72E1');
        $this->addSql('DROP TABLE cooptation_steps');
        $this->addSql('DROP TABLE step_cooptation');
        $this->addSql('ALTER TABLE event RENAME COLUMN image_name TO image_url');
        $this->addSql('ALTER TABLE levels ADD created_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE levels ADD updated_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE levels ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE levels ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT fk_9f2a6419de12ab56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT fk_9f2a641916fe72e1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9f2a641916fe72e1 ON levels (updated_by)');
        $this->addSql('CREATE INDEX idx_9f2a6419de12ab56 ON levels (created_by)');
        $this->addSql('ALTER TABLE cooptation ALTER status SET NOT NULL');
        $this->addSql('DROP INDEX formation_register_pkey');
        $this->addSql('ALTER TABLE formation_register ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE formation_register ALTER collaborator_id DROP NOT NULL');
        $this->addSql('ALTER TABLE formation_register ALTER formation_id DROP NOT NULL');
        $this->addSql('ALTER TABLE formation_register ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE formation ADD image_url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formation DROP image_name');
        $this->addSql('ALTER TABLE "user" DROP points');
    }
}
