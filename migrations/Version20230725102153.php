<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725102153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE levels_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_levels_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE levels (id INT NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D5311670DE12AB56 ON skills (created_by)');
        $this->addSql('CREATE INDEX IDX_D531167016FE72E1 ON skills (updated_by)');
        $this->addSql('COMMENT ON COLUMN skills.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN skills.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE skills_levels (id INT NOT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2356AAA5585C142 ON skills_levels (skill_id)');
        $this->addSql('CREATE INDEX IDX_D2356AAA5FB14BA7 ON skills_levels (level_id)');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(30) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(20) NOT NULL, firstname VARCHAR(20) NOT NULL, token VARCHAR(255) NOT NULL, email_verify BOOLEAN NOT NULL, sent_email_counter INT NOT NULL, is_verified BOOLEAN NOT NULL, company_name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, siret_number VARCHAR(255) DEFAULT NULL, tva_number VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D531167016FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_levels ADD CONSTRAINT FK_D2356AAA5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_levels ADD CONSTRAINT FK_D2356AAA5FB14BA7 FOREIGN KEY (level_id) REFERENCES levels (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE levels_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_levels_id_seq CASCADE');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D5311670DE12AB56');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D531167016FE72E1');
        $this->addSql('ALTER TABLE skills_levels DROP CONSTRAINT FK_D2356AAA5585C142');
        $this->addSql('ALTER TABLE skills_levels DROP CONSTRAINT FK_D2356AAA5FB14BA7');
        $this->addSql('DROP TABLE levels');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE skills_levels');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
