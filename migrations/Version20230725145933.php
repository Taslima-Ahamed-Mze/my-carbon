<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725145933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contracts_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cooptation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_register_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE levels_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE skills_levels_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE types_events_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_skills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contracts (id INT NOT NULL, offer_id INT DEFAULT NULL, collaborator_id UUID DEFAULT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_950A97353C674EE ON contracts (offer_id)');
        $this->addSql('CREATE INDEX IDX_950A97330098C8C ON contracts (collaborator_id)');
        $this->addSql('CREATE INDEX IDX_950A973DE12AB56 ON contracts (created_by)');
        $this->addSql('CREATE INDEX IDX_950A97316FE72E1 ON contracts (updated_by)');
        $this->addSql('COMMENT ON COLUMN contracts.collaborator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contracts.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contracts.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE cooptation (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cv_path VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60F61635DE12AB56 ON cooptation (created_by)');
        $this->addSql('CREATE INDEX IDX_60F6163516FE72E1 ON cooptation (updated_by)');
        $this->addSql('COMMENT ON COLUMN cooptation.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN cooptation.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7DE12AB56 ON event (created_by)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA716FE72E1 ON event (updated_by)');
        $this->addSql('COMMENT ON COLUMN event.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE event_register (id INT NOT NULL, collaborator_id UUID DEFAULT NULL, event_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1915A9C430098C8C ON event_register (collaborator_id)');
        $this->addSql('CREATE INDEX IDX_1915A9C471F7E88B ON event_register (event_id)');
        $this->addSql('COMMENT ON COLUMN event_register.collaborator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE levels (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, level VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F2A6419DE12AB56 ON levels (created_by)');
        $this->addSql('CREATE INDEX IDX_9F2A641916FE72E1 ON levels (updated_by)');
        $this->addSql('COMMENT ON COLUMN levels.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN levels.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE offers (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA460427DE12AB56 ON offers (created_by)');
        $this->addSql('CREATE INDEX IDX_DA46042716FE72E1 ON offers (updated_by)');
        $this->addSql('COMMENT ON COLUMN offers.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN offers.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE profile (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skills (id INT NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D5311670DE12AB56 ON skills (created_by)');
        $this->addSql('CREATE INDEX IDX_D531167016FE72E1 ON skills (updated_by)');
        $this->addSql('COMMENT ON COLUMN skills.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN skills.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE skills_levels (id INT NOT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D2356AAA5585C142 ON skills_levels (skill_id)');
        $this->addSql('CREATE INDEX IDX_D2356AAA5FB14BA7 ON skills_levels (level_id)');
        $this->addSql('CREATE TABLE types_events (id INT NOT NULL, event_id INT DEFAULT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2C4CA82571F7E88B ON types_events (event_id)');
        $this->addSql('CREATE INDEX IDX_2C4CA825DE12AB56 ON types_events (created_by)');
        $this->addSql('CREATE INDEX IDX_2C4CA82516FE72E1 ON types_events (updated_by)');
        $this->addSql('COMMENT ON COLUMN types_events.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN types_events.updated_by IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, profile_id INT NOT NULL, email VARCHAR(30) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(20) NOT NULL, firstname VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649CCFA12B8 ON "user" (profile_id)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_skills (id INT NOT NULL, skill_id INT NOT NULL, level_id INT NOT NULL, collaborator_id UUID NOT NULL, created_by UUID DEFAULT NULL, updated_by UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0630D4D5585C142 ON user_skills (skill_id)');
        $this->addSql('CREATE INDEX IDX_B0630D4D5FB14BA7 ON user_skills (level_id)');
        $this->addSql('CREATE INDEX IDX_B0630D4D30098C8C ON user_skills (collaborator_id)');
        $this->addSql('CREATE INDEX IDX_B0630D4DDE12AB56 ON user_skills (created_by)');
        $this->addSql('CREATE INDEX IDX_B0630D4D16FE72E1 ON user_skills (updated_by)');
        $this->addSql('COMMENT ON COLUMN user_skills.collaborator_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_skills.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_skills.updated_by IS \'(DC2Type:uuid)\'');
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
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A97353C674EE FOREIGN KEY (offer_id) REFERENCES offers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A97330098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A973DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contracts ADD CONSTRAINT FK_950A97316FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation ADD CONSTRAINT FK_60F61635DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cooptation ADD CONSTRAINT FK_60F6163516FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA716FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_register ADD CONSTRAINT FK_1915A9C430098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_register ADD CONSTRAINT FK_1915A9C471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT FK_9F2A6419DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE levels ADD CONSTRAINT FK_9F2A641916FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA460427DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offers ADD CONSTRAINT FK_DA46042716FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D531167016FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_levels ADD CONSTRAINT FK_D2356AAA5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skills_levels ADD CONSTRAINT FK_D2356AAA5FB14BA7 FOREIGN KEY (level_id) REFERENCES levels (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE types_events ADD CONSTRAINT FK_2C4CA82571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE types_events ADD CONSTRAINT FK_2C4CA825DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE types_events ADD CONSTRAINT FK_2C4CA82516FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D5FB14BA7 FOREIGN KEY (level_id) REFERENCES levels (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D30098C8C FOREIGN KEY (collaborator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4DDE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skills ADD CONSTRAINT FK_B0630D4D16FE72E1 FOREIGN KEY (updated_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contracts_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cooptation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_register_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE levels_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE skills_levels_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE types_events_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_skills_id_seq CASCADE');
        $this->addSql('ALTER TABLE contracts DROP CONSTRAINT FK_950A97353C674EE');
        $this->addSql('ALTER TABLE contracts DROP CONSTRAINT FK_950A97330098C8C');
        $this->addSql('ALTER TABLE contracts DROP CONSTRAINT FK_950A973DE12AB56');
        $this->addSql('ALTER TABLE contracts DROP CONSTRAINT FK_950A97316FE72E1');
        $this->addSql('ALTER TABLE cooptation DROP CONSTRAINT FK_60F61635DE12AB56');
        $this->addSql('ALTER TABLE cooptation DROP CONSTRAINT FK_60F6163516FE72E1');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7DE12AB56');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA716FE72E1');
        $this->addSql('ALTER TABLE event_register DROP CONSTRAINT FK_1915A9C430098C8C');
        $this->addSql('ALTER TABLE event_register DROP CONSTRAINT FK_1915A9C471F7E88B');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT FK_9F2A6419DE12AB56');
        $this->addSql('ALTER TABLE levels DROP CONSTRAINT FK_9F2A641916FE72E1');
        $this->addSql('ALTER TABLE offers DROP CONSTRAINT FK_DA460427DE12AB56');
        $this->addSql('ALTER TABLE offers DROP CONSTRAINT FK_DA46042716FE72E1');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D5311670DE12AB56');
        $this->addSql('ALTER TABLE skills DROP CONSTRAINT FK_D531167016FE72E1');
        $this->addSql('ALTER TABLE skills_levels DROP CONSTRAINT FK_D2356AAA5585C142');
        $this->addSql('ALTER TABLE skills_levels DROP CONSTRAINT FK_D2356AAA5FB14BA7');
        $this->addSql('ALTER TABLE types_events DROP CONSTRAINT FK_2C4CA82571F7E88B');
        $this->addSql('ALTER TABLE types_events DROP CONSTRAINT FK_2C4CA825DE12AB56');
        $this->addSql('ALTER TABLE types_events DROP CONSTRAINT FK_2C4CA82516FE72E1');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D5585C142');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D5FB14BA7');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D30098C8C');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4DDE12AB56');
        $this->addSql('ALTER TABLE user_skills DROP CONSTRAINT FK_B0630D4D16FE72E1');
        $this->addSql('DROP TABLE contracts');
        $this->addSql('DROP TABLE cooptation');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_register');
        $this->addSql('DROP TABLE levels');
        $this->addSql('DROP TABLE offers');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE skills_levels');
        $this->addSql('DROP TABLE types_events');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_skills');
        $this->addSql('DROP TABLE messenger_messages');
    }
}